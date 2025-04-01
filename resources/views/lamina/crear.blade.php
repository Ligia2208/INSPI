
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
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Ingresar Láminas</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">
            <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-window-plus titulo-grande"></i> Ingreso de Láminas </h2>

            <hr/>

            <div class="card">

                <div class="card-head">
                    <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                        <div class="lh-1">
                            <h1 class="h3 mb-0 text-white lh-1">Datos Generales</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="">
                        </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-4">
                                <label for="fecha_recep" class="form-label fs-6">Fecha de Recepción</label>
                                <input type="date" id="fecha_recep" name="fecha_recep" class="form-control" required autofocus value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-8">
                                <label for="centro_salud" class="form-label fs-6">Nombre del Laboratorio Supervisado</label>
                                <select id="centro_salud" name="centro_salud" class="form-control single-select" required>
                                    <option value="0">Seleccione un Centro de Salud</option>
                                    @foreach($instituciones as $institucion)
                                    <option value="{{$institucion->id}}">{{$institucion->nombre}} - {{ $institucion->canton }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="responsable" class="form-label fs-6">Responsable Recepción</label>
                                <select id="responsable" name="responsable" class="form-control single-select" required>
                                    <option value="0">Seleccione un Responsable</option>
                                    @foreach($responsables as $responsable)
                                    <option value="{{$responsable->usuario_id}}">{{$responsable->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="analista" class="form-label fs-6">Analista(Encargado de Control de Calidad)</label>
                                <select id="analista" name="analista" class="form-control single-select" required>
                                    <option value="0">Seleccione un Responsable</option>
                                    @foreach($responsables as $responsable)
                                    <option value="{{$responsable->usuario_id}}">{{$responsable->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="mes_recepcion" class="form-label fs-6">Mes Supervisado</label>
                                <input type="text" id="mes_recepcion" name="mes_recepcion" class="form-control" required disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="total_laminas" class="form-label fs-6">Total de Láminas</label>
                                <input type="number" id="total_laminas" name="total_laminas" class="form-control" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Evaluación de Láminas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">1. Láminas empacadas en cajas de láminas portaobjetos y separadas entre ellas</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_empacadas" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_empacadas" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">2. Láminas con información legible y enumeradas en forma consecutiva</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_legibles" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_legibles" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">3. Las láminas sin identificación de su resultado</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_sin_id" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_sin_id" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">4. Láminas sin exceso de aceite de inmersión</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_sin_aceite" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_sin_aceite" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">5. Láminas con frotis adecuado (tinción y dimensiones estables en el manual de baciloscopía)</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_frotis_adecuado" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_frotis_adecuado" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">6. Láminas íntegras sin rajaduras que afecten al frotis</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_integras" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_integras" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">7. Láminas con documentación respectiva (listado con el número y resultado de cada lámina)</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_documentacion" value="true" required>
                                    <label class="form-check-label">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="laminas_documentacion" value="false">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12 mt-5">
                                <label class="form-label fw-bold"><strong>Observaciones</strong></label>
                                <textarea class="form-control" name="observaciones" rows="3" placeholder="Escribe aquí cualquier observación..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>





            <div class="col-lg-12 d-flex align-items-center justify-content-center mt-5">
                <a class="col-2 btn btn-primary px-1 mb-5" type="button" id="btnGuardarSolicitud" style="margin-right: 2%">
                    <i class="bi bi-send-check"></i> Guardar
                </a>

                <a class="col-2 btn btn-danger px-1 p mb-5" type="button" onclick="window.location.href='/laminas'">
                <i class="bi bi-caret-left"></i> Regresar
                </a>
            </div>

        </div>




    </div>

</div>


@endsection


@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Lamina/crear_lamina.js?v0.0.0')}}"></script>
@endpush
