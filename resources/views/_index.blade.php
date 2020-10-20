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
        <!--AdSense Script-->
        <script data-ad-client="ca-pub-4747161271433972" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    </head>
<body>
    <div class="contenedor_vp" style="width:100%;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 principal-container-vp">
                    <div style="width:100%;position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);-webkit-transform: translate(-50%, -50%);">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <center><img src="{{ asset('img/completo.png') }}" width="280" height="140"></center>
                                            <br>
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">E-Mail</label>
                    
                                                    <div class="col-md-6">
                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                    
                                                <div class="form-group row">
                                                    <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">Contraseña</label>
                    
                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            Acceder
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    body {
        background:url({{ asset('img/background_dashboard.jpg')}});
    }

    .contenedor_vp {
            padding-left: 20px;
            padding-top: 40px;
        }

        .principal-container-vp {
            background-color: white;
            height: 90vh;
            padding: 25px;
            overflow: hidden;
            overflow-y: auto;
            border-radius:5px;
            border: solid 1px #87c91f;
            -webkit-box-shadow: 0px 2px 18px 2px rgba(135,201,31,1);
            -moz-box-shadow: 0px 2px 18px 2px rgba(135,201,31,1);
            box-shadow: 0px 2px 18px 2px rgba(135,201,31,1);
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
</body>
</html>