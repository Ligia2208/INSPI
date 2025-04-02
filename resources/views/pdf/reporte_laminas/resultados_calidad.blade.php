<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDF REPORTE RESULTADO</title>
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
        font-size: 10px;
    }

</style>
</head>

<body>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center; vertical-align: middle;" class="letra">
        <thead>
            <tr>
                <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                </th>
                <th colspan="2">INFORME DE CONTROL DE CALIDAD DE BACILOSCOPÍA</th>
                <th style="width: 6%;">CÓDIGO</th>
                <th style="width: 6%;">F-MICOTB-004</th>
            </tr>
            <tr>
                <td rowspan="2" style="width: 30%;">MACRO-PROCESO: Laboratorios de Vigilancia Epidemiológica y Referencia Nacional</td>
                <td rowspan="2" style="width: 40%;">PROCESO INTERNO: Centro de Referencia Nacional de Micobacterias</td>
                <td style="border: 1px solid black; width: 10%;">Edición</td>
                <td>04</td>
            </tr>
            <tr>
                <td>Fecha de aprobación</td>
                <td>07/10/2019</td>
            </tr>
        </thead>
    </table><br>

    <span class="letra"><strong>Fecha: </strong>{{ date('d/m/Y') }}</span> <br>
    <span class="letra"><strong>Nombre de la Unidad: </strong>{{$datos->instituto}}</span> <br>
    <span class="letra"><strong>Director de la Unidad: </strong> </span> <br>
    <span class="letra"><strong>Responsable: </strong></span> <br>
    <span class="letra"><strong>Analista: </strong>{{$datos->analita}}</span> <br>
    <span class="letra"><strong>Informe de la supervisión realizada a las láminas enviadas por UD. con fecha: </strong>{{$datos->fecha_recep}}</span> <br>
    <span class="letra"><strong>Mes: </strong>{{$datos->mes_recepcion}}</span> <br>
    <span class="letra"><strong>Total de láminas Enviadas: </strong></span> <br>
    <span class="letra"><strong>Total de Láminas Supervisadas: </strong>{{$datos->total_laminas}}</span> <br>

    <div style="text-align: center;">

        <table class="table table-bordered letra" style="width: 80%; margin: auto; margin-top: 15px;">
            <thead class="table-dark">
                <tr>
                    <th colspan="3">Evaluación Técnica</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>Láminas Positivas</td>
                    <td>% Discordantes</td>
                    <td>Calificación de Resultados</td>
                </tr>

                <tr>
                    <td>{{ $resultados->get(0)?->nro_laminas }}</td>
                    <td>{{ number_format($resultados->get(0)?->porcentaje_laminas, 2) }}%</td>
                    <td rowspan="3">    {{ number_format(
                    ((float) $resultados->get(0)?->porcentaje_laminas + (float) $resultados->get(1)?->porcentaje_laminas) / 2, 
                        2
                    ) }}%
                    </td>
                </tr>

                <tr>
                    <td>Láminas Negativas</td>
                    <td>% Discordantes</td>
                    
                </tr>

                <tr>
                    <td>{{ $resultados->get(1)?->nro_laminas }}</td>
                    <td>{{ number_format($resultados->get(1)?->porcentaje_laminas, 2) }}%</td>
                    
                </tr>


            </tbody>
        </table>

        <table class="table table-bordered letra" style="width: 80%; margin: auto; margin-top: 15px;">
            <thead class="table-dark">
                <tr>
                    <th colspan="4">Datos de Frotis</th>
                </tr>
                <tr>
                    <th>Tipo de Frotis</th>
                    <th>Número de Registros</th>
                    <th>Porcentaje</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos_frotis as $frotis)
                <tr>
                    <td>{{ $frotis['nombre'] }}</td>
                    <td>{{ $frotis['cantidad'] }}</td>
                    <td>{{ number_format($frotis['porcentaje'], 2) }}%</td>
                    <td>{{ $frotis['calificacion'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <table class="table table-bordered letra" style="width: 80%; margin: auto; margin-top: 15px;">
            <thead class="table-dark">
                <tr>
                    <th colspan="4">Datos de Tinción</th>
                </tr>
                <tr>
                    <th>Tipo de Tinción</th>
                    <th>Número de Registros</th>
                    <th>Porcentaje</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos_tincion as $tincion)
                <tr>
                    <td>{{ $tincion['nombre'] }}</td>
                    <td>{{ $tincion['cantidad'] }}</td>
                    <td>{{ number_format($tincion['porcentaje'], 2) }}%</td>
                    <td>{{ $tincion['calificacion'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table table-bordered letra" style="width: 70%; margin: auto; margin-top: 15px;">
            <thead class="table-dark">
                <tr>
                    <th colspan="3">Datos de Apariencia</th>
                </tr>
                <tr>
                    <th>Tipo de Apariencia</th>
                    <th>Número de Registros</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos_apariencia as $apariencia)
                <tr>
                    <td>{{ $apariencia['nombre'] }}</td>
                    <td>{{ $apariencia['cantidad'] }}</td>
                    <td>{{ number_format($apariencia['porcentaje'], 2) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>


</body>
