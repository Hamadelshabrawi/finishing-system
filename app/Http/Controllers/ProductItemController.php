<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductItem;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class ProductItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Products List');
    }
    public function index($productId)
    {
        $product = Product::with(['items.item'])->findOrFail($productId);
        $items = Item::all();
        
        return view('products.items.index', compact('product', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        
        // Create or update product item
        $productItem = ProductItem::firstOrCreate([
            'product_id' => $productId,
            'item_id' => $validated['item_id']
        ], [
            'quantity' => $validated['quantity'],
            'unit_cost' => $item->price,
            'cost' => $item->price * $validated['quantity'],
        ]);

        // If the item already existed, update its quantity and cost
        if (!$productItem->wasRecentlyCreated) {
            $productItem->quantity = $validated['quantity'];
            $productItem->unit_cost = $item->price;
            $productItem->cost = $item->price * $validated['quantity'];
            $productItem->save();
        }

        return redirect()->back()->with('success', 'Item added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product, $item) 
    {
        $validated = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
        ])->validate();

        $productItem = ProductItem::where('product_id', $product)
            ->where('item_id', $item)
            ->firstOrFail();

        $productItem->update([
            'quantity' => $validated['quantity'],
            'unit_cost' => $validated['unit_cost'],
            'cost' => $validated['cost']
        ]);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product, $item_id)
    {
        // Delete the item using composite key
        ProductItem::where('product_id', $product)
            ->where('item_id', $item_id)
            ->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}
