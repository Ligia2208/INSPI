<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>INFORME PREVIO DE RESULTADOS</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 6px; vertical-align: top; }
            .center { text-align: center; vertical-align: middle;}
            .bold { font-weight: bold; }
            .underline { text-decoration: underline; }
            .italic { font-style: italic; }
            .no-border, .no-border td, .no-border th { border: none !important;}
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
                    <th colspan="2">INFORME PREVIO DE RESULTADOS DE CONTROL DE CALIDAD INDIRECTO DE LÁMINAS</th>
                    <th style="width: 4%;">CÓDIGO</th>
                    <th style="width: 18%;">F-PAMI-015</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">MACRO-PROCESO:</span> Laboratorios de Vigilancia Epidemiológica y Referencia Nacional
                    </td>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">PROCESO INTERNO:</span> Centro de Referencia Nacional de Parasitología y Micología
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
                    <td>29/12/2021</td>
                </tr>

            </thead>
        </table>
        <br>
        
        <!-- CUERPO1 -->
        <table class="no-border">
            <tr>
                <td style="border: none;"><strong>EVENTO:</strong> Ligia</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Fecha:</strong> {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Unidad de Aseguramiento de la Calidad:</strong> IESS </td>
                <td style="border: none;"><strong>Provincia:</strong> Los Rios</td>
                <td style="border: none;"><strong>Cantón:</strong> Babahoyo</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Responsable de la UAC:</strong> Nathaly</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Semana o mes:</strong> Abril</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Fecha de recepción de láminas:</strong> {{ date('d-m-Y') }}</td>
            </tr>
           
        </table>
        <br>

        <!-- CUERPO2 -->
    
        <table class="center" style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr>
              <th colspan="8" style="font-weight: bold; padding-bottom: 10px;">
                CONTROL DE CALIDAD INDIRECTO REALIZADO POR EL <span class="underline">CRN DE PARASITOLOGÍA Y MICOLOGÍA:</span>
              </th>
            </tr>
            <tr>
              <th colspan="8" style="text-align: left; padding-bottom: 5px;">
                Resultado:
              </th>
            </tr>
            <tr>
              <th># Total Láminas Recibidas en CRN</th>
              <th># Láminas Positivas Recibidas en CRN</th>
              <th># Láminas Negativas Recibidas en CRN</th>
              <th># Láminas Revisadas en el CRN</th>
              <th># Láminas Positivas Concordantes</th>
              <th># Láminas Positivas Discordantes</th>
              <th># Láminas Negativas Concordantes</th>
              <th># Láminas Negativas Discordantes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>685</td>
              <td>60</td>
              <td>625</td>
              <td>122</td>
              <td>60</td>
              <td>0</td>
              <td>62</td>
              <td>0</td>
            </tr>
          </tbody>
        </table>
        <br>

        <!-- Tabla der -->
        <table style="width: 49%; float: left; font-size: 14px;">
          <tr style="height: 35px;">
            <th class="center">Puntaje Acumulado</th>
            <th class="center">Interpretación</th>
          </tr>

          <tr>
            <td class="center bold" style="font-size: 16px; vertical-align: middle; height: 80px;">98%</td>
            <td class="center" style="font-size: 16px; vertical-align: middle; height: 80px;">Excelente</td>
          </tr>
          
        </table>
        <!-- Tabla izq -->
        <table style="width: 49%; float: right; font-size: 14px;">
          <tr style="height: 35px;">
            <td colspan="2" class="italic underline center"><strong>
              Porcentajes alcanzado por parámetros evaluados</strong>
            </td>
          </tr>
          <tr style="height: 35px;">
            <td class="italic underline center">Resultado</td>
            <td class="center"><strong>100.00%</strong></td>
          </tr>
          <tr style="height: 35px;">
            <td class="italic underline center">Especie</td>
            <td class="center"><strong>100.00%</strong></td>
          </tr>
          <tr style="height: 35px;">
            <td class="italic underline center">Recuentos</td>
            <td class="center"> <strong>83.90%</strong></td>
          </tr>
        </table>
        <div style="clear: both;"></div>
        <br>
        <br>
 
    
        <!-- CUERPO3 -->
        <table class= "no-border" style="width: 100%; text-align: left;">
            <tr>
              <td style="width: 60%;">
                <span class="underline">Responsable del control indirecto del CRN de Parasitología y Micología:</span>
              </td>
              <td style="width: 40%;">
                <strong><span class="underline">Lcd. Marcelo Andrade</span></strong>
              </td>              
            </tr>

            <tr>
              <td colspan="2" style="padding-top: 20px;">
                <strong>OBSERVACIONES / RECOMENDACIONES:</strong><br><br>
                <hr style="border: 1px solid #000; margin: 12px 0;">
                <hr style="border: 1px solid #000; margin: 12px 0;">
                <hr style="border: 1px solid #000; margin: 12px 0;">
                <hr style="border: 1px solid #000; margin: 12px 0;">
                <hr style="border: 1px solid #000; margin: 12px 0;">
              </td>
            </tr>
        </table>
        <br>
        <br>


        <!-- INFERIOR -->
        <table class="no-border" style="width: 100%; text-align: center; margin-top: 30px;">
          <tr>
            <td style="width: 50%; text-align: center; padding-right: 30px;">
              <hr style="width: 70%; margin-bottom: 5px;">
              <strong>Dr. Luis Solórzano Álava</strong><br>
              Responsable del Centro de Referencia Nacional de <br>
              Parasitología y Micología - INSPI
            </td>
        
            <td style="width: 50%; text-align: center;">
              <hr style="width: 70%; margin-bottom: 5px;">
              <strong>Lcd. Marcelo Andrade Castro</strong><br>
              Analista Técnico del Centro de Referencia Nacional de <br>
              Parasitología y Micología - INSPI
            </td>
          </tr>
        </table>        
        <br>
        <br>
        <br>
        
        <!-- PIE -->
        <div id="footer" style="width: 100%; text-align: center; font-size: 10px; border: 2px solid black; padding: 6px 0;">
          <strong>Página <span id="current-page">1</span>/<span id="total-pages">1</span></strong>
        </div>
               

        <script>
            // Función para actualizar el pie de página
            function actualizarPieDePagina(currentPage, totalPages) {
                document.getElementById("current-page").textContent = currentPage;
                document.getElementById("total-pages").textContent = totalPages;
            }

            // Ejemplo de uso: suponer que la página actual es 1 y hay un total de 5 páginas
            actualizarPieDePagina(1, 2);
        </script>

    </body>
</html>
