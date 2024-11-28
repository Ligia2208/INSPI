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

</style>

<body>



<div style="width: 100%; height: auto; position: relative;">

    <!-- CABEZERA -->
    <div style="margin-top: 0px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div class="borde" style="width: 15%; height: 51px; position: absolute; top: 0; left: 0; border: 1px solid black;">
            <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="80" height="40" style="margin-left: 10%; margin-top: 4%;">
        </div>

        <div style="width: 65%; height: 50px; position: absolute; top: 0; left: 15%;">

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 18px;">
                <strong style="font-size: 7px;">REGISTRO DE TRABAJO Y RESULTADOS DE PCR EN TIEMPO REAL</strong>
            </div>

            <div style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex;">

                <div class="borde" style="width: 50%; height: 25px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 9px;">
                    <strong style="font-size: 5px;">Macro-Proceso:</strong><br>
                    <span style="font-size: 5px;">Laboratorio de Vigilancia Epidemiológica y Referencia nacional</span>
                </div>

                <div class="borde" style="width: 50%; height: 25px; position: absolute; top: 0; left: 50%; border: 1px solid black; text-align: center; line-height: 9px;">
                    <strong style="font-size: 5px;">Proceso Interno:</strong><br>
                    <span style="font-size: 5px;">Centro de Referencia Nacional de Virus Exantemáticos, Gastroentéricos y Transmitidos por Vectores</span>
                </div>

            </div>

        </div>

        <div style="width: 8%; height: 50px; position: absolute; top: 0; left: 80%; text-align: center;">

            <div class="borde" style="width: 100%; height: 11.5px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 5px;">Código</strong>
            </div>

            <div class="borde" style="width: 100%; height: 12.5px; position: absolute; top: 12.5px; left: 0; display: flex; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 5px;">Edición</strong>
            </div>

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                <strong style="font-size: 5px;">Fecha de aprobación</strong>
            </div>

        </div>


        <div style="width: 12%; height: 50px; position: absolute; top: 0; left: 88%;">

            <div class="borde" style="width: 100%; height: 11.5px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <span style="font-size: 5px;">F-EGTV-006</span>
            </div>

            <div class="borde" style="width: 100%; height: 12.5px; position: absolute; top: 12.5px; left: 0; display: flex; border: 1px solid black; line-height: 9px; text-align: center;">
                <span style="font-size: 5px;">00</span>
            </div>

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                <span style="font-size: 5px;">25/01/2021</span>
            </div>

        </div>

    </div>
    <!-- CABEZERA -->

    <!-- DATOS DEL ANALISTA -->
    <div style="margin-top: 60px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">

            <div class="borde" style="width: 45%; height: 24px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">

                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center;">
                    <strong style="font-size: 5px;">Analista Técnico:</strong><br>
                    <strong style="font-size: 5px;">Técnica de RT-qPCR para:</strong>
                </div>

                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center;">
                    <spam style="font-size: 5px;">{{$corrida->name}}</spam><br>
                    <spam style="font-size: 5px;">{{$corrida->servicio}}</spam>
                </div>
            </div>

            <div class="borde" style="width: 55%; height: 24px; position: absolute; top: 0; left: 45%; display: flex; border: 1px solid black; text-align: center;">

                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">
                    <strong style="font-size: 5px;">Equipos utilizados para RT-qPCR: </strong>
                </div>

                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center;">
                    <spam style="font-size: 5px;">{{$corrida->equipos}}</spam>
                </div>

            </div>
                
        </div>
        
    </div>
    <!-- DATOS DEL ANALISTA -->


    <!-- CUERPO 1 -->
    <div style="margin-top: 90px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">

            <?php $cuerpo0Total = 50; ?>
            <!-- EXTRACCION DE ARN -->
            <div style="width: 20%; height: 121px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center;">

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


            </div>
            <!-- EXTRACCION DE ARN -->



            <?php $cuerpo1Total = 50; ?>

            <!-- MEZCLA DE REACCION -->
            <div style="width: 80%; height: 24px; position: absolute; top: 0; left: 20%; display: flex; text-align: center;">

                <div style="width: 96%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> 2. MEZCLA DE REACCION </strong>
                    </div>

                    <div style="width: 100%; height: 24px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">

                        <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 30%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 5px;"> Reactivo </strong>
                            </div>

                            <div style="width: 30%; height: 24px; position: absolute; top: 0; left: 30%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 5px;"> Marca </strong>
                            </div>

                            <div style="width: 40%; height: 24px; position: absolute; top: 0; left: 60%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 5px;"> Lote </strong>
                            </div>

                        </div>

                        <?php $conMezcla = 25; ?>

                        @foreach($mezcla as $mez)
                        <div style="width: 50%; height: 10px; position: absolute; top: {{$conMezcla}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$mez->reactivo}} </spam>
                            </div>

                            <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 30%; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> Invitrogen </spam>
                            </div>

                            <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 60%; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$mez->lote}} </spam>
                            </div>

                        </div>
                        <?php $conMezcla += 11;  $cuerpo1Total += 11;?>
                        @endforeach

                        <div style="width: 50%; height: 10px; position: absolute; top: {{$conMezcla}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: end; border: 1px solid black;">
                                <spam style="font-size: 5px;"> Volúmen total (uL) </spam>
                            </div>

                        </div>

                        <div style="width: 50%; height: 10px; position: absolute; top: {{$conMezcla+11}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: end; border: 1px solid black;">
                                <spam style="font-size: 5px;"> ARN (uL) </spam>
                            </div>

                        </div>

                    
                        <!-- DATOS DE LA MEZCLA -->
                        <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center;">
                            
                            <?php 
                            $withMezcla = 84/count($examenes); 
                            $totalExa = $withMezcla/2;
                            $topExa = 0;
                            ?>

                            <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">


                                @foreach($examenes as $exa)
                                <div style="width: {{$totalExa}}%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 16px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 5px;"> 1rx (uL) </strong>
                                </div>
                                <?php $topExa += $totalExa; ?>
                                <div style="width: {{$totalExa}}%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 16px; text-align: center;">

                                    <div style="width: 100%; height: 8px; position: absolute; top: 0; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 5px;"> RT - PCR </strong>
                                    </div>
                                    <div style="width: 100%; height: 8px; position: absolute; top: 9px; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 5px;"> {{$exa->nombre}} </strong>
                                    </div>
                                    <div style="width: 100%; height: 6px; position: absolute; top: 18px; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 5px;"> {{$exa->cant}} </strong>
                                    </div>

                                </div>
                                <?php $topExa += $totalExa; ?>
                                @endforeach

                                <div style="width: 16%; height: 24px; position: absolute; top: 0; left: {{$topExa}}%; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 5px;"> Total reactivo consumido (uL) </strong>
                                </div>

                            </div>

                            <?php $topExa2 = 0; $totalRT = 0; $totalRX = 0; ?>
                            @foreach($arrayMezclas as $mezclaEx)
                            <div style="width: {{$withMezcla}}%; height: 10px; position: absolute; top: 25px; left: {{$topExa2}}%; line-height: 16px; text-align: center;">

                                <?php $topExaDet2 = 0; ?>
                                
                                @foreach($mezclaEx['mezclaDet'] as $detMez)
                                <div style="width: 100%; height: 10px; position: absolute; top: {{$topExaDet2}}px; left: 0; line-height: 9px; text-align: center; ">

                                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 5px;"> {{$detMez->rx}} </spam>
                                    </div>

                                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 5px;"> {{$detMez->rt}} </spam>
                                    </div>

                                </div>
                                <?php $topExaDet2 += 11; $totalRT += $detMez->rt; $totalRX += $detMez->rx; ?>
                                @endforeach

                                <div style="width: 100%; height: 10px; position: absolute; top: {{$topExaDet2}}px; left: 0; line-height: 9px; text-align: center; ">

                                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 5px;"> {{$totalRX}} </spam>
                                    </div>

                                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                                        <spam style="font-size: 5px;"> {{$totalRT}} </spam>
                                    </div>

                                </div>


                            </div>
                            <?php $topExa2 += $withMezcla; ?>
                            @endforeach

                            <?php $topExa3 = 25; $sumTotalRT = 0; ?>
                            @foreach($resultadosMez as $reult)
                            <div style="width: 16%; height: 10px; position: absolute; top: {{$topExa3}}px; left: {{$topExa2}}%; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$reult->total_rt}} </spam>
                            </div>
                            <?php $topExa3 += 11; $sumTotalRT += $reult->total_rt;?>
                            @endforeach

                            <div style="width: 16%; height: 10px; position: absolute; top: {{$topExa3}}px; left: {{$topExa2}}%; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$sumTotalRT}} </spam>
                            </div>

                            <div style="width: 100%; height: 10px; position: absolute; top: {{$topExaDet2+36}}px; left: ; line-height: 16px; text-align: center;">

                                <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 5px;"> 5 </spam>
                                </div>

                            </div>


                        </div>
                        <!-- DATOS DE LA MEZCLA -->

                    </div>

                    <div style="width: 100%; height: 40px; position: absolute; top: {{$topExa3+35}}px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">

                        <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: left;">
                            <strong style="font-size: 5px;"> Observaciones: </strong>
                        </div>

                        <div style="width: 100%; height: 30px; position: absolute; top: 10px; left: 0; line-height: 9px; text-align: center;">
                            <spam style="font-size: 5px;"> N/A: </spam>
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

            <!-- PERFIL TERMICO -->
            <div style="width: 40%; height: 24px; position: absolute; top: {{$totalCabezera}}px; left: 40%; display: flex; text-align: center;">

                <div style="width: 96%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> 3. PERFIL TERMICO </strong>
                    </div>

                    <div style="width: 100%; height: 24px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">

                        <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 5px;"> Temperatura </strong>
                            </div>

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 5px;"> Tiempo </strong>
                            </div>

                        </div>

                        <?php $topPerfil = 25; ?>
                        @foreach($perfilDet as $perf)
                        <div style="width: 50%; height: 10px; position: absolute; top: {{$topPerfil}}px; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$perf->temperatura}} °C </spam>
                            </div>

                            <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                                <spam style="font-size: 5px;"> {{$perf->tiempo}} </spam>
                            </div>

                        </div>
                        <?php $topPerfil += 11; $ciclos = $perf->tiempo; ?>
                        @endforeach

                        <?php $heigPerfil = (count($perfilDet)*11)+24; $heigPerfilDiv = $heigPerfil/count($perfilDet); ?>
                        <!-- CICLOS -->
                        <div style="width: 50%; height: {{$heigPerfil}}px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center; border: 1px solid black;">
                            
                            <div style="width: 100%; height: 22px; position: absolute; top: 30%; left: 0; line-height: {{$heigPerfilDiv}}px; text-align: center;">

                                <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center;">
                                    <strong style="font-size: 5px;"> Ciclos: </strong>
                                </div>

                                <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center;">
                                    <spam style="font-size: 5px;"> {{$ciclos}} </spam>
                                </div>

                                <div style="width: 50%; height: 10px; position: absolute; top: 11px; left: 0; line-height: 9px; text-align: center;">
                                    <strong style="font-size: 5px;"> Canales: </strong>
                                </div>

                                <div style="width: 50%; height: 10px; position: absolute; top: 11px; left: 50%; line-height: 9px; text-align: center;">
                                    <spam style="font-size: 5px;"> {{$perfil->canales}} </spam>
                                </div>

                            </div>

                        </div>
                        <!-- CICLOS -->
                        <?php $cuerpo2Total = $totalCabezera + $topPerfil + 110;  ?>

                    </div>


                </div>

            </div>
            <!-- PERFIL TERMICO -->


        </div>

    </div>
    <!-- CUERPO 1 -->




        <!-- CUERPO 2 -->
        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo2Total}}px; left: 0; display: flex; text-align: center;">

            <div style="width: 100%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                    <strong style="font-size: 5px;"> 4. REPORTE DE RESULTADOS </strong>
                </div>

                <div style="width: 100%; height: 10px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">

                    <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: start; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Fecha de Procesamiento: </strong>
                        <spam style="font-size: 5px;"> {{$resultado->f_procesa}} </spam>
                    </div>

                    <div style="width: 50%; height: 10px; position: absolute; top: 0px; left: 50%; line-height: 9px; text-align: start; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Fecha de Reporte: </strong>
                        <spam style="font-size: 5px;"> {{$resultado->f_reporte}} </spam>
                    </div>

                </div>

                <div style="width: 100%; height: 10px; position: absolute; top: 24px; left: 0; line-height: 16px; text-align: center;">

                    <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Ubicación de la Placa </strong>
                    </div>

                    <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 10%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Fecha de Ingreso </strong>
                    </div>

                    <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 25%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Código </strong>
                    </div>

                    <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 30%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Nombre del Paciente </strong>
                    </div>

                    <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Procedencia </strong>
                    </div>

                    <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 5px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Tipo de Muestra </strong>
                    </div>

                    <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 75%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Ensayo </strong>
                    </div>

                    <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 85%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> CT </strong>
                    </div>

                    <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 90%; line-height: 6px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 5px;"> Resultado </strong>
                    </div>

                </div>
                <?php $topResult = -1;  ?>
                <div style="width: 100%; height: 10px; position: absolute; top: 35px; left: 0px; line-height: 12px; text-align: center; border: 1px solid black;">
                    
                    @foreach($resultadoDet as $resulta)
                    <div style="width: 100%; height: 10px; position: absolute; top: {{$topResult}}px; left: -1px; line-height: 16px; text-align: center;">

                        <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 0; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->ubicacion}} </spam>
                        </div>

                        <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 10%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->f_ingreso}} </spam>
                        </div>

                        <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 25%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->codigo}} </spam>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 30%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->paciente}} </spam>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->procedencia}} </spam>
                        </div>

                        <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->nombre}} </spam>
                        </div>

                        <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 75%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->ensayo}}  </spam>
                        </div>

                        <div style="width: 5%; height: 10px; position: absolute; top: 0; left: 85%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->ct}} </spam>
                        </div>

                        <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 90%; line-height: 6px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$resulta->resultado}} </spam>
                        </div>
                        <?php $topResult += 11;  ?>

                    </div>
                    @endforeach

                </div>

                <div style="width: 100%; height: 40px; position: absolute; top: {{$topResult+36}}px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">

                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: left;">
                        <strong style="font-size: 5px;"> Observaciones: </strong>
                    </div>

                    <div style="width: 100%; height: 30px; position: absolute; top: 10px; left: 0; line-height: 9px; text-align: center;">
                        <spam style="font-size: 5px;"> {{$resultado->observacion}} </spam>
                    </div>

                </div>

            </div>

        </div>
        <!-- CUERPO 2 -->



        <!-- CUERPO 3 -->
        <?php $cuerpo3Total = $cuerpo2Total + $topResult + 85;  ?>
        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo3Total}}px; left: 0; display: flex; text-align: center;">

            <div style="width: 100%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">
                    <strong style="font-size: 5px;"> 5. USO DE CONTROLES </strong>
                </div>

                <div style="width: 100%; height: 30px; position: absolute; top: 14px; left: 0px; line-height: 12px; text-align: center;">
                    @if(count($controlDet) == 1)

                    <div style="width: 80%; height: 10px; position: absolute; top: -1px; left: 0; line-height: 16px; text-align: center;">

                        <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CONTROLES </strong>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CT </strong>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> INTERPRETACION </strong>
                        </div>

                        <?php $topControl1 = 11;  ?>
                        @foreach($controlDet as $index => $detCont)
                        <div style="width: 50%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->nombre}} </spam>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->ct}} </spam>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->resultado}} </spam>
                        </div>
                        <?php $topControl1 += 11;  ?>
                        @endforeach
                    </div>


                    @else

                    <div style="width: 40%; height: 10px; position: absolute; top: -1px; left: 0; line-height: 16px; text-align: center;">

                        <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CONTROLES </strong>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CT </strong>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> INTERPRETACION </strong>
                        </div>

                        <?php $topControl1 = 11;  ?>
                        @foreach($controlDet as $index => $detCont)
                        @if($index % 2 == 0)
                        <div style="width: 50%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->nombre}} </spam>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->ct}} </spam>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$detCont->resultado}} </spam>
                        </div>
                        <?php $topControl1 += 11;  ?>
                        @endif
                        @endforeach

                        </div>

                        <div style="width: 40%; height: 10px; position: absolute; top: -1px; left: 40%; line-height: 16px; text-align: center;">

                        <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CONTROLES </strong>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> CT </strong>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> INTERPRETACION </strong>
                        </div>

                        <?php $topControl2 = 11;  ?>
                        @foreach($controlDet as $index => $detCont)
                        @if($index % 2 == 1)
                        <div style="width: 50%; height: 10px; position: absolute; top: {{$topControl2}}px; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> CN ZIKA </spam>
                        </div>

                        <div style="width: 20%; height: 10px; position: absolute; top: {{$topControl2}}px; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> ... </spam>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: {{$topControl2}}px; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> Negativo </spam>
                        </div>
                        <?php $topControl2 += 11;  ?>
                        @endif
                        @endforeach

                    </div>

                    @endif

                    <?php 
                    $totalControles = count($controlDet); 
                    $totalControlesDiv = $totalControles / 2; 
                    $redondeado = round($totalControlesDiv);

                    $totalControlesHeig = (round($redondeado)*10)+11;
                    
                    $line = $totalControlesHeig/2;
                    ?>

                    <div style="width: 20%; height: {{$totalControlesHeig}}px; position: absolute; top: -1px; left: 80%; line-height: 16px; text-align: center;">

                        <div style="width: 50%; height: {{$totalControlesHeig}}px; position: absolute; top: 0; left: 0%; line-height: {{$line}}px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> Total de Controles Utilizados </strong>
                        </div>

                        <div style="width: 50%; height: {{$totalControlesHeig}}px; position: absolute; top: 0; left: 50%; line-height: {{$line}}px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 5px;"> {{$totalControles}} </spam>
                        </div>

                    </div>


                </div>

                <div style="width: 100%; height: 40px; position: absolute; top: 56px; left: 0; line-height: 12px; text-align: center;">

                    <div style="width: 80%; height: 40px; position: absolute; top: 0; left: 10%; line-height: 9px; text-align: start;">

                        <div style="width: 50%; height: 35px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: left; border: 1px solid black;">
                            <strong style="font-size: 5px; margin-left: 2px;"> Revisado por: </strong>
                            <spam style="font-size: 5px; "> {{$usuarios['revisado']['name']}} </spam> <br>
                            <strong style="font-size: 5px; margin-left: 2px;"> Autorizado por: </strong>
                            <spam style="font-size: 5px;"> {{$usuarios['autoriza']['name']}} </spam> <br>
                            <strong style="font-size: 5px; margin-left: 2px;"> Reportado por: </strong>
                            <spam style="font-size: 5px;"> {{$usuarios['reporta']['name']}} </spam>
                        </div>

                        <div style="width: 30%; height: 35px; position: absolute; top: 0; right: 0; line-height: 20px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 5px;"> Hora Analítica: </strong>
                            <spam style="font-size: 5px;"> {{$corrida->hora}} </spam>
                        </div>

                    </div>

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








