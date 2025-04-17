<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function projectReport($projectId)
    {
        $project = Auth::user()->projects()->find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $tasks = $project->tasks()->with('statusHistory')->get();

        $report = $tasks->map(function ($task) {
            return [
                'task_name' => $task->name,
                'description' => $task->description,
                'status' => $task->status,
                'remarks' => $task->remarks,
                'status_history' => $task->statusHistory,
            ];
        });

        return response()->json([
            'project_name' => $project->name,
            'tasks' => $report,
        ]);
    }
}
