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
                    <strong style="font-size: 12px;">REGISTRO DE CONTROL DE REACTIVOS Y FUNGIBLES</strong>
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
                <td colspan="14" class="text-left"> <strong> CIUDAD / ZONAL: </strong> <span> {{$results->nombre_zonal}} </span> </td>
            </tr>
            <tr>
                <td colspan="14" class="text-left"> <strong> CENTRO NACIONAL DE REFERENCIA / PLATAFORMA / ÁREA: </strong> <span> {{$results->nombre_laboratorio}} </span> </td>
            </tr>
            <tr>
                <td colspan="14" class="text-left"> <strong> NOMBRE DEL ARTÍCULO: </strong> 
                    <span>   @if(!empty($datosArt->descripcion))
                                {{$datosArt->descripcion}}
                            @else
                                {{$datosArt->nombre}}
                            @endif 
                    </span> 
                </td>
            </tr>

            <tr>
                <th rowspan="2" colspan="5">Movimientos</th>
                <th colspan="3">Unidad de Medidas</th>
                <th colspan="3">Cantidad Máxima</th>
                <th colspan="3">Cantidad Mínima</th>
            </tr>

            <tr>
                
                <th colspan="3">Entradas</th>
                <th colspan="3">Salidas</th>
                <th colspan="3">Saldos</th>
            </tr>

            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Lote</th>
                <th>U_medida</th>
                <th>Valor Inicial</th>
                <th>Cantidad</th>
                <th>Valor unitario</th>
                <th>Valor total</th>
                <th>Cantidad</th>
                <th>Valor unitario</th>
                <th>Valor total</th>
                <th>Cantidad</th>
                <th>Valor unitario</th>
                <th>Valor total</th>
            </tr>

            @foreach($movimientos as $movimi)
            <tr>
                <td>{{$movimi->fecha}}</td>
                <td>{{$movimi->tipo_movimiento}}</td>
                <td>{{$movimi->nom_lote}}</td>
                <td>{{$movimi->uni_nombre}} ( {{$movimi->uni_abreviatura}} ) </td>
                <td>{{$movimi->saldo_ini}}</td>

                @if($movimi->tipo == 'I' || $movimi->tipo == 'C' || ($movimi->tipo == 'A' && $movimi->transaccion == 'positivo') )
                <td>{{$movimi->unidades}}</td>
                <td>{{$movimi->precio}}</td>
                <td>{{$movimi->precio_total}}</td>
                <td></td>
                <td></td>
                <td></td>
                @elseif($movimi->tipo == 'T' || $movimi->tipo == 'E' || ($movimi->tipo == 'A' && $movimi->transaccion == 'negativo') )
                <td></td>
                <td></td>
                <td></td>
                <td>{{$movimi->unidades}}</td>
                <td>{{$movimi->precio}}</td>
                <td>{{$movimi->precio_total}}</td>
                @endif
                <td>{{$movimi->unidades}}</td>
                <td>{{$movimi->precio}}</td>
                <td>{{$movimi->saldo_fin}}</td>
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
