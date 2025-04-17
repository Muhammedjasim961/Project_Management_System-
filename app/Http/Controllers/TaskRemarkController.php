<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskRemarkController extends Controller
{
    public function destroy(Project $project, Task $task, TaskRemark $remark)
    {
        // Check if the task belongs to the project
        if ($task->project_id !== $project->id) {
            return response()->json(['message' => 'Task does not belong to project'], 404);
        }

        // Check if the remark belongs to the task
        if ($remark->task_id !== $task->id) {
            return response()->json(['message' => 'Remark does not belong to task'], 404);
        }

        // Delete the remark
        $remark->delete();

        return response()->json(['message' => 'Remark deleted successfully']);
    }
}
