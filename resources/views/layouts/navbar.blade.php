<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @php $contador_pendientes = count(\App\Service::where('technical_id',Auth::user()->id)->where('status_service_id',1)->get()); @endphp
                        @if($contador_pendientes > 0)
                        <span style="color:red">{{ $contador_pendientes }}</span>
                        <span class="icon icon-earth" style="color:#2E86C1;" title="Pendientes"></span>
                        @else
                        <span class="icon icon-earth" style="color:#808B96;" title="Pendientes"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @php $pendientes = \App\Service::where('technical_id',Auth::user()->id)->where('status_service_id',1)->orderBy('schedule','asc')->limit(5)->get(); @endphp
                        @if(count($pendientes)<=0)
                        <a class="dropdown-item">
                            No hay servicios pendientes
                        </a>
                        @endif
                        @foreach($pendientes as $pendiente)
                        <a class="dropdown-item" href="{{ route('show_service',$pendiente->id) }}">
                            <label class="font-weight-bold">{{ $pendiente->customer['name'] }} - {{ $pendiente->service_report }}</label>
                            <br>
                            {{ $pendiente->usuario_Final['name'] }} {{ $pendiente->usuario_Final['last_name1'] }} {{ $pendiente->usuario_Final['last_name2'] }}
                            <br>
                            <span style="color:#2E86C1;">{{ date_format(new \DateTime($pendiente->schedule), 'd-m-Y g:i A') }}</span>
                        </a>
                        @endforeach
                        <a class="dropdown-item" href="{{ route('index_pendiente') }}">
                            <center style="color:#2E86C1;">Mostrar todos los pendientes</center>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <input type="hidden" id="ruta_cargar_mensajes_push" value="{{ route('cargar_mensajes_push') }}">
                        @php $mensajes = \App\Mensaje::where('receptor_id',Auth::user()->id)->orderBy('id','desc')->limit(5)->get(); @endphp
                        @php $contador_mensajes = count(\App\Mensaje::where('receptor_id',Auth::user()->id)->where('leido','NO')->get()); @endphp
                        @if($contador_mensajes > 0)
                        <span id="span_num_bubble" style="color:red;" >{{ $contador_mensajes }}</span>
                        <span id="span_icon_bubble" style="color:#2E86C1;" class="icon icon-bubble" title="Mensajes"></span>
                        @else
                        <span class="icon icon-bubble" style="color:#808B96;" title="Mensajes"></span>
                        @endif
                    </a>
                    <input type="hidden" id="txt_img_loading" value="{{ asset('img/loading.gif') }}">
                    <div id="div_items_mensajes" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @foreach($mensajes as $mensaje)
                        @if($mensaje->leido == 'NO')
                        <a style="background-color:#85C1E9;" class="dropdown-item" href="{{ route('open_message',[$mensaje->id,$mensaje->service_id]) }}">
                            <span class="icon {{$mensaje->icon}}" style="color:{{$mensaje->color}}"></span>
                            <label class="font-weight-bold">{{$mensaje->emisor['name']}} {{$mensaje->emisor['last_name1']}}</label> {!! $mensaje->mensaje !!}
                            <br>
                            <span class="float-right" style="color:white;">{{ date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A') }}</span>
                            <br>
                        </a>
                        @else
                        <a class="dropdown-item" href="{{ route('open_message',[$mensaje->id,$mensaje->service_id]) }}">
                            <span class="icon {{$mensaje->icon}}" style="color:{{$mensaje->color}}"></span>
                            <label class="font-weight-bold">{{$mensaje->emisor['name']}} {{$mensaje->emisor['last_name1']}}</label> {!! $mensaje->mensaje !!}
                            <br>
                            <span class="float-right" style="color:#2E86C1;">{{ date_format(new \DateTime($mensaje->created_at), 'd-m-Y g:i A') }}</span>
                            <br>
                        </a>
                        @endif
                        @endforeach
                        <a class="dropdown-item" href="{{ route('index_mensajes') }}">
                            <center style="color:#2E86C1;">Ver todos los mensajes</center>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Servicios
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('index_service') }}">
                            Lista de servicios
                        </a>
                        <a onclick="buscadorServicios();" class="dropdown-item" href="#">
                            Buscador de servicios
                        </a>
                        @if(!getRoles()['rol_tec'] || getRoles()['rol_mesa'] || getRoles()['rol_admin'])
                        <a class="dropdown-item" href="{{ route('create_service') }}">
                            Nuevo servicio
                        </a>
                        @endif
                    </div>
                </li>
                @if(getRoles()['rol_admin'])
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Usuarios
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('index_user') }}">
                            Lista de usuarios
                        </a>
                        <a class="dropdown-item" href="{{ route('create_user') }}">
                            Nuevo usario
                        </a>
                    </div>
                </li>
                @endif
                @if(getRoles()['rol_admin'] || getRoles()['rol_mesa'])
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Clientes
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('index_customer') }}">
                            Lista de clientes
                        </a>
                        <a class="dropdown-item" href="{{ route('create_customer') }}">
                            Nuevo cliente
                        </a>
                    </div>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{current_user()->name}} {{current_user()->last_name1}} {{current_user()->last_name2}}
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <input type="hidden" id="txt_pusher_user_id" value="{{ Auth::user()->id }}">
                        <audio id="tono_mensaje" src="{{ asset('sound/mensaje.mp3') }}"></audio>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
<br><br><br>
@include('services.search_service_modal')