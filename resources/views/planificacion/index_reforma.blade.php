
@extends('layouts.main')

@section('title', 'Reforma')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Reforma</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE REFORMAS</h2>
            <hr/>
            <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('planificacion.crearReforma') }}" type="button" >
                <i class="lni lni-circle-plus"></i> Crear Reforma
            </a>
            <hr/>

            <div id="contModalComentarios">
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblReformaIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nro de solicitud</th>
                                    <th>Solicitante</th>
                                    <th>Justificacion</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nro de solicitud</th>
                                    <th>Solicitante</th>
                                    <th>Justificacion</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <a id="btnModalReportReforma" data-toggle="modal" data-target="#addReportReforma" class="d-none"></a>

        <div class="modal fade" id="addReportReforma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reporte de Reforma</h5>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                        <div id="modalContent">
                            <!-- Aquí se mostrarán los datos -->
                            <div class="row">

                                <input type="hidden" id="id_reforma" name="id_reforma" class="form-control" required="" autofocus="" value="">

                                    <div class="col-lg-12 mb-2">
                                        <h1 class="form-label fs-6">Área requiriente</h1>
                                    </div>

                                    <div class="col-md-4 mt-2">
                                        <label for="creado" class="form-label fs-6">Usuario que solicita</label>
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

                                    <div class="col-lg-12 mb-2 mt-5">
                                        <h1 class="form-label fs-6">Planificación y Gestión estratégica</h1>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="areaReq" class="form-label fs-6">Usuario que registra</label>
                                        <!-- Input para ingresar el nombre manualmente -->
                                        <input type="text" id="areaReq" name="areaReq" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                        <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                        <label for="cargo_areaReq" class="form-label fs-6 mt-2">Cargo</label>
                                        <!-- Input para ingresar el cargo -->
                                        <input type="text" id="cargo_areaReq" name="cargo_areaReq" class="form-control" placeholder="Ingrese el cargo" required>
                                        <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label for="planificacionYG" class="form-label fs-6">Usuario que valida</label>
                                        <!-- Input para ingresar el nombre manualmente -->
                                        <input type="text" id="planificacionYG" name="planificacionYG" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                        <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                        <label for="cargo_planificacionYG" class="form-label fs-6 mt-2">Cargo</label>
                                        <!-- Input para ingresar el cargo -->
                                        <input type="text" id="cargo_planificacionYG" name="cargo_planificacionYG" class="form-control" placeholder="Ingrese el cargo" required>
                                        <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                    </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGenerarReportReforma">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCerrarModalReforma" data-dismiss="modal">Cerrar</button>
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

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/reforma.js?v0.0.8')}}"></script>
@endpush
