<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemPurchase;
use DataTables;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ItemController extends Controller
{
    



    public function index(Request $request)
    {
        if ($request->ajax()) {
            Log::info('AJAX request received');
        
            $query = Item::latest();
        
            return DataTables::eloquent($query)
                ->addColumn('actions', function($data) {
                    $actions = '';
        
                    if (auth()->user()->can('Project Details')) {
                        $actions .= '<a href="'.route('items.show', $data->id).'" class="btn btn-info btn-sm">View</a> ';
                    }
        
                    if (auth()->user()->can('Create Project')) {
                        $actions .= '<a href="'.route('items.edit', $data->id).'" class="btn btn-warning btn-sm">Edit</a> ';
                    }
        
                    if (auth()->user()->can('Delete Project')) {
                        $actions .= '<form action="'.route('items.destroy', $data->id).'" method="POST" style="display:inline;">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>';
                    }
        
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        
    
        return view('items.index');
    }


    public function data(Request $request)
    {
        Log::info('AJAX request received');
        $data = Item::latest()->get();
        Log::info('Retrieved data: ' . json_encode($data));

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="' . route('items.edit', $row->id) . '" class="btn btn-success btn-sm">Edit</a> 
                        <form action="' . route('items.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items',
            'unit' => 'required',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['product_id'] = $product->id;
        Item::create($validated);

        return redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->validate([
            'name' => 'required|unique:items,name,' . $item->id,
            'unit' => 'required',
            'selling_price' => 'required|numeric',
        ]));

        return redirect()->route('items.index');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index');
    }
}
