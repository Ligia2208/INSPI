@extends('layouts.main')

@section('title', 'Lista de Usuarios')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        /* Bordes color azul menta */
        .custom-table {
            border-color: #30d0db !important;
        }

        .custom-table th, 
        .custom-table td {
            border: 2px solid #30d0db !important; 
        }

        /* Estilo para hacer los botones circulares */
        .btn-circle {
            width: 35px;
            height: 35px;
            padding: 6px 0;
            border-radius: 50%;
            text-align: center;
            font-size: 18px;
            line-height: 1.2;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>
        
        <table class="table table-striped table-hover table-bordered custom-table">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Acciones</th> 
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
                        <td>
                            <div class="d-flex justify-content-center">
                                <!-- Botón Editar -->
                                <a href="{{ route('formularios.edit', $formulario->id) }}" 
                                   class="btn btn-warning btn-sm btn-circle mx-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('formularios.destroy', $formulario->id) }}" 
                                      method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-circle mx-1" 
                                            onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" 
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/Planificacion/reportFormulario_ListaUsuario.js?v0.0.0') }}"></script>
@endpush
