@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Planificacion/revision_reforma.js?v0.0.6')}}"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

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


<div class="page-wrapper">
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

        <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> REVISIÓN REFORMA</h2>
        <hr/>
        <?php
            // var_dump($atributos);
        ?>

    <input type="hidden" id="id_reforma" value="{{ $id }}">

        <div class ="scroll_horizontal">
            <table class="table table-striped" style="background-color: white;">
                <thead>
                    <tr>
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
                        <td>{{ $atributo->nombreActividadOperativa}}</td>
                        <td>{{ $atributo->nombreSubActividad }}</td>
                        <td>{{ $atributo->nombreItem }}</td>
                        <td>{{ $atributo->descripcionItem }}</td>
                        <td class="width">
                            <select disabled class ="form-select" name="tipo[]">
                                @if($atributo->tipo == 'DISMINUYE')
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="DISMINUYE" selected>Disminuye</option>
                                    <option value="AUMENTA">Aumenta</option>
                                @elseif ($atributo->tipo == 'AUMENTA')
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="DISMINUYE" >Disminuye</option>
                                    <option value="AUMENTA" selected>Aumenta</option>
                                @endif
                            </select>
                        </td>



                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="enero_R[]" value="{{ $atributo->enero}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="febrero_R[]" value="{{ $atributo->febrero}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="marzo_R[]" value="{{ $atributo->marzo}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="abril_R[]" value="{{ $atributo->abril}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="mayo_R[]" value="{{ $atributo->mayo}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="junio_R[]" value="{{ $atributo->junio}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="julio_R[]" value="{{ $atributo->julio}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="agosto_R[]" value="{{ $atributo->agosto}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="septiembre_R[]" value="{{ $atributo->septiembre}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="octubre_R[]" value="{{ $atributo->octubre}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="noviembre_R[]" value="{{ $atributo->noviembre}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="diciembre_R[]" value="{{ $atributo->diciembre}}"></td>
                        <td><input disabled class ="form-control" style="width: 125px;" type="text" name="total_R[]" value="{{ $atributo->total}}"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <div class="col-md-12 mt-2" style="margin-bottom: 20px">
        <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
        <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4" disabled>{{ $justifi->justificacion}}</textarea>
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
            <select id="estadoReforma" name="estadoPeforma" class="form-select single-select" required>
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

@endsection


