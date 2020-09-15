@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3  bg-white rounded">
        <h4>Reagendar el servicio para {{ $service->customer['name'] }}</h4>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">
                    Se creará un reagendado para este servicio
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow p-3  bg-white rounded">
        <div class="container">
            <form action="{{ route('store_reschedule') }}" method="POST">
                <div class="row">
                    <div class="col-md-12 py-4">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="manager_id" value="{{ Auth()->user()->id }}">
                        <input type="hidden" name="last_date" value="{{ $service->schedule }}">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Reagendar para:</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Fecha</label>
                            <input type="date" name="new_date_fecha" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Fecha</label>
                            <input type="time" name="new_date_hora" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Reagendar" class="btn btn-primary float-right">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>