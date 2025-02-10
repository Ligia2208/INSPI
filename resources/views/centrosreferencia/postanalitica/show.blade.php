@extends('layouts.main')

@section('title', "Detalle")

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('postanalitica.index') }}">
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
                                        <a href="{{ route('postanalitica.index') }}" class="navi-link">
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
                                        <span class="form-control-plaintext font-weight-bolder">{{ $postanalitica->instituciones->descripcion }} - ({{ $postanalitica->instituciones->clasificacion->descripcion }} - {{ $postanalitica->instituciones->nivel->descripcion }} - {{ $postanalitica->instituciones->tipologia->descripcion }})</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Paciente:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $postanalitica->paciente->identidad }} - ({{ $postanalitica->paciente->apellidos }} {{ $postanalitica->paciente->nombres }})</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Enviado a:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $postanalitica->sedes->descripcion }} - {{ $postanalitica->crns->descripcion }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Evento Solicitado:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">({{ $postanalitica->evento->simplificado }}) - {{ $postanalitica->evento->descripcion }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Fecha Registro:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $postanalitica->created_at }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-3 col-form-label">Usuario Registro:</label>
                                    <div class="col-9" style="align:left">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $postanalitica->usuariot->name }}</span>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <label class="col-12 col-form-label" align="center"><h3>Muestras Receptadas</h3></label>
                            <hr>
                            <?php $i=1; ?>
                            @forelse ($muestras as $objAn)
                            <div class="container mt-5 col-12">
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active" wire:ignore>
                                        <a class="btn btn-default" href="#tab-<?php echo $i*5+1; ?>" aria-controls="#tab-<?php echo $i*5+1; ?>" role="tab" data-toggle="tab">Detalles</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-<?php echo $i*5+2; ?>" aria-controls="#tab-<?php echo $i*5+2; ?>" role="tab" data-toggle="tab">Informe Proceso</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-5">
                                    <div role="tabpanel" class="tab-pane active" id="tab-<?php echo $i*5+1; ?>" wire:ignore.self>

                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="col-xl-12">
                                                    <div class="my-5">
                                                        <div class="form-row">
                                                            <div class="card-body py-4">
                                                            @if($objAn->resultado_id>0)
                                                                <div class="form-group row my-2">
                                                            @else
                                                                <div class="form-group row my-2" style="background-color: rgb(201, 170, 170)">
                                                            @endif
                                                                    <label class="col-1 col-form-label">Tipo de Muestra:</label>
                                                                    <div class="col-2" style="align:left">
                                                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->muestra->descripcion }}</span>
                                                                    </div>
                                                                    <label class="col-1 col-form-label">Código de Muestra:</label>
                                                                    <div class="col-2" style="align:left">
                                                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->anio_registro }} - {{ str_pad($objAn->codigo_muestra, 5, "0", STR_PAD_LEFT) }} - {{ str_pad($objAn->codigo_secuencial, 3, "0", STR_PAD_LEFT) }}</span>
                                                                    </div>
                                                                    <label class="col-1 col-form-label">Fecha recepción:</label>
                                                                    <div class="col-2" style="align:left">
                                                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->created_at }}</span>
                                                                    </div>
                                                                    <label class="col-1 col-form-label">Técnica aplicada:</label>
                                                                    <div class="col-2" style="align:left">
                                                                        @if($objAn->tecnica_id>0)
                                                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->tecnica->descripcion }}</span>
                                                                        @else
                                                                        <span class="form-control-plaintext font-weight-bolder"></span>
                                                                        @endif
                                                                    </div>
                                                                    <label class="col-1 col-form-label">Resultado obtenido:</label>
                                                                    <div class="col-2" style="align:left">
                                                                        @if($objAn->resultado_id>0)
                                                                            @if($objAn->carga_viral > 0)
                                                                                <span class="form-control-plaintext font-weight-bolder">{{ $objAn->resultado->descripcion }} <br> ({{ $objAn->carga_viral }} {{ $objAn->unidades->descripcion }})</span>
                                                                            @else
                                                                            <span class="form-control-plaintext font-weight-bolder">{{ $objAn->resultado->descripcion }}</span>
                                                                            @endif
                                                                        @else
                                                                        <span class="form-control-plaintext font-weight-bolder"></span>
                                                                        @endif
                                                                    </div>
                                                                    <label class="col-1 col-form-label">Detalle del resultado:</label>
                                                                    <div class="col-8" style="align:left">
                                                                        <span class="form-control-plaintext font-weight-bolder">{{ $objAn->descripcion }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="tab-<?php echo $i*5+2; ?>" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="col-xl-12">
                                                    <div class="my-5">
                                                        <div class="form-row">
                                                            <div class="card-body py-4">
                                                                @if ($objAn->archivo)
                                                                    <embed width="100%" height="1000px" src="{{ Storage::url($objAn->archivo) }}#toolbar=1&navpanes=0&scrollbar=0" type="">
                                                                @else
                                                                    <span class="d-block badge badge-secondary text-muted pt-2 font-size-sm">Ninguno</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="d-none" type="submit"></button>
                                </div>
                            </div>
                            <?php $i++; ?>
                            @empty
                            @endforelse
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
