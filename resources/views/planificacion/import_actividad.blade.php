
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Planificacion/import_actividad.js?v0.0.0')}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- <link href="{{asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" /> -->

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
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

@endsection


<script>

</script>

