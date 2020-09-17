<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\RetiroEquipo;
use App\Service;
use Storage;
class ApiRetiroEquipoController extends Controller
{
    public function index(Request $request)
    {
        $retiros = RetiroEquipo::where('service_id', $request->service_id)->get();
        foreach($retiros as $retiro)
        {
            if(!empty($retiro->firma))
            $retiro->firma =  env('APP_URL').'/public/storage'.'/'. $retiro->firma;
        }
        return $retiros;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $retiro = RetiroEquipo::create($request->all());
        if($retiro){ return "Registro almacenado"; }else{ return "Error al insertar"; }
    }
    public function storeFirma(Request $request)
    {
        $retiro = RetiroEquipo::findOrFail($request->retiro_id);
        $service = Service::findOrFail($request->service_id);
        $report = str_replace('/','-',$service->service_report);
        $image = $request->firma;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_retiro_Rt'.$request->retiro_id.'_'.$service->customer['code'].'_'.$report.'.'.'png';
        Storage::disk('local')->put($imageName,base64_decode($image));
        $retiro->firma = $imageName;
        $retiro->save();
        return $retiro;
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
