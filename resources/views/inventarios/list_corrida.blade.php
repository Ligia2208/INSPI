
@extends('layouts.main')

@section('title', 'Lista de Corridas')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Lista de Corridas</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('laboratorio')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-inboxes py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Inventario</h4>
                                </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('corrida')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-card-checklist py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">List Corrida</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('transferencia')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-folder-symlink py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Transferencía</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('agregarUnidades')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-plus-slash-minus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Unidades</h4>
                                    <span class="position-absolute top-0 right-0 translate-middle badge rounded-pill menu-label">
                                        <span class="label label-danger">{{$cantKits}}+</span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Lista de Corridas </h2>
            <hr/>
            <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('inventario.crearEgresoInf') }}" type="button">
                <i class="lni lni-circle-plus"></i> Crear Corrida
            </a>

            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblIActaIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Técnica</th>
                                    <th>Servicio</th>
                                    <th>Equipos</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Técnica</th>
                                    <th>Servicio</th>
                                    <th>Equipos</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        @if(session('success'))
        <script>
            Swal.fire({
                title: 'SoftInspi',
                text: '{{ session('success') }}',
                icon: 'success',
                type: 'success',
                confirmButtonText: 'Aceptar',
                timer: 3500
            });
        </script>
        @endif

    </div>

</div>


    <a id="btnModalReport" data-toggle="modal" data-target="#addReport" class="d-none"></a>

    <div class="modal fade" id="addReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Reporte 1</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                                <input type="hidden" id="id_corrida" name="id_corrida" class="form-control" required="" autofocus="" value="">
                                <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="{{$labora->id}}">

                            <div class="col-md-4 mt-1">
                                <label for="revisado" class="form-label fs-6">Usuario que Revisó</label>
                                <select id="revisado" name="revisado" class="single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="aprovado" class="form-label fs-6">Usuario que Autoriza</label>
                                <select id="aprovado" name="aprovado" class="form-select single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="realizo" class="form-label fs-6">Usuario que Reporta</label>
                                <select id="realizo" name="realizo" class="form-select single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarReport">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <a id="btnModalReportMono" data-toggle="modal" data-target="#addReportMono" class="d-none"></a>

    <div class="modal fade" id="addReportMono" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generar Reporte Monoclonales</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="row">

                                <input type="hidden" id="id_corridaMono" name="id_corridaMono" class="form-control" required="" autofocus="" value="">
                                <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="{{$labora->id}}">

                            <div class="col-md-4 mt-1">
                                <label for="revisadoMono" class="form-label fs-6">Usuario que Revisó</label>
                                <select id="revisadoMono" name="revisadoMono" class="form-select single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="aprovadoMono" class="form-label fs-6">Usuario que Autoriza</label>
                                <select id="aprovadoMono" name="aprovadoMono" class="form-select single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                            <div class="col-md-4 mt-1">
                                <label for="realizoMono" class="form-label fs-6">Usuario que Reporta</label>
                                <select id="realizoMono" name="realizoMono" class="form-select single-select" required>
                                    <option value="0">Seleccione un Usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                            </div>

                            <div class="col-md-4">
                                <label for="tecnica" class="form-label fs-6">Fecha Inicio</label>
                                <input type="date" id="fInicioMono" name="fInicioMono" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4">
                                <label for="tecnica" class="form-label fs-6">Fecha Fin</label>
                                <input type="date" id="fFinMono" name="fFinMono" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnGenerarReportMono">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <div id="contModalReport">
    </div>



@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

<script>

function redireccionEncuesta(dato){

    if(dato == 'corrida'){
        //window.location.href = '/inventario/crearEgreso';
        window.location.href = '/inventario/list_corrida';
    }else if(dato == 'transferencia'){
        window.location.href = '/inventario/transferencia';
    }else if(dato == 'agregarUnidades'){
        window.location.href = '/inventario/agregarUnidades';
    }else if(dato == 'laboratorio'){
        window.location.href = "/inventario/laboratorio";
    }

}


</script>


<script>

    $('#revisado').select2({
    /*
        dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    */
    });

</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/list_corrida.js?v0.0.0')}}"></script>
@endpush
