<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemPurchase;

class ItemPurchaseController extends Controller
{
    public function create(Item $item)
    {
        return view('item_purchases.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
        ]);

        $purchase = $item->purchases()->create([
            'purchase_price' => $validated['purchase_price'],
            'quantity' => $validated['quantity'],
            'remaining_quantity' => $validated['quantity'],
            'purchase_date' => $validated['purchase_date'],
        ]);

        // Update item stock and cost calculations
        $item->increment('total_stock', $validated['quantity']);
        $item->increment('total_quantity', $validated['quantity']);
        $item->increment('total_cost', $validated['quantity'] * $validated['purchase_price']);

        // Calculate current cost based on weighted average
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }

        return redirect()->route('items.show', $item);
    }

    public function consume(Item $item, Request $request)
    {
        $validated = $request->validate([
            'consume_quantity' => 'required|integer|min:1'
        ]);

        $qtyToConsume = $validated['consume_quantity'];
        $purchases = $item->purchases()->where('remaining_quantity', '>', 0)->orderBy('purchase_date')->get();

        $totalCost = 0;
        $totalQuantity = 0;

        foreach ($purchases as $purchase) {
            if ($qtyToConsume <= 0) break;

            $available = $purchase->remaining_quantity;
            $deduct = min($qtyToConsume, $available);

            $purchase->remaining_quantity -= $deduct;
            $purchase->save();

            // Calculate cost for consumed quantity
            $totalCost += $deduct * $purchase->purchase_price;
            $totalQuantity += $deduct;

            $qtyToConsume -= $deduct;
        }

        if ($qtyToConsume > 0) {
            return back()->withErrors(['consume_quantity' => 'Not enough stock to consume requested quantity.']);
        }

        // Update item stock and cost calculations
        $item->decrement('total_stock', $validated['consume_quantity']);
        $item->decrement('total_quantity', $validated['consume_quantity']);
        $item->decrement('total_cost', $totalCost);

        // Update current cost if there's still stock
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }

        return redirect()->route('items.show', $item);
    }

    public function edit(Item $item, ItemPurchase $purchase)
    {
        return view('item_purchases.edit', compact('item', 'purchase'));
    }

    public function update(Request $request, Item $item, ItemPurchase $purchase)
    {
        $validated = $request->validate([
            'purchase_price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
        ]);

        // Calculate changes
        $oldQuantity = $purchase->quantity;
        $newQuantity = $validated['quantity'];
        $quantityDiff = $newQuantity - $oldQuantity;

        // Update purchase
        $purchase->update([
            'purchase_price' => $validated['purchase_price'],
            'quantity' => $validated['quantity'],
            'remaining_quantity' => $validated['quantity'] - ($purchase->quantity - $purchase->remaining_quantity),
            'purchase_date' => $validated['purchase_date'],
        ]);

        // Update item stock and cost calculations
        $item->total_stock += $quantityDiff;
        $item->total_quantity += $quantityDiff;
        $item->total_cost += $quantityDiff * $validated['purchase_price'];

        // Update current cost if there's still stock
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }

        return redirect()->route('items.show', $item);
    }

    public function destroy(Item $item, ItemPurchase $purchase)
    {
        // Update item stock and cost calculations
        $item->decrement('total_stock', $purchase->remaining_quantity);
        $item->decrement('total_quantity', $purchase->quantity);
        $item->decrement('total_cost', $purchase->quantity * $purchase->purchase_price);

        // Update current cost if there's still stock
        if ($item->total_quantity > 0) {
            $item->current_cost = $item->total_cost / $item->total_quantity;
            $item->save();
        }

        $purchase->delete();
        return redirect()->route('items.show', $item);
    }

}
