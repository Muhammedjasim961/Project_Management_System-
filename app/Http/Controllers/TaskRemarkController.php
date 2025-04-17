<?php

namespace App\Http\Controllers;

use App\Models\Remark;  // Add this if it's not already imported
use Illuminate\Http\Request;

class TaskRemarkController extends Controller
{
    public function destroy($projectId, $taskId, $remarkId)
    {
        $remark = Remark::where('id', $remarkId)
            ->where('task_id', $taskId)
            ->first();

        if (!$remark) {
            return response()->json(['message' => 'Remark not found'], 404);
        }

        if ($remark->task_id != $taskId) {
            return response()->json(['message' => 'Invalid remark for the specified task'], 400);
        }

        $remark->delete();

        return response()->json(['message' => 'Remark deleted successfully']);
    }
}
