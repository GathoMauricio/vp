@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3  bg-white rounded">
        <h4>Solicitud de reagendado</h4>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    Se enviará una solicitud para reagendar este servicio por lo tanto debe ingresar el motivo de está
                    acción.
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    <form id="frm_reschedule_service" action="{{ route('update_status_service') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service_id }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="comment_type_id" value="2">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Fecha solicitada</label>
                                        <input type="date" name="fecha" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">Hora solicitada</label>
                                        <input type="time" name="hora" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <table style="width:100%;">
                        <tr>
                            <td width="85%"><input type="text" name="comment" class="form-control"
                                    placeholder="Escriba aquí..." required></td>
                            <td width="15%"><button onClick="$('#frm_reschedule_service').submit();" type="submit"
                                    class="btn btn-warning">Enviar solicitud</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection