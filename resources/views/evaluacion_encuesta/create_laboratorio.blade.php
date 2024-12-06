
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/create_laboratorio.js?v0.0.3')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Laboratorio </h2>
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

                            <input type="hidden" id="id_area" name="id_area" value="" >
                            <input type="hidden" id="id_zonal" name="id_zonal" value="" >

                            <form id="frmCreateEncuesta" action="{{ route('gestion.store') }}" method="post" class="row g-3 needs-validation " novalidate>
                            @csrf

                                    <div id="contenedorEncuesta" class="row">

                                        <div class="col-md-12">
                                            <label for="descripLab" class="form-label">Descripción</label>
                                            <input type="text" id="descripLab" name="descripLab" class="form-control @error('descripLab') is-invalid @enderror" value="{{ old('descripLab') }}" required="" autofocus="" placeholder="Ingrese el asunto">
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('descripLab')
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
                                            <label for="departamentos" class="form-label">Departamento</label>
                                            <select id="departamento" name="departamento" class="form-select single-select  @error('departamento') is-invalid @enderror" required="" autofocus="">
                                                <option value="0">Seleccione un Departamento</option>

                                            </select>
                                            @error('departamento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr class="mt-4">

                                        <div class="col-md-6 mt-2">

                                            <h3>Seleccione tipo de Encuesta:</h3>
                                            @if(count($tipoEncuesta) > 0)
                                            @foreach($tipoEncuesta as $tipo)

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="tipoEncuestaLab" id="flexSwitchPresencial" data-id="{{ $tipo->id }}">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">{{$tipo->nombre}}</label>
                                            </div>

                                            @endforeach
                                            @else
                                                <p class="text-danger">No hay elementos para mostrar. No podrá ingresar un laboratorio sin antes agregar un Tipo de Encuesta</p>
                                                <input id="validacionLab" type="hidden" value="0">
                                            @endif

                                        </div>

                                    </div>


                                    <div class="modal-footer mt-4">
                                        <a type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2" onclick="guardar()">
                                            <span class="lni lni-save"></span>
                                            Guardar
                                        </a>
                                        <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('encuesta.listLaboratorio') }}">
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


