
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
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button id="btnGenerateExcel" class="btn btn-primary form-control"><i class="bi bi-file-earmark-spreadsheet mr-1"></i>Generar POA Excel</button>
                </div>
            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> LISTA DE ACTIVIDADES </h2>
            <hr/>
            <div id="contModalComentarios">
            </div>

            <div class="card">

                <div class="card-body">


                    <div class="row">

                        <div class="col-lg-6">
                            <label for="filterEstado" class="form-label">Filtrar por Estados:</label>
                            <select id="filterEstado" class="form-control js-example-basic-single mt-2">
                                <option value="">Todos los Estados</option>
                                <option value="A">Registrado</option>
                                <option value="O">Aprobado</option>
                                <option value="R">Rechazado</option>
                                <!-- <option value="C">Corregido</option> -->
                                <option value="S">Solicitado</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="filterDireccion" class="form-label">Filtrar por Direcciones:</label>
                            <select id="filterDireccion" class="form-control js-example-basic-single mt-2">
                                <option value="">Todas las Direcciones</option>
                                @foreach($direcciones as $direccion)
                                    <option value="{{ $direccion->departamento }}">{{ $direccion->departamento }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-4 mb-5">
                            <label for="filterItem" class="form-label">Filtrar por Item:</label>
                            <select id="filterItem" class="js-example-basic-single filter">
                                <option value="">Todos</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-4 mb-5">
                            <label for="filterPrograma" class="form-label">Filtrar por Programa:</label>
                            <select id="filterPrograma" class="js-example-basic-single filter">
                                <option value="">Todos</option>
                                @foreach($programas as $programa)
                                    <option value="{{ $programa->nombre }}">{{ $programa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>


                    <div class="table-responsive">
                        <table id="tblPlanificacionIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Item</th>
                                    <th>Objetivo Operativo</th>
                                    <th>Actividad Operativa</th>
                                    <th>Sub actividad</th>
                                    <th>Tipo de Proceso</th>
                                    <th>Monto</th>
                                    <th>N° POA</th>
                                    <th>Fecha</th>
                                    <th> <center> Estado </center></th>
                                    <th>Revisión</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" class="text-end">Total:</th>
                                    <th id="totalMonto"></th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
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
<script src="{{asset('assets/js/Planificacion/init_poa.js?v0.0.12')}}"></script>
<script src="{{asset('assets/js/Planificacion/calculadora.js?v0.0.0')}}"></script>
@endpush
