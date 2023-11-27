<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Project, ProjectInvite, User, File, ProjectTaskComment, ProjectCollaborator};
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectInviteMail;
use App\Repositories\{ ListRepository };

class ProjectController extends Controller
{
    protected $listRep;
    public function __construct(ListRepository $listRep)
    {
        $this->listRep = $listRep;
        $this->listRep->bindModel(Project::class);
    }
    public function getColor($num) {
        $hash = md5('color' . $num); // modify 'color' to get a different palette
        return array(
            hexdec(substr($hash, 0, 2)), // r
            hexdec(substr($hash, 2, 2)), // g
            hexdec(substr($hash, 4, 2))); //b
    }
    public function index(Request $request){
        $query = $this->listRep->listFilteredQuery([
            'projects.title', 'projects.description'
        ])->select('projects.*')->where('id','<>',1);
        if($request->user()->user_type!=1){
            $project_ids = ProjectCollaborator::select('project_id')->where('user_id', $request->user()->id)->get()->pluck('project_id');
            $query = $query->whereIn('id', $project_ids);
        }
        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $query = $query->paginate($_GET['perpage']);
        } else {
            $query = $query->paginate(20);
        }
        return view('project.index')->with('title' , 'Projects')
        ->with('aProjectMenu', true)
        ->with('hicon','fa-project-diagram')
        ->with(compact('query'));
        // return UserResource::collection($query);
    }
    public function store(Request $request){
        $max_id = (Project::max('id')+1);
        $color = $this->getColor($max_id);
        $color_code = 'rgb('.$color[0].','.$color[1].','.$color[2].')';
        $project = Project::create([
            'title'=>$request->title,
            'color_code' => $color_code,
            'user_id'=>auth()->user()->id
        ]);
        $project->collaborators()->create([
            'user_id' => auth()->user()->id
        ]);
        return redirect()->route('projects.board', $project);
    }
    public function update(Request $request, Project $project){
        $project->update($request->only('title'));
        return redirect()->back()->with('redirect_success', 'Project Name Updated');
    }
    public function board(Project $project){
        $users = User::where('is_deleted', 0)->get();
        return view('project.board')
        ->with('users',$users)->with('title','Board')
        ->with(compact('project'))->with('projectBoardMenu', true);
    }
    public function list(Project $project){
        $users = User::where('is_deleted', 0)->get();
        return view('project.list')
        ->with('users',$users)->with('title','List')
        ->with(compact('project'))->with('projectListMenu', true);
    }
    public function files(Project $project){
        $files = File::where('table_name', 'project_task_comments')->whereIn('fileable_id', 
            ProjectTaskComment::where('project_id', $project->id)->select('id')->get()->pluck('id')
        )->orderBy('id','desc')->get();
        return view('project.files')->with('title','Files')
        ->with(compact('project','files'))->with('projectFilesMenu', true);
    }
    public function invite(Request $request, Project $project){
        ProjectInvite::where('project_id', $project->id)->where('email', $request->email)->delete();
        $invite = ProjectInvite::create([
            'project_id' => $project->id,
            'email' => $request->email
        ]);
        Mail::to($request->email)->send(new ProjectInviteMail($invite, $request->user()));
        return redirect()->back()->with('redirect_success', 'Invitation Sent');
    }
    public function userInvite(Request $request, Project $project, User $user){
        ProjectInvite::where('project_id', $project->id)->where('email', $user->email)->delete();
        $invite = ProjectInvite::create([
            'project_id' => $project->id,
            'email' => $user->email
        ]);
        Mail::to($user->email)->send(new ProjectInviteMail($invite, $request->user()));
        return redirect()->back()->with('redirect_success', 'Invitation Sent');
    }
}
