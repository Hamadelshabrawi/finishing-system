<?php

// app/Http/Controllers/MaterialController.php
namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log ;
use App\Models\Item;

class MaterialController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'materials' => 'required|array',
            'materials.*.item_id' => 'nullable|exists:items,id',
            'materials.*.quantity' => 'nullable|string',
            'materials.*.notes' => 'nullable|string',
        ]);
    
        $project = Project::findOrFail($projectId);
    
        foreach ($request->materials as $index => $materialData) {
            $material = new Material();
            $material->project_id = $project->id;
    
            if ($materialData['item_id'] !== 'other') {
                $item = Item::find($materialData['item_id']);
    
                if (!$item) {
                    return back()->withErrors(['materials.' . $index . '.item_id' => 'Invalid item selected.']);
                }
    
                $material->item_id = $item->id;
                $material->material_source = Material::SOURCE_INVENTORY;
            } else {
                $material->material_source = Material::SOURCE_MANUAL;
            }
    
            $material->quantity = $materialData['quantity'] ?? null;
            
            if (isset($materialData['notes'])) {
                $material->notes = $materialData['notes'];
            }
    
            $material->save();
        }
    
        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Materials added successfully.');
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'item_id' => 'nullable|exists:items,id',
            'quantity' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);
    
        $material->update($validated);
    
        return redirect()->back()->with('material_success', 'Material updated successfully.');
    }
    
    

    public function destroy($id)
    {

        $material = Material::find($id);
    
        if ($material) {
            $material->delete();
        }
    
        return redirect()->back()->with('success', 'Material deleted successfully.');
    }
}
