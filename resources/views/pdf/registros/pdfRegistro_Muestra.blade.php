<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Datos de la muestra</title>
        <style>
<<<<<<< HEAD
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 9px;
            }
            table {
                width: 100%;
                border: 1px solid #000;
            }
            th, td {
                border: 1px solid #000;
                padding: 2px;
                text-align: center;
            }
            thead th {
                background-color: #eeeeee;
            }
        </style>
=======
            body { font-family: Arial, sans-serif; font-size: 8px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 3px; vertical-align: top; }
            .center { text-align: center; }
            .bold { font-weight: bold; }
            .no-border { border: none; }
            .underline { text-decoration: underline; }
            .italic { font-style: italic; }
            .letra{
                font-size: 8px;;
            }
            .letra2{
                font-size: 6px;;
            }
        </style> 
>>>>>>> edcad5c6c6fe28ad47f33f7475117955a532c00e
    </head>

    <body>
        <!-- ENCABEZADO -->
        <table class="letra" style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: center; vertical-align: middle;">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                    <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                    </th>
                    <th colspan="2">REGISTRO DE DATOS DE LAS MUESTRAS PARA GENOTIPIFICACIÓN</th>
                    <th style="width: 4%;">CÓDIGO</th>
                    <th style="width: 18%;">F-GSB-003</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">MACRO-PROCESO:</span> Laboratorios de Vigilancia Epidemiolígica y Referencia Nacional
                    </td>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">PROCESO INTERNO:</span> Centro de Referencia Nacional de Genómica, Secuenciación y Bioinformática
                    </td>
                    <td style="border: 1px solid black; width: 10%;"> 
                        <span class="bold">Edición</span>
                    </td>
                    <td>02</td>
                </tr>
                <tr>
                    <td> 
                        <span class="bold">Fecha de Aprobación</span>
                    </td>
                    <td>15/04/2024</td>
                </tr>

            </thead>
        </table>
        <br>
    

        <!-- CUERPO1 -->
