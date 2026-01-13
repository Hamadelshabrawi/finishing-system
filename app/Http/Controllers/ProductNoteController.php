<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductNoteController extends Controller
{
    public function show(Product $product)
    {
        $latestNote = $product->notes()->latest()->first();
        return response()->json($latestNote?->note ?? '');
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:65535',
        ]);

        $product->ProductNote()->create([
            'note' => $validated['note'],
            'product_id' => $product->id
        ]);

        return redirect()->back()->with('success', 'Note added successfully');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:65535',
        ]);

        $note = $product->ProductNote()->latest()->first();
        if ($note) {
            $note->update([
                'note' => $validated['note']
            ]);
        }

        return redirect()->back()->with('success', 'Note updated successfully');
    }

    public function destroy(Product $product)
    {
        $note = $product->ProductNote()->latest()->first();
        if ($note) {
            $note->delete();
        }

        return redirect()->back()->with('success', 'Note deleted successfully');
    }
}
