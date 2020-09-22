<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Hash;
use Auth;
use Storage;

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
    public function showFirm(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if(!empty($user->firm))
        return env('APP_URL').'/public/storage'.'/'. $user->firm;
        else return NULL;
    }
    public function updateFirm(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $image = $request->firma;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_user_'.$user->id.'_.'.'png';
        Storage::disk('local')->put($imageName,base64_decode($image));
        $user->firm = $imageName;
        $user->save();
        return $user;
    }
}
