<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Resultados</title>
</head>
<style>

    .borde{
        border-collapse: collapse;
        border: solid black;
    }



    .espacio-entre-tr {
        border-collapse: separate; /* Asegura que las celdas se comporten como elementos separados */
        border-spacing: 0 10px; /* Espacio entre filas */
    }
    .espacio-entre-tr .margen-bottom {
        margin-bottom: 10px; 
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 5px;
        text-align: center;
    }

</style>

<body>



<div style="width: 100%; height: auto; position: relative;">

    <!-- CABEZERA -->
    <div style="margin-top: 0px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div class="borde" style="width: 15%; height: 66px; position: absolute; top: 0; left: 0; border: 1px solid black;">
            <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="80" height="40" style="margin-left: 10%; margin-top: 4%;">
        </div>

        <div style="width: 65%; height: 50px; position: absolute; top: 0; left: 15%;">

            <div class="borde" style="width: 100%; height: 30px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 21px;">
                <strong style="font-size: 12px;">REGISTRO DE INFLUENZA POR PCR EN TIEMPO REAL</strong>
            </div>

            <div style="width: 100%; height: 25px; position: absolute; top: 31px; left: 0; display: flex;">

                <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 12px;">
                    <strong style="font-size: 10px;">Macro-Proceso:</strong><br>
                    <span style="font-size: 10px;">Laboratorio de Vigilancia Epidemiológica y Referencia nacional</span>
                </div>

                <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 50%; border: 1px solid black; text-align: center; line-height: 12px;">
                    <strong style="font-size: 10px;">Proceso Interno:</strong><br>
                    <span style="font-size: 10px;">Centro de Referencia Nacional de Influenza y Otros Virus Respitatorios</span>
                </div>

            </div>

        </div>

        <div style="width: 8%; height: 50px; position: absolute; top: 0; left: 80%; text-align: center;">

            <div class="borde" style="width: 100%; height: 15px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 12px; text-align: center;">
                <strong style="font-size: 10px;">Código</strong>
            </div>

            <div class="borde" style="width: 100%; height: 14px; position: absolute; top: 16px; left: 0; display: flex; border: 1px solid black; line-height: 12px; text-align: center;">
                <strong style="font-size: 10px;">Edición</strong>
            </div>

            <div class="borde" style="width: 100%; height: 35px; position: absolute; top: 31px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                <strong style="font-size: 10px;">Fecha de aprobación</strong>
            </div>

        </div>


        <div style="width: 12%; height: 50px; position: absolute; top: 0; left: 88%;">

            <div class="borde" style="width: 100%; height: 15px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 12px; text-align: center;">
                <span style="font-size: 10px;">F-FLU-006</span>
            </div>

            <div class="borde" style="width: 100%; height: 14px; position: absolute; top: 16px; left: 0; display: flex; border: 1px solid black; line-height: 12px; text-align: center;">
                <span style="font-size: 10px;">03</span>
            </div>

            <div class="borde" style="width: 100%; height: 35px; position: absolute; top: 31px; left: 0; display: flex; border: 1px solid black; line-height: 26px; text-align: center;">
                <span style="font-size: 10px;">04/05/2022</span>
            </div>

        </div>

    </div>
    <!-- CABEZERA -->

    <!-- DATOS DEL ANALISTA -->
    <div style="margin-top: 80px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">

            <div style="width: 70%; height: 24px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center;">

                <div style="width: 30%; height: 24px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center;">
                    <strong style="font-size: 10px;">Operador de la prueba:</strong><br>
                    <strong style="font-size: 10px;">Protocolo:</strong>
                </div>

                <div style="width: 70%; height: 24px; position: absolute; top: 0; left: 30%; line-height: 12px; text-align: left;">
                    <spam style="font-size: 10px;">{{$corrida->name}}</spam><br>
                    <spam style="font-size: 10px;">{{$corrida->servicio}}</spam>
                </div>
            </div>

            <div style="width: 30%; height: 24px; position: absolute; top: 0; left: 70%; display: flex;  text-align: center;">

                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">
                    <strong style="font-size: 10px;">Fecha: </strong> <spam style="font-size: 10px;">{{$corrida->fecha}}</spam>
                </div>

            </div>
                
        </div>

        <div style="width: 100%; height: 24px; position: absolute; top: 25px; left: 0px; line-height: 9px; text-align: center;">

            <div style="width: 20%; height: 24px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center;">
                <strong style="font-size: 10px;">Mezcla Maestra:</strong><br>
            </div>

            <div style="width: 80%; height: 24px; position: absolute; top: 0; left: 20%; line-height: 12px; text-align: left;">
                <strong style="font-size: 10px;">Influenza estacional:</strong> <spam style="font-size: 10px;"> {{$corrida->estacional}}</spam><br>
                <strong style="font-size: 10px;">Influenza Variante H1N12009:</strong> <spam style="font-size: 10px;"> {{$corrida->variante}}</spam>
            </div>
        </div>
        
    </div>
    <!-- DATOS DEL ANALISTA -->


    <!-- CUERPO 1 -->
    <div style="margin-top: 140px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">

            <?php $cuerpo0Total = 50; ?>
            <!-- EXTRACCION DE ARN -->
            <!-- <div style="width: 20%; height: 121px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center;">

                <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;">1. EXTRACCION DE ARN</strong>
                    </div>
                </div>

                <div style="width: 100%; height: 10px; position: absolute; top: 11px; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;">Fecha: </strong> <spam style="font-size: 5px;"> {{$corrida->fecha}} </spam>
                    </div>
                </div>

                <div style="width: 100%; height: 10px; position: absolute; top: 22px; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;">Código Muestra</strong>
                    </div>

                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;">Tipo de Muestra</strong>
                    </div>
                </div>

                <?php $conExtra = 33; ?>

                @foreach($extraccionDet as $extra)
                <div style="width: 100%; height: 10px; position: absolute; top: {{$conExtra}}px; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 5px;">{{$extra->cod_muestra}}</spam>
                    </div>

                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 5px;">{{$extra->nombre}}</spam>
                    </div>
                </div>
                <?php $conExtra += 11; $cuerpo0Total += 11;?>
                @endforeach

                <div style="width: 100%; height: 30px; position: absolute; top: {{$conExtra}}px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">

                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: left;">
                        <strong style="font-size: 5px;"> Observaciones: </strong>
                    </div>

                    <div style="width: 100%; height: 20px; position: absolute; top: 10px; left: 0; line-height: 9px; text-align: center;">
                        <spam style="font-size: 5px;"> {{$extraccion->observacion}} </spam>
                    </div>

                </div>

                <div style="width: 100%; height: 30px; position: absolute; top: {{$conExtra+31}}px; left: 0px; line-height: 12px; text-align: center; border: 1px solid black;">

                    <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; ">
                        <strong style="font-size: 5px;">Nombre kit</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 0; left: 40%; line-height: 8px; text-align: center; ">
                        <spam style="font-size: 5px;">{{$extraccion->nombre}}</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 10px; left: 0; line-height: 8px; text-align: center; ">
                        <strong style="font-size: 5px;">Lote</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 10px; left: 40%; line-height: 8px; text-align: center; ">
                        <spam style="font-size: 5px;">{{$extraccion->lote}}</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 20px; left: 0; line-height: 8px; text-align: center; ">
                        <strong style="font-size: 5px;">Caducidad</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 20px; left: 40%; line-height: 8px; text-align: center; ">
                        <spam style="font-size: 5px;">{{$extraccion->f_caduca}}</spam>
                    </div>

                </div>


            </div> -->
            <!-- EXTRACCION DE ARN -->



            <?php $cuerpo1Total = 50; ?>

            <!-- MEZCLA DE REACCION -->
            <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0%; display: flex; text-align: center;">

                <div style="width: 90%; height: 54px; position: absolute; top: 0; left: 5%; display: flex; text-align: center;">

                    <div style="width: 100%; height: 24px; position: absolute; top: 0px; left: 0; line-height: 12px; text-align: center;">

                        <div style="width: 40%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 10px;"> Reactivo </strong>
                            </div>

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 10px;"> Lote </strong>
                            </div>

                        </div>

                        <?php $conMezcla = 25; ?>

                        @foreach($mezcla as $mez)
                        <div style="width: 40%; height: 10px; position: absolute; top: {{$conMezcla}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 10px;"> {{$mez->reactivo}} </spam>
                            </div>

                            <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 50%; line-height: 15px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 10px;"> {{$mez->lote}} </spam>
                            </div>

                        </div>
                        <?php $conMezcla += 17;  $cuerpo1Total += 17;?>
                        @endforeach

                        <div style="width: 40%; height: 10px; position: absolute; top: {{$conMezcla}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 100%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: end; border: 1px solid black;">
                                <spam style="font-size: 10px;"> Volúmen total (uL) </spam>
                            </div>

                        </div>

                        <div style="width: 40%; height: 16px; position: absolute; top: {{$conMezcla+17}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 100%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: end; border: 1px solid black;">
                                <spam style="font-size: 10px;"> ARN (uL) </spam>
                            </div>

                        </div>

                    
                        <!-- DATOS DE LA MEZCLA -->
                        <div style="width: 60%; height: 24px; position: absolute; top: 0; left: 40%; line-height: 16px; text-align: center;">
                            
                            <?php 
                            $withMezcla = 84/count($examenes); 
                            $totalExa = $withMezcla/2;
                            $topExa = 0;
                            $volumenTotal = 0;
                            ?>

                            <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">


                                @foreach($examenes as $exa)
                                <div style="width: {{$totalExa}}%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 16px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 10px;"> 1rx (uL) </strong>
                                </div>
                                <?php $topExa += $totalExa; ?>
                                <div style="width: {{$totalExa}}%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 16px; text-align: center;">

                                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 10px;"> RT - PCR </strong>
                                    </div>
                                    <!-- <div style="width: 100%; height: 8px; position: absolute; top: 9px; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 10px;"> {{$exa->nombre}} </strong>
                                    </div> -->
                                    <div style="width: 100%; height: 11px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 10px;"> {{$exa->cant}} </strong>
                                    </div>

                                </div>
                                <?php $topExa += $totalExa;  $volumenTotal += $exa->cant; ?>
                                @endforeach

                                <div style="width: 16%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 10px;"> Total reactivo (uL) </strong>
                                </div>

                            </div>

                            <?php $topExa2 = 0; $totalRT = 0; $totalRX = 0; ?>
                            @foreach($arrayMezclas as $mezclaEx)
                            <div style="width: {{$withMezcla}}%; height: 10px; position: absolute; top: 25px; left: {{$topExa2}}%; line-height: 16px; text-align: center;">

                                <?php $topExaDet2 = 0; ?>
                                
                                @foreach($mezclaEx['mezclaDet'] as $detMez)
                                <div style="width: 100%; height: 16px; position: absolute; top: {{$topExaDet2}}px; left: 0; line-height: 9px; text-align: center; ">

                                    <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 10px;"> {{$detMez->rx}} </spam>
                                    </div>

                                    <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 50%; line-height: 15px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 10px;"> {{$detMez->rt}} </spam>
                                    </div>

                                </div>
                                <?php $topExaDet2 += 17; $totalRT += $detMez->rt; $totalRX += $detMez->rx; ?>
                                @endforeach

                                <div style="width: 100%; height: 16px; position: absolute; top: {{$topExaDet2}}px; left: 0; line-height: 9px; text-align: center; ">

                                    <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 10px;"> {{$totalRX}} </spam>
                                    </div>

                                    <div style="width: 50%; height: 16px; position: absolute; top: 0; left: 50%; line-height: 15px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 10px;"> {{$totalRT}} </spam>
                                    </div>

                                </div>


                            </div>
                            <?php $topExa2 += $withMezcla; ?>
                            @endforeach

                            <?php $topExa3 = 25; $sumTotalRT = 0; ?>
                            @foreach($resultadosMez as $reult)
                            <div style="width: 16%; height: 16px; position: absolute; top: {{$topExa3}}px; left: {{$topExa2}}%; line-height: 15px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 10px;"> {{$reult->total_rt}} </spam>
                            </div>
                            <?php $topExa3 += 17; $sumTotalRT += $reult->total_rt;?>
                            @endforeach

                            <div style="width: 16%; height: 16px; position: absolute; top: {{$topExa3}}px; left: {{$topExa2}}%; line-height: 15px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 10px;"> {{$sumTotalRT}} </spam>
                            </div>

                            <div style="width: 100%; height: 16px; position: absolute; top: {{$topExaDet2+42}}px; left: ; line-height: 16px; text-align: center;">

                                <div style="width: 100%; height: 16px; position: absolute; top: 0; left: 0; line-height: 15px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 10px;"> {{$volumenTotal}} </spam>
                                </div>

                            </div>


                        </div>
                        <!-- DATOS DE LA MEZCLA -->

                    </div>

                    <div style="width: 100%; height: 40px; position: absolute; top: {{$topExa3+46}}px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">

                        <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: left;">
                            <strong style="font-size: 10px;"> Observaciones: </strong>
                        </div>

                        <div style="width: 100%; height: 30px; position: absolute; top: 10px; left: 0; line-height: 9px; text-align: center;">
                            <spam style="font-size: 10px;"> {{$corrida->observacion}} </spam>
                        </div>

                    </div>

                </div>

            </div>
            <!-- MEZCLA DE REACCION -->


            <?php 
                $cuerpo1Total += 60;
                $cuerpo0Total += 60;
                
                if($cuerpo1Total > $cuerpo0Total){
                    $totalCabezera = $cuerpo1Total;
                }else{
                    $totalCabezera = $cuerpo0Total;
                }
            ?>


        </div>

    </div>
    <!-- CUERPO 1 -->

    <?php $cuerpo2Total = 295;  ?>

        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo2Total}}px; left: 0; display: flex; text-align: center;">
            <div style="width: 90%; height: 24px; position: absolute; top: 0; left: 5%; display: flex; text-align: center;">
                <table>
                    <thead>
                        <tr>
                            <th>Master Mix</th>
                            @for ($i = 1; $i <= 12; $i++)
                                <th>{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                            //$data = ['Q-', 'M1', 'M2', 'M3', 'M4', 'M5', 'C+', '', '', '', '', ''];
                            //$extraccionDet;
                            $grid = array_fill(0, 8, array_fill(0, 12, '')); // 8 rows x 12 columns

                            foreach ($extraccionDet as $index => $value) {
                                $row = $index % 8; // 0 to 7 (for rows A to H)
                                $col = intdiv($index, 8); // increment column every 8 items
                                $grid[$row][$col] = $value->cod_muestra;
                            }
                        @endphp
                        @foreach ($rows as $rowIndex => $row)
                            <tr>
                                <td>{{ $row }}</td>
                                @foreach ($grid[$rowIndex] as $cell)
                                    <td>{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo2Total+290}}px; left: 0; display: flex; text-align: center;">

            <div style="width: 90%; height: 54px; position: absolute; top: 0; left: 5%; display: flex; text-align: left; border: 1px solid black;">

                <strong style="font-size: 10px; margin-left: 2px;"> Prueba positiva (+) con señal de amplificación <= 37 ciclos; prueba negativa (-) 
                    con señal de amplificación de 38 a 40 ciclos </strong> <br>

                <strong style="font-size: 10px; margin-left: 2px;"> En base al instructivo 0-FLU-054 </strong>
  
            </div>

        </div>


        <!-- CUERPO 3 -->
        <?php $cuerpo3Total = 365 + $cuerpo2Total;  ?>
        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo3Total}}px; left: 0; display: flex; text-align: center;">

            <div style="width: 90%; height: 54px; position: absolute; top: 0; left: 5%; display: flex; text-align: center;">

                <div style="width: 50%; height: 35px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: left; ">
                    <strong style="font-size: 10px; margin-left: 2px;"> Revisado por: </strong>
                    <spam style="font-size: 10px; "> {{$usuarios['revisado']['name']}} </spam> <br>

                    <!-- <strong style="font-size: 5px; margin-left: 2px;"> Reportado por: </strong>
                    <spam style="font-size: 5px;"> {{$usuarios['reporta']['name']}} </spam> -->
                </div>

                <div style="width: 50%; height: 35px; position: absolute; top: 0; right: 0; line-height: 20px; text-align: center; ">
                    <strong style="font-size: 10px; margin-left: 2px;"> Aprobado por: </strong>
                    <spam style="font-size: 10px;"> {{$usuarios['autoriza']['name']}} </spam> <br>
                </div>

            </div>

        </div>
        <!-- CUERPO 3 -->

        <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 780, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
	</script>

</div>
      


</body>
</html>








