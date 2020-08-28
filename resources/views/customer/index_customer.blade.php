@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Lista de clientes</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <table class="table table-dark">
            <tr>
                <th></th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Usuarios finales</th>
                <th>
                    <!--Opciones-->
                </th>
            </tr>
            @if(count($customers) <= 0)
            <tr><td colspan="7"><center>No hay registros</center></td></tr>
            @endif
            @foreach($customers as $customer)
            @php
                $finalUsers = \App\FinalUser::where('customer_id',$customer->id)->get();
            @endphp
            <tr>
                <tr>
                    <td><img src="{{ asset('storage/') }}/{{$customer->image}}" alt="{{$customer->image}}" width="80" height="80" style="border-radius:150px;"></td>
                    <td>{{ $customer->customer_type['customer_type'] }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        {{ $customer->calle_numero }} 
                        {{ $customer->asentamiento }}
                        {{ $customer->cp }} 
                        {{ $customer->ciudad }}
                        {{ $customer->municipio }}
                        {{ $customer->estado }} 
                    </td>
                    <td>{{ count($finalUsers) }}</td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <a href="{{ route('show_customer',$customer->id) }}" class="btn btn-primary">
                                        <span class="icon icon-eye"
                                            style="color:white;"></span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection