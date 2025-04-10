<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>REGISTRO DE SOLICITUD DE SERVICIOS</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 6px; vertical-align: top; }
            .center { text-align: center; }
            .bold { font-weight: bold; }
            .no-border { border: none; }
            .underline { text-decoration: underline; }
            .italic { font-style: italic; }
        </style> 
    </head>
    <body>
        <!-- ENCABEZADO -->
        <table class="letra" style="width: 100%; border-collapse: collapse; font-size: 12px; text-align: center; vertical-align: middle;">
            <thead>
                <tr>
                    <th rowspan="3" style="width: 22.5%; text-align: center; vertical-align: middle;">
                    <img src="img/logo_peque.png" alt="Foto" width="125" height="80">
                    </th>
                    <th colspan="2">REGISTRO DE SOLICITUD DE SERVICIOS</th>
                    <th style="width: 4%;">CÓDIGO</th>
                    <th style="width: 18%;">F-GSB-004</th>
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
        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                    <th colspan="5" style="border: 1px solid #000; text-align: center; font-weight: bold;">
                        SECUENCIACIÓN Y BIOINFORMÁTICA
                    </th>
                </tr>
                <tr>
                    <th colspan="5" style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #d3d3d3;">
                        TIPO DE ORGANISMO
                    </th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;">Bacteria</td>
                    <td style="border: 1px solid #000;">Virus</td>
                    <td style="border: 1px solid #000;">Parásitos</td>
                    <td style="border: 1px solid #000;">Hongos</td>
                    <td style="border: 1px solid #000;">Otros (especifique): ___________</td>
                </tr>
            </tbody>
        </table>
        <table>

            <thead>
                <tr>
                    <th colspan="4" style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #d3d3d3;">
                        TIPO DE MUESTRAS ENTREGADAS
                    </th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;">Muestra primaria</td>
                    <td style="border: 1px solid #000;">Alícuota</td>
                    <td style="border: 1px solid #000;">Cultivo</td>
                    <td style="border: 1px solid #000;">Material genético:
                        ADN
                        ARN
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #d3d3d3;">
                        SERVICIO SOLICITADO
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000;">Genotipificación de virus, bacterias, parásitos, hongos, insectos y otros organismos biológicos de importancia en salud pública.</td>
                    <td style="border: 1px solid #000;">Genotipificación para determinación de genes de resistencia a fármacos</td>
                    <td style="border: 1px solid #000;">  Genotipificación de biomarcadores relacionados con enfermedades no transmisibles.</td>
                    <td style="border: 1px solid #000;"> Metagenómica. Detección simultánea de todos los microorganismos presentes en una muestra.</td>
                </tr>
            </tbody>
        </table>
        <br>

        <!-- CUERPO2 -->
        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; text-align: center; font-weight: bold; background-color: #d3d3d3;">
                        DATOS DEL SOLICITANTE
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nombres y apellidos: </td>
                </tr>
                <tr>
                    <td>Nombre del Centro/Laboratorio/Unidad de salud: </td>
                </tr>
                <tr>
                    <td>Teléfono: </td>
                </tr>
                <tr>
                    <td>Correo electrónico: </td>
                </tr>
                <tr>
                    <td>Firma: 
                    <br>
                    <br>
                    </td>
                </tr>
                
                <!-- PIE -->
                <div id="footer" style="text-align: right; font-size: 10px;">
                    Página <span id="current-page">1</span>/<span id="total-pages">1</span>
                </div>
            
            </tbody>
        </table>
        <br>

        <script>
            // Función para actualizar el pie de página
            function actualizarPieDePagina(currentPage, totalPages) {
                document.getElementById("current-page").textContent = currentPage;
                document.getElementById("total-pages").textContent = totalPages;
            }

            // Ejemplo de uso: suponer que la página actual es 1 y hay un total de 5 páginas
            actualizarPieDePagina(1, 5);
        </script>


        <!-- INFERIOR2 -->
        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; text-align: center; width: 33%;">Elaborado</th>
                    <th style="border: 1px solid #000; text-align: center; width: 33%;">Revisado</th>
                    <th style="border: 1px solid #000; text-align: center; width: 33%;">Aprobado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">
                        <p>Analista del Centro de Referencia Nacional de Genómica, Secuenciación y Bioinformática</p>
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        <p>Responsable del Centro de Referencia Nacional de Genómica, Secuenciación y Bioinformática</p>
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        <p>Coordinador Zonal 9</p>
                    </td>
                </tr>
                <tr>
                    <td>  <br>   <br> </td>
                    <td>  <br>   <br> </td>
                    <td>  <br>   <br> </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">
                        <b>Ing. Damaris Alarcón MSc.</b>
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        <b>Ing. Andrés Carrasco MSc.</b>
                    </td>
                    <td style="border: 1px solid #000; text-align: center;">
                        <b>Ing. Isaac Armendáriz, MSc.</b>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>
                    <td style="border: 1px solid #000; text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>
                    <td style="border: 1px solid #000; text-align: center; width: 30%;">Fecha: {{ date('d-m-Y') }}</td>

                </tr>
            </tbody>
        </table>
        <br>

    </body>
</html>
