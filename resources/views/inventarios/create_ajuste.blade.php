@extends('layouts.main')

@section('title', 'Ajuste de Inventario')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Ajuste de Inventario</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">

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

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Registrar ajuste en el Inventario </h2>
            
            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos del Movimiento</h1>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row p-2">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fs-6">RUC</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required="" autofocus="" value="" oninput="getName(this)">
                            <div class="valid-feedback">¡El RUC es correcto!</div>
                            <div class="invalid-feedback">El RUC no es válido</div>
                        </div>

                        <div class="col-md-3">
                            <label for="fecha" class="form-label fs-6">Fecha</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" readonly>
                            <div class="valid-feedback">Looks good!</div>
                        </div>


                        <div class="col-md-3">
                            <label for="tipo" class="form-label fs-6">Seleccione el Tipo</label>
                            <select id="tipo" name="tipo" class="form-control single-select" onchange="selectTipo()" disabled>
                                <option value="0">Seleccione Opción</option>
                                <option value="I"> Donación </option>
                                <option value="C"> Compra Local </option>
                                <option value="E"> Egreso </option>
                                <option value="T"> Traspaso </option>
                                <option value="A" selected> Ajuste </option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-4 mt-2">
                            <label for="destino" class="form-label fs-6">Destino</label>
                            <select class="js-example-basic-single form-control" name="destino" id="destino"
                                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true" onchange="selectLaboratorio()">
                                <option value="0">Seleccione Laboratorio</option>
                                @foreach($laboratorios as $laboratorio)
                                <option value="{{$laboratorio->id}}"> {{$laboratorio->descripcion}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="transaccion" class="form-label fs-6">Seleccione el Tipo</label>
                            <select id="transaccion" name="transaccion" class="form-control js-example-basic-single">
                                <option value="0">Seleccione Opción</option>
                                <option value="positivo"> Ajuste de Ingreso </option>
                                <option value="negativo"> Ajuste de Egreso </option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="descripcion" class="form-label fs-6">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" required="" autofocus="" rows="7" ></textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>
            </div>


            <div class="card text-center" id="cuerpoEgreso">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">
                            <a class="nav-link active fs-5 fw-bolder" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Artículo</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">

                            <table class="table table-striped table-hover" id="table_ajuste">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col" class="unidades">Totales</th>
                                        <th scope="col">Artículo</th>
                                        <th scope="col" class="cantidad">Cantidad(unidades)</th>
                                        <th scope="col">Lote</th>
                                        <th scope="col">U trans.</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaEgreso">
    
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-primary d-flex align-items-center justify-content-center float-start" type="button" id="btnAddMovimiento" onclick="agregarArticuloEgre()">
                                        <i class="lni lni-circle-plus"></i> Agregar Movimiento
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" id="btnSaveMovimiento" onclick="guardarEgreso()">
                                        <i class='bx bxs-save'></i> Guardar
                                    </a>
                                </div>
                            </div>

                        </div>

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


    <div class="modal fade" id="addArticuloM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Artículo</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <div class="col-md-12">
                            <label for="nameArticulo" class="form-label fs-6">Nombre del artículo</label>
                            <input type="text" id="nameArticulo" name="nameArticulo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="categoriaArti" class="form-label fs-6">Seleccione la Categoría</label>
                            <select id="categoriaArti" name="categoriaArti" class="form-select single-select" required>
                                <option value="0">Seleccione Opción</option>
                                @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id}}"> {{ $categoria->nombre}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="unidadaArticulo" class="form-label fs-6">Seleccione la Unidad de medida</label>
                            <select id="unidadaArticulo" name="unidadaArticulo" class="form-select single-select" required>
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
                    <button type="button" class="btn btn-primary" id="btnArticuloM">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCategoriaM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Categoría</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <div class="col-md-12">
                            <label for="nameCategoriaM" class="form-label fs-6">Nombre de la categoría</label>
                            <input type="text" id="nameCategoriaM" name="nameCategoriaM" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnCategoriaM">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModalCate" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMarcaM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Marca</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalContent">
                        <div class="col-md-12">
                            <label for="nameMarcaM" class="form-label fs-6">Nombre de la Marca</label>
                            <input type="text" id="nameMarcaM" name="nameMarcaM" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnMarcaM">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModalMarca" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="contModalUpdateCategoria">
    </div>



@endsection

<!-- <script src="{{asset('assets/plugins/select2/js/select2.min.js') }}"></script> -->


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
        }

    }


</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/create_ajuste.js?v0.0.0')}}"></script>
@endpush