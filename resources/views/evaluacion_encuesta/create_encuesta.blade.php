
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/create_encuesta.js?v0.0.1')}}"></script>
    <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js?v0.0.75')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Encuesta </h2>
        <!-- <hr/> -->
            <!-- <button class="btn btn-primary px-5  d-flex align-items-center" id="btnCreateCatalogo" name="btnCreateCatalogo" type="button" >
                <i class="lni lni-circle-plus"></i> Agregar
            </button> -->
        <hr/>


        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <div class="row">
            <div class="col-xl-12 mx-auto">

                <div class="card">

                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form id="frmCreateEncuesta" action="{{ route('gestion.store') }}" method="post" class="row g-3 needs-validation " novalidate>
                            @csrf

                                    <div id="contenedorEncuesta" class="row">

                                        <div class="col-md-6">
                                            <label for="nombreEncue" class="form-label">Nombre de la Encuesta</label>
                                            <input type="text" id="nombreEncue" name="nombreEncue" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required autofocus placeholder="Ingrese el nombre">
                                            @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="descripEncue" class="form-label">Descripción</label>
                                            <input type="text" id="descripEncue" name="descripEncue" class="form-control @error('asunto') is-invalid @enderror" value="{{ old('asunto') }}" required="" autofocus="" placeholder="Ingrese la descripción">
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('asunto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <hr>

                                    <a class="btn submit btn-success btn-shadow font-weight-bold mr-2" onclick="agregarPregunta()">
                                        <i class="lni lni-circle-plus"></i>
                                        Agregar Pregunta
                                    </a>


                                    <div class="modal-footer mt-4">
                                        <a type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2" onclick="guardar()">
                                            <span class="lni lni-save"></span>
                                            Guardar
                                        </a>
                                        <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('encuesta') }}">
                                            <span class="lni lni-close"></span>
                                            Cerrar
                                        </a>
                                    </div>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>
</div>
@endsection


