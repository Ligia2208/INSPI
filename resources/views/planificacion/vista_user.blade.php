
@extends('layouts.main')

@section('title', 'Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-cash py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <span>Monto de la dirección</span>
                                    <h4 class="my-1 text-primary ms-auto" id="monto_total">{{$monto}}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-graph-up-arrow py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <span>Total de Actividades Operativas</span>
                                    <h4 class="my-1 text-primary ms-auto" id="total_ocupado">{{$totalOcupado}}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary position-relative">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-patch-check py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <span>Total de Certificaciones POA</span>
                                    <h4 class="my-1 text-primary ms-auto" id="">{{$totalCertificado}}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row mb-4 mt-4">
                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> ACTIVIDADES - {{$area}}</h2>
                <hr/>

                <!-- <a type="button" onclick="ejecutar()"  class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center">
                    Ejecutar
                </a> -->
                @if(!$proestado)
                <a style= "margin-left: 1%; margin-right: 1%" class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('planificacion.crearPlanificacion', ['id_direccion' => $id_direccion]) }}" type="button" >
                    <i class="lni lni-circle-plus"></i> Crear Actividad
                </a>
                @endif

                <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('planificacion.reformaIndex') }}" type="button" >
                    <i class="lni lni-circle-plus"></i> Reformas
                </a>
            
            </div>


            <div id="contModalComentarios">
            </div>


            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-6 mt-2 mb-5">
                            <label for="filterItem" class="form-label">Item:</label>
                            <select id="filterItem" class="js-example-basic-single filter">
                                <option value="">Todos</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2 mb-5">
                            <label for="filterEstado" class="form-label">Filtrar por Estados:</label>
                            <select id="filterEstado" class="form-control js-example-basic-single mt-2">
                                <option value="">Todos los Estados</option>
                                <option value="A">Registrado</option>
                                <option value="O">Aprobado</option>
                                <option value="R">Rechazado</option>
                                <!-- <option value="C">Corregido</option> -->
                                <option value="S">Solicitado</option>
                            </select>
                        </div>
                    </div>


                    <div class="">
                        <table id="tblPlanificacionVistaUser" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>POA</th>
                                    <th>Objetivo Operativo</th>
                                    <th>Actividad Operativa</th>
                                    <th>Sub actividad</th>
                                    <th>Item</th>
                                    <th>Monto</th>
                                    <th>Proceso</th>
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
                                    <th colspan="6" style="text-align:right">Total:</th>
                                    <th></th> <!-- Aquí se mostrará el total -->
                                    <th colspan="5"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Generar Solicitud de Certificción POA</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                            <input type="hidden" id="id_poa" name="id_poa" required="" autofocus="" value="">

                            <h1 class="form-label fs-6 col-lg-12">Área requiriente</h1>

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
                            <h1 class="form-label fs-6 col-lg-12 mt-5">Planificación y Gestión estratégica</h1>

                            <div class="col-md-6 mt-1">
                                <label for="areaReq" class="form-label fs-6">Usuario que valida</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="areaReq" name="areaReq" class="form-control" value="LCDA. ERICKA BEATRIZ CEVALLOS MEJIA " placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_areaReq" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_areaReq" name="cargo_areaReq" class="form-control" value="ANALISTA DE PLANIFICACION Y GESTION ESTRATEGICA" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-6 mt-1">
                                <label for="planificacionYG" class="form-label fs-6">Usuario que aprueba</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="planificacionYG" name="planificacionYG" class="form-control" value="ING. LADY CONCEPCION ROJAS TORRES" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_planificacionYG" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_planificacionYG" name="cargo_planificacionYG" class="form-control" value="DIRECTORA DE PLANIFICACION Y GESTION ESTRATEGICA" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarReportPOA"><i class="bi bi-file-earmark-arrow-down"></i>Descargar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModalPOA" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <!--- para los Zonales -->
    <a id="btnModalReportPOAZonal" data-toggle="modal" data-target="#addReportPOAZonal" class="d-none"></a>

    <div class="modal fade" id="addReportPOAZonal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Solicitud de Certificción POA</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                            <input type="hidden" id="id_poa2" name="id_poa2" required="" autofocus="" value="">

                            <h1 class="form-label fs-6 col-lg-12">Área requiriente</h1>

                            <div class="col-md-4 mt-1">
                                <label for="creado" class="form-label fs-6">Usuario que elabora</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="creado2" name="creado2" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_creado" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_creado2" name="cargo_creado2" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="autorizado" class="form-label fs-6">Usuario que revisa</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="autorizado2" name="autorizado2" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_autorizado" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_autorizado2" name="cargo_autorizado2" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="reporta" class="form-label fs-6">Usuario que aprueba</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="reporta2" name="reporta2" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_reporta" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_reporta2" name="cargo_reporta2" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <hr class="mt-4">
                            <h1 class="form-label fs-6 col-lg-12 mt-5">Planificación y Gestión estratégica</h1>

                            <div class="col-md-6 mt-1">
                                <label for="areaReq" class="form-label fs-6">Usuario que valida</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="areaReq2" name="areaReq2" class="form-control" value="ING. JONATHAN TRUJILLO CERÓN" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_areaReq" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_areaReq2" name="cargo_areaReq2" class="form-control" value="PLANIFICADOR INSTITUCIONAL" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-6 mt-1">
                                <label for="planificacionYG" class="form-label fs-6">Usuario que aprueba</label>
                                <!-- Input para ingresar el nombre manualmente -->
                                <input type="text" id="planificacionYG2" name="planificacionYG2" class="form-control" value="TLGA. TANYA PORTUGUÉZ PILCO" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_planificacionYG" class="form-label fs-6 mt-2">Cargo</label>
                                <!-- Input para ingresar el cargo -->
                                <input type="text" id="cargo_planificacionYG2" name="cargo_planificacionYG2" class="form-control" value="ANALISTA ZONAL ADMINISTRATIVA FINANCIERA" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarReportPOA2"><i class="bi bi-file-earmark-arrow-down"></i>Descargar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModalPOA" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--- para los Zonales -->




    <div class="modal fade" id="apruebaSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Aprobación de solicitud </h5>
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

                            <table id="tblSolicitud" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Departamento Solicitante</th>
                                        <th>Sub actividad</th>
                                        <th>Item</th>
                                        <th>Tipo</th>
                                        <th>Disponible</th>
                                        <th>Disminuye</th>
                                        <th>Aumenta</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                    
                        </div>

                        <div class="col-md-12 mt-2 text-center">
                            <label for="frecuencia" class="form-label fs-6">Quiere autorizar la actividad?</label>
                            <select id="estado" name="estado" class="form-control js-example-basic-single" required="" >
                                <option value="0" selected="">Seleccione el estado</option>
                                <option value="aprobado"> SI </option>
                                <option value="rechazado"> NO </option>
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

@endsection

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/vistaUser_poa.js?v0.0.29')}}"></script>
@endpush
