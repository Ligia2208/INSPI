@extends('layouts.main')

@section('title', 'Montos por Direcciones')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Montos por Direcciones</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row">

                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE DIRECCIONES </h2>

                <hr/>

                <a class="col-2 mb-3 btn btn-primary d-flex align-items-center justify-content-center mr-2" type="button" data-toggle= "modal" data-target="#modalItemPres">
                    <i class="lni lni-circle-plus"></i> Crear Dirección
                </a>

            </div>

            <!-- MODAL PARA CREAR ITEM PRESUPUESTARIO -->
            <div class="modal fade" id="modalItemPres" tabindex="-1" role="dialog" aria-labelledby="modalItPresLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalItPresLabel">AGREGAR ITEM PRESUPUESTARIO</h5>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <div class="col-md-12">
                        <label for="nameItem" class="form-label fs-6">Nombre</label>
                        <input type="text" id="nameItem" name="nameItem" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="descripcion" class="form-label fs-6">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required="" autofocus="" rows="4"></textarea>
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="montoItem" class="form-label fs-6">Monto</label>
                        <input type="number" id="montoItem" name="montoItem" class="form-control" required="" autofocus="" value="0">
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Ingrese solo números</div>
                    </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCerrarItemPres" data-dismiss="modal">Cerrar</button>
                        <a class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" id="btnSaveItemPres" onclick="guardarItemPres()">
                            <i class='bx bxs-save'></i> Guardar
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        
            <div id="contModalUpdateItemPres">
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblItemPresupuestarioIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Monto</th>
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


    <div class="modal fade " id="modalRecordItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Visualizar Historial </h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                    
                        <input type="hidden" id="id_itemPres" name="id_itemPres" class="form-control" required="" autofocus="" value="">
                        <div class="col-md-12">
                            <label for="nameItemPU" class="form-label fs-6">Seleccionar fecha</label>
                            <select id="yearSelect" class="form-control js-example-basic-single"></select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btGeneHistorial">Generar Historial</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btGeneHistorialCerrar">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <a id="btnModalAbrir" class="show-tooltip me-1"  data-toggle="modal" data-target="#modalRecords"></a>

    <div class="modal fade " id="modalRecords" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Historial </h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div id="modalContent">

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12 col-lg-12 col-xl-12">

                                <div class="card mb-0" id="chat2">

                                    <div id="contenedorHistorial" class="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px; overflow-y: auto">

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btGeneHistorialCerrar">Cerrar</button>
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

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/ItemPresupuestario/init_monto_dir.js?v0.0.6')}}"></script>
@endpush
