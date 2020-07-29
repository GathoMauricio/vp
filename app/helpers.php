
<?php

if (! function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}

if (! function_exists('getRoles')) {
    function getRoles()
    {
        $roles = App\UserRol::where('user_id',Auth::user()->id)->get();
        $rol_admin=false;
        $rol_mesa=false;
        $rol_tec=false;
        foreach($roles as $rol)
        {
            if($rol->rol_id==7)
            {
                $rol_admin=true;
            }
            if($rol->rol_id==6)
            {
                $rol_mesa=true;
            }
            if($rol->rol_id < 6)
            {
                $rol_tec=true;
            }
        }
        return [
            'rol_admin' => $rol_admin,
            'rol_mesa' => $rol_mesa,
            'rol_tec' => $rol_tec
        ];
    }
}