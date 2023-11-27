<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectTask, ProjectTaskComment};
use App\Repositories\{TaskRepository, FileRepository};
use Illuminate\Support\Facades\Storage;

class ProjectTaskCommentController extends Controller
{
    protected $file;
    protected $taskRepository;
    public function __construct(TaskRepository $taskRepository, FileRepository $file)
    {
        $this->file = $file;
        $this->taskRepository = $taskRepository;
    }
    public function store(Project $project, ProjectTask $projectTask, Request $request){
        $comment = $projectTask->comments()->create([
            'project_id'=>$project->id,
            'comment'=>$request->comment,
            'user_id'=>$request->user()->id
        ]);
        $this->taskRepository->manageCollaborator($projectTask->id);
        if($request->file('files')){
            $this->file->create($request->file('files'), 'project_task_comments', $comment->id, 2);
        }
        return response()->json([
            'comment' => $projectTask->comments()->orderBy('id','desc')->get()
        ]);
    }
}
