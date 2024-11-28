
@extends('layouts.main')

@section('title', 'Transferencia Inventario')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Transferencia Inventario</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">

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

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Transferir Insumos </h2>
            
            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos de la Transferencía</h1>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row p-2">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fs-6">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                            <label for="fecha" class="form-label fs-6">Fecha</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" readonly>
                            <div class="valid-feedback">Looks good!</div>
                        </div>


                        <div class="col-md-6 mt-2">
                            <label for="tipo" class="form-label fs-6">Seleccione el Tipo</label>
                            <select id="tipo" name="tipo" class="form-control single-select" required disabled>
                                <option value="0">Seleccione Opción</option>
                                <option value="I" disabled>Ingreso</option>
                                <option value="E" disabled>Egreso</option>
                                <option value="T" selected>Transferencía</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="destino" class="form-label fs-6">Destino</label>                     
                            <select id="destino" name="destino" class="form-control single-select">
                                <option value="0">Seleccione Laboratorio</option>
                                @foreach($laboratorios as $laboratorio)
                                <option value="{{$laboratorio->id}}"> {{$laboratorio->descripcion}} </option>
                                @endforeach
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


            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">
                            <a class="nav-link active fs-5 fw-bolder" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Artículo</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Carga Masiva</a>
                        </li> -->

                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">

                            <table class="table table-striped table-hover">
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
                                <tbody id="cuerpoTablaMovimiento">
                                    <tr id="totalMovimiento">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-primary d-flex align-items-center justify-content-center float-start" type="button" id="btnAddMovimiento" onclick="agregarArticulo()">
                                        <i class="lni lni-circle-plus"></i> Agregar Movimiento
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" id="btnSaveMovimiento" onclick="guardarMovimiento()">
                                        <i class='bx bxs-save'></i> Guardar
                                    </a>
                                </div>
                            </div>

                        </div>


                        <!-- <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">

                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <a href="{{ asset('assets/doc/plantilla_ingreso_inventario.csv') }}" download="plantilla_ingreso_inventario.csv" class="btn btn-primary">
                                    Descargar Plantilla
                                    <i class='bx bx-download'></i>
                                </a>
                            </div>

                            <form id="importForm" enctype="multipart/form-data">
                                @csrf
                                <div class="border p-5 pt-2">
                                    <label class="form-label fs-4 fw-bolder" for="customFile">Ingrese la matriz</label>
                                    <input type="file" class="form-control" name="file" required id="file" />
                                </div>

                                <div class="col-6 mt-2">
                                    <button id="importButton" class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button">
                                        <i class='bx bxs-save'></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div> -->

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

                        <div class="col-md-12 mt-1">
                            <label for="precioArticulo" class="form-label fs-6">Precio del Artículo</label>
                            <input type="text" id="precioArticulo" name="precioArticulo" class="form-control" required autofocus value="">
                            <div class="valid-feedback">¡Se ve bien!</div>
                            <div class="invalid-feedback">Ingrese solo números</div>
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

        if(dato == 'corrida'){
            window.location.href = '/inventario/list_corrida';
        }else if(dato == 'transferencia'){
            window.location.href = '/inventario/transferencia';
        }else if(dato == 'agregarUnidades'){
            window.location.href = '/inventario/agregarUnidades';
        }else if(dato == 'laboratorio'){
            window.location.href = "/inventario/laboratorio";
        }

    }


</script>


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/create_transferencia.js?v0.0.0')}}"></script>
@endpush

