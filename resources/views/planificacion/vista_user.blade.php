
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.5/dist/css/select2.min.css" rel="stylesheet" />


    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Planificacion/vistaUser_poa.js?v0.0.11')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Versión específica de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.5/dist/js/select2.min.js"></script>

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

        <div class="col">
                <!-- <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('categoria')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-category-alt' ></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Categoría</h4>
                            </div>

                        </div>
                    </div>
                </div> -->
            </div>

            <!-- <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('articulo')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bx-coffee-togo' ></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Artículo</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('factura')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-spreadsheet'></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Movimiento</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('unidad')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bx-unite'></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Unidad de medida</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div> -->


        </div>

        <div class="row mb-4">
            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> ACTIVIDADES - {{$area->nombre}}</h2>
            <hr/>
            <a style= "margin-left: 1%; margin-right: 1%" class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('planificacion.crearPlanificacion') }}" type="button" >
                <i class="lni lni-circle-plus"></i> Crear Actividad
            </a>
            <!-- Redirige a planificacion/crearPoa -->

            <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('planificacion.reformaIndex') }}" type="button" >
                <i class="lni lni-circle-plus"></i> Reformas
            </a>
           
        </div>


        <div id="contModalComentarios">
        </div>


        <div class="card">
            <div class="card-body">
                <div class="">
                    <table id="tblPlanificacionVistaUser" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>POA</th>
                                <th>Objetivo Operativo</th>
                                <th>Actividad Operativa</th>
                                <th>Sub actividad</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th> <center> Estado </center></th>
                                <th> <center> Solicitado </center></th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Departamento</th>
                                <th>POA</th>
                                <th>Objetivo Operativo</th>
                                <th>Actividad Operativa</th>
                                <th>Sub actividad</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th> <center> Estado </center></th>
                                <th> <center> Solicitado </center></th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

    <a id="btnModalReportPOA" data-toggle="modal" data-target="#addReportPOA" class="d-none"></a>

    <div class="modal fade" id="addReportPOA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Actividad</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                            <input type="hidden" id="id_poa" name="id_poa" class="form-control" required="" autofocus="" value="">

                            <h1 class="form-label fs-6">Área requiriente</h1>

                                <div class="col-md-4 mt-1">
                                    <label for="creado" class="form-label fs-6">Usuario que elabora</label>
                                    <!-- Input para ingresar el nombre manualmente -->
                                    <input type="text" id="creado" name="creado" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_creado" class="form-label fs-6 mt-2">Cargo</label>
                                    <!-- Input para ingresar el cargo -->
                                    <input type="text" id="cargo_creado" name="cargo_creado" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                                <div class="col-md-4 mt-1">
                                    <label for="autorizado" class="form-label fs-6">Usuario que revisa</label>
                                    <!-- Input para ingresar el nombre manualmente -->
                                    <input type="text" id="autorizado" name="autorizado" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_autorizado" class="form-label fs-6 mt-2">Cargo</label>
                                    <!-- Input para ingresar el cargo -->
                                    <input type="text" id="cargo_autorizado" name="cargo_autorizado" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                                <div class="col-md-4 mt-1">
                                    <label for="reporta" class="form-label fs-6">Usuario que aprueba</label>
                                    <!-- Input para ingresar el nombre manualmente -->
                                    <input type="text" id="reporta" name="reporta" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_reporta" class="form-label fs-6 mt-2">Cargo</label>
                                    <!-- Input para ingresar el cargo -->
                                    <input type="text" id="cargo_reporta" name="cargo_reporta" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                            <hr class="mt-4">

                            <h1 class="form-label fs-6">Planificación y Gestión estratégica</h1>
                                <div class="col-md-6 mt-1">
                                    <label for="areaReq" class="form-label fs-6">Usuario que valida</label>
                                    <!-- Input para ingresar el nombre manualmente -->
                                    <input type="text" id="areaReq" name="areaReq" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_areaReq" class="form-label fs-6 mt-2">Cargo</label>
                                    <!-- Input para ingresar el cargo -->
                                    <input type="text" id="cargo_areaReq" name="cargo_areaReq" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                                <div class="col-md-6 mt-1">
                                    <label for="planificacionYG" class="form-label fs-6">Usuario que aprueba</label>
                                    <!-- Input para ingresar el nombre manualmente -->
                                    <input type="text" id="planificacionYG" name="planificacionYG" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_planificacionYG" class="form-label fs-6 mt-2">Cargo</label>
                                    <!-- Input para ingresar el cargo -->
                                    <input type="text" id="cargo_planificacionYG" name="cargo_planificacionYG" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                            <!-- <hr class="mt-4"> -->

                            <!-- <h1 class="form-label fs-6">Justificación área requiriente</h1>
                                <div>
                                    <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                                </div> -->

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarReportPOA">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModalPOA" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="apruebaSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Aprovación de solicitud </h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                            <input type="hidden" id="id_solicitud" name="id_solicitud" class="form-control" required="" autofocus="" value="">

                            <h3 class="">Área requiriente</h3>

                            <div class="col-md-12 mt-1 text-start">
                                <strong class="d-block">Área Requirente</strong>
                                <small id="area">  </small>

                                <strong class="d-block mt-1">Fecha</strong>
                                <small id="fecha">  </small>
                            </div>

                            <hr class="mt-4">

                            <h3 class="">Datos de la Actividad</h3>

                            <div class="position-static d-flex flex-column flex-lg-row align-items-stretch justify-content-start p-3 rounded-3">
                                <nav class="col-lg-12">
                                    <ul class="list-unstyled d-flex flex-column gap-2">
                                        <li class="row">
                                            <div class="btn text-start col-lg-9">
                                                <strong class="d-block">Objetivo</strong>
                                                <small id="objetivo">  </small>
                                                <strong class="d-block mt-1">Actividad</strong>
                                                <small id="actividad"></small>
                                                <strong class="d-block mt-1">Sub Actividad</strong>
                                                <small id="subActividad">  </small>
                                            </div>
                                            <div class="btn text-start col-lg-3">
                                                <strong class="d-block">Número de actividad</strong>
                                                <small id="numero">  </small>
                                            </div>
                                        </li>

                                        <table class="table">
                                            <tbody class="table-group-divider">
                                                <tr>
                                                    <th scope="row">Ene</th>
                                                    <th scope="row">Feb</th>
                                                    <th scope="row">Mar</th>
                                                    <th scope="row">May</th>
                                                </tr>
                                                <tr>
                                                    <td id="ene"></td>
                                                    <td id="feb"></td>
                                                    <td id="mar"></td>
                                                    <td id="may"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Abr</th>
                                                    <th scope="row">Jun</th>
                                                    <th scope="row">Jul</th>
                                                    <th scope="row">Ago</th>
                                                </tr>
                                                <tr>
                                                    <td id="abr"></td>
                                                    <td id="jun"></td>
                                                    <td id="jul"></td>
                                                    <td id="ago"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Sep</th>
                                                    <th scope="row">Oct</th>
                                                    <th scope="row">Nov</th>
                                                    <th scope="row">Dic</th>
                                                </tr>
                                                <tr>
                                                    <td id="sep"></td>
                                                    <td id="oct"></td>
                                                    <td id="nov"></td>
                                                    <td id="dic"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </ul>
                                </nav>
                            </div>

                            <hr class="mt-0">

                            <h3 class="">Datos de la Actividad Actualizados</h3>

                            <div class="position-static d-flex flex-column flex-lg-row align-items-stretch justify-content-start p-3 rounded-3">
                                <nav class="col-lg-12">
                                    <ul class="list-unstyled d-flex flex-column gap-2">
                                        <li class="row">
                                            <div class="btn text-start col-lg-9">
                                                <strong class="d-block">Objetivo</strong>
                                                <small id="objetivoS">  </small>
                                                <strong class="d-block mt-1">Actividad</strong>
                                                <small id="actividadS"></small>
                                                <strong class="d-block mt-1">Sub Actividad</strong>
                                                <small id="subActividadS">  </small>
                                            </div>
                                            <div class="btn text-start col-lg-3">
                                                <strong class="d-block">Tipo de Movimiento</strong>
                                                <small id="tipo">  </small>
                                            </div>
                                        </li>

                                        <table class="table">
                                            <tbody class="table-group-divider">
                                                <tr>
                                                    <th scope="row">Ene</th>
                                                    <th scope="row">Feb</th>
                                                    <th scope="row">Mar</th>
                                                    <th scope="row">May</th>
                                                </tr>
                                                <tr>
                                                    <td id="eneS"></td>
                                                    <td id="febS"></td>
                                                    <td id="marS"></td>
                                                    <td id="mayS"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Abr</th>
                                                    <th scope="row">Jun</th>
                                                    <th scope="row">Jul</th>
                                                    <th scope="row">Ago</th>
                                                </tr>
                                                <tr>
                                                    <td id="abrS"></td>
                                                    <td id="junS"></td>
                                                    <td id="julS"></td>
                                                    <td id="agoS"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Sep</th>
                                                    <th scope="row">Oct</th>
                                                    <th scope="row">Nov</th>
                                                    <th scope="row">Dic</th>
                                                </tr>
                                                <tr>
                                                    <td id="sepS"></td>
                                                    <td id="octS"></td>
                                                    <td id="novS"></td>
                                                    <td id="dicS"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </ul>
                                </nav>
                            </div>

                        </div>

                        <div class="col-md-12 mt-2 text-center">
                            <label for="frecuencia" class="form-label fs-6">Quiere prestar la actividad?</label>
                            <select id="estado" name="estado" class="form-select single-select" required="" >
                                <option value="0" selected="">Seleccione el estado de la actividad</option>
                                <option value="aprobado"> Aprobado</option>
                                <option value="rechazado"> Rechazado</option>
                            </select>
                        </div>


                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGuardarSolicitud">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnSolicitud" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    @if(session('success'))
    <script>
        Swal.fire({
            title: 'SoftInspi',
            text: '{{ session('success') }}',
            icon: 'success',
            type: 'success',
            confirmButtonText: 'Aceptar',
            timer: 3500
        });
    </script>
    @endif

@endsection


