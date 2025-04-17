<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index($projectId)
    {
        $user = auth()->user();
        $project = Project::where('id', $projectId)->where('user_id', $user->id)->first();

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project->tasks);
    }

    public function store(Request $request, $projectId)
    {
        \Log::info('Authenticated User ID: ' . Auth::id());
        \Log::info('Trying to access Project ID: ' . $projectId);

        $project = Auth::user()->projects()->find($projectId);
        if (!$project) {
            \Log::warning('Project not found for user.');
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $project->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json($task, 201);
    }

    public function show($projectId, $taskId)
    {
        $project = Auth::user()->projects()->find($projectId);

        if (!$project)
            return response()->json(['message' => 'Project not found'], 404);

        $task = $project->tasks()->find($taskId);

        if (!$task)
            return response()->json(['message' => 'Task not found'], 404);

        return response()->json($task);
    }

    public function getRemarks(Project $project, Task $task)
    {
        // Fetch remarks for the task
        $remarks = $task->remarks;  // Assuming Task model has a relationship with Remark

        return response()->json([
            'remarks' => $remarks
        ]);
    }

    public function updateStatus(Request $request, $projectId, $taskId)
    {
        $task = Task::where('id', $taskId)->where('project_id', $projectId)->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'status' => 'required|string'
        ]);

        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'Task status updated successfully', 'task' => $task]);
    }

    public function destroy($projectId, $taskId)
    {
        $project = Auth::user()->projects()->find($projectId);
        if (!$project)
            return response()->json(['message' => 'Project not found'], 404);

        $task = $project->tasks()->find($taskId);
        if (!$task)
            return response()->json(['message' => 'Task not found'], 404);

        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }

    public function addRemark(Request $request, $projectId, $taskId)
    {
        try {
            $project = Auth::user()->projects()->find($projectId);
            if (!$project) {
                return response()->json(['message' => 'Project not found'], 404);
            }

            $task = $project->tasks()->find($taskId);
            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            $validated = $request->validate([
                'remark' => 'required|string',
            ]);

            $remark = $task->remarks()->create([
                'remark' => $validated['remark'],
                'user_id' => Auth::id(),
            ]);

            return response()->json($remark, 201);
        } catch (\Exception $e) {
            \Log::error('Remark Create Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function report(Project $project)
    {
        $project->load([
            'tasks.remarks' => function ($query) {
                $query->orderBy('created_at');
            },
            'user:id,name'
        ]);

        return response()->json([
            'project' => $project
        ]);
    }
}
