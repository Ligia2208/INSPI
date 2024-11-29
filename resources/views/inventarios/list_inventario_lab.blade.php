
@extends('layouts.main')

@section('title', 'Inventario CRN')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Inventario CRN</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-4">

        @if(!$permiso)
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Importante!</h4>
                <p>Usted no pertenece a ningún laboratorio. Por favor, contáctese con los encargados.</p>
                <hr>
                <p class="mb-0">INSPI</p>
            </div>
        @else


            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('laboratorio')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-inboxes py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Inventario</h4>
                                </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('corrida')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-card-checklist py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">List Corrida</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('transferencia')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-folder-symlink py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Transferencía</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('agregarUnidades')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-plus-slash-minus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Unidades</h4>
                                    <span class="position-absolute top-0 right-0 translate-middle badge rounded-pill menu-label">
                                        <span class="label label-danger">{{$cantKits}}+</span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end mt-2">
                <p class="d-inline-flex gap-1">
                    <button type="button" class="btn btn-info btn-sm text-light" data-bs-toggle="collapse" href="#infoSemaforo" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                        <i class="bi bi-info-circle parpadeo_info_semaforo me-0"></i>
                    </button>
                </p>
            </div>

            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="infoSemaforo">
                        <div class="card card-body">
                            <h3>INDICADORES DE STOCKS</h3>
                            <span> Identifica y determina en el
                                momento oportuno que reactivo/fungible están próximos a vencer.</span>
                            <hr />
                            <div class="row">
                                <div class="col-lg-6">
                                    <strong>Fechas de Caducidad:</strong><br>
                                    <span><i class="bi bi-circle-fill text-danger"></i> El color rojo indica que dentro de un mes finaliza su tiempo de vida útil</span><br>
                                    <span><i class="bi bi-circle-fill text-warning"></i> El color amarillo indica que tiene hasta 3 meses de vida útil</span><br>
                                    <span><i class="bi bi-circle-fill text-success"></i> El color verde indica que esta dentro de su vida útil</span>
                                </div>
                                <div class="col-lg-6">
                                    <strong>Indicadores de Stock:</strong><br>
                                    <span><i class="bi bi-circle-fill text-danger"></i> El color rojo indica que el stock ha alcanzado o está por debajo del nivel mínimo requerido.</span><br>
                                    <span><i class="bi bi-circle-fill text-warning"></i> El color amarillo indica que el stock actual es el doble del nivel mínimo establecido.</span><br>
                                    <span><i class="bi bi-circle-fill text-success"></i> El color verde indica que el stock es adecuado, superando al menos el triple del nivel mínimo.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-table'></i> Artículos </h2>

            <div class="col-md-12 mt-1">
                <label for="id_labora" class="form-label fs-6">Seleccione el laboratorio</label>
                <select id="id_labora" name="id_labora" class="form-control js-example-basic-single" required onchange="actualizarTabla()">
                    <option value="0">Seleccione Opción</option>
                    @foreach($laboratorios as $laboratorio)
                        @if($laboratorio->id == $id_labora)
                            <option value="{{ $laboratorio->id }}" selected>{{ $laboratorio->descripcion }}</option>
                        @else
                            <option value="{{ $laboratorio->id }}">{{ $laboratorio->descripcion }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
            </div>

            <hr/>
            <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#addReportInventario" type="button" id="btnModalOpen">
                <i class="bi bi-file-earmark-ruled"></i> Generar Reporte Inventario
            </a>

            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblIArticuloIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <!-- <th>Precio</th> -->
                                    <th>Categoría</th>
                                    <th>Unidad</th>
                                    <th>Stock</th>
                                    <th>Cant. Mímima</th>
                                    <th>F. Caduca</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <!-- <th>Precio</th> -->
                                    <th>Categoría</th>
                                    <th>Unidad</th>
                                    <th>Stock</th>
                                    <th>Cant. Mímima</th>
                                    <th>F. Caduca</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


            <form id="filterForm">
                <div class="card card-body mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Filtrar por:</h3>
                        <a type="buttom" class="btn btn-primary" id="generarReporte"> <i class="bi bi-file-earmark-pdf"></i> Generar Reporte </a>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Caducidad</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caducar" value="todos" checked> Todos
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caducar" value="por_caducar"> Por caducar
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="caducar" value="caducados"> Caducados
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4>Stock</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="stock" value="todos" checked> Todos
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="stock" value="minimo"> Por Stock mínimo
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="stock" value="cercano"> Cercanos al stock mínimo
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>

            <div class="card card-body">
                <table id="resultsTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Lote</th>
                            <th>Categoría</th>
                            <th>Unidad</th>
                            <th>Stock</th>
                            <th>Fecha Caducidad</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>




        @endif()
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


<a id="btnModalReport" data-toggle="modal" data-target="#addReportArticulo" class="d-none"></a>

<div class="modal fade" id="addReportArticulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Registro de Control de Reactivos y Fungibles</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                <div id="modalContent">
                    <!-- Aquí se mostrarán los datos -->
                    <div class="row">

                        <input type="hidden" id="id_articulo" name="id_articulo" class="form-control" required="" autofocus="" value="">
                        <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="{{$id_labora}}">

                        <div class="col-md-4">
                            <label for="tecnica" class="form-label fs-6">Fecha Inicio</label>
                            <input type="date" id="fInicioMono" name="fInicioMono" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                            <label for="tecnica" class="form-label fs-6">Fecha Fin</label>
                            <input type="date" id="fFinMono" name="fFinMono" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGenerarReportReactivo">Generar</button>
                <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<a id="btnModalReportkARDEX" data-toggle="modal" data-target="#addReportKardexReactivos" class="d-none"></a>

<div class="modal fade" id="addReportKardexReactivos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Registro de Control de Reactivos y Fungibles</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                <div id="modalContent">
                    <!-- Aquí se mostrarán los datos -->
                    <div class="row">

                        <input type="hidden" id="id_articuloKardex" name="id_articuloKardex" class="form-control" required="" autofocus="" value="">
                        <input type="hidden" id="id_laboratorioKardex" name="id_laboratorioKardex" class="form-control" required="" autofocus="" value="{{$id_labora}}">

                        <div class="col-md-4">
                            <label for="fInicioKardex" class="form-label fs-6">Fecha Inicio</label>
                            <input type="date" id="fInicioKardex" name="fInicioKardex" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                            <label for="fFinKardex" class="form-label fs-6">Fecha Fin</label>
                            <input type="date" id="fFinKardex" name="fFinKardex" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGenerarReportReactivoKardex">Generar</button>
                <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<!-- REPORTE DE INVENTARIO -->
<div class="modal fade" id="addReportInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Reporte de inventario de Reactivos y Fungibles </h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <div class="row">

                        <input type="hidden" id="id_laboratorioR" name="id_laboratorioR" class="form-control" required="" autofocus="" value="{{$id_labora}}">

                        <div class="col-md-6">
                            <label for="fLaboratorio" class="form-label fs-6">Filtrar por Bodega</label>
                            <select id="fLaboratorio" name="fLaboratorio[]" class="form-select single-select js-example-basic-single" multiple required>
                                @foreach($laboratorios as $laboratorio)
                                        <option value="{{ $laboratorio->id}}"> {{ $laboratorio->descripcion}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="fCategoria" class="form-label fs-6">Filtrar por Categoría</label>
                            <select id="fCategoria" name="fCategoria" class="form-select single-select js-example-basic-single" multiple required>
                                @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id}}"> {{ $categoria->nombre}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>

                        </div>

                        <div class="col-md-4">
                            <label for="fInicioR" class="form-label fs-6">Fecha Inicio</label>
                            <input type="date" id="fInicioR" name="fInicioR" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                            <label for="fFinR" class="form-label fs-6">Fecha Fin</label>
                            <input type="date" id="fFinR" name="fFinR" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGenerarReportInvent">Generar</button>
                <button type="button" class="btn btn-secondary" id="btnCerrarModalInvent" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- REPORTE DE INVENTARIO -->



@endsection

<script>

    function redireccionEncuesta(dato){

        if(dato == 'corrida'){
            //window.location.href = '/inventario/crearEgreso';
            window.location.href = '/inventario/list_corrida';
        }else if(dato == 'transferencia'){
            window.location.href = '/inventario/transferencia';
        }else if(dato == 'agregarUnidades'){
            window.location.href = '/inventario/agregarUnidades';
        }else if(dato == 'laboratorio'){
            window.location.href = "/inventario/laboratorio";
        }else if(dato == 'marca'){
            window.location.href = '/inventario/marca';
        }

    }


</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/list_inventario_lab.js?v0.0.0')}}"></script>
@endpush