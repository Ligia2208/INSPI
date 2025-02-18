<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Detalle</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th style="width:200px;">Dirección</th>
                <th>Actividad Operativa</th>
                <th>Objetivo Operativo</th>
                <th>Sub Actividad</th>
                <th>Item Presupuestario</th>
                <th>Descripción Item</th>
                <th>Unidad Ejecutora</th>
                <th>Programa</th>
                <th>Proyecto</th>
                <th>Actividad</th>
                <th>Fuente</th>
                <th>Total</th>
                <th>Total Certificado</th>
                <th>Tipo POA</th>
                <th>Proceso</th>
                <th>Plurianual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $actividad)
                <tr>
                    <td>{{ $actividad->direccion }}</td>
                    <td>{{ $actividad->actividad_operativa }}</td>
                    <td>{{ $actividad->objOperativo }}</td>
                    <td>{{ $actividad->sub_actividad }}</td>
                    <td>{{ $actividad->item_presupuestario }}</td>
                    <td>{{ $actividad->descripcion_item }}</td>
                    <td>{{ $actividad->u_ejecutora }}</td>
                    <td>{{ $actividad->programa }}</td>
                    <td>{{ $actividad->proyecto }}</td>
                    <td>{{ $actividad->actividad }}</td>
                    <td>{{ $actividad->fuente }}</td>
                    
                    <td>{{ $actividad->total }}</td>
                    <td>{{ $actividad->certificado }}</td>
                    <td>{{ $actividad->tipoPoa }}</td>
                    <td>{{ $actividad->proceso }}</td>
                    <td>{{ $actividad->plurianual ? 'SI' : 'NO' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
