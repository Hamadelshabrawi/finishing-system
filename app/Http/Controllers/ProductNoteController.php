<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductNote;
use Illuminate\Http\Request;

class ProductNoteController extends Controller
{
    public function show(Product $product)
    {
        return response()->json($product->note?->note ?? '');
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:65535',
        ]);

        $product->note()->create([
            'note' => $validated['note']
        ]);

        return redirect()->back()->with('success', 'Note added successfully');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:65535',
        ]);

        $product->note()->update([
            'note' => $validated['note']
        ]);

        return redirect()->back()->with('success', 'Note updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->note) {
            $product->note()->delete();
        }

        return redirect()->back()->with('success', 'Note deleted successfully');
    }
}
