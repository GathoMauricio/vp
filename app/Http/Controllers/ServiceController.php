<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRol;
use App\Customer;
use App\Service;
use App\ServiceType;
use App\Comment;
use App\Mensaje;
use App\File;
use App\Http\Requests\ServiceRequest;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\NotificationController;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (getRoles()['rol_admin']) {
            $services = Service::whereDate('schedule', Carbon::today())->
                paginate(15);
            return view('services/index_service', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de administrador por lo tanto se muestran todos los servicios existentes.']);
        }
        if (getRoles()['rol_mesa'] && getRoles()['rol_tec']) {
            $services = Service::whereDate('schedule', Carbon::today())->where('manager_id', Auth::user()->id)
                ->orWhere('technical_id', Auth::user()->id)
                ->paginate(15);
            return view('services/index_service', ['services' => $services, 'desc' => 'Este perfil cuenta tanto con rol de mesa de ayuda como de técnico se muestran tanto los servicios levantados como asignanos a este usuario.']);
        }
        if (getRoles()['rol_mesa']) {
            $services = Service::whereDate('schedule', Carbon::today())->where('manager_id', Auth::user()->id)->paginate(15);
            return view('services/index_service', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de mesa de ayuda por lo tanto se muestran los servicios que haya levantado este usuario.']);
        }
        if (getRoles()['rol_tec']) {
            $services = Service::whereDate('schedule', Carbon::today())->where('technical_id', Auth::user()->id)->paginate(15);
            return view('services/index_service', ['services' => $services, 'desc' => 'Este perfil cuenta con rol de técnico por lo tanto se muestran los servicios asignados a este usuario.']);
        }
        $services = Service::whereDate('schedule', Carbon::today())->where('technical_id', 0)->paginate(15);
        return view('services/index_service', ['services' => $services, 'desc' => 'Este perfil no cuenta con ningun rol verifique con el administrador.']);
    }

    function searchService(Request $request)
    {
        $consulta = (new Service)->newQuery();
        $consulta->when(!empty($request->date1) && !empty($request->date2), function ($query) use ($request) {
			return $query->whereBetween('schedule', [$request->date1.' 00:00:00', $request->date2.' 23:59:59']);
        });
        $consulta->when(!empty($request->customer_id), function ($query) use ($request) {
			return $query->where('customer_id',$request->customer_id);
		});
        $consulta->when(!empty($request->final_user_id), function ($query) use ($request) {
			return $query->where('final_user_id',$request->final_user_id);
        });
        if (getRoles()['rol_admin']) {
            //Sin condición
            $consulta->orderBy('schedule','desc');
            $consulta
            ->with('customer');
            return view('services.result_search_service',['services' => $consulta->get()]);
        }
        if (getRoles()['rol_mesa'] && getRoles()['rol_tec']) {
            $consulta
            ->where('manager_id', Auth::user()->id)
            ->orWhere('technical_id', Auth::user()->id);
            $consulta->orderBy('schedule','desc');
            $consulta
            ->with('customer');
            return view('services.result_search_service',['services' => $consulta->get()]);
        }
        if (getRoles()['rol_mesa']) {
            $consulta
            ->where('manager_id', Auth::user()->id);
            $consulta->orderBy('schedule','desc');
            $consulta
            ->with('customer');
            return view('services.result_search_service',['services' => $consulta->get()]);
        }
        if (getRoles()['rol_tec']) {
            $consulta
            ->where('technical_id', Auth::user()->id);
            $consulta->orderBy('schedule','desc');
            $consulta
            ->with('customer');
            return view('services.result_search_service',['services' => $consulta->get()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $servicesTypes = ServiceType::all();
        //$technicals = User::where('user_type_id',3)->get();//El id 3 son los técnicos
        //$technicals = User::all();
        $customers = Customer::all();
        return view(
            'services/create_service',
            [
                'servicesTypes' => $servicesTypes,
                //'technicals' => $technicals,
                'customers' => $customers
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        //return dd($request);
        $service = Service::create(
            $request->all() +
                [
                    'service_report' => 'VP/' . date('mdHis'),
                    'schedule' => $request->schedule_fecha . ' ' . $request->schedule_hora . ':00'
                ]
        );
        if ($service) {
            Mensaje::create([
                    'service_id' => $service->id,
                    'emisor_id' => $service->manager_id,
                    'receptor_id' => $service->technical_id,
                    'mensaje' => 'Te ha asignano el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'icon' => 'icon-file-text',
                    'color' => '#A569BD'
                ]);
                $notificacion = new NotificationController();
                    $notificacion->sendMensaje(
                        'user_channel_'.$service->technical_id,
                        'mensaje_push',
                        [
                            'cliente' => $service->customer['code'],
                            'emisor' => $service->manager['name'].' '.$service->manager['last_name1'],
                            'mensaje' => 'Te ha asignado el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                            'timestamp' => date('Y-m-d H:i:s')
                        ]
                    );
            return redirect('show_service/' . $service->id)->with('mensaje', 'El servicio se creó con éxito.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        $comments = Comment::where('service_id', $id)->orderBy('created_at', 'desc')->get();
        $files = File::where('service_id', $id)->get();
        return view('services/show_service', [
            'service' => $service,
            'comments' => $comments,
            'files' => $files
        ]);
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

    public function loadEmployees(Request $request)
    {
        if (!empty($request->value)) {
            $empleados = DB::select("
            SELECT * FROM users u LEFT JOIN users_roles ur 
            ON u.id = ur.user_id 
            LEFT JOIN roles r 
            ON r.id = ur.rol_id 
            WHERE r.id = '$request->value'
            ");
            $html = "<option value>--Seleccione una opción--</option>";
            for ($i = 0; $i < count($empleados); $i++) {
                $html .= "<option value='" . $empleados[$i]->user_id . "'>" . $empleados[$i]->name . " " . $empleados[$i]->last_name1 . " " . $empleados[$i]->last_name2 . "</option>";
            }
            return $html;
        } else {
            return "<option value>--Seleccione una opción--</option>";
        }
    }

    public function loadFinalUsers(Request $request)
    {
        if (!empty($request->value)) {
            $finalUsers = DB::select("
            SELECT * FROM final_users WHERE customer_id = " . $request->value . "
            ");
            $html = "<option value>--Seleccione una opción--</option>";
            for ($i = 0; $i < count($finalUsers); $i++) {
                $html .= "<option value='" . $finalUsers[$i]->id . "'>" . $finalUsers[$i]->name . " " . $finalUsers[$i]->last_name1 . " " . $finalUsers[$i]->last_name2 . "</option>";
            }
            return $html;
        } else {
            return "<option value>--Seleccione una opción--</option>";
        }
    }
    public function printSErviceFormat(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $pdf = \PDF::loadView('pdf.servicio', ['service' => $service]);
        return $pdf->download($service->customer['code'].'_' . $service->service_report . '.pdf');
    }
    public function editStatusService(Request $request, $id, $status)
    {
        switch ($status) {
            case 1: //iniciar servicio
                return view('services.init_service', ['service_id' => $id, 'status' => $status]);
                break;
            case 2: //reagendar servicio
                return view('services.reschedule_service', ['service_id' => $id, 'status' => $status]);
                break;
            case 3: //cancelar servicio
                return view('services.cancel_service', ['service_id' => $id, 'status' => $status]);
                break;
            case 4: //finalizar servicio
                return view('services.success_service', ['service_id' => $id, 'status' => $status]);
                break;
            case 6:
                $service = Service::findOrFail($id);
                $service->status_service_id = $status;
                $service->save();
                return redirect('show_service/' . $id)->with('mensaje', 'El servicio ha pasado a pendiente por pagar.');
                break;
            case 7:
                $service = Service::findOrFail($id);
                $service->status_service_id = $status;
                $service->save();
                return redirect('show_service/' . $id)->with('mensaje', 'El servicio se encuentra en proceso de pago.');
                break;
            case 8:
                $service = Service::findOrFail($id);
                $service->status_service_id = $status;
                $service->save();
                return redirect('show_service/' . $id)->with('mensaje', 'El servicio se ha sido cerado.');
                break;
        }
    }
    public function updateStatusService(Request $request)
    {
        #Se pretende que cada movimiento sea notificado de forma inmediata a sus respectivos usuarios
        switch ($request->status) {
                //Iniciar el servicio pasandolo a en proceso
            case 1:
                if ($request->comment != null) {
                    $comment = Comment::create([
                        'service_id' => $request->service_id,
                        'comment_type_id' => $request->comment_type_id,
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
                        return redirect('show_service/' . $service->id)->with('mensaje', 'El servicio se inició con éxito.');
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
                    return redirect('show_service/' . $service->id)->with('mensaje', 'El servicio se inició con éxito.');
                }
                break;
            case 2:
                $comment = Comment::create([
                    'service_id' => $request->service_id,
                    'comment_type_id' => $request->comment_type_id,
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
                return redirect('show_service/' . $request->service_id)->with('mensaje', 'Su solicitud se ha enviado con éxito.');
                break;
            case 3:
                $comment = Comment::create([
                    'service_id' => $request->service_id,
                    'comment_type_id' => $request->comment_type_id,
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
                return redirect('show_service/' . $request->service_id)->with('mensaje', 'Su solicitud se ha enviado con éxito.');
                break;
                //finaliza un servicio guardano la retroalimentación y las evidencias
            case 4:
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
                return redirect('show_service/' . $service->id)->with('mensaje', 'El servicio se finalizó con éxito.');
                break;
        }
    }
    public function uploadFile(ImageRequest $request)
    {
        
        //obtenemos el campo file definido en el formulario
        $file = $request->file('file');
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
            $service = Service::findOrFail($request->service_id);
                Mensaje::create([
                    'service_id' => $service->id,
                    'emisor_id' => $service->technical_id,
                    'receptor_id' => $service->manager_id,
                    'mensaje' => 'Ha agregado evidencia en el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                    'icon' => 'icon-image',
                    'color' => '#A569BD'
                ]);
                $notificacion = new NotificationController();
                    $notificacion->sendMensaje(
                        'user_channel_'.$service->manager_id,
                        'mensaje_push',
                        [
                            'cliente' => $service->customer['code'],
                            'emisor' => $service->technical['name'].' '.$service->technical['last_name1'],
                            'mensaje' => 'Ha agregado evidencia en el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                            'timestamp' => date('Y-m-d H:i:s')
                        ]
                    );
            return redirect('show_service/' . $request->service_id)->with('mensaje', 'El archivo se almacenó con éxito.');
        }
            
            
    }
    public function indexAjax()
    {
        if (getRoles()['rol_admin']) {
            $services = Service::with('customer')->get();
            return $services;
        }
        if (getRoles()['rol_mesa'] && getRoles()['rol_tec']) {
            $services = Service::where('manager_id', Auth::user()->id)
                ->orWhere('technical_id', Auth::user()->id)
                ->with('customer')
                ->get();
            return $services;
        }
        if (getRoles()['rol_mesa']) {
            $services = Service::where('manager_id', Auth::user()->id)
            ->with('customer')
            ->get();
            return $services;
        }
        if (getRoles()['rol_tec']) {
            $services = Service::where('technical_id', Auth::user()->id)
            ->with('customer')
            ->get();
            return $services;
        }
    }
}
