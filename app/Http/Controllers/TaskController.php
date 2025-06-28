<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        // Apply middleware for each action
        $this->middleware('can:Projects List')->only(['index', 'myTasks']);
        $this->middleware('can:Create Task')->only(['create', 'store']);
        $this->middleware('can:Edit Task')->only(['edit', 'update']);
        $this->middleware('can:Delete Task')->only(['destroy']);
        $this->middleware('can:View Task Details')->only(['show']);
        $this->middleware('can:Assign Task')->only(['assign']);
    }

    public function index($projectId)
    {
        if (!auth()->user()->can('View Project Tasks')) {
            abort(403, 'Unauthorized action.');
        }

        $tasks = Task::with('assignedTo')
            ->where('project_id', $projectId)
            ->get();
        return redirect()->route('projects.show', $projectId);
    }

    public function myTasks()
    {
        $tasks = Task::with('project')->where('assigned_to', auth()->id())->orderBy('due_date', 'asc')->get();
        if (Auth::user()->user_type == 'Admin') {
            $tasks = Task::with('project')->orderBy('due_date', 'asc')->get();
        }
        return view('tasks.my-tasks', compact('tasks'));
    }

    public function create($projectId)
    {
        $users = User::all();
        return view('tasks.create', compact('projectId', 'users'));
    }

    public function store(Request $request, $projectId)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:not_started,in_progress,completed',
        ])->validate();

        $validated['project_id'] = $projectId;
        $validated['assigned_at'] = now();
        Task::create($validated);

        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Task created successfully');
    }

    public function edit($projectId, Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'projectId', 'users'));
    }

    public function update(Request $request, $projectId, Task $task)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:not_started,in_progress,completed',
            'due_date' => 'nullable|date',
        ])->validate();

        if ($validated['status'] === 'completed' && $task->status !== 'completed') {
            $validated['completed_at'] = now();
        }

        $task->update($validated);

        return redirect()->route('tasks.index', $projectId)
            ->with('success', 'Task updated successfully');
    }

    public function destroy($projectId, Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index', $projectId)
            ->with('success', 'Task deleted successfully');
    }
}
