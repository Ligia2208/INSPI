<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>CONTROL DE CALIDAD INDIRECTO</title>
        <style>
          body { font-family: Arial, sans-serif; font-size: 9px; /* reducido para A4 horizontal */}
          table { border-collapse: collapse;width: 100%; }
          th, td { border: 1px solid black; padding: 2px;text-align: center; vertical-align: middle;}
          .no-border, .no-border td, .no-border th { border: none !important;}
          .hr-line { border-top: 2px solid black;  padding: 0; height: 10px; }
          .vertical-text { writing-mode: vertical-lr; /* texto de arriba hacia abajo */transform: rotate(270deg);   /* sin giro adicional */ white-space: nowrap;}
          .bold { font-weight: bold; }
          .underline { text-decoration: underline; }
          .italic { font-style: italic; }
        </style>
        
          
    </head>
    <body>
      <!-- ENCABEZADO -->
      <table class="no-border">
        <tr>
          <!-- Logo izquierda -->
          <td style="width: 25%; text-align: center; vertical-align: top;">
            <img src="img/logo_inspi.jpg" alt="Logo INSPI" style="max-width: 80%; height: auto;">
            <input type="text" value="CRN-PAMI-INSPI" readonly style="margin-top: 5px; width: 80%; 
            background-color: #f0f0f0d2; border: 1px solid #000; padding: 2px;">
          </td>
      
          <!-- Título central -->
          <td style="width: 50%; text-align: center; vertical-align: top;">
            <div style="font-size: 18px; font-weight: bold; margin-top: 20px;">CONTROL DE CALIDAD INDIRECTO</div>
          </td>
      
          <!-- Escudo derecha -->
          <td style="width: 25%; text-align: center; vertical-align: top;">
            <img src="img/escudo.jpg" alt="Escudo del Ecuador" style="max-width: 60px; height: auto;">
            <div style="font-size: 12px; margin-top: 5px;">Aseguramiento de la Calidad del Diagnóstico</div>
          </td>
        </tr>
      
        <!-- lINEA -->
        <tr>
          <td colspan="3" style="border-top: 2px solid black !important; border-left: none; border-right: none; border-bottom: none; height: 10px; padding: 0;"></td>
        </tr>
        
        <!-- Segunda fila con campos -->
        <tr>
          <td colspan="3">
            <table class="no-border" style="margin-top: 10px;">
              <tr>
                <td style="width: 30%;">Código de Microscopista Evaluado:</td>
                <td style="width: 20%;">
                  <input type="text" value="LR3PA" readonly style="width: 90%; background-color: #f0f0f0d2; border: 1px solid #000; padding: 2px;">
                </td>                
                <td style="width: 15%; text-align: right;">Fecha Inicial:</td>
                <td style="width: 15%;">
                  <input type="text" value="1/1/2025" readonly style="width: 90%; background-color: #f0f0f0d2; border: 1px solid #000; padding: 2px;">
                </td>
                <td style="width: 10%; text-align: right;">Fecha Final:</td>
                <td style="width: 10%;">
                  <input type="text" value="31/12/2025" readonly style="width: 90%; background-color: #f0f0f0d2; border: 1px solid #000; padding: 2px;">
                </td>
              </tr>
            </table>
          </td>
        </tr>
      
        <!-- Calificación -->
        <tr>
          <td colspan="3" style="text-align: right; font-size: 12px; padding-top: 5px; padding-right: 80px;">
            Calificación: Bueno - 0; Malo - 1
          </td>
        </tr>        
      </table>        
      <br>
      
      <!-- CUERPO1 -->
      <table style="border-collapse: collapse; font-size: 6.5px; width: 100%;" border="1">
        <thead>
          <tr>
            <th colspan="4">DATOS BÁSICOS</th>
            <th rowspan="2">Error Identificación</th>
            <th colspan="3">CALIDAD GOTA GRUESA</th>
            <th colspan="4">CALIDAD COLORACIÓN</th>
            <th colspan="3">CALIDAD EXTENDIDO</th>
            <th colspan="4">RESULTADOS CONTROL DE CALIDAD</th>
            <th colspan="4">RESULTADOS MICROSCOPISTA</th>
            <th rowspan="2">CÓD. LECTOR</th>
            <th colspan="2">FECHAS</th>
          </tr>
          <tr>
            <th>Fecha</th>
            <th>Semana</th>
            <th>Código Microscopista</th>
            <th># Lámina</th>
            <th>Tamaño</th>
            <th>Ubicación</th>
            <th>Grosor</th>
            <th>Deshemoglobinación</th>
            <th>Tonalidad</th>
            <th>Precipitado</th>
            <th>Contaminación</th>
            <th>Tamaño</th>
            <th>Ubicación</th>
            <th>Extendido</th>
            <th>Diagnóstico - Control</th>
            <th>Recuento - Control VIVAX</th>
            <th>Recuento - Control FALCIPARUM</th>
            <th>Presencia Fg - Control</th>
            <th>Diagnóstico - Microscopista</th>
            <th>Recuento - Microscopista VIVAX</th>
            <th>Recuento - Microscopista FALCIPARUM</th>
            <th>Presencia Fg - Microscopista</th>
            <th>Año</th>
            <th>Mes</th>
          </tr>
        </thead>
        <tbody>
          <!-- filas de ejemplo -->
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>475</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>V</td><td>3248</td><td></td><td></td><td>V</td><td>3520</td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>478</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>V</td><td>2160</td><td></td><td></td><td>V</td><td>2520</td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>479</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>V</td><td>2540</td><td></td><td></td><td>V</td><td>2815</td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>494</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>V</td><td>3216</td><td></td><td></td><td>V</td><td>2917</td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>498</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>V</td><td>1468</td><td></td><td></td><td>V</td><td>1845</td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>472</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>485</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
          <tr><td>7/4/2025</td><td>30</td><td>WT5</td><td>493</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>N</td><td></td><td></td><td></td><td>MA</td><td>2025</td><td>4</td></tr>
        </tbody>
      </table>
      <br>

    </body>
</html>
