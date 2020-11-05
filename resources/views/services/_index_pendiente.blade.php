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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        Campos
                    </th>
                </tr>
            </thead>
            @foreach($services as $service)
            <tbody>
                <tr>
                    <th scope="row">
                    Pásame los campos
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endif
@endsection
