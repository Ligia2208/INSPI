@extends('layouts.Rocker.cuerpo')


@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/doEncuesta.js?v0.0.1')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')

    

<div class="page-wrapper">
    <div class="page-content">

        <h2 class="mb-0 text-uppercase text-center mt-2"> 
            <i class="font-32 text-success bi bi-check2-circle"></i> 
            Encuesta de Satisfacción - INSPI 
        </h2>
        <hr/>

        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">¡Encuesta Completada!</h4>
            <p> <i class="font-22 bi bi-file-earmark-ruled"></i> Gracias por completar la encuesta de satisfacción. Valoramos mucho tu opinión y tus comentarios nos ayudan a mejorar continuamente nuestros servicios.</p>
            <hr>
            <p class="mb-0">Si necesitas más información o asistencia adicional, no dudes en contactar al equipo de CRN.</p>
        </div>

    </div>
</div>



@endsection