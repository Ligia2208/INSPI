
@extends('layouts.main')

@section('title', 'Crear Laboratorio')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Creación de Laboratorios</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">
            <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Laboratorio </h2>
            <hr/>

            <div class="row">
                <div class="col-xl-12 mx-auto">

                    <div class="card">

                        <div class="card-body">
                            <div class="p-4 border rounded">

                                <input type="hidden" id="id_area" name="id_area" value="" >
                                <input type="hidden" id="id_zonal" name="id_zonal" value="" >

                                <form id="frmCreateEncuesta" method="post" class="row g-3 needs-validation " novalidate>
                                    @csrf

                                    <div id="contenedorEncuesta" class="row col-lg-12">

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
                                            <select id="coordina" name="coordina" class="form-control single-select  @error('coordina') is-invalid @enderror" required="" autofocus="">
                                                <option value="0">Seleccione la Coordinación</option>
                                                @foreach($coordina as $coor)
                                                    <option value="{{ $coor->id}}"> {{ $coor->descripcion}} </option>
                                                @endforeach
                                            </select>
                                            @error('coordina')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <label for="departamentos" class="form-label">Departamento</label>
                                            <select id="departamento" name="departamento" class="form-control single-select  @error('departamento') is-invalid @enderror" required="" autofocus="">
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

                                    <div class="modal-footer mt-4 col-lg-12">
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

</div>
@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/EventoEncuesta/create_laboratorio.js?v0.0.3')}}"></script>
@endpush
