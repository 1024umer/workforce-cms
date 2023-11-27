<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, Quote, ProjectTask, ProjectCollaborator};
use Carbon\Carbon;
use DB;
class DashboardController extends Controller
{
    public function todayQuotes(){
        $quotes = Quote::whereDate('created_at', Carbon::today())
        ->with('comments.user', 'user')->orderBy('id','desc')->get();
        return response()->json(['quotes' => $quotes]);
    }
    public function index(){
        $user_id = auth()->user()->id;
        $type = 'today';
        if(isset($_GET['type'])){
            $type = $_GET['type'];
        }
        $currentDate = now();
        $query = "SELECT SUM(TIMESTAMPDIFF(MINUTE,project_task_timers.start_time,IFNULL(project_task_timers.end_time,'$currentDate'))/60) AS hours_spend,
        project_task_timers.user_id FROM project_task_timers
        WHERE user_id = ". $user_id;
        switch ($type) {
            case "today":
                $date = date('Y-m-d');
                $query = $query." AND DATE(created_at) = '$date'";
                break;
            case "week":
                $time = strtotime(date('Y-m-d'));
                $first_day_of_week = date('Y-m-d', strtotime('Last Monday', $time));
                $last_day_of_week = date('Y-m-d', strtotime('Next Sunday', $time));
                $query = $query." AND DATE(created_at) BETWEEN '$first_day_of_week' AND '$last_day_of_week'";
                break;
            case "month":
                $first_day_of_month = date('Y-m-01');
                $last_day_of_month = date("Y-m-t");
                $query = $query." AND DATE(created_at) BETWEEN '$first_day_of_month' AND '$last_day_of_month'";
                break;
            default:
                $date = date('Y-m-d');
                $query = $query." AND DATE(created_at) = '$date'";
        }
        $query = $query.' GROUP BY user_id';
        $currentTimeCalculation = DB::select($query);
        $hoursWorked = 0;
        if(count($currentTimeCalculation)>0){
            $hoursWorked = number_format($currentTimeCalculation[0]->hours_spend, 2);
        }
        return view('dashboard.index')->with('title', 'Dashboard')
        ->with('dashboardMenu', true)
        ->with(compact('currentTimeCalculation', 'hoursWorked'));
    }
    public function getTasks(Request $request){
        $next7Days = date('Y-m-d', strtotime("+7 day"));
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')->whereDate('due_date',date('Y-m-d'))
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->with(['project','grid'])
        ->get();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', date('Y-m-d'))
        ->where('user_id', $request->user()->id)
        ->where('is_completed', 0)
        ->limit(10)
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')->with(['project','grid'])->get();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->where('user_id', $request->user()->id)
        ->whereDate('due_date', '<', $date)
        ->where('is_completed', 0)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->limit(10)
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')->with(['project','grid'])->get();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->where('user_id', $request->user()->id)
        ->whereDate('due_date', '<', $date)
        ->where('is_completed', 0)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->limit(10)
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')->with(['project','grid'])->get();
        $completedToday = ProjectTask::whereDate('completed_at', date('Y-m-d'))
        ->where('is_completed', 1)
        ->where('user_id', $request->user()->id)
        ->select('title','project_id','project_grid_id', 'is_completed', 'id')->with(['project','grid'])->get();
        return response()->json([
            'today'=>$today,
            'overdue'=>$overdue,
            'upcomming'=>$upComming,
            'completedToday'=>$completedToday,
            'stopped'=>$stopped
        ]);
    }
    public function getProjects(){
        $project_ids = ProjectCollaborator::select('project_id')->where('user_id', auth()->user()->id)->get()->pluck('project_id');
        $projects = Project::whereIn('id', $project_ids)
        ->where('id','<>',1)->orderBy('id','desc')->with('collaborators','collaborators.user')->get();
        $recentProjects = Project::orderBy('id','desc')
        ->whereIn('id', $project_ids)
        ->where('id','<>',1)->limit(10)->with('collaborators','collaborators.user')->get();
        return response()->json([
            'projects'=>$projects,
            'recentProjects'=>$recentProjects,
        ]);
    }
    public function birthdayCalendar(){
        return view('dashboard.widgets.calendar');
    }
}
