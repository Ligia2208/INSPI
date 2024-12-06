
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/link_encuesta.js?v0.0.0')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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




        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-link'></i> Enlazar Encuesta </h2>
        <!-- <hr/> -->
            <!-- <button class="btn btn-primary px-5  d-flex align-items-center" id="btnCreateCatalogo" name="btnCreateCatalogo" type="button" >
                <i class="lni lni-circle-plus"></i> Agregar
            </button> -->
        <hr/>


        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <div class="row">

            @if(count($tipoEncuesta) > 0)
            @foreach($tipoEncuesta as $tipo)

            <div class="col-xl-4 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <label for="tipo{{$tipo->id}}" class="form-label">{{$tipo->nombre}}</label>
                        <select id="tipo{{$tipo->id}}" name="tipo" data-id="{{$tipo->id}}" class="form-select single-select" required="" autofocus="" onchange="guardarEncuesta('tipo{{$tipo->id}}')">
                            <option value="0">Seleccione una encuesta</option>
                            @foreach($encuestas as $encuesta)
                            <option value="{{$encuesta->id}}" {{ $encuesta->id == $tipo->encuesta_id ? 'selected' : '' }} > {{$encuesta->nombre}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            @endforeach
            @else
                <p class="text-danger">No hay elementos para mostrar. Debe de ingresar un Tipo de Encuesta</p>
                <input id="validacionLab" type="hidden" value="0">
            @endif

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
