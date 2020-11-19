@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">Pendientes
    {{ $services->links() }}
</h3>
@if(count($services) <= 0) 
@include('layouts.no_records') 
@else
<div class="container">
    <div class="row py-1">
        <table class="table table-bordered table-sort">
            <thead>
                <tr>
                    <th scope="col">
                        Folio
                    </th>
                    <th scope="col">
                        Fecha y hora de atención
                    </th>
                    <th scope="col">
                        Equipo
                    </th>
                    <th scope="col">
                        Tipo de servicio
                    </th>
                    <th scope="col">
                        Falla reportada
                    </th>
                    <th scope="col">
                        Estatus
                    </th>
                    <th scope="col">
                        Prioridad
                    </th>
                    <th scope="col">
                        Cliente
                    </th>
                    <th scope="col">
                        Usuario final
                    </th>
                    <th scope="col">
                        Observaciones
                    </th>
                </tr>
            </thead>
            @foreach($services as $service)
            <tbody>
                <tr>
                    <td scope="row">
                        <a href="{{ route('show_service',$service->id) }}">{{ $service->service_report }}</a>
                    </td>
                    <td>
                        {{ getFormatDate($service->schedule) }}
                    </td>
                    <td>
                        {{ $service->tipo_equipo['tipo_equipo'] }}
                    </td>
                    <td>
                        {{ $service->service_type['service_type'] }}
                    </td>
                    <td>
                        {{ $service->description }}
                    </td>
                    <td>
                        <span style="background-color:#AAB7B8;color:white;font-weight: bold;padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                    </td>
                    <td>
                        {{ $service->priority }}
                    </td>
                    <td>
                        <a href="{{ route('show_customer',$service->customer['id']) }}">{{ $service->customer['name'] }}</a>
                    </td>
                    <td>
                        <a href="{{ route('show_final_user',$service->usuario_Final['id']) }}">{{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }} {{ $service->usuario_Final['last_name2'] }}</a>
                    </td>
                    <td>
                        {{ $service->observations }}
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endif
@endsection
