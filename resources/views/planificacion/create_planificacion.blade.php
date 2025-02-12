
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

    @if($id_fuente == '' || $monto == false || $montoDir == 0)

    <div class="container2">

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">¡Acción requerida!</h4>
            @if($monto == false)
            <p>El monto presupuestado de su dirección no coincide con el monto asignado a sus ítems presupuestarios. Por favor, revise y corrija esta discrepancia antes de continuar.</p>
            @endif
            <hr>
            @if($id_fuente == '')
            <p class="mb-0">No ha seleccionado una estructura presupuestaria. Complete este paso para proceder.</p>
            @endif
            <hr>
            @if($montoDir == 0)
            <p class="mb-0">No puede crear una actividad hasta que su Área tenga un monto asignado.</p>
            @endif
        </div>

        <a class="col-2 btn btn-danger px-1 d-flex align-items-center justify-content-center mt-4" href="{{ route('itemPresupuestario.monto_item') }}" type="button" >
            <i class="bi bi-arrow-return-left"></i> Regresar
        </a>

    </div>

    @else

    <div class="container2">
        <div class="page-content mb-5">
            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-window-plus titulo-grande"></i> Creación de Actividad Operativa </h2>

            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Plan Operativo Anual</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-6">
                                <label for="obOpera" class="form-label fs-6">Objetivo Operativo</label>

                                <select id="obOpera" name="item_presupuestario" class="form-control single-select" required>
                                    <option value="0">Seleccione Opción</option>
                                    @foreach($objExistente as $obj)
                                        <option value="{{$obj->id}}">{{$obj->nombre}}</option>
                                    @endforeach
                                </select>

                                <!--
                                <input type="text" id="obOpera" name="obOpera" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                                -->
                                
                            </div>

                            <div class="col-md-6">
                                <label for="actOpera" class="form-label fs-6">Actividad Operativa</label>
                                <input type="text" id="actOpera" name="actOpera" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="subActi" class="form-label fs-6">Sub Actividad / Objeto de Contratación / Convenio</label>
                                <input type="text" id="subActi" name="subActi" class="form-control" required="" autofocus="" value="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>


                            <div class="col-md-4 mt-2">
                                <label for="item" class="form-label fs-6">Item presupuestario</label>
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

                            <!--
                            <div class="col-md-4 mt-2">
                                <label for="desItem" class="form-label fs-6">Descripción del Item Presupuestario</label>
                                <input type="text" id="desItem" name="desItem" class="form-control" required="" autofocus="" value="" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            -->

                            <div class="col-md-4 mt-2">
                                <label for="monto" class="form-label fs-6">Monto</label>
                                <input type="number" id="monto" name="monto" class="form-control" required="" autofocus="" value="0" onchange="">
                                <div class="valid-feedback">¡Se ve bien!</div>
                                <div class="invalid-feedback">Ingrese solo números</div>
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

                            <!-- <div class="col-md-4 mt-2">
                                <label for="presupuesto_proyectado" class="form-label fs-6">Presupuesto proyectado</label>
                                <input type="number" id="presupuesto_proyectado" name="presupuesto_proyectado" class="form-control" required="" autofocus="" value="0">
                                <div class="valid-feedback">¡Se ve bien!</div>
                                <div class="invalid-feedback">Ingrese solo números</div>
                            </div> -->

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row p-2">

                        <input value="{{$id_fuente}}" type="hidden" id="id_fuente">

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
                            <select id="poa" name="poa" class="form-control single-select" required >
                                <option value="0">Seleccione Opción</option>
                                @foreach($tipos as $tipo)
                                <option value="{{$tipo->id}}"> {{$tipo->nombre}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mt-5" style="margin-left: 8%;">
                            <label for="plurianual" class="form-label fs-6">Plurianual</label>
                            <input type="checkbox" id="plurianual" name="plurianual" class="form-check">
                        </div>

                        <!--
                        <div class="col-md-12 mt-2">
                            <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                            <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        -->

                    </div>

                </div>
            </div>



            <div class="card">
                <div class="card-body">
                    <div class="row p-2">

                        <div class="col-md-4 mt-2">
                            <label for="unidad" class="form-label fs-6">Unidad ejecutora</label>
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

            <div class="card mb-5">
                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-info rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Cronograma de Devengamiento</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="">
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row p-2">
                        <div class="col-md-4 mt-2">
                            <label for="frecuencia" class="form-label fs-6">Frecuencia</label>
                            <select id="frecuencia" name="frecuencia" class="form-select single-select" required >
                                <option selected="" value="0">Seleccione Frecuencia</option>
                                <option value="7"> Personalizado </option>
                                <option value="8"> En 0 </option>
                                <option value="1"> Mensual </option>
                                <option value="2"> Bimensual </option>
                                <option value="3"> Trimestral </option>
                                <option value="4"> Cuatrimestral </option>
                                <option value="5"> Semestral </option>
                                <option value="6"> Anual </option>
                            </select>
                        </div>
                    </div>

                    <div class="row p-2 mt-1">

                        <div class="col-md-3">
                            <label for="enero" class="form-label fs-6">Enero</label>
                            <input type="text" id="enero" name="enero" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="febre" class="form-label fs-6">Febrero</label>
                            <input type="text" id="febre" name="febre" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="marzo" class="form-label fs-6">Marzo</label>
                            <input type="text" id="marzo" name="marzo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="abril" class="form-label fs-6">Abril</label>
                            <input type="text" id="abril" name="abril" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="mayo" class="form-label fs-6">Mayo</label>
                            <input type="text" id="mayo" name="mayo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="junio" class="form-label fs-6">Junio</label>
                            <input type="text" id="junio" name="junio" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="julio" class="form-label fs-6">Julio</label>
                            <input type="text" id="julio" name="julio" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="agosto" class="form-label fs-6">Agosto</label>
                            <input type="text" id="agosto" name="agosto" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="septiem" class="form-label fs-6">Septiembre</label>
                            <input type="text" id="septiem" name="septiem" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="octubre" class="form-label fs-6">Octubre</label>
                            <input type="text" id="octubre" name="octubre" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="noviem" class="form-label fs-6">Noviembre</label>
                            <input type="text" id="noviem" name="noviem" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="diciem" class="form-label fs-6">Diciembre</label>
                            <input type="text" id="diciem" name="diciem" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="guardarPlanificacion()" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Guardar
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/planificacion/vistaUser'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
            </div>

        </div>




    </div>

    @endif

</div>


    <div class="modal fade" id="addCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Artículo</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="col-md-12">
                            <label for="nameArticulo" class="form-label fs-6">Nombre del artículo</label>
                            <input type="text" id="nameArticulo" name="nameArticulo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="precioArticulo" class="form-label fs-6">Precio del Artículo</label>
                            <input type="text" id="precioArticulo" name="precioArticulo" class="form-control" required autofocus value="">
                            <div class="valid-feedback">¡Se ve bien!</div>
                            <div class="invalid-feedback">Ingrese solo números</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="categoriaArti" class="form-label fs-6">Seleccione la Categoría</label>
                            <select id="categoriaArti" name="categoriaArti" class="form-select single-select" required>
                                <option value="0">Seleccione Opción</option>
                                        <option value="">  </option>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnArticulo">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="contModalUpdateCategoria">
    </div>



@endsection

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

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/create_planificacion.js?v0.0.9')}}"></script>
@endpush
