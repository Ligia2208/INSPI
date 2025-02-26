@extends('layouts.main')

@section('title', 'Crear Usuario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')

<div class="container">
    <h2 class="text-center mt-4 ">Crear Usuario</h2>

    <div class="card p-4 shadow-sm">
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                </div>

                <div class="col-md-6">
                    <label for="surname" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" placeholder="Correo electrónico">
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Teléfono">
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" id="CrearUsuario" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script src="{{asset('assets/js/Planificacion/reportFormulario_Crear.js?v0.0.0')}}"></script>
@endpush