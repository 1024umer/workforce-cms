<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(){
        return view('inbox.index')->with('title', 'Inbox')
        ->with('inboxMenu', true)
        ->with('hicon', 'fas fa-comments');
    }
}
