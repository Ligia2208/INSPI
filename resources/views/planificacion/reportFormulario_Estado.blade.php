@extends('layouts.main')

@section('title', 'Estado Formulario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaWa9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<style>
    .custom-table {
        border-color: #30d0db !important;
    }

    .custom-table th, 
    .custom-table td {
        border: 2px solid #30d0db !important; 
    }

    .btn-circle {
        width: 35px;
        height: 35px;
        padding: 6px 0;
        border-radius: 50%;
        text-align: center;
        font-size: 18px;
        line-height: 1.2;
    }

    .btn-lista-usuarios {
        background-color: rgb(185, 32, 70);
        color: white;
        border: none;
    }

    .btn-lista-usuarios:hover {
        background-color: rgb(155, 22, 55);
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    
    <div class="mb-3 d-flex justify-content-start">
        <a href="{{ route('planificacion.reportFormulario_ListaUsuario') }}" 
           class="btn btn-lista-usuarios">
           <i class="bi bi-person-fill-check"> Lista de Usuarios </i>
        </a>
    </div>

    <h2 class="mb-4 text-center">Reporte de Formularios</h2>

    <form method="GET" action="{{ route('planificacion.reportFormulario_Estado') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="estado" class="form-control">
                    <option value="">-- Filtrar por Estado --</option>
                    <option value="A" {{ request('estado') == 'A' ? 'selected' : '' }}>Activos</option>
                    <option value="E" {{ request('estado') == 'E' ? 'selected' : '' }}>Eliminados</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered custom-table">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($formularios as $formulario)
                <tr class="text-center">
                    <td>{{ $formulario->id }}</td>
                    <td>{{ $formulario->nombre }}</td>
                    <td>{{ $formulario->apellido }}</td>
                    <td>{{ $formulario->correo }}</td>
                    <td>{{ $formulario->telefono }}</td>
                    <td>
                        @if ($formulario->estado === 'E')
                            <span class="badge bg-danger">E</span>
                        @else
                            <span class="badge bg-success">A</span>
                        @endif
                    </td>
                    <td>
                        @if ($formulario->estado === 'E')
                            <form action="{{ route('planificacion.cambiar_estado_usuario') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $formulario->id }}">
                                <button type="submit" class="btn btn-circle" style="background-color: #001F3F; color: white;">
                                    <i class="bi bi-backspace-fill"></i>
                                </button>

                            </form>
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $formularios->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/Planificacion/reportFormulario_Estado.js?v0.0.0') }}"></script>
@endpush
