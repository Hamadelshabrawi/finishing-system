<?php

namespace App\Http\Controllers;

use App\Models\FinalFinish;
use App\Models\Project;
use Illuminate\Http\Request;

use App\Models\Product;

class FinalFinishController extends Controller
{

    public function create(Product $product)
    {
        // Check if FinalFinish already exists for this product
        $existingFinish = FinalFinish::where('product_id', $product->id)->first();

        if ($existingFinish) {
            return redirect('/products/' . $product->id)
                ->with('warning', 'Final finishes already exist for this product');
        }

        return view('products.final-finish.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'internal_paint' => 'nullable|string',
            'electrostatic' => 'nullable|string',
            'pvd' => 'nullable|string',
            'polishing' => 'nullable|string',
        ]);

        // Check if FinalFinish already exists for this product
        $existingFinish = FinalFinish::where('product_id', $product->id)->first();

        if ($existingFinish) {
            // Update existing record
            $existingFinish->update($request->all());
            return redirect('/products/' . $product->id)
                ->with('success', 'Final finishes updated successfully');
        }

        // Create new record if none exists
        $finalFinish = new FinalFinish($request->all());
        $finalFinish->product_id = $product->id;
        $finalFinish->save();
        
        return redirect('/products/' . $product->id)
            ->with('success', 'Final finishes added successfully');
    }

    public function edit(Product $product)
    {
        $finalFinish = $product->finalFinish;
        return view('products.final-finish.edit', compact('product', 'finalFinish'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'internal_paint' => 'nullable|string',
            'electrostatic' => 'nullable|string',
            'pvd' => 'nullable|string',
            'polishing' => 'nullable|string',
        ]);

        // Check if final finish exists for this product
        $finalFinish = $product->finalFinish;
        
        if (!$finalFinish) {
            return redirect('/products/' . $product->id)
                ->with('error', 'No final finishes found for this product');
        }

        $finalFinish->update($request->all());

        return redirect('/products/' . $product->id)
            ->with('success', 'Final finishes updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->finalFinish()->delete();
        return redirect()->route('products.final-finish.show', $product)
            ->with('success', 'Final finishes removed successfully');
    }
}
