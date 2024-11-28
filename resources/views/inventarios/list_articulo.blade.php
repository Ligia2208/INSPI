
@extends('layouts.main')

@section('title', 'Artículos')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Artículos</h5></a>
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

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Artículos </h2>
            <hr/>
            <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#addCategoria" type="button" id="btnModalOpen">
                <i class="lni lni-circle-plus"></i> Crear Artículo
            </a>

            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblIArticuloIndex" class="table table-striped table-bordered p-2">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <!-- <th>Precio</th> -->
                                    <th>Categoría</th>
                                    <th>Unidad</th>
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
 


    <div class="modal fade" id="addCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Artículo</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="col-md-12">
                            <label for="nameArticulo" class="form-label fs-6">Nombre del artículo</label>
                            <input type="text" id="nameArticulo" name="nameArticulo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="categoriaArti" class="form-label">Seleccione la Categoría</label>
                            <select id="categoriaArti" name="categoriaArti" class="form-control select2Core" required>
                                <option value="0">Seleccione Opción</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una opción.
                            </div>
                        </div>


                        <div class="col-md-12 mt-3">
                            <label for="unidadaArticulo" class="form-label fs-6">Seleccione la Unidad de medida</label>
                            <select id="unidadaArticulo" name="unidadaArticulo" class="form-control select2Core" required>
                                <option value="0">Seleccione Opción</option>
                                @foreach($unidades as $unidad)
                                        <option value="{{ $unidad->id}}"> {{ $unidad->abreviatura}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnArticulo">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="contModalUpdateCategoria">
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
        }else if(dato == 'marca'){
            window.location.href = '/inventario/marca';
        }else if(dato == 'bodega'){
            window.location.href = '/inventario/bodega';
        }

    }


</script>


@push('scripts')
<!-- Script personalizado -->
<script src="{{ asset('assets/js/Inventario/articulo.js?v0.0.0') }}"></script>
@endpush

