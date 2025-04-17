<?php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// crud operations
class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Auth::user()->projects()->find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Auth::user()->projects()->find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully',
            'project' => $project,
        ]);
    }

    public function destroy($id)
    {
        $project = Auth::user()->projects()->find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
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
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'created_by' => $project->user->name ?? 'N/A',
                'tasks' => $project->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'status' => $task->status,
                        'remarks' => $task->remarks->map(function ($remark) {
                            return [
                                'id' => $remark->id,
                                'remark' => $remark->remark,
                                'status' => $remark->status,
                                'created_at' => $remark->created_at->format('Y-m-d H:i:s')
                            ];
                        }),
                    ];
                }),
            ]
        ]);
    }
}
