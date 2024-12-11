@extends('layouts.main')

@section('title', 'Importar Actividades')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Importar Actividades</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">


            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Registrar movimientos en el Inventario </h2>
            
            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Carga Masiva</h1>
                        </div>
                    </div>
                </div>

            </div>



            <div class="card text-center" id="cuerpoIngreso">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">
                            <a class="nav-link active fs-5 fw-bolder" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Carga Masiva</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">

                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <a href="{{ asset('assets/doc/plantilla_ingreso_inventario.csv') }}" download="plantilla_ingreso_inventario.csv" class="btn btn-primary">
                                    Descargar Plantilla
                                    <i class='bx bx-download'></i>
                                </a>

                                <a href="{{ route('exportarPlantilla') }}"  class="btn btn-secondary ms-2">
                                    Descargar Datos
                                    <i class='bx bx-download'></i>
                                </a>

                            </div>

                            <form id="importForm" enctype="multipart/form-data">
                                @csrf
                                <div class="border p-5 pt-2">
                                    <label class="form-label fs-4 fw-bolder" for="customFile">Ingrese la matriz</label>
                                    <input type="file" class="form-control" name="file" required id="file" />
                                </div>

                                <div class="col-6 mt-2">
                                    <button id="importButton" class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button">
                                        <i class='bx bxs-save'></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>

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


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/import_actividad.js?v0.0.0')}}"></script>
@endpush