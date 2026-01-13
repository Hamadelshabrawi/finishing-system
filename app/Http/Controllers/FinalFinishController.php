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
            'internal_paint' => 'nullable|string',  // دهانات داخلية
            'electrostatic' => 'nullable|string',   // الكتروستاتيك
            'pvd' => 'nullable|string',            // PVD
            'polishing' => 'nullable|string',      // فرش تلميع
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
        // Get the final finish directly from the database
        $finalFinish = FinalFinish::where('product_id', $product->id)->first();
        
        if (!$finalFinish) {
            return redirect()->route('products.show', $product->id)
                ->with('error', 'No final finishes found for this product');
        }

        return view('products.final-finish.edit', compact('product', 'finalFinish'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'internal_paint' => 'nullable|string',  // دهانات داخلية
            'electrostatic' => 'nullable|string',   // الكتروستاتيك
            'pvd' => 'nullable|string',            // PVD
            'polishing' => 'nullable|string',      // فرش تلميع
        ]);

        // Get the final finish directly from the database
        $finalFinish = FinalFinish::where('product_id', $product->id)->first();
        
        if (!$finalFinish) {
            return redirect('/products/' . $product->id)
                ->with('error', 'No final finishes found for this product');
        }

        // Update using mass assignment like in store method
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
