<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectTask, ProjectTaskTimer};
use Carbon\Carbon;
use App\Repositories\{TaskRepository};

class ProjectTaskTimerController extends Controller
{
    protected $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function setTimer(Request $request, Project $project, ProjectTask $projectTask){
        $user_id = $request->user()->id;
        $projectTimerCount = ProjectTaskTimer::where('project_task_id', $projectTask->id)
        ->where('user_id',$user_id)->whereNull('end_time')->count();
        if($projectTimerCount===0){
            $otherTasksTimerCount = ProjectTaskTimer::where('user_id',$user_id)
            ->whereNull('end_time')->where('project_task_id','<>', $projectTask->id)->count();
            if($otherTasksTimerCount>0){
                $otherTaskTimerData = ProjectTaskTimer::where('user_id',$user_id)
                ->whereNull('end_time')->where('project_task_id','<>', $projectTask->id)->first();
                $this->taskRepository->setCommentTypeOther('Stopped Timer',$otherTaskTimerData->project_task_id);
                ProjectTaskTimer::where('user_id',$user_id)
                ->whereNull('end_time')->where('project_task_id','<>', $projectTask->id)
                ->update([
                    'end_time'=>Carbon::now(),
                ]);
            }
            ProjectTaskTimer::create([
                'project_id' => $project->id,
                'project_task_id' => $projectTask->id,
                'user_id'=> $user_id,
                'project_grid_id'=>$projectTask->project_grid_id,
                'start_time'=>Carbon::now(),
                'end_time'=>null,
            ]);
            $this->taskRepository->setCommentTypeOther('Started Timer',$projectTask->id);
        }else{
            ProjectTaskTimer::where('project_task_id', $projectTask->id)->whereNull('end_time')
            ->where('user_id',$user_id)
            ->update([
                'end_time'=>Carbon::now(),
            ]);
            $this->taskRepository->setCommentTypeOther('Stopped Timer',$projectTask->id);
        }
        $this->taskRepository->manageCollaborator($projectTask->id);
        if(isset($_GET['ajax'])){
            return response()->json([
                'status' => true
            ]);
        }
        return redirect()->back()->with('redirect_success', 'Project Task Timer Set');
    }
}
