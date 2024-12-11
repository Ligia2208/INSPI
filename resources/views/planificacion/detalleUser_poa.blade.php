@extends('layouts.main')

@section('title', 'Detalle Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Detalle Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

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

                <div class="col-md-5 d-flex align-items-center justify-content-center">
                    <h2 class="text-danger"> <i class="bi bi-layer-backward"></i> Total Planificación: </h2> <h1 class="ms-2"> {{$sumaActividades}} </h1>
                </div>
            </div>


            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblPlanificacionDetalleUser" class="table table-striped table-bordered" style="width:100%">
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

    </div>

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


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/detalle_user.js?v0.0.0')}}"></script>
@endpush