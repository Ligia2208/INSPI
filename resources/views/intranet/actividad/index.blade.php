@extends('layouts.main')

@section('title', 'Gestión Tickets')

@section('content')

<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="card">    
    <div class="card-header border-0">
        <h3 class="card-title fw-bolder text-dark">Agenda Digital</h3>
    </div>
    
    <div class="card-body pt-2">
        <div>Para agregar un evento solo debes hacer click en una fecha, para editar y/o borrar hacer click sobre cada evento.</div><br>
        <div id="agenda" name="agenda">
        </div>
    <!-- Modal -->
    <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos del Evento</h5>
                </div>
                <div class="modal-body">
                   <form action="" id="formularioEventos" name="formularioEventos">
                    {{ csrf_field() }}
                       <div class="form-group d-none">
                         <label for="id">ID</label>
                         <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="">
                         <small id="helpId" class="form-text text-muted">&nbsp;</small>
                       </div>
                       <div class="form-group">
                         <label for="title">Título</label>
                         <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="" required="required">
                         <small id="helpId" class="form-text text-muted">&nbsp;</small>
                       </div>
                       <div class="form-group">
                         <label for="descripcion">Descripción</label>
                         <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                         <small id="helpId" class="form-text text-muted">&nbsp;</small>
                       </div>
                       <div class="row">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Fecha Inicio</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="time" class="form-control" name="startH" id="startH" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Hora Inicio</small>
                            </div>
                       </div>
                       <div class="row">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Fecha Fin</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="time" class="form-control" name="endH" id="endH" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Hora Fin</small>
                            </div>
                       </div>                      
                   </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                    <button type="button" class="btn btn-primary" id="btnModificar">Modificar</button>
                    <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrar">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection