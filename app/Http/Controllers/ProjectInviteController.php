<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ProjectInvite, User, ProjectCollaborator};
use Illuminate\Support\Facades\Hash;

class ProjectInviteController extends Controller
{
    public function index(ProjectInvite $projectInvite){
        $userCheckCount = User::where('email', $projectInvite->email)->count();
        return view('project.invite')->with('title' ,'Invitation')->with('invitePage', true)
        ->with('userCheckCount', $userCheckCount)
        ->with('projectInvite', $projectInvite);
    }
    public function inviteAccept(Request $request, ProjectInvite $projectInvite){
        if(isset($request->password)){
            User::create([
                'user_type' => 2,
                'email' => $projectInvite->email,
                'password' => Hash::make($request->password),
                'name' => $request->name
            ]);
        }
        $user = User::where('email', $projectInvite->email)->first();
        ProjectCollaborator::where('project_id', $projectInvite->project_id)
        ->where('user_id', $user->id)->delete();
        ProjectCollaborator::create([
            'project_id' => $projectInvite->project_id,
            'user_id' => $user->id
        ]);
        return redirect()->route('login')->with('redirect_success', 'Invitation Accepted');
    }
}
