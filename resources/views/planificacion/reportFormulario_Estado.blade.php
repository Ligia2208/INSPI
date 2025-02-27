@extends('layouts.main')

@section('title', 'Estado Usuario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')

<div class="container">
    <h2 class="text-center mt-4">Estado de Usuario</h2>

    <div class="card p-4 shadow-sm">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$id}}</td>
                    <td>{{$nombre}}</td>
                    <td>{{$apellido}}</td>
                    <td>{{$correo}}</td>
                    <td>{{$telefono}}</td>
                    <td>{{$estado}}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            <button type="button" id="EditarUsuario" class="btn btn-primary">Editar</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/js/Planificacion/reportFormulario_Estado.js?v0.0.0')}}"></script>
@endpush
