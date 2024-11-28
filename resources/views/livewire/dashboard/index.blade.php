@extends('layouts.main')

@section('title', 'Bienvenida')

@section('content')
    <!--begin::Bread-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <h5 class="text-dark font-weight-bold my-2 mr-5">Bienvenida</h5>
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item active">
                            <a href="#" class="text-muted">General </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--begin::page-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
            <!--begin::Dashboard-->
                <div class="row">
                    <div class="card-body">
                        <div class="text-center px-4 ">
                            <h3 class="fs-2x fw-bolder mb-10">Hola {{ Auth::user()->name }} ... Buen dia!</h3>
                            <img class="img-fluid col-12" alt="" src="{{ asset('assets/media/ilustrations/inspi.jpg') }}">
                        </div>
                        <div class="card-px text-center py-8">
                            <p class="text-gray-600 fs-4x fw-bold mb-6">El Instituto Nacional de Investigación en Salud Pública,
                             es una institución ejecutora de la investigación, ciencia,<br> tecnología e innovación en el área de la Salud Humana y Laboratorio de Referencia Nacional de la RED de Salud Pública del país.<br>
                             Con el objetivo de promover la investigación en servicios sanitarios, en articulación con el Sistema de Vigilancia epidemiológica, <br>que permita la detección oportuna de patologías, virus y
                             demás enfermedades; asi como la identificación de mecanismos<br> y acciones para contrarestar una posible propagación de epidemias y cubrir eficientemente las demandas <br>
                             del Ministerio de Salud Pública - MSP.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
