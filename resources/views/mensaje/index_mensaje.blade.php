@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Todos los mensajes</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row" style="padding:10px;">
                <div class="col-md-12">
                    {{ $mensajes->links() }}
                </div>
                @foreach($mensajes as $mensaje)
                <div class="col-md-12">
                    @if($mensaje->leido == 'NO')
                        <a style="background-color:#85C1E9;" class="dropdown-item" href="{{ route('open_message',[$mensaje->id,$mensaje->service_id]) }}">
                            <span class="icon {{$mensaje->icon}}" style="color:{{$mensaje->color}}"></span>
                            <label class="font-weight-bold">{{$mensaje->emisor['name']}} {{$mensaje->emisor['last_name1']}}</label> {{ $mensaje->mensaje }}
                            <br>
                            <span class="float-right" style="color:white;">{{ date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A') }}</span>
                            <br>
                        </a>
                        @else
                        <a class="dropdown-item" href="{{ route('open_message',[$mensaje->id,$mensaje->service_id]) }}">
                            <span class="icon {{$mensaje->icon}}" style="color:{{$mensaje->color}}"></span>
                            <label class="font-weight-bold">{{$mensaje->emisor['name']}} {{$mensaje->emisor['last_name1']}}</label> {{ $mensaje->mensaje }}
                            <br>
                            <span class="float-right" style="color:#2E86C1;">{{ date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A') }}</span>
                            <br>
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection