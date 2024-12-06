
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/doEncuesta.js?v0.0.1')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Encuesta de Satisfacción - INSPI </h2>
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

                                            <div class="container">

                                                <!--  Servicios  -->
                                                <section class="row">

                                                @foreach( $encuestaArray as $encuesta )

                                                <div class="container mt-4">
                                                    <section class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="text-center">{{ $encuesta['descripcion'] }}</h2>
                                                            <p class="text-center">{{ $encuesta['nombre'] }}</p>
                                                            <input type="hidden" value="{{ $encuesta['nombre'] }}" id="nombreEncuesta">
                                                            <input type="hidden" value="{{ $encuesta['id'] }}" id="idEncuesta">
                                                            <input type="hidden" value="{{ $encuesta['descripcion'] }}" id="descripcion">
                                                            <input type="hidden" value="{{ $tipoencuesta_id }}" id="tipoencuesta_id">
                                                            <input type="hidden" value="{{ $laboratorio_id }}" id="laboratorio_id">
                                                            <input type="hidden" value="{{ $id_evento }}" id="id_evento">
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label for="fechaUser" class="form-label">Fecha</label>
                                                            <input type="date" id="fechaUser" name="fechaUser" class="form-control @error('fechaUser') is-invalid @enderror" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" disabled>
                                                            <div class="valid-feedback">Looks good!</div>
                                                            @error('fechaUser')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label for="servicioName" class="form-label">Seleccione el servicio</label>
                                                            <select id="servicioName" name="servicioName" class="form-select single-select  @error('servicios') is-invalid @enderror" required="" autofocus="">
                                                                <option value="0">Seleccione el Servicio</option>
                                                                @foreach($servicios as $servicio)
                                                                    <option value="{{ $servicio->id}}"> {{ $servicio->nombre}} </option>
                                                                @endforeach
                                                            </select>
                                                            @error('servicios')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label for="areaName" class="form-label">Área que prestó el servicio</label>
                                                            <input type="text" id="areaName" name="areaName" class="form-control @error('areaName') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese el area del servicio">
                                                            <div class="valid-feedback">Looks good!</div>
                                                            @error('areaName')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6 mt-2">
                                                            <label for="ciudad" class="form-label">Ciudad</label>
                                                            <input type="text" id="ciudad" name="ciudad" class="form-control @error('ciudad') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese la Ciudad">
                                                            <div class="valid-feedback">Looks good!</div>
                                                            @error('ciudad')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </section>

                                                    <hr class="mt-4">

                                                    <p class="text-center">Estimado Usuario, solicitamos su colaboración en el llenado del siguiente cuestionario. Su opinión es importante para nosotros.    Sus respuestas serán tratadas de forma confidencial y serán utilizadas para mejorar el servicio que le brindamos.</p>

                                                    @foreach( $encuesta['preguntas'] as $pregunta )

                                                    @if($pregunta['abrindada'] == 'false')
                                                    <section class="row mt-4">
                                                        <div class="col-md-12">
                                                            <h4>{{ $pregunta['nombre'] }}</h4>
                                                            <input class="form-control" type="hidden" id="pregunta{{ $pregunta['id'] }}" name="pregunta" data-id="{{ $pregunta['id'] }}" value="{{ $pregunta['nombre'] }}">
                                                            
                                                            @php
                                                                $primerValor = reset($pregunta['opciones']);
                                                                $ultimoValor = end($pregunta['opciones']);
                                                            @endphp

                                                            <!-- Utiliza $primerValor como una cadena -->
                                                            <p class=""> <em> ( {{ $primerValor['nombre'] }} / 1 - {{ $ultimoValor['nombre'] }} / 5 ) </em> </p>

                                                            <p></p>
                                                        </div>

                                                        <div class="row p-4 ms-4">
                                                        @foreach( $pregunta['opciones'] as $opcion )
                                                            <div class="col-md-12 form-check">
                                                                <input class="form-check-input" type="radio" id="opcion{{ $pregunta['id'] }}" name="opcion{{ $pregunta['id'] }}" data-id="{{ $opcion['id'] }}" data-nombre="{{ $opcion['nombre'] }}" data-idPregunta="{{ $pregunta['id'] }}" value="SI">
                                                                <label class="radio form-check-label fs-6">
                                                                    {{ $opcion['nombre'] }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        </div>

                                                    </section>
                                                    <hr class="mt-4">

                                                    @else

                                                    <h3 class="text-center">RESPECTO A LA ATENCIÓN BRINDADA POR EL SERVIDOR PÚBLICO </h3>

                                                    <section class="row mt-4">
                                                        <div class="col-md-12">
                                                            <h4>{{ $pregunta['nombre'] }}</h4>
                                                            <input class="form-control" type="hidden" id="pregunta{{ $pregunta['id'] }}" name="pregunta" data-id="{{ $pregunta['id'] }}" value="{{ $pregunta['nombre'] }}">
                                                            
                                                            @php
                                                                $primerValor = reset($pregunta['opciones']);
                                                                $ultimoValor = end($pregunta['opciones']);
                                                            @endphp

                                                            <!-- Utiliza $primerValor como una cadena -->
                                                            <p class=""> <em> ( {{ $primerValor['nombre'] }} / 1 - {{ $ultimoValor['nombre'] }} / 5 ) </em> </p>

                                                            <p></p>
                                                        </div>

                                                        <div class="row p-4 ms-4">
                                                        @foreach( $pregunta['opciones'] as $opcion )
                                                            <div class="col-md-12 form-check">
                                                                <input class="form-check-input" type="radio" id="opcion{{ $pregunta['id'] }}" name="opcion{{ $pregunta['id'] }}" onchange="presentar('{{ $loop->iteration }}')" data-id="{{ $opcion['id'] }}" data-nombre="{{ $opcion['nombre'] }}" data-idPregunta="{{ $pregunta['id'] }}" value="SI">
                                                                <label class="radio form-check-label fs-6">
                                                                    {{ $opcion['nombre'] }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        </div>

                                                    </section>
                                                    @endif

                                                    @endforeach

                                                </div>

                                                @endforeach


                                                <!--  Comentarios al laboratorio  -->
                                                @if($tipo == 'P' || $tipo == 'NP')
                                                <section class="row" id="conteAbrindada">

                                                </section>
                                                @endif
                                                <!--  Comentarios al laboratorio  -->


                                                <!--  Comentarios  -->
                                                <section class="row mt-5">
                                                    <div class="col-md-12">
                                                        <h3>Comentarios.</h3>
                                                        <p></p>
                                                    </div>
                                                </section>
                                                <section class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="comment">Comentarios:</label>
                                                            <textarea class="form-control" rows="6" id="comentarios"></textarea>
                                                        </div>
                                                    </div>
                                                </section>

                                            </div>

                                    </div>


                                    <div class="modal-footer mt-4">
                                        <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('encuesta.listEncuesta') }}">
                                            <span class="lni lni-close"></span>
                                            Atras
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


