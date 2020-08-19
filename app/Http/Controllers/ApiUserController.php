<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Hash;
use Auth;

class ApiUserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!empty($user)>0)
        {
            if (Hash::check($request->password,bcrypt($request->password)))
            {
                return $user;
            }
        }else{
            return 0;
        }
    }
    public function updateFcmToken(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->fcm_token = $request->fcm_token;
        if($user->save())
        {
            return "FCM Token actualizado";
        }else{
            return "Error al actualizar FCM Token";
        }
    }
}
