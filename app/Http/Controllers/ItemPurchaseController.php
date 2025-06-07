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

        // update total stock
        $item->increment('total_stock', $validated['quantity']);

        return redirect()->route('items.show', $item);
    }

    public function consume(Item $item, Request $request)
    {
        $validated = $request->validate([
            'consume_quantity' => 'required|integer|min:1'
        ]);

        $qtyToConsume = $validated['consume_quantity'];
        $purchases = $item->purchases()->where('remaining_quantity', '>', 0)->orderBy('purchase_date')->get();

        foreach ($purchases as $purchase) {
            if ($qtyToConsume <= 0) break;

            $available = $purchase->remaining_quantity;
            $deduct = min($qtyToConsume, $available);

            $purchase->remaining_quantity -= $deduct;
            $purchase->save();

            $qtyToConsume -= $deduct;
        }

        if ($qtyToConsume > 0) {
            return back()->withErrors(['consume_quantity' => 'Not enough stock to consume requested quantity.']);
        }

        // update item total stock
        $item->decrement('total_stock', $validated['consume_quantity']);

        return redirect()->route('items.show', $item);
    }
}
