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
                <th>Dirección</th>
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
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <th>Total</th>
                <th>Frecuencia</th>
                <th>Tipo POA</th>
                <th>Proceso</th>
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
                    <td>{{ $actividad->total }}</td>
                    <td>{{ $actividad->frecuencia }}</td>
                    <td>{{ $actividad->tipoPoa }}</td>
                    <td>{{ $actividad->proceso }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
