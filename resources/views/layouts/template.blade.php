<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script src="{{ asset('js/dist/sweetalert.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dist/sweetalert.css') }}">
    <!--Icons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
</head>

<body>
    <div class="contenedor_vp" style="width:100%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 principal-container-vp">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="navigator">

        <img src="{{ asset('img/employee/employee.png') }}" width="50" height="50" class="float-right image-profile">
    </div>
    <div class="menu_vp">
        <img src="{{ asset('img/completo.png') }}" width="90" height="50">
        <div class="content_menu_vp">
            <a href="#">
                <p style="cursor:pointer;">
                    <span class="icon-search">
                        <span style="display:none;" class="label-item-menu">
                            Buscar
                        </span>
                    </span>
                </p>
            </a>
            <a href="#">
                <p style="cursor:pointer;">
                    <span class="icon-home">
                        <span style="display:none;" class="label-item-menu">
                            Inicio
                        </span>
                    </span>
                </p>
            </a>
            <a href="#">
                <p style="cursor:pointer;">
                    <span class="icon-calendar" id="item_calendar">
                        <span style="display:none;" class="label-item-menu">
                            Calendario
                        </span>
                    </span>
                </p>
            </a>
        </div>
    </div>


    <style>
        body {
            background:url({{ asset('img/background_dashboard.jpg')}});
        }

        .navigator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 10vh;
            padding: 10px;
            /*background-color: #87c91f;*/
            /*background-color: #273746;*/
        }

        .image-profile {
            border-radius: 150px;
        }

        .menu_vp {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 10px;
            background-color: #273746;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .content_menu_vp {
            padding: 10px;
            padding-top: 50px;
            text-align: center;
        }

        .content_menu_vp p span {
            color: white;
            font-size: 22px;
        }

        .label-item-menu {
            font-weight: bold;
            padding: 10px;
            font-size: 18;
            color: white;
        }

        .contenedor_vp {
            padding: 80px;
        }

        .principal-container-vp {
            background-color: white;
            height: 90vh;
            padding: 25px;
            overflow: hidden;
            overflow-y: auto;
        }

        .sin-registros {
            width: 100%;
            color: #87c91f;
            text-align: center;
        }

        .title_page_vp {
            color: #ee9900;
            font-weight: bold;
        }

        .card-header-vp {
            background-color: #87c91f;
            color: white;
            cursor: pointer;
        }

        .card-header-vp :hover {
            background-color: #87c91f;
            color: #ee9900;
        }

        .item-service {
            border: solid 1px #87c91f;
            -webkit-box-shadow: -4px 6px 6px -1px rgba(135, 201, 31, 1);
            -moz-box-shadow: -4px 6px 6px -1px rgba(135, 201, 31, 1);
            box-shadow: -4px 6px 6px -1px rgba(135, 201, 31, 1);
        }

        .user_span_preview {
            color: #4e71ba;
            font-weight: bold;
        }

        .status-theme {
            color: #80755a;
            border: 3px solid #80755a;
            border-radius: 5px;
        }

        .principal-container-vp::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px #ee9900;
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .principal-container-vp::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }

        .principal-container-vp::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #ee9900;
            ;
        }
        .index-comment{
            width: 100%;
            padding:5px;
        }
        .index-item-comment{
            width: 100%;
            border-radius:10px;
            background-color:#D5D8DC;
            padding:10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function(){
        $(".menu_vp").mouseenter(function(e){
            $(".label-item-menu").css('display', 'inline');
            $(".content_menu_vp p").css('text-align','left');
            $(".content_menu_vp p span").css('font-size','18px');
        }).mouseleave(function(){
            $(".content_menu_vp p").css('text-align','center');
            $(".label-item-menu").css('display', 'none');
            $(".content_menu_vp p span").css('font-size','22px');
        });       
    });
    </script>
</body>

</html>