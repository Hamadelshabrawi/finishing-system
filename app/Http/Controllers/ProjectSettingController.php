<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectSettingController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('Manage Project Settings');
        
        $settings = $project->settings()->orderBy('sort_order')->get();
        
        return view('projects.settings.index', compact('project', 'settings'));
    }

    public function create(Project $project)
    {
        $this->authorize('Manage Project Settings');
        
        return view('projects.settings.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('Manage Project Settings');
        
        $validated = $request->validate([
            'key' => 'required|string|unique:project_settings,key,NULL,id,project_id,' . $project->id,
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'value' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'type' => 'required|in:text,number,textarea,select',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $project->settings()->create($validated);

        return redirect()->route('projects.settings.index', $project)
            ->with('success', __('messages.setting_created'));
    }

    public function edit(Project $project, ProjectSetting $setting)
    {
        $this->authorize('Manage Project Settings');
        
        return view('projects.settings.edit', compact('project', 'setting'));
    }

    public function update(Request $request, Project $project, ProjectSetting $setting)
    {
        $this->authorize('Manage Project Settings');
        
        $validated = $request->validate([
            'key' => 'required|string|unique:project_settings,key,' . $setting->id . ',id,project_id,' . $project->id,
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'value' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'type' => 'required|in:text,number,textarea,select',
            'is_required' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $setting->update($validated);

        return redirect()->route('projects.settings.index', $project)
            ->with('success', __('messages.setting_updated'));
    }

    public function destroy(Project $project, ProjectSetting $setting)
    {
        $this->authorize('Manage Project Settings');
        
        $setting->delete();

        return redirect()->route('projects.settings.index', $project)
            ->with('success', __('messages.setting_deleted'));
    }
}
