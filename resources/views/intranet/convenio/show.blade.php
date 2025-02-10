@extends('layouts.main')

@section('title', $convenio->numerodocumento)

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('convenio.index') }}"><h5 class="text-dark font-weight-bold my-2 mr-5">Convenios</h5></a>
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
                    <div class="col-xl-4">
                        <div class="card card-custom mb-5 ">

                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <!--start::Toolbar-->
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('convenio.index') }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-reply" style="color:orange" title="Regresar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp;
                                    @if(auth()->user()->roles()->first()->name=="Transferencia")
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('convenio.edit', $convenio) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-edit" style="color:lightblue" title="Editar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    @endif
                                </div>
                            </div>

                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-4">

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Nombre del Convenio:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $convenio->nombre }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Institución:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $convenio->institucionprincipal->nombre }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Objetivo del Convenio:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $convenio->objetivo }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Firma:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $convenio->fechafirma }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Fecha Vigencia:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">{{ $convenio->fechavigencia }}</span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Ámbito del Convenio:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $convenio->ambitoconvenio->descripcion }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Responsable INSPI:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $convenio->contactointerno->name }}</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Contacto Externo:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $convenio->contactoexterno }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Correo Contacto:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext font-weight-bolder">
                                            {{ $convenio->correoexterno }}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row my-2">
                                    <label class="col-4 col-form-label">Estado Convenio:</label>
                                    <div class="col-8">
                                        <span class="form-control-plaintext">
                                            <span class="font-weight-bolder">{{ $convenio->estadoconvenio->descripcion }}</span>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header h-auto py-4">
                                <div class="card-title">
                                    <h3 class="card-label">{{ $convenio->numerodocumento }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($convenio->archivo)
                                    <embed width="100%" height="1000px" src="{{ Storage::url($convenio->archivo) }}#toolbar=1&navpanes=0&scrollbar=0" type="">
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
