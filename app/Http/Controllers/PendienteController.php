<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Auth;
class PendienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('technical_id',Auth::user()->id)->where('status_service_id',1)->orderBy('schedule','asc')->paginate(15);
        return view('pendiente.index_pendiente',['services' => $services]);
    }

    public function index_pendiente_menu(Request $request)
    {
        if (getRoles()['rol_admin']) {
            $services = Service::where('status_service_id',1)->
                paginate(15);
            return view('services/_index_pendiente', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de administrador por lo tanto se muestran todos los servicios existentes.']);
        }
        if (getRoles()['rol_mesa'] && getRoles()['rol_tec']) {
            $services = Service::where('status_service_id',1)->
            where('manager_id', Auth::user()->id)
                ->orWhere('technical_id', Auth::user()->id)
                ->paginate(15);
            return view('services/_index_pendiente', ['services' => $services, 'desc' => 'Este perfil cuenta tanto con rol de mesa de ayuda como de técnico se muestran tanto los servicios levantados como asignanos a este usuario.']);
        }
        if (getRoles()['rol_mesa']) {
            $services = Service::where('status_service_id',1)->
            where('manager_id', Auth::user()->id)->paginate(15);
            return view('services/_index_pendiente', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de mesa de ayuda por lo tanto se muestran los servicios que haya levantado este usuario.']);
        }
        if (getRoles()['rol_tec']) {
            $services = Service::where('status_service_id',1)->
            where('technical_id', Auth::user()->id)->paginate(15);
            return view('services/_index_pendiente', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de técnico por lo tanto se muestran los servicios asignados a este usuario.']);
        }
        $services = Service::where('status_service_id',1)->
        where('technical_id', 0)->paginate(15);
        return view('services/_index_pendiente', ['services' => $services, 'desc' => 'Este perfil no cuenta con ningun rol verifique con el administrador.']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
