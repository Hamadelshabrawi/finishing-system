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
        $quantity = $validated['quantity'];

        // Calculate cost using FIFO method
        $purchases = $item->purchases()
            ->where('remaining_quantity', '>', 0)
            ->orderBy('purchase_date')
            ->get();

        $totalCost = 0;
        $totalQuantity = 0;
        $consumptionDetails = [];

        foreach ($purchases as $purchase) {
            if ($quantity <= 0) break;

            $available = $purchase->remaining_quantity;
            $deduct = min($quantity, $available);

            $purchase->remaining_quantity -= $deduct;
            $purchase->save();

            // Calculate cost for consumed quantity
            $totalCost += $deduct * $purchase->purchase_price;
            $totalQuantity += $deduct;

            $consumptionDetails[] = [
                'purchase_date' => $purchase->purchase_date,
                'purchase_price' => $purchase->purchase_price,
                'quantity' => $deduct,
                'total_cost' => $deduct * $purchase->purchase_price
            ];

            $quantity -= $deduct;
        }

        if ($quantity > 0) {
            return back()->withErrors([
                'quantity' => 'Not enough stock to consume requested quantity. ' . 
                'Available: ' . $totalQuantity . ' / Requested: ' . ($totalQuantity + $quantity)
            ]);
        }

        // Update item stock and cost calculations
        $item->decrement('total_stock', $totalQuantity);
        $item->decrement('total_quantity', $totalQuantity);
        $item->decrement('total_cost', $totalCost);

        // Update current cost if there's still stock
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }

        // Find or create product item record
        $productItem = $product->items()->where('item_id', $item->id)->first();
        
        if ($productItem) {
            // Update existing product item
            $productItem->quantity += $totalQuantity;
            $productItem->cost += $totalCost;
            $productItem->unit_cost = $productItem->cost / $productItem->quantity;
            $productItem->save();
        } else {
            // Create new product item
            $product->items()->create([
                'item_id' => $item->id,
                'quantity' => $totalQuantity,
                'cost' => $totalCost,
                'unit_cost' => $totalCost / $totalQuantity,
                'product_id' => $product->id
            ]);
        }

        // Record consumption history
        $product->consumptions()->create([
            'item_id' => $item->id,
            'quantity' => $totalQuantity,
            'unit_price' => $totalCost / $totalQuantity,
            'total_price' => $totalCost,
            'notes' => $validated['notes'] ?? null,
            'details' => json_encode($consumptionDetails)
        ]);

        // Update product cost
        $this->updateProductCost($product);

        return redirect()->route('products.show', $product)
            ->with('success', 'Successfully consumed ' . $totalQuantity . ' units of ' . $item->name);
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
}
