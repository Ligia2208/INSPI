
@extends('layouts.main')

@section('title', 'Usuarios No Presenciales')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Usuarios No Presenciales</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="page-wrapper">
        <div class="page-content">
            <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Crear Usuarios Externos No Presenciales </h2>

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
                                        <input id="id_usuario" type="hidden" value="">


                                        <div class="col-md-4 mt-4 row fixed-height">

                                            <div class="col-md-12 mt-2">
                                                <label for="nombreUser" class="form-label">Nombre</label>
                                                <input type="text" id="nombreUser" name="nombreUser" class="form-control @error('nombreUser') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese el nombre">
                                                <div class="valid-feedback">Looks good!</div>
                                                @error('nombreUser')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label for="apellidoUser" class="form-label">Apellido</label>
                                                <input type="text" id="apellidoUser" name="apellidoUser" class="form-control @error('apellidoUser') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese el apellido">
                                                <div class="valid-feedback">Looks good!</div>
                                                @error('apellidoUser')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label for="correoUser" class="form-label">Correo</label>
                                                <input type="text" id="correoUser" name="correoUser" class="form-control @error('correoUser') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese el correo">
                                                <div class="valid-feedback">Looks good!</div>
                                                @error('correoUser')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label for="hospitalUser" class="form-label">Hospital</label>
                                                <input type="text" id="hospitalUser" name="hospitalUser" class="form-control @error('hospitalUser') is-invalid @enderror" required="" autofocus="" placeholder="Ingrese el hospital">
                                                <div class="valid-feedback">Looks good!</div>
                                                @error('hospitalUser')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <a type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2" onclick="guardar()" id="btn_Guardar">
                                                    <i class="bi bi-save2"></i>
                                                    Guardar
                                                </a>

                                                <a type="submit" class="btn submit btn-success btn-shadow font-weight-bold mr-2" onclick="editar()" id="btn_Editar">
                                                    <i class="bi bi-pen"></i>
                                                    Editar
                                                </a>

                                                <a type="button" class="btn submit btn-danger btn-shadow font-weight-bold mr-2" onclick="cancelar()" id="btn_Cancelar">
                                                    <i class="bi bi-x"></i>
                                                    Cancelar
                                                </a>

                                            </div>

                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <div class="col-md-12 border text-center">

                                                <h4 class="p-4">Usuarios agregados</h4>

                                                <ul class="list-group">

                                                    @if(count($usuariosLab) > 0)
                                                    @foreach($usuariosLab as $usuarioL)
                                                    @if($usuarioL->estado == 'A')
                                                    <li class="list-group-item mb-2 ">
                                                        <div class="row">
                                                            <div class="col-lg-9">
                                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                                    <span><strong>Nombre: </strong>{{$usuarioL->nombre}}</span>
                                                                    <span><strong>Correo: </strong>{{$usuarioL->correo}}</span>
                                                                    <span><strong>Hospital: </strong>{{$usuarioL->hospital}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a tupe="buttom" class="btn btn-success btn-sm" onclick="editUser( {{$usuarioL->id}}, {{$usuarioL->laboratorio_id}}, {{ $usuarioL->id_labusu }} )">
                                                                    <i class="bi bi-pen"></i>
                                                                </a>
                                                                <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( {{$usuarioL->id}}, {{$usuarioL->laboratorio_id}}, {{ $usuarioL->id_labusu }} )">
                                                                    <i class="bi bi-file-x"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
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

                                        <div class="col-md-4 mt-4">
                                            <div class="col-md-12 border text-center">

                                                <h4 class="p-4">Usuarios anteriores</h4>

                                                <ul class="list-group" id="usuariosAnteriores">

                                                    @if(count($usuariosLab) > 0)
                                                    @foreach($usuariosLab as $usuarioL)
                                                    @if($usuarioL->estado == 'E')
                                                    <li class="list-group-item mb-2 ">
                                                        <div class="row">
                                                            <div class="col-lg-9">
                                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                                    <span><strong>Nombre: </strong>{{$usuarioL->nombre}}</span>
                                                                    <span><strong>Correo: </strong>{{$usuarioL->correo}}</span>
                                                                    <span><strong>Hospital: </strong>{{$usuarioL->hospital}}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <a tupe="buttom" class="btn btn-success btn-sm" onclick="editUser( {{$usuarioL->id}}, {{$usuarioL->laboratorio_id}}, {{ $usuarioL->id_labusu }} )">
                                                                    <i class="bi bi-pen"></i>
                                                                </a>
                                                                <a tupe="buttom" class="btn btn-primary btn-sm" onclick="moveUser( {{$usuarioL->id}}, {{$usuarioL->laboratorio_id}}, {{ $usuarioL->id_labusu }} )">
                                                                    <i class="bi bi-arrow-left-square"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endif
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
<script src="{{asset('assets/js/EventoEncuesta/createUsuario_nopre.js?v0.0.1')}}"></script>
@endpush