<<<<<<< HEAD

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Organismo</th>
                    <th>Tipo muestra</th>
                    <th>Fecha colecta</th>
                    <th>Localidad</th>
                    <th>Unidad Salud</th>
                    <th>Sexo</th>
                    <th>Edad</th>
                    <th>CT</th>
                    <th>GENSBIO</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item)
                    <tr>
                        <td>{{ $item->codigo_procedencia ?? 'N/A' }}</td>
                        <td>{{ $item->organismo ?? 'N/A' }}</td>
                        <td>{{ $item->tipo_muestra ?? 'N/A' }}</td>
                        <td>{{ $item->fecha_colecta ?? 'N/A' }}</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>N/A</td>
                        <td>{{ $item->observaciones ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
          <!--<table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
=======
        <table class="letra" style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
>>>>>>> edcad5c6c6fe28ad47f33f7475117955a532c00e
            <thead>
                <tr>
                    <th colspan="11" style="text-align: center; font-weight: bold; background-color: #d3d3d3;">
                        Datos de la muestra
                    </th>
                </tr>
                <tr>
                    <th style="font-size: 10px;">Código de procedencia</th>
                    <th style="font-size: 10px;">Organismo</th>
                    <th style="font-size: 10px;">Tipo de muestra</th>
                    <th style="font-size: 10px;">Fecha de colecta</th>
                    <th style="font-size: 10px;">Localidad</th>
                    <th style="font-size: 10px;">Unidad de Salud</th>
                    <th style="font-size: 10px;">Sexo (Hombre / Mujer)</th>
                    <th style="font-size: 10px;">Edad</th>
                    <th style="font-size: 10px;">CT</th>
                    <th style="font-size: 10px;">Código GENSBIO</th>
                    <th style="font-size: 10px;">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos as $item )
                    <tr>
                        <td>{{ $item->codigo_procedencia ?? '' }}</td>
                        <td>{{ $item->nombre_organismo ?? '' }}</td>
                        <td>{{ $item->tipo_muestra ?? '' }}</td>
                        <td>{{ $item->fecha_colecta ?? '' }}</td>
                        <td>{{$item->canton}}</td>
                        <td>{{$item->institucion}}</td>
                        <td>{{$item->sexo}}</td>
                        <td>{{$item->edad}}</td>
                        <td>{{$item->ct}}</td>
                        <td>{{$item->codigo_calidad}}</td>
                        <td>{{ $item->observaciones ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>-->
        <br>


        <!-- CUERPO2 -->
        <table class="letra2" style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; font-weight: bold; background-color:rgb(107, 108, 109); color: white; padding: 5px;">
                        Instrucciones: (Llenar con N/A, en caso de que no aplique la información solicitada o no exista.)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 5px; width: 25%;">Código</td>
                    <td style="padding: 5px; width: 75%;">Código completo asignado en el laboratorio de origen / CRN / unidad de salud.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Organismo</td>
                    <td style="padding: 5px; width: 75%;">Organismo a secuenciar al nivel taxonómico más específico conocido.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Tipo de muestra</td>
                    <td style="padding: 5px; width: 75%;">Elegir entre: Muestra primaria (detallar el tipo), alícuota (detallar el tipo), cultivo, material genético: ADN o ARN.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Fecha de colecta</td>
                    <td style="padding: 5px; width: 75%;">Fecha en la que se colectó la muestra (Año-Mes-Día).</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Localidad</td>
                    <td style="padding: 5px; width: 75%;">País / provincia / ciudad / localidad.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Unidad de salud</td>
                    <td style="padding: 5px; width: 75%;">Registrar la unidad de salud de donde provienen la muestra.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Sexo</td>
                    <td style="padding: 5px; width: 75%;">Hombre / Mujer</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Edad</td>
                    <td style="padding: 5px; width: 75%;">Edad del paciente al momento de la toma de muestra.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">CT</td>
                    <td style="padding: 5px; width: 75%;">Umbral de ciclos, así como el número de ciclos en el que la señal fluorescente cruza este umbral.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">*Código GENSBIO</td>
                    <td style="padding: 5px; width: 75%;">Código asignado para el CRN Genómica, Secuenciación y Bioinformática. Campo de uso exclusivo para ser llenado por el personal del INSPI que recibe las muestras.</td>
                </tr>
                <tr>
                    <td style="padding: 5px; width: 25%;">Observaciones</td>
                    <td style="padding: 5px; width: 75%;">Información adicional relevante.</td>
                </tr>
            </tbody>
        </table>
        <br>
        

        <!-- INFERIOR -->
        <table class="letra" style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                <th style="border: 1px solid #000; text-align: center; width: 30%;">Entregado por:</th>
                <th style="border: 1px solid #000; text-align: center; width: 30%;">Recibido por:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; height: 50px;"></td>
                    <td style="border: 1px solid #000; height: 50px;"></td>
                </tr>
                <tr>
                    <th style="border: 1px solid #000; text-align: center; width: 30%;">Firma</th>
                    <th style="border: 1px solid #000; text-align: center; width: 30%;">Firma</th>
                </tr>

                <tr>
                    <th style="border: 1px solid #000; text-align: left; width: 30%;">Fecha: {{ date('d-m-Y') }}</th>
                    <th style="border: 1px solid #000; text-align: left; width: 30%;">Fecha: {{ date('d-m-Y') }}</th>
                </tr>
        
            </tbody>
        </table>
        <br>

        <!-- PIE -->
        <div id="footer" style="text-align: right; font-size: 10px; border: 1px solid #000;">
            Página <span id="current-page">1</span>/<span id="total-pages">1</span>
        </div>

        <script>
            // Función para actualizar el pie de página
            function actualizarPieDePagina(currentPage, totalPages) {
                document.getElementById("current-page").textContent = currentPage;
                document.getElementById("total-pages").textContent = totalPages;
            }

            // Ejemplo de uso: suponer que la página actual es 1 y hay un total de 5 páginas
            actualizarPieDePagina(1, 5);
        </script>
        <br>


        <!-- INFERIOR2 -->
        <table style="width: 80%; border: 1px solid #000; border-collapse: collapse; margin: auto; font-size: 10px;">
            <thead>
                <tr>
                    <th style="text-align: center; width: 33%;">Elaborado</th>
                    <th style="text-align: center; width: 33%;">Revisado</th>
                    <th style="text-align: center; width: 33%;">Aprobado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">
                        <p>Analista del Centro de Referencia Nacional de Genómica, Secuenciación y Bioinformática</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Responsable del Centro de Referencia Nacional de Genómica, Secuenciación y Bioinformática</p>
                    </td>
                    <td style="text-align: center;">
                        <p>Coordinador Zonal 9</p>
                    </td>
                </tr>
                <tr>
                    <td>  <br>   <br> </td>
                    <td>  <br>   <br> </td>
                    <td>  <br>   <br> </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <b>Ing. Damaris Alarcón MSc.</b>
                    </td>
                    <td style="text-align: center;">
                        <b>Ing. Andrés Carrasco MSc.</b>
                    </td>
                    <td style="text-align: center;">
                        <b>Ing. Isaac Armendáriz, MSc.</b>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>
                    <td style="text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>
                    <td style="text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>

                </tr>
            </tbody>
        </table>
        <br>

    </body>
</html>
