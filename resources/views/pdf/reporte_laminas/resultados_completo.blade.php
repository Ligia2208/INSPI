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
                <th colspan="2">RESULTADO DE LAMINAS INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA &quot;LEOPOLDO IZQUIETA PÉREZ&quot; - INSPI</th>
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



    <!-- Segunda tabla -->
    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;" class="letra">
        <thead>
            <tr>
                <th style="width: 25%; text-align: center;">Centro de Salud</th>
                <th style="width: 25%; text-align: center;">Evento</th>
                <th style="width: 25%; text-align: center;">Técnica Aplicada</th>
                <th style="width: 25%; text-align: center;">Resultado Técnica Aplicada - Número</th>
                <th style="width: 25%; text-align: center;">Resultado Técnica Aplicada - Porcentaje</th>
                <th style="width: 25%; text-align: center;">Resultado del Evento - Porcentaje Acumulado</th>
                <th style="width: 25%; text-align: center;">Resultado del Evento - Interpretación</th>
            </tr>
        </thead>

        <tbody>
            
            @foreach($resultados as $resultado)
            <tr>
                <td style="text-align: center;"> {{$resultado->nom_instituto}} </td>
                <td style="text-align: center;"> {{$resultado->nom_tecnica}} </td>
                <td style="text-align: center;"> {{$resultado->tecnica_lamina}} </td>
                <td style="text-align: center;"> {{$resultado->nro_laminas}} </td>
                <td style="text-align: center;"> {{$resultado->porcentaje_laminas}} </td>
                <td style="text-align: center;"> {{$resultado->porcentaje_acumulado}} </td>
                <td style="text-align: center;"> {{$resultado->interpretacion}} </td>
            </tr>
            @endforeach
            

        </tbody>

    </table><br>



</body>
