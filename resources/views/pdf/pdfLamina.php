<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VERIFICACIÍON Y RECEPCIÓN DE LÁMINAS</title>
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
                    <th colspan="2">VERIFICACIÍON Y RECEPCIÓN DE LÁMINAS</th>
                    <th style="width: 6%;">CÓDIGO</th>
                    <th style="width: 6%;">F-MICOTB-001</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 30%;">MACRO-PROCESO: Laboratorios de Vigilancia Epidemiológica y Referencia Nacional</td>
                    <td rowspan="2" style="width: 40%;">PROCESO INTERNO: Centro de Referencia Nacional de Micobacterias</td>
                    <td style="border: 1px solid black; width: 10%;">Edición</td>
                    <td>01</td>
                </tr>
                <tr>
                    <td>Fecha de Aprobación</td>
                    <td>01/04/2025</td>
                </tr>

            </thead>
    </table><br>
 
    <table class="letra2" style="width: 100%; border-collapse: collapse; font-size: 12px; border: 1px solid black;">
    <tbody>
        <tr>
            <td>Fecha de Recepción de Láminas:</td>
            <td>{{ $fechaRecepcion }}</td>
            <td>Nombre del Laboratorio Supervisado:</td>
            <td>{{ $nombreLab }}</td>
        </tr>
        <tr>
            <td>Total de Láminas Recibidas:</td>
            <td>{{ $totalLaminas }}</td>
            <td>Procedencia:</td>
            <td>{{ $procedencia }}</td>
        </tr>
        <tr>
            <td>Responsable de Recepción:</td>
            <td colspan="3">{{ $responsable }}</td>
        </tr>
        <tr>
            <td>Analista (encargado de Control de Calidad):</td>
            <td colspan="3">{{ $analista }}</td>
        </tr>
        <tr>
            <td>Mes supervisado:</td>
            <td colspan="3">{{ $mesSupervisado }}</td>
        </tr>
        </tbody>
    </table>


    <!----------------------------------------------------------------------------------------------------------------------------------------------->
    <table class="tabla-inferior">
        <thead>
            <tr>
                <th>Verificación</th>
                <th>SI</th>
                <th>NO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Láminas empacadas en cajas de láminas porta objetos y separadas entre ellas</td>
                <td>{{ $laminas_empacadas ? '✔' : '' }}</td>
                <td>{{ !$laminas_empacadas ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Láminas con información legible y enumeradas en forma consecutiva</td>
                <td>{{ $laminas_legibles ? '✔' : '' }}</td>
                <td>{{ !$laminas_legibles ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Las Láminas sin identificación de su resultado</td>
                <td>{{ $laminas_sin_id ? '✔' : '' }}</td>
                <td>{{ !$laminas_sin_id ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Láminas sin exceso de aceite de inmersión</td>
                <td>{{ $laminas_sin_aceite ? '✔' : '' }}</td>
                <td>{{ !$laminas_sin_aceite ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Láminas con frotis adecuado (tinción y dimensiones establecidas en el Manual de Baciloscopía)</td>
                <td>{{ $laminas_frotis_adecuado ? '✔' : '' }}</td>
                <td>{{ !$laminas_frotis_adecuado ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Láminas íntegras sin rajaduras que afecten al frotis</td>
                <td>{{ $laminas_integras ? '✔' : '' }}</td>
                <td>{{ !$laminas_integras ? '✘' : '' }}</td>
            </tr>
            <tr>
                <td>Láminas con documentación respectiva (listado con el número y resultado de cada lámina)</td>
                <td>{{ $laminas_documentacion ? '✔' : '' }}</td>
                <td>{{ !$laminas_documentacion ? '✘' : '' }}</td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <tr>
            <td style="border: 1px solid black; padding: 10px;" colspan="2">
                <strong>Observaciones:</strong><br><br>
                {{ $observaciones }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 10px; width: 70%;">
                <strong>Realizado por:</strong><br><br>
                {{ $realizadoPor }}
            </td>
            <td style="border: 1px solid black; padding: 10px; width: 30%;">
                <strong>Fecha:</strong><br><br>
                {{ date('d-m-Y') }}
            </td>
        </tr>
    </table>

</body>
