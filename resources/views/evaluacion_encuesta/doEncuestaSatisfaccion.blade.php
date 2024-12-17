@extends('layouts.Rocker.cuerpo')


@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/doEncuesta.js?v0.0.2')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')

    

<div class="page-wrapper">
	<div class="page-content">

        @if(!$valor)

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">¡Encuestas de Satisfacción!</h4>
            <p>Actualmente no hemos encontrado ninguna encuesta disponible.</p>
            <hr>
            <p class="mb-0">Si tienes alguna pregunta o necesitas asistencia, por favor, contacta al CRN.</p>
        </div>

        @else

        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Encuesta de Satisfacción - INSPI </h2>
        <hr/>


        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <div class="row">

            @php
                $semestreActual = \Carbon\Carbon::now()->month <= 6 ? 1 : 2;
                $encuestaPeriodo = $datosEvento->periodo == '1er Semestre' ? 1 : 2;
                $añoActual = date('Y');
            @endphp

            @if ($encuestaPeriodo == $semestreActual && $añoActual == $datosEvento->anio)
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
                                                        <label for="nom_zonal" class="form-label">Coordinación</label>
                                                        <input type="text" id="nom_zonal" name="nom_zonal" class="form-control @error('nom_zonal') is-invalid @enderror" required="" autofocus="" value=" {{ $datos_lab->nom_zonal }} " disabled>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        @error('nom_zonal')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6 mt-2">
                                                        <label for="areaName" class="form-label">Laboratorio</label>
                                                        <input type="text" id="areaName" name="areaName" class="form-control @error('nom_lab') is-invalid @enderror" required="" autofocus="" value=" {{ $datos_lab->nom_lab }} " disabled>
                                                        <div class="valid-feedback">Looks good!</div>
                                                        @error('nom_lab')
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

                                                    <div class="col-md-6 mt-2">
                                                        <label for="name_unidad" class="form-label">Unidad de Salud</label>
                                                        <input type="text" id="name_unidad" name="name_unidad" class="form-control @error('name_unidad') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese la Unidad de Salud">
                                                        <div class="valid-feedback">Looks good!</div>
                                                        @error('name_unidad')
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
                                                            <input class="form-check-input" type="radio" id="opcion{{ $pregunta['id'] }}" name="opcion{{ $pregunta['id'] }}" onchange="presentar({{ $loop->iteration }})" data-id="{{ $opcion['id'] }}" data-nombre="{{ $opcion['nombre'] }}" data-idPregunta="{{ $pregunta['id'] }}" value="SI">
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
                                            {{-- @if($tipo == 'P' || $tipo == 'NP' || $tipo == 'L') --}}
                                            <!-- <section class="row" id="conteAbrindada"> -->

                                            <!-- </section> -->
                                            {{-- @endif --}}
                                            <!--  Comentarios al laboratorio  -->


                                            <!--  Comentarios  -->
                                            <section class="row mt-5">
                                            <div class="col-md-12">
                                                <h3>Comentarios (Opcional).</h3>
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
                                            <section class="row mt-5">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info" id="saveForm" onclick="guardarExternoLink()">Guardar Encuesta</button>
                                                <button type="button" class="btn btn-danger" id="clearForm" onclick="limpiarRadios()">Limpiar formulario</button>
                                            </div>
                                            </section>
                                        </div>

                                </div>

                            </form>


                        </div>
                    </div>
                </div>


            </div>
            @else
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">¡Encuestas de Satisfacción!</h4>
                <p>La encuestas que esta buscando ya expiro. {{ $semestreActual }}</p>
                <hr>
                <p class="mb-0">Si tienes alguna pregunta o necesitas asistencia, por favor, contacta al CRN.</p>
            </div>
            @endif
        </div>

        @endif

    </div>
</div>


@endsection