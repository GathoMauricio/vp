@extends('layouts.template')
@section('content')
<input type="hidden" id="txt_show_service_calendar" value="{{ route('show_service') }}">
<input type="hidden" id="txt_index_ajax" value="{{  route('index_ajax') }}">
<div class="container">
    <div class="row">
        <div class="col"></div>
            <div class="col-12">
                <div id="calendar"></div>
            </div>
        <div class="col"></div>
    </div>
</div>
@endsection