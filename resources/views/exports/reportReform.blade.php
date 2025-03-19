<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Reforma</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Dirección</th>
                <th>Número de Solicitud</th>
                <th>Número de Reforma</th>
                <th>Justificativo</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($actividades as $actividad)
                <tr>
                    <td>{{ $actividad->nombre }}</td> 
                    <td>{{ $actividad->nro_solicitud }}</td>
                    <td>{{ $actividad->nro_reforma }}</td>
                    <td>{{ $actividad->justificacion_area }}</td>
                    <td>{{ $actividad->tipo_reform }}</td> 
                    <td>{{ \Carbon\Carbon::parse($actividad->created_at)->format('Y-m-d') }}</td> 
                    <td>{{ $actividad->estado_reform }}</td> 
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay datos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
