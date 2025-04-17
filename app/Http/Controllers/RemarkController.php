<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Remark;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller
{
    public function store(Request $request, $projectId, $taskId)
    {
        $project = Auth::user()->projects()->find($projectId);
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $task = $project->tasks()->find($taskId);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'remark' => 'required|string'
        ]);

        $remark = $task->remarks()->create([
            'user_id' => Auth::id(),
            'remark' => $validated['remark'],
        ]);

        return response()->json(['message' => 'Remark added successfully', 'remark' => $remark], 201);
    }
}
