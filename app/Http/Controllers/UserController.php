<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;
use App\User;
use App\UserRol;
use App\UserType;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserPwdRequest;
use Redirect;
use DB;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('user/index_user',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rols = Rol::all();
        return view('user/_create_user',['rols'=>$rols]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if($request->password == $request->repassword)
        {
            $user = User::create($request->except('repassword'));
            if($user)
            {
                //Crear token
                $user->api_token = Str::random(60);
                $user->save();
                //Eliminar roles existentes para este usuario
                DB::table('users_roles')->where('user_id',$user->id)->delete();
                //Crear nueva lista de roles
                foreach($request->roles as $rol)
                {
                    UserRol::create([
                        'user_id'=>$user->id,
                        'rol_id'=>$rol
                    ]);
                }
                return redirect('show_user/'.$user->id)->with('mensaje','El usuario se creó con éxito.');
            }
        }else{
            return Redirect::back()->withErrors(['repassword'=>'Las contraseñas no coinciden.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usersRoles = UserRol::where('user_id',$id)->get();
        $user = User::findOrfail($id);
        return view('user/_show_user',['user'=>$user,'usersRoles'=>$usersRoles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        $roles = Rol::all();
        $usersRoles = UserRol::where('user_id',$id)->get();
        return view('user/edit_user',['user'=>$user,'roles'=>$roles,'usersRoles'=>$usersRoles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrfail($id);
        $user->update($request->all());
        //Eliminar roles existentes para este usuario
        
        //Crear nueva lista de roles
        //DB::table('users_roles')->where('user_id',$user->id)->delete();
        /*
        foreach($request->roles as $rol)
        {
            UserRol::create([
                'user_id'=>$user->id,
                'rol_id'=>$rol
            ]);
        }
        */
        return redirect('show_user/'.$user->id)->with('mensaje','El usuario se actualizó con éxito.');
    }

    /**
     * confirm the specified resource before destroy.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request,$id)
    {
        $user = User::findOrfail($id);
        return view('user/confirm_user',['user'=>$user]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request,$id)
    {
        $user = User::findOrfail($id);
        if($user->delete())
        {
            DB::table('users_roles')->where('user_id',$id)->delete();
            return redirect('index_user')->with('mensaje','El usuario se eliminó con éxito.');
        }else{
            return redirect('index_user')->with('mensaje','Ocurrió un error al intentar eliminar el registro.');
        }
    }

    /**
     * Show the form for editing the password of specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPwd(Request $request,$id)
    {
        $user = User::findOrfail($id);
        return view('user/edit_pwd_user',['user'=>$user]);
    }

    /**
     * Update the specified password of resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePwd(UserPwdRequest $request,$id)
    {
        if($request->password == $request->repassword)
        {
            $user = User::findOrfail($id);
            $user->update($request->all());
            return redirect('show_user/'.$user->id)->with('mensaje','La contraseña de '.$user->name.' se actualizó con éxito.');
        }else{
            return Redirect::back()->withErrors(['repassword'=>'Las contraseñas no coinciden.']);
        }
    }
}