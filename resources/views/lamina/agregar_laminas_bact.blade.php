
@extends('layouts.main')

@section('title', 'Desglose de Láminas')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="height: 95px;" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Desglose de Láminas</h5></a>
            </div>
            <div class="row">
                <div class="mb-2 col-lg-2">
                    <label for="puntuacion" class="form-label">Puntuación</label>
                    <input type="text" id="puntuacion" class="form-control" disabled="" readonly="">
                </div>
                <div class="mb-2 col-lg-2">
                    <label for="interpretacion" class="form-label">Interpretación</label>
                    <input type="text" id="interpretacion" class="form-control" disabled="" readonly="">
                </div>
                <div class="mb-2 col-lg-2">
                    <label for="porcentajeResult" class="form-label">Porcentaje Resultado</label>
                    <input type="text" id="porcentajeResult" class="form-control" disabled="" readonly="">
                </div>
                <div class="mb-2 col-lg-2">
                    <label for="porcentajeEspe" class="form-label">Porcentaje Especie</label>
                    <input type="text" id="porcentajeEspe" class="form-control" disabled="" readonly="">
                </div>
                <div class="mb-2 col-lg-2">
                    <label for="porcentajeRecuen" class="form-label">Porcentaje Recuento</label>
                    <input type="text" id="porcentajeRecuen" class="form-control" disabled="" readonly="">
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">
            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-window-plus titulo-grande"></i> Ingreso de Láminas </h2>

            <hr/>

            <div class="card card-custom card-sticky" id="kt_page_sticky_card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos Generales</h1>
                            <input type="hidden" id="id_ingreso" name="id_ingreso" class="form-control" required="" autofocus="" value="">
                        </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-4">
                                <label for="fecha_recep" class="form-label fs-6">Fecha de Recepción</label>
                                <input type="date" id="fecha_recep" name="fecha_recep" class="form-control" required autofocus value="" >
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-8">
                                <label for="centro_salud" class="form-label fs-6">Nombre del Laboratorio Supervisado</label>
                                <input type="text" id="centro_salud" name="centro_salud" class="form-control" required autofocus value="" >
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="evento" class="form-label fs-6">Evento</label>
                                <select name="evento" class="form-control single-select">
                                    <option value="">Selecciona una Opción</option>
                                    <option value="MALARIA">MALARIA</option>
                                    <option value="CHAGAS">CHAGAS</option>
                                    <option value="LESMANIASIS">LESMANIASIS</option>
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="responsable" class="form-label fs-6">Responsable Recepción</label>
                                <input type="text" id="responsable" name="responsable" class="form-control" required autofocus value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha_recebcion" class="form-label fs-6">Fecha de Recepción de láminas:</label>
                                <input type="date" id="fecha_recebcion" name="fecha_recebcion" class="form-control" value="" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="mes_recepcion" class="form-label fs-6">Semana o Mes</label>
                                <input type="text" id="mes_recepcion" name="mes_recepcion" class="form-control" value="" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="total_laminas" class="form-label fs-6">Total de Láminas</label>
                                <input type="number" id="total_laminas" name="total_laminas" class="form-control" value="" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="total_laminas_super" class="form-label fs-6">Total de Láminas Recibidas</label>
                                <input type="number" id="total_laminas_super" name="total_laminas_super" class="form-control" required value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="codigo" class="form-label fs-6">Código Microscopista Evaluado:</label>
                                <select name="codigo" id="codigo" class="form-control single-select">
                                    <option value="">Selecciona una Opción</option>
                                    <option value="LR1-ES">LR1-ES</option>
                                    <option value="LR3-PA">LR3-PA</option>
                                    <option value="LR6-MO">LR6-MO</option>
                                    <option value="LR7-EO">LR7-EO</option>
                                    <option value="LR8-GU">LR8-GU</option>
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha_inicio" class="form-label fs-6">Fecha Inicial:</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha_fin" class="form-label fs-6">Fecha Final:</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-12 mt-2 mb-2">
                                <label for="observacion" class="form-label fs-6">Observación:</label>
                                <textarea id="observacion" name="observacion" class="form-control" rows="3" required></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <input type="text" id="resultado_total" class="form-control" disabled placeholder="Total Resultado" hidden>
                            <input type="text" id="resultado_especie" class="form-control" disabled placeholder="Total Resultado Especie" hidden> 
                            <input type="text" id="resultado_recuento" class="form-control" disabled placeholder="Total Resultado Recuento" hidden>
                            <input type="text" id="resultado_recuento_total" class="form-control" disabled placeholder="Total Resultado Recuento Total" hidden>
                            <input type="text" id="resultado_recuento_total_valor" class="form-control" disabled placeholder="Total Resultado Recuento Valor" hidden>
                            <input type="text" id="resultado_recuento_total_especie" class="form-control" disabled placeholder="Total Resultado Recuento Especie" hidden>
                            <input type="text" id="resultado_total_sumatoria" class="form-control" disabled placeholder="Total Resultado Sumatoria" hidden>
                            
                        </div>
                    </div>
                </div>


                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Desglose de Láminas</h5>
                    </div>
                    <div class="card-body">


                    <table class="table table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th colspan="4">DATOS BÁSICOS</th>
                                <th colspan="4">RESULTADOS CONTROL DE CALIDAD</th>
                                <th colspan="4">RESULTADOS MICROSCOPISTA</th>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <th>Semana</th>
                                <th>Código Micro</th>
                                <th># Lámina</th>

                                <th>Diagnóstico - Control</th>
                                <th>Recuento - Control VIVAX</th>
                                <th>Recuento - Control FALCIPARUM</th>
                                <th>Presencia Fg - Control</th>

                                <th>Diagnóstico - Microscopista</th>
                                <th>Recuento - Microscopista VIVAX</th>
                                <th>Recuento - Microscopista FALCIPARUM</th>
                                <th>Presencia Fg - Microscopista</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_body">
                            <tr>
                                <td>
                                    <input type="date" id="fecha_${i}" name="fecha_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>   
                                </td>
                                <td>
                                    <input type="text" id="semana_${i}" name="semana_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <input type="text" id="codigo_micro_${i}" name="codigo_micro_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <input type="text" id="num_lamina_${i}" name="num_lamina_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <select name="diagnostico_calidad_${i}" class="form-control single-select">
                                        <option value="">Selecciona una Opción</option>
                                        <option value="1">F - Falciparum</option>
                                        <option value="2">N - Negativo</option>
                                        <option value="3">V - Vivax</option>
                                    </select>
                                </td>  
                                <td>
                                    <input type="text" id="recuento_control_vivax_${i}" name="recuento_control_vivax_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <input type="text" id="recuento_control_falciparum_${i}" name="recuento_control_falciparum_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                    
                                </td>
                                <td>
                                    <input type="text" id="presencia_control_${i}" name="presencia_control_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>


                                <td>
                                    <select name="diagnostico_microscopista_${i}" class="form-control single-select">
                                        <option value="">Selecciona una Opción</option>
                                        <option value="1">F - Falciparum</option>
                                        <option value="2">N - Negativo</option>
                                        <option value="3">V - Vivax</option>
                                    </select>
                                </td>   
                                <td>
                                    <input type="text" id="recuento_microscopista_vivax_${i}" name="recuento_microscopista_vivax_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <input type="text" id="recuento_microscopista_falciparum_${i}" name="recuento_microscopista_falciparum_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                                <td>
                                    <input type="text" id="presencia_control_${i}" name="presencia_control_${i}" class="form-control" required autofocus value="" disabled>
                                    <div class="valid-feedback">Looks good!</div>
                                </td>
                            </tr>


                            <!-- Agregar más filas según sea necesario -->
                        </tbody>
                    </table>




                    </div>
                </div>


                <div id="resultados-container" class="mt-4">
                    <!-- Aquí se agregarán los inputs resultado dinámicamente -->
                </div>


            </div>





            <div class="col-lg-12 d-flex align-items-center justify-content-center mt-5">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" id="btnGuardarSolicitud" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Guardar
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/laminas'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
            </div>

        </div>




    </div>

</div>


@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Lamina/agregar_lamina_bact.js?v0.0.0')}}"></script>
@endpush
