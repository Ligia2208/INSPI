@extends('layouts.main')

@section('title', 'Ajustes')
<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Ajustes</h5></a>
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

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative mt-2" onclick="redireccionEncuesta('ajuste')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class='bi bi-arrow-repeat py-3 px-2 titulo-grande'></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Ajuste de Inventario</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class="font-32 text-success bi bi-chevron-bar-contract"></i> Ajustes </h2>
            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblIActaIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nº Ajuste</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Origen</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nº Ajuste</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Origen</th>
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


    <!-- MODAL PARA TRANSFERIR -->
    <div class="modal fade" id="modalTransferir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Transferir Ingreso </h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
       
                        <input type="hidden" id="id_acta" name="id_acta" value="">

                        <div class="container">
 
                            <div class="row">
                                <div class="col-xs-2">
                                    <div class="titulo"> <strong>Nro.: </strong> <span id="numero"> </span> </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="titulo"> <strong>RUC: </strong> <span id="ruc"> </span> </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="titulo"> <strong>Proveedor: </strong> <span id="proveedor"> </span> </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="titulo"> <strong>Fecha: </strong> <span id="fecha"> </span> </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="titulo"> <strong>Doc Respaldo: </strong> <span id="factura"> </span> </div>
                                </div>

                            </div>      
                            
                            <table class="table table-bordered mt-4" id="tablaTransferir">
                                <thead>
                                    <tr>
                                        <th><h5 class="titulo">Unidad</h5></th>
                                        <th><h5 class="titulo">Artículo</h5></th>
                                        <th><h5 class="titulo">Presentación</h5></th>
                                        <th><h5 class="titulo">Lote</h5></th>
                                        <th><h5 class="titulo">Costo Unitario</h5></th>
                                        <th><h5 class="titulo">Costo Total</h5></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="codigo"></td>
                                        <td class="descripcion"></td>
                                        <td class="cantidad izq"></td>
                                        <td class="precio izq"></td>
                                        <td class="descuento izq"></td>
                                        <td class="subtotal izq"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-xs-8 titulopie">
                                    <span id="descripcion"> </span>
                                </div>
                            </div>

                            <hr class="mt-4">

                            <div class="col-md-4 col-sm-4 col-4 mt-2">
                                <label for="destino" class="form-label fs-6">Destino</label>
                                <select class="js-example-basic-single form-select single-select" name="destino" id="destino"
                                        data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                                    <option value="0">Seleccione Laboratorio</option>
                                    @foreach($laboratorios as $laboratorio)
                                    <option value="{{$laboratorio->id}}"> {{$laboratorio->nombre}} </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnTranferirInventario">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA TRANSFERIR -->


    <!-- MODAL PARA VALIDAR AJUSTE -->
    <div class="modal fade" id="validaAjuste" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Validar Ajuste </h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                            <input type="hidden" id="id_acta_ajuste" name="id_acta_ajuste" value="">

                            <div class="col-md-4 mt-1">
                                <label for="selectAprobar" class="form-label fs-6">Aprueba el Ajuste</label>
                                <select id="selectAprobar" name="selectAprobar" class="form-control" required>
                                    <option value="0">Seleccione Opción</option>
                                    <option value="SI"> SI </option>
                                    <option value="NO"> NO </option>

                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSaveValidar">Validar</button>
                    <button type="button" class="btn btn-secondary" id="btnSaveValida" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA VALIDAR AJUSTE -->



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
        }else if(dato == 'ajuste'){
            window.location.href = '/inventario/list_ajuste';
        }

    }


</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/list_ajuste.js?v0.0.0')}}"></script>
@endpush