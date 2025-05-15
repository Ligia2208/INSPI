

control




@extends('layouts.main')

@section('title', 'Laminas')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="card card-custom gutter-b"> 
  <div class="card-body pt-0 pb-3">
        <div class="mb-5">
            <div class="row align-items-center">

                <div class="col-md-3 " align="center">
                <a href="http://127.0.0.1:8000/laminas_parasitologia_validar" class="navi-link py-4 menu-item-active active d-block">
                    <span class="navi-icon d-block mb-2">
                    <i class="fa fa-tags fa-3x"></i>
                    </span>
                    <span class="navi-text font-size-xl d-block">Láminas Asignadas</span>
                </a>
                </div>
                
                <div class="col-md-3 " align="center">
                <a href="http://127.0.0.1:8000/laminas_parasitologia_procesadas" class="navi-link py-4 d-block">
                    <span class="navi-icon d-block mb-2">
                    <i class="fa fa-cogs fa-3x"></i>
                    </span>
                    <span class="navi-text font-size-xl d-block">Láminas Procesadas</span>
                </a>
                </div>
            
            </div>
        </div>
  </div>
</div>

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" kt-hidden-height="54">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
    <div class="d-flex align-items-center flex-wrap mr-1">
      <div class="d-flex align-items-baseline mr-5">
        <a href="#">
          <h5 class="text-dark font-weight-bold my-2 mr-5">Recepción de Láminas</h5>
        </a>
      </div>
    </div>
  </div>
</div>


<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE INGRESOS DE LAMINAS </h2>
            <hr/>

            <div class="row mb-3"> 

                <div class="col-md-2 d-flex">
                    <button id="btnGenerarPDFResultados" class="btn btn-dark w-100"><i class="bi bi-filetype-pdf"></i>Generar PDF Resultados</button>
                </div>

            </div>



            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="tblPlanificacionIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>COD Microscopista</th>
                                    <th>Unidad de salud</th>
                                    <th>Analista</th>
                                    <th>Total de Láminas</th>
                                    <th>Puntaje</th>
                                    <th>Interpretación</th>
                                    <th>Mes</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>COD Microscopista</th>
                                    <th>Unidad de salud</th>
                                    <th>Analista</th>
                                    <th>Total de Láminas</th>
                                    <th>Puntaje</th>
                                    <th>Interpretación</th>
                                    <th>Mes</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                    <!-- Campo oculto para guardar el ID seleccionado de la lámina -->
                    <input type="hidden" id="id_lamina">

                </div>
                
            </div>

        </div>

    </div>

</div>


@endsection

@stack('scripts')

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Lamina/index_parasito_pro.js?v0.0.0')}}"></script>
@endpush



