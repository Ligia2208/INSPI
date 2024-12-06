
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/doEncuesta.js?v0.0.1')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')

<div class="page-wrapper">
	<div class="page-content">
        <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Encuesta de Satisfacción - INSPI </h2>

        <hr/>

        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <div class="row">
            <div class="col-xl-12 mx-auto">

                <div class="card">

                    <div class="card-body">
                        <div class="p-4 border rounded">
                            <form id="frmCreateEncuesta" action="{{ route('gestion.store') }}" method="post" class="row g-3 needs-validation " novalidate>
                            @csrf

                                    <div id="contenedorEncuesta" class="row">

                                            <div class="container">

                                                <!--  Servicios  -->
                                                <section class="row">

                                                @foreach( $encuestaArray as $encuesta )

                                                <div class="container mt-4">
                                                    <section class="row">
                                                        <div class="col-md-12">
                                                            <h2 class="text-center">{{ $encuesta['descripcion'] }}</h2>
                                                            <p class="text-center">{{ $encuesta['nombre'] }}</p>
                                                        </div>
                                                    </section>

                                                    <hr class="mt-4">

                                                    <p class="text-center fs-5">Estimado usuario, esta encuesta ya ha sido completada. Por favor, regrese a la selecciòn de encuestas para continuar.</p>

                                                </div>
                                                @endforeach
                                            </div>

                                    </div>

                                    <div class="modal-footer mt-4">
                                        <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('encuesta.homeUsuario') }}">
                                            <span class="lni lni-close"></span>
                                            Atras
                                        </a>
                                    </div>
                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>
</div>
@endsection


