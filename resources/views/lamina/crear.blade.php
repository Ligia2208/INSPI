
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
                            <h1 class="h3 mb-0 text-white lh-1">Plan Operativo Anual</h1>
                            <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="">
                        </div>
                    </div>
                </div> 

                <div class="card">
                    <div class="card-body">
                        <div class="row p-2">

                            <div class="col-md-4">
                                <label for="fecha_recep" class="form-label fs-6">Fecha de Recepción</label>
                                <input type="date" id="fecha_recep" name="fecha_recep" class="form-control" required="" autofocus="" value="" disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-8">
                                <label for="centro_salud" class="form-label fs-6">Nombre del Laboratorio Supervisado</label>
                                <select id="centro_salud" name="centro_salud" class="form-control single-select" required>
                                    <option value="0">Seleccione un Centro de Salud</option>

                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="responsable" class="form-label fs-6">Responsable Recepción</label>
                                <select id="responsable" name="responsable" class="form-control single-select" required>
                                    <option value="0">Seleccione un Responsable</option>

                                </select>
                            </div>


                            <div class="col-md-6 mt-2">
                                <label for="analista" class="form-label fs-6">Analista(Encargado de Control de Calidad)</label>
                                <select id="analista" name="analista" class="form-control single-select" required>
                                    <option value="0">Seleccione un Responsable</option>

                                </select>
                            </div>

                            <div class="col-md-4 mt-2">
                                <label for="mes_recepcion" class="form-label fs-6">Mes Supervisado</label>
                                <input type="text" id="mes_recepcion" name="mes_recepcion" class="form-control" required disabled>
                                <div class="valid-feedback">Looks good!</div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row p-2">

                        <div class="col-md-12">
                            <label><strong>1. Láminas empacadas en cajas de láminas portaobjetos y separadas entre ellas</strong></label>
                            <div>
                                <input type="radio" name="laminas_empacadas" value="si" required> Sí
                                <input type="radio" name="laminas_empacadas" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>2. Láminas con información legible y enumeradas en forma consecutiva</strong></label>
                            <div>
                                <input type="radio" name="laminas_legibles" value="si" required> Sí
                                <input type="radio" name="laminas_legibles" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>3. Las láminas sin identificación de su resultado</strong></label>
                            <div>
                                <input type="radio" name="laminas_sin_id" value="si" required> Sí
                                <input type="radio" name="laminas_sin_id" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>4. Láminas sin exceso de aceite de inmersión</strong></label>
                            <div>
                                <input type="radio" name="laminas_sin_aceite" value="si" required> Sí
                                <input type="radio" name="laminas_sin_aceite" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>5. Láminas con frotis adecuado (tinción y dimensiones estables en el manual de baciloscopía)</strong></label>
                            <div>
                                <input type="radio" name="laminas_frotis_adecuado" value="si" required> Sí
                                <input type="radio" name="laminas_frotis_adecuado" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>6. Láminas íntegras sin rajaduras que afecten al frotis</strong></label>
                            <div>
                                <input type="radio" name="laminas_integras" value="si" required> Sí
                                <input type="radio" name="laminas_integras" value="no"> No
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label><strong>7. Láminas con documentación respectiva (listado con el número y resultado de cada lámina)</strong></label>
                            <div>
                                <input type="radio" name="laminas_documentacion" value="si" required> Sí
                                <input type="radio" name="laminas_documentacion" value="no"> No
                            </div>
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
<script src="{{asset('assets/js/Lamina/crear_lamina.js?v0.0.0')}}"></script>
@endpush
