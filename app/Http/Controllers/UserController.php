<?php

namespace App\Http\Controllers;

use App\Models\{User, ProjectCollaborator};
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Repositories\{ FileRepository, ListRepository };
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreateMail;

class UserController extends Controller
{
    protected $file;
    protected $listRep;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->file = $file;
        $this->listRep = $listRep;
        $this->listRep->bindModel(User::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $query = $this->listRep->listFilteredQuery([
            'users.name','users.email'
        ])->select('users.*')->where('is_deleted', 0)->where('id','!=',auth()->user()->id);
        
        if (isset($_GET['user_type'])&&$_GET['user_type']!='') {
            $query = $query->where('users.user_type', $_GET['user_type']);
        }
        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $query = $query->paginate($_GET['perpage']);
        } else {
            $query = $query->paginate(20);
        }
        return view('users.index')->with('title' , 'Users')
        ->with('aUserMenu', true)
        ->with(compact('query'));
        // return UserResource::collection($query);
    }

    public function listing(Request $request){
        $query = $this->listRep->listFilteredQuery([
            'users.name','users.email'
        ])->select('users.*');
        if(isset($_GET['project_id'])){
            $uids = ProjectCollaborator::where('project_id', $_GET['project_id'])
            ->select('user_id')->get()->pluck('user_id');
            $query = $query->whereNotIn('id', $uids);
        }
        $query = $query->limit(10)->get();
        return response()->json([
            'data' => $query
        ]);
    }

    public function create(){
        return view('users.create')
        ->with('aUserMenu', true)->with('title' , 'Create User');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){
        $user = User::create($request->only('name','email','user_type','password'));
        $user->password = Hash::make($user->password);
        $user->save();
        Mail::to($request->email)->send(new UserCreateMail($user, $request->password));
        if($request->image){
            $this->file->create([$request->image], 'users', $user->id, 1);
        }
        // return new UserResource($user);
        return redirect()->route('admin.users.index')->with('redirect_success','User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user){
        return view('users.edit')->with('title' , 'Edit User')
        ->with('aUserMenu', true)
        ->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user){
        $user->update($request->only('name','email','user_type'));
        if($request->password!=''){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
        if($request->image){
            $this->file->create([$request->image], 'users', $user->id, 1);
        }
        return redirect()->route('admin.users.index')->with('redirect_success','User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user){
        // Gate::authorize('delete',$user);
        $user->update([
            'is_deleted' => 1,
            'deleted_at' => now()
        ]);
        return redirect()->back()->with('redirect_success', 'User Deleted');
        // return response()->json(null, 204);
    }
}