<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios Externos No Presenciales</title>
</head>

<style>

    .container {
        display: flex;
        flex-direction: row;
    }


    .border {
        border: 1px solid black;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 8px;
        text-align: center;
    }
    .header-title {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }
    .header-subtitle {
        text-align: center;
        font-size: 10px;
    }

    .spam1{
        /* padding: 0 10 0 10; */
        font-size: 12px;
        color: #151F30;
    }

    .spam2{
        font-size: 20px;
    }

    .center-text {
        text-align: center;
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 80px;
    }

    .center-left {
        text-align: left;
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 80px;
    }

    .block {
        display: block;
        margin-top: 10px;
    }

</style>

<body>



<div style="width: 100%; height: auto; position: relative; background-color: #fafaff;">

    <!-- CABEZERA -->
    <div style="margin-top: 0px; position: absolute; top: 0; left: 0; height: 50px; width: 100%;" >

        <div class="borde" style="width: 15%; height: 66px; position: absolute; top: 0; left: 0; border: 1px solid black;">
            <img src="{{ public_path('img/logo_peque.png') }}" alt="Foto" width="80" height="40" style="margin-left: 10%; margin-top: 6%;">
        </div>

        <div style="width: 65%; height: 50px; position: absolute; top: 0; left: 15%;">

            <div class="borde" style="width: 100%; height: 30px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 15px;">
                <strong style="font-size: 10px;">ENCUESTA DE SATISFACCION DE LA CALIDAD DEL SERVICIO PARA USUARIOS EXTERNOS NO PRESENCIALES</strong>
            </div>

            <div style="width: 100%; height: 25px; position: absolute; top: 31px; left: 0; display: flex;">

                <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 0; border: 1px solid black; text-align: center; line-height: 12px;">
                    <strong style="font-size: 10px;">Macro-Proceso:</strong><br>
                    <span style="font-size: 10px;">Dirección de Planificación y Gestión Estratégica</span>
                </div>

                <div class="borde" style="width: 50%; height: 35px; position: absolute; top: 0; left: 50%; border: 1px solid black; text-align: center; line-height: 12px;">
                    <strong style="font-size: 10px;">Proceso Interno:</strong><br>
                    <span style="font-size: 10px;">Gestión de Servicios, Procesos y Calidad</span>
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
                <span style="font-size: 10px;"> F-SPC-012 </span>
            </div>

            <div class="borde" style="width: 100%; height: 14px; position: absolute; top: 16px; left: 0; display: flex; border: 1px solid black; line-height: 12px; text-align: center;">
                <span style="font-size: 10px;">00</span>
            </div>

            <div class="borde" style="width: 100%; height: 35px; position: absolute; top: 31px; left: 0; display: flex; border: 1px solid black; line-height: 26px; text-align: center;">
                <span style="font-size: 10px;"> 7/10/2020 </span>
            </div>

        </div>

    </div>
    <!-- CABEZERA -->

    <!-- CABEZERA DE LA ENCUESTA -->
    <div style="margin-top: 80px;" class="center-text">
        <spam class="spam1"> Estimado Usuario, solicitamos su colaboración en el llenado del siguiente cuestionario. Su opinión es importante para nosotros. Sus respuestas serán tratadas de forma confidencial y serán utilizadas para mejorar el servicio que le brindamos.
        </spam>
    </div>

    <div style="margin-top: 10px;" class="center-left">
        <div class="block">
            <strong class="spam1">Fecha:</strong> <spam class="spam1"> {{ $encuestas->fecha }} </spam>
        </div>

        @if($encuestas->name_unidad != '')
        <div class="block">
            <strong class="spam1">Nombre de la Unidad:</strong> <spam class="spam1"> {{ $encuestas->name_unidad }} </spam>
        </div>
        @endif

        @if($encuestas->servicio != '')
        <div class="block">
            <strong class="spam1">Nombre del Servicio:</strong> <spam class="spam1"> {{ $encuestas->servicio }} </spam>
        </div>
        @endif

        <div class="block">
            <strong class="spam1">Área que prestó el servicio:</strong> <spam class="spam1"> {{ $encuestas->nombreArea }} </spam>
        </div>

        <div class="block">
            <strong class="spam1">Ciudad:</strong> <spam class="spam1"> {{ $encuestas->ciudad }} </spam>
        </div>

    </div>

    <div style="margin-top: 20px;" class="center-text">
        <spam class="spam1"> En una escala del 1 al 5, donde 1 es nada satisfecho y 5 es totalmente satisfecho, por favor califique: 
        </spam>
    </div>

    <!-- CABEZERA DE LA ENCUESTA -->

    <!-- ENCUESTA -->
    <div style="margin-top: 5px;">
        <table style="background-color: #ffffff;">
            <tr class="spam1" style="background-color: #fafafa;">
                <th>¿Qué tan satisfecho se encuentra usted con...?</th>
                <th>Totalmente Insatisfecho <img src="{{ public_path('img/muy_triste.png') }}" alt="Foto" width="18" height="18" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Poco Insatisfecho <img src="{{ public_path('img/triste.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Neutral <img src="{{ public_path('img/neutral.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Muy Satisfecho <img src="{{ public_path('img/feliz.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Totalmente Satisfecho <img src="{{ public_path('img/muy_feliz.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
            </tr>

            @foreach($preguntas as $index => $pregunta)
                @if($index < count($preguntas) - 1)
                <tr class="spam1">
                    <td>{{ $pregunta['nombre'] }}</td>

                    @foreach($pregunta['opciones'] as $opcione)
                    <?php 
                    $resp = '';
                    if($opcione['respuesta'] == 'true'){
                        $resp = 'X';
                    }else{
                        $resp = '';
                    }
                    ?>
                    <td>{{ $resp }}</td>
                    @endforeach
                </tr>
                @endif
            @endforeach

        </table>

        <table style="margin-top: 10px; background-color: #ffffff;">
            <tr style="background-color: #fafafa;">
                <th colspan="6">RESPECTO A LA ATENCIÓN BRINDADA POR EL SERVIDOR PÚBLICO</th>
            </tr>
            <tr class="spam1" style="background-color: #fafafa;">
                <th>¿Qué tan sastisgecho está usted con...?</th>
                <th>Totalmente Insatisfecho <img src="{{ public_path('img/muy_triste.png') }}" alt="Foto" width="18" height="18" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Poco Insatisfecho <img src="{{ public_path('img/triste.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Neutral <img src="{{ public_path('img/neutral.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Muy Satisfecho <img src="{{ public_path('img/feliz.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
                <th>Totalmente Satisfecho <img src="{{ public_path('img/muy_feliz.png') }}" alt="Foto" width="14" height="14" style="margin-left: 10%; margin-top: 6%;"> </th>
            </tr>

            @foreach($preguntas as $index => $pregunta)
                @if($index == count($preguntas) - 1)
                <tr class="spam1">
                    <td>{{ $pregunta['nombre'] }}</td>

                    @foreach($pregunta['opciones'] as $opcione)
                    <?php 
                    $resp = '';
                    if($opcione['respuesta'] == 'true'){
                        $resp = 'X';
                    }else{
                        $resp = '';
                    }
                    ?>
                    <td>{{ $resp }}</td>
                    @endforeach
                </tr>
                @endif
            @endforeach
        </table>
    </div>
    <!-- ENCUESTA -->


    @if($encuestas->servidor_publico != '')
    <div style="margin-top: 10px;" class="center-text">
        <strong class="spam1"> En caso de que su respuesta sea menos a 3 respecto a la atención brindada por el servidor público y para que nos ayude a mejorar el servicio, por favor indicarnos el nombre del servidor público que le atendió y el motivo de la calificación:  
        </strong>
    </div>
    @endif
    <div style="margin-top: 10px;" class="center-left">
        @if($encuestas->servidor_publico != '')
        <div class="block">
            <strong class="spam1">Nombre del servidor público:</strong> <spam class="spam1"> {{ $encuestas->servidor_publico }} </spam>
        </div>

        <div class="block">
            <strong class="spam1">Motivo de la Calificación:</strong> <spam class="spam1"> {{ $encuestas->motivo_califica }} </spam>
        </div>
        @endif

        <div class="block">
            <strong class="spam1">Comentarios y/o sugerencias respecto:</strong> <spam class="spam1"> {{ $encuestas->comentario }} </spam>
        </div>

    </div>

    <div style="margin-top: 30px; color: #7A7A7A;" class="center-text">
        <strong class="spam2"> ¡GRACIAS por su colaboración para mejorar el servicio!  
        </strong>
    </div>

    


        <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 810, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 7);
            ');
        }
	    </script>

</div>
      


</body>
</html>








