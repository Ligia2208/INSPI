@extends('layouts.main')

@section('title', 'Lista Usuario')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">nombre</th>
            <th scope="col">apellido</th>
            <th scope="col">correo</th>
             <th scope="col">telefono</th>
        </tr>
    </thead>

    <tbody>
         @foreach($Formularios as $Formulario)
            <tr>
                <td>{{ $Formulario->id }}</td>
                <td>{{ $Formulario->nombre }}</td>
                <td>{{ $Formulario->apellido }}</td>
                <td>{{ $Formulario->correo }}</td>
                <td>{{ $Formulario->telefono }}</td>
             </tr>
        @endforeach
    </tbody>
</table>

@push('scripts')
<script src="{{asset('assets/js/Planificacion/reportFormulario_ListaUsuario.js?v0.0.0')}}"></script>
@endpush
