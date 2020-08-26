<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Service;
use Storage;
use App\File;

use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::where('technical_id',$request->user_id)
        ->whereDate('schedule',$request->date)
        ->with('status')
        ->with('service_type')
        ->with('manager')
        ->with('technical')
        ->with('usuario_Final')
        ->with('customer')
        ->get();
        return $services;
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
    public function show(Request $request)
    {
        $service = Service::where('id',$request->service_id)
        ->with('status')
        ->with('service_type')
        ->with('manager')
        ->with('technical')
        ->with('usuario_Final')
        ->with('customer')
        ->first();
        return $service;
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

    public function storeEvidence(Request $request)
    {
        //obtenemos el campo file definido en el formulario
        $file = $request->file('imagen');
        //obtenemos el nombre del archivo
        $nombre = $request->service_id."_".$file->getClientOriginalName();
        $myfile = File::create(
            [
                'service_id' => $request->service_id,
                'route' => $nombre,
                'description' => $request->description
            ]
        );
        if($myfile)
        {
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('local')->put($nombre,\File::get($file));
        }
    }
    public function uploadEvidence(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        $report = str_replace('/','-',$service->service_report);
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'evidenceTest_'.$service->customer['code'].'_'.$report.'.'.'png';
        //\File::put(storage_path(). '/' . $imageName, base64_decode($image));
        Storage::disk('local')->put($imageName,base64_decode($image));
        /*
        $service->firm = $imageName;
        $service->save();
        */
        return $service;
    }
}
