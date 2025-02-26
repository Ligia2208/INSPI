@extends('layouts.main')

@section('title', 'Editar Usuario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@endpush

@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2>Editar Usuario</h2>

        <!-- Botón de regreso a la lista de usuarios -->
        <a href="{{ route('planificacion.reportFormulario_ListaUsuario') }}" 
           class="btn btn-warning btn-circle" title="Volver a la lista">
            <i class="bi bi-arrow-bar-left"></i>
        </a>
    </div>

    <div class="card p-4 shadow-sm mt-3">
        <form>

            <!-- Campo ID con botón de búsqueda -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="id" class="form-label">ID</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="buscar_id" placeholder="Ingrese ID" value="{{$id}}">
                        <button class="btn btn-primary" type="button" onclick="buscarUsuario()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="{{$nombre}}">
                </div>

                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido" value="{{$apellido}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" placeholder="Correo electrónico" value="{{$correo}}">
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" value="{{$telefono}}">
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" id="EditarUsuario" class="btn btn-primary">Editar</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{asset('assets/js/Planificacion/reportFormulario_Editar.js?v0.0.0')}}"></script>

<script>
    function buscarUsuario() {
        let id = document.getElementById("buscar_id").value;
        if (id) {
            window.location.href = "{{ url('planificacion/reportFormulario_Editar') }}/" + id;
        } else {
            alert("Por favor, ingrese un ID válido.");
        }
    }
</script>
@endpush
