
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/initEncuesta.js?v0.0.1')}}"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('crearEncuesta')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bx bxs-book-add"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Crear Encuesta</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('encuesta')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bx bxs-calendar-event"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Programar Evento</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('listarEncuesta')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bx bx-list-ol"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Lista Encuestas</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('crearUsuario')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bx bx-user-plus"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Crear Usuario</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('enlazarEncuesta')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bx-link'></i>
                            </div>

                            <div class="text-center">
                                <h4 class="my-1 text-primary ms-auto">Enlazar</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('crearLaboratorio')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Crear Laboratorio</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Lista de Programación </h2>
        <hr/>
        <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('encuesta.createEvento') }}" type="button" >
            <i class="lni lni-circle-plus"></i> Crear Evento
        </a>
        <hr/>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tblGEncuestaIndex" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Laboratorio ID</th>
                                <th>Año</th>
                                <th>Periodo</th>
                                <th> <center> Estado </center></th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Laboratorio ID</th>
                                <th>Año</th>
                                <th>Periodo</th>
                                <th> <center> Estado </center></th>
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


    <div class="modal fade " id="modalLinkEncuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Link de la Encuesta</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                <div id="modalContentLink" class="row">
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

        if(dato == 'crearEncuesta'){
            window.location.href = '/encuestas/create';
        }else if(dato == 'listarEncuesta'){
            window.location.href = '/encuestas/listarEncuesta';
        }else if(dato == 'crearLaboratorio'){
            window.location.href = '/encuestas/listarLaboratorio';
        }else if(dato == 'enlazarEncuesta'){
            window.location.href = '/encuestas/enlazarEncuesta';
        }else if(dato == 'encuesta'){
            window.location.href = '/encuestas';
        }else if(dato == 'crearUsuario'){
            window.location.href = '/encuestas/crearUsuario';
        }

    }


</script>

