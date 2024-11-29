<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJUSTE</title>
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
            text-align: left;
            border-bottom: none ;
            border-top: none;
        }
        #obs-conte{
            text-align: left;
            border-top: none;
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
    </style>
    </head>

@if($datosActa['transaccion'] == 'positivo')
    <body>
        <table id="table1" style="width: 100%;">

            <tr>
                <th rowspan="3" style="width: 150px;">
                    <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="100" height="100" style="width: 90%;">
                </th>

                <th style="width: 200px;" colspan="2">REGISTRO DE AJUSTE DE INGRESOS DE BIENES, MATERIALES, INSUMOS Y SUMINISTROS</th>
            </tr>

            <tr>
                <th style="width: 251px;">Macro-Proceso:</th>
                <th >Proceso Interno:</th>
            </tr>

            <tr>
                <td rowspan="">DIRECCIÓN DE GESTION <br>ADMINISTRATIVA-FINANCIERA</td>
                <td rowspan=""> BODEGA </td>
            </tr>

            <tr>
                <th colspan="3" style="font-size: 10px; font-weight: bold;"> <strong> INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA--INSPI--"LEOPOLDO IZQUIETA PÉREZ" </strong></th>
            </tr>

            <tr>
                <th id="id-d" style="font-weight: bold;">Dirección: <strong style="font-weight: normal;"> {{ $datosActa['laboratorio'] }} </strong></th>
                <th id="id-n" style="font-weight: bold;">Nro: <strong style="font-weight: normal;">{{ $datosActa['numero'] }}</strong></th>
                <th id="fecha"  style="font-weight: bold;">FECHA EGRESO: {{ $datosActa['fecha'] }}</th>
            </tr>
            <tr>
                <th id="id-d" style="font-weight: bold;">Tipo de movimiento: <strong style="font-weight: normal;"> Ingreso</strong></th>
                <th id="id-n" style="font-weight: bold;">RUC: <strong style="font-weight: normal;">{{ $datosActa['nombre'] }}</strong></th>
                <th id="fecha"  style="font-weight: bold;"></th>

            </tr>

        </table>

        <table id="table2" style="width: 100%;">
            <thead>
                <tr>
                    <th id="x" style="width: 2%;"></th>
                    <th style="width: 10%;">N°</th>
                    <th>Descripción de artículos</th>
                    <th>Cantidad</th>
                    <th>Lote</th>
                    <th style="width: 10%;">Unidad</th>
                    <th id="x" style="width: 2%;"></th>
                </tr>
            </thead>

            <tbody>
            @foreach($datosMovimiento as $datos)
                <tr>
                    <td id="x"></td>
                    <td><strong style="font-weight: normal;">{{ $loop->iteration }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->nombre }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->unidades }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->lote }}</strong></td>
                    <td style="width: 10%;"><strong style="font-weight: normal;">{{ $datos->uniNombre }}</strong></td>
                    <td id="x" style="width: 2%;"></td>
                </tr>
            @endforeach
            </tbody>

            <tr>
                <td id="obs" colspan="7"><strong>Observaciones</strong></td>
            </tr>

            <tr>
                <td id="obs-conte" colspan="7"><strong style="font-weight: normal;">{{ $datosActa['descripcion'] }}</strong></td>
            </tr>
        </table>


        <table id="table3" style="width: 100%;">
            <tr>
                <th id="lap"></th>
                <th id="las"></th>
                <th id="lat">ENTREGUE CONFORME</th>
                <th id="lac"></th>
                <th id="lacn"></th>
                <th id="lasx">RECIBI CONFORME</th>
                <th id="ul"></th>
            </tr>
            <tr>
                <th id="lap"></th>
                <th id="las"></th>
                <th id="lat"></th>
                <th id="lac"></th>
                <th id="lacn">FIRMA</th>
                <th id="lasx"></th>
                <th id="ul"></th>
            </tr>
            <tr>
                <th id="lap1"></th>
                <th id="las1"></th>
                <th id="lat1">BODEGA INSPI</th>
                <th id="lac1"></th>
                <th id="lacn1">NOMBRE</th>
                <th id="lasx1"></th>
                <th id="ul1"></th>
            </tr>
        </table>

    </body>


