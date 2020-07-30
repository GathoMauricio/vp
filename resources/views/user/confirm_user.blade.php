@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Eliminar usuario</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h5>
            <img src="{{ asset('img/employee') }}/{{ $user->image }}" alt="{{ asset('img/employee') }}/{{ $user->image }}" width="100" height="100" style="border-radius:150px;">
            ¿Realmente desea eliminar el registro de {{ $user->name }}?
        </h5>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h6 style="color:red">
            Atención: Sí elimina este registro no podrá deshacer los cambios posteriormente.
        </h6>
    </div>
    <div style="width:100%;">
        <table class="float-right">
            <tr>
                <td>
                    <form action="{{ route('destroy_user',$user->id) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Si, eliminar</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('show_user',$user->id) }}" class="btn" style="background-color: #EAECEE">Cancelar</a>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection