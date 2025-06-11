<?php

namespace App\Http\Controllers;

use App\Models\Outsource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\Product;

class OutsourceController extends Controller
{
    // Display a listing of the resource
    public function index($productId)
    {
        $product = Product::with('outsources')->findOrFail($productId);
        return view('products.outsources.index', compact('product'));
    }

    // Show the form for creating a new resource
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.outsources.create', compact('product'));
    }

    // Show the form for editing the specified resource
    public function edit($productId, $outsourceId)
    {
        $product = Product::findOrFail($productId);
        $outsource = Outsource::findOrFail($outsourceId);
        return view('products.outsources.edit', compact('product', 'outsource'));
    }

    // Store a newly created resource in storage
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'outsource_name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
            'boarder_note' => 'nullable|string',
        ]);

        Outsource::create([
            'product_id' => $productId,
            'project_id' => $request->project_id,
            'outsource_name' => $validated['outsource_name'],
            'boarder_note' => $validated['boarder_note'] ?? null,
            'cost' => $validated['cost'],
            'quantity' => $validated['quantity'],
        ]);

        return redirect()->back()->with('success', 'Outsource added successfully!');
    }

    // Update the specified resource in storage
    public function update(Request $request, $productId, $outsourceId)
    {
        $validated = $request->validate([
            'outsource_name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:1',
            'boarder_note' => 'nullable|string',
        ]);

        $outsource = Outsource::findOrFail($outsourceId);
        
        if ($outsource->product_id != $productId) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $outsource->update($validated);

        return redirect()->back()->with('success', 'Outsource updated successfully!');
    }

    // Remove the specified resource from storage
    public function destroy($productId, $outsourceId)
    {
        $outsource = Outsource::findOrFail($outsourceId);
        
        if ($outsource->product_id != $productId) {
            return redirect()->back()->with('error', 'Unauthorized action');
        }
        
        $outsource->delete();
        return redirect()->back()->with('success', 'Outsource deleted successfully!');
    }
}
