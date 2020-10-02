@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Detalle de personal
</h3>
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label for="" class="font-weight-bold">Roles</label>
                </div>
            </div>
            <div class="row">
                @foreach($usersRoles as $userRol)
                <div class="col-md-3 item_rol">
                    {{ $userRol->rol_name['rol'] }}
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ asset('img/employee') }}/{{ $user->image }}" alt="{{ asset('img/employee') }}/{{ $user->image }}" width="100" height="100" style="border-radius: 150px">
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Nombre</label>
                    <br>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">A. Paterno</label>
                    <br>
                    <span>{{ $user->last_name1 }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">A. Materno</label>
                    <br>
                    <span>{{ $user->last_name2 }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Estatus</label>
                    <br>
                    <span>
                        @if($user->status_id <= 1)
                        <span class="bg-success" style="padding:5px;border-radius:3px;">{{ $user->estatus['status'] }}</span>
                        @else 
                        <span class="bg-danger" style="padding:5px;border-radius:3px;">{{ $user->estatus['status'] }}</span>
                        @endif
                    </span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">E-Mail</label>
                    <br>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Teléfono</label>
                    <br>
                    <span>{{ $user->phone }}</span>
                </div>
                <div class="col-md-3">
                    <label for="" class="font-weight-bold">Dirección</label>
                    <br>
                    <span>
                        {{ $user->calle_numero }} 
                        {{ $user->asentamiento }} 
                        {{ $user->cp }} 
                        {{ $user->ciudad }} 
                        {{ $user->municipio }} 
                        {{ $user->estado }} 
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('edit_user',$user->id) }}" class="btn btn-warning btn-block">Actualizar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('confirm_user',$user->id) }}" class="btn btn-danger btn-block">Eliminar</a>
                </div>
                <div class="col-md-4">
                    <br>
                    <a href="{{ route('index_user') }}" class="btn btn-block" style="background-color: #EAECEE">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection