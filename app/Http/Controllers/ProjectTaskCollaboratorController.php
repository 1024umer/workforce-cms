<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectTask, ProjectTaskCollaborator, User};
use App\Repositories\{TaskRepository};

class ProjectTaskCollaboratorController extends Controller
{
    protected $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function index(Project $project, ProjectTask $projectTask){
        $collaborators = $projectTask->collaborators;
        $users = User::where('is_deleted', 0)->simplePaginate(20);
        return view('project.taskCollaborators')->with('title' ,'Task Collaborator')
        ->with('myTaskMenu', true)
        ->with('hicon', 'fa fa-github')
        ->with('users', $users)
        ->with('collaborators', $collaborators)
        ->with(compact('project', 'projectTask'));
    }
    public function store(Project $project, ProjectTask $projectTask, Request $request){
        if($request->is_added==0){
            $this->taskRepository->addCollaborator($projectTask->id, $request->user_id);
        }else{
            $this->taskRepository->deleteCollaboratorUser($projectTask->id, $request->user_id);
        }
        return redirect()->back()->with('redirect_success', 'Collaborator Updated');
    }
}
