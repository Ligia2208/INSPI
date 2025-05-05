<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>CONTROL DE CALIDAD INDIRECTO</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 6px; vertical-align: top; }
            .center { text-align: center; vertical-align: middle;}
            .bold { font-weight: bold; }
            .underline { text-decoration: underline; }
            .italic { font-style: italic; }
            .no-border, .no-border td, .no-border th { border: none !important;}
            .hr-line {border-top: 2px solid black; padding: 0; height: 10px;}
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
      <table>
       
      </table>
      <br>

    </body>
</html>
