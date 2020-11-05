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
                    <div class="col-md-12 py-1" style="background-color: #EAECEE">
                        @if(!empty($service->rate))
                        <div class="float-right">
                            <h5>{{ $service->rate }} <span class="icon-star-full" style="color:#F1C40F;"></span></h5>
                            {{ $service->rate_comment }}
                        </div>
                        @endif
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
                    <span class="bg-secondary"
                        style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,1]) }}" style="color:blue;"><span
                            class="icon icon-share"></span> Iniciar servicio</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,2]) }}" style="color:orange;"><span
                            class="icon icon-clock"></span> Solicitar reagendar</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="{{ route('edit_status_service',[$service->id,3]) }}" style="color:red;"><span
                            class="icon icon-bin"></span> Solicitar cancelar</a>
                    @endif
                    @if($service->status['status_service'] == 'En proceso')
                    <span class="bg-warning"
                        style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    &nbsp;&nbsp;&nbsp;
                    @if(count($files) <= 0) <a href="#"
                        onclick="swal('Alto!','No es posible finalizar un servicio sin agregar evidencia','warning');"
                        style="color:green;"><span class="icon icon-checkmark"></span> finalizar servicio</a>
                        @else
                        <a href="{{ route('edit_status_service',[$service->id,4]) }}" style="color:green;"><span
                                class="icon icon-checkmark"></span> finalizar servicio</a>
                        @endif
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ route('edit_status_service',[$service->id,2]) }}" style="color:orange;"><span
                                class="icon icon-clock"></span> Solicitar reagendar</a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ route('edit_status_service',[$service->id,3]) }}" style="color:red;"><span
                                class="icon icon-bin"></span> Solicitar cancelar</a>
                        @endif
                        @if($service->status['status_service'] == 'Finalizado' || $service->status_service_id >= 6)
                        <span class="bg-success" style="padding:5px;border-radius:5px;">Finalizado</span>
                        @endif
                        @if (getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                        <br><br>
                        @if($service->status['status_service'] == 'Finalizado')
                        <a href="{{ route('edit_status_service',[$service->id,6]) }}" style="color:green;"><span
                                class="icon icon-checkmark"></span> Cambiar a pendiente por pagar (PPP)</a>
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'PPP')
                        <a href="{{ route('edit_status_service',[$service->id,7]) }}" style="color:green;"><span
                                class="icon icon-checkmark"></span> Cambiar a procesando pago (EP)</a>
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'EP')
                        <form action="{{ route('edit_status_service',[$service->id,8]) }}">
                            <table>
                                <tr>
                                    <td>
                                        <label for="" class="font-weight-bold">Método de pago</label>
                                        <select name="payment" class="form-control">
                                            <option value="Transferencia">Transferencia</option>
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><button style="color:green;"><span class="icon icon-checkmark"></span> Cambiar a
                                            cerrado (CR)</button></td>
                                </tr>
                            </table>
                        </form>
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        @if($service->status['status_service'] == 'CR')
                        <span class="bg-primary" style="padding:5px;border-radius:5px;">Servicio cerrado
                            ({{ $service->status['status_service'] }})</span>
                        &nbsp;&nbsp;&nbsp;
                        @endif
                        @endif
                        @if($service->status['status_service'] == 'Re-agendado')
                        <span class="bg-primary"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                        @if($service->status['status_service'] == 'Cancelado')
                        <span class="bg-danger"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif


                        <a href="{{ route('formato_pdf_servicio',$service->id) }}" target="_blank" style="float:right;"
                            class="btn btn-primary"><span class="icon icon-file-pdf"></span> Imprimir formato</a>
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
                    {{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }}
                    {{ $service->usuario_Final['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Tipo de servicio</label>
                    <br>
                    {{ $service->service_type['service_type'] }}
                </div>
                <div class="col-md-12"><hr></div>
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
                <div class="col-md-12"><hr></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Mesa de ayuda</label>
                    <br>
                    {{ $service->manager['name'] }} {{ $service->manager['last_name1'] }}
                    {{ $service->manager['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Técnico asignado</label>
                    <br>
                    {{ $service->technical['name'] }} {{ $service->technical['last_name1'] }}
                    {{ $service->technical['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Fecha y hora de asignación</label>
                    <br>
                    {{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}
                </div>
                <div class="col-md-12"><hr></div>
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
                <div class="col-md-12"><hr></div>
            </div>
            <div class="row">
                @if(!empty($service['firm']))
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Firma usuario final</label>
                    <br>
                    <img src="{{ env('APP_URL').'/public/storage'.'/'.$service['firm'] }}" wicth="120" height="120">
                </div>
                @endif
                @if(!empty($service['firm2']))
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Firma encargado</label>
                    <br>
                    <img src="{{ env('APP_URL').'/public/storage'.'/'.$service['firm2'] }}" wicth="120" height="120">
                </div>
                @endif
                @if (getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                    @if(!empty($service['payment']))
                    <div class="col-md-4">
                        <label for="" class="font-weight-bold">Método de pago</label>
                        <br>
                        {{ $service['payment'] }}
                    </div>
                    @else
                    <div class="col-md-4">
                    <label for="" class="font-weight-bold">Método de pago</label>
                        <br>
                        No definido aún
                    </div>
                    @endif
                @endif
                <div class="col-md-12"><hr></div>
            </div>
            <div class="row">
                @if(!empty($service->init_service))
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Servicio iniciado:</label> {{ date_format(new \DateTime($service->init_service), 'd-m-Y g:i A') }}
                </div>
                @endif
                @if(!empty($service->end_service))
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Servicio finalizado:</label> {{ date_format(new \DateTime($service->end_service), 'd-m-Y g:i A') }}
                </div>
                @endif
                <div class="col-md-12"><hr></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small style="color:#154360;">
                        <b>
                            Este sercivio fue creado el
                            {{ date_format(new \DateTime($service->created_at), 'd-m-Y g:i A') }}
                            y actualizado por última vez el
                            {{ date_format(new \DateTime($service->updated_at), 'd-m-Y g:i A') }}
                            <a href="{{ route('confirm_service',$service->id) }}" style="color:red;">[Eliminar servicio]</a>
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
                    <h4>Reemplazo de equipo producto y accesorios</h4>
                </div>
            </div>
            <form action="{{ route('store_reemplazo') }}" method="POST">
                @csrf
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reemplazo" class="font-weight-bold">Reemplazo</label>
                                <input name="reemplazo" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marca" class="font-weight-bold">Marca</label>
                                <input name="marca" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="modelo" class="font-weight-bold">Modelo</label>
                                <input name="modelo" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serie" class="font-weight-bold">Serie</label>
                                <input name="serie" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="otro" class="font-weight-bold">Otro</label>
                                <input name="otro" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="costo" class="font-weight-bold">Costo</label>
                                <input name="costo" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary btn-block" value="Agregar reemplazo">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Reemplazo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Serie</th>
                            <th>Otro</th>
                            <th>Costo</th>
                            <th>Firma</th>
                        </tr>
                        @php $reemplazos = \App\Reemplazo::where('service_id',$service->id)->get(); @endphp
                        @if(count($reemplazos) <= 0) <tr>
                            <td colspan="7">
                                <center>No se han agregado productos</center>
                            </td>
                            </tr>
                            @endif
                            @foreach($reemplazos as $reemplazo)
                            <tr>
                                <td>{{ $reemplazo->reemplazo }}</td>
                                <td>{{ $reemplazo->marca }}</td>
                                <td>{{ $reemplazo->modelo }}</td>
                                <td>{{ $reemplazo->serie }}</td>
                                <td>{{ $reemplazo->otro }}</td>
                                <td>${{ $reemplazo->costo }}</td>
                                @if(!empty($reemplazo->firma))
                                <td><img src="{{ parseBase64(env('APP_URL').'/public/storage'.'/'.$reemplazo->firma) }}" width="80" height="80"></td>
                                @else
                                <td>No disponible</td>
                                @endif
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
                        <form id="frm_subir_archivo" method="POST" action="{{ route('subir_archivo',$service->id) }}"
                            accept-charset="UTF-8" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="file" name="file" class="btn btn-primary">
                            <textarea name="description" class="form-control"
                                placeholder="Ingrese una descripción des archivo..."></textarea>
                            @if($errors->has('description')) <small
                                style="color:red">{{ $errors->first('description') }}</small>@endif
                            <br>
                            <input type="submit" value="Subir archivo" class="btn btn-primary float-right">
                        </form>

                    </div>
                </div>
            </div>
            <div class="row" style="padding:10px;">
                @if(count($files) <= 0) <div class="col-md-12 text-align-center">
                    No se han agregado archivos
                    <br>
                    <small style="color: orange;">Se debe agregar por lo menos una evidencia para poder cerrar un
                        servicio</small>
            </div>
            @endif
            @foreach($files as $file)
            <div class="col-md-3" style="padding:10px;">
                <a href="{{ asset('storage/') }}/{{ $file->route }}" target="_new"><img
                        src="{{ asset('storage/') }}/{{ $file->route }}" width="120" height="120"></a>
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
</div>
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Reagendados</h4>
                    @php
                    $reschedules = App\Reschedule::where('service_id', $service->id)->get();
                    @endphp
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Autoriza</th>
                            <th>Última fecha</th>
                            <th>Nueva fecha</th>
                        </tr>
                        @foreach($reschedules as $reschedule)
                        <tr>
                            <td>{{ $reschedule->manager['name'] }} {{ $reschedule->manager['last_name1'] }} {{ $reschedule->manager['last_name2'] }}</td>
                            <td>{{ date_format(new \DateTime($reschedule->last_date), 'd-m-Y g:i A') }}</td>
                            <td>{{ date_format(new \DateTime($reschedule->new_date), 'd-m-Y g:i A') }}</td>
                        </tr>
                        @endforeach
                        @if(count($reschedules) <= 0)
                        <tr><td colspan="3"><center>No existen reagendados</center></td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Retiro de equipo</h4>
                    @php
                    $retiros_equipos = App\RetiroEquipo::where('service_id', $service->id)->get();
                    @endphp
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Equipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>No. Serie</th>
                            <th>Observaciones</th>
                            <th>Firma</th>
                        </tr>
                        @foreach($retiros_equipos as $retiro_equipo)
                        <tr>
                            <td>{{ $retiro_equipo->equipo }}</td>
                            <td>{{ $retiro_equipo->marca }}</td>
                            <td>{{ $retiro_equipo->modelo }}</td>
                            <td>{{ $retiro_equipo->serie }}</td>
                            <td>{{ $retiro_equipo->observaciones }}</td>
                            @if(!empty($retiro_equipo->firma))
                            <td><img src="{{ parseBase64(env('APP_URL').'/public/storage'.'/'.$retiro_equipo->firma) }}" width="80" height="80"></td>
                            @else
                            <td>No disponible</td>
                            @endif
                        </tr>
                        @endforeach
                        @if(count($retiros_equipos) <= 0)
                        <tr><td colspan="6"><center>No existen registros</center></td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('services.comment_box')