<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reschedule;
use App\Service;

class RescheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $service = Service::findOrFail($id);
        return view('reschedule.index_reschedule',['service' => $service]);
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
        $service = Service::findOrFail($request->service_id);
        Reschedule::create(
            [
                'service_id' => $request->service_id,
                'manager_id' => $request->manager_id,
                'last_date' => $request->last_date,
                'new_date' => $request->new_date_fecha.' '.$request->new_date_hora
            ]
        );
        $service->schedule = $request->new_date_fecha.' '.$request->new_date_hora;
        $service->save();
        return redirect('show_service/' . $service->id)->with('mensaje', 'El servicio se reagendó con éxito.');
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
