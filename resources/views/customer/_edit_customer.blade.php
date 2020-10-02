@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Editar cliente
</h3>
<div class="container">
    <form id="frm_edit_customer" action="{{ route('update_customer',$customer->id) }}" class="form" method="POST">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="customer_type_id" class="font-weight-bold">Tipo de cliente</label>
                    <select  name="customer_type_id" class="form-control">
                        <option value>--Seleccione una opción--</option>
                        @foreach ($customersTypes as $customerType)
                            @if( old('customer_type_id') == $customerType->id || $customer->customer_type_id == $customerType->id)
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
                    <input name="name" type="text" value="{{ old('name',$customer->name) }}" class="form-control">
                    @if($errors->has('name')) <small style="color:red">{{ $errors->first('name') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="code" class="font-weight-bold">Código identificador</label>
                    <input name="code" type="text" value="{{ old('code',$customer->code) }}" class="form-control">
                    @if($errors->has('code')) <small style="color:red">{{ $errors->first('code') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="rfc" class="font-weight-bold">Rfc</label>
                    <input name="rfc" type="text" value="{{ old('rfc',$customer->rfc) }}" class="form-control">
                    @if($errors->has('rfc')) <small style="color:red">{{ $errors->first('rfc') }}</small>@endif
                </div>
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="responsable_name" class="font-weight-bold">Nombre de la pesona responsable</label>
                    <input name="responsable_name" type="text" value="{{ old('responsable_name',$customer->responsable_name) }}" class="form-control">
                    @if($errors->has('responsable_name')) <small style="color:red">{{ $errors->first('responsable_name') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="responsable_last_name1" class="font-weight-bold">A. Paterno de la persona responsable</label>
                    <input name="responsable_last_name1" type="text" value="{{ old('responsable_last_name1',$customer->responsable_last_name1) }}" class="form-control" >
                    @if($errors->has('responsable_last_name1')) <small style="color:red">{{ $errors->first('responsable_last_name1') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="responsable_last_name2" class="font-weight-bold">A. Materno de la persona responsable</label>
                    <input name="responsable_last_name2" type="text" value="{{ old('responsable_last_name2',$customer->responsable_last_name2) }}" class="form-control" >
                    @if($errors->has('responsable_last_name2')) <small style="color:red">{{ $errors->first('responsable_last_name2') }}</small>@endif
                </div>
            </div>
        </div>
        -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Teléfono</label>
                    <input name="phone" type="text" value="{{ old('phone',$customer->phone) }}" class="form-control">
                    @if($errors->has('phone')) <small style="color:red">{{ $errors->first('phone') }}</small>@endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adress" class="font-weight-bold">Email</label>
                    <input name="email" type="text" value="{{ old('email',$customer->email) }}" class="form-control" >
                    @if($errors->has('email')) <small style="color:red">{{ $errors->first('email') }}</small>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="hidden" id="ruta_get_sepomex" value="{{ route('getSepomex') }}">
                    <label for="cp" class="font-weight-bold">Código postal</label>
                    <input name="cp" onkeyup="getSepomex(this.value);" value="{{ old('cp',$customer->cp) }}" id="txt_cp_sepomex" type="text" class="form-control">
                    @if($errors->has('cp')) <small style="color:red">{{ $errors->first('cp') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="font-weight-bold">Asentamiento</label>
                    <select name="asentamiento" id="cbo_asentamiento_sepomex" value="{{ old('asentamiento',$customer->asentamiento) }}"  type="text" class="form-control">
                    </select>
                     @if($errors->has('asentamiento')) <small style="color:red">{{ $errors->first('asentamiento') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ciudad" class="font-weight-bold">Ciudad</label>
                    <input name="ciudad" id="txt_ciudad_sepomex" type="text" value="{{ old('ciudad',$customer->ciudad) }}"  class="form-control" readonly>
                    @if($errors->has('ciudad')) <small style="color:red">{{ $errors->first('ciudad') }}</small>@endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="municipio" class="font-weight-bold">Municipio</label>
                    <input name="municipio" id="txt_municipio_sepomex" value="{{ old('municipio',$customer->municipio) }}"  type="text" class="form-control" readonly>
                    @if($errors->has('municipio')) <small style="color:red">{{ $errors->first('municipio') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="estado" class="font-weight-bold">Estado</label>
                    <input name="estado" id="txt_estado_estado" value="{{ old('estado',$customer->estado) }}"  type="text" class="form-control" readonly>
                    @if($errors->has('estado')) <small style="color:red">{{ $errors->first('estado') }}</small>@endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="calle_numero" class="font-weight-bold">Calle y número</label>
                    <input name="calle_numero" type="text" value="{{ old('calle_numero',$customer->calle_numero) }}"  class="form-control">
                    @if($errors->has('calle_numero')) <small style="color:red">{{ $errors->first('calle_numero') }}</small>@endif
                </div>
            </div>
        </div>
        
    </form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a  href="{{ route('index_customer') }}" class="btn float-right"  style="background-color: #EAECEE">Cancelar</a>
                <button onClick="$('#frm_edit_customer').submit();"  type="submit" class="btn btn-primary float-right">Actualizar cliente</button>
            </div>
        </div>
    </div>
</div>
@endsection