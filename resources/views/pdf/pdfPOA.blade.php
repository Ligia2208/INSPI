<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PDF EN BLANCO</title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
    .inferior th, td {
        padding: 8px;
        text-align: left;
        text-align: center;
    }

    .invisible {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .invisible2 {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .invisible3 {
        border-top: none;
        border-bottom: none;
        color: white;
    }

    .firma {
        border-bottom: none;
    }

    .letra{
        font-size: 11px;
    }

</style>
</head>

<body>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center; vertical-align: middle;" class="letra">
        <thead>
            <tr>
                <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                </th>
                <th colspan="2">CERTIFICACIÓN POA INSTITUTO NACIONAL DE INVESTIGACIÓN EN SALUD PÚBLICA &quot;LEOPOLDO IZQUIETA PÉREZ&quot; - INSPI</th>
                <th style="width: 6%;">CÓDIGO</th>
                <th style="width: 6%;">F-PI-007</th>
            </tr>
            <tr>
                <td rowspan="2" style="width: 30%;">MACRO-PROCESO: Dirección de Planificación y Gestión Estratégica</td>
                <td rowspan="2" style="width: 40%;">PROCESO INTERNO: Planificación e inversión</td>
                <td style="border: 1px solid black; width: 10%;">Edición</td>
                <td>03</td>
            </tr>
            <tr>
                <td>Fecha de aprobación</td>
                <td>08/01/2024</td>
            </tr>
        </thead>
    </table><br>





        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;" class="letra">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th colspan="4" style="border: 1px solid black; width: 75%;">SOLICITUD</th>
                    <th colspan="2" style="border: 1px solid black;">VALIDACIÓN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 15%;">Coordinación/ Directiva Técnica o administrativa/ Proyecto</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 40%;">{{$atributos->departamento}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 10%;">Fecha de solicitud</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->fecha}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; width: 10%; background-color: #f0f0f0;">Nro de Certificación POA:</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle; background-color: #f0f0f0; ">{{$atributos->numero}}</td>
                </tr>
            </tbody>
        </table>


        <!-- Nueva fila con checkboxes -->
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: -1px;" class="letra">
            <tbody>
                <tr>
                    <td style="width: 15%; text-align: center; vertical-align: middle; padding-right: 10px;">POA:</td>
                    <td style="width: 35%; text-align: left; vertical-align: middle; padding-left: 10px">
                        @if($atributos->idPoa == 1)
                            Corriente
                        @elseif($atributos->idPoa == 2)
                            Inversión
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: -1px; white-space: normal; word-wrap: break-word;" class="letra">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th colspan="3" style="border: 1px solid black;">PLANIFICACIÓN Y GESTIÓN ESTRATÉGICA</th>
                    <th colspan="8" style="border: 1px solid black;">ESTRUCTURA PRESUPUESTARIA</th>
                    <th colspan="5" style="border: 1px solid black;">PROGRAMACIÓN DE EJECUCIÓN</th>
                    <th rowspan="2" style="border: 1px solid black; width: 6%;text-align: center; vertical-align: middle;">ACTIVIDAD PLANIFICADA</th>
                    <th rowspan="2" style="border: 1px solid black; width: 10%; text-align: center; vertical-align: middle;">MONTO<br>DISPONIBLE POR ITEM PRESUP.<br>(ESIGEF)</th>
                </tr>

                <tr style="background-color: #f0f0f0;">
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 6%;">OBJETIVO OPERATIVO</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 7%;">ACTIVIDAD OPERATIVA</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%;">SUB ACT./<br>OBJ. DE CONTRATACIÓN</td>

                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">UNIDAD EJECUTORA</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">Programa (PR)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%">Proyecto<br>(PY)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%">Actividad (Act)</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 4%;">FUENTE DE FINANCI<br>AMIENTO</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 3%">ITEM PRESUP.</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 7%">DESCR. DE ITEM PRESUP.</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">MONTO PLANIFICADO O REFERENCIAL PAPP</td>

                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">I TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">II TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">III TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">IV TRIMESTRE</td>
                    <th style="border: 1px solid black; text-align: center; vertical-align: middle; width: 5%">TIENE PLURI<br>ANUALIDAD</td>

                </tr>
            </thead>
            <tbody>
                <!-- Filas vacías para llenar desde el controlador -->
                <tr style="height: 100px;">
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->nombreObjOperativo}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->nombreActividadOperativa}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->nombreSubActividad}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->u_ejecutora}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->programa}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->proyecto}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->actividad}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->fuente}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->nombreItem}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->descripcionItem}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->monto}}</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">
                        @if($atributos->enero == 0.00 && $atributos->febrero == 0.00 && $atributos->marzo == 0.00)

                        @else
                            x
                        @endif
                    </td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">
                        @if($atributos->abril == 0.00 && $atributos->mayo == 0.00 && $atributos->junio == 0.00)

                        @else
                            x
                        @endif
                    </td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">
                        @if($atributos->julio == 0.00 && $atributos->agosto == 0.00 && $atributos->septiembre == 0.00)
                            
                        @else
                            x
                        @endif
                    </td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">
                        @if($atributos->octubre == 0.00 && $atributos->noviembre == 0.00 && $atributos->diciembre == 0.00)

                        @else
                            x
                        @endif
                    </td>
                    <td>
                        @if($atributos->plurianual == 1)
                            SI
                        @else
                            NO
                        @endif
                    </td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">SI</td>
                    <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->monto_item}}</td>
                </tr>
                <!-- Repite estas filas según la cantidad de datos que se vayan a llenar -->
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: -1px;" class="letra">
        <tbody>
            <tr>
                <td style="border: 1px solid black; width: 20.71%; text-align: center; vertical-align: middle;">Justificación área requiriente</td>
                <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$atributos->justificacion_area}}</td>
            </tr>
            <tr>
                <td style="border: 1px solid black; text-align: center; vertical-align: middle;">Justificación/Observación de la Dirección de Planificación</td>
                <td style="border: 1px solid black; text-align: center; vertical-align: middle;">{{$comentarios->comentario ?? 'Comentario no disponible por reforma'}}</td>
            </tr>
        </tbody>
    </table> <br>


