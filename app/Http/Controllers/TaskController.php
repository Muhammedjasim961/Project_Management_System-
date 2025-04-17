<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Store a new task
    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project = Auth::user()->projects()->findOrFail($projectId);

        $task = $project->tasks()->create($validated);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    // Update task status
    public function updateStatus(Request $request, $taskId)
    {
        $task = Auth::user()->tasks()->findOrFail($taskId);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'remarks' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Task status updated successfully',
            'task' => $task,
        ]);
    }
}
