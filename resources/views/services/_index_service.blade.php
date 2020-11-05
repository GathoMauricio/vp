@extends('layouts.template')
@section('content')
<h3 class="title_page_vp">Se muestran los servicios del dia {{ date('d-m-Y') }} 
    {{ $services->links() }}
</h3>
@if(count($services) <= 0) @include('layouts.no_records') @endif
<div class="container">
    <div class="row py-1">
        @foreach($services as $service)
        <div class="col-md-12 py-3 item-service">
            @if($service->status_service_id == 1)
            <span style="background-color: #D6DBDF;color:black;" class="float-right font-weight-bold status-theme">
                {{ $service->status['status_service'] }}
            </span>
            @endif
            @if($service->status_service_id == 2)
            <span style="background-color: #F39C12;color:white;" class="float-right font-weight-bold status-theme">
                {{ $service->status['status_service'] }}
            </span>
            @endif
            @if($service->status_service_id == 3)
            <span style="background-color: #2ECC71;color:white;" class="float-right font-weight-bold status-theme">
                {{ $service->status['status_service'] }}
            </span>
            @endif
            @if($service->status_service_id == 5)
            <span style="background-color: #E74C3C;color:white;" class="float-right font-weight-bold status-theme">
                {{ $service->status['status_service'] }}
            </span>
            @endif

            @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                @if($service->status_service_id > 5)
                <span style="background-color: #F4D03F;color:white;" class="float-right font-weight-bold status-theme">
                    {{ $service->status['status_service'] }}
                </span>
                @endif 
            @else 
            <span style="background-color: #2ECC71;color:white;" class="float-right font-weight-bold status-theme">
                Finalizado
            </span>
            @endif


            <span class="float-right" style="padding:15px;padding-top:10px;">
                <a href="{{ route('formato_pdf_servicio',$service->id) }}"target="_blank" class="btn btn-danger">
                    <span class="icon-file-pdf"></span>
                </a>
            </span>
            <h5 class="font-weight-bold"> 
                <a href="{{ route('show_service',$service->id) }}" style="color:#87c91f;">
                {{ $service->customer['code'] }}  [{{ $service->service_report }}]
                </a>
                - {{ $service->service_type['service_type'] }}
            </h6>
            <h6 style="color:#6A6A6A;font-weight: bold;">Asignado por 
                <a href="{{ route('show_user',$service->manager_id) }}" class="user_span_preview">
                    {{ $service->manager['name'] }} 
                    {{ $service->manager['last_name1'] }} 
                    {{ $service->manager['last_name2'] }}
                </a> 
                para 
                <a href="{{ route('show_user',$service->technical_id) }}" class="user_span_preview">
                    {{ $service->technical['name'] }} 
                    {{ $service->technical['last_name1'] }} 
                    {{ $service->technical['last_name2'] }}
                </a> 
            </h6>
            <h6 class="font-weight-bold">
                <a href="{{ route('show_customer',$service->customer['id']) }}" class="user_span_preview">{{ $service->customer['name'] }} </a>
                <span class="icon-play3" style="color:#6A6A6A;"></span> 
                <a href="{{ route('show_final_user',$service->usuario_Final['id']) }}" class="user_span_preview">{{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }} {{ $service->usuario_Final['last_name2'] }}</a>
            </h6>
            <p style="color:#2d3323;">
                <img src="{{ env('APP_URL').'/public/storage'.'/'.$service->customer['image'] }}" width="80" height="80" class="py1">
                &nbsp;&nbsp;
                {{ $service->description }}
            </p>
            <span class="float-right font-weight-bold">Programado para el: {{ getFormatDate($service->schedule) }}</span>
                <!--
                <form action="">
                    <input type="text" class="form-control" placeholder="Escriba su comentario aquí...">
                </form>
                @php $comments = \App\Comment::where('service_id', $service->id)->get(); @endphp
                
                <div class="index-comment">
                    @foreach ($comments as $comment)
                    <div class="index-item-comment">
                        <a href="#" class="user_span_preview">
                            {{ $comment->user['user'] }} 
                            {{ $comment->user['last_name1'] }} 
                            {{ $comment->user['last_name2'] }}
                        </a> 
                        <p style="color:#2d3323;">{{ $comment->comment }}</p>
                        <span class="float-right font-weight-bold">{{ getFormatDate($comment->created_at) }}</span>
                        <br>
                    </div>
                    <br>
                    @endforeach
                </div>
                -->
        </div>
        @endforeach
    </div>
</div>
@endsection