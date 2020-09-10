@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Alta de servicio</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <form id="frm_create_service" action="{{ route('store_service') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_type_id" class="font-weight-bold">Tipo de servicio</label>
                            <select onchange="cargarUsuarios(this.value);" name="service_type_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                                @foreach($servicesTypes as $serviceType)
                                <option value="{{ $serviceType->id }}">{{ $serviceType->service_type }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('service_type_id')) <small
                                style="color:red">{{ $errors->first('service_type_id') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" id="ruta_cargar_empleados" value="{{ route('cargar_empleados') }}">
                            <label for="technical_id" class="font-weight-bold">Técnico asignado</label>
                            <select id="cbo_empleado_servicio" name="technical_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                            </select>
                            @if($errors->has('technical_id')) <small
                                style="color:red">{{ $errors->first('technical_id') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id" class="font-weight-bold">Cliente</label>
                            <select onchange="cargarUsuariosFinales(this.value);getCustomerAddress(this.value);" name="customer_id"
                                class="form-control">
                                <option value>--Seleccione una opción--</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('customer_id')) <small
                                style="color:red">{{ $errors->first('customer_id') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario_final" class="font-weight-bold" style="width:100%">Usuario final <a id="link_usuario_final_ajax" onclick="$('#create_final_user_modal').modal();" href="#" class="float-right" style="display:none"><span class="icon icon-plus"></span> Crear usuario final</a></label>
                            <select id="cbo_usuario_final" name="final_user_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                            </select>
                            @if($errors->has('final_user_id')) <small
                                style="color:red">{{ $errors->first('final_user_id') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="schedule_fecha" class="font-weight-bold">Fecha de atención</label>
                            <input type='date' value="{{ old('schedule_fecha') }}" name="schedule_fecha"
                                class="form-control" id="datepicker" />
                        </div>
                        @if($errors->has('schedule_fecha')) <small
                            style="color:red">{{ $errors->first('schedule_fecha') }}</small>@endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="schedule_hora" class="font-weight-bold">Programar hora</label>
                            <input type='time' name="schedule_hora" value="{{ old('schedule_hora') }}"
                                class="form-control" id="datepicker" />
                        </div>
                        @if($errors->has('schedule_hora')) <small
                            style="color:red">{{ $errors->first('schedule_hora') }}</small>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_equipo_id" class="font-weight-bold">Tipo de equipo</label>
                            <select name="tipo_equipo_id" class="form-control">
                                @foreach($tipos_equipos as $tipo_equipo)
                                <option value="{{ $tipo_equipo->id }}">{{ $tipo_equipo->tipo_equipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('tipo_equipo_id')) <small
                            style="color:red">{{ $errors->first('tipo_equipo_id') }}</small>@endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca_equipo" class="font-weight-bold">Marca</label>
                            <input type='text' name="marca_equipo" value="{{ old('marca_equipo') }}"
                                class="form-control" />
                        </div>
                        @if($errors->has('marca_equipo')) <small
                            style="color:red">{{ $errors->first('marca_equipo') }}</small>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modelo_equipo" class="font-weight-bold">Modelo</label>
                            <input type='text' name="modelo_equipo" value="{{ old('modelo_equipo') }}"
                                class="form-control" />
                        </div>
                        @if($errors->has('modelo_equipo')) <small
                            style="color:red">{{ $errors->first('modelo_equipo') }}</small>@endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serie_equipo" class="font-weight-bold">Serie</label>
                            <input type='text' name="serie_equipo" value="{{ old('serie_equipo') }}"
                                class="form-control" />
                        </div>
                        @if($errors->has('serie_equipo')) <small
                            style="color:red">{{ $errors->first('serie_equipo') }}</small>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Descripción</label>
                            <textarea name="description" class="form-control"></textarea>
                            @if($errors->has('description')) <small
                                style="color:red">{{ $errors->first('description') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="priority" class="font-weight-bold">Prioridad</label>
                            <select name="priority" class="form-control">
                                <option value="Normal">Normal</option>
                                <option value="Alta">Alta</option>
                                <option value="Baja">Baja</option>
                            </select>
                            @if($errors->has('priority')) <small
                                style="color:red">{{ $errors->first('priority') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observations" class="font-weight-bold">Observaciones <i>(Internas)</i> </label>
                            <textarea name="observations" class="form-control"></textarea>
                            @if($errors->has('descriptobservationsion')) <small
                                style="color:red">{{ $errors->first('observations') }}</small>@endif
                        </div>
                    </div>
                </div>

            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="{{ route('index_service') }}" class="btn float-right"
                            style="background-color: #EAECEE">Cancelar</a>
                        <button onClick="$('#frm_create_service').submit();" type="submit"
                            class="btn btn-primary float-right">Iniciar servicio</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@include('final_user.create_final_user_modal')
@endsection