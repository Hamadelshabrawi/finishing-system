<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductItem;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductItemConsumption;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\ItemConsumptionLog;
use App\Models\ProductItemConsumptionLog;
use App\Models\ItemPurchase;
use App\Models\ProductItemUnitCost;
use App\Services\FIFOStockService;

class ProductItemController extends Controller
{
    private FIFOStockService $fifoStockService;

    public function __construct(FIFOStockService $fifoStockService)
    {
        $this->middleware('can:Products List');
        $this->fifoStockService = $fifoStockService;
    }

    public function index($productId)
    {
        $product = Product::with(['items.item'])->findOrFail($productId);
        $items = Item::all();
        
        return view('products.items.index', compact('product', 'items'));
    }

    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $itemId = $validated['item_id'];
        $item = Item::findOrFail($itemId);
        $requestedQuantity = (int)$validated['quantity'];

        DB::beginTransaction();
        try {
            // Get the product
            $product = Product::findOrFail($productId);

            // Process stock consumption using FIFO
            $result = $this->fifoStockService->processStockConsumption($itemId, $requestedQuantity, $product, $item);
            $totalCost = $result['total_cost'];

            // Check if item already exists in this product
            $existingItem = ProductItem::where('product_id', (int)$productId)
                ->where('item_id', (int)$itemId)
                ->first();

            // Update or create product item
            if ($existingItem) {
                // Calculate new quantities and costs
                $newQuantity = $existingItem->quantity + $requestedQuantity;

                // Update existing item
                $existingItem->update([
                    'quantity' => $newQuantity,
                    'cost' => $existingItem->cost + $totalCost,
                ]);
            } else {
                // Create new product item
                ProductItem::create([
                    'product_id' => (int)$productId,
                    'item_id' => (int)$itemId,
                    'quantity' => $requestedQuantity,
                    'cost' => $totalCost
                ]);
            }
    
            // Update item stock
            $item->decrement('total_stock', $requestedQuantity);
            $item->decrement('total_cost', $totalCost);
    
            DB::commit();
            return redirect()->back()->with('success', 'Item added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    

    public function update(Request $request, $productId, $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $productItem = ProductItem::findOrFail($item);
            $item = $productItem->item;
            $product = $productItem->product;
            $newQuantity = (int)$validated['quantity'];
            $difference = $newQuantity - $productItem->quantity;
            
            // Log initial values
            \Log::info('Update Calculation Start');
            \Log::info('Current values:');
            \Log::info("Current Quantity: {$productItem->quantity}");
            \Log::info("Current Cost: {$productItem->cost}");
            \Log::info("Current Unit Cost: {$productItem->unit_cost}");
            \Log::info("New Quantity: {$newQuantity}");
            \Log::info("Difference: {$difference}");
            if ($difference > 0) {
                \Log::info('Adding units scenario');
                \Log::info("Adding: {$difference} units");
                
                $result = $this->fifoStockService->processStockConsumption($item->id, abs($difference), $product, $item);
                $totalCost = $result['total_cost'];
                \Log::info("Total cost for new units: {$totalCost}");
                
                $item->decrement('total_stock', abs($difference));
                $item->decrement('total_cost', $totalCost);
                
                ItemConsumptionLog::create([
                    'item_purchase_id' => null,
                    'quantity' => abs($difference),
                    'unit_price' => $totalCost / abs($difference),
                    'total_cost' => $totalCost,
                    'product_id' => $productId,
                    'item_id' => $item->id,
                    'unit_cost' => $totalCost / abs($difference),
                    'notes' => "Added {$difference} units to product: {$product->name}"
                ]);

                // Calculate new values
                $newCost = $productItem->cost + $totalCost;
                $newUnitCost = $newCost / $newQuantity;
                
                \Log::info('New calculated values:');
                \Log::info("New Cost: {$newCost}");
                \Log::info("New Unit Cost: {$newUnitCost}");
                
                $productItem->update([
                    'quantity' => $newQuantity,
                    'cost' => $newCost,
                    'unit_cost' => $newUnitCost
                ]);
            } else if ($difference < 0) {
                \Log::info('Removing units scenario');
                \Log::info("Removing: {$difference} units");
                
                $this->fifoStockService->returnStock($item->id, abs($difference));
                $item->increment('total_stock', abs($difference));
                
                // Calculate cost of removed units
                $removedUnitCost = $productItem->cost / $productItem->quantity;
                $removedTotalCost = abs($difference) * $removedUnitCost;
                
                \Log::info('Calculating removed cost:');
                \Log::info("Unit cost before removal: {$removedUnitCost}");
                \Log::info("Total cost of removed units: {$removedTotalCost}");
                
                $item->increment('total_cost', $removedTotalCost);
                
                ItemConsumptionLog::create([
                    'item_purchase_id' => null,
                    'quantity' => abs($difference),
                    'unit_price' => $removedUnitCost,
                    'total_cost' => $removedTotalCost,
                    'product_id' => $productId,
                    'item_id' => $item->id,
                    'unit_cost' => $removedUnitCost,
                    'notes' => "Removed {$difference} units from product: {$product->name}"
                ]);

                // Calculate new values
                $remainingCost = $productItem->cost - $removedTotalCost;
                $newUnitCost = $remainingCost / $newQuantity;
                
                \Log::info('New calculated values:');
                \Log::info("Remaining Cost: {$remainingCost}");
                \Log::info("New Unit Cost: {$newUnitCost}");
                
                $productItem->update([
                    'quantity' => $newQuantity,
                    'cost' => $remainingCost,
                    'unit_cost' => $newUnitCost
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Item updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function destroy($productId, $item)
    {
        DB::beginTransaction();
        try {
            $productItem = ProductItem::where('product_id', (int)$productId)
                ->where('item_id', (int)$item)
                ->firstOrFail();
            $item = $productItem->item;
            $purchases = ItemPurchase::where('item_id', $item->id)
                ->orderBy('purchase_date')
                ->get();
            $remainingQuantity = $productItem->quantity;
            foreach ($purchases as $purchase) {
                if ($remainingQuantity <= 0) break;
                $toReturn = min($remainingQuantity, $purchase->quantity - $purchase->remaining_quantity);
                if ($toReturn > 0) {
                    ItemPurchase::where('id', $purchase->id)
                        ->increment('remaining_quantity', $toReturn);
                    $remainingQuantity -= $toReturn;
                }
            }
            ItemConsumptionLog::create([
                'item_purchase_id' => null,
                'quantity' => $productItem->quantity,
                'unit_price' => $productItem->cost / $productItem->quantity,
                'total_cost' => $productItem->cost,
                'product_id' => $productId,
                'item_id' => $item->id,
                'unit_cost' => $productItem->cost / $productItem->quantity,
                'notes' => "Item removed from product. Stock returned to inventory."
            ]);

            // Update item stock
            $item->increment('total_stock', $productItem->quantity);
            $item->increment('total_cost', $productItem->cost);

            // Delete the product item
            $productItem->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Item removed from product successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}