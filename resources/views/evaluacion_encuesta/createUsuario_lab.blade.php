
@extends('layouts.main')

@section('title', 'Creación de usuarios')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Creación de usuarios por laboratorios</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('crearEncuesta')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class="bi bi-clipboard-plus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Crear Encuesta</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('encuesta')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class="bi bi-calendar-event py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Programar Evento</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('listarEncuesta')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class="bi bi-list-ol py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Lista Encuestas</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('crearUsuario')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class="bi bi-person-plus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Crear Usuario</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative mt-2" onclick="redireccionEncuesta('enlazarEncuesta')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class='bi bi-link py-3 px-2 titulo-grande'></i>
                                </div>

                                <div class="text-center">
                                    <h4 class="my-1 text-primary ms-auto">Enlazar</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative mt-2" onclick="redireccionEncuesta('crearLaboratorio')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white mr-2"><i class='bi bi-thermometer-high py-3 px-2 titulo-grande'></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Crear Laboratorio</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <h2 class="mb-0 text-uppercase text-center mt-4"> <i class='font-32 text-success bx bx-link'></i> Crear Usuarios </h2>
            <!-- <hr/> -->
                <!-- <button class="btn btn-primary px-5  d-flex align-items-center" id="btnCreateCatalogo" name="btnCreateCatalogo" type="button" >
                    <i class="lni lni-circle-plus"></i> Agregar
                </button> -->
            <hr/>

            <div class="row mb-4">

                @foreach($laboratoriosEncuesta as $pregunta)

                    <div class="col-xl-4 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <h3> {{ $pregunta['descripcion'] }} </h3>
                                <!-- <h3>Pregunta ID: {{ $pregunta['id'] }}</h3> -->
                                <h5>Agregar Usuarios</h5>
                                @if(count($pregunta['opcionesEncuesta']) > 0)

                                    <div class="row mt-1 d-flex justify-content-center align-items-center">

                                        @foreach($pregunta['opcionesEncuesta'] as $opcion)
                                        @if($opcion['tipo'] == 'P')
                                        <a class="col-5 btn btn-primary mx-1 mt-2 d-flex justify-content-center align-items-center" href="/encuestas/createUsuario_pre?tipoencu_id={{ $opcion['id'] }}" type="button">
                                            <i class="lni lni-circle-plus"></i> {{ $opcion['nombre'] }}
                                        </a>
                                        @elseif($opcion['tipo'] == 'NP')
                                        <a class="col-5 btn btn-primary mx-1 mt-2 d-flex justify-content-center align-items-center" href="/encuestas/createUsuario_nopre?tipoencu_id={{ $opcion['id'] }}" type="button">
                                            <i class="lni lni-circle-plus"></i> {{ $opcion['nombre'] }}
                                        </a>
                                        @elseif($opcion['tipo'] == 'I')
                                        <a class="col-5 btn btn-primary mx-1 mt-2 d-flex justify-content-center align-items-center" href="/encuestas/createUsuario_int?tipoencu_id={{ $opcion['id'] }}" type="button">
                                            <i class="lni lni-circle-plus"></i> {{ $opcion['nombre'] }}
                                        </a>
                                        @endif

                                        <!-- <li>ID: {{ $opcion['id'] }}, Nombre: {{ $opcion['nombre'] }}, Valor: {{ $opcion['valor'] }}, tipoencuesta_id:  {{ $opcion['tipoencuesta_id'] }}</li> -->
                                        @endforeach

                                    </div>

                                @else
                                    <p>No hay opciones para esta pregunta.</p>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach

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

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/EventoEncuesta/createUsuario_lab.js?v0.0.0')}}"></script>
@endpush