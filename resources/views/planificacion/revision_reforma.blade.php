
@extends('layouts.main')

@section('title', 'Revisión de Reforma')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Revisión de Reforma</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

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

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bi bi-table'></i> REVISIÓN REFORMA</h2>
            <hr/>
            <?php
                // var_dump($atributos);
            ?>

        <input type="hidden" id="id_reforma" value="{{ $id }}">

        <div class="scroll_horizontal">

            <div class="d-flex align-items-center p-3 text-white bg-info rounded shadow-sm">
                <div class="lh-1">
                    <h1 class="h3 mb-0 text-white lh-1">
                        Reforma de tipo {{ $justifi->tipo == 'M' ? 'Modificación PAPP' : ($justifi->tipo == 'R' ? 'Reforma PAPP/Presupuestaria' : 'Indefinido') }}
                    </h1>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" style="background-color: white;" id="tblActividades">
                    <thead>
                        <tr>
                            <th>UNIDAD</th>
                            <th>PROGRAMA</th>
                            <th>PROYECTO</th>
                            <th>ACTIVIDAD</th>
                            <th>FUENTE</th>
                            <th style="min-width: 250px;">DIRECCIÓN</th>
                            <th style="min-width: 300px;">SUB-ACTIVIDAD/OBJETO DE CONTRATACIÓN</th>
                            <th style="min-width: 300px;">SUB-ACTIVIDAD/MODIFICADA</th>
                            <th>ITEM PRESUPUESTARIO</th>
                            <th>DESCRIPCIÓN DEL ITEM PRESUPUESTARIO</th>
                            <th style="min-width: 120px;">TIPO DE INGRESO</th>
                            <th>TOTAL</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($atributos as $atributo)
                        <tr>
                            <input type="hidden" name="id_actividad[]" value="{{ $atributo->id_actividad }}">
                            <td>{{ $atributo->u_ejecutora}}</td>
                            <td>{{ $atributo->programa}}</td>
                            <td>{{ $atributo->proyecto}}</td>
                            <td>{{ $atributo->actividad}}</td>
                            <td>{{ $atributo->fuente}}</td>

                            <td>{{ $atributo->direccion}}</td>
                            <td>{{ $atributo->nombreSubActividad }}</td>
                            <td class="text-warning">{{ $atributo->sub_actividad }}</td>
                            <td>{{ $atributo->nombreItem }}</td>
                            <td>{{ $atributo->descripcionItem }}</td>
                            <td class="width">
                                <select disabled class="form-control" name="tipo[]">
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="DISMINUYE" {{ $atributo->tipo == 'DISMINUYE' ? 'selected' : '' }}>Disminuye</option>
                                    <option value="AUMENTA" {{ $atributo->tipo == 'AUMENTA' ? 'selected' : '' }}>Aumenta</option>
                                    <option value="IGUAL" {{ $atributo->tipo == 'IGUAL' ? 'selected' : '' }}>Igual</option>
                                    <option value="AJUSTE" {{ $atributo->tipo == 'AJUSTE' ? 'selected' : '' }}>Ajuste</option>
                                </select>
                            </td>

                            @foreach(['total'] as $mes)
                                <td>
                                    @if($atributo->tipo == 'DISMINUYE' && (float)$atributo->$mes > 0)
                                        <input disabled class="form-control disabled-red" style="width: 125px;" type="text" name="{{ $mes }}_R[]" value="{{ $atributo->$mes }}">
                                    @elseif($atributo->tipo == 'AUMENTA' && (float)$atributo->$mes > 0)
                                        <input disabled class="form-control disabled-green" style="width: 125px;" type="text" name="{{ $mes }}_R[]" value="{{ $atributo->$mes }}">
                                    @else
                                        <input disabled class="form-control" style="width: 125px;" type="text" name="{{ $mes }}_R[]" value="{{ $atributo->$mes }}">
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div class="col-lg-12 row">

            <div class="col-md-6">
                <label for="disTotal" class="form-label fs-6">Total Disminuye</label>
                <input type="text" id="disTotal" name="disTotal" class="form-control disabled-red" required="" autofocus="" value="" disabled="">
                <div class="valid-feedback">Looks good!</div>
            </div>

            <div class="col-md-6">
                <label for="aumTotal" class="form-label fs-6">Total Aumenta</label>
                <input type="text" id="aumTotal" name="aumTotal" class="form-control disabled-green" required="" autofocus="" value="" disabled="">
                <div class="valid-feedback">Looks good!</div>
            </div>

        </div>

        <div class="col-md-12 mt-2" style="margin-bottom: 20px">
            <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
            <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4" disabled>{{ $justifi->justificacion_area}}</textarea>
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

        <div class="" style="margin-bottom: 2%;">
            <div class="col-md-4 mt-2">
                <label for="estadoReforma" class="form-label fs-6">Estado de comprobación de la reforma</label>
                <select id="estadoReforma" name="estadoPeforma" class="form-control single-select" required>
                    <option value="0" selected>Seleccione el estado de la reforma</option>
                    <option value="O"> Aprobado</option>
                    <option value="R"> Rechazado</option>
                    <!-- <option value="C"> Corregido</option> -->
                    <!-- <option value="4"> Cuatrimestral </option>
                    <option value="5"> Semestral </option>
                    <option value="6"> Anual </option>  -->
                </select>
            </div>
        </div>


        <!-- Campo de justificación al final de la tabla -->
        <div style="margin-top: 20px; margin-bottom: 20px">
            <label for="justificacion_Reforma">Justificación de la selección:</label>
            <textarea class="form-control" name="justificacion_Reforma" id="justificacion_Reforma" rows="3"></textarea>
        </div>

        <div class="col-lg-12 d-flex align-items-center justify-content-center">
            <a class="col-2 btn btn-primary px-1 mb-5" type="button" onclick="agregarComentarioReforma()" style="margin-right: 2%">
                <i class="bi bi-send-check"></i> Enviar
            </a>

            <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/planificacion/reformaPrincipal'">
            <i class="bi bi-caret-left"></i> Regresar
            </a>
        </div>

    </div>

</div>

@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Planificacion/revision_reforma.js?v0.0.9')}}"></script>
@endpush