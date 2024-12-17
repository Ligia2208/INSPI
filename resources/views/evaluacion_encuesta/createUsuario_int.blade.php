
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
            <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Usuarios Internos </h2>
            <hr/>
            <div class="row">
                <div class="col-xl-12 mx-auto">

                    <div class="card">

                        <div class="card-body">
                            <div class="p-4 border rounded">
                                <form id="frmCreateEncuesta" method="post" class="row g-3 needs-validation " novalidate>
                                @csrf

                                        <div id="contenedorEncuesta" class="row">

                                            <input id="laboratorio_id" type="hidden" value=" {{ $laboratorio_id }} ">
                                            <input id="tipoencuesta_id" type="hidden" value=" {{ $tipoencuesta_id }} ">

                                            <div class="col-md-6 mt-4 row">
                                                <div class="col-md-12">
                                                    <label for="usuarios" class="form-label">Usuarios del Laboratorio</label>
                                                    <select id="usuarios" name="usuarios" class="form-select single-select  @error('usuarios') is-invalid @enderror" required="" autofocus="">
                                                        <option value="0">Seleccione un Usuario</option>

                                                        @foreach($usuarios as $usuario)
                                                        <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                                        @endforeach

                                                    </select>
                                                    @error('usuarios')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <a type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2" onclick="guardar()">
                                                        <span class="lni lni-save"></span>
                                                        Guardar
                                                    </a>
                                                </div>

                                            </div>


                                            <div class="col-md-6 mt-4 border text-center">

                                                <h4 class="p-4">Usuarios agregados</h4>

                                                <ul class="list-group">

                                                    @if(count($usuariosLab) > 0)
                                                    @foreach($usuariosLab as $usuarioL)
                                                    <li class="list-group-item mb-2 ">
                                                        <div class="row">
                                                            <div class="col-lg-9">
                                                                {{$usuarioL->nombre}}
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( {{$usuarioL->id}}, {{$usuarioL->laboratorio_id}}, {{ $usuarioL->id_labusu }} )">
                                                                    <span class="lni lni-close"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                    @else
                                                    <!-- <li class="list-group-item active" aria-current="true"> -->
                                                    <li class="list-group-item mb-2">
                                                        Aun no hay usuarios para este laboratorio
                                                    </li>
                                                    @endif

                                                </ul>

                                            </div>


                                        </div>


                                        <div class="modal-footer mt-4">
                                            <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('encuesta.createUsuario_lab') }}">
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

</div>

@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/EventoEncuesta/createUsuario_lab.js?v0.0.2')}}"></script>
@endpush