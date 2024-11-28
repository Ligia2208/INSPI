@extends('layouts.main')

@section('title', $solicituddir->numerodocumento)

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('solicituddir.index') }}"><h5 class="text-dark font-weight-bold my-2 mr-5">Solicitudes</h5></a>
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
                                    <div class="dropdown dropdown-inline" data-toggle="tooltip"  data-placement="left">
                                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-left">
                                        @if ($solicituddir->procesado==0)
                                            <a class="dropdown-item" href="{{ route('solicituddir.edit', $solicituddir) }}"><i class="fa fa-pen mr-2"></i> Editar Solicitud</a>
                                        @endif    
                                            <a class="dropdown-item" href="{{ route('solicituddir.index') }}"><i class="fa fa-reply mr-2"></i> Regresar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Número Documento:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $solicituddir->numerodocumento }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Documento:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $solicituddir->fechadocumento }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Recepción:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $solicituddir->fecharecepcion }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Asunto:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $solicituddir->descripcion }}
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
                                        @if ($solicituddir->area_id>0)
                                            <span class="badge badge-info">{{ $solicituddir->area->nombre }}</span>
                                        @else
                                            <span class="badge badge-secondary">Ningun área ha sido asignada"</span>
                                        @endif
                                    </p> 
                                    <br>
                                    <div class="font-weight-bold text-success mb-5">Sumillado Dirección Ejecutiva: {{ $solicituddir->sumillado }}</div>
                                </div>                       
                            </div>
                            <!--end::Body-->
                        </div>
                        <div class="card bgi-no-repeat card-stretch gutter-b" style="background-position: right top; background-size: 30% auto; background-image: url({{ asset('assets') }}/media/svg/shapes/abstract-4.svg)">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="">
                                    <p class="text-dark-75 font-weight-bolder font-size-h5 m-0">
                                    @if ($userDir != null)
                                        <span class="badge badge-info">{{ $userDir->name }}</span>
                                    @else
                                    <span class="badge badge-info"></span>
                                    @endif
                                    </p> 
                                    <br>
                                    <div class="font-weight-bold text-success mb-5">Sumillado Área: {{ $solicituddir->sumillado_dirgen }}</div>
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
                                    <h3 class="card-label">{{ $solicituddir->numerodocumento }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($solicituddir->archivo)
                                    <embed width="100%" height="600px" src="{{ Storage::url($solicituddir->archivo) }}" type="">
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