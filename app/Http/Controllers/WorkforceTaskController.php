<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\{FileRepository, TaskRepository};
use App\Models\{Project, User, ProjectTask};
class WorkforceTaskController extends Controller
{
    protected $file;
    protected $taskRepository;
    public function __construct(FileRepository $file, TaskRepository $taskRepository)
    {
        $this->file = $file;
        $this->taskRepository = $taskRepository;
    }
    public function index(Project $project){
        $users = User::all();
        return view('project.taskAssigner')->with('title', 'Task Assignment Manager')
        ->with('WFMTasksMenu', true)
        ->with('hicon', 'fas fa-manat-sign')
        ->with('project', $project)
        ->with('users', $users);
    }
    public function store(Request $request, Project $project){
        foreach($request->task as $task){
            $arr = [
                'user_id' => $task['user_id'],
                'project_grid_id' => $task['project_grid_id'],
                'due_date' => date('Y-m-d H:i:s', strtotime($task['due_date'])),
                'title' => $task['title'],
                'is_priority' => $task['is_priority'],
                'description' => $task['description'],
            ];
            $task = $project->tasks()->create($arr);
            if(intval($task['user_id'])!=$request->user()->id){
                $this->taskRepository->manageCollaborator($task->id);
            }
            $this->taskRepository->addCollaborator($task->id, $task['user_id']);
            // dd($request->file('files'));
            if (isset($task['files'])) {
                $this->file->create($task['files'], 'project_tasks', $task->id, 2);
            }
        }
        return response()->json(['status'=>true]);
    }
}