<!----------------------------------------------------------------------------------------------------------------------------------------------->
    <table class="inferior letra">
        <tr>
            <th colspan="6">AREA REQUIRENTE</th>
            <th colspan="4">DIRECCIÓN DE PLANIFICACIÓN Y GESTIÓN ESTRATÉGICA</th>
        </tr>
        <tr>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
            <th colspan="2" class="firma">Firma</th>
        </tr>
        <tr>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
            <th colspan="2" class="invisible">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
            <th colspan="2" class="invisible2">‎ </th>
        </tr>
        <tr>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
            <th colspan="2" class="invisible3">‎ </th>
        </tr>
        <tr>
            <th>Nombre:</th>
            <td>{{$usuarios['creado']['name']}}</td>
            <th>Nombre:</th>
            <td>{{$usuarios['autorizado']['name']}}</td>
            <th>Nombre:</th>
            <td>{{$usuarios['reporta']['name']}}</td>
            <th>Nombre:</th>
            <td>{{$usuarios['areaReq']['name']}}</td>
            <th>Nombre:</th>
            <td>{{$usuarios['planificacionYG']['name']}}</td>
        </tr>
        <tr>
            <th>Cargo: </th>
            <td>{{$usuarios['creado']['cargo']}}</td>
            <th>Cargo: </th>
            <td>{{$usuarios['autorizado']['cargo']}}</td>
            <th>Cargo: </th>
            <td>{{$usuarios['reporta']['cargo']}}</td>
            <th>Cargo: </th>
            <td>{{$usuarios['areaReq']['cargo']}}</td>
            <th>Cargo: </th>
            <td>{{{$usuarios['planificacionYG']['cargo']}}}</td>
        </tr>
        <tr>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
            <th>Fecha: </th>
            <td><?php echo date('d-m-Y'); ?></td>
        </tr>
        <tr>
            <th colspan="2">Elaborado</th>
            <th colspan="2">Revisado</th>
            <th colspan="2">Aprobado</th>
            <th colspan="2">Validado</th>
            <th colspan="2">Aprobado</th>
        </tr>
    </table>
</body>
