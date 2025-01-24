<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDF EN BLANCO</title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
    .inferior th, td {
        padding: 8px;
        text-align: left;
        text-align: center;
    }

    .invisible {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .invisible2 {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .invisible3 {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .firma {
        border-bottom: none;
    }
</style>
</head>

<body>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 12px; text-align: center; vertical-align: middle;">
        <thead>
            <tr>
                <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                </th>
                <th colspan="2">SOLICITUD DE REFORMA PAPP Y MODIFICACIÓN PRESUPUESTARIA</th>
                <th style="width: 6%;">CÓDIGO:</th>
                <td style="width: 6%;">F-PI-004</td>
            </tr>
            <tr>
                <td rowspan="2" style="width: 45%;"><strong>MACRO-PROCESO: </strong>Dirección de Planificación y Gestión Estratégica</td>
                <td rowspan="2" style="width: 25%;"><strong>PROCESO INTERNO: </strong>Gestión de planificación e inversión</td>
                <td style="border: 1px solid black; width: 10%;"><strong>EDICIÓN:</strong></td>
                <td>03</td>
            </tr>
            <tr>
                <th>FECHA DE APROBACIÓN:</th>
                <td>5/1/2024</td>
            </tr>
            <tr>
                <th rowspan="2">COORDINACIÓN/DIRECCIÓN SOLICITANTE: </th>
                <th rowspan="2">{{ $atributos->area }}</th>
                <th>NÚMERO DE SOLICITUD:</th>
                <td colspan="2">{{ $atributos->numero}}</td>
            </tr>
            <tr>
                <th>FECHA DE SOLICITUD: </th>
                <td colspan="2">{{ $atributos->fecha_apr}}</td>
            </tr>
        </thead>
    </table><br>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 8px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th colspan="23" style="border: 1px solid black;">PLAN ANUAL DE POLÍTICAS PÚBLICAS PAPP</th>
            </tr>
            <tr>
                <th colspan="11" style="border: 1px solid black;">ESTRUCTURA PROGRAMATICA Y PLANIFICACIÓN ESTRATÉGICA</th>
                <th colspan="12" style="border: 1px solid black;">CRONOGRAMA DE DEVENGAMIENTO</th>
            </tr>
            <tr>
                <th>UE</th>
                <th>PR</th>
                <th>PY</th>
                <th>ACT</th>
                <th>FTE</th>
                <th>ACTIVIDADES OPERATIVAS</th>
                <th>SUB-ACTIVIDAD/OBJETO DE CONTRATACIÓN</th>
                <th>ITEM PRESUPUESTARIO</th>
                <th>DESCRIPCIÓN DEL ITEM PRESUPUESTARIO</th>
                <th>DISMINUYE</th>
                <th>AUMENTA</th>
                <th>ENERO</th>
                <th>FEBRERO</th>
                <th>MARZO</th>
                <th>ABRIL</th>
                <th>MAYO</th>
                <th>JUNIO</th>
                <th>JULIO</th>
                <th>AGOSTO</th>
                <th>SEPTIEMBRE</th>
                <th>OCTUBRE</th>
                <th>NOVIEMBRE</th>
                <th>DICIEMBRE</th>
            </tr>
        </thead>
        <tbody>
        @php
        $totales = [
            'enero' => 0, 'febrero' => 0, 'marzo' => 0, 'abril' => 0,
            'mayo' => 0, 'junio' => 0, 'julio' => 0, 'agosto' => 0,
            'septiembre' => 0, 'octubre' => 0, 'noviembre' => 0, 'diciembre' => 0,
            'totalDisminuye' => 0, 'totalAumenta' => 0
        ];
         @endphp
            @foreach($actividades as $actividad)
                <tr>
                    <td>{{$actividad->u_ejecutora}}</td>
                    <td>{{$actividad->programa}}</td>
                    <td>{{$actividad->proyecto}}</td>
                    <td>{{$actividad->actividad}}</td>
                    <td>{{$actividad->fuente}}</td>
                    <td>{{ $actividad->actividad_operativa }}</td>
                    <td>{{ $actividad->sub_actividad }}</td>
                    <td>{{ $actividad->item_presupuestario }}</td>
                    <td>{{ $actividad->descripcion_item }}</td>
                    <td>{{ $actividad->tipo == 'DISMINUYE' ? number_format($actividad->total, 2) : '' }}</td>
                    <td>{{ $actividad->tipo == 'AUMENTA' ? number_format($actividad->total, 2) : '' }}</td>
                    <td style="width: 20px;">{{ $actividad->enero }}</td>
                    <td>{{ $actividad->febrero }}</td>
                    <td>{{ $actividad->marzo }}</td>
                    <td>{{ $actividad->abril }}</td>
                    <td>{{ $actividad->mayo }}</td>
                    <td>{{ $actividad->junio }}</td>
                    <td>{{ $actividad->julio }}</td>
                    <td>{{ $actividad->agosto }}</td>
                    <td>{{ $actividad->septiembre }}</td>
                    <td>{{ $actividad->octubre }}</td>
                    <td>{{ $actividad->noviembre }}</td>
                    <td>{{ $actividad->diciembre }}</td>
                </tr>
                @php
                    $totales['enero'] += $actividad->enero;
                    $totales['febrero'] += $actividad->febrero;
                    $totales['marzo'] += $actividad->marzo;
                    $totales['abril'] += $actividad->abril;
                    $totales['mayo'] += $actividad->mayo;
                    $totales['junio'] += $actividad->junio;
                    $totales['julio'] += $actividad->julio;
                    $totales['agosto'] += $actividad->agosto;
                    $totales['septiembre'] += $actividad->septiembre;
                    $totales['octubre'] += $actividad->octubre;
                    $totales['noviembre'] += $actividad->noviembre;
                    $totales['diciembre'] += $actividad->diciembre;

                    if ($actividad->tipo == 'DISMINUYE') {
                        $totales['totalDisminuye'] += $actividad->total;
                    } elseif ($actividad->tipo == 'AUMENTA') {
                        $totales['totalAumenta'] += $actividad->total;
                    }
                @endphp
            @endforeach
            <tr>
                <th colspan="9">Total</th>
                <td>{{ number_format($totales['totalDisminuye'], 2) }}</td>
                <td>{{ number_format($totales['totalAumenta'], 2) }}</td>
                <td>{{ number_format($totales['enero'], 2) }}</td>
                <td>{{ number_format($totales['febrero'], 2) }}</td>
                <td>{{ number_format($totales['marzo'], 2) }}</td>
                <td>{{ number_format($totales['abril'], 2) }}</td>
                <td>{{ number_format($totales['mayo'], 2) }}</td>
                <td>{{ number_format($totales['junio'], 2) }}</td>
                <td>{{ number_format($totales['julio'], 2) }}</td>
                <td>{{ number_format($totales['agosto'], 2) }}</td>
                <td>{{ number_format($totales['septiembre'], 2) }}</td>
                <td>{{ number_format($totales['octubre'], 2) }}</td>
                <td>{{ number_format($totales['noviembre'], 2) }}</td>
                <td>{{ number_format($totales['diciembre'], 2) }}</td>
            </tr>
            <tr>
                <th style="text-align: center; vertical-align: middle;" colspan="5">Justificación del área requirente:</th>
                <td colspan="18">{{$atributos->justificacion_area}}</td>
            </tr>
        </tbody>
    </table> <br>

         <!-- <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th colspan="4" style="border: 1px solid black; width: 75%;">SOLICITUD</th>
                    <th colspan="2" style="border: 1px solid black;">VALIDACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 15%;">Coordinación/ Directiva Técnica o administrativa/ Proyecto</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 40%;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 10%;">Fecha de solicitud</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->fecha_sol}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 10%; background-color: #f0f0f0;">Nro de Certificación POA:</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; background-color: #f0f0f0; ">{{$atributos->numero}}</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: -1px; font-size: 12px; white-space: normal; word-wrap: break-word;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th colspan="3" style="border: 1px solid black;">PLANIFICACIÓN Y GESTIÓN ESTRATÉGICA</th>
                    <th colspan="8" style="border: 1px solid black;">ESTRUCTURA PRESUPUESTARIA</th>
                    <th colspan="5" style="border: 1px solid black;">PROGRAMACIÓN DE EJECUCIÓN</th>
                    <th rowspan="2" style="border: 1px solid black; width: 6%;text-align: center; vertical-align: middle;">ACTIVIDAD PLANIFICADA</th>
                    <th rowspan="2" style="border: 1px solid black; width: 10%; text-align: center; vertical-align: middle;">MONTO<br>DISPONIBLE POR ITEM PRESUP.<br>(ESIGEF)</th>
                </tr>

                <tr style="background-color: #f0f0f0;">
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 6%;">OBJETIVO OPERATIVO</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 7%;">ACTIVIDAD OPERATIVA</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%;">SUB ACT./<br>OBJ. DE CONTRATACIÓN</td>

                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">UNIDAD EJECUTORA</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">Programa (PR)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%">Proyecto<br>(PY)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%">Actividad (Act)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">FUENTE DE FINANCI<br>AMIENTO</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 3%">ITEM PRESUP.</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 7%">DESCR. DE ITEM PRESUP.</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">MONTO PLANIFICADO O REFERENCIAL PAPP</td>

                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">I TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">II TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">III TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">IV TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">TIENE PLURI<br>ANUALIDAD</td>

                </tr>
            </thead>
            <tbody>
                Filas vacías para llenar desde el controlador
                <tr style="height: 100px;">
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">9999</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">01</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">000</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">001</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">001</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">x</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                    <td>
                    </td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">SI</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;"></td>
                </tr>
                Repite estas filas según la cantidad de datos que se vayan a llenar
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: -1px;">
        <tbody>
            <tr>
                <td style="border: 1px solid black; width: 20.71%; text-align: center; vertical-align: middle;">Justificación área requiriente</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; text-align: center; vertical-align: middle;">Justificación/Observación de la Dirección de Planificación</td>
            </tr>
        </tbody>
    </table> <br> -->


<!----------------------------------------------------------------------------------------------------------------------------------------------->
     <table class="inferior">
        <tr>
            <th colspan="6">AREAS REQUIRENTES (COORDINACIÓN/DIRECCIÓN TÉCNICAS Y ADMINISTRATIVAS)</th>
            <th colspan="4">DIRECCIÓN DE PLANIFICACIÓN Y GESTIÓN ESTRATÉGICA</th>
        </tr>
        <tr>
            <th colspan="2">Elaborado por: {{$usuarios['creado']['name']}} </th>
            <th colspan="2">Revisado por: {{$usuarios['autorizado']['name']}} </th>
            <th colspan="2">Aprobado por: {{$usuarios['reporta']['name']}} </th>
            <th colspan="2">Registrado por: {{$usuarios['areaReq']['name']}} </th>
            <th colspan="2">Validado por: {{$usuarios['planificacionYG']['name']}}</th>
        </tr>
        <tr>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="firma" style="border-top: none;">Firma</th>
            <th colspan="2" class="firma" style="border-top: none;">Firma</th>
            <th colspan="2" class="firma" style="border-top: none;">Firma</th>
            <th colspan="2" class="firma" style="border-top: none;">Firma</th>
            <th colspan="2" class="firma" style="border-top: none;">Firma</th>
        </tr>
        <tr>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
        </tr>
    </table>
</body>
