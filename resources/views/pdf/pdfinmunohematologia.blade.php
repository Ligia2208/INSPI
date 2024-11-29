<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Resultados - Inmuno</title>
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

<?php $color = '#64A46E;'; ?>

<div style="width: 100%; height: auto; position: relative;">

    <!-- CABEZERA -->
    <div style="margin-top: 0px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div class="borde" style="width: 15%; height: 51px; position: absolute; top: 0; left: 0; border: 1px solid black;">
            <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="80" height="40" style="margin-left: 10%; margin-top: 4%;">
        </div>

        <div style="width: 65%; height: 50px; position: absolute; top: 0; left: 15%;">

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 18px;">
                <strong style="font-size: 7px;">REGISTRO DE TRABAJO DIARIO PARA PCR EN TIEMPO REAL</strong>
            </div>

            <div style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex;">

                <div class="borde" style="width: 50%; height: 25px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 9px;">
                    <strong style="font-size: 6px;">Macro-Proceso:</strong><br>
                    <span style="font-size: 6px;">Laboratorio de Vigilancia Epidemiológica y Referencia nacional</span>
                </div>

                <div class="borde" style="width: 50%; height: 25px; position: absolute; top: 0; left: 50%; border: 1px solid black; text-align: center; line-height: 9px;">
                    <strong style="font-size: 6px;">Proceso Interno:</strong><br>
                    <span style="font-size: 6px;">Centro de Referencia Nacional de Inmunohematología e Infecciones virales de transmisión sexual</span>
                </div>

            </div>

        </div>

        <div style="width: 8%; height: 50px; position: absolute; top: 0; left: 80%; text-align: center;">

            <div class="borde" style="width: 100%; height: 11.5px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Código</strong>
            </div>

            <div class="borde" style="width: 100%; height: 12.5px; position: absolute; top: 12.5px; left: 0; display: flex; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Edición</strong>
            </div>

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                <strong style="font-size: 6px;">Fecha de aprobación</strong>
            </div>

        </div>


        <div style="width: 12%; height: 50px; position: absolute; top: 0; left: 88%;">

            <div class="borde" style="width: 100%; height: 11.5px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <span style="font-size: 6px;">F-IVTS-018</span>
            </div>

            <div class="borde" style="width: 100%; height: 12.5px; position: absolute; top: 12.5px; left: 0; display: flex; border: 1px solid black; line-height: 9px; text-align: center;">
                <span style="font-size: 6px;">00</span>
            </div>

            <div class="borde" style="width: 100%; height: 25px; position: absolute; top: 26px; left: 0; display: flex; border: 1px solid black; line-height: 16px; text-align: center;">
                <span style="font-size: 6px;">12/09/2023</span>
            </div>

        </div>

    </div>
    <!-- CABEZERA -->

    <!-- DATOS DEL ANALISTA -->
    <div style="margin-top: 60px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">
        
            <div class="borde" style="width: 20%; height: 12px; position: absolute; top: 0; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Analista que realiza la prueba:</strong><br>
            </div>

            <div class="borde" style="width: 30%; height: 12px; position: absolute; top: 0; left: 20%; border: 1px solid black; line-height: 9px; text-align: center;">
                <spam style="font-size: 6px;">{{$corrida->name}}</spam><br>
            </div>

            <div class="borde" style="width: 20%; height: 12px; position: absolute; top: 0; left: 50%; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Técnica de RT-qPCR para:</strong>
            </div>

            <div class="borde" style="width: 30%; height: 12px; position: absolute; top: 0; left: 70%; border: 1px solid black; line-height: 11px; text-align: center;">
                <spam style="font-size: 10px; font-weight: 800;">{{$corrida->servicio}}</spam>
            </div>


            <div class="borde" style="width: 20%; height: 12px; position: absolute; top: 13px; left: 0; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Fecha de análisis:</strong><br>
            </div>

            <div class="borde" style="width: 30%; height: 12px; position: absolute; top: 13px; left: 20%; border: 1px solid black; line-height: 9px; text-align: center;">
                <spam style="font-size: 6px;">{{$corrida->fecha}}</spam><br>
            </div>

            <div class="borde" style="width: 20%; height: 12px; position: absolute; top: 13px; left: 50%; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">N° de corrida:</strong>
            </div>

            <div class="borde" style="width: 30%; height: 12px; position: absolute; top: 13px; left: 70%; border: 1px solid black; line-height: 11px; text-align: center;">
                <spam style="font-size: 6px;">{{$corrida->numero}}</spam>
            </div>


            <div class="borde" style="width: 40%; height: 12px; position: absolute; top: 26px; left: 0%; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Equipos utilizados para Extracción:</strong>
            </div>

            <div class="borde" style="width: 60%; height: 12px; position: absolute; top: 26px; left: 40%; border: 1px solid black; line-height: 11px; text-align: center;">
                <spam style="font-size: 6px;">{{$corrida->extraccion_equi}}</spam>
            </div>


            <div class="borde" style="width: 40%; height: 12px; position: absolute; top: 39px; left: 0%; border: 1px solid black; line-height: 9px; text-align: center;">
                <strong style="font-size: 6px;">Equipos utilizados para RT-qPCR:</strong>
            </div>

            <div class="borde" style="width: 60%; height: 12px; position: absolute; top: 39px; left: 40%; border: 1px solid black; line-height: 11px; text-align: center;">
                <spam style="font-size: 6px;">{{$corrida->equipos}}</spam>
            </div>

                
        </div>
        
    </div>
    <!-- DATOS DEL ANALISTA -->


    <!-- CUERPO 1 -->
    <div style="margin-top: 120px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; text-align: center;">

            <?php $cuerpo0Total = 50; ?>
            <!-- EXTRACCION DE ARN -->
            <div style="width: 30%; height: 121px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center;">

                <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;">1. EXTRACCION DE ADN</strong>
                    </div>
                </div>

                <div style="width: 100%; height: 30px; position: absolute; top: 11px; left: 0px; line-height: 12px; text-align: center;">

                    <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;">Nombre del reactivo:</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 0; left: 40%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 6px;">{{$extraccion->nombre}}</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 11px; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;">Marca:</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 11px; left: 40%; line-height: 8px; text-align: center;border: 1px solid black; ">
                        <spam style="font-size: 6px;">Dean Gene</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 22px; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;">Lote:</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 22px; left: 40%; line-height: 8px; text-align: center;border: 1px solid black; ">
                        <spam style="font-size: 6px;">{{$extraccion->lote}}</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 33px; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;">Caducidad:</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 33px; left: 40%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 6px;">{{$extraccion->f_caduca}}</spam>
                    </div>

                    <div style="width: 40%; height: 10px; position: absolute; top: 44px; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;">Rxs utilizados:</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 44px; left: 40%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 6px;">{{count($extraccionDet)}}</spam>
                    </div>

                </div>

                <?php $conExtra = 70; ?>

                <div style="width: 100%; height: 10px; position: absolute; top: {{$conExtra}}px; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;">Código Muestra</strong>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 0; left: 40%; line-height: 8px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;">Tipo de Muestra</strong>
                    </div>
                </div>

                <?php $conExtra = 81; ?>
                @foreach($extraccionDet as $extra)
                <div style="width: 100%; height: 10px; position: absolute; top: {{$conExtra}}px; left: 0; line-height: 10px; text-align: center;">
                    <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 0; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 6px;">{{$extra->cod_muestra}}</spam>
                    </div>

                    <div style="width: 60%; height: 10px; position: absolute; top: 0; left: 40%; line-height: 8px; text-align: center; border: 1px solid black;">
                        <spam style="font-size: 6px;">{{$extra->nombre}}</spam>
                    </div>
                </div>
                <?php $conExtra += 11; $cuerpo0Total += 11;?>
                @endforeach

            </div>
            <!-- EXTRACCION DE ARN -->



            <?php $cuerpo1Total = 50; ?>

            <!-- MEZCLA DE REACCION -->
            <div style="width: 70%; height: 24px; position: absolute; top: 0; left: 30%; display: flex; text-align: center;">

                <div style="width: 96%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> 2. MEZCLA DE AMPLIFICACIÓN </strong>
                    </div>

                    <div style="width: 100%; height: 24px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">

                        <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                                <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Nombre del reactivo </strong>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 25px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Marca: </strong>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 38px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Lote: </strong>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 51px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Fecha de Caducidad: </strong>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 64px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Rxs utilizadas: </strong>
                                </div>

                            </div>

                            <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center;">

                                @foreach($mezcla as $mez)
                                <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                    <span style="font-size: 6px;"> {{$mez->reactivo}} </span>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 25px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <span style="font-size: 6px;"> Dean Gene </span>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 38px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <span style="font-size: 6px;"> {{$mez->lote}} </span>
                                </div>

                                <div style="width: 100%; height: 12px; position: absolute; top: 51px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <span style="font-size: 6px;"> {{$mez->f_caduca}} </span>
                                </div>
                                @endforeach

                                <div style="width: 100%; height: 12px; position: absolute; top: 64px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> {{$arrayMezclas[0]['cant']}} </strong>
                                </div>

                            </div>

                        </div>

                        <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center;">

                            <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center;">

                                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                    <strong style="font-size: 6px;"> Reactivo </strong>
                                </div>

                                <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center;">
                                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> N° rxs (uL) </strong>
                                    </div>
                                    <div style="width: 50%; height: 11px; position: absolute; top: 13px; left: 0%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> 1 rx </strong>
                                    </div>
                                    
                                    @foreach($examenes as $exa)
                                    <div style="width: 50%; height: 11px; position: absolute; top: 13px; left: 50%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> {{$exa->cant}} rx </strong>
                                    </div>
                                    @endforeach

                                </div>

                                <?php $conMezc = 25; $rxTotal = 0; $rtTotal = 0;?>

                                @foreach($mezclaDet as $exa)
                                <div style="width: 100%; height: 12px; position: absolute; top: {{$conMezc}}px; left: 0; line-height: 10px; text-align: center;">
                                    <div style="width: 50%; height: 12px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <span style="font-size: 6px;"> {{$exa->solucion}} </span>
                                    </div>
                                    <div style="width: 25%; height: 12px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <span style="font-size: 6px;"> {{$exa->rx}} </span>
                                    </div>
                                    <div style="width: 25%; height: 12px; position: absolute; top: 0; left: 75%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <span style="font-size: 6px;"> {{$exa->rt}} </span>
                                    </div>
                                </div>
                                <?php $conMezc += 13; $rxTotal += $exa->rx; $rtTotal += $exa->rt; ?>
                                @endforeach

                                <div style="width: 100%; height: 12px; position: absolute; top: {{$conMezc}}px; left: 0; line-height: 10px; text-align: center;">
                                    <div style="width: 50%; height: 12px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> Volúmen total (uL) </strong>
                                    </div>
                                    <div style="width: 25%; height: 12px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> {{$rxTotal}} </strong>
                                    </div>
                                    <div style="width: 25%; height: 12px; position: absolute; top: 0; left: 75%; line-height: 10px; text-align: center; border: 1px solid black;">
                                        <strong style="font-size: 6px;"> {{$rtTotal}} </strong>
                                    </div>
                                </div>

                            </div>

                        </div>



                    </div>

                </div>

            </div>
            <!-- MEZCLA DE REACCION -->


            <?php 
                $cuerpo1Total += 45;
                $cuerpo0Total += 60;
                $totalCabezera = $cuerpo1Total;
                /*
                if($cuerpo1Total > $cuerpo0Total){
                    $totalCabezera = $cuerpo1Total;
                }else{
                    $totalCabezera = $cuerpo0Total;
                }
                */

            ?>

            <!-- ESTANDAR DE CUANTIFICACION -->
            <div style="width: 70%; height: 24px; position: absolute; top: {{$totalCabezera}}px; left: 30%; display: flex; text-align: center;">

                <div style="width: 96%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> 3. CORRIDA DE STANDARES DE CUANTIFICACIÓN </strong>
                    </div>

                    <div style="width: 100%; height: 24px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">


                        <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> Estándar </strong>
                        </div>

                        <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 25%; line-height: 16px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> Concentración </strong>
                        </div>

                        <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> CT </strong>
                        </div>

                        <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 75%; line-height: 16px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> Interpretación </strong>
                        </div>


                        <?php $topEstandar = 25; ?>
                        @foreach($estandar as $est)

                        <div style="width: 25%; height: 12px; position: absolute; top: {{$topEstandar}}px; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <span style="font-size: 6px;"> {{$est->estandar}} </span>
                        </div>

                        <div style="width: 25%; height: 12px; position: absolute; top: {{$topEstandar}}px; left: 25%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <span style="font-size: 6px;"> {{$est->concentra}} </span>
                        </div>

                        <div style="width: 25%; height: 12px; position: absolute; top: {{$topEstandar}}px; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <span style="font-size: 6px;"> {{$est->ct}} </span>
                        </div>

                        <div style="width: 25%; height: 12px; position: absolute; top: {{$topEstandar}}px; left: 75%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <span style="font-size: 6px;"> {{$est->interpreta}} </span>
                        </div>

                        <?php $topEstandar += 13; ?>
                        @endforeach

                    </div>


                </div>
            </div>
            <!-- ESTANDAR DE CUANTIFICACION -->

            <?php $totalCabezera += $topEstandar + 20; ?>

            <!-- PERFIL TERMICO -->
            <div style="width: 70%; height: 24px; position: absolute; top: {{$totalCabezera}}px; left: 30%; display: flex; text-align: center;">

                <div style="width: 96%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                    <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> 4. PERFIL TERMICO CANALES: {{$perfil->canales}} </strong>
                    </div>

                    <div style="width: 100%; height: 24px; position: absolute; top: 13px; left: 0; line-height: 12px; text-align: center;">

                        <div style="width: 100%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center;">

                            <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 0; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 6px;"> Fase </strong>
                            </div>

                            <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 25%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 6px;"> # de Ciclos </strong>
                            </div>

                            <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 50%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 6px;"> Temperatura </strong>
                            </div>

                            <div style="width: 25%; height: 24px; position: absolute; top: 0; left: 75%; line-height: 16px; text-align: center; border: 1px solid black;">
                                <strong style="font-size: 6px;"> Tiempo </strong>
                            </div>

                        </div>

                        <?php $topPerfil = 25; ?>
                        @foreach($perfilDet as $index => $datosPer)
                            <div style="width: 100%; height: 10px; position: absolute; top: {{$topPerfil}}px; left: 0; line-height: 16px; text-align: center;">
                                <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 6px;"> {{$index}} </spam>
                                </div>

                                <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 25%; line-height: 9px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 6px;"> {{$datosPer->temperatura}} °C </spam>
                                </div>

                                <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 6px;"> {{$datosPer->temperatura}} °C </spam>
                                </div>

                                <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 75%; line-height: 9px; text-align: center; border: 1px solid black;">
                                    <spam style="font-size: 6px;"> {{$datosPer->tiempo}} </spam>
                                </div>
                            </div>
                            <?php $topPerfil += 11; ?>
                        @endforeach

                        <!-- CICLOS -->
                        <?php $cuerpo2Total = $totalCabezera + $topPerfil + 140;  ?>

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

                <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 12px; text-align: center;">
                    
                    <div style="width: 50%; height: 12px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> 5. USO DE CONTROLES </strong>
                    </div>
                    <div style="width: 30%; height: 12px; position: absolute; top: 0; left: 50%; line-height: 10px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> Valor del Umbral: </strong>
                        <span style="font-size: 6px;"> {{$control->umbral}} </span>
                    </div>
                    <div style="width: 20%; height: 12px; position: absolute; top: 0; left: 80%; line-height: 10px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                        <strong style="font-size: 6px;"> Automatic </strong>
                        <span style="font-size: 6px;"> {{$control->automatic}} </span>
                    </div>

                </div>

                <div style="width: 100%; height: 30px; position: absolute; top: 14px; left: 0px; line-height: 12px; text-align: center;">

                    <div style="width: 100%; height: 10px; position: absolute; top: -1px; left: 0; line-height: 16px; text-align: center;">

                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> CONTROLES </strong>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: 0; left: 20%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> CT </strong>
                        </div>

                        <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> INTERPRETACION </strong>
                        </div>

                        <div style="width: 40%; height: 10px; position: absolute; top: 0; left: 60%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px;"> INTERPRETACION </strong>
                        </div>

                        <?php $topControl1 = 11;  ?>
                        @foreach($controlDet as $index => $detCont)
                        <div style="width: 20%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$detCont->nombre}} </spam>
                        </div>

                        <div style="width: 30%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 20%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$detCont->resultado}} </spam>
                        </div>

                        <div style="width: 10%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$detCont->ct}} </spam>
                        </div>

                        <div style="width: 40%; height: 10px; position: absolute; top: {{$topControl1}}px; left: 60%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$detCont->criterios}} </spam>
                        </div>

                        <?php $topControl1 += 11;  ?>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>
        <!-- CUERPO 2 -->



        <!-- CUERPO 3 -->
        <?php $cuerpo3Total = $cuerpo2Total + $topControl1 + 20;  ?>
        <div style="width: 100%; height: 24px; position: absolute; top: {{$cuerpo3Total}}px; left: 0; display: flex; text-align: center;">

            <div style="width: 100%; height: 54px; position: absolute; top: 0; right: 0; display: flex; text-align: center;">

                <div style="width: 100%; height: 12px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center; border: 1px solid black; background-color: {{$color}};">
                    <strong style="font-size: 6px;"> 6. REPORTE DE RESULTADOS </strong>
                </div>

                <div style="width: 100%; height: 10px; position: absolute; top: 13px; left: 0; line-height: 16px; text-align: center;">

                    <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> Código </strong>
                    </div>

                    <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 10%; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> Nombre </strong>
                    </div>

                    <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 35%; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> Procedencia </strong>
                    </div>

                    <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> Resultado </strong>
                    </div>

                    <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> CT </strong>
                    </div>

                    <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 85%; line-height: 9px; text-align: center; border: 1px solid black;">
                        <strong style="font-size: 6px;"> Concentración </strong>
                    </div>

                </div>
                <?php $topResult = -12;  ?>
                <div style="width: 100%; height: 10px; position: absolute; top: 35px; left: 0px; line-height: 12px; text-align: center; border: 1px solid black;">
                    
                    @foreach($resultadoDet as $resulta)
                    <div style="width: 100%; height: 10px; position: absolute; top: {{$topResult}}px; left: -1px; line-height: 16px; text-align: center;">

                        <div style="width: 10%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->codigo}} </spam>
                        </div>

                        <div style="width: 25%; height: 10px; position: absolute; top: 0; left: 10%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->paciente}} </spam>
                        </div>

                        <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 35%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->procedencia}} </spam>
                        </div>

                        @if($resulta->observacion == '')
                        <div style="width: 20%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->resultado}} </spam>
                        </div>

                        <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 70%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->ct}} </spam>
                        </div>

                        <div style="width: 15%; height: 10px; position: absolute; top: 0; left: 85%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->concentracion}} </spam>
                        </div>
                        @else
                        <div style="width: 50%; height: 10px; position: absolute; top: 0; left: 50%; line-height: 9px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$resulta->observacion}} </spam>
                        </div>
                        @endif

                        <?php $topResult += 11;  ?>

                    </div>
                    @endforeach

                </div>

                <div style="width: 100%; height: 40px; position: absolute; top: {{$topResult+36}}px; left: 0; line-height: 12px; text-align: center; border: 1px solid black;">

                    <div style="width: 100%; height: 10px; position: absolute; top: 0; left: 0; line-height: 9px; text-align: left;">
                        <strong style="font-size: 6px;"> Observaciones: </strong>
                    </div>

                    <div style="width: 100%; height: 30px; position: absolute; top: 10px; left: 0; line-height: 9px; text-align: center;">
                        <spam style="font-size: 6px;"> {{$resultado->observacion}} </spam>
                    </div>

                </div>

            </div>

            <!-- PIE DE PAGINA -->
            <div style="width: 100%; height: 40px; position: absolute; top: {{$topResult+80}}px; left: 0; line-height: 12px; text-align: center;">

                <div style="width: 80%; height: 40px; position: absolute; top: 0; left: 20%; line-height: 9px; text-align: start;">

                    <div style="width: 80%; height: 35px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: left;">

                        <div style="width: 40%; height: 12px; position: absolute; top: 0; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px; margin-left: 2px;"> Revisado por: </strong>
                        </div>
                        <div style="width: 60%; height: 12px; position: absolute; top: 0; left: 40%; line-height: 10px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px; "> {{$usuarios['revisado']['name']}} </spam> <br>
                        </div>

                        <div style="width: 40%; height: 12px; position: absolute; top: 13px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px; margin-left: 2px;"> Autorizado por: </strong>
                        </div>
                        <div style="width: 60%; height: 12px; position: absolute; top: 13px; left: 40%; line-height: 10px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$usuarios['autoriza']['name']}} </spam> <br>
                        </div>

                        <div style="width: 40%; height: 12px; position: absolute; top: 26px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px; margin-left: 2px;"> Reportado por: </strong>
                        </div>
                        <div style="width: 60%; height: 12px; position: absolute; top: 26px; left: 40%; line-height: 10px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$usuarios['reporta']['name']}} </spam>
                        </div>

                        <div style="width: 40%; height: 12px; position: absolute; top: 39px; left: 0; line-height: 10px; text-align: center; border: 1px solid black;">
                            <strong style="font-size: 6px; margin-left: 2px;"> Fecha de reporte: </strong>
                        </div>
                        <div style="width: 60%; height: 12px; position: absolute; top: 39px; left: 40%; line-height: 10px; text-align: center; border: 1px solid black;">
                            <spam style="font-size: 6px;"> {{$corrida->fecha}} </spam>
                        </div>

                    </div>

                </div>
            </div>
            <!-- PIE DE PAGINA -->

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








