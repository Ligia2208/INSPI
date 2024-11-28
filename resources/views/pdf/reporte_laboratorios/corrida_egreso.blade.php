<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corrida</title>
    <style>

        .table1, .table2, .table3 {
            width: 100%;
            border-collapse: collapse;
        }

        .logo {
            width: 150px;
        }

        .logo-img {
            width: 90%;
        }

        .instituto-title {
            font-size: 10px;
            font-weight: bold;
        }

        .direccion, .tecnica, .fecha {
            font-weight: bold;
        }

        .empty-cell {
            width: 2%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        thead th {
            background-color: #f2f2f2;
        }

        strong {
            font-weight: normal;
        }

        .height{
            height: 60px;
        }

    </style>
    </head>

    <body>
        <table id="table1" class="table1">
            <tr>
                <th rowspan="3" class="logo">
                    <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" class="logo-img">
                </th>
                <th colspan="2">REGISTRO DE REACTIVOS USADOS EN LA CORRIDA</th>
            </tr>
            <tr>
                <th>Macro-Proceso:</th>
                <th>Proceso Interno:</th>
            </tr>
            <tr>
                <td>{{ $datosLaboratorio->nombre_zonal }}</td>
                <td>{{ $datosLaboratorio->nombre_laboratorio }}</td>
            </tr>
            <tr>
                <th colspan="3" class="instituto-title">
                    INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA--INSPI--"LEOPOLDO IZQUIETA PÉREZ"
                </th>
            </tr>
            <tr>
                <th class="direccion">Dirección: <strong>{{ $datosLaboratorio->nombre_laboratorio }}</strong></th>
                <th class="tecnica">Técnica: <strong>{{ $corrida->tecnica }}</strong></th>
                <th class="fecha">FECHA EGRESO: <strong>{{ $corrida->fecha }}</strong></th>
            </tr>
            <tr>
                <th>Servicio:</th>
                <th colspan="2"><strong>{{ $corrida->servicio }}</strong></th>
            </tr>
        </table>

        <table id="table2" class="table2">
            <thead>
                <tr>
                    <th class="empty-cell"></th>
                    <th>N°</th>
                    <th>Prueba</th>
                    <th>Descripción de artículos</th>
                    <th>Lote</th>
                    <th>Unidad</th>
                    <th>ul x1</th>
                    <th>Rx-N</th>
                    <th>Totales</th>
                    <th class="empty-cell"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimientos as $datos)
                <tr>
                    <td class="empty-cell"></td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $datos->nombre_prueba }}</td>
                    <td>{{ $datos->nombre }}</td>
                    <td>{{ $datos->lote }}</td>
                    <td>{{ $datos->abreviatura }} ({{ $datos->uniNombre }})</td>
                    <td>{{ $datos->cantidad }}</td>
                    <td>{{ $datos->pruebas }}</td>
                    <td>{{ $datos->total }}</td>
                    <td class="empty-cell"></td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <th colspan="10" class="direccion"> Observaciones </th>
            </tr>
            <tr>
                <td colspan="10">{{ $corrida->observacion }}</td>
            </tr>
        </table>

        <table id="table3" class="table3">
            <tr>
                <th colspan="1">REVISÓ</th>
                <th colspan="1">RECIBÍ CONFORME</th>
            </tr>
            <tr>
                <th colspan="1" class="height"></th>
                <th colspan="1" class="height"></th>
            </tr>
            <tr>
                <th colspan="1">FIRMA</th>
                <th colspan="1">FIRMA</th>
            </tr>
        </table>

    </body>


</html>