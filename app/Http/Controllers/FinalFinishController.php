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

        $finalFinish = new FinalFinish($request->all());
        $finalFinish->product_id = $product->id;
        $finalFinish->save();

        return redirect()->back()
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

        $finalFinish = $product->finalFinish;
        $finalFinish->update($request->all());

        return redirect()->back()
            ->with('success', 'Final finishes updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->finalFinish()->delete();
        return redirect()->route('products.final-finish.show', $product)
            ->with('success', 'Final finishes removed successfully');
    }
}
