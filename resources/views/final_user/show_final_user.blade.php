@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Detalles de usuario final</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row" style="padding:10px;">
                <div class="col-md-3">
                    <img src="{{ asset('img/final_user') }}/{{ $finalUser->image }}" alt="{{ asset('img/final_user') }}/{{ $finalUser->image }}" width="100" height="100" style="border-radius:150px;">
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Nombre: </label> {{ $finalUser->name }} {{ $finalUser->last_name1 }} {{ $finalUser->last_name2 }}
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Email: </label> {{ $finalUser->email }} 
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Teléfono: </label> {{ $finalUser->phone }} Ext: {{ $finalUser->extension }} 
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="font-weight-bold">Dirección: </label>
                    {{ $finalUser->calle_numero }} 
                    {{ $finalUser->asentamiento }}, 
                    {{ $finalUser->cp }} 
                    {{ $finalUser->ciudad }} 
                    {{ $finalUser->municipio }} 
                    {{ $finalUser->estado }} 
                    @if(!empty($finalUser->piso))
                    Piso {{ $finalUser->piso }} 
                    @endif
                    @if(!empty($finalUser->interior))
                    Int {{ $finalUser->interior }} 
                    @endif
                </div> 
                <div class="col-md-6">
                    @if($finalUser->customer['customer_type_id'] > 2 )
                    <label for="" class="font-weight-bold">Descripción: </label>
                    @else
                    <label for="" class="font-weight-bold">Área: </label>
                    @endif
                    {{ $finalUser->area_descripcion }}
                </div> 
            </div>
            <div class="row">
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('edit_final_user',$finalUser->id) }}" class="btn btn-warning btn-block">Actualizar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('confirm_final_user',$finalUser->id) }}" class="btn btn-danger btn-block">Eliminar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('show_customer',$finalUser->customer_id) }}" class="btn btn-block" style="background-color: #EAECEE">Cancelar</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <a href="{{ route('create_final_user',$finalUser->customer_id) }}" class="btn btn-block" style="background-color: #3498DB;color:white;">
                        Agregar otro ususario final para {{ $finalUser->customer['name'] }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection