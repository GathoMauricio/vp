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
        $imageName = 'firma_'.$service->customer['code'].'_'.$report.'.'.'png';
        //\File::put(storage_path(). '/' . $imageName, base64_decode($image));
        Storage::disk('local')->put($imageName,base64_decode($image));
        $service->firm = $imageName;
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
        //$path = storage_path('/').$service->firm;
        return env('APP_URL').'/vp/public/storage'.'/'. $service->firm;
        //Storage::disk('local')->path($service->firm);
        //return $path;
        
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
