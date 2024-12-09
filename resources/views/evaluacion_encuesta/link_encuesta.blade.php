

@extends('layouts.main')

@section('title', 'Enlazar Encuesta')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Enlazar Encuesta</h5></a>
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
                            <select id="tipo{{$tipo->id}}" name="tipo" data-id="{{$tipo->id}}" class="form-control single-select" required="" autofocus="" onchange="guardarEncuesta('tipo{{$tipo->id}}')">
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
<script src="{{asset('assets/js/EventoEncuesta/link_encuesta.js?v0.0.0')}}"></script>
@endpush