<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use App\Http\Requests\Profile\{ChangePassword, UpdateProfile};
use App\Models\{User, ProjectTask};
use Illuminate\Support\Facades\Hash;
use App\Repositories\{FileRepository};
class ProfileController extends ReportController
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    public function profile(){
        return view('auth.profile')->with('title', 'Profile')
        ->with('hicon', 'fas fa-user-alt')
        ->with('profileMenu', true);
    }
    public function user(Request $request, User $user){
        $workforceTimers = $this->workforceTimers($request, $user->id);
        return view('auth.user')
        ->with('title', 'Profile')->with('hicon', 'fas fa-user-alt')
        ->with('profileMenu', true)
        ->with('user', $user)
        ->with('workforceTimers', $workforceTimers);
    }
    public function tasks(Request $request, User $user){
        $date = date('Y-m-d');
        $today = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date',$date)
        ->where('user_id', $user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])
        ->get();
        $upComming = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '>', $date)
        ->where('user_id', $user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        $overdue = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') <= 6")
        ->where('user_id', $user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        $stopped = ProjectTask::orderBy('is_priority', 'desc')
        ->whereDate('due_date', '<', $date)
        ->whereRaw("TIMESTAMPDIFF(DAY, project_tasks.due_date, '$date') > 6")
        ->where('user_id', $user->id)
        ->where('is_completed', 0)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date')
        ->with(['project','grid','collaborators'])->get();
        //completed date filter, if no date is selected then current month tasks will show, other wise filtered
        $fromDate = date('Y-m-01');
        if(isset($_GET['start_date'])){
            $fromDate = date('Y-m-d', strtotime($_GET['start_date']));
        }
        $toDate = date('Y-m-t');
        if(isset($_GET['end_date'])){
            $toDate = date('Y-m-d', strtotime($_GET['end_date']));
        }
        $completedToday = ProjectTask::where('user_id', $user->id)
        ->select('id','title','project_id','project_grid_id', 'is_completed', 'is_priority', 'user_id', 'due_date', 'completed_at')
        ->with(['project','grid','collaborators'])
        ->whereBetween('completed_at', [$fromDate." 00:00:00",$toDate." 23:59:59"])
        ->where('is_completed', 1)->get();
        return view('auth.tasks')->with('title', ucwords($user->name).' Tasks')
        ->with('hiconimg', $user->image_url)
        ->with(compact('today','overdue','upComming','completedToday', 'stopped', 'user', 'toDate', 'fromDate'));
    }
    public function update(UpdateProfile $request){
        $ar = $request->only(['name','email','favourite_color','favourite_movie','favourite_book','favourite_animal',
        'favourite_food','hobbies','dream_vacation','pet_peeves','biggest_fear','superpowers','onewish','talent','date_of_birth', 'bio']);
        User::where('id', $request->user()->id)
        ->update($ar);
        if ($request->image) {
            $this->file->create([$request->image], 'users', auth()->user()->id, 1);
        }
        return redirect()->back()->with('redirect_success', 'Profile Updated');
    }
    public function changePassword(ChangePassword $request){
        User::where('id', $request->user()->id)
        ->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->back()->with('redirect_success', 'Password Updated');
    }
}
