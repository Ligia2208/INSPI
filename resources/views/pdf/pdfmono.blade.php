<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de Resultados</title>
</head>
<style>

    .container {
        display: flex;
        flex-direction: row;
    }
    .panel {
        margin: 20px;
        padding: 10px;
        border: 1px solid black;
        width: 200px;
        height: 150px;
        position: relative;
    }
    .panel h4 {
        text-align: center;
        margin: 0;
    }
    .row {
        display: flex;
        justify-content: space-around;
        margin-bottom: 10px;
    }
    .circle {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        border: 1px solid black;
        text-align: center;
        line-height: 25px;
        margin-left: 5px;
    }
    .label {
        position: absolute;
        left: -50px;
        top: 50%;
        transform: translateY(-50%);
        writing-mode: vertical-rl;
        text-align: center;
    }
    .crossed {
        position: relative;
    }
    .crossed::before, .crossed::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 1px;
        height: 100%;
        background: red;
        transform: rotate(45deg);
    }
    .crossed::after {
        transform: rotate(-45deg);
    }
    .bottom-labels {
        display: flex;
        justify-content: space-around;
        font-size: 12px;
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
    <?php $cuerpo2Total = 55 ;  ?>

    <div style="margin-top: 80px; position: absolute; top: {{$cuerpo2Total}}px; left: 0; height: auto; width: 100%;" >

        <?php
            $lastUsuario = null;
            $lastFecha = null;
            $chunkCount = 0;
            $top = 0;
            $left = 0;
            $keyMonoCount = 0;
        ?>

        @foreach($monoclonales as $chunkIndex => $chunk)

        <?php
            if($lastUsuario !== null ){
                if($chunkCount % 2 === 0){
                    $top += 175;
                    $left = 0;
                }else{
                    $left = 50;
                }
            }

            //$top = ($chunkCount % 2 === 0) ? 0 : 175 * ($chunkCount - 1);
            //$left = ($chunkCount % 2 === 0) ? 0 : 50;
        ?>

        @foreach($chunk as $keyMono => $item)

        <?php
            
            // Verificar si el usuario o la fecha han cambiado
            if ($lastUsuario !== null && ($lastUsuario !== $item['usuario_id'] || $lastFecha !== $item['fecha'])) {
                //$chunkCount++;

                if($chunkCount % 2 === 1){
                    $chunkCount++;
                }

                //$top = ($chunkCount % 2 === 0) ? $top + 175 : $top;
                //$left = ($chunkCount % 2 === 0) ? 0 : 50;

                if($keyMonoCount % 2 === 1){
                    $keyMonoCount++;
                }

                if($lastUsuario !== null){
                    if($chunkCount % 2 === 0){
                        $top += 175;
                        $left = 0;
                    }else{
                        $left = 50;
                    }
                }



            }
            
            // Actualizar los últimos valores procesados
            $lastUsuario = $item['usuario_id'];
            $lastFecha = $item['fecha'];
        ?>
        <div style="width: 50%; height: 24px; position: absolute; top: {{ $top }}px; left: {{ $left }}%; display: flex; text-align: center;">


            <div style="width: 100%; height: 15px; position: absolute; top: 0; left: 0%; display: flex; text-align: left;">
                <strong style="font-size: 10px; margin-left: 10px">Fecha:</strong> 
                <span style="font-size: 10px;">{{$item['fecha']}}</span> 
            </div>

            <div style="width: 7%; height: 100px; position: absolute; top: 25px; left: 0%; display: flex; text-align: center;">

                <?php 
                    $contMuestra = 15; 
                    $aux1 = 0;
                ?>
                @foreach($chunk as $key => $monos)
                    <div style="width: 100%; height: 30px; position: absolute; top: {{$contMuestra}}%; left: 0%; display: flex; text-align: center; border: 1px solid black;">   
                        <strong style="font-size: 10px; margin-left: 1px">{{ $monos->muestra }}</strong>    
                    </div>
                    
                    <?php $contMuestra += 45;  ?>
                @endforeach

            </div>

            <div style="width: 93%; height: 100px; position: absolute; top: 25px; left: 7%; display: flex; text-align: center;">

                <div style="width: 80%; height: 100px; position: absolute; top: 0; left: 0%; display: flex; text-align: center; border: 1px solid black;">
                    @if($keyMonoCount % 2 === 0)
                    @foreach($arrayReactivos  as $monoK)
                    @if($monoK['id_monoclonal'] == $item->id)
                    <div class="" style="width: 100%; height: 40px; position: absolute; top: 0; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        @if($monoK['id_reactivo'] == 'VSR')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'ADN')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'HMPV')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PI')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PII')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PIII')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;"></div>
                        @endif

                    </div>
                    @endif
                    @endforeach
                    @endif

                    <div class="" style="width: 100%; height: 20px; position: absolute; top: 30px; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">VSR</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">ADN</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">HMPV</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PI</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PII</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PIII</strong>
                        </div>
                    </div>

                    @if($keyMonoCount % 2 === 1)
                    @foreach($arrayReactivos  as $monoK)
                    @if($monoK['id_monoclonal'] == $item->id)
                    <div class="" style="width: 100%; height: 40px; position: absolute; top: 55px; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        @if($monoK['id_reactivo'] == 'VSR')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'ADN')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'HMPV')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PI')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PII')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;"></div>
                        @endif

                        @if($monoK['id_reactivo'] == 'PIII')
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;"></div>
                        @else
                        <div class="circle" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;"></div>
                        @endif
                    </div>
                    @endif
                    @endforeach
                    @endif

                </div>
            </div>

            <div style="width: 100%; height: 15px; position: absolute; top: 130px; left: 0%; display: flex; text-align: left;">
                <strong style="font-size: 10px; margin-left: 10px">Realizado por:</strong> 
                <span style="font-size: 10px;">{{$item['usuario_id']}}</span> 
            </div>

 

        <?php $keyMonoCount++; ?>
        </div>

        @endforeach
        <?php 
            if ($lastUsuario !== null && ($lastUsuario !== $item['usuario_id'] || $lastFecha !== $item['fecha'])) {
                $chunkCount++; 
            }
        ?>

       
        @endforeach


        <!-- <div style="width: 50%; height: 24px; position: absolute; top: 0; left: 50%; display: flex; text-align: center;">

            <div style="width: 100%; height: 15px; position: absolute; top: 0; left: 0%; display: flex; text-align: left;">
                <strong style="font-size: 10px; margin-left: 10px">Fecha:</strong>   
            </div>

            <div style="width: 7%; height: 100px; position: absolute; top: 25px; left: 0%; display: flex; text-align: center;">

                <div style="width: 100%; height: 30px; position: absolute; top: 15%; left: 0%; display: flex; text-align: center; border: 1px solid black;">   
                    <strong style="font-size: 10px; margin-left: 1px">M4</strong>    
                </div>

                <div style="width: 100%; height: 30px; position: absolute; top: 60%; left: 0%; display: flex; text-align: center; border: 1px solid black;">  
                    <strong style="font-size: 10px; margin-left: 1px">M5</strong>     
                </div>

            </div>

            <div style="width: 93%; height: 100px; position: absolute; top: 25px; left: 7%; display: flex; text-align: center;">

                <div style="width: 80%; height: 100px; position: absolute; top: 0; left: 0%; display: flex; text-align: center; border: 1px solid black;">

                    <div class="" style="width: 100%; height: 40px; position: absolute; top: 0; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;">
                        </div>
                    </div>

                    <div class="" style="width: 100%; height: 20px; position: absolute; top: 30px; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">VSR</strong>
                        </div>

                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">ADN</strong>
                        </div>

                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">HMPV</strong>
                        </div>

                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PI</strong>
                        </div>
                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PII</strong>
                        </div>

                        <div class="" style="width: 15%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;">
                            <strong style="font-size: 10px;">PIII</strong>
                        </div>
                    </div>

                    <div class="" style="width: 100%; height: 40px; position: absolute; top: 55px; left: 0%; display: flex; text-align: center; margin-top: 10%;">
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 5%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 20%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 35%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 50%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 65%; display: flex; text-align: center;">
                        </div>
                        <div class="circle crossed" style="width: 10%;  position: absolute; top: 0; left: 80%; display: flex; text-align: center;">
                        </div>
                    </div>

                </div>

            
            </div>

            <div style="width: 100%; height: 15px; position: absolute; top: 130px; left: 0%; display: flex; text-align: left;">
                <strong style="font-size: 10px; margin-left: 10px">Realizado por:</strong>   
            </div>

        </div> -->

    </div>

    <!-- DATOS DEL ANALISTA -->
    <div style="margin-top: 80px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >


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








