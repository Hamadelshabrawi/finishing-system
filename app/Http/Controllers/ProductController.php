<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Products List')->only(['index']);
        $this->middleware('can:Create Product')->only(['create', 'store']);
        $this->middleware('can:Edit Product')->only(['edit', 'update']);
        $this->middleware('can:Delete Product')->only(['destroy']);
        $this->middleware('can:View Product Details')->only(['show']);
        $this->middleware('can:Export Product')->only(['export']);
    }

    /**
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('View Project Products')) {
            // Get products for projects the user has access to
            $products = Product::with(['project', 'items', 'outsources', 'finalFinish'])
                ->whereHas('project', function($query) {
                    $query->where('created_by', auth()->id());
                })
                ->paginate(10);
        } else {
            $products = Product::with(['project', 'items', 'outsources', 'finalFinish'])
                ->paginate(10);
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('products.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
        ])->validate();

        $product = Product::create($validated);

        return redirect()->route('products.show', $product->id)->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['project', 'items', 'outsources', 'finalFinish', 'ProductNote', 'files'])
            ->findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $projects = Project::all();
        return view('products.edit', compact('product', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}
