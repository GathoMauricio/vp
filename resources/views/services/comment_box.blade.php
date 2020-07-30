{{! $comments = \App\Comment::where('service_id', $service->id)->orderBy('created_at', 'ASC')->get() }}
<div class="contenedor_box">
    <div class="header_box">
        <span onclick="switchCommentBox()" class="icon icon-minus float-right" style="color:white;cursor:pointer;"></span>
        <label class="font-weight-bold" style="color:white">Bitácora ({{ count($comments) }})</label>
    </div>
    <input type="hidden" id="txt_ruta_get_bitacora_ajax" value="{{ route('get_bitacora_ajax') }}">
    <input type="hidden" id="txt_id_get_bitacora_ajax" value="{{ $service->id }}">
    <div class="contenedor_mensajes" id="contenedor_mensajes">
        @if(count($comments) <= 0)
                    <center>No se han agregado comentarios a este servicio</center>
                    @endif
                    @foreach($comments as $comment)

                    <div class="comment-item">

                        @if($comment->type['comment_type']=='Bitácora')
                        
                        <span style="color:white;padding:5px;" class="float-right bg-primary font-weight-bold" >
                            {{ $comment->type['comment_type'] }}
                        </span>

                        @endif

                        @if($comment->type['comment_type']=='Reagendar')

                        <span class="float-right bg-warning font-weight-bold" style="padding:5px;">

                            @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                            <a style="color:white" href="#" class="font-weight-bold">{{ $comment->type['comment_type'] }}</a>
                            @else
                            {{ $comment->type['comment_type'] }}
                            @endif

                        </span>

                        @endif

                        @if($comment->type['comment_type']=='Cancelar')

                        <span class="float-right bg-danger font-weight-bold" style="padding:5px;">

                            @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                            <a style="color:white" href="#" class="font-weight-bold">{{ $comment->type['comment_type'] }}</a>
                            @else

                            {{ $comment->type['comment_type'] }}

                            @endif
                        </span>

                        @endif

                        <label class="font-weight-bold" style="color:#154360;">
                            {{ $comment->user['name'] }} {{ $comment->user['last_name1'] }} {{ $comment->user['last_name2'] }}
                        </label>
                        <br>
                        {{ $comment->comment }}
                        <br>
                        <span class="float-right">{{ date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') }}</span>
                        <br>
                    </div>
                    <br>

                    @endforeach
    </div>
    <form id="form_store_comment" action="{{ route('store_comment') }}" method="post">
        @csrf
        <table style="width:100%;">
            <tr>
                <td>
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="comment_type" value="1">
                    <input type="text" id="txt_comment_ajax" name="comment" class="form-control" placeholder="Escriba aquí...">
                </td>
                <td>
                    <input type="image" src="{{ asset('img/send.png') }}" width="50" height="40">
                </td>
            </tr>
        </table>
    </form>
</div>

<style>
    .header_box {
        width: 100%;
        height: 40px;
        background-color: #3498DB;
        padding: 10px;
    }
    .contenedor_box{
        position: fixed;
        right: 0;
        bottom: 0;
        width: 280px;
        height:40px;
        z-index: 999;
        border: 1px solid #D5D8DC;
        border-radius: 5px;
        background-color:white;
        
    }
    .contenedor_mensajes{
        width: 100%;
        height: 260px;
        padding:5px;
        overflow: hidden;
        overflow-y: scroll;
    }
    /* width */
    .contenedor_mensajes::-webkit-scrollbar{
    width: 5px;
    border-radius:3px;
    }

    /* Track */
    .contenedor_mensajes::-webkit-scrollbar-track {
    background: #f1f1f1; 
    }
    
    /* Handle */
    .contenedor_mensajes::-webkit-scrollbar-thumb {
    background: #888; 
    }

    /* Handle on hover */
    .contenedor_mensajes::-webkit-scrollbar-thumb:hover {
    background: #555;
    width: 10px;
    }
</style>