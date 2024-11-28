<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($datosActa['tipo'] == 'I')
            INGRESOS POR DONACIÓN
        @elseif($datosActa['tipo'] == 'C')
            INGRESOS POR COMPRA LOCAL
        @else
            INGRESOS
        @endif
    </title>
<style>
    table {
        border-collapse: collapse;

    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        height: -15%;
        font-family: sans-serif;
        font-size: 10px;
    }
    #id-n{
        border: none;

    }
    #id-d{
        border-top: none;
        border-bottom: none;
        border-right: none;
        width: 60%;
    }
    #id-n{
        text-align:right ;
    }
    #fecha{
        border-left: none;
        border-top: none;
        border-bottom: none ;

    }
    #lodeenmedio{
        width: 20%;
    }
    #obs{
        /* text-align: left; */
        border-bottom: none ;
        border-top: none;
        border-right: none;
    }
    #obs-conte{
        text-align: left;
        border-top: none;
        border-right: none;
        border-bottom: none;
    }
    #x{
        border-bottom: none ;
        border-top: none;
    }
    #lap{
        border-right: none;
        border-bottom: none;
        border-top: none;
    }
    #lap1{
        border-right: none;
        border-top: none;
    }
    #las{
        border-right: none;
        border-left: none;
        border-top: none;
        border-bottom: none;

    }
    #las1{
        border-right: none;
        border-left: none;
        border-top: none;


    }
    #lat{
        border-right: none;
        border-left: none;
        border-top: none;
        border-bottom: none;
    }
    #lat1{
        border-right: none;
        border-left: none;

    }
    #lac{
        border-right: none;
        border-left: none;
        border-top: none;
        border-bottom: none;

    }
    #lac1{
        border-right: none;
        border-left: none;
        border-top: none;

    }
    #lacn{
        border-right: none;
        border-left: none;
        border-top: none;
        border-bottom: none;

    }#lacn1{
        border-right: none;
        border-left: none;
        border-top: none;

    }
    #lasx{
        border-left: none;
        border-top: none;
        border-bottom: none;
        border-right: none;

    }#lasx1{
        border-right: none;
        border-left: none;
    }
    #ul{
        border-left: none;
        border-bottom: none;
        border-top: none;
    }
    #ul1{
        border-left: none;
        border-top: none;
    }
    #nuevo{
        border-left: none;
        border-top: none;
        border-bottom: none;
    }
    #bodega{
        border-left: none;
        border-top: none;
        border-bottom: none;
    }
    #ultimo{
        border-right: none;
        border-top: none;
    }#mm{
        border-left: none;
        border-top: none;
    }#ull{
        border-right: none ;
        border-left: none;
    }
    .signature-line {
        width: 30%;
        margin: 0 auto;
        border-top: 1px solid black;
        margin-bottom: 3px;
    }

    .signature-container {
        border-top: none;
        text-align: center;
    }
</style>
</head>
<body>

