<?php

namespace App\Http\Controllers;

use App\Models\FinalFinish;
use App\Models\Project;
use Illuminate\Http\Request;

class FinalFinishController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'internal_paint' => 'nullable|string',
            'electrostatic' => 'nullable|string',
            'pvd' => 'nullable|string',
            'polishing' => 'nullable|string',
        ]);

        $project = Project::findOrFail($projectId);

        $finalFinish = $project->finalFinish()->firstOrNew([]);
        $finalFinish->fill($request->all());
        $finalFinish->save();

        return redirect()->route('projects.show', $projectId)
                         ->with('success', 'Final Finish data saved successfully.');
    }
}
