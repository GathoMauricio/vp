<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use File;
use Storage;
use Illuminate\Support\Facades\Response;

class ApiFirmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $report = str_replace('/','-',$service->service_report);
        $image = $request->firma;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_final_user_'.$service->customer['code'].'_'.$report.'.'.'png';
        Storage::disk('local')->put($imageName,base64_decode($image));
        $service->firm = $imageName;
        $service->save();
        return $service;
    }
    public function store2(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        $report = str_replace('/','-',$service->service_report);
        $image = $request->firma;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_encargado_'.$service->customer['code'].'_'.$report.'.'.'png';
        Storage::disk('local')->put($imageName,base64_decode($image));
        $service->firm2 = $imageName;
        $service->save();
        return $service;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        return env('APP_URL').'/public/storage'.'/'. $service->firm;
    }
    public function show2(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        return env('APP_URL').'/public/storage'.'/'. $service->firm2;
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
