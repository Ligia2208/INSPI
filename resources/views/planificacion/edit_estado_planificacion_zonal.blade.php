@extends('layouts.main')

@section('title', 'Aprobar Planificación')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Aprobar Planificación</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">

            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-window-plus"></i> Verificar actividad </h2>

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

                <div class="card-body">

                    <div class="row p-2">

                        <div class="col-md-12" hidden>
                            <label for="coordina" class="form-label fs-6">ID</label>
                            <input type="text" id="id_poa" name="id_poa" class="form-control" required="" autofocus="" value="{{$atributos->id}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12">
                            <label for="coordina" class="form-label fs-6">Coordinación/Dirección/Proyecto</label>
                            <input type="text" id="coordina" name="coordina" class="form-control" required="" autofocus="" value="{{$atributos->departamento}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2" hidden>
                            <label for="nPOA" class="form-label fs-6">N° de POA</label>
                            <input type="text" id="nPOA" name="nPOA" class="form-control" required="" autofocus="" value="{{$atributos->numero}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="fecha" class="form-label fs-6">Fecha</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required="" autofocus="" value="{{$atributos->fecha}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>


                        <div class="col-md-4 mt-2">
                            <label for="poa" class="form-label fs-6">Tipo de Gasto</label>
                            <select id="poa" name="poa" class="form-control single-select" required="" disabled autofocus="">
                                <!-- <option value="0">Seleccione Opción</option> -->
                                @foreach($tipos as $tipo)
                                @if($tipo->id == $atributos->idPoa)
                                    <option value="{{$tipo->id}}" selected>{{$tipo->nombre}}</option>
                                @else
                                    <!-- <option value=""></option> -->
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <!--<div class="col-md-12 mt-2">
                            <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                            <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4" disabled>{{$atributos->justificacion}}</textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div> -->


                        <div class="col-md-2 mt-5" style="margin-left: 8%;">
                            <label for="plurianual" class="form-label fs-6">Plurianual</label>
                            <input type="checkbox" id="plurianual" name="plurianual" disabled class="form-check" {{ $atributos->plurianual ? 'checked' : '' }}>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                            <textarea id="justifi" name="justifi" class="form-control" disabled required="" autofocus="" rows="4">{{$atributos->justificacion}}</textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row p-2">

                        <div class="col-md-6">
                            <label for="obOpera" class="form-label fs-6">Objetivo Operativo</label>
                            <input type="text" id="obOpera" name="obOpera" class="form-control" required="" autofocus="" value="{{$atributos->nombreObjOperativo}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-6">
                            <label for="actOpera" class="form-label fs-6">Actividad Operativa</label>
                            <input type="text" id="actOpera" name="actOpera" class="form-control" required="" autofocus="" value="{{$atributos->nombreActividadOperativa}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="subActi" class="form-label fs-6">Sub Actividad / Objeto de Contratación / Convenio</label>
                            <input type="text" id="subActi" name="subActi" class="form-control" required="" autofocus="" value="{{$atributos->nombreSubActividad}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="item" class="form-label fs-6">Item presupuestario</label>
                            <select id="item_presupuestario" name="item_presupuestario" class="form-control" required onchange="fetchItemData(this.value)" disabled>
                                @foreach($item_presupuestario as $item)
                                @if($item->id == $atributos->id_item)
                                    <option value="{{$item->id}}" selected>{{$item->nombre}} - {{$item->descripcion}}</option>
                                @else
                                    <option value="{{$item->id}}">{{$item->nombre}} - {{$item->descripcion}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="monDisp" class="form-label fs-6">Monto Disponible del Item</label>
                            <input type="text" id="monDisp" name="monDisp" class="form-control" required="" autofocus="" value="{{$atributos->montoItem}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="desItem" class="form-label fs-6">Descripción del Item Presupuestario</label>
                            <input type="text" id="desItem" name="desItem" class="form-control" required="" autofocus="" value="{{$atributos->descripcionItem}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="monto" class="form-label fs-6">Monto</label>
                            <input type="number" id="monto" name="monto" class="form-control" required="" autofocus="" value="{{intval($atributos->monto)}}" disabled>
                            <div class="valid-feedback">¡Se ve bien!</div>
                            <div class="invalid-feedback">Ingrese solo números</div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="presupuesto_proyectado" class="form-label fs-6">Presupuesto proyectado</label>
                            <input type="number" id="presupuesto_proyectado" name="presupuesto_proyectado" class="form-control" required="" autofocus="" disabled value="{{intval($atributos->presupuesto_proyectado)}}">
                            <div class="valid-feedback">¡Se ve bien!</div>
                            <div class="invalid-feedback">Ingrese solo números</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row p-2">

                        <div class="col-md-4 mt-2">
                            <label for="unidad" class="form-label fs-6">Unidad ejecutora</label>
                            <select id="unidad_ejecutora" name="unidad_ejecutora" class="form-control" required disabled>
                                @foreach($unidad_eje as $unidad)
                                    @if($unidad->id == $atributos->u_ejecutora)
                                        <option value="{{$unidad->id}}" selected>{{$unidad->nombre}}</option>
                                    @else
                                        <option value="{{$unidad->id}}"> {{$unidad->nombre}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="programa" class="form-label fs-6">Programa</label>
                            <select id="programa" name="programa" class="form-control" required disabled>
                                @foreach($programa as $prog)
                                    @if($prog->id == $atributos->programa)
                                        <option value="{{$prog->id}}" selected>{{$prog->nombre}}</option>
                                    @else
                                        <option value="{{$prog->id}}"> {{$prog->nombre}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="proyecto" class="form-label fs-6">Proyecto</label>
                            <select id="proyecto" name="proyecto" class="form-control" required disabled>
                                @foreach($proyecto as $proy)
                                    @if($proy->id == $atributos->proyecto)
                                        <option value="{{$proy->id}}" selected>{{$proy->nombre}}</option>
                                    @else
                                        <option value="{{$proy->id}}"> {{$proy->nombre}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 mt-2">
                            <label for="actividad" class="form-label fs-6">Actividad</label>
                            <select id="actividad" name="actividad" class="form-control" required disabled>
                                @foreach($actividad as $act)
                                    @if($act->id == $atributos->actividad)
                                        <option value="{{$act->id}}" selected>{{$act->nombre}}</option>
                                    @else
                                        <option value="{{$act->id}}"> {{$act->nombre}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="fuente_financiamiento" class="form-label fs-6">Fuente de financiamiento</label>
                            <select id="fuente_financiamiento" name="fuente_financiamiento" class="form-control" required disabled>
                                @foreach($fuente as $fue)
                                    @if($fue->id == $atributos->fuente)
                                        <option value="{{$fue->id}}" selected>{{$fue->nombre}}</option>
                                    @else
                                        <option value="{{$fue->id}}"> {{$fue->nombre}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-5">
                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-info rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Cronograma de Devengamiento</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                <div class="row p-2">
                    <div class="col-md-4 mt-2">
                        <label for="frecuencia" class="form-label fs-6">Frecuencia</label>
                        <select id="frecuencia" name="frecuencia" class="form-select single-select" required disabled>
                            <option value="">Seleccione una frecuencia</option>
                            @foreach($tipoMonto as $tipoM)
                                <option value="{{ $tipoM->id }}" {{ $atributos->idTipoMonto == $tipoM->id ? 'selected' : '' }}>
                                    {{ $tipoM->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                    <div class="row p-2 mt-1">

                        <div class="col-md-3">
                            <label for="enero" class="form-label fs-6">Enero</label>
                            <input type="text" id="enero" name="enero" class="form-control" required="" autofocus="" value="{{$atributos->enero}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="febre" class="form-label fs-6">Febrero</label>
                            <input type="text" id="febre" name="febre" class="form-control" required="" autofocus="" value="{{$atributos->febrero}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="marzo" class="form-label fs-6">Marzo</label>
                            <input type="text" id="marzo" name="marzo" class="form-control" required="" autofocus="" value="{{$atributos->marzo}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3">
                            <label for="abril" class="form-label fs-6">Abril</label>
                            <input type="text" id="abril" name="abril" class="form-control" required="" autofocus="" value="{{$atributos->abril}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="mayo" class="form-label fs-6">Mayo</label>
                            <input type="text" id="mayo" name="mayo" class="form-control" required="" autofocus="" value="{{$atributos->mayo}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="junio" class="form-label fs-6">Junio</label>
                            <input type="text" id="junio" name="junio" class="form-control" required="" autofocus="" value="{{$atributos->junio}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="julio" class="form-label fs-6">Julio</label>
                            <input type="text" id="julio" name="julio" class="form-control" required="" autofocus="" value="{{$atributos->julio}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="agosto" class="form-label fs-6">Agosto</label>
                            <input type="text" id="agosto" name="agosto" class="form-control" required="" autofocus="" value="{{$atributos->agosto}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="septiem" class="form-label fs-6">Septiembre</label>
                            <input type="text" id="septiem" name="septiem" class="form-control" required="" autofocus="" value="{{$atributos->septiembre}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="octubre" class="form-label fs-6">Octubre</label>
                            <input type="text" id="octubre" name="octubre" class="form-control" required="" autofocus="" value="{{$atributos->octubre}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="noviem" class="form-label fs-6">Noviembre</label>
                            <input type="text" id="noviem" name="noviem" class="form-control" required="" autofocus="" value="{{$atributos->noviembre}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <label for="diciem" class="form-label fs-6">Diciembre</label>
                            <input type="text" id="diciem" name="diciem" class="form-control" required="" autofocus="" value="{{$atributos->diciembre}}" disabled>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($comentarios) > 0)
                    <div class="card mb-5">
                        <div class="card-head">
                            <div class="d-flex align-items-center p-3 text-white bg-success rounded shadow-sm">
                                <div class="lh-1">
                                    <h1 class="h3 mb-0 text-white lh-1">Comentarios sobre esta actividad</h1>
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

            <div class="card mb-5">
                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-warning rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Validación de la actividad</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="" disabled>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <!--Código de php para crear la lista de todos los comentarios que haya escrito ese usuario. Solo deberá mostrarse si-->
                    <!--es que se encuentra que el usuario tiene al menos un comentario. Si no existe ningún comentario, entonces esta lista-->
                    <!--de comentarios no debería ni mostrarse. Aquí debe hacerse un if (creo) y un for para recorrer los campos de cada comentario-->
                    <!--En el for debe estar el campo del usuario (id_usuario) del comentario en sí y de la fecha de creación, esto con la finalidad-->
                    <!--de mostrar en cada for dichos datos, para cada comentario encontrado-->
                    <div class="row">

                        <div class="col-md-4 mt-2">
                            <label for="frecuencia" class="form-label fs-6">Estado de comprobación de la actividad</label>
                            <select id="estadoPoa" name="estadoPoa" class="form-select single-select" required>
                                <option value="0" selected>Seleccione el estado de la actividad</option>
                                <option value="O"> Validado</option>
                                <option value="R"> Rechazado</option>
                            </select>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="montoCer" class="form-label fs-6 text-red">Monto A Certificar</label>
                            <input type="text" id="montoCer" name="montoCer" class="form-control disabled-red" required="" autofocus="" value="{{$atributos->certificado}}" disabled>
                        </div>

                        <div class="col-md-4 mt-2">
                            <label for="montoDis" class="form-label fs-6">Monto Disponibe del Item</label>
                            <input type="text" id="montoDis" name="montoDis" class="form-control" required="" autofocus="" value="">
                        </div>


                        <div class="col-md-12 mt-2">
                            <label for="justifi" class="form-label fs-6">Justificación de la selección</label>
                            <textarea id="justificacionPoa" name="justificacionPoa" class="form-control" required="" autofocus="" rows="4"></textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        
                    </div>


                </div>
            </div>

            <div class="col-lg-12 d-flex align-items-center justify-content-center">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="agregarComentarioEstadoZonal()" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Enviar revisión
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/planificacion/vistaUser'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
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
<script src="{{asset('assets/js/Planificacion/editPlanificacion.js?v0.0.10')}}"></script>
@endpush