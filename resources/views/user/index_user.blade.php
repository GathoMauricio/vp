@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Lista de usuarios</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        {{ $users->links() }}
        <table class="table table-dark">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Estatus</th>
                <th>
                    <!--Opciones-->
                </th>
            </tr>
            @foreach($users as $user)
            <tr>
                <td><img src="{{asset('img/employee')}}/{{$user->image}}" alt="{{$user->image}}" width="80" height="80" style="border-radius:150px;"></td>
                <td>{{ $user->name }} {{ $user->last_name1 }} {{ $user->last_name2 }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    {{ $user->calle_numero }} 
                    {{ $user->asentamiento }}
                    {{ $user->cp }} 
                    {{ $user->ciudad }}
                    {{ $user->municipio }}
                    {{ $user->estado }}
                </td>
                <td>
                    @if($user->status_id <= 1)
                    <span class="bg-success" style="padding:5px;border-radius:3px;">{{ $user->estatus['status'] }}</span>
                    @else 
                    <span class="bg-danger" style="padding:5px;border-radius:3px;">{{ $user->estatus['status'] }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('show_user',$user->id) }}" class="btn btn-primary">
                        <span class="icon icon-eye"
                            style="color:white;"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection