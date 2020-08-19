@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    @if($errors->has('file')) 
    <p class="bg-danger" style="padding:5px;color:white;">
        {{ $errors->first('file') }}
    </p>
    @endif
    @if($errors->has('descrption')) 
    <p class="bg-danger" style="padding:5px;color:white;">
        {{ $errors->first('descrption') }}
    </p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <h4>
                            Detalles del servicio {{ $service->service_report }} - 
                            Prioridad 
                            @if($service->priority == 'Alta')
                            <span style="color:#2ECC71;" class="font-weight-bold">{{ $service->priority }}</span>
                            @endif
                            @if($service->priority == 'Normal')
                            <span style="color:#2E86C1;" class="font-weight-bold">{{ $service->priority }}</span>
                            @endif
                            @if($service->priority == 'Baja')
                            <span style="color:#F1C40F;" class="font-weight-bold">{{ $service->priority }}</span>
                            @endif
                        </h4> 
                    </div>
                </div>
                <div class="col-md-12 py-4">
                    @if($service->status['status_service'] == 'Pendiente')
                    <span class="bg-secondary" style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,1]) }}" style="color:blue;"><span class="icon icon-share"></span> Iniciar servicio</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,2]) }}" style="color:orange;"><span class="icon icon-clock"></span> Solicitar reagendar</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,3]) }}" style="color:red;"><span class="icon icon-bin"></span> Solicitar cancelar</a>
                    @endif
                    @if($service->status['status_service'] == 'En proceso')
                    <span class="bg-warning" style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    &nbsp;&nbsp;&nbsp;
                    @if(count($files) <= 0)
                    <a href="#" onclick="swal('Alto!','No es posible finalizar un servicio sin agregar evidencia','warning');" style="color:green;"><span class="icon icon-checkmark"></span> finalizar servicio</a>
                    @else
                    <a href="{{ route('edit_status_service',[$service->id,4]) }}" style="color:green;"><span class="icon icon-checkmark"></span> finalizar servicio</a>
                    @endif
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,2]) }}" style="color:orange;"><span class="icon icon-clock"></span> Solicitar reagendar</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,3]) }}" style="color:red;"><span class="icon icon-bin"></span> Solicitar cancelar</a>
                    @endif
                    @if($service->status['status_service'] == 'Finalizado' || $service->status_service_id >= 6)
                    <span class="bg-success" style="padding:5px;border-radius:5px;">Finalizado</span>
                    @endif
                    @if (getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                    <br><br>
                        @if($service->status['status_service'] == 'Finalizado')
                            <a href="{{ route('edit_status_service',[$service->id,6]) }}" style="color:green;"><span class="icon icon-checkmark"></span> Cambiar a pendiente por pagar (PPP)</a>
                            &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'PPP')
                            <a href="{{ route('edit_status_service',[$service->id,7]) }}" style="color:green;"><span class="icon icon-checkmark"></span> Cambiar a procesando pago (EP)</a>
                            &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'EP')
                            <a href="{{ route('edit_status_service',[$service->id,8]) }}" style="color:green;"><span class="icon icon-checkmark"></span> Cambiar a cerrado (CR)</a>
                            &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'CR')
                            <span class="bg-primary" style="padding:5px;border-radius:5px;">Servicio cerrado ({{ $service->status['status_service'] }})</span>
                            &nbsp;&nbsp;&nbsp;
                        @endif
                    @endif
                     @if($service->status['status_service'] == 'Re-agendado')
                    <span class="bg-primary" style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    @endif
                    @if($service->status['status_service'] == 'Cancelado')
                    <span class="bg-danger" style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    @endif
                        
                    
                    <a href="{{ route('formato_pdf_servicio',$service->id) }}" style="float:right;" class="btn btn-primary"><span class="icon icon-file-pdf"></span> Imprimir formato</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Cliente/Razón social</label>
                    <br>
                    {{ $service->customer['name'] }} - [{{ $service->customer['code'] }}]
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Usuario final</label>
                    <br>
                    {{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }} {{ $service->usuario_Final['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Tipo de servicio</label>
                    <br>
                    {{ $service->service_type['service_type'] }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">E-Mail de contacto</label>
                    <br>
                    {{ $service->usuario_Final['email'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Teléfono de contacto</label>
                    <br>
                    {{ $service->usuario_Final['phone'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Dirección de contacto</label>
                    <br>
                    {{ $service->usuario_Final['calle_numero'] }} 
                    {{ $service->usuario_Final['asentamiento'] }}, 
                    {{ $service->usuario_Final['cp'] }} 
                    {{ $service->usuario_Final['ciudad'] }} 
                    {{ $service->usuario_Final['municipio'] }} 
                    {{ $service->usuario_Final['estado'] }} 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Mesa de ayuda</label>
                    <br>
                    {{ $service->manager['name'] }} {{ $service->manager['last_name1'] }} {{ $service->manager['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Empleado asignado</label>
                    <br>
                    {{ $service->technical['name'] }} {{ $service->technical['last_name1'] }} {{ $service->technical['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Fecha de asignación</label>
                    <br>
                    {{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Descripción</label>
                    <br>
                    {{ $service->description }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Solución</label>
                    <br>
                    @if(@empty($service->solution))
                    Pendiente
                    @else
                    {{ $service->solution }}
                    @endif
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Observación</label>
                    <br>
                    {{ $service['observations'] }}
                </div>
            </div>
            <div class="row">
                @if(!empty($service['firm']))
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Firma usuario final</label>
                    <br>
                    <img src="{{ env('APP_URL').'/public/storage'.'/'.$service['firm'] }}" wicth="120" height="120">
                </div>
                @endif
            </div>
            <div class="row">
                @if(!empty($service->init_service))
                <div class="col-md-4">
                    Servicio iniciado: {{ date_format(new \DateTime($service->init_service), 'd-m-Y g:i A') }}
                </div>
                @endif
                @if(!empty($service->end_service))
                <div class="col-md-4">
                    Servicio finalizado: {{ date_format(new \DateTime($service->end_service), 'd-m-Y g:i A') }}
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small style="color:#154360;">
                        <b>
                            Este sercivio fue creado el {{ date_format(new \DateTime($service->created_at), 'd-m-Y g:i A') }} 
                            y actualizado por última vez el {{ date_format(new \DateTime($service->updated_at), 'd-m-Y g:i A') }}
                        </b>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Alta de productos</h4>
                </div>
            </div>
            <form action="{{ route('store_producto') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="equipo_refaccion" class="font-weight-bold">Equipo/Refacción</label>
                            <input name="equipo_refaccion" type="text" class="form-control">
                            @if($errors->has('equipo_refaccion')) 
                            <small
                            style="color:red">{{ $errors->first('equipo_refaccion') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="marca" class="font-weight-bold">Marca</label>
                            <input name="marca" type="text" class="form-control">
                            @if($errors->has('marca')) 
                            <small
                            style="color:red">{{ $errors->first('marca') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="modelo" class="font-weight-bold">Modelo</label>
                            <input name="modelo" type="text" class="form-control">
                            @if($errors->has('modelo')) 
                            <small
                            style="color:red">{{ $errors->first('modelo') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="serie" class="font-weight-bold">Serie</label>
                            <input name="serie" type="text" class="form-control">
                            @if($errors->has('serie')) 
                            <small
                            style="color:red">{{ $errors->first('serie') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="otro" class="font-weight-bold">Otro</label>
                            <input name="otro" type="text" class="form-control">
                            @if($errors->has('otro')) 
                            <small
                            style="color:red">{{ $errors->first('otro') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" class="font-weight-bold"></label>
                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-dark">
                        <tr>
                            <th>Equipo/Refaccion</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Otro</th>
                        </tr>
                        @php $productos = \App\Producto::where('service_id',$service->id)->get(); @endphp
                        @if(count($productos) <= 0)
                        <tr><td colspan="5"><center>No se han agregado productos</center></td></tr>
                        @endif
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->equipo_refaccion }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>{{ $producto->modelo }}</td>
                            <td>{{ $producto->serie }}</td>
                            <td>{{ $producto->otro }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Alta de evidencia</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="float-right">
                        <form id="frm_subir_archivo" method="POST" action="{{ route('subir_archivo',$service->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="file" name="file" class="btn btn-primary">
                            <textarea name="description" class="form-control" placeholder="Ingrese una descripción des archivo..."></textarea>
                            @if($errors->has('description')) <small
                                style="color:red">{{ $errors->first('description') }}</small>@endif
                            <br>
                            <input  type="submit" value="Subir archivo" class="btn btn-primary float-right">
                        </form>
                        
                    </div>
                </div>
            </div>
            <div class="row" style="padding:10px;">
                @if(count($files) <= 0)
                <div class="col-md-12 text-align-center">
                    No se han agregado archivos
                    <br>
                    <small style="color: orange;">Se debe agregar por lo menos una evidencia para poder cerrar un servicio</small>
                </div>
                @endif
                @foreach($files as $file)
                <div class="col-md-3" style="padding:10px;">
                    <a href="{{ asset('storage/') }}/{{ $file->route }}" target="_new"><img src="{{ asset('storage/') }}/{{ $file->route }}" width="120" height="120"></a>
                    <br>
                    Subido por:
                    <br>
                    {{ $file->user['name'] }} {{ $file->user['last_name1'] }} {{ $file->user['last_name2']}}
                    <br>
                    {{ $file->description }}
                    <br>
                    {{ date_format(new \DateTime($file->created_at), 'd-m-Y g:i A') }} 
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Comentarios</h4>
                    </div>
                </div>
                <div class="col-md-12">
                    <form action="{{ route('store_comment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="comment_type_id" value="1">
                        <table style="width:100%;">
                            <tr>
                                <td width="95%"><input type="text" name="comment" class="form-control" placeholder="Escriba aquí..." required></td>
                                <td width="5%"><input type="image" src="{{ asset('img/send.png') }}" width="80" height="60"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($comments) <= 0)
                    <center>No se han agregado comentarios a este servicio</center>
                    @endif
                    @foreach($comments as $comment)
                    <div class="comment-item">
                        @if($comment->type['comment_type']=='Bitácora')
                        <span style="color:white;padding:5px;" class="float-right bg-primary font-weight-bold" >
                            {{ $comment->type['comment_type'] }}
                        </span>
                        @endif
                        @if($comment->type['comment_type']=='Reagendar')
                        <span class="float-right bg-warning font-weight-bold" style="padding:5px;">
                            @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                            <a style="color:white" href="#" class="font-weight-bold">{{ $comment->type['comment_type'] }}</a>
                            @else
                            {{ $comment->type['comment_type'] }}
                            @endif
                        </span>
                        @endif
                        @if($comment->type['comment_type']=='Cancelar')
                        <span class="float-right bg-danger font-weight-bold" style="padding:5px;">
                            @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                            <a style="color:white" href="#" class="font-weight-bold">{{ $comment->type['comment_type'] }}</a>
                            @else
                            {{ $comment->type['comment_type'] }}
                            @endif
                        </span>
                        @endif
                        <label class="font-weight-bold" style="color:#154360;">
                            {{ $comment->user['name'] }} {{ $comment->user['last_name1'] }} {{ $comment->user['last_name2'] }}
                        </label>
                        <br>
                        {{ $comment->comment }}
                        <br>
                        <span class="float-right">{{ date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') }}</span>
                        <br>
                    </div>
                    <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    -->
</div>
@endsection
@include('services.comment_box')