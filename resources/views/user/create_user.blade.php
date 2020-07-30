@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Alta de usuario</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <form id="frm_create_user" action="{{ route('store_user') }}" class="form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="font-weight-bold">Roles</label>
                        @if($errors->has('roles')) <small style="color:red">{{ $errors->first('roles') }}</small>@endif
                    </div>
                    
                </div>
                <div class="row">
                    @foreach($rols as $rol)
                    <div class="col-sm-3 item_rol">
                        <input type="checkbox" name="roles[]" value="{{ $rol['id'] }}"> {{ $rol['rol'] }}
                    </div>
                    @endforeach
                    
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nombre(s)</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="Nombre del empleado...">
                            @if($errors->has('name')) <small style="color:red">{{ $errors->first('name') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name1" class="font-weight-bold">A. Paterno</label>
                            <input name="last_name1" type="text" value="{{ old('last_name1') }}"  class="form-control" placeholder="Apellido materno de empleado...">
                            @if($errors->has('last_name1')) <small style="color:red">{{ $errors->first('last_name1') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_name2" class="font-weight-bold">A. Materno</label>
                            <input name="last_name2" type="text" value="{{ old('last_name2') }}" class="form-control" placeholder="Apellido materno del empleado...">
                            @if($errors->has('last_name2')) <small style="color:red">{{ $errors->first('last_name2') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">E-Mail</label>
                            <input name="email" type="text" value="{{ old('email') }}" class="form-control" placeholder="Ingrese un email válido...">
                            @if($errors->has('email')) <small style="color:red">{{ $errors->first('email') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Teléfono</label>
                            <input name="phone" type="text" value="{{ old('phone') }}" class="form-control" placeholder="Ingrese un teléfono...">
                            @if($errors->has('phone')) <small style="color:red">{{ $errors->first('phone') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="ruta_get_sepomex" value="{{ route('getSepomex') }}">
                            <label for="" class="font-weight-bold">Código postal</label>
                            <input name="cp" value="{{ old('cp') }}" onkeyup="getSepomex(this.value);" id="txt_cp_sepomex" type="text" class="form-control">
                            @if($errors->has('cp')) <small style="color:red">{{ $errors->first('cp') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Asentamiento</label>
                            <select name="asentamiento" id="cbo_asentamiento_sepomex" type="text" class="form-control">
                            </select>
                             @if($errors->has('asentamiento')) <small style="color:red">{{ $errors->first('asentamiento') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Ciudad</label>
                            <input name="ciudad" value="{{ old('cidad') }}" id="txt_ciudad_sepomex" type="text" class="form-control" readonly>
                            @if($errors->has('ciudad')) <small style="color:red">{{ $errors->first('ciudad') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Municipio</label>
                            <input name="municipio" value="{{ old('municipio') }}" id="txt_municipio_sepomex" type="text" class="form-control" readonly>
                            @if($errors->has('municipio')) <small style="color:red">{{ $errors->first('municipio') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Estado</label>
                            <input name="estado" value="{{ old('estado') }}" id="txt_estado_estado" type="text" class="form-control" readonly>
                            @if($errors->has('estado')) <small style="color:red">{{ $errors->first('estado') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Calle y número</label>
                            <input name="calle_numero" value="{{ old('calle_numero') }}" type="text" class="form-control">
                            @if($errors->has('calle_numero')) <small style="color:red">{{ $errors->first('calle_numero') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="font-weight-bold">Contraseña</label>
                            <input name="password" type="password" class="form-control" placeholder="Cree una contraseña almenos de 6 dígitos...">
                            @if($errors->has('password')) <small style="color:red">{{ $errors->first('password') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="repassword" class="font-weight-bold">Repetir contraseña</label>
                            <input name="repassword" type="password" class="form-control" placeholder="Confirme su nueva contraseña...">
                            @if($errors->has('repassword')) <small style="color:red">{{ $errors->first('repassword') }}</small>@endif
                        </div>
                    </div>
                </div>
                
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <a  href="{{ route('index_user') }}" class="btn float-right"  style="background-color: #EAECEE">Cancelar</a>
                        <button onClick="$('#frm_create_user').submit();" type="submit" class="btn btn-primary float-right">Agregar usuario</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
