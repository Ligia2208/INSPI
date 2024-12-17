
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/create_evento.js?v0.0.1')}}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Evento </h2>
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

                                        <div class="col-md-12">
                                            <label for="eventoName" class="form-label">Nombre del Evento</label>
                                            <input type="text" id="eventoName" name="eventoName" class="form-control @error('eventoName') is-invalid @enderror" value="{{ old('eventoName') }}" required="" autofocus="" placeholder="Ingrese el asunto">
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('eventoName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <label for="coordina" class="form-label">Coordinación Zonal</label>
                                            <select id="coordina" name="coordina" class="form-select single-select  @error('coordina') is-invalid @enderror" required="" autofocus="">
                                                <option value="0">Seleccione la Coordinación</option>
                                                @foreach($coordina as $coor)
                                                    <option value="{{ $coor->id}}"> {{ $coor->nombre}} </option>
                                                @endforeach
                                            </select>
                                            @error('coordina')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <label for="laboratorio" class="form-label">Laboratorio</label>
                                            <select id="laboratorio" name="laboratorio" class="form-select single-select  @error('laboratorio') is-invalid @enderror" required="" autofocus="">
                                                <option value="0">Seleccione un Laboratorio</option>

                                            </select>
                                            @error('laboratorio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr class="mt-4">

                                        <div class="col-md-6">
                                            <label for="periodo" class="form-label">Perido de Encuesta</label>
                                            <select id="periodo" name="periodo" class="form-select single-select  @error('periodo') is-invalid @enderror" required="" autofocus="">
                                                <option value="0">Seleccione el perido</option>
                                                @foreach($periodos as $periodo)
                                                    <option value="{{ $periodo->id}}"> {{ $periodo->nombre}} </option>
                                                @endforeach
                                            </select>
                                            @error('periodo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="anio" class="form-label">Seleccione el año:</label>
                                            <input type="text" id="anio" name="anio" class="form-control @error('anio') is-invalid @enderror" required="" placeholder="Seleccione el año">
                                            <div class="valid-feedback">¡Correcto!</div>
                                            @error('anio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>


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


