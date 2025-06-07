<?php

namespace App\Http\Controllers;

use App\Models\Outsource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;
use App\Models\GeneralNote;

class OutsourceController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $outsources = Outsource::all();
        return response()->json($outsources);
    }

    // Show the form for creating a new resource
    public function create()
    {
        // If using API only, you might not need this.
        return view('outsources.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request, $projectId)
    {
        $outsources = $request->input('outsources', []);
    
        foreach ($outsources as $outsourceData) {
            Outsource::create([
                'project_id' => $projectId,
                'outsource_name' => $outsourceData['outsource_name'],
                'boarder_note' => $outsourceData['boarder_note'] ?? null,
                'cost' => $outsourceData['cost'],
                'quantity' => $outsourceData['quantity'],
            ]);
        }
    
        return redirect()->back()->with('outsource_success', 'Outsources added successfully!');
    }
    

    // Display the specified resource
    public function show($id)
    {
        $outsource = Outsource::findOrFail($id);
        return response()->json($outsource);
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $outsource = Outsource::findOrFail($id);
        // If using API only, you might not need this.
        return view('outsources.edit', compact('outsource'));
    }

    public function update(Request $request, Outsource $outsource)
    {
        $validated = $request->validate([
            'outsource_name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'quantity' => 'required|numeric',
            'boarder_note' => 'nullable|string',
        ]);
    
        $outsource->update($validated);
    
        return redirect()->back()->with('outsource_success', 'Outsource updated successfully!');
    }
    
    // Remove the specified resource from storage
    public function destroy($id)
    {
        $outsource = Outsource::findOrFail($id);
        $outsource->delete();
    
        return redirect()->back()->with('success', 'Record deleted successfully')->with('tab', 'tab3');
    }

    public function general_note(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'Note' => 'required|string|max:1000',
        ]);

        GeneralNote::updateOrCreate(
            ['project_id' => $validated['project_id']],
            ['Note' => $validated['Note']]
        );

        return redirect()->back()->with('note_success', 'Note saved successfully!');
    }
}
