<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Comment;
use App\Mensaje;
use App\Http\Controllers\NotificationController;
use Auth;

class BitacoraController extends Controller
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
        $comment = Comment::create($request->all());
        $service = Service::findOrFail($request->service_id);
        if(Auth::user()->id == $service->technical_id)
        {
            
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->technical_id,
                'receptor_id' => $service->manager_id,
                'mensaje' => 'Ha comentado el servicio de '.$service->customer['code'].' con folio: '.$service->service_report,
                'icon' => 'icon-bubbles4',
                'color' => '#2ECC71'
            ]);
        }
        if(Auth::user()->id == $service->manager_id)
        {
            
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->manager_id,
                'receptor_id' => $service->technical_id,
                'mensaje' => 'Ha comentado el servicio de '.$service->customer['code'].' con folio: '.$service->service_report,
                'icon' => 'icon-bubbles4',
                'color' => '#2ECC71'
            ]);
        }
        //Crear notificación
        $notificacion = new NotificationController();
        //Pasar el canal del receptor, el evento y el mensaje
        $notificacion->sendMensaje(
            'user_channel_'.$service->technical_id,
            'mensaje_push',
            [
                'auth'=>Auth::user()->id,
                'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                'mensaje' => 'Ha comentado el servicio de '.$service->customer['code'].' con folio: '.$service->service_report,
                'timestamp' => date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') 
            ]
        );
        $notificacion->sendMensaje(
            'user_channel_'.$service->manager_id,
            'mensaje_push',
            [
                'auth'=>Auth::user()->id,
                'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                'mensaje' => 'Ha comentado el servicio de '.$service->customer['code'].' con folio: '.$service->service_report,
                'timestamp' => date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') 
            ]
        );


        


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

    public function getBitacoraAjax(Request $request)
    {
        $comments = Comment::where('service_id', $request->id)->orderBy('created_at', 'ASC')->get();
        $html='';
        foreach($comments as $comment)
        {
            $html.='<div class="comment-item">';
            if($comment->type['comment_type']=='Bitácora')
            {
                $html.='<span style="color:white;padding:5px;" class="float-right bg-primary font-weight-bold" >
                            '.$comment->type['comment_type'].'
                        </span>';
            }
            if($comment->type['comment_type']=='Reagendar')
            {
                $html.='<span class="float-right bg-warning font-weight-bold" style="padding:5px;">';
                if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                {
                    $html.='<a style="color:white" href="#" class="font-weight-bold">'.$comment->type['comment_type'].'</a>';
                }else{
                    $html.=$comment->type['comment_type'];
                }
                $html.='</span>';
            }
            if($comment->type['comment_type']=='Cancelar')
            {
                $html.='<span class="float-right bg-danger font-weight-bold" style="padding:5px;">';
                if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                {
                    $html.='<a style="color:white" href="#" class="font-weight-bold">'.$comment->type['comment_type'].'</a>';
                }else{
                    $html.=$comment->type['comment_type'];
                }
                $html.='</span>';
            }
            $html.='<label class="font-weight-bold" style="color:#154360;">
                    '.$comment->user['name'].' '.$comment->user['last_name1'].' '.$comment->user['last_name2'].'
                    </label>
                    <br>';
            $html.=$comment->comment;
            $html.='<br>
                    <span class="float-right">'.date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A').'</span>
                    <br>
                </div>
                <br>';
            
        }
        return [
            'html' => $html
        ];
    }
}
