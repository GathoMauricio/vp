<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Comment;
use App\Mensaje;
use Redirect;
use Auth;
use Purifier;
use App\Http\Controllers\NotificationController;

class CommentController extends Controller
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
        //Obtener el servicio actual 
        $service = Service::findOrfail($request->service_id);
        //Obtener technical y manager
        //si el technical es igual al usuario logeado el emisor es technical y receptor es manager
        if(Auth::user()->id == $service->technical_id)
        {
            //Insertar el comentario
            $comment = Comment::create($request->all());
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->technical_id,
                'receptor_id' => $service->manager_id,
                'mensaje' => Purifier::clean(Input::get('Ha comentado el servicio de <span style="font-weight: bold;">'.$service->customer['code'].'</span> con folio: '.$service->service_report)),
                'icon' => 'icon-bubbles4',
                'color' => '#2ECC71'
            ]);
            //Crear notificación
            $notificacion = new NotificationController();
            //Pasar el canal del receptor, el evento y el mensaje
            $notificacion->sendMensaje(
                'user_channel_'.$service->manager_id,
                'mensaje_push',
                [
                    'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                    'mensaje' => Purifier::clean(Input::get('Ha comentado el servicio de <span style="font-weight: bold;">'.$service->customer['code'].'</span> con folio: '.$service->service_report)),
                    'timestamp' => date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') 
                ]
            );
            sendFcm($service->manager['fcm_token'],"Nuevo comentario","Servicio de ".$service->customer['code'],$service->id);
        }
        //si el manager es igual al usuario logeado el emisor es manager y receptor es technical
        if(Auth::user()->id == $service->manager_id)
        {
            //Insertar el comentario
            $comment = Comment::create($request->all());
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->manager_id,
                'receptor_id' => $service->technical_id,
                'mensaje' => Purifier::clean(Input::get('Ha comentado el servicio de <span style="font-weight: bold;">'.$service->customer['code'].'</span> con folio: '.$service->service_report)),
                'icon' => 'icon-bubbles4',
                'color' => '#2ECC71'
            ]);
            //Crear notificación
            $notificacion = new NotificationController();
            //Pasar el canal del receptor, el evento y el mensaje
            $notificacion->sendMensaje(
                'user_channel_'.$service->technical_id,
                'mensaje_push',
                [
                    'emisor' => $service->manager['name'].' '.$service->manager['last_name1'],
                    'mensaje' => Purifier::clean(Input::get('Ha comentado el servicio de <span style="font-weight: bold;">'.$service->customer['code'].'</span> con folio '.$service->service_report)),
                    'timestamp' => date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A')
                ]
            );
            sendFcm($service->technical['fcm_token'],"Nuevo comentario","Servicio de ".$service->customer['code'],$service->id);
        }
        //Regresar al la vista del servicio (show_service)
        return Redirect::back();
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
