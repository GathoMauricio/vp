@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3  bg-white rounded">
        <h4>Lista de servicios</h4>
    </div>
    <!--
    <div class="row shadow p-3  bg-white rounded">
        {{ $desc }}
    </div>
    -->
    

    <div class="row shadow p-3  bg-white rounded">
        {{ $services->links() }}
        <table class="table table-dark">
            <tr>
                <th>Folio</th>
                <th>Programación</th>
                <th>Tipo</th>
                <th>Mesa</th>
                <th>Técnico</th>
                <th>Cliente</th>
                <th>Usuario final</th>
                <th>Descripción</th>
                <!--
                <th>Comentarios</th>
                <th>Archivos</th>
                -->
                <th>Estatus</th>
                <th>Prioridad</th>
                <th>
                Options
                </th>
            </tr>
            @if(count($services) <= 0) <tr>
                <td colspan="8">
                    <center>--No se encontraron registros--</center>
                </td>
                </tr>
                @endif
                @foreach($services as $service)
                <tr>
                    <td>{{ $service->service_report }}</td>
                    <td>{{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}</td>
                    <td>{{ $service->service_type['service_type'] }}</td>
                    <td>{{ $service->manager['name'] }} {{ $service->manager['last_name1'] }}
                        {{ $service->manager['last_name2'] }}</td>
                    <td>{{ $service->technical['name'] }} {{ $service->technical['last_name1'] }}
                        {{ $service->technical['last_name2'] }}</td>
                    <td>{{ $service->customer['name'] }}</td>
                    <td>{{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }}
                        {{ $service->usuario_Final['last_name2'] }}</td>
                    <td>{{ $service->description }} </td>
                    <!--
                    <td>{{ count(App\Comment::where('service_id',$service->id)->get()) }}&nbsp;&nbsp;&nbsp;<span class="icon icon-bubble"></span></td>
                    <td>{{ count(App\File::where('service_id',$service->id)->get()) }}&nbsp;&nbsp;&nbsp;<span class="icon icon-attachment"></span></td>
                    -->    
                    <td>
                        @if($service->status['status_service'] == 'Pendiente')
                        <span class="bg-secondary"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                        @if($service->status['status_service'] == 'En proceso')
                        <span class="bg-warning"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                        @if($service->status['status_service'] == 'Finalizado')
                        <span class="bg-success"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                        @if($service->status['status_service'] == 'Re-agendado')
                        <span class="bg-primary"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                        @if($service->status['status_service'] == 'Cancelado')
                        <span class="bg-danger"
                            style="padding:5px;border-radius:5px;">{{ $service->status['status_service'] }}</span>
                        @endif
                    </td>
                    <td>
                        @if($service->priority == 'Alta')
                        <span
                            style="padding:5px;border-radius:5px;color:#2ECC71;">{{ $service->priority }}</span>
                        @endif
                        @if($service->priority == 'Normal')
                        <span
                            style="padding:5px;border-radius:5px;color:#2E86C1;">{{ $service->priority }}</span>
                        @endif
                        @if($service->priority == 'Baja')
                        <span
                            style="padding:5px;border-radius:5px;color:#F1C40F">{{ $service->priority }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('show_service',$service->id) }}" class="btn btn-primary"><span
                                class="icon icon-eye"></span></a>
                    </td>
                </tr>
                @endforeach
        </table>
    </div>


    <input type="hidden" id="txt_show_service_calendar" value="{{ route('show_service') }}">
    <input type="hidden" id="txt_index_ajax" value="{{  route('index_ajax') }}">
    <div class="row shadow p-3  bg-white rounded">
        <div class="col"></div>
        <div class="col-12">
            <div id="calendar"></div>
        </div>
        <div class="col"></div>
    </div>

</div>
@endsection