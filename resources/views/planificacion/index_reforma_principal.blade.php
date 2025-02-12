
@extends('layouts.main')

@section('title', 'Reforma Administrador')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Reforma Administrador</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> SOLICITUD DE REFORMAS PAPP/PRESUPUESTARIA </h2>
            <hr/>


            <div id="contModalComentarios">
            </div>

            <div class="card">

                <div class="card-body">

                    <div class="row">

                        <div class="col-lg-3 mt-2 mb-5">
                            <label for="filterEstado" class="form-label">Filtrar por Estados:</label>
                            <select id="filterEstado" class="form-control js-example-basic-single">
                                <option value="">Todos los Estados</option>
                                <option value="A">Ingresado</option>
                                <option value="O">Validado</option>
                                <option value="V">Aprobado</option>
                                <option value="R">Rechazado</option>
                            </select>
                        </div>

                        <div class="col-lg-3 mt-2 mb-5">
                            <label for="filterTipo" class="form-label">Seleccione el tipo de Reforma:</label>
                            <select id="filterTipo" class="form-control js-example-basic-single">
                                <option value="">Todos los Tipos</option>
                                <option value="M">Modificación PAPP</option>
                                <option value="R">Reforma PAPP/Presupuestaria</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2 mb-5">
                            <label for="filterDireccion" class="form-label">Seleccione la dirección:</label>
                            <select id="filterDireccion" class="form-control js-example-basic-single">
                                <option value="">Todas las Direcciones</option>
                                @foreach($direcciones as $direccion)
                                    <option value="{{ $direccion->id }}">{{ $direccion->nombre }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="tblReformaIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nro de solicitud</th>
                                    <th>Solicitante</th>
                                    <th>Justificacion</th>
                                    <th>Monto</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nro de solicitud</th>
                                    <th>Solicitante</th>
                                    <th>Justificacion</th>
                                    <th>Monto</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
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

@endsection

<script>

    function redireccionEncuesta(dato){

        if(dato == 'categoria'){
            window.location.href = '/inventario/categoria';
        }else if(dato == 'articulo'){
            window.location.href = '/inventario/articulo';
        }else if(dato == 'factura'){
            window.location.href = '/inventario/movimiento';
        }else if(dato == 'unidad'){
            window.location.href = '/inventario/unidad';
        }

    }

</script>


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/init_reforma.js?v0.0.11')}}"></script>
@endpush