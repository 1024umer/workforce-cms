<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectTask, ProjectTaskSubtask};
use App\Repositories\{TaskRepository};

class ProjectTaskSubtaskController extends Controller
{
    protected $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function store(Project $project, ProjectTask $projectTask, Request $request){
        $subtask = ProjectTaskSubtask::create([
            'project_id' => $project->id,
            'project_task_id' => $projectTask->id,
            'is_completed' => 0,
            'description' => null
        ]);
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json(['subtask' => $subtask]);
    }
    public function update(Project $project, ProjectTask $projectTask, ProjectTaskSubtask $subTask, Request $request){
        $arr = $request->only(['is_completed','description']);
        $subTask->update($arr);
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json(['subtask' => $subTask]);
    }
    public function destroy(Project $project, ProjectTask $projectTask, ProjectTaskSubtask $subTask){
        $subTask->delete();
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json(['status' => true]);
    }
}
