<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>VERIFICACIÓN Y RECEPCIÓN DE LÁMINAS</title>
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
                    <th colspan="2">VERIFICACIÓN Y RECEPCIÓN DE LÁMINAS</th>
                    <th style="width: 6%;">CÓDIGO</th>
                    <th style="width: 10%;">F-MICOTB-001</th>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">MACRO-PROCESO:</span> Laboratorios de Vigilancia Epidemiológica y Referencia Nacional
                    </td>
                    <td rowspan="2" style="width: 30%;"> 
                        <span class="bold">PROCESO INTERNO:</span> Centro de Referencia Nacional de Micobacterias
                    </td>
                    <td style="border: 1px solid black; width: 10%;"> 
                        <span class="bold">Edición</span>
                    </td>
                    <td>01</td>
                </tr>
                <tr>
                    <td> 
                        <span class="bold">Fecha de Aprobación</span>
                    </td>
                    <td>01/04/2025</td>
                </tr>

            </thead>
        </table>
        <br>
        
        <!-- CUERPO1 -->
        <table class="no-border" style="width: 100%; border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; text-align: left; border: none;">Fecha de Recepción de Láminas:</td>
                <td style="width: 50%; text-align: left; border: none;">Nombre del <span class="underline">Laboratorio Supervisado</span>:</td>
            </tr>
            <tr>
                <td style="text-align: left; border: none;">Total de Láminas Recibidas:</td>
                <td style="text-align: left; border: none;">{{ $datos->total_laminas }}</td> <!-- Total de Láminas -->
            </tr>
            <tr>
                <td style="text-align: left; border: none;">Responsable de Recepción:</td>
                <td colspan="1" style="border: none;">{{ $datos->recepta ?? 'No disponible' }}</td> <!-- Responsable -->
            </tr>
            <tr>
                <td style="text-align: left; border: none;">Analista (encargado de Control de Calidad):</td>
                <td style="text-align: left; border: none;">{{ $datos->analita ?? 'No disponible' }}</td> <!-- Analista -->
            </tr>
            <tr>
                <td style="text-align: left; border: none;">Mes <span class="underline">supervisado</span>:</td>
                <td style="text-align: left; border: none;">{{ $datos->mes_recepcion }}</td> <!-- Mes de Recepción -->
            </tr>
        </table>
        <br>

        <!-- CUERPO2: Sección de verificación -->
        <table>
            <thead>
                <tr class="center bold">
                    <td>Verificación</td>
                    <td style="width: 15%;">SI</td>
                    <td style="width: 15%;">NO</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Láminas empacadas en cajas de láminas porta objetos y separadas entre ellas</td>
                    <td>{{ $datos->laminas_empacadas ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_empacadas ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Láminas con información legible y enumeradas en forma consecutiva</td>
                    <td>{{ $datos->laminas_legibles ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_legibles ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Las Láminas sin identificación de su resultado</td>
                    <td>{{ $datos->laminas_sin_id ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_sin_id ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Láminas sin exceso de aceite de inmersión</td>
                    <td>{{ $datos->laminas_sin_aceite ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_sin_aceite ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Láminas con frotis adecuado (tinción y dimensiones establecidas en el Manual de Baciloscopía)</td>
                    <td>{{ $datos->laminas_frotis_adecuado ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_frotis_adecuado ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Láminas íntegras sin rajaduras que afecten al frotis</td>
                    <td>{{ $datos->laminas_integras ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_integras ? 'X' : '' }}</td>
                </tr>
                <tr>
                    <td>Láminas con documentación respectiva (<span class="italic underline">listado con el número y resultado de cada lámina</span>)</td>
                    <td>{{ $datos->laminas_documentacion ? 'X' : '' }}</td>
                    <td>{{ !$datos->laminas_documentacion ? 'X' : '' }}</td>
                </tr>
            </tbody>
        </table>
        <br>

        <!-- PIE -->
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="border-bottom: 1px solid black; text-align: left;"><strong>Observaciones:</strong><br>{{ $datos->observaciones }}</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid black; width: 70%; padding: 5px; text-align: left;">
                    <strong>Realizado por:</strong> ____________________________<br><br>
                </td>
            </tr>
        </table>
        <br>

        <div style="text-align: right; font-size: 10px;">Página 1/1</div>

    </body>
</html>
