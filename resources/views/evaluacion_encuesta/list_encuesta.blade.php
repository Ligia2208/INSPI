
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/list_encuesta.js?v0.0.3')}}"></script>
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

        <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Lista de Encuestas </h2>
        <hr/>

        <div class="card">
            <div class="card-header">
                <a class="btn btn-success col-2 d-flex align-items-center justify-content-center" onclick="redireccionEncuesta('crearEncuesta')">
                    <i class="lni lni-circle-plus"></i>Crear Encuesta
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tblLEncuesta" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th># Preguntas</th>
                                <th>Fecha</th>
                                <th> <center> Estado </center></th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th># Preguntas</th>
                                <th>Fecha</th>
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

