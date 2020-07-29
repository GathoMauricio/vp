@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3  bg-white rounded">
        <h4>Finalizar servicio</h4>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    Antes de dar por finalizado el servicio, por favor agregue su retroalimentación<!-- y evidencias digitales-->.
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    <form id="frm_success_service" action="{{ route('update_status_service') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service_id }}">
                        <input type="hidden" name="status" value="{{ $status }}">
                        <input type="hidden" name="comment_type_id" value="4">
                        <textarea name="solution" class="form-control" placeholder="Escriba aquí..." required></textarea>
                        <br>
                        <button onClick="$('#frm_success_service').submit();" type="submit" class="btn btn-success float-right">Finalizar servicio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection