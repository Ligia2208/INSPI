@extends('layouts.main')

@section('title', 'Crear Encuesta')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Crear Encuesta</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">
    <div class="container2">
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
                                <form id="frmCreateEncuesta" method="post" class="row g-3 needs-validation " novalidate>
                                    @csrf

                                    <div class="row col-lg-12">

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

                                    <div id="contenedorEncuesta" class="col-lg-12 mt-4">
                                    </div>


                                    <hr>

                                    <div class="col-lg-12 mt-4">
                                        <a class="btn submit btn-success btn-shadow font-weight-bold mr-2" onclick="agregarPregunta()">
                                            <i class="lni lni-circle-plus"></i>
                                            Agregar Pregunta
                                        </a>
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
</div>
@endsection

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/EventoEncuesta/create_encuesta.js?v0.0.1')}}"></script>
@endpush
