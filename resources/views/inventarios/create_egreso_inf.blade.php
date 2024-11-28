

@extends('layouts.main')

@section('title', 'Egreso Inventario')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Egreso Inventario</h5></a>
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

            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-clipboard2-pulse"></i> Registrar Corrida Influenza </h2>
            
            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos de la Corrida</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="{{ $labora->id }}">
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row p-2">

                        <input type="hidden" id="id_usuario" value="{{$id_usuario}}">

                        <div class="col-md-4">
                            <label for="tecnica" class="form-label fs-6">Técnica</label>
                            <input type="text" id="tecnica" name="tecnica" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4">
                            <label for="fechaCorrida" class="form-label fs-6">Fecha</label>
                            <input type="date" id="fechaCorrida" name="fechaCorrida" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" >
                            <div class="valid-feedback">Looks good!</div>
                        </div>


                        <div class="col-md-4">
                            <label for="tipo" class="form-label fs-6">Seleccione el Tipo</label>
                            <select id="tipo" name="tipo" class="form-control single-select" required disabled>
                                <option value="0">Seleccione Opción</option>
                                <option value="I"> Ingreso </option>
                                <option value="E" selected> Corrida </option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="protocolo" class="form-label fs-6">Protocolo</label>
                            <input type="text" id="protocolo" name="protocolo" class="form-control" required="" autofocus="" value="CDC(adaptación de laboratorio NIC)">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="observacion" class="form-label fs-6">Observación</label>
                            <textarea id="observacion" name="observacion" class="form-control" required="" autofocus="" rows="4"></textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>
            </div>


            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder active" id="list-standar-list" data-bs-toggle="list" href="#list-standar" role="tab" aria-controls="list-standar">Inmunofluorescencia</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder" id="list-arn-list" data-bs-toggle="list" href="#list-arn" role="tab" aria-controls="list-arn">Extracción</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Mezcla</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder" id="list-pcr-list" data-bs-toggle="list" href="#list-pcr" role="tab" aria-controls="list-pcr">RT-PCR</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link fs-5 fw-bolder" id="list-termico-list" data-bs-toggle="list" href="#list-termico" role="tab" aria-controls="list-termico">Consumibles</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="nav-tabContent">

                        <!-- EXTRACION DE ARN -->
                        <div class="tab-pane fade " id="list-arn" role="tabpanel" aria-labelledby="list-arn-list">


                            <h2> Extracción de Accidos Núcleicos </h2>

                            <div class="row">

                                <div class="row m-0 col-lg-12" id="cuerpoARN">
                                </div>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-start">
                                    <button id="importButton" class="btn btn-success" type="button" onclick="agregarARN()">
                                        <i class="bi bi-file-plus"></i> Agregar
                                    </button>
                                </div>

                            </div>

                        </div> 
                        <!-- EXTRACION DE ARN -->



                        <!-- MEZCLA DE REACCIONES -->
                        <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">

                            <h2 class="mb-4 text-primary" > Mezcla de reacciones </h2>

                            <div class="row">

                                <div class="row m-0 col-lg-12" id="cuerpoPCR">

                                </div>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-start">
                                    <button id="importButton" class="btn btn-success" type="button" onclick="agregarArticulo()">
                                        <i class="bi bi-file-plus"></i> Agregar
                                    </button>
                                </div>

                            </div>

                        </div>
                        <!-- MEZCLA DE REACCIONES -->


                        <!-- INMUNOFLUORESCENCIA -->
                        <div class="tab-pane fade active show" id="list-standar" role="tabpanel" aria-labelledby="list-standar-list">

                            <h2> Pruebas Inmunofluorescencia </h2>

                            <div class="row">

                                <div class="row m-0 col-lg-12" id="cuerpoMono">
                                </div>

                                <div class="row m-0 col-lg-12" id="cuerpoPoli">
                                </div>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-center">

                                    <button id="" class="btn btn-success float-end me-5" type="button" onclick="agregarMono()">
                                        <i class="bi bi-file-plus"></i> Agregar Mono
                                    </button>

                                    <button id="" class="btn btn-success float-end" type="button" onclick="agregarPoliclonal()">
                                        <i class="bi bi-file-plus"></i> Agregar Poli
                                    </button>

                                </div>

                            </div>

                        </div>           
                        <!-- INMUNOFLUORESCENCIA -->


                        <!-- RT-PCR -->
                        <div class="tab-pane fade" id="list-pcr" role="tabpanel" aria-labelledby="list-pcr-list">

                            <h2> RT-PCR </h2>

                            <div class="row">

                                <div class="row m-0 col-lg-12" id="cuerpoInfluA">
                                </div>

                                <div class="row m-0 col-lg-12" id="cuerpoInfluB">
                                </div>

                                <div class="row m-0 col-lg-12" id="cuerpoCOVID">
                                </div>

                                <div class="row m-0 col-lg-12" id="cuerpoSincitial">
                                </div>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-center">

                                    <button id="" class="btn btn-success me-2" type="button" onclick="agregarInfluenzaA()">
                                        <i class="bi bi-file-plus"></i> Agregar Influenza A
                                    </button>

                                    <button id="" class="btn btn-success me-2" type="button" onclick="agregarInfluenzaB()">
                                        <i class="bi bi-file-plus"></i> Agregar Influenza B
                                    </button>

                                    <button id="" class="btn btn-success me-2" type="button" onclick="agregarCovid()">
                                        <i class="bi bi-file-plus"></i> Agregar COVID
                                    </button>

                                    <button id="" class="btn btn-success me-2" type="button" onclick="agregarSincitial()">
                                        <i class="bi bi-file-plus"></i> Agregar Sincitial respiratorio
                                    </button>

                                </div>

                            </div>

                        </div>           
                        <!-- RT-PCR -->


                        <!-- CONSUMIBLES -->
                        <div class="tab-pane fade" id="list-termico" role="tabpanel" aria-labelledby="list-termico-list">

                            <h2> Consumibles </h2>

                            <div class="row">

                                <div class="row m-0 col-lg-12" id="cuerpoConsumibles">
                                </div>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-center">
                                    <button id="importButton" class="btn btn-success float-end" type="button" onclick="agregarConsumible()">
                                        <i class="bi bi-file-plus"></i> Agregar
                                    </button>
                                </div>

                            </div>

                        </div> 
                        <!-- CONSUMIBLES -->

                    </div>

                    <hr>

                    <div class="col-12 mt-2 d-flex align-items-center justify-content-center">

                        <a class="btn btn-secondary" type="button" id="btnSaveMovimiento" onclick="guardarMovimiento()">
                            <i class='bx bxs-save'></i> Guardar
                        </a>

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
            //window.location.href = '/inventario/crearEgreso';
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
<script src="{{asset('assets/js/Inventario/create_egreso_inf.js?v0.0.3')}}"></script>
@endpush