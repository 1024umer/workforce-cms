<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\{Project, ProjectTask, ProjectTaskTimer};
use App\Constants\{ Priorities };
use App\Repositories\{FileRepository, TaskRepository};

class ProjectTaskController extends Controller
{
    protected $file;
    protected $taskRepository;
    public function __construct(FileRepository $file, TaskRepository $taskRepository)
    {
        $this->file = $file;
        $this->taskRepository = $taskRepository;
    }
    public function store(Project $project, Request $request){
        $grid = $project->grids()->orderBy('order','asc')->first();
        $task = $project->tasks()->create([
            'project_grid_id' => intval(isset($request->grid)?$request->grid:$grid->id),
            'title' => $request->title,
            'description' => $request->description,
            'user_id'=>$request->user()->id,
            'due_date'=> (isset($request->due_date)? date('Y-m-d H:i:s', strtotime($request->due_date)): now())
        ]);
        $this->taskRepository->manageCollaborator($task->id);
        return response()->json(['status'=> true, 'task'=>$task]);
    }
    public function storeOtherProject(Project $project, Request $request){
        $task = $project->tasks()->create([
            'project_grid_id' => $request->grid_id,
            'title' => $request->title,
            'description' => $request->description,
            'user_id'=>$request->user_id,
            'due_date'=> ($request->due_date.' '.$request->due_time)//(isset($request->due_date)? $request->due_date: now())
        ]);
        if($request->user_id!=$request->user()->id){
            $this->taskRepository->manageCollaborator($task->id);
        }
        $this->taskRepository->addCollaborator($task->id, $request->user_id);
        // dd($request->file('files'));
        if ($request->file('files')) {
            $this->file->create($request->file('files'), 'project_tasks', $task->id, 2);
        }
        return response()->json(['status'=> true, 'task'=>$task]);
    }
    public function mytasks(Request $request){
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date',$date)
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->with(['project','grid','collaborators'])
        ->get();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', $date)
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->with(['project','grid','collaborators'])->get();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->with(['project','grid','collaborators'])->get();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->with(['project','grid','collaborators'])->get();
        $completedToday = ProjectTask::where('user_id', $request->user()->id)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority')
        ->with(['project','grid','collaborators'])
        ->where('is_completed', 1)->get();
        return view('mytasks')->with('title', 'My Tasks Board')
        ->with('myTaskMenu', true)
        ->with('hicon', 'fas fa-list-check')
        ->with(compact('today','overdue','upComming','completedToday', 'stopped'));
    }
    public function mytasksList(Request $request){
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date',$date)
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])
        ->get();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', $date)
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        $completedToday = ProjectTask::where('user_id', $request->user()->id)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])
        ->where('is_completed', 1)->get();
        return view('mytasksList')->with('title', 'My Tasks List')
        ->with('myTaskListMenu', true)
        ->with('hicon', 'fas fa-tasks-alt')
        ->with(compact('today','overdue','upComming','completedToday', 'stopped'));
    }
    public function get(Project $project, ProjectTask $projectTask){
        $projectTask->load('assigned', 'grid', 'comments', 'comments.user', 'subtasks', 'collaborators','collaborators.user');
        $project->load('grids');
        $currentDate = now();
        $taskTimer = DB::select("SELECT SUM(TIMESTAMPDIFF(MINUTE,project_task_timers.start_time,IFNULL(project_task_timers.end_time,'$currentDate'))/60) AS hours_spend
            from project_task_timers where project_task_timers.project_task_id = ".$projectTask->id);
        $hoursSpent = 0;
        if(count($taskTimer)>0){
            $hoursSpent = $taskTimer[0]->hours_spend;
        }
        return response()->json([
            'task' => $projectTask,
            'project' => $project,
            'hoursSpent'=> $hoursSpent
        ]);
    }
    public function gridUpdate(Project $project, ProjectTask $projectTask, Request $request){
        $msg = 'Updated Type from '.$projectTask->grid->grid_name.' to ';
        $projectTask->update([
            'project_grid_id' => $request->grid_id
        ]);
        $updatedTask = $projectTask->fresh();
        $msg.= $updatedTask->grid->grid_name;
        $this->taskRepository->setCommentTypeOther($msg,$projectTask->id);
        return response()->json([
            'status' => true
        ]);
    }
    public function priorityUpdate(Project $project, ProjectTask $projectTask, Request $request){
        $priorities = Priorities::getPriorities();
        $msg = 'Updated Priority from ';
        foreach($priorities as $priorityk=>$priorityv){
            if($priorityk==$projectTask->is_priority){
                $msg.=$priorityv['name'];
            }
        }
        $msg.=' to ';
        foreach($priorities as $priorityk=>$priorityv){
            if($priorityk==$request->priority){
                $msg.=$priorityv['name'];
            }
        }
        $this->taskRepository->setCommentTypeOther($msg,$projectTask->id);
        $projectTask->update([
            'is_priority' => $request->priority
        ]);
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json([
            'status' => true
        ]);
    }
    public function dueDateUpdate(Project $project, ProjectTask $projectTask, Request $request){
        $dueDate = date('Y-m-d H:i:s', strtotime($request->due_date));
        $this->taskRepository->setCommentTypeOther(
            'Updated due date from '.$projectTask->due_date.' to '.$dueDate,
            $projectTask->id
        );
        $projectTask->update([
            'due_date' => $dueDate
        ]);
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json([
            'status' => true
        ]);
    }
    public function completeToggle(Project $project, ProjectTask $projectTask, Request $request){
        if($projectTask->is_completed==0){
            //stop timer
            if(ProjectTaskTimer::where('project_task_id', $projectTask->id)->whereNull('end_time')->count()>0){
                $this->taskRepository->setCommentTypeOther('Stopped Timer',$projectTask->id);
            }
            ProjectTaskTimer::where('project_task_id', $projectTask->id)->whereNull('end_time')
            ->update([
                'end_time'=>now(),
            ]);
        }
        if($projectTask->is_completed==0){
            $this->taskRepository->setCommentTypeOther(
                'Marked Completed',
                $projectTask->id
            );
        }else{
            $this->taskRepository->setCommentTypeOther(
                'Re-Opened',
                $projectTask->id
            );
        }
        $projectTask->update([
            'is_completed' => ($projectTask->is_completed==0?1:0),
            'completed_at' => ($projectTask->is_completed==0?now():null)
        ]);
        $this->taskRepository->manageCollaborator($projectTask->id);
        return response()->json(['status'=> true]);
    }
    public function updateTaskTitle(Project $project, ProjectTask $projectTask, Request $request){
        $this->taskRepository->setCommentTypeOther(
            'Title Updated. Old title: '.$projectTask->title,
            $projectTask->id
        );
        $projectTask->update($request->only('title'));
        return response()->json(['status'=> true]);
    }
}
