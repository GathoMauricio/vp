@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Alta de usuario final para {{ $customer->name }}</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <form id="frm_create_final_user" action="{{ route('store_final_user') }}" class="form" method="POST">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Nombre(s)</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="form-control">
                            @if($errors->has('name')) <small
                                style="color:red">{{ $errors->first('name') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">A. Paterno</label>
                            <input name="last_name1" value="{{ old('last_name1') }}" type="text" class="form-control">
                            @if($errors->has('last_name1')) <small
                                style="color:red">{{ $errors->first('last_name1') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">A. Materno</label>
                            <input name="last_name2" value="{{ old('last_name2') }}" type="text" class="form-control">
                            @if($errors->has('last_name2')) <small
                                style="color:red">{{ $errors->first('last_name2') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Email</label>
                            <input name="email" value="{{ old('email') }}" type="text" class="form-control">
                            @if($errors->has('email')) <small
                                style="color:red">{{ $errors->first('email') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Teléfono</label>
                            <input name="phone" value="{{ old('phone') }}" type="text" class="form-control">
                            @if($errors->has('phone')) <small
                                style="color:red">{{ $errors->first('phone') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Extensión</label>
                            <input name="extension" value="{{ old('extension') }}" type="text" class="form-control">
                            @if($errors->has('extension')) <small
                                style="color:red">{{ $errors->first('extension') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @if($customer->customer_type_id > 2 )
                            <label for="" class="font-weight-bold">Descripción</label>
                            @else
                            <label for="" class="font-weight-bold">Area</label>
                            @endif
                            <input name="area_descripcion" value="{{ old('area_descripcion') }}" type="text"
                                class="form-control">
                            @if($errors->has('area_descripcion')) <small
                                style="color:red">{{ $errors->first('area_descripcion') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="ruta_get_customer_address" value="{{ route('get_customer_address') }}">
                        <a href="#" id="a_customer_adress_id" onclick="getCustomerAddress({{ $customer->id}});">Utilizar dirección de
                            {{ $customer->name }}</a>
                        <input type="hidden" id="txt_customer_adress_id" value="{{ $customer->id}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="ruta_get_sepomex" value="{{ route('getSepomex') }}">
                            <label for="" class="font-weight-bold">Código postal</label>
                            <input name="cp" value="{{ old('cp') }}" onkeyup="getSepomex(this.value);"
                                onchange="getSepomex(this.value);" id="txt_cp_sepomex" type="text" class="form-control">
                            @if($errors->has('cp')) <small style="color:red">{{ $errors->first('cp') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Asentamiento</label>
                            <select name="asentamiento" value="{{ old('asentamiento') }}" id="cbo_asentamiento_sepomex"
                                type="text" class="form-control">
                            </select>
                            @if($errors->has('asentamiento')) <small
                                style="color:red">{{ $errors->first('asentamiento') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Ciudad</label>
                            <input name="ciudad" value="{{ old('ciudad') }}" id="txt_ciudad_sepomex" type="text"
                                class="form-control" readonly>
                            @if($errors->has('ciudad')) <small
                                style="color:red">{{ $errors->first('ciudad') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Municipio</label>
                            <input name="municipio" value="{{ old('municipio') }}" id="txt_municipio_sepomex"
                                type="text" class="form-control" readonly>
                            @if($errors->has('municipio')) <small
                                style="color:red">{{ $errors->first('municipio') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Estado</label>
                            <input name="estado" value="{{ old('estado') }}" id="txt_estado_estado" type="text"
                                class="form-control" readonly>
                            @if($errors->has('estado')) <small
                                style="color:red">{{ $errors->first('estado') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Calle y número</label>
                            <input name="calle_numero" value="{{ old('calle_numero') }}" id="txt_calle_numero"
                                type="text" class="form-control">
                            @if($errors->has('calle_numero')) <small
                                style="color:red">{{ $errors->first('calle_numero') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="piso" class="font-weight-bold">Piso</label>
                            <input name="piso" value="{{ old('piso') }}" id="txt_piso"
                                type="text" class="form-control">
                            @if($errors->has('piso')) <small
                                style="color:red">{{ $errors->first('piso') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="interior" class="font-weight-bold">Interior</label>
                            <input name="interior" value="{{ old('interior') }}" id="txt_interior"
                                type="text" class="form-control">
                            @if($errors->has('interior')) <small
                                style="color:red">{{ $errors->first('interior') }}</small>@endif
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <!--<a  href="{{ route('index_customer') }}" class="btn float-right"  style="background-color: #EAECEE">Cancelar</a>-->
                        <button onClick="$('#frm_create_final_user').submit();" type="submit"
                            class="btn btn-primary float-right">Agregar usuario final</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection