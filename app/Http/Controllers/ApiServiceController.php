<?php

namespace App\Http\Controllers;
use App\Http\Controllers\NotificationController;
use Carbon\Carbon;
use App\Service;
use Storage;
use App\File;
use App\Comment;
use App\Mensaje;

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
    public function indexEvidencia(Request $request)
    {
        $json = [];
        $files = File::where('service_id',$request->service_id)->get();
        foreach($files as $file)
        {
            $json[] = [
                'id' => $file->id,
                'date' => date_format(new \DateTime($file->created_at), 'd-m-Y g:i A'),
                'src' =>  env('APP_URL').'/public/storage'.'/'.$file->route,
                'description' => $file->description
            ];
        }
        return $json;
    }
    public function indexMensajes(Request $request)
    {
        $json = [];
        $comentarios = Comment::where('service_id', $request->service_id)
        ->orderBy('created_at', 'ASC')
        ->with('user')
        ->get();
        foreach($comentarios as $comentario)
        {
            $json[] = [
                'id' => $comentario->id,
                'user' => $comentario->user['name'].' '.$comentario->user['last_name1'].' '.$comentario->user['last_name2'],
                'comment' => $comentario->comment,
                'date' => date_format(new \DateTime($comentario->created_at), 'd-m-Y g:i A')
            ];
        }
        return $json;
    }
    public function storeMensaje(Request $request)
    {
        Comment::create($request->all());
        $json = [];
        $comentarios = Comment::where('service_id', $request->service_id)
        ->orderBy('created_at', 'ASC')
        ->with('user')
        ->get();
        foreach($comentarios as $comentario)
        {
            $json[] = [
                'id' => $comentario->id,
                'user' => $comentario->user['name'].' '.$comentario->user['last_name1'].' '.$comentario->user['last_name2'],
                'comment' => $comentario->comment,
                'date' => date_format(new \DateTime($comentario->created_at), 'd-m-Y g:i A')
            ];
        }
        return $json;
    }
    public function iniciarServicio(Request $request)
    {
        if ($request->comment != null) {
            $comment = Comment::create([
                'service_id' => $request->service_id,
                'comment_type_id' => 1,
                'comment' => $request->comment
            ]);
            if ($comment) {
                $service = Service::findOrFail($request->service_id);
                $service->status_service_id = 2;
                $service->init_service = date('Y-m-d H:i:s');
                $service->save();
                Mensaje::create([
                    'service_id' => $service->id,
                    'emisor_id' => $service->technical_id,
                    'receptor_id' => $service->manager_id,
                    'mensaje' => 'Ha iniciado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'icon' => 'icon-share',
                    'color' => 'blue'
                ]);
                $notificacion = new NotificationController();
                $notificacion->sendMensaje(
                    'user_channel_'.$service->manager_id,
                    'mensaje_push',
                    [
                        'cliente' => $service->customer['code'],
                        'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                        'mensaje' => 'Ha iniciado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                );
                return ['error' => 0 , 'msg' => 'El servicio se ha iniciado con éxito'];
            }
        } else {
            $service = Service::findOrFail($request->service_id);
            $service->status_service_id = 2;
            $service->init_service = date('Y-m-d H:i:s');
            $service->save();
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->technical_id,
                'receptor_id' => $service->manager_id,
                'mensaje' => 'Ha iniciado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                'icon' => 'icon-share',
                'color' => 'blue'
            ]);
            $notificacion = new NotificationController();
                $notificacion->sendMensaje(
                    'user_channel_'.$service->manager_id,
                    'mensaje_push',
                    [
                        'cliente' => $service->customer['code'],
                        'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                        'mensaje' => 'Ha iniciado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                );
                return ['error' => 0 , 'msg' => 'El servicio se ha iniciado con éxito'];
        }
        return ['error' => 1 , 'msg' => 'Error al procesar la petición'];
    }

    public function validarEvidencia(Request $request)
    {
        
        return [
            'evidencia' => count(File::where('service_id',$request->service_id)->get()),
            'firma' => count(Service::where('id',$request->service_id)->where('firm','!=',NULL)->get())
        ];
    }
    public function finalizarServicio(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
                $service->status_service_id = 3;
                $service->solution = $request->solution;
                $service->end_service = date('Y-m-d H:i:s');
                $service->save();
                Mensaje::create([
                    'service_id' => $service->id,
                    'emisor_id' => $service->technical_id,
                    'receptor_id' => $service->manager_id,
                    'mensaje' => 'Ha finalizado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'icon' => 'icon-checkmark',
                    'color' => 'green'
                ]);
                $notificacion = new NotificationController();
                    $notificacion->sendMensaje(
                        'user_channel_'.$service->manager_id,
                        'mensaje_push',
                        [
                            'cliente' => $service->customer['code'],
                            'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                            'mensaje' => 'Ha finalizado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                            'timestamp' => date('Y-m-d H:i:s')
                        ]
                    );
        return ['error' => 0 , 'msg' => 'El servicio se ha finalizado con éxito'];
    }
    public function reagendarServicio(Request $request)
    {
        $comment = Comment::create([
            'service_id' => $request->service_id,
            'comment_type_id' => 2,
            'comment' => $request->comment . ' (' . $request->fecha . ' A las ' . $request->hora . ' Hrs.)'

        ]);
        $service = Service::findOrFail($request->service_id);
        Mensaje::create([
            'service_id' => $service->id,
            'emisor_id' => $service->technical_id,
            'receptor_id' => $service->manager_id,
            'mensaje' => 'Ha solicitado reagendar el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
            'icon' => 'icon-clock',
            'color' => 'orange'
        ]);
        $notificacion = new NotificationController();
            $notificacion->sendMensaje(
                'user_channel_'.$service->manager_id,
                'mensaje_push',
                [
                    'cliente' => $service->customer['code'],
                    'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                    'mensaje' => 'Ha solicitado reagendar el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            );
            return ['error' => 0 , 'msg' => 'La solicitud se envió con éxito'];
    }
    public function cancelarServicio(Request $request)
    {
        $comment = Comment::create([
            'service_id' => $request->service_id,
            'comment_type_id' => 3,
            'comment' => $request->comment

        ]);
        $service = Service::findOrFail($request->service_id);
        Mensaje::create([
            'service_id' => $service->id,
            'emisor_id' => $service->technical_id,
            'receptor_id' => $service->manager_id,
            'mensaje' => 'Ha solicitado cancelar el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
            'icon' => 'icon-bin',
            'color' => 'red'
        ]);
        $notificacion = new NotificationController();
            $notificacion->sendMensaje(
                'user_channel_'.$service->manager_id,
                'mensaje_push',
                [
                    'cliente' => $service->customer['code'],
                    'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                    'mensaje' => 'Ha solicitado cancelar el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            );
            return ['error' => 0 , 'msg' => 'La solicitud se envió con éxito'];
    }
    public function getRate(Request $request)
    {
        return Service::findOrFail($request->service_id); 
    }
    public function rateService(Request $request)
    {
        $service = Service::findOrFail($request->service_id);
        $service->rate = $request->rate;
        $service->rate_comment = $request->rate_comment;
        if($service->save())
        return "Calificación agregada!";
        else return "Error al agregar calificación.";
    }
}
