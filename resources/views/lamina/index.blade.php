
@extends('layouts.main')

@section('title', 'Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Recepción de Laminas</h5></a>
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
                <div class="col-md-2 d-flex me-2">
                    <a class="btn btn-primary w-100 d-flex align-items-center justify-content-center" href="{{ route('laminas.crear') }}">
                        <i class="lni lni-circle-plus me-1"></i> Ingresar Lámina
                    </a>
                </div>

                <div class="col-md-2 d-flex">
                    <button id="btnGenerarPDF" class="btn btn-primary w-100">Generar PDF</button>
                </div>
            </div>



            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="tblPlanificacionIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N° US</th>
                                    <th>Unidad de salud</th>
                                    <th>Recepta</th>
                                    <th>Analista</th>
                                    <th>Total de Láminas</th>
                                    <th>Mes</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>N° US</th>
                                    <th>Unidad de salud</th>
                                    <th>Recepta</th>
                                    <th>Analista</th>
                                    <th>Total de Láminas</th>
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



        <!-- Botón para abrir la calculadora -->
        <button type="button" class="btn btn-primary btn-floating" data-toggle="modal" data-target="#miCalculadora">
            <i class="bi bi-calculator titulo-grande p-0"></i>
        </button>

        <!-- Modal con la calculadora -->
        <div class="modal fade" id="miCalculadora" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Calculadora</h5>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent">
                            <div class="container">
                                <input type="text" id="display" class="form-control mb-2 text-right" disabled>
                                <div class="row">
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('7')">7</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('8')">8</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('9')">9</button>
                                    <button class="btn btn-warning col m-1" onclick="addToDisplay('/')">÷</button>
                                </div>
                                <div class="row">
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('4')">4</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('5')">5</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('6')">6</button>
                                    <button class="btn btn-warning col m-1" onclick="addToDisplay('*')">×</button>
                                </div>
                                <div class="row">
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('1')">1</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('2')">2</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('3')">3</button>
                                    <button class="btn btn-warning col m-1" onclick="addToDisplay('-')">−</button>
                                </div>
                                <div class="row">
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('0')">0</button>
                                    <button class="btn btn-secondary col m-1" onclick="addToDisplay('.')">.</button>
                                    <button class="btn btn-success col m-1" onclick="calculateResult()">=</button>
                                    <button class="btn btn-warning col m-1" onclick="addToDisplay('+')">+</button>
                                </div>
                                <div class="row">
                                    <button class="btn btn-danger col m-1" onclick="clearDisplay()">C</button>
                                    <button class="btn btn-info col m-1" onclick="addToMemory()">M+</button>
                                    <button class="btn btn-dark col m-1" onclick="clearMemory()">MC</button>
                                    <button class="btn btn-primary col m-1" onclick="useMemory()">MR</button>
                                </div>
                                <p class="text-right mt-2"><strong>Memoria: <span id="memoryValue">0</span></strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Botón para abrir el modal de convenio -->
        <button type="button" class="btn btn-primary btn-floating" data-toggle="modal" data-target="#miConvenio" id="btConvenio">
            <i class="bi bi-calculator titulo-grande p-0"></i>
        </button>

        <!-- Modal del convenio -->
        <div class="modal fade" id="miConvenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Convenios</h5>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent">
                            <div class="container">
                                <input type="hidden" id="id_convenio" class="form-control mb-2 text-right" disabled>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="justifica" class="form-label fs-6">Justificación</label>
                                <textarea id="justifica" name="justifica" class="form-control" required="" autofocus="" rows="4"></textarea>
                            </div>

                            <div class="col-md-12 mt-4 text-center">
                                <label for="estadoConv" class="form-label fs-6">Quiere cerrar el convenio?</label>
                                <select id="estadoConv" name="estadoConv" class="form-control js-example-basic-single" required="" >
                                    <option value="0" selected="">Seleccione el estado</option>
                                    <option value="aprobado"> SI </option>
                                    <option value="rechazado"> NO </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGuardarConvenio">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCerrarConvenio">Cerrar</button>
                    </div>
                </div>
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

@stack('scripts')

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Lamina/index.js?v0.0.1')}}"></script>
@endpush
