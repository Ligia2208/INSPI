<div>
    <div class="card card-custom">
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Nombre <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Tecnicos.nombre"
                                            type="text"
                                            class="form-control form-control-solid @error('Tecnicos.nombre') is-invalid @enderror"
                                            placeholder="Ej: Gestión de redes sociales" />
                                    </div>
                                    @error('Tecnicos.nombre')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <textarea class="form-control form-control-solid @error('Tecnicos.descripcion_actividades') is-invalid @enderror"
                                        wire:model.defer="Tecnicos.descripcion_actividades"
                                        rows=5
                                        placeholder="Ej: Descripción de lo solicitado en el ticket">{$Tecnicos->descripcion}</textarea>
                                    </div>
                                    @error('Tecnicos.descripcion_actividades')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Usuarios <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tecnicos.usuario_id"
                                            class="form-control selectpicker form-control-solid @error('Tecnicos.usuario_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Usuario</option>
                                            @foreach ($usuarios as $objUser)
                                                <option data-subtext=""
                                                    value="{{ $objUser->id }}">{{ $objUser->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tecnicos.usuario_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="card-toolbar" style="align: center">
                <button
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right"
                    wire:loading.attr="disabled"
                    wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>
