<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TaskNotification;
use App\Models\User;
class CronController extends Controller
{
    public function taskStatusNotifications(){
        $users = User::all();
        foreach($users as $user){
            $user->notify(new TaskNotification($user));
        }
    }
}
