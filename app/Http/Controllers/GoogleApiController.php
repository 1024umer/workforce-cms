<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class GoogleApiController extends Controller
{
    public function setToken(Request $request){
        Session::put('googleToken', json_decode($request->token));
        return response()->json(['status' => true]);
    }
    public function checkToken(Request $request){
        // $request->session()->flush();
        if ($request->session()->has('googleToken')) {
            $token = Session::get('googleToken');
            return response()->json(['token' => $token, 'status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }
    public function forgetToken(Request $request){
        $request->session()->forget('googleToken');
        return response()->json(['status' => true]);
    }
}
