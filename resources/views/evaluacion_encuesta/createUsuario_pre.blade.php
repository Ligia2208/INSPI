
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/createUsuario_pre.js?v0.0.0')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Usuarios Externo Presencial </h2>
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
@endsection


