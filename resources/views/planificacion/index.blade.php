
@extends('layouts.main')

@section('title', 'Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                </div>
            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE ACTIVIDADES </h2>
            <hr/>
            <div id="contModalComentarios">
            </div>

            <div class="card">
                <select id="filterDireccion" class="form-control js-example-basic-single mt-2">
                    <option value="">Todas las Direcciones</option>
                    @foreach($direcciones as $direccion)
                        <option value="{{ $direccion->departamento }}">{{ $direccion->departamento }}</option>
                    @endforeach
                </select>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblPlanificacionIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>POA</th>
                                    <th>Objetivo Operativo</th>
                                    <th>Actividad Operativa</th>
                                    <th>Sub actividad</th>
                                    <th>Proceso</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Revisión</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Departamento</th>
                                    <th>POA</th>
                                    <th>Objetivo Operativo</th>
                                    <th>Actividad Operativa</th>
                                    <th>Sub actividad</th>
                                    <th>Proceso</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Revisión</th>
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
<script src="{{asset('assets/js/Planificacion/init_poa.js?v0.0.6')}}"></script>
@endpush
