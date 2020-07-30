<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link 
        rel="stylesheet" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
        crossorigin="anonymous">
        <title>Servicio</title>
        <style>
            td{
                padding:10px;
            }
        </style>
    </head>
    <body>
        <div style="width:100%;padding:10px;">
            <table class="table" style="width:100%;">
                <tr>
                    <td width="20%">
                        <img src="{{public_path('img\512x512.png')}}" style="width:90px;height:80px;">
                    </td>
                    <td width="80%">
                        <center><h5 class="font-weight-bold">BITÁCORA DE CONTROL DE SOPORTE TÉCNICO</h5></center>
                    </td>
                </tr>
            </table>
            
            <table style="width:100%;" class="table">
                <tr>
                    <td colspan="2" style="background-color:#D5D8DC " class="font-weight-bold">Datos del cliente</td>
                </tr>
                <tr>
                    <td width="50%">
                        <span class="font-weight-bold">Cliente:</span>  <i>{{ $service->customer['name'] }}</i>
                        <br>
                        <span class="font-weight-bold">Usuario final:</span>  <i>{{ $service->usuario_final['name'] }} {{ $service->usuario_final['last_name1'] }} {{ $service->usuario_final['last_name2'] }}</i>
                    </td>
                    <td width="50%">
                        <span class="font-weight-bold">N° de Reporte</span>
                        <br>
                        {{ $service->service_report }}
                    </td>
                </tr>
            </table>
            <table style="width:100%;" class="table">
                <tr><td colspan="3" style="background-color:#D5D8DC " class="font-weight-bold">Contacto</td></tr>
                <tr>
                    <td><span class="font-weight-bold">E-Mail:</span> <br>  <i>{{ $service->usuario_final['email'] }}</i></td>
                    <td><span class="font-weight-bold">Teléfono:</span> <br>  <i>{{ $service->usuario_final['phone'] }}</i></td>
                    <td><span class="font-weight-bold">Dirección:</span> <br>  
                    <i>
                        {{ $service->usuario_Final['calle_numero'] }} 
                        {{ $service->usuario_Final['asentamiento'] }}, 
                        {{ $service->usuario_Final['cp'] }} 
                        {{ $service->usuario_Final['ciudad'] }} 
                        {{ $service->usuario_Final['municipio'] }} 
                        {{ $service->usuario_Final['estado'] }} 
                    </i></td>
                </tr>
            </table>
            <table style="width:100%;" class="table">
                <tr><td colspan="3" style="background-color:#D5D8DC " class="font-weight-bold"
                    >Descripción del servicio: <i>{{ $service->service_type['service_type'] }}</i>
                </td></tr>
                <tr>
                    <td><span class="font-weight-bold">Mesa de ayuda:</span><br>   <i>{{ $service->manager['name'] }} {{ $service->manager['last_name1'] }} {{ $service->manager['last_name2'] }}</i></td>
                    <td><span class="font-weight-bold">Técnico asignado:</span> <br>  <i>{{ $service->technical['name'] }} {{ $service->technical['last_name1'] }} {{ $service->technical['last_name2'] }}</i></td>
                    <td><span class="font-weight-bold">Horario:</span><br>   <i>{{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}</i></td>
                </tr>
            </table>
            <table style="width:100%;" class="table">
                <tr>
                    <td><span class="font-weight-bold">Problemática:</span><br>   <i>{{ $service['description'] }}</i></td>
                    <td><span class="font-weight-bold">Observaciones:</span><br>   <i>{{ $service['observations'] }}</i></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="font-weight-bold">Solución:</span><br>   <i>{{ $service['solution'] }}</i></td>
                </tr>
            </table>
        </div>

        <div class="firmas">
            <table style="width:100%;">
            <tr>
                <td>
                    <center>
                        <span class="font-weight-bold">Firma del técnico</span>
                    </center>
                </td>
                <td>
                    <center>
                        <span class="font-weight-bold">Firma del cliente</span>
                    </center>
                </td>
            </tr>
            </table>
            <br><br><br><br><br><br>
        </div>
        <style>
            .firmas{
                position: fixed;
                left: 0;
                bottom: 0;
                width:100%;
            }
        </style>
    </body>
</html>