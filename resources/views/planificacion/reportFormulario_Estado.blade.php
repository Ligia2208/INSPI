@extends('layouts.main')

@section('title', 'Estado Usuario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Reporte de Usuarios</h2>

    <!-- Filtro por estado -->
    <form method="GET" action="{{ route('planificacion.reportFormulario_Estado') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="estado" class="form-control">
                    <option value="">-- Filtrar por Estado --</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                    <option value="eliminado" {{ request('estado') == 'eliminado' ? 'selected' : '' }}>Eliminados</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->apellido }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->telefono }}</td>
                    <td>
                        @if ($usuario->deleted_at)
                            <span class="badge badge-danger">Eliminado</span>
                        @else
                            <span class="badge badge-success">Activo</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/Planificacion/reportFormulario_Estado.js?v0.0.0') }}"></script>
@endpush
