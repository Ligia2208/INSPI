<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PLAN ANUAL DE POLITICAS PUBLICAS (PAPP)</title>
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

    .letra{
        font-size: 11px;
    }

    .letra2{
        font-size: 6px;
    }
</style>
</head>

<body>

<table class="letra" style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 12px; text-align: center; vertical-align: middle;">
        <thead>
            <tr>
                <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                </th>
                <th colspan="2">PLAN ANUAL DE POLÍTICAS PÚBLICAS (PAPP)</th>
                <th style="width: 6%;">CÓDIGO</th>
                <th style="width: 6%;">F-PI-001</th>
            </tr>
            <tr>
                <td rowspan="2" style="width: 30%;">MACRO-PROCESO: Dirección de Planificación y Gestión Estratégica</td>
                <td rowspan="2" style="width: 40%;">PROCESO INTERNO: Planificación e inversión</td>
                <td style="border: 1px solid black; width: 10%;">Edición</td>
                <td>11</td>
            </tr>
            <tr>
                <td>Fecha de aprobación</td>
                <td>28/08/2023</td>
            </tr>

        </thead>
    </table><br>

    <table class="letra2" style="width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center; vertical-align: middle;">
        <thead>
            <tr>
                <td colspan="4">PLANIFICACIÓN Y SEGUIMIENTO INSTITUCIONAL</td>
                <td colspan="8">ESTRUCTURA Y MONTO PRESUPUESTARIO</td>
                <td colspan="3">CONTRATACIÓN PÚBLICA</td>
                <td colspan="12">PROGRAMACIÓN DEVENGAMIENTO</td>
            </tr>

            <tr>
                <td>OBJETIVO OPERATIVO</td>
                <td>ACTIVIDADES OPERATIVAS</td>
                <td>SUB ACTIVIDAD/OBJETO DE CONTRATACIÓN</td>
                <td>DIRECCIÓN/COORDINACIÓN</td>
                <td>UNIDAD EJECUTORA</td>
                <td>PROGRAMA</td>
                <td>PROYECTO</td>
                <td>ACTIVIDAD</td>
                <td>FUENTE DE FINANCIAMIENTO</td>
                <td>ITEM PRESUPUESTARIO</td>
                <td>DESCRIPCIÓN DEL ITEM PRESUPUESTARIO</td>
                <td>MONTO REFERENCIAL ANUAL O PLANIFICADO</td>
                <td>TIPO DE GASTO: CORRIENTE E INVERSIÓN</td>
                <td>TIPO DE PROCESO: NUEVO O ARRASTRE</td>
                <td>TIPO DE CONTRATACIÓN SUGERIDO: (REGIMEN, SUBASTA, INFIMA, CATALOGO, ETC)</td>
                <td>ENERO</td>
                <td>FEBRERO</td>
                <td>MARZO</td>
                <td>ABRIL</td>
                <td>MAYO</td>
                <td>JUNIO</td>
                <td>JULIO</td>
                <td>AGOSTO</td>
                <td>SEPTIEMBRE</td>
                <td>OCTUBRE</td>
                <td>NOVIEMBRE</td>
                <td>DICIEMBRE</td>
            </tr>
        </thead>
        <tbody>
            @php
            $totalAnual = 0;
            $totalesMensuales = [
                'enero' => 0, 'febrero' => 0, 'marzo' => 0, 'abril' => 0,
                'mayo' => 0, 'junio' => 0, 'julio' => 0, 'agosto' => 0,
                'septiembre' => 0, 'octubre' => 0, 'noviembre' => 0, 'diciembre' => 0
            ];
            @endphp
        @foreach($actividades as $actividad)
                <tr>
                    <td>{{$actividad->objOperativo}}</td>
                    <td>{{$actividad->actividad_operativa }}</td>
                    <td>{{$actividad->sub_actividad }}</td>
                    <td>{{$actividad->direccion}}</td>
                    <td>{{$actividad->u_ejecutora}}</td>
                    <td>{{$actividad->programa}}</td>
                    <td>{{$actividad->proyecto}}</td>
                    <td>{{$actividad->actividad}}</td>
                    <td>{{$actividad->fuente}}</td>
                    <td>{{ $actividad->item_presupuestario }}</td>
                    <td>{{ $actividad->descripcion_item }}</td>
                    <td>{{ $actividad->total }}</td>
                    <td>{{ $actividad->tipoPoa }}</td>
                    <td>{{ $actividad->proceso }}</td>
                    <td></td>
                    <td>{{ $actividad->enero }}</td>
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
                    $totalAnual += $actividad->total;
                    $totalesMensuales['enero'] += $actividad->enero;
                    $totalesMensuales['febrero'] += $actividad->febrero;
                    $totalesMensuales['marzo'] += $actividad->marzo;
                    $totalesMensuales['abril'] += $actividad->abril;
                    $totalesMensuales['mayo'] += $actividad->mayo;
                    $totalesMensuales['junio'] += $actividad->junio;
                    $totalesMensuales['julio'] += $actividad->julio;
                    $totalesMensuales['agosto'] += $actividad->agosto;
                    $totalesMensuales['septiembre'] += $actividad->septiembre;
                    $totalesMensuales['octubre'] += $actividad->octubre;
                    $totalesMensuales['noviembre'] += $actividad->noviembre;
                    $totalesMensuales['diciembre'] += $actividad->diciembre;
                @endphp
            @endforeach
            <tr>
                <td colspan="11">Total</td>
                <td>{{ number_format($totalAnual, 2) }}</td>
                <td colspan="3"></td>
                <td>{{ number_format($totalesMensuales['enero'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['febrero'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['marzo'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['abril'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['mayo'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['junio'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['julio'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['agosto'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['septiembre'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['octubre'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['noviembre'], 2) }}</td>
                <td>{{ number_format($totalesMensuales['diciembre'], 2) }}</td>
            </tr>
        </tbody>
    </table>

<!----------------------------------------------------------------------------------------------------------------------------------------------->
    <table class="inferior letra">
        <tr>
            <th colspan="2">Elaborado</th>
            <th colspan="2">Revisado</th>
            <th colspan="2">Aprobado</th>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;">Cargo: {{$usuarios['elabora']['cargo']}}</td>
            <td colspan="2" style="text-align: left;">Cargo: {{$usuarios['revisa']['cargo']}}</td>
            <td colspan="2" style="text-align: left;">Cargo: {{$usuarios['aprueba']['cargo']}}</td>
        </tr>
        <tr>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
        </tr>
        <tr>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;">Nombre: {{$usuarios['elabora']['name']}}</td>
            <td colspan="2" style="text-align: left;">Nombre: {{$usuarios['revisa']['name']}}</td>
            <td colspan="2" style="text-align: left;">Nombre: {{$usuarios['aprueba']['name']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;">Fecha: <?php echo date('d-m-Y'); ?></td>
            <td colspan="2" style="text-align: left;">Fecha: <?php echo date('d-m-Y'); ?></td>
            <td colspan="2" style="text-align: left;">Fecha: <?php echo date('d-m-Y'); ?></td>
        </tr>
    </table>

</body>
