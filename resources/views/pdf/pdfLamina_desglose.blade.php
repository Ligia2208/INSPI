<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>INFORME PREVIO DE RESULTADOS</title>
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
                    <th colspan="2">INFORME PREVIO DE RESULTADOS DE CONTROL DE CALIDAD DE BACILOSCOPÍA</th>
                    <th style="width: 4%;">CÓDIGO</th>
                    <th style="width: 18%;">F-MICOTB-005</th>
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
                    <td>03</td>
                </tr>
                <tr>
                    <td> 
                        <span class="bold">Fecha de Aprobación</span>
                    </td>
                    <td>23/11/2018</td>
                </tr>

            </thead>
        </table>
        <br>
        
        <!-- CUERPO1 -->
        <table class="no-border">
            <tr>
                <td style="border: none;"><strong>Fecha:</strong> {{ date('d/m/Y') }}</td>
                <td rowspan="3" style="padding-left: 10px; padding-right: 10px; text-align: left; width: 30%;">
                    <div style="text-align: center;"><strong>Relectura de Discordancia</strong></div><br>
                    <strong>2do Técnico:</strong><br><br>
                    <strong>3er Técnico:</strong>
                </td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Nombre de Unidad a Supervisar:</strong> {{$datos->instituto}}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Mes Enviado:</strong> {{$datos->mes_recepcion}}</td>
            </tr>
        </table>
        <br>

        <!-- CUERPO2 -->
        @php
            $maxFilas = max(
                count($datos_apariencia ?? []), 
                count($datos_frotis ?? []), 
                count($datos_tincion ?? [])
            );

            $total_apariencia = array_sum(array_column($datos_apariencia ?? [], 'cantidad'));
            $total_frotis     = array_sum(array_column($datos_frotis ?? [], 'cantidad'));
            $total_tincion    = array_sum(array_column($datos_tincion ?? [], 'cantidad'));
        @endphp

        <table style="width: 100%; border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000;">N° LÁMINAS</th>
                    <th style="border: 1px solid #000;">LECTURA</th>
                    <th style="border: 1px solid #000;">APARIENCIA MICROSCÓPICA</th>
                    <th style="border: 1px solid #000;">FROTIS</th>
                    <th style="border: 1px solid #000;">TINCIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laminas as $index => $lamina)
                    <tr>
                        <td style="border: 1px solid #000; text-align: center;">
                            {{ $lamina->nro_lamina ?? '' }}
                        </td>
                        <td style="border: 1px solid #000; text-align: center;">
                            {{ $lamina->lectura ?? '' }}
                        </td>
                        <td style="border: 1px solid #000; text-align: center;">
                            {{ $lamina->apariencia_nombre ?? ''}}
                        </td>
                        <td style="border: 1px solid #000; text-align: center;">
                            {{ $lamina->frotis_nombre ?? '' }}
                        </td>
                        <td style="border: 1px solid #000; text-align: center;">
                            {{ $lamina->tincion_nombre ?? '' }}
                        </td>
                    </tr>
                @endforeach

                    <tr>
                        <td style="border: 1px solid #000; text-align: center;" colspan="2"><b>Total</b></td>
                        <td style="border: 1px solid #000; text-align: center;" colspan="3">
                            {{ $laminas->count() }}
                        </td>
                    </tr>
            </tbody>
        </table>
        <br>


        <!-- CUERPO3 -->
        <table style="border-collapse: collapse; width: 100%;">
            <tbody id="tabla_body">
                <tr>
                    <td style="width: 33%; padding: 8px; vertical-align: top;">
                        <b>SALIVA</b><br>
                        @foreach ($datos_apariencia as $apariencia)
                            @if ($apariencia['cantidad'] > 0)
                                {{ strtoupper($apariencia['nombre']) }}: {{ $apariencia['cantidad'] }}<br>
                            @endif
                        @endforeach
                    </td>
                    <td style="width: 33%; padding: 8px; vertical-align: top;">
                        <strong>CALCULO:</strong><br>
                        <b>EXTENDIDO</b><br>
                        @foreach ($datos_frotis as $frotis)
                            @if ($frotis['cantidad'] > 0)
                                {{ strtoupper($frotis['nombre']) }}: {{ $frotis['cantidad'] }}<br>
                            @endif
                        @endforeach
                    </td>
                    <td style="width: 34%; padding: 8px; vertical-align: top;">
                        <b>TINCIÓN</b><br>
                        @foreach ($datos_tincion as $tincion)
                            @if ($tincion['cantidad'] > 0)
                                {{ strtoupper($tincion['nombre']) }}: {{ $tincion['cantidad'] }}<br>
                            @endif
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="padding: 8px; vertical-align: top; text-align: left;">
                        <b>LÁMINAS RECIBIDAS:</b><br>
                        <b>LÁMINAS SUPERVISADAS:</b> {{$datos->total_laminas}}<br>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>


        <!-- INFERIOR -->
        <table class="no-border" style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="text-align: center; border: none;">
                    <strong>Realizado por:</strong> ____________________________ <br><br>
                </td>
                <td style="text-align: center; border: none;">
                    <strong>Autorizado por:</strong> ____________________________ <br><br>
                </td>
            </tr>
            <tr>
                <td style="border: none; text-align: right; padding-right: 50px;" colspan="2">
                    <strong>Fecha: </strong> {{ date('d-m-Y') }}
                </td>
            </tr>
        </table>
        <br>

        <!-- PIE -->
        <div id="footer" style="text-align: right; font-size: 10px;">
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

    </body>
</html>
