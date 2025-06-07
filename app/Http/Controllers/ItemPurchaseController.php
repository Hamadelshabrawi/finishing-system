<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemPurchaseController extends Controller
{
    public function create(Item $item)
    {
        return view('item_purchases.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'purchase_price' => 'required|numeric|min:0.01|max:1000000',
                'quantity' => 'required|integer|min:1|max:100000',
                'purchase_date' => 'required|date|before_or_equal:today',
                'supplier' => 'required|string|max:255',
                'invoice_number' => 'nullable|string|max:50|unique:item_purchases,invoice_number',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->toJson());
            }

            $validated = $validator->validated();

            $purchase = $item->purchases()->create([
                'purchase_price' => $validated['purchase_price'],
                'quantity' => $validated['quantity'],
                'remaining_quantity' => $validated['quantity'],
                'purchase_date' => $validated['purchase_date'],
                'supplier' => $validated['supplier'],
                'invoice_number' => $validated['invoice_number'] ?? null,
            ]);

            // Update total stock with transaction
            $item->increment('total_stock', $validated['quantity']);

            DB::commit();
            return redirect()->route('items.show', $item)->with('success', 'Purchase recorded successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function consume(Item $item, Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'consume_quantity' => 'required|integer|min:1|max:100000',
                'project_id' => 'required|exists:projects,id',
                'notes' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->toJson());
            }

            $validated = $validator->validated();

            $qtyToConsume = $validated['consume_quantity'];
            $purchases = $item->purchases()
                ->where('remaining_quantity', '>', 0)
                ->orderBy('purchase_date')
                ->get();

            $totalAvailable = $purchases->sum('remaining_quantity');

            if ($qtyToConsume > $totalAvailable) {
                throw new \Exception("Not enough stock to consume requested quantity. Available: $totalAvailable");
            }

            foreach ($purchases as $purchase) {
                if ($qtyToConsume <= 0) break;

                $available = $purchase->remaining_quantity;
                $deduct = min($qtyToConsume, $available);

                $purchase->remaining_quantity -= $deduct;
                $purchase->save();

                // Create consumption log
                $purchase->consumptionLogs()->create([
                    'quantity' => $deduct,
                    'project_id' => $validated['project_id'],
                    'notes' => $validated['notes'] ?? null,
                    'consumed_by' => auth()->id(),
                ]);

                $qtyToConsume -= $deduct;
            }

            // Update item total stock
            $item->decrement('total_stock', $validated['consume_quantity']);

            DB::commit();
            return redirect()->route('items.show', $item)->with('success', 'Stock consumed successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
