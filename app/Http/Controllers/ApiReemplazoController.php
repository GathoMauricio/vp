<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Reemplazo;
use App\Service;
use Storage;
class ApiReemplazoController extends Controller
{
    public function index(Request $request)
    {
        $reemplazos = Reemplazo::where('service_id', $request->service_id)->get();
        foreach($reemplazos as $reemplazo)
        {
            if(!empty($reemplazo->firma))
            $reemplazo->firma =  env('APP_URL').'/public/storage'.'/'. $reemplazo->firma;
        }
        return $reemplazos;
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function storeFirma(Request $request)
    {
        $reemplazo = Reemplazo::findOrFail($request->reemplazo_id);
        $service = Service::findOrFail($request->service_id);
        $report = str_replace('/','-',$service->service_report);
        $image = $request->firma;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'firma_reemplazo_Rm'.$request->reemplazo_id.'_'.$service->customer['code'].'_'.$report.'.'.'png';
        Storage::disk('local')->put($imageName,base64_decode($image));
        $reemplazo->firma = $imageName;
        $reemplazo->save();
        return $reemplazo;
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
