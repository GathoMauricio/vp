<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title> 
    <!--AdSense Script-->
    <script data-ad-client="ca-pub-4747161271433972" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
    <div class="contenedor_vp" style="width:100%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 principal-container-vp">
                    Test
                </div>
            </div>
        </div>
    </div>

    <div class="navigator">
        
        <img 
        src="{{ asset('img/employee/employee.png') }}" 
        width="50" 
        height="50" 
        class="float-right image-profile"
        >
    </div>
    <div class="menu_vp">
        <img src="{{ asset('img/completo.png') }}" width="90" height="50">
        <div class="content_menu_vp">
            <p style="cursor:pointer;">
                <span class="icon-search">
                    <span style="display:none;" class="label-item-menu">
                        Buscar
                    </span>
                </span> 
            </p>
            <p style="cursor:pointer;">
                <span class="icon-home">
                    <span style="display:none;" class="label-item-menu">
                        Inicio
                    </span>
                </span> 
            </p>
            <p style="cursor:pointer;">
                <span class="icon-calendar" id="item_calendar">
                    <span style="display:none;" class="label-item-menu">
                        Calendario
                    </span>
                </span> 
            </p>
        </div>
    </div>
    

    <style>
        body{
            background:url({{ asset('img/background_dashboard.jpg') }});
        }
        .navigator{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 10vh;
            padding:10px;
            /*background-color: #87c91f;*/
            /*background-color: #273746;*/
        }
        .image-profile{
            border-radius: 150px;
        }
        .menu_vp{
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding:10px;
            background-color: #273746;
        }
        .content_menu_vp{
            padding: 10px;
            padding-top:50px;
            text-align: left;
        }
        .content_menu_vp p span{
            color:white;
            font-size: 28px;
        }
        .label-item-menu{
            font-weight: bold;
            padding: 10px;
            font-size: 22px;
            color: white;
        }
        .contenedor_vp{
            padding:80px;
        }
        .principal-container-vp{
            background-color:white;
            height: 80vh;;
        }
    </style>






<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $(".menu_vp").mouseenter(function(e){
            $(".label-item-menu").css('display', 'inline');
        }).mouseleave(function(){
            $(".label-item-menu").css('display', 'none');
        });       
    });
</script>
</body>
</html>