@if($datosActa['tipo'] == 'I')
    <!-- Contenido para Donación -->
    <table id="table1" style="width: 100%;">
        <tr>
            <th rowspan="3" style="width: 150px;">
                <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="100" height="100" style="width: 90%;">
            </th>
            <th class="uno" colspan="2">REGISTRO DE INGRESO DE BIENES, MATERIALES, INSUMOS Y SUMINISTROS POR DONACIÓN</th>
        </tr>

        <tr>
            <th style="width: 250px;">Macro-Procesos</th>
            <th>Proceso Interno</th>
        </tr>

        <tr>
            <td rowspan="">DIRECCIÓN DE GESTION <br>ADMINISTRATIVA-FINANCIERA</td>
            <td rowspan=""> BODEGA </td>
        </tr>

        <tr>
            <th colspan="3" style="font-size: 10px;">INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA--INSPI--"LEOPOLDO IZQUIETA PÉREZ"</th>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="3" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">TIPO DE MOVIMIENTO: <strong style="font-weight: normal;"> Donación </strong> </th>
            <th id="fecha" style="font-weight: bold;">NRO: <strong style="font-weight: normal;">{{ $datosActa['no_ingreso'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">RUC: <strong style="font-weight: normal;">{{ $datosActa['nombre'] }}</strong> </th>
            <th id="fecha" style="font-weight: bold;">FECHA DE INGRESO: <strong style="font-weight: normal;">{{ $datosActa['fecha'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">PROVEEDOR: <strong style="font-weight: normal;">{{ $datosActa['proveedor'] }}</strong></th>
            <th id="fecha" style="font-weight: bold;">DESTINO: <strong style="font-weight: normal;">{{ $datosActa['laboratorio'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">No. ORDEN DE COMPRA: <strong style="font-weight: normal;">{{ $datosActa['n_contrato'] }}</strong></th>
            <th id="fecha" style="width: 20%; font-weight: bold;"><strong style="font-weight: normal;"></strong></th>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="3" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
    </table>

    <table id="table2" style="width: 100%;">
        <tr>
            <th id="x" style="width: 2%;"></th>
            <th style="width: 9%; font-size: 7px;">N°</th>
            <th style="font-size: 7px;">Descripcion de artículos</th>
            <th style="font-size: 7px;">Cantidad</th>
            <th style="font-size: 7px;">Unidad</th>
            <th style="font-size: 7px;">Caduca</th>
            <th style="font-size: 7px;">Fecha de elaboración</th>
            <th style="font-size: 7px;">Fecha de expiración</th>
            <th style="font-size: 7px;">Lote</th>
            <th style="font-size: 7px;">Costo unitario</th>
            <th style="font-size: 7px;">Costo total</th>
            <td id="x" style="width: 1%;"></td>
        </tr>

        @foreach($datosMovimiento as $datos)
        <tr>
            <td id="x"></td>
            <td><strong style="font-size: 7px;">{{ $loop->iteration }}</strong></td>
            <td><strong style="font-size: 7px;">{{ $datos->nombre }}</strong></td>
            <td><strong style="font-size: 7px;">{{ $datos->unidades }}</strong></td>
            <td style="font-size: 7px;"><strong>{{ $datos->uniNombre }}</strong></td>
            <th style="font-size: 7px;">
                @if ($datos->caduca == 'true')
                    Sí
                @else
                    No
                @endif
            </th>
            <th style="font-size: 7px;">{{ $datos->fecha_ela }}</th>
            <th style="font-size: 7px;">{{ $datos->fecha_cad }}</th>
            <th style="font-size: 7px;">{{ $datos->lote }}</th>
            <th style="font-size: 7px;">{{ $datos->precio}}</th>
            <th style="font-size: 7px;">{{ $datos->total}}</th>
            <td id="x" style="width: 1%;"></td>
        </tr>
        @endforeach

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td id="obs" colspan="3" style="font-weight: bold;">Observaciones: </td>
            <td id="nuevo" colspan="9" style="font-weight: bold;">{{ $datosActa['descripcion'] }}</td>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td id="obs-conte" colspan="11" style="font-weight: normal; text-align: center;">RECIBÍ CONFORME</td>
            <td id="bodega" style="font-weight: normal;"></td>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td colspan="12" class="signature-container">
            <div class="signature-line"></div>
            BODEGA INSPI
        </td>
    </table>

@elseif($datosActa['tipo'] == 'C')
    <!-- Contenido para Compra Local -->
    <!-- Contenido para Donación -->
    <table id="table1" style="width: 100%;">
        <tr>
            <th rowspan="3" style="width: 150px;">
                <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="100" height="100" style="width: 90%;">
            </th>
            <th class="uno" colspan="2">REGISTRO DE INGRESO DE BIENES, MATERIALES, INSUMOS Y SUMINISTROS POR COMPRA LOCAL</th>
        </tr>

        <tr>
            <th style="width: 250px;">Macro-Procesos</th>
            <th>Proceso Interno</th>
        </tr>

        <tr>
            <td rowspan="">DIRECCIÓN DE GESTION <br>ADMINISTRATIVA-FINANCIERA</td>
            <td rowspan=""> BODEGA </td>
        </tr>

        <tr>
            <th colspan="3" style="font-size: 10px;">INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA--INSPI--"LEOPOLDO IZQUIETA PÉREZ"</th>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="3" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">TIPO DE MOVIMIENTO: <strong style="font-weight: normal;"> Compra local </strong> </th>
            <th id="fecha" style="font-weight: bold;">NRO: <strong style="font-weight: normal;">{{ $datosActa['no_ingreso'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">RUC: <strong style="font-weight: normal;">{{ $datosActa['nombre'] }}</strong> </th>
            <th id="fecha" style="font-weight: bold;">FECHA DE INGRESO: <strong style="font-weight: normal;">{{ $datosActa['fecha'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">PROVEEDOR: <strong style="font-weight: normal;">{{ $datosActa['proveedor'] }}</strong></th>
            <th id="fecha" style="font-weight: bold;">DESTINO: <strong style="font-weight: normal;">{{ $datosActa['laboratorio'] }}</strong></th>
        </tr>

        <tr>
            <th id="id-d" colspan="2" style="font-weight: bold;">No. ORDEN DE COMPRA: <strong style="font-weight: normal;">{{ $datosActa['n_contrato'] }}</strong></th>
            <th id="fecha" style="width: 20%; font-weight: bold;">DOCUMENTO DE RESPALDO: <strong style="font-weight: normal;">{{ $datosActa['factura'] }}</strong></th>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="3" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
    </table>

    <table id="table2" style="width: 100%;">
        <tr>
            <th id="x" style="width: 2%;"></th>
            <th style="width: 9%; font-size: 7px;">N°</th>
            <th style="font-size: 7px;">Descripcion de artículos</th>
            <th style="font-size: 7px;">Cantidad</th>
            <th style="font-size: 7px;">Unidad</th>
            <th style="font-size: 7px;">Caduca</th>
            <th style="font-size: 7px;">Fecha de elaboración</th>
            <th style="font-size: 7px;">Fecha de expiración</th>
            <th style="font-size: 7px;">Lote</th>
            <th style="font-size: 7px;">Costo unitario</th>
            <th style="font-size: 7px;">Costo total</th>
            <td id="x" style="width: 1%;"></td>
        </tr>

        @foreach($datosMovimiento as $datos)
        <tr>
            <td id="x"></td>
            <td><strong style="font-size: 7px;">{{ $loop->iteration }}</strong></td>
            <td><strong style="font-size: 7px;">{{ $datos->nombre }}</strong></td>
            <td><strong style="font-size: 7px;">{{ $datos->unidades }}</strong></td>
            <td style="font-size: 7px;"><strong>{{ $datos->uniNombre }}</strong></td>
            <th style="font-size: 7px;">
                @if ($datos->caduca == 'true')
                    Sí
                @else
                    No
                @endif
            </th>
            <th style="font-size: 7px;">{{ $datos->fecha_ela }}</th>
            <th style="font-size: 7px;">{{ $datos->fecha_cad }}</th>
            <th style="font-size: 7px;">{{ $datos->lote }}</th>
            <th style="font-size: 7px;">{{ $datos->precio}}</th>
            <th style="font-size: 7px;">{{ $datos->total}}</th>
            <td id="x" style="width: 1%;"></td>
        </tr>
        @endforeach

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td id="obs" colspan="3" style="font-weight: bold;">Observaciones: </td>
            <td id="nuevo" colspan="9" style="font-weight: bold;">{{ $datosActa['descripcion'] }}</td>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td id="obs-conte" colspan="11" style="font-weight: normal; text-align: center;">RECIBÍ CONFORME</td>
            <td id="bodega" style="font-weight: normal;"></td>
        </tr>

        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr style="border-right: 1px solid black; border-left: 1px solid black;">
            <th colspan="12" class="invisible" style="border-right: none; border-left: none; border-top: none; border-bottom: none;"></th>
        </tr>
        <tr>
            <td colspan="12" class="signature-container">
            <div class="signature-line"></div>
            BODEGA INSPI
        </td>
    </tr>
    </table>

@else
    <div style="text-align: center; font-size: 24px; margin-top: 50px;">
        No existe información para mostrar
    </div>
@endif


</body>
</html>
