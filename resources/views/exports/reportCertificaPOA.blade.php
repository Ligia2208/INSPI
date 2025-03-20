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
                <th>Sub Actividad</th>
                <th>Número de POA</th>

                <th>Motivo</th>
                <th>Estado</th>
                <th>Fecha</th>

                <th>Tipo POA</th>
                <th>Proceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actividades as $actividad)
                <tr>
                    <td>{{ $actividad->direccion }}</td>
                    <td>{{ $actividad->actividad_operativa }}</td>
                    <td>{{ $actividad->sub_actividad }}</td>
                    <td>{{ $actividad->nro_poa }}</td>

                    <td>{{ $actividad->comentario }}</td>
                    <td>{{ $actividad->estado_poa }}</td>
                    <td>{{ $actividad->fecha_registro }}</td>

                    <td>{{ $actividad->tipoPoa }}</td>
                    <td>{{ $actividad->proceso }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
