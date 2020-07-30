@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Eliminar usuario final</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h5>
            <img src="{{ asset('img/final_user') }}/{{ $finalUser->image }}" alt="{{ asset('img/final_user') }}/{{ $finalUser->image }}" width="100" height="100" style="border-radius:150px;">
            ¿Realmente desea eliminar el registro de {{ $finalUser->name }} {{ $finalUser->last_name1 }} {{ $finalUser->last_name2 }}?
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
                    <form action="{{ route('destroy_final_user',$finalUser->id) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Si, eliminar</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('show_final_user',$finalUser->id) }}" class="btn" style="background-color: #EAECEE">Cancelar</a>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection