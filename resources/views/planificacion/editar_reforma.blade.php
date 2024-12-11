@extends('layouts.main')

@section('title', 'Editar Reforma')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Editar Reforma</h5></a>
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
            white-space: nowrap;
        }

    </style>

    <div class="container2">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <div class="col">
                    <!-- <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('categoria')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-category-alt' ></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Categoría</h4>
                                </div>

                            </div>
                        </div>
                    </div> -->
                </div>


            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> EDITAR REFORMA</h2>
            <hr/>
            <?php
                // var_dump($atributos);
            ?>

        <input type="hidden" id="id_reforma" value="{{ $id }}">

            <div class ="scroll_horizontal">
                <table class="table table-striped" style="background-color: white;" id="tblActividadesEditar">
                    <thead>
                        <tr>
                            <th>OPCIONES</th>
                            <th>ACTIVIDADES OPERATIVAS</th>
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
                        @foreach($atributos as $atributo)
                        <tr>
                            <input type="hidden" name="id_actividad[]" value="{{ $atributo->id_actividad }}">
                            <input type="hidden" name="solicitud[]" value="true">
                            <input type="hidden" name="id_area_soli[]" value="{{ $atributo->id_areaS }}">

                            <td>
                                <i type="button" class="font-22 fadeIn animated bx bx-trash" title="Eliminar actividad" onclick="eliminarFila(this)">
                                </i>
                            </td>
                            <td>{{ $atributo->nombreActividadOperativa}}</td>
                            <td>
                                <input class ="form-control" style="width: 350px;" type="text" name="subActividad[]" value="{{ $atributo->nombreSubActividad }}">
                            </td>
                            <td>{{ $atributo->nombreItem }}</td>
                            <td>{{ $atributo->descripcionItem }}</td>
                            <td class="width">
                                <select class ="form-select" name="tipo[]" onchange="cambioSelect(this)">
                                    @if($atributo->tipo == 'DISMINUYE')
                                        <option value="" selected disabled>Seleccionar tipo...</option>
                                        <option value="DISMINUYE" selected>Disminuye</option>
                                        <option value="AUMENTA">Aumenta</option>
                                    @elseif ($atributo->tipo == 'AUMENTA')
                                        <option value="" selected disabled>Seleccionar tipo...</option>
                                        <option value="DISMINUYE" >Disminuye</option>
                                        <option value="AUMENTA" selected>Aumenta</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <input class ="form-control" style="width: 125px;" type="text" name="enero1[]" value="{{ $atributo->enero}}">
                            </td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="febrero1[]" value="{{ $atributo->febrero}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="marzo1[]" value="{{ $atributo->marzo}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="abril1[]" value="{{ $atributo->abril}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="mayo1[]" value="{{ $atributo->mayo}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="junio1[]" value="{{ $atributo->junio}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="julio1[]" value="{{ $atributo->julio}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="agosto1[]" value="{{ $atributo->agosto}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="septiembre1[]" value="{{ $atributo->septiembre}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="octubre1[]" value="{{ $atributo->octubre}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="noviembre1[]" value="{{ $atributo->noviembre}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="diciembre1[]" value="{{ $atributo->diciembre}}"></td>
                            <td><input class ="form-control" style="width: 125px;" type="text" name="total1[]" value="{{ $atributo->total}}"></td>
                        </tr>
                        @endforeach
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


            <div id="formularioActividad" style="display: none;" class="mt-4">
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
                            <div class="col-md-12">
                                <label for="coordina" class="form-label fs-6">Coordinación/Dirección/Proyecto</label>
                                <input type="text" id="coordina" name="coordina" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha" class="form-label fs-6">Fecha</label>
                                <input type="date" id="fecha" name="fecha" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="poa" class="form-label fs-6">POA</label>
                                <select id="poa" name="poa" class="form-select single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($tipos as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mt-5" style="margin-left: 8%;">
                                <label for="plurianual" class="form-label fs-6">Plurianual</label>
                                <input type="checkbox" id="plurianual" name="plurianual" class="form-check-input">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                                <textarea id="justifi2" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-md-6">
                                <label for="obOpera" class="form-label fs-6">Objetivo Operativo</label>
                                <input type="text" id="obOpera" name="obOpera" class="form-control" required="" autofocus="" value="">
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
                                <select id="item_presupuestario" name="item_presupuestario" class="form-select" required onchange="fetchItemData(this.value)">
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($item_presupuestario as $item)
                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="monDisp" class="form-label fs-6">Monto Disponible del Item</label>
                                <input type="text" id="monDisp" name="monDisp" class="form-control" required="" autofocus="" value="" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-8 mt-2">
                                <label for="desItem" class="form-label fs-6">Descripción del Item Presupuestario</label>
                                <input type="text" id="desItem" name="desItem" class="form-control" required="" autofocus="" value="" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-md-4 mt-2">
                                <label for="unidad" class="form-label fs-6">Unidad ejecutora</label>
                                <select id="unidad_ejecutora" name="unidad_ejecutora" class="form-select" required></select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="programa" class="form-label fs-6">Programa</label>
                                <select id="programa" name="programa" class="form-select" required></select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="proyecto" class="form-label fs-6">Proyecto</label>
                                <select id="proyecto" name="proyecto" class="form-select" required></select>
                            </div>


                            <div class="col-md-6 mt-2">
                                <label for="actividad" class="form-label fs-6">Actividad</label>
                                <select id="actividad" name="actividad" class="form-select" required></select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="fuente_financiamiento" class="form-label fs-6">Fuente de financiamiento</label>
                                <select id="fuente_financiamiento" name="fuente_financiamiento" class="form-select" required></select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 d-flex align-items-center mt-3">
                    <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="guardarNuevaActividad()" style="margin-right: 2%">
                        <i class="bi bi-send-check"></i> Guardar Actividad
                    </a>

                    <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="cerrarFormulario()">
                        <i class="bi bi-x-circle"></i> Cerrar Actividad
                    </a>

                    <!-- <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="cancelarNuevaActividad()">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a> -->
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
                                <label for="czonal" class="form-label fs-6">Coordinación Zonal</label>
                                <select data-url="planificacion/getAreas" id="czonal" name="czonal" class="form-select single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($czonal as $z)
                                        <option value="{{ $z->id}}"> {{ $z->nombre}} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Por favor seleccione una Coordinación Zonal.</div>

                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="area" class="form-label fs-6">Area</label>
                                <select id="area" name="area" class="form-select single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione un Area.</div>
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
                                        <input type="hidden" name="id_poa[]" value="{{ $atributo->id_poa }}">
                                        <td>
                                            <i type="button" class="font-22 fadeIn animated bi bi-plus-square" title="Agregar actividad" onclick="CrearActArea(this)">
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

        @if(count($comentarios) > 0)
            <div class="card mb-5 mt-5">
                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-secondary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Comentarios sobre esta planificación</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    @foreach($comentarios as $index => $comentario)
                        <div class="mb-3 col-md-6">
                            <div class="mb-3 col-md-12 border rounded h-100">
                                <h5 class="text-align text-center mt-2">Comentario #{{$index + 1}}:</h5>
                                <p class="m-2 mb-3"><strong>Usuario:</strong> {{ $comentario->id_usuario }}</p>
                                <p class="m-2 mb-3"><strong>Comentario:</strong> {{ $comentario->comentario }}</p>
                                <p class="m-2 mb-3"><strong>Creación del comentario:</strong> {{ $comentario->created_at }}</p>
                                <p class="m-2 mb-1"><strong>Estado de la planificación:</strong>
                                    @if($comentario->estado_planificacion == 'Rechazado')
                                        <span class="m-2 mb-3 badge bg-warning  fs-6">{{ $comentario->estado_planificacion }}</span>
                                    @elseif($comentario->estado_planificacion == 'Ingresado')
                                        <span class="m-2 mb-3 badge bg-primary fs-6">{{ $comentario->estado_planificacion }}</span>
                                    @elseif($comentario->estado_planificacion == 'Aprobado')
                                        <span class="m-2 mb-3 badge bg-success fs-6">{{ $comentario->estado_planificacion }}</span>
                                    @elseif($comentario->estado_planificacion == 'Corregido')
                                        <span class="m-2 mb-3 badge bg-info fs-6">{{ $comentario->estado_planificacion }}</span>
                                    @else
                                        <!-- <p class="m-2 mb-3 badge"><strong>Estado de la planificación:</strong> {{ $comentario->estado_planificacion }}</p> -->
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

                <!-- Campo de justificación al final de la tabla -->
            <div style="margin-top: 20px; margin-bottom: 20px">
                <label for="justificacion">Justificación:</label>
                <textarea class="form-control" name="justificacion" id="justificacion" rows="3"></textarea>
            </div>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="actualizarReforma()" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Actualizar
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
<script src="{{asset('assets/js/Planificacion/edit_reforma.js?v0.0.6')}}"></script>
@endpush
