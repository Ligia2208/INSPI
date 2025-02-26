@extends('layouts.main')

@section('title', 'Lista de Usuarios')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Lista de Usuarios</h2>
    
    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Teléfono</th>
            </tr>
        </thead>

        <tbody>
            @foreach($formularios as $formulario)
                <tr class="text-center">
                    <td>{{ $formulario->id }}</td>
                    <td>{{ $formulario->nombre }}</td>
                    <td>{{ $formulario->apellido }}</td>
                    <td>{{ $formulario->correo }}</td>
                    <td>{{ $formulario->telefono }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/Planificacion/reportFormulario_ListaUsuario.js?v0.0.0') }}"></script>
@endpush
