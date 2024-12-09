
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Planificacion/init_poa.js?v0.0.6')}}"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

        <div class="col">

        </div>


        </div>

        <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE ACTIVIDADES </h2>
        <!-- <hr/>
        <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('inventario.crearMovimiento') }}" type="button" >
            <i class="lni lni-circle-plus"></i> Crear Movimiento
        </a> -->
        <hr/>

        <div id="contModalComentarios">
        </div>

        <div class="card">
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

