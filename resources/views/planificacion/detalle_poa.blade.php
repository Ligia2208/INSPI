@extends('layouts.main')

@section('title', 'Detalle Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Detalle Planificación2</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> DETALLE DE PAPP </h2>

            <div class="row mt-4">

                <div class="col-md-2">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button id="btnGeneratePDF" class="btn btn-primary form-control"><i class="bi bi-filetype-pdf mr-1"></i>Generar PDF</button>
                </div>
                <div class="col-md-2">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button id="btnGenerateExcel" class="btn btn-primary form-control"><i class="bi bi-file-earmark-spreadsheet mr-1"></i>Generar Excel</button>
                </div>

                <div class="col-md-2">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button class="btn btn-primary form-control" onclick="prueba()">Suma</button>
                </div>

                <input type="number" value="0" class="form-control" name="valor1" id="valor1" >
                <input type="number" value="0" class="form-control" name="valor2" id="valor2" >

                <div class="col-md-2">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button class="btn btn-primary form-control" onclick="prueba2()">Mostrar Texto</button>

                </div>

                <input type="text" class="form-control" name="text1" id="text1" >

                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <h2 class="text-success"> <i class="bi bi-layer-forward"></i> Total Items: </h2> <h1 class="ml-2">{{$sumaMontos}}</h1>
                </div>

                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <h2 class="text-danger"> <i class="bi bi-layer-backward"></i> Total Actividades: </h2> <h1 class="ml-2"> {{$sumaActividades}} </h1>
                </div>
            </div>


            <hr/>

            <div class="card">
                <div class="card-body">

                    <div class="filters row">
                        <div class="col-lg-4">
                            <label for="filterAnio" class="form-label">Año:</label>
                            <select id="filterAnio" class="basic-single filter">

                            </select>
                        </div>

                        <div class="col-lg-8">
                            <label for="filterDireccion" class="form-label">Dirección:</label>
                            <select id="filterDireccion" class="basic-single filter">
                                <option value="">Todas</option>
                                @foreach($direcciones as $direccion)
                                    <option value="{{ $direccion->id }}">{{ $direccion->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <label for="filterItem" class="form-label">Item:</label>
                            <select id="filterItem" class="basic-single filter">
                                <option value="">Todos</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }} - {{ $item->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <label for="filterSubActividad" class="form-label">Sub Actividad:</label>
                            <select id="filterSubActividad" class="basic-single filter">
                                <option value="">Todas</option>
                                @foreach($sub_actividades as $sub_actividad)
                                    <option value="{{ $sub_actividad->id }}">{{ $sub_actividad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-6 mt-2">
                            <label for="filterUnidad" class="form-label">Unidad Ejecutora:</label>
                            <select id="filterUnidad" class="basic-single filter">
                                <option value="">Todas</option>
                                @foreach($unidades as $unidad)
                                    <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <div class="table-responsive mt-6">
                        <table id="tblPlanificacionDetalle" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Area</th>

                                    <th>Unidad</th>
                                    <th>Programa</th>
                                    <th>Proyecto</th>
                                    <th>Actividad</th>
                                    <th>Unidad</th>

                                    <th>Tipo de POA</th>
                                    <th>Obj. Operativo</th>
                                    <th>Act. Operativa</th>
                                    <th>Sub Actividad</th>
                                    <th>Item</th>
                                    <th>Total/Item</th>
                                    <th>Total</th>
                                    <th>Ene</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Abr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Ago</th>
                                    <th>Sept</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dic</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Ene</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Abr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Ago</th>
                                    <th>Sept</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dic</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <a id="btnModalReportPOA" data-toggle="modal" data-target="#addReportDetalle" class="d-none"></a>

        <div class="modal fade" id="addReportDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de PAPP</h5>
                        <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent">
                            <div class="row">
                                <div class="col-md-4 mt-1">
                                    <label for="creado" class="form-label fs-6">Usuario que elabora</label>
                                    <input type="text" id="elabora" name="elabora" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_creado" class="form-label fs-6 mt-2">Cargo</label>
                                    <input type="text" id="cargo_elabora" name="cargo_elabora" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                                <div class="col-md-4 mt-1">
                                    <label for="autorizado" class="form-label fs-6">Usuario que revisa</label>
                                    <input type="text" id="revisa" name="revisa" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_autorizado" class="form-label fs-6 mt-2">Cargo</label>
                                    <input type="text" id="cargo_revisa" name="cargo_revisa" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>

                                <div class="col-md-4 mt-1">
                                    <label for="reporta" class="form-label fs-6">Usuario que aprueba</label>
                                    <input type="text" id="aprueba" name="aprueba" class="form-control" placeholder="Ingrese nombre de usuario" required>
                                    <div class="invalid-feedback">Por favor ingrese el nombre.</div>

                                    <label for="cargo_reporta" class="form-label fs-6 mt-2">Cargo</label>
                                    <input type="text" id="cargo_aprueba" name="cargo_aprueba" class="form-control" placeholder="Ingrese el cargo" required>
                                    <div class="invalid-feedback">Por favor ingrese el cargo.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnGenerarReportPOA">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCerrarModalPOA" data-dismiss="modal">Cerrar</button>
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

    <div class="modal fade " id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tipos de encuestas</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                <div id="modalContent">
                <!-- Aquí se mostrarán los datos -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<script src="{{asset('assets/js/Planificacion/init_detalle.js?v0.0.4')}}"></script>
@endpush