@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">
    Lista de Clientes
    {{ $customers->links() }}
</h3>
@if(count($customers) <= 0) @include('layouts.no_records') @endif 
<div class="container">
    <div class="row py-1">
        @foreach($customers as $customer)
        <div class="col-md-12 py-3 item-service">
            <h5 class="font-weight-bold"> 
                <a href="{{ route('show_customer',$customer->id) }}" style="color:#87c91f;">
                {{ $customer->name }}  [{{ $customer->code }}]
                </a>
                - {{ $customer->customer_type['customer_type'] }}
            </h6>
            <p class="font-weight-bold">
                <img src="{{ env('APP_URL').'/public/storage'.'/'.$customer['image'] }}" width="80" height="80" class="py1">
                &nbsp;&nbsp;
                <label style="color:#f6993f;">Responsable: </label>
                {{ $customer->responsable['name'] }} 
                {{ $customer->responsable['last_name1'] }} 
                {{ $customer->responsable['last_name2'] }}
                <br>
                <label style="color:#f6993f;">Teléfono: </label>
                {{ $customer->phone }} 
                &nbsp;&nbsp;
                <label style="color:#f6993f;">Email: </label>
                {{ $customer->email }} 
                &nbsp;&nbsp;
                <label style="color:#f6993f;">Rfc: </label>
                {{ $customer->rfc }} 
                <br>
                <label style="color:#f6993f;">Dirección: </label>
                {{ $customer->calle_numero }} 
                {{ $customer->asentamiento }}
                {{ $customer->interior }} 
                {{ $customer->piso }} 
                {{ $customer->cp }}
                {{ $customer->estado }} 
                {{ $customer->municipio }} 
                {{ $customer->ciudad }} 
                <br>
            </p>
            <span class="float-right font-weight-bold">Creado el: {{ getFormatDate($customer->created_at) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection