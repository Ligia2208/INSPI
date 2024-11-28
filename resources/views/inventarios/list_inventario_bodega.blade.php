
@extends('layouts.main')

@section('title', 'Inventario Bodega')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Inventario Bodega</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('bodega')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-plus-slash-minus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Inventario</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('categoria')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class='bi bi-app-indicator py-3 px-2 titulo-grande' ></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Categoría</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('articulo')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class='bi bi-box-seam py-3 px-2 titulo-grande' ></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Artículo</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('factura')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class='bi bi-bar-chart-steps py-3 px-2 titulo-grande'></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Movimiento</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative mt-2" onclick="redireccionEncuesta('unidad')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class='bi bi-speedometer2 py-3 px-2 titulo-grande'></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Unidad de medida</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Inventario Bodega </h2>

            <hr/>

            <div class="row">

                <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#addReportInventario" type="button" id="btnModalOpen">
                    <i class="bi bi-file-earmark-ruled"></i> Generar Reporte Kardex General
                </a>

                <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center ml-2" data-toggle="modal" data-target="#addReportStock" type="button" id="">
                    <i class="bi bi-file-earmark-ruled"></i> Generar Reporte Stock
                </a>

            </div>

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
                <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Stock </h5>
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


<!-- REPORTE DE INVENTARIO -->
<div class="modal fade" id="addReportInventario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Reporte de inventario Kardex General </h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <div class="row">

                        <input type="hidden" id="id_laboratorioR" name="id_laboratorioR" class="form-control" required="" autofocus="" value="{{$id_labora}}">

                        <div class="col-md-6">
                            <label for="fCategoria" class="form-label fs-6">Filtrar por Categoría</label>
                            <select id="fCategoria" name="fCategoria" class="form-control js-example-basic-single" multiple required>
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


<!-- REPORTE DE INVENTARIO - STOCK -->
<div class="modal fade" id="addReportStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Reporte de inventario Stock Actual </h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <div class="row">

                        <input type="hidden" id="id_laboratorioR" name="id_laboratorioR" class="form-control" required="" autofocus="" value="{{$id_labora}}">

                        <div class="col-md-6">
                            <label for="rFiltro" class="form-label fs-6">Filtrar por ...</label>
                            <select id="rFiltro" name="rFiltro" class="form-select single-select js-example-basic-single" required>
                                <option value="todos" selected> Todos los productos </option>
                                <option value="sin"> Sin stock disponible </option>
                                <option value="dispo"> Stock disponible </option>
                            </select>
                        </div>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGenerarReportStock">Generar</button>
                <button type="button" class="btn btn-secondary" id="btnCerrarModalInvent" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- REPORTE DE INVENTARIO - STOCK -->




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
        }else if(dato == 'marca'){
            window.location.href = '/inventario/marca';
        }else if(dato == 'bodega'){
            window.location.href = '/inventario/bodega';
        }

    }

</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/list_inventario_bodega.js?v0.0.0')}}"></script>
@endpush