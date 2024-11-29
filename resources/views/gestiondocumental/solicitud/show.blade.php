@extends('layouts.main')

@section('title', $solicitud->numerodocumento)

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('solicitud.index') }}"><h5 class="text-dark font-weight-bold my-2 mr-5">Solicitudes</h5></a>
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
                    <div class="col-xl-4">
                        <div class="card card-custom mb-5 ">
                            
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <!--start::Toolbar-->
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('solicitud.index') }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-reply" style="color:orange" title="Regresar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp;
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('solicitud.edit', $solicitud) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-edit" style="color:lightblue" title="Editar"></i>
                                            </span>
                                        </a>
                                    </i>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Origen:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $solicitud->origen->nombre }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Dependencia:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $solicitud->dependencia->nombre }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Número Documento:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $solicitud->numerodocumento }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Documento:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $solicitud->fechadocumento }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Recepción:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $solicitud->fecharecepcion }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Asunto:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $solicitud->descripcion }}
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets') }}/media/svg/shapes/abstract-4.svg)">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="">
                                    <p class="text-dark-75 font-weight-bolder font-size-h5 m-0">
                                        @if ($solicitud->destino_id>0)
                                            <span class="badge badge-info">{{ $solicitud->area->nombre }}</span>
                                        @else
                                            <span class="badge badge-secondary">Ningun área ha sido asignada</span>
                                        @endif
                                    </p> 
                                    <br>
                                    <div class="font-weight-bold text-success mb-5">Sumillado: {{ $solicitud->sumillado }}</div>
                                </div>                       
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">{{ $solicitud->numerodocumento }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($solicitud->archivo)
                                    <embed width="100%" height="600px" src="{{ Storage::url($solicitud->archivo) }}" type="">
                                @else
                                    <span class="d-block badge badge-secondary text-muted pt-2 font-size-sm">Ninguno</span>
                                @endif
                               
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
@endsection