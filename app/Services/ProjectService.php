<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectFiles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectService
{
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($data, [
                'date' => 'required|date',
                'item_name' => 'required|string|max:255',
                'project_name' => 'required|string|max:255|unique:projects',
                'quantity' => 'required|integer|min:1|max:10000',
                'execution_period' => 'required|integer|min:1|max:365',
                'delivery_date' => 'required|date|after_or_equal:date',
                'delivery_location' => 'required|string|max:255',
                'panel_number' => 'required|string|max:255',
                'initial_approval' => 'nullable|in:pending,approved,rejected',
                'technical_approval' => 'required|in:pending,approved,rejected',
                'description' => 'required|string|max:1000',
                'client_id' => 'required|exists:clients,id',
                'initial_files.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'technical_files.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'initial_files' => 'array|max:5',
                'technical_files' => 'array|max:5',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->toJson());
            }

            $project = Project::create([
                'created_by' => Auth::id(),
                'project_name' => $data['project_name'],
                ...$data
            ]);

            // Handle Initial Files
            if (isset($data['initial_files'])) {
                foreach ($data['initial_files'] as $file) {
                    $path = $file->store('projects/initial_files', 'public');
                    $project->initialFiles()->create([
                        'file_path' => $path,
                        'phase' => 'initial',
                        'uploaded_by' => Auth::id(),
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType()
                    ]);
                }
            }

            // Handle Technical Files
            if (isset($data['technical_files'])) {
                foreach ($data['technical_files'] as $file) {
                    $path = $file->store('projects/technical_files', 'public');
                    $project->technicalFiles()->create([
                        'file_path' => $path,
                        'phase' => 'technical',
                        'uploaded_by' => Auth::id(),
                        'file_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
            return $project;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(Project $project, array $data)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($data, [
                'project_name' => 'required|string|max:255|unique:projects,project_name,' . $project->id,
                'quantity' => 'required|integer|min:1|max:10000',
                'execution_period' => 'required|integer|min:1|max:365',
                'delivery_date' => 'required|date|after_or_equal:date',
                'delivery_location' => 'required|string|max:255',
                'panel_number' => 'required|string|max:255',
                'initial_approval' => 'nullable|in:pending,approved,rejected',
                'technical_approval' => 'required|in:pending,approved,rejected',
                'description' => 'required|string|max:1000',
                'initial_files.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'technical_files.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'initial_files' => 'array|max:5',
                'technical_files' => 'array|max:5',
            ]);

            if ($validator->fails()) {
                throw new \Exception($validator->errors()->toJson());
            }

            $project->update($data);

            // Handle file updates
            if (isset($data['initial_files'])) {
                $this->handleFileUpdates($project, $data['initial_files'], 'initial');
            }

            if (isset($data['technical_files'])) {
                $this->handleFileUpdates($project, $data['technical_files'], 'technical');
            }

            DB::commit();
            return $project;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function handleFileUpdates(Project $project, $files, $phase)
    {
        // Delete existing files if requested
        if (isset($files['delete']) && is_array($files['delete'])) {
            foreach ($files['delete'] as $fileId) {
                $file = ProjectFiles::findOrFail($fileId);
                if ($file->phase === $phase) {
                    Storage::disk('public')->delete($file->file_path);
                    $file->delete();
                }
            }
        }

        // Upload new files
        if (isset($files['new']) && is_array($files['new'])) {
            foreach ($files['new'] as $file) {
                $path = $file->store('projects/' . $phase . '_files', 'public');
                $project->initialFiles()->create([
                    'file_path' => $path,
                    'phase' => $phase,
                    'uploaded_by' => Auth::id(),
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType()
                ]);
            }
        }
    }

    public function delete(Project $project)
    {
        DB::beginTransaction();
        try {
            // Delete associated files
            $project->initialFiles()->each(function ($file) {
                Storage::disk('public')->delete($file->file_path);
            });

            $project->technicalFiles()->each(function ($file) {
                Storage::disk('public')->delete($file->file_path);
            });

            $project->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
