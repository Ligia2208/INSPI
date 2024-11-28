<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro de Control de Reactivos y Fungibles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header, .header td {
            border: none;
        }

        .mt-10{
            margin-top: 60px;
        }
        .text-left{
            text-align: left;
        }
    </style>
</head>
<body>

    <div style="width: 100%; height: auto; position: relative; margin-left: 10px;">

        <!-- CABEZERA -->
        <div style="margin-top: 0px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

            <div class="borde" style="width: 15%; height: 66px; position: absolute; top: 0; left: 0; border: 1px solid black;">
                <img src="{{ public_path('img/logo_inspi.jpg') }}" alt="Foto" width="125" height="40" style="margin-left: 10%; margin-top: 8%;">
            </div>

            <div style="width: 65%; height: 50px; position: absolute; top: 0; left: 15%;">

                <div class="borde" style="width: 100%; height: 30px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 21px;">
                    <strong style="font-size: 12px;">REGISTRO DE CONTROL DE REACTIVOS Y FUNGIBLES - REPORTE GENERAL</strong>
                </div>

                <div style="width: 100%; height: 25px; position: absolute; top: 31px; left: 0; display: flex;">

                    <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 12px;">
                        <strong style="">Macro-Proceso:</strong><br>
                        <span style="">Aseguramiento de Calidad de Resultados</span>
                    </div>

                    <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 50%; border: 1px solid black; text-align: center; line-height: 12px;">
                        <strong style="">Proceso Interno:</strong><br>
                        <span style="">Aseguramiento de Calidad Institucional</span>
                    </div>

                </div>

            </div>

            <div style="width: 8%; height: 50px; position: absolute; top: 0; left: 80%; text-align: center;">

                <div class="borde" style="width: 100%; height: 15px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 12px; text-align: center;">
                    <strong style="">Código</strong>
                </div>

                <div class="borde" style="width: 100%; height: 14px; position: absolute; top: 16px; left: 0; display: flex; border: 1px solid black; line-height: 12px; text-align: center;">
                    <strong style="">Edición</strong>
                </div>

                <div class="borde" style="width: 100%; height: 35px; position: absolute; top: 31px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                    <strong style="">Fecha de aprobación</strong>
                </div>

            </div>


            <div style="width: 12%; height: 50px; position: absolute; top: 0; left: 88%;">

                <div class="borde" style="width: 100%; height: 15px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 12px; text-align: center;">
                    <span style="">F-ACL-024</span>
                </div>

                <div class="borde" style="width: 100%; height: 14px; position: absolute; top: 16px; left: 0; display: flex; border: 1px solid black; line-height: 12px; text-align: center;">
                    <span style="">01</span>
                </div>

                <div class="borde" style="width: 100%; height: 35px; position: absolute; top: 31px; left: 0; display: flex; border: 1px solid black; line-height: 26px; text-align: center;">
                    <span style="">5/4/2018</span>
                </div>

            </div>

        </div>
        <!-- CABEZERA -->

    </div>


    <div class="container mt-10">
        <table>
            <tr>
                <td colspan="5" class="text-left"> <strong> CIUDAD / ZONAL: </strong> <span> {{$results->nombre_zonal}} </span> </td>
            </tr>
            <tr>
                <td colspan="5" class="text-left"> <strong> CENTRO NACIONAL DE REFERENCIA / PLATAFORMA / ÁREA: </strong> <span> {{$results->nombre_laboratorio}} </span> </td>
            </tr>
            <tr>
                <td colspan="5" class="text-left"> <strong> DESDE: </strong> <span> {{$fInicio}} </span> <strong> HASTA: </strong> <span> {{$fFin}}  </span> </td>
            </tr>

            <tr>
                <th> REACTIVO/FUNGIBLE </th>
                <th> SALDO INICIAL </th>
                <th> INGRESADOS </th>
                <th> CONSUMIDOS </th>
                <th> SALDO FINAL </th>
            </tr>

            

            @foreach($resultadoFinal as $datos)
            
            <tr>
                <td>{{ $datos['reactivo'] }}</td>
                <td>{{ $datos['saldo_inicial'] }}</td>
                <td>{{ $datos['ingresado'] }}</td>
                <td>{{ $datos['consumo'] }}</td>
                <td>{{ $datos['saldo_final'] }}</td>
            </tr>
            @endforeach

        </table>

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(380, 570, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 7);
                ');
            }
        </script>

    </div>

</body>
</html>
