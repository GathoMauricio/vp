@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Eliminar cliente
</h3>
<div class="container">
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h5>
            <img src="{{ asset('storage/') }}/{{$customer->image}}" alt="{{ asset('storage/') }}/{{$customer->image}}" width="100" height="100" style="border-radius:150px;">
            ¿Realmente desea eliminar el registro de {{ $customer->name }} junto con todos sus usuarios finales?
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
                    <form action="{{ route('destroy_customer',$customer->id) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Si, eliminar</button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('show_customer',$customer->id) }}" class="btn" style="background-color: #EAECEE">Cancelar</a>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection