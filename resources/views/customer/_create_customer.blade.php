@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Alta de cliente
</h3>
<div class="container">
            <form enctype="multipart/form-data" id="frm_create_customer" action="{{ route('store_customer') }}" class="form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customer_type_id" class="font-weight-bold">Tipo de cliente</label>
                            <select name="customer_type_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                                @foreach ($customersTypes as $customerType)
                                    @if( old('customer_type_id') == $customerType->id)
                                    <option value="{{$customerType->id}}" selected>{{$customerType->customer_type}}</option>
                                    @else 
                                    <option value="{{$customerType->id}}">{{$customerType->customer_type}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('customer_type_id')) <small style="color:red">{{ $errors->first('customer_type_id') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nombre o Razón social</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                            @if($errors->has('name')) <small style="color:red">{{ $errors->first('name') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="code" class="font-weight-bold">Código identificador</label>
                            <input name="code" type="text" value="{{ old('code') }}" class="form-control">
                            @if($errors->has('code')) <small style="color:red">{{ $errors->first('code') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rfc" class="font-weight-bold">Rfc</label>
                            <input name="rfc" type="text" value="{{ old('rfc') }}" class="form-control">
                            @if($errors->has('rfc')) <small style="color:red">{{ $errors->first('rfc') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="responsable_name" class="font-weight-bold">Nombre de la persona responsable</label>
                            <input name="responsable_name" type="text" value="{{ old('responsable_name') }}" class="form-control">
                            @if($errors->has('responsable_name')) <small style="color:red">{{ $errors->first('responsable_name') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="responsable_last_name1" class="font-weight-bold">A. Paterno de la persona responsable</label>
                            <input name="responsable_last_name1" type="text" value="{{ old('responsable_last_name1') }}" class="form-control" >
                            @if($errors->has('responsable_last_name1')) <small style="color:red">{{ $errors->first('responsable_last_name1') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="responsable_last_name2" class="font-weight-bold">A. Materno de la persona responsable</label>
                            <input name="responsable_last_name2" type="text" value="{{ old('responsable_last_name2') }}" class="form-control" >
                            @if($errors->has('responsable_last_name2')) <small style="color:red">{{ $errors->first('responsable_last_name2') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Teléfono</label>
                            <input name="phone" type="text" value="{{ old('phone') }}" class="form-control">
                            @if($errors->has('phone')) <small style="color:red">{{ $errors->first('phone') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="extension" class="font-weight-bold">Extensión</label>
                            <input name="extension" type="text" value="{{ old('extension') }}" class="form-control">
                            @if($errors->has('extension')) <small style="color:red">{{ $errors->first('extension') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adress" class="font-weight-bold">Email</label>
                            <input name="email" type="email" value="{{ old('email') }}" class="form-control" accept="image/x-png,image/gif,image/jpeg">
                            @if($errors->has('email')) <small style="color:red">{{ $errors->first('email') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="image" class="font-weight-bold">Imagen</label>
                            <input name="image" type="file" value="{{ old('image') }}" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" id="ruta_get_sepomex" value="{{ route('getSepomex') }}">
                            <label for="cp" class="font-weight-bold">Código postal</label>
                            <input name="cp" onkeyup="getSepomex(this.value);" id="txt_cp_sepomex" type="text" class="form-control">
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
                            <label for="ciudad" class="font-weight-bold">Ciudad</label>
                            <input name="ciudad" id="txt_ciudad_sepomex" type="text" class="form-control" readonly>
                            @if($errors->has('ciudad')) <small style="color:red">{{ $errors->first('ciudad') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio" class="font-weight-bold">Municipio</label>
                            <input name="municipio" id="txt_municipio_sepomex" type="text" class="form-control" readonly>
                            @if($errors->has('municipio')) <small style="color:red">{{ $errors->first('municipio') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado" class="font-weight-bold">Estado</label>
                            <input name="estado" id="txt_estado_estado" type="text" class="form-control" readonly>
                            @if($errors->has('estado')) <small style="color:red">{{ $errors->first('estado') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="calle_numero" class="font-weight-bold">Calle y número</label>
                            <input name="calle_numero" type="text" class="form-control">
                            @if($errors->has('calle_numero')) <small style="color:red">{{ $errors->first('calle_numero') }}</small>@endif
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
                        <a  href="{{ route('index_customer') }}" class="btn float-right"  style="background-color: #EAECEE">Cancelar</a>
                        <button onClick="$('#frm_create_customer').submit();" type="submit" class="btn btn-primary float-right">Agregar cliente</button>
                    </div>
                </div>
            </div>
        </div>
@endsection