@elseif($datosActa['transaccion'] == 'negativo')
    <body>
        <table id="table1" style="width: 100%;">

            <tr>
                <th rowspan="3" style="width: 150px;">
                    <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="100" height="100" style="width: 90%;">
                </th>

                <th style="width: 200px;" colspan="2">REGISTRO DE AJUSTE DE EGRESOS DE BIENES, MATERIALES, INSUMOS Y SUMINISTROS</th>
            </tr>

            <tr>
                <th style="width: 251px;">Macro-Proceso:</th>
                <th >Proceso Interno:</th>
            </tr>

            <tr>
                <td rowspan="">DIRECCIÓN DE GESTION <br>ADMINISTRATIVA-FINANCIERA</td>
                <td rowspan=""> BODEGA </td>
            </tr>

            <tr>
                <th colspan="3" style="font-size: 10px; font-weight: bold;"> <strong> INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA--INSPI--"LEOPOLDO IZQUIETA PÉREZ" </strong></th>
            </tr>

            <tr>
                <th id="id-d" style="font-weight: bold;">Dirección: <strong style="font-weight: normal;"> {{ $datosActa['laboratorio'] }} </strong></th>
                <th id="id-n" style="font-weight: bold;">Nro: <strong style="font-weight: normal;">{{ $datosActa['numero'] }}</strong></th>
                <th id="fecha"  style="font-weight: bold;">FECHA EGRESO: {{ $datosActa['fecha'] }}</th>
            </tr>
            <tr>
                <th id="id-d" style="font-weight: bold;">Tipo de movimiento: <strong style="font-weight: normal;"> Egreso</strong></th>
                <th id="id-n" style="font-weight: bold;">RUC: <strong style="font-weight: normal;">{{ $datosActa['nombre'] }}</strong></th>
                <th id="fecha"  style="font-weight: bold;"></th>

            </tr>

        </table>

        <table id="table2" style="width: 100%;">
            <thead>
                <tr>
                    <th id="x" style="width: 2%;"></th>
                    <th style="width: 10%;">N°</th>
                    <th>Descripción de artículos</th>
                    <th>Cantidad</th>
                    <th>Lote</th>
                    <th style="width: 10%;">Unidad</th>
                    <th id="x" style="width: 2%;"></th>
                </tr>
            </thead>

            <tbody>
            @foreach($datosMovimiento as $datos)
                <tr>
                    <td id="x"></td>
                    <td><strong style="font-weight: normal;">{{ $loop->iteration }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->nombre }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->unidades }}</strong></td>
                    <td><strong style="font-weight: normal;">{{ $datos->lote }}</strong></td>
                    <td style="width: 10%;"><strong style="font-weight: normal;">{{ $datos->uniNombre }}</strong></td>
                    <td id="x" style="width: 2%;"></td>
                </tr>
            @endforeach
            </tbody>

            <tr>
                <td id="obs" colspan="7"><strong>Observaciones</strong></td>
            </tr>

            <tr>
                <td id="obs-conte" colspan="7"><strong style="font-weight: normal;">{{ $datosActa['descripcion'] }}</strong></td>
            </tr>
        </table>


        <table id="table3" style="width: 100%;">
            <tr>
                <th id="lap"></th>
                <th id="las"></th>
                <th id="lat">ENTREGUE CONFORME</th>
                <th id="lac"></th>
                <th id="lacn"></th>
                <th id="lasx">RECIBI CONFORME</th>
                <th id="ul"></th>
            </tr>
            <tr>
                <th id="lap"></th>
                <th id="las"></th>
                <th id="lat"></th>
                <th id="lac"></th>
                <th id="lacn">FIRMA</th>
                <th id="lasx"></th>
                <th id="ul"></th>
            </tr>
            <tr>
                <th id="lap1"></th>
                <th id="las1"></th>
                <th id="lat1">BODEGA INSPI</th>
                <th id="lac1"></th>
                <th id="lacn1">NOMBRE</th>
                <th id="lasx1"></th>
                <th id="ul1"></th>
            </tr>
        </table>

    </body>
@endif
</html>