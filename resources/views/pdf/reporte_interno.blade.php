<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Reporte interno</title>
</head>

<body>
    <table class="table" style="width:100%;">
        <tr>
            <td width="20%">
                <img src="{{ $logo_vp }}" style="width:160px;height:90px;">
            </td>
            <td width="80%">
                <br>
                <i class="float-right font-weight-bold" style="padding-right:20px;color:#98ca48;">"Que tus negocios no
                    se detengan".</i>
                <br>
                <hr style="border:1px solid #98ca48;">
            </td>
        </tr>
    </table>
    <div class="zone">
        <table style="width:100%;">
            <tr>
                <td width="20%">Tipo de Servicio:</td>
                <td width="40%"><b>{{ $service->service_type['service_type'] }}</b></td>
                <td width="40%">
                    Fecha: <b>{{ date_format(new \DateTime(date('Y-m-d H:i:s')), 'd-m-Y g:i A') }}</b>
                    <br>
                    Folio Ticket: <b>{{ $service->service_report }}</b>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="zone">
        <div class="title">Datos del Cliente.</div>
        <table style="width:100%;" border="1">
            <tr>
                <td>Nombre o Razón Social</td>
                <td><b>{{ $service->customer['name'] }}</b></td>
            </tr>
            <tr>
                <td>Dirección.</td>
                <td>
                    <b>
                        {{ $service->customer['calle_numero'] }}
                        @if(!empty($service->customer['interior']))
                        Int {{ $service->customer['interior'] }}
                        @endif
                        @if(!empty($service->customer['piso']))
                        Piso {{ $service->customer['piso'] }}
                        @endif
                        Cp. {{ $service->customer['cp'] }}
                        {{ $service->customer['asentamiento'] }}
                        {{ $service->customer['ciudad'] }}
                        {{ $service->customer['municipio'] }},
                        {{ $service->customer['estado'] }}
                    </b>
                </td>
            </tr>
            <tr>
                <td>Responsable.</td>
                <td>
                    <b>
                        {{ $service->customer['responsable_name'] }}
                        {{ $service->customer['responsable_last_name1'] }}
                        {{ $service->customer['responsable_last_name2'] }}
                    </b>
                </td>
            </tr>
            <tr>
                <td>Mail.</td>
                <td><b>{{ $service->customer['email'] }}</b></td>
            </tr>
            <tr>
                <td>Teléfono.</td>
                <td><b>{{ $service->customer['phone'] }}</b></td>
            </tr>
        </table>
        <br>
        <table style="width:100%;" border="1">
            <tr>
                <td>Código </td>
                <td><b>{{ $service->customer['code'] }}</b></td>
            </tr>
            <tr>
                <td>Mesa de Ayuda </td>
                <td>
                    <b>
                        {{ $service->manager['name'] }}
                        {{ $service->manager['last_name1'] }}
                        {{ $service->manager['last_name2'] }}
                    </b>
                </td>
            </tr>
            <tr>
                <td>Técnico Asignado. </td>
                <td>
                    <b>
                        {{ $service->technical['name'] }}
                        {{ $service->technical['last_name1'] }}
                        {{ $service->technical['last_name2'] }}
                    </b>
                </td>
            </tr>
            <tr>
                <td>Horario de Cita:</td>
                <td><b>{{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}</b></td>
            </tr>
        </table>
    </div>
    <br>
    <div class="zone">
        <div class="title">Usuario Final.</div>
        <table style="width:100%;" border="1">
            <tr>
                <td>Nombre </td>
                <td>
                    <b>
                        {{ $service->usuario_Final['name'] }}
                        {{ $service->usuario_Final['last_name1'] }}
                        {{ $service->usuario_Final['last_name2'] }}
                    </b>
                </td>
            </tr>
            <tr>
                <td>Telefono </td>
                <td><b>{{ $service->usuario_Final['phone'] }}</b></td>
            </tr>

            <tr>
                <td>Área</td>
                <td><b>{{ $service->usuario_Final['area_descripcion'] }}</b></td>
            </tr>
        </table>
    </div>
    <br>
    <div class="zone">
        <div class="title">Descripción del Servicio: Soporte Técnico En sitio.</div>
        <table style="width:100%;" border="1">
            <tr>
                <td>Tipo de Equipo. <b>{{ $service->tipo_equipo['tipo_equipo'] }}</b></td>
                <td>Marca: <b>{{ $service->marca_equipo }}</b></td>
                <td>Modelo: <b>{{ $service->modelo_equipo }}</b></td>
                <td>N° Serie: <b>{{ $service->serie_equipo }}</b></td>
            </tr>
        </table>
        <table style="width:100%;" border="1">
            <tr>
                <td>Falla Reportada.</td>
                <td>Observaciones (Mesa de ayuda).</td>
            </tr>
            <tr>
                <td><b>{{ $service->description }}</b></td>
                <td><b>{{ $service->observations }}</b></td>
            </tr>
        </table>
        <table style="width:100%;" border="1">
            @if(!empty($service->technical_observations))
            <tr>
                <td width="20%">Observaciones.<br />(Técnico)</td>
                <td>{{ $service->technical_observations }}</td>
            </tr>
            @endif
            @if(!empty($service->technical_diagnostic))
            <tr>

                <td width="20%">Diagnóstico.<br />(Técnico)</td>
                <td>{{ $service->technical_diagnostic }}</td>
            </tr>
            @endif
            @if(!empty($service->solution))
            <tr>
                <td width="20%">Solución.</td>
                <td>{{ $service->solution }}</td>
            </tr>
            @endif

        </table>
    </div>
    <!--Si el servicio contiene productos se muestra esta parte-->
    @if(count($reemplazos)>0)
    <br>
    <div class="zone">
        <div class="title">Reemplazo de Equipo, Módulos y Accesorios. </div>
        <table style="width:100%;" border="1">
            <thead>
                <tr>
                    <th>Reemplazo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Otro</th>
                    <th>Costo</th>
                    <th>Firma</th>
                </tr>
            </thead>
            @foreach($reemplazos as $reemplazo)
            <tr>
                <td>{{ $reemplazo->reemplazo }}</td>
                <td>{{ $reemplazo->marca }}</td>
                <td>{{ $reemplazo->modelo }}</td>
                <td>{{ $reemplazo->serie }}</td>
                <td>{{ $reemplazo->otro }}</td>
                <td>${{ $reemplazo->costo }}</td>
                @if(!empty($reemplazo->firma))
                <td>{{ $reemplazo->firma }}</td>
                @else
                <td>No disponible</td>
                @endif
            </tr>
            @endforeach
        </table>
        <br>
        <span style="border: 2px solid #98ca48;float: right;font-size: 12px; padding: 10px;">
            Fecha de Entrega. 17 de Agosto del 2020
        </span>
        <br><br>
    </div>
    @endif
    <!--Si hay reagendados con retiro de equipo se miestra esta parte-->
    <br>
    <div class="zone">
        <div class="title">Retiro de equipo</div>
        <table style="width:100%;" border="1">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>N° Serie.</th>
                    <th>Observaciones</th>
                    <th>Firma de Autorización.</th>
                </tr>
            </thead>
            <tr>
                <td>Laptop</td>
                <td>Toshiba</td>
                <td>RT 5670 lA</td>
                <td>KBL52551084548664646</td>
                <td>El equipo tiene mancha en el lcd y rotas las bisagras, también falta una tecla.</td>
                <td>img</td>
            </tr>
        </table>
        <br>
        <span style="border: 2px solid #98ca48;float: right;font-size: 12px; padding: 10px;">
            Fecha de Entrega. 17 de Agosto del 2020
        </span>
        <br><br>
    </div>
    <br>
    <div style="width:100%;font-size: 12px;">
        * Para que el servicio realizado tenga garantía, el producto lo proveerá Victoria Project.
        <br>
        * El costo de el (los) producto (s) únicamente será asignado por el área de Mesa de Ayuda de VP, y será
        informado al Cliente para aprobar su autorización.
    </div>
    <br>
    <div class="zone">
        <div class="title" style="text-align: left;">Calificación del Servicio</div>
        <table style="width:100%;">
            <tr>
                <td>
                    <center><img src="{{public_path('img\icon_good.png')}}" width="40" height="40"></center>
                </td>
                <td>
                    <center><img src="{{public_path('img\icon_regular.png')}}" width="40" height="40"></center>
                </td>
                <td>
                    <center><img src="{{public_path('img\icon_bad.png')}}" width="40" height="40"></center>
                </td>
            </tr>
        </table>
        <div class="title" style="text-align: left;">Recomendación para mejora del Servicio:</div>
        <hr style="border:1px solid #98ca48;">
    </div>
    <table style="width:100%;">
        <tr>
            <td><br><br><br>
                <center>
                    <hr style="border:1px solid #98ca48;">Firma de Usuario.</center>
            </td>
            <td><br><br><br>
                <center>
                    <hr style="border:1px solid #98ca48;">Firma de Responsable.</center>
            </td>
            <td><br><br><br>
                <center>
                    <hr style="border:1px solid #98ca48;">Firma de Técnico.</center>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <center><span style="font-size: 12px;color:gray;">Victoria Project queda de Ud. para cualquier duda y/ó
                        aclaración. www.victoriapro.com.mx , contacto@victoriapro.com.mx Oficina: 55 58 55 15 77
                        WhatsApp: 55 73 89 73 73. Carlos Victoria.</span></center>
            </td>
        </tr>
    </table>
    <style>
        body {
            padding: 10px;
        }

        table tr td,
        table tr th {
            font-size: 12px;
            padding: 5px;
        }

        .title {
            width: 100%;
            font-size: 14px;
            font-weight: bold;
            color: #98ca48;
            text-align: center;
        }

        .zone {
            width: 100%;
            padding: 10px;
            border: 1px solid #98ca48;
            -webkit-box-shadow: -2px 0px 16px 6px rgba(152, 202, 72, 0.70);
            -moz-box-shadow: -2px 0px 16px 6px rgba(152, 202, 72, 0.70);
            box-shadow: -2px 0px 16px 6px rgba(152, 202, 72, 0.70);
            border-radius: 10px;
        }
    </style>
</body>

</html>