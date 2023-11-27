<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class NotificationController extends Controller
{
    public function index(){
        if(isset($_GET['is_important'])){
            $notifications = auth()->user()->notifications()
            ->where('is_important',1)->simplePaginate(50);
            $notifications->appends(['is_important' => '1']);
        }else{
            $notifications = auth()->user()->notifications()->simplePaginate(50);
        }
        $notificationsRead = [];
        foreach($notifications as $notification){
            if(!$notification->read_at){
                $notificationsRead[] = $notification->id;
            }
            $notification->markAsRead();
        }
        return view('notifications.index')->with('title','Notifications')
        ->with('notificationMenu', true)
        ->with('hicon', 'fas fa-bell')
        ->with('notifications', $notifications)
        ->with('notificationsRead', $notificationsRead);
    }
    public function destroy($id){
        DB::delete("delete from notifications where id = ?",[$id]);
        return redirect()->back();
    }
    public function markImportant($id){
        DB::update("Update notifications set is_important = CASE WHEN is_important = 1 THEN 0 ELSE 1 END
        where id = ?
        ", [$id]);
        return redirect()->back();
    }
}
