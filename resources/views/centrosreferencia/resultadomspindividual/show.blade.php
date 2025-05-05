@extends('layouts.main')

@section('title', str_pad($resultado->codigo, 10, '0', STR_PAD_LEFT))

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('resultadomspindividual.index') }}">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">Seguimiento de casos</h5>
                    </a>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item active">
                            <a href="#" class="text-muted">@yield('title')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">

                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">Caso No.
                                        {{ str_pad($resultado->codigo, 5, '0', STR_PAD_LEFT) }} -
                                        {{ $resultado->identidad }} - {{ $resultado->apellidos }} {{ $resultado->nombres }}</h3>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('resultadomspindividual.index') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-times icon-xl" style="color:rgb(255, 0, 0)"
                                                    title="Cerrar"></i>
                                            </span>
                                        </a>
                                    </i>
                                </div>
                            </div>
                            <br>
                            <div class="card-body pt-0 pb-3">
                                <ul class="timeline-with-icons">
                                    <li class="timeline-item mb-5">
                                        <span class="timeline-icon">
                                            <i class="fa fa-university text-primary fa-2x"></i>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Según ficha de registro</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Llega a Institución de Salud</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $resultado->fecha_atencion }}</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $resultado->unidad_salud }}</label>
                                        </span>
                                    </li>
                                    <li class="timeline-item mb-5">
                                        <span class="timeline-icon">
                                            <i class="fa fa-flag text-primary fa-2x"></i>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Ingresa muestra por INSPI sede - {{ $resultado->ingresa_por }}</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Se envia muestra a {{ $resultado->sede }} - {{ $resultado->crn }}</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Registrado por: {{ $resultado->usuario_registro }}</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Fecha Registro: {{ $resultado->fecha_atencion }}</label>
                                        </span>
                                    </li>
                                    <li class="timeline-item mb-5">
                                        <span class="timeline-icon">
                                            <i class="fa fa-flask text-primary fa-2x"></i>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Se reciben la siguientes muestras:</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Clase: {{ $resultado->clase_muestra }} - Tipo: {{ $resultado->tipo_muestra }} - Fecha toma: {{ $resultado->fecha_toma_muestra }}</label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Evento solicitado: {{ $resultado->evento }}</label>
                                        </span>
                                    </li>
                                    @if($procesadot==0)
                                    <li class="timeline-item mb-5">
                                        <span class="timeline-icon">
                                            <i class="fa fa-hourglass-end text-danger fa-2x"></i>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">En espera de procesamiento en el área técnica</label>
                                        </span>
                                    </li>
                                    @else
                                    <li class="timeline-item mb-5">
                                        <span class="timeline-icon">
                                            <i class="fa fa-hourglass-end text-primary fa-2x"></i>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Muestras llegaron al CRN: {{ $analiticas->fecha_llegada_lab }} </label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Muestras se procesaron: {{ $analiticas->fecha_procesamiento }} </label>
                                            <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Técnico responsable: {{ $nomtec }} </label>
                                        </span>
                                    </li>
                                    @if($resultado->validado=='N')
                                        <li class="timeline-item mb-5">
                                            <span class="timeline-icon">
                                                <i class="fa fa-hourglass-end text-danger fa-2x"></i>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">En espera de la validación del Responsable</label>
                                            </span>
                                        </li>
                                        @else
                                        <li class="timeline-item mb-5">
                                            <span class="timeline-icon">
                                                <i class="fa fa-check text-success fa-2x"></i>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Validación Responsable: {{ $resultado->fecha_validacion }} </label>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">Responsable CRN: {{ $nomres }} </label>
                                            </span>
                                        </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>


                        </div>
                        <!--end::Card-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
    </div>
@endsection

@section('footer')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets') }}/plugins/custom/flot/flot.bundle.js"></script>
    <script src="{{ asset('assets') }}/js/pages/features/charts/flotcharts.js"></script>
    <script language="javascript">
        function veroficio(nombre) {
            window.open('/storage/' + nombre);
        }
    </script>
@endsection
