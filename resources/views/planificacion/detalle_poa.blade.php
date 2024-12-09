
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Planificacion/init_poa.js?v0.0.0')}}"></script>
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
            </div>

            <div class="col">
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

        <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> DETALLE DE PAPP </h2>
        <!-- <hr/>
        <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('inventario.crearMovimiento') }}" type="button" >
            <i class="lni lni-circle-plus"></i> Crear Movimiento
        </a> -->

        <div class="row mt-4">
            <div class="col-md-2">
                <label for="nameItemPU" class="form-label fs-6">Seleccionar fecha</label>
                <select id="yearSelect" class="form-select js-example-basic-single" onchange="actualizarTabla()"></select>
            </div>
            <div class="col-md-2">
                <label class="form-label fs-6">&nbsp;</label>
                <button id="btnGeneratePDF" class="btn btn-primary form-control">Generar PDF</button>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <h2 class="text-success"> <i class="bi bi-layer-forward"></i> Total Items: </h2> <h1 class="ms-2">{{$sumaMontos}}</h1>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <h2 class="text-danger"> <i class="bi bi-layer-backward"></i> Total Planificación: </h2> <h1 class="ms-2"> {{$sumaActividades}} </h1>
            </div>
        </div>


        <hr/>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tblPlanificacionDetalle" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Area</th>
                                <th>Tipo de POA</th>
                                <th>Obj. Operativo</th>
                                <th>Act. Operativa</th>
                                <th>Sub Actividad</th>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sept</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sept</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a id="btnModalReportPOA" data-toggle="modal" data-target="#addReportDetalle" class="d-none"></a>

    <div class="modal fade" id="addReportDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Actividad</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <div class="row">
                            <input type="hidden" id="id_poa" name="id_poa" class="form-control" required="" autofocus="" value="">

                            <div class="col-md-4 mt-1">
                                <label for="creado" class="form-label fs-6">Usuario que elabora</label>
                                <input type="text" id="elabora" name="elabora" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_creado" class="form-label fs-6 mt-2">Cargo</label>
                                <input type="text" id="cargo_elabora" name="cargo_elabora" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="autorizado" class="form-label fs-6">Usuario que revisa</label>
                                <input type="text" id="revisa" name="revisa" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_autorizado" class="form-label fs-6 mt-2">Cargo</label>
                                <input type="text" id="cargo_revisa" name="cargo_revisa" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="reporta" class="form-label fs-6">Usuario que aprueba</label>
                                <input type="text" id="aprueba" name="aprueba" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                <label for="cargo_reporta" class="form-label fs-6 mt-2">Cargo</label>
                                <input type="text" id="cargo_aprueba" name="cargo_aprueba" class="form-control" placeholder="Ingrese el cargo" required>
                                <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                            </div>
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

</div>



    <div class="modal fade " id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tipos de encuestas</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                <div id="modalContent">
                <!-- Aquí se mostrarán los datos -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>



@endsection

<script>

    function redireccionEncuesta(dato){

        if(dato == 'categoria'){
            window.location.href = '/inventario/categoria';
        }else if(dato == 'articulo'){
            window.location.href = '/inventario/articulo';
        }else if(dato == 'factura'){
            window.location.href = '/inventario/movimiento';
        }else if(dato == 'unidad'){
            window.location.href = '/inventario/unidad';
        }

    }

</script>
