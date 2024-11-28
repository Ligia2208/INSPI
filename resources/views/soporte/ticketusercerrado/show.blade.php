@extends('layouts.main')

@section('title', str_pad($ticketusercerrado->id, 5, "0", STR_PAD_LEFT))

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a class="text-dark" href="{{ route('ticketusercerrado.index') }}">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">Seguimiento de Tickets</h5>
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
                                    <h3 class="card-label">Ticket No. {{ str_pad($ticketusercerrado->id, 5, "0", STR_PAD_LEFT) }} - {{ $ticketusercerrado->titulo }}</h3>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('ticketusercerrado.index') }}" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-times icon-xl" style="color:rgb(255, 0, 0)" title="Cerrar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp;&nbsp;&nbsp;
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-pen icon-xl" style="color:lightblue" title="Editar"></i>
                                            </span>
                                        </a>
                                    </i>
                                </div>
                            </div>
                            <div class="card-body pt-0 pb-3">
                                <section class="py-5">
                                    <ul class="timeline-with-icons">
                                        @forelse ($detalles as $objDet)
                                        <li class="timeline-item mb-5">
                                            <span class="timeline-icon">
                                            @if($objDet->funcion == 'Usuario')
                                                <i class="fa fa-user text-primary fa-2x"></i>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objDet->funcion }}</label>
                                            @endif
                                            @if($objDet->funcion == 'Gestor')
                                                <i class="fa fa-cog text-primary fa-2x"></i>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objDet->funcion }}</label>
                                            @endif
                                            @if($objDet->funcion == 'Técnico')
                                                <i class="fa fa-gavel text-primary fa-2x"></i>
                                                <label class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objDet->funcion }}</label>
                                            @endif
                                            </span>
                                            <hr>
                                            <h5 class="fw-bold">{{ $objDet->titulo }} - {{ $objDet->usuario->name }} @if ($objDet->archivo != null) - (Ver adjuntos <i class="ace-icon fa fa-eye" style="color:rgb(250, 0, 0)" onclick="veroficio('{{$objDet->archivo}}')" title="Archivos adjuntos"></i>)@endif</h5>
                                            <p class="text-muted mb-2 fw-bold">{{ $objDet->fecha_registro }}</p>
                                            <p class="text-muted">
                                                <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objDet->descripcion }}</span>

                                            </p>
                                        </li>
                                        <br>
                                        @empty
                                        <!--begin::Col-->
                                        <div class="col-12">
                                            <div class="alert alert-custom alert-notice alert-light-dark fade show mb-5"
                                                role="alert">
                                                <div class="alert-icon">
                                                    <i class="flaticon-questions-circular-button"></i>
                                                </div>
                                                <div class="alert-text">Sin detalles</div>
                                            </div>
                                        </div>
                                    @endforelse
                                    </ul>

                                </section>

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
        function veroficio(nombre){
        window.open('/storage/'+nombre);
        }
    </script>
@endsection
