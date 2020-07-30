<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Mensaje;
use App\Service;
use Auth;
class NotificationController extends Controller
{
    public function sendMensaje($canal,$evento,$mensaje)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'), 
            env('PUSHER_APP_SECRET'), 
            env('PUSHER_APP_ID'), 
            array(
                'cluster'=>env('PUSHER_APP_CLUSTER')
            ));
        return $pusher->trigger($canal,$evento,$mensaje);
    }
    public function openMessage(Request $request, $id, $service_id)
    {
        $servicio = Service::findOrFail($service_id);
        $mensaje = Mensaje::findOrFail($id);
        $mensaje->leido = 'SI';
        $mensaje->save();
        return redirect('show_service/'.$servicio->id);
    }
    public function cargarMensajesPush(Request $request)
    {
        $contador = count(Mensaje::where('receptor_id',Auth::user()->id)->where('leido','NO')->get());
        $mensajes = Mensaje::where('receptor_id',Auth::user()->id)->orderBy('id','desc')->limit(5)->get();
        $html = '';
        foreach($mensajes as $mensaje)
        {
            if($mensaje->leido == 'NO')
            {
                $html.='<a style="background-color:#85C1E9;" class="dropdown-item" href="'.route('open_message',[$mensaje->id,$mensaje->service_id]).'">
                            <span class="icon '.$mensaje->icon.'" style="color:'.$mensaje->color.'"></span>
                            <label class="font-weight-bold">'.$mensaje->emisor['name'].' '.$mensaje->emisor['last_name1'].'</label> '.$mensaje->mensaje.'
                            <br>
                            <span class="float-right" style="color:white;">'.date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A').'</span>
                            <br>
                        </a>';
            }else{
                $html.='<a class="dropdown-item" href="'.route('open_message',[$mensaje->id,$mensaje->service_id]).'">
                            <span class="icon '.$mensaje->icon.'" style="color:'.$mensaje->color.'"></span>
                            <label class="font-weight-bold">'.$mensaje->emisor['name'].' '.$mensaje->emisor['last_name1'].'</label> '.$mensaje->mensaje.'
                            <br>
                            <span class="float-right" style="color:#2E86C1;">'.date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A').'</span>
                            <br>
                        </a>';
            }
            
        }
        return [
            'contador' => $contador,
            'html' => $html
        ];
    }
}
