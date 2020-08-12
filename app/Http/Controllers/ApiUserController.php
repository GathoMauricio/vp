<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Hash;

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
}
