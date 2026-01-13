<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Item;
use App\Models\ItemPurchase;
use App\Models\ProductItem;

class ProductItemConsumptionController extends Controller
{
    public function create(Product $product)
    {
        $items = Item::orderBy('name')->get();
        return view('product_item_consumptions.create', compact('product', 'items'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
    
        $item = Item::findOrFail($validated['item_id']);
        $requiredQuantity = $validated['quantity'];
    
        // Get available purchases (FIFO)
        $purchases = $item->purchases()
            ->where('remaining_quantity', '>', 0)
            ->orderBy('purchase_date')
            ->get();
    
        // Step 1: Check if total available is enough
        $availableQuantity = $purchases->sum('remaining_quantity');
    
        if ($availableQuantity < $requiredQuantity) {
            return back()->withErrors([
                'quantity' => 'Not enough stock to consume requested quantity. ' .
                    'Available: ' . $availableQuantity . ' / Requested: ' . $requiredQuantity
            ]);
        }
    
        // Step 2: Proceed to consume now that we know it's safe
        $remaining = $requiredQuantity;
        $totalCost = 0;
        $consumptionDetails = [];
    
        foreach ($purchases as $purchase) {
            if ($remaining <= 0) break;
    
            $available = $purchase->remaining_quantity;
            $deduct = min($remaining, $available);
    
            $purchase->remaining_quantity -= $deduct;
            $purchase->save();
    
            $totalCost += $deduct * $purchase->purchase_price;
    
            $consumptionDetails[] = [
                'purchase_date' => $purchase->purchase_date,
                'purchase_price' => $purchase->purchase_price,
                'quantity' => $deduct,
                'total_cost' => $deduct * $purchase->purchase_price
            ];
    
            $remaining -= $deduct;
        }
    
        // Update item stock
        $item->decrement('total_stock', $requiredQuantity);
        $item->decrement('total_quantity', $requiredQuantity);
        $item->decrement('total_cost', $totalCost);
    
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }
    
        // Update or create product item
        $productItem = $product->items()->where('item_id', $item->id)->first();
    
        if ($productItem) {
            $productItem->quantity += $requiredQuantity;
            $productItem->cost += $totalCost;
            $productItem->unit_cost = $productItem->cost / $productItem->quantity;
            $productItem->save();
        } else {
            $product->items()->create([
                'item_id' => $item->id,
                'quantity' => $requiredQuantity,
                'cost' => $totalCost,
                'unit_cost' => $totalCost / $requiredQuantity,
                'product_id' => $product->id
            ]);
        }
    
        $product->consumptions()->create([
            'item_id' => $item->id,
            'quantity' => $requiredQuantity,
            'unit_price' => $totalCost / $requiredQuantity,
            'total_price' => $totalCost,
            'notes' => $validated['notes'] ?? null,
            'details' => json_encode($consumptionDetails)
        ]);
    
        $this->updateProductCost($product);
    
        return redirect()->route('products.show', $product)
            ->with('success', 'Successfully consumed ' . $requiredQuantity . ' units of ' . $item->name);
    }
    
    private function updateProductCost(Product $product)
    {
        $totalCost = 0;
        $totalQuantity = 0;

        foreach ($product->items as $productItem) {
            $totalCost += $productItem->cost;
            $totalQuantity += $productItem->quantity;
        }

        if ($totalQuantity > 0) {
            $product->cost = $totalCost;
            $product->unit_cost = $totalCost / $totalQuantity;
            $product->save();
        }
    }
}
