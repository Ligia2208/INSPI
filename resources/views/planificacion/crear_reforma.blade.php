@extends('layouts.main')

@section('title', 'Crear Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Crear Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <style>

        table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            text-align: center;
            margin-bottom: 2%;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
        }
        .scroll_horizontal{
            overflow-x: auto;
        }
        .form-select, .form-control {
            width: 100%;
        }
        .width {
            width: 125px;
            white-space: break-spaces;
        }

    </style>

    <div class="container2">
        <div class="page-content">

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> CREAR REFORMA</h2>
            <hr/>

            <div class="row">

                <div class="col-lg-10 mt-2 mb-5">
                    <label for="select_idpoa" class="form-label">Seleccione Actividad Para la Reforma:</label>
                    <select id="select_idpoa" class="single-select filter">
                        <option value="">Seleccione una Sub_Actividad/Objeto de Contratación</option>
                        @foreach($atributos as $item)
                            <option value="{{ $item->id }}">{{ $item->nombreSubActividad }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-2 mt-2 mb-5">
                    <label class="form-label fs-6">&nbsp;</label>
                    <button onclick="agregarActividad()" id="btnAgregarActividad" class="btn btn-primary form-control"><i class="bi bi-file-plus mr-1"></i>Agregar Sub_Actividad</button>
                </div>

            </div>



            <div class ="scroll_horizontal">
                <table class="table table-striped" style="background-color: white;" id="tblActividades">
                    <thead>
                        <tr>
                            <th>OPCIONES</th>
                            <th style="width: 30px;">ACTIVIDADES OPERATIVAS</th>
                            <th>SUB-ACTIVIDAD/OBJETO DE CONTRATACIÓN</th>
                            <th>ITEM PRESUPUESTARIO</th>
                            <th>DESCRIPCIÓN DEL ITEM PRESUPUESTARIO</th>
                            <th class="width">TIPO DE INGRESO</th>
                            <th >ENERO</th>
                            <th >FEBRERO</th>
                            <th >MARZO</th>
                            <th >ABRIL</th>
                            <th >MAYO</th>
                            <th >JUNIO</th>
                            <th >JULIO</th>
                            <th >AGOSTO</th>
                            <th >SEPTIEMBRE</th>
                            <th >OCTUBRE</th>
                            <th >NOVIEMBRE</th>
                            <th>DICIEMBRE</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="width">

                    </tbody>
                </table>
            </div>

            <div class="row" id="contenedorBotonAgregarActividad">
            <hr type="hidden"/>
                <a style= "margin-left: 1%; margin-right: 1%" class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" onclick="mostrarFormularioActividad()" type="button">
                    <i class="lni lni-circle-plus" id="btnActividad"></i> Crear Actividad
                </a>
                <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" onclick="mostrarFormActArea()" type="button">
                    <i class="lni lni-circle-plus" id="btnActividadArea"></i> Agregar Actividad
                </a>
            </div>


            <!-- ==========================FORMULARIO PARA CREAR ACTIVIDAD EN REFORMA=============================== -->
            <div id="formularioActividad" style="display: none;" class="mt-4 mb-4">
                <div class="card">
                    <div class="card-head">
                        <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                            <div class="lh-1">
                                <h1 class="h3 mb-0 text-white lh-1">Nueva Actividad</h1>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row p-2">

                            <input value="{{$id_fuente}}" type="hidden" id="id_fuente">

                            <div class="col-md-6">
                                <label for="obOpera" class="form-label fs-6">Objetivo Operativo</label>
                                <select id="obOpera" name="obOpera" class="form-control single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($obj_Operativo as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-6">
                                <label for="actOpera" class="form-label fs-6">Actividad Operativa</label>
                                <input type="text" id="actOpera" name="actOpera" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="subActi" class="form-label fs-6">Sub Actividad / Objeto de Contratación</label>
                                <input type="text" id="subActi" name="subActi" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="item_presupuestario" class="form-label fs-6">Item presupuestario</label>
                                <select id="item_presupuestario" name="item_presupuestario" class="form-control single-select" required onchange="fetchItemData(this.value)">
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($item_presupuestario as $item)
                                        <option value="{{$item->id}}" data-id_item="{{$item->id_item}}" >{{$item->nombre}} - {{$item->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="monDisp" class="form-label fs-6">Monto Disponible del Item</label>
                                <input type="text" id="monDisp" name="monDisp" class="form-control" required="" autofocus="" value="" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="proceso" class="form-label fs-6">Tipo de Proceso</label>
                                <select id="proceso" name="proceso" class="form-control single-select" required >
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($proceso as $tipo)
                                    <option value="{{$tipo->id}}"> {{$tipo->nombre}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="card mt-3">

                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-md-12">
                                <label for="coordina" class="form-label fs-6">Coordinación/Dirección/Proyecto</label>
                                <input type="text" id="coordina" name="coordina" class="form-control" required="" autofocus="" value="{{$nombre}}" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha" class="form-label fs-6">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="poa" class="form-label fs-6">Tipo de Gasto</label>
                                <select id="poa" name="poa" class="form-control single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mt-5" style="margin-left: 8%;">
                                <label for="plurianual" class="form-label fs-6">Plurianual</label>
                                <input type="checkbox" id="plurianual" name="plurianual" class="form-check">
                            </div>

                            <!-- <div class="col-md-12 mt-2">
                                <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                                <textarea id="justifi2" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div> -->
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-4 mt-2">
                                <label for="unidad_ejecutora" class="form-label fs-6">Unidad ejecutora</label>
                                <select id="unidad_ejecutora" name="unidad_ejecutora" class="form-control single-select" required disabled></select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="programa" class="form-label fs-6">Programa</label>
                                <select id="programa" name="programa" class="form-control single-select" required disabled></select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="proyecto" class="form-label fs-6">Proyecto</label>
                                <select id="proyecto" name="proyecto" class="form-control single-select" required disabled></select>
                            </div>


                            <div class="col-md-6 mt-2">
                                <label for="actividad" class="form-label fs-6">Actividad</label>
                                <select id="actividad" name="actividad" class="form-control single-select" required disabled></select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="fuente_financiamiento" class="form-label fs-6">Fuente de financiamiento</label>
                                <select id="fuente_financiamiento" name="fuente_financiamiento" class="form-control single-select" required disabled></select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12 d-flex align-items-center mt-3">
                    <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="crearReformaConActividades()" style="margin-right: 2%">
                        <i class="bi bi-send-check"></i> Guardar Actividad
                    </a>

                    <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="cerrarFormulario()">
                        <i class="bi bi-x-circle"></i> Cerrar Actividad
                    </a>
                </div>
            </div>




            <!-- ==========================FORMULARIO PARA AGREGAR ACTIVIDAD EXISTENTE DE OTRA ÁREA=============================== -->
            <div id="formularioActArea" style="display: none;" class="mt-4">
                <div class="card">
                    <div class="card-head">
                        <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                            <div class="lh-1">
                                <h1 class="h3 mb-0 text-white lh-1">Añadir actividad por Dirección</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row p-2">

                            <div class="col-md-4 mt-2">
                                <label for="area" class="form-label fs-6">Direcciones</label>
                                <select id="area" name="area" class="form-select single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($direcciones as $direccion)
                                    <option value="{{$direccion->id}}">{{$direccion->nombre}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Dirección.</div>
                            </div>
                        </div>

                        <div id="tblActArea" style="display: none;" class="mt-3">
                            <table class="table table-striped" style="background-color: white; padding">
                                <thead>
                                    <tr>
                                        <th>OPCIONES</th>
                                        <th>DEPARTAMENTO</th>
                                        <th>ACTIVIDADES OPERATIVAS</th>
                                        <th>SUB-ACTIVIDAD/OBJETO DE CONTRATACIÓN</th>
                                        <th>ITEM PRESUPUESTARIO</th>
                                        <th>DESCRIPCIÓN DEL ITEM PRESUPUESTARIO</th>
                                    </tr>
                                </thead>
                                <tbody class="width">
                                    @foreach($atributos as $atributo)
                                    <tr>
                                        <input type="hidden" name="id_poa[]" value="{{ $atributo->id }}">
                                        <td>
                                            <i type="button" class="font-22 fadeIn animated bi bi-plus-square" title="Agregar actividad" onclick="agregarActAreaFila(this)">
                                            </i>
                                        </td>
                                        <td>{{ $atributo->departamento}}</td>
                                        <td>{{ $atributo->nombreActividadOperativa}}</td>
                                        <td>{{ $atributo->nombreSubActividad }}</td>
                                        <td>{{ $atributo->nombreItem }}</td>
                                        <td>{{ $atributo->descripcionItem }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <div class="col-lg-12 d-flex align-items-center mt-3">

                    <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="cerrarFormularioAct()">
                        <i class="bi bi-x-circle"></i> Cerrar
                    </a>

                    <!-- <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="cancelarNuevaActividad()">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a> -->
                </div>

            </div>





        <div class="col-md-12 mt-2" style="margin-bottom: 20px">
            <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
            <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
            <div class="valid-feedback">Looks good!</div>
        </div>

        <!-- Campo de justificación al final de la tabla -->
        <!--<div style="margin-top: 20px; margin-bottom: 20px">
            <label for="justificacion">Justificación:</label>
            <textarea class="form-control" name="justificacion" id="justificacion" rows="3"></textarea>
        </div>
        -->

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="guardarReforma()" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Registrar
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/planificacion/reformaIndex'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
            </div>

    </div>

</div>

@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/create_reforma.js?v0.0.8')}}"></script>
@endpush
