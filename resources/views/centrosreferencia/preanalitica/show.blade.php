@extends('layouts.main')

@section('title', $preanalitica->id)

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('preanalitica.index') }}">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">Consulta de muestras generadas</h5>
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
            <div class="container-fluid">
                <!--begin::Container-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-custom mb-5 ">

                            <!--begin::Header-->
                            <div class="card-header h-auto py-6">
                                <!--start::Toolbar-->
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('preanalitica.index') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ki ki-bold-close icon-lg" style="color:rgb(255, 0, 0)"
                                                    title="Cerrar/Regresar"></i>
                                            </span>
                                        </a>
                                    </i>
                                </div>
                            </div>

                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">

                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Institución de Salud:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $preanalitica->instituciones->descripcion }} - ({{ $preanalitica->instituciones->clasificacion->descripcion }} - {{ $preanalitica->instituciones->nivel->descripcion }} - {{ $preanalitica->instituciones->tipologia->descripcion }})</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Paciente:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $preanalitica->paciente->identidad }} - ({{ $preanalitica->paciente->apellidos }} {{ $preanalitica->paciente->nombres }})</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Enviado a:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $preanalitica->sedes->descripcion }} - {{ $preanalitica->crns->descripcion }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Evento Solicitado:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $preanalitica->evento->descripcion }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Fecha Registro:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $preanalitica->created_at }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Usuario Registro:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $preanalitica->usuariot->name }}</span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <label class="col-12 col-form-label" align="center"><h3>Muestras Receptadas</h3></label>
                            <hr>
                            <div class="card-body py-4">
                                @forelse ($analitica as $objAn)
                                <div class="form-group row my-2">
                                    <label class="col-1 col-form-label">Clase:</label>
                                    <div class="col-1" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->clase->descripcion }}</span>
                                    </div>
                                    <label class="col-1 col-form-label">Tipo de Muestra:</label>
                                    <div class="col-2" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->muestra->descripcion }}</span>
                                    </div>
                                    <label class="col-1 col-form-label">Código de Muestra:</label>
                                    <div class="col-2" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->anio_registro }} - {{ str_pad($objAn->codigo_muestra, 6, "0", STR_PAD_LEFT) }} - {{ str_pad($objAn->codigo_secuencial, 2, "0", STR_PAD_LEFT) }}</span>
                                    </div>
                                    <label class="col-2 col-form-label">Fecha recepción:</label>
                                    <div class="col-2" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->created_at }}</span>
                                    </div>
                                </div>
                                @empty
                                <!--begin::Col-->
                                <div class="col-12">
                                    <div class="alert alert-custom alert-notice alert-light-dark fade show mb-5"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="flaticon-questions-circular-button"></i>
                                        </div>
                                        <div class="alert-text">Sin registros</div>
                                    </div>
                                </div>
                            @endforelse
                            </div>
                        </div>
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
@endsection
