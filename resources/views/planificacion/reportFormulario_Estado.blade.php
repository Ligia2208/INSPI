@extends('layouts.main')

@section('title', 'Estado Usuario')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('content')

<div class="container">
    <h2 class="text-center mt-4 ">Estado de Usuario</h2>

    <div class="card p-4 shadow-sm">
        <form>

            <div class="col-md-6">
                    <label for="name" class="form-label">ID</label>
                    <input type="text" class="form-control" id="id" placeholder="Id" value='{{$id}}'>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" value='{{$nombre}}'>
                </div>

                <div class="col-md-6">
                    <label for="surname" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido" value='{{$apellido}}'>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" placeholder="Correo electrónico" value='{{$correo}}'>
                </div>

                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" value='{{$telefono}}'>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" id="EditarUsuario"  class="btn btn-primary">Editar</button>
            </div>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script src="{{asset('assets/js/Planificacion/reportFormulario_Estado.js?v0.0.0')}}"></script>
@endpush