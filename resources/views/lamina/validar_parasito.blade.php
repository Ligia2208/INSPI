
@extends('layouts.main')

@section('title', 'Desglose de Láminas')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="height: 65px;" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Desglose de Láminas</h5></a>
            </div>

        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2 mt-5">
        <div class="page-content mb-5">
            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-window-plus titulo-grande"></i> Validar Control de Láminas </h2>

            <hr/>

            <div class="card card-custom card-sticky" id="kt_page_sticky_card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos Generales</h1>
                            <input type="hidden" id="id_ingreso" name="id_ingreso" class="form-control" required="" autofocus="" value="{{$datos->id}}">
                        </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-4">
                                <label for="fecha_recep" class="form-label fs-6">Fecha de Recepción</label>
                                <input type="date" id="fecha_recep" name="fecha_recep" class="form-control" required readonly value="{{$datos->fecha_recep}}" >
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-8">
                                <label for="centro_salud" class="form-label fs-6">Nombre del Laboratorio Supervisado</label>
                                <select name="centro_salud" class="form-control single-select" id="centro_salud" onchange="actualizarCodigoMicroscopista()" readonly>
                                    <option value="">Selecciona una Opción</option>
                                    @foreach($instituciones as $institucion)
                                    @if($institucion->id == $datos->centro_salud)
                                        <option value="{{ $institucion->id }}" data-unicodigo="{{ $institucion->unicodigo }}" selected>
                                            {{ $institucion->descripcion }}
                                        </option>
                                    @else
                                        <option value="{{ $institucion->id }}" data-unicodigo="{{ $institucion->unicodigo }}">
                                            {{ $institucion->descripcion }}
                                        </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="evento" class="form-label fs-6">Evento</label>
                                <select name="evento" class="form-control single-select" id="evento" readonly>
                                    <option value="">Selecciona una Opción</option>
                                    @foreach($eventos as $evento)
                                        @if($evento->id == $datos->id_evento)
                                            <option value="{{$evento->id}}" selected>{{$evento->descripcion}}</option>
                                        @else
                                            <option value="{{$evento->id}}">{{$evento->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="responsable" class="form-label fs-6">Responsable Recepción</label>
                                <select name="responsable" class="form-control single-select" id="responsable" readonly>
                                    <option value="">Selecciona una Opción</option>
                                    @foreach($responsables as $responsable)
                                        @if($responsable->usuario) {{-- Validamos que tenga usuario relacionado --}}
                                            @if($responsable->usuario_id == $datos->id_responsable)
                                                <option value="{{ $responsable->usuario_id }}" selected>{{ $responsable->usuario->name }}</option>
                                            @else
                                                <option value="{{ $responsable->usuario_id }}">{{ $responsable->usuario->name }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="fecha_recebcion" class="form-label fs-6">Fecha de Reporte:</label>
                                <input type="date" id="fecha_recebcion" name="fecha_recebcion" class="form-control" value="{{$datos->fecha_recebcion}}" required readonly> 
                                <div class="valid-feedback">Looks good!</div>
                            </div>



                            <div class="col-md-3 mt-2">
                                <label for="total_laminas" class="form-label fs-6">Total de Láminas</label>
                                <input type="number" id="total_laminas" name="total_laminas" class="form-control" value="{{$datos->total_laminas_recib}}" required readonly> 
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="total_laminas_super" class="form-label fs-6">Total de Láminas Recibidas</label>
                                <input type="number" id="total_laminas_super" name="total_laminas_super" class="form-control" required value="{{$datos->total_laminas}}" readonly>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="total_laminas_pos" class="form-label fs-6">Total de Láminas Positivas</label>
                                <input type="number" id="total_laminas_pos" name="total_laminas_pos" class="form-control" required readonly value="{{$datos->laminas_positivas_rec}}">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <label for="total_laminas_neg" class="form-label fs-6">Total de Láminas Negativas</label>
                                <input type="number" id="total_laminas_neg" name="total_laminas_neg" class="form-control" required value="{{$datos->laminas_negativas_rec}}" readonly>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="codigo" class="form-label fs-6">Código Microscopista Evaluado:</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" required readonly value="{{$datos->unicodigo}}">
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="mes_recepcion" class="form-label fs-6">Semana o Mes</label>
                                <input type="text" id="mes_recepcion" name="mes_recepcion" class="form-control" readonly value="{{$datos->mes_recepcion}}" required >
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="codigo_lec" class="form-label fs-6">Código del Lector:</label>
                                <input type="text" id="codigo_lec" name="codigo_lec" class="form-control" readonly required value="{{$datos->codigo_lec}}">
                            </div>

                            <div class="col-md-12 mt-2 mb-2">
                                <label for="observacion" class="form-label fs-6">Observación:</label>
                                <textarea id="observacion" name="observacion" class="form-control" rows="3" readonly required>{{$datos->observaciones}}</textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            
                        </div>
                    </div>
                </div>


                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Resultados del control de Láminas</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-2 col-lg-2">
                                <label for="puntuacion" class="form-label">Puntuación</label>
                                <input type="text" id="puntuacion" class="form-control" disabled readonly value="{{ number_format($datos->porcentaje_laminas, 2) }}%">
                            </div>
                            <div class="mb-2 col-lg-4">
                                <label for="interpretacion" class="form-label">Interpretación</label>
                                <input type="text" id="interpretacion" class="form-control" disabled readonly value="{{ $datos->interpretacion }}">
                            </div>
                            <div class="mb-2 col-lg-2">
                                <label for="porcentajeResult" class="form-label">Porcentaje Resultado</label>
                                <input type="text" id="porcentajeResult" class="form-control" disabled readonly value="{{ number_format($datos->resultado, 2) }}%">
                            </div>
                            <div class="mb-2 col-lg-2">
                                <label for="porcentajeEspe" class="form-label">Porcentaje Especie</label>
                                <input type="text" id="porcentajeEspe" class="form-control" disabled readonly value="{{ number_format($datos->especie, 2) }}%">
                            </div>
                            <div class="mb-2 col-lg-2">
                                <label for="porcentajeRecuen" class="form-label">Porcentaje Recuento</label>
                                <input type="text" id="porcentajeRecuen" class="form-control" disabled readonly value="{{ number_format($datos->recuentos, 2) }}%">
                            </div>
                        </div>

                    </div>
                </div>


                <div id="resultados-container" class="mt-4 card">
                    <div class="row card-body">

                        <div class="col-md-4 mt-2">
                            <label for="id_resultado" class="form-label fs-6">Resultado Cierre Caso<span class="text-danger">*</span></label>
                            <select name="id_resultado" class="form-control single-select" id="id_resultado">
                                <option value="">Selecciona una Opción</option>
                                @foreach($resultados as $resultado)
                                    <option value="{{ $resultado->id }}">{{ $resultado->descripcion }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group col-md-12 mt-4">
                            <label class="text-black"><b>Observación Responsable de la validación</b></label>
                            <div class="input-group input-group-solid">
                                <textarea id="observacion" class="form-control form-control-solid" placeholder="Ej: Datos relevantes a reportar" cols="30" rows="3"
                                ></textarea>
                            </div>
                        </div>


                    </div>
                </div>


            </div>





            <div class="col-lg-12 d-flex align-items-center justify-content-center mt-5">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" id="btnGuardarSolicitud" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Guardar
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/laminas_parasitologia_validar'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
            </div>

        </div>




    </div>

</div>





@endsection


@push('scripts')
<!-- Script personalizado -->
<script>
    const desgloseData = @json($desglose);
</script>
<script src="{{asset('assets/js/Lamina/validar_parasito.js?v0.0.0')}}"></script>
@endpush
