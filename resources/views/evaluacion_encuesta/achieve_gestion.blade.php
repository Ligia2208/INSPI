
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js?v0.0.51')}}"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-paste"></i> Finalizar Seguimiento </h6>
        <!-- <hr/> -->
            <!-- <button class="btn btn-primary px-5  d-flex align-items-center" id="btnCreateCatalogo" name="btnCreateCatalogo" type="button" >
                <i class="lni lni-circle-plus"></i> Agregar
            </button> -->
        <hr/>


        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <?php

            $data = json_decode($documento, true);

            // Verifica si la decodificación fue exitosa
            if ($data !== null) {
                $primerElemento = $data[0];
            }

        ?>




        <div class="row">
            <div class="col-xl-12 mx-auto">

                <div class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="mb-0 text-uppercase mt-4 ms-3">
                                        <i class="font-22 text-success fadeIn animated bx bx-clipboard"></i>
                                        DATOS DEL SEGUMIENTO
                                    </h6>
                                </div>
                                <div class="col-5 mt-4">
                                    <div class="d-flex justify-content-end">
                                        @if($primerElemento['estado'] == 'E')
                                        <span class="badge bg-secondary fs-6">Eliminado</span>
                                        @elseif($primerElemento['estado'] == 'V')
                                        <span class="badge bg-danger fs-6">Expirado</span>
                                        @else
                                        <span class="badge bg-success fs-6">Activo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="p-4 border rounded">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Número de Documento:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['nombre'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Fecha de Creación:</strong> </label>
                                    <spam class="fs-6"> {{ $fechaFormateada = date("Y-m-d", strtotime($primerElemento['fecha'])) }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Tipo de Documneto:</strong> </label>
                                    @if($primerElemento['tipo'] == '1')
                                    <spam class="fs-6"> Correo <spam>
                                    @else
                                    <spam class="fs-6"> Quipux <spam>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Departamento Asignado:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['asignado'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Fecha de Vencimiento:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['f_plazo'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Días faltantes:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['dias_faltantes'] }} <spam>
                                </div>

                            </div>

                            <hr>

                            <div class="col-md-12">
                                <label for="comentario" class="form-label fs-6">Agregar Memorándum  de respuesta</label>
                                <input type="text" id="comentario" name="comentario" class="form-control" required=""  autofocus ="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <!-- [{"nombre":"12","tipo":"1","fecha":"2023-09-20 00:00:00","f_plazo":null,"id_usuario":null,"estado":"A","asignado":null,"cargo":null,"id_documento":14}] -->


                        </div>
                        <hr>

                        <div class="text-center">
                            <input type="hidden" id="id_asignacion" name="id_asignacion" class="form-control"  readonly="readonly" required="" value="{{ $primerElemento['id_asignacion'] }}" autofocus>

                            <a type="button" class="btn submit btn-primary btn-shadow font-weight-bold me-2" id="btnFinalizarSeg">
                                <i class="fadeIn animated bx bx-send text-light"></i>
                                Finalizar
                            </a>

                            <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('documentos') }}">
                                <i class="font-22 fadeIn text-light animated bx bx-arrow-back" style="color:indianred"></i>
                                Regresar
                            </a>

                        </div>

                    </div>
                </div>


            </div>
        </div>


    </div>
</div>
@endsection


