<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Outsource;
use App\Models\Project;
use App\Models\Product;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::with(['outsources'])->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Supplier::create([
            'name' => $validated['name'],
            'location' => $validated['location'],
            'contact' => $validated['contact'],
            'description' => $validated['description'],
        ]);
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
    }

    public function show($id)
    {
        $supplier = Supplier::with(['outsources'])->findOrFail($id);
        return view('suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validated);
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }

    public function supplierOutsources($id)
    {
        $supplier = Supplier::with(['outsources.project', 'outsources.product'])->findOrFail($id);
        return view('suppliers.outsources', compact('supplier'));
    }
}
