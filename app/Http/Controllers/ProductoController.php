<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Http\Requests\ProductoRequest;
use App\Service;
use App\Mensaje;
use App\Http\Controllers\NotificationController;

class ProductoController extends Controller
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
    public function store(ProductoRequest $request)
    {
        $producto = Producto::create($request->all());
        if ($producto) {
            $service = Service::where('id', $producto->service_id)->first();
            Mensaje::create([
                'service_id' => $service->id,
                'emisor_id' => $service->manager_id,
                'receptor_id' => $service->technical_id,
                'mensaje' => 'Ha añadido un producto en el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                'icon' => 'icon-drive',
                'color' => '#2ECC71'
            ]);
            $notificacion = new NotificationController();
                $notificacion->sendMensaje(
                    'user_channel_'.$service->technical_id,
                    'mensaje_push',
                    [
                        'cliente' => $service->customer['code'],
                        'emisor' => $service->manager['name'].' '.$service->manager['last_name1'],
                        'mensaje' => 'Ha añadido un producto en el servicio de '.$service->customer['code'].' con folio '.$service->service_report,
                        'timestamp' => date('Y-m-d H:i:s')
                    ]
                );
            return redirect('show_service/' . $producto->service_id)->with('mensaje', 'El producto se agregó con éxito.');
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
