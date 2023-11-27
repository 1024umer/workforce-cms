<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ProjectTaskTimer, User, ProjectGrid, ProjectTask};
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request){
        if($request->user()->user_type==1){
            $users = User::whereIn('users.user_type',[0, 1])->where('is_deleted', 0)->get();
        }else{
            $users = User::where('users.id',$request->user()->id)->where('is_deleted', 0)->get();
        }
        foreach($users as &$user){
            $tasks = $this->userTasks($user->id);
            $user->today = $tasks['today'];
            $user->upComming = $tasks['upComming']; 
            $user->overdue = $tasks['overdue']; 
            $user->stopped = $tasks['stopped']; 
            $user->completed = $tasks['completed'];
            $user->completedToday = $tasks['completedToday'];
        }
        $grids = ProjectGrid::where('project_id', 1)->get();
        $workforceTimers = $this->workforceTimers($request);
        // dd($workforceTimers);
        return view('reports.indexv2')->with('title', 'Reports')
        ->with('reportMenu', true)
        ->with('hicon' ,'fas fa-chart-line')
        ->with(compact('workforceTimers','grids','users'));
    }
    public function userTasks($user_id){
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date',$date)
        ->where('user_id', $user_id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->count();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', $date)
        ->where('user_id', $user_id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->count();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->where('user_id', $user_id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->count();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->where('user_id', $user_id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->count();
        $completed = ProjectTask::where('user_id', $user_id)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->where('is_completed', 1)->count();
        $completedToday = ProjectTask::whereDate('completed_at', date('Y-m-d'))
        ->where('is_completed', 1)
        ->where('user_id', $user_id)
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')->count();
        return [
            'today' => $today,
            'upComming' => $upComming,
            'overdue' => $overdue,
            'stopped' => $stopped,
            'completed' => $completed,
            'completedToday' => $completedToday,
        ];
    }
    public function workforceTimers(Request $request, $user=0){
        $type = 'today';
        $currentDate = now();
        $workforceTimers = ProjectTaskTimer::
        selectRaw("users.name ,project_grids.grid_name, project_grid_id, SUM(TIMESTAMPDIFF(MINUTE,project_task_timers.start_time,IFNULL(project_task_timers.end_time,'$currentDate'))/60) AS hours_spend,
        project_task_timers.user_id")
        ->leftJoin('project_grids', 'project_task_timers.project_grid_id','=','project_grids.id')
        ->leftJoin('users', 'project_task_timers.user_id','=','users.id')
        ->whereIn('users.user_type',[0, 1])
        ->where('project_task_timers.project_id', 1)
        ->groupBy('user_id', 'project_grid_id');
        if($request->user()->user_type==1){
            if($user>0){
                $workforceTimers = $workforceTimers->where('user_id', $user);
            }
        }else{
            $workforceTimers = $workforceTimers->where('user_id', $request->user()->id);
        }
        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }
        switch ($type) {
            case "today":
                $date = date('Y-m-d');
                $workforceTimers = $workforceTimers->whereDate('project_task_timers.created_at', $date);
                break;
            case "week":
                $time = strtotime(date('Y-m-d'));
                $first_day_of_week = date('Y-m-d', strtotime('Last Monday', $time));
                $last_day_of_week = date('Y-m-d', strtotime('Next Sunday', $time));
                $workforceTimers = $workforceTimers
                ->whereRaw("DATE(project_task_timers.created_at) BETWEEN ? AND ?", [$first_day_of_week, $last_day_of_week]);
                break;
            case "month":
                $first_day_of_month = date('Y-m-01');
                $last_day_of_month = date("Y-m-t");
                $workforceTimers = $workforceTimers
                ->whereRaw("DATE(project_task_timers.created_at) BETWEEN ? AND ?", [$first_day_of_month, $last_day_of_month]);
                break;
            case "custom":
                $from_date = date('Y-m-d');
                $to_date = date('Y-m-d');
                if(isset($_GET['from'])&&$_GET['from']!=''){
                    $from_date = date('Y-m-d', strtotime($_GET['from']));
                }
                if(isset($_GET['to'])&&$_GET['to']!=''){
                    $to_date = date('Y-m-d', strtotime($_GET['to']));
                }
                $workforceTimers = $workforceTimers
                ->whereRaw("DATE(project_task_timers.created_at) BETWEEN ? AND ?", [$from_date, $to_date]);
                break;
            default:
                $date = date('Y-m-d');
                $workforceTimers = $workforceTimers->whereDate('project_task_timers.created_at', $date);
        }
        $workforceTimers = $workforceTimers->get()->groupBy('user_id');
        return $workforceTimers;
    }
}
