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
                                    <label for="inputCodigo">Áreas <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Cargos.area_id"
                                            class="form-control selectpicker form-control-solid @error('Cargos.area_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Área</option>
                                            @foreach ($areas as $objArea)
                                                <option data-subtext="{{ $objArea->descripcion }}" value="{{ $objArea->id }}">{{ $objArea->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Cargos.area_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Dirección/Coordinación <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Cargos.direccion_id"
                                            class="form-control selectpicker form-control-solid @error('Cargos.direccion_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Dirección/Coordinación</option>
                                            @foreach ($direcciones as $objDir)
                                                <option data-subtext="{{ $objDir->descripcion }}" value="{{ $objDir->id }}">{{ $objDir->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Cargos.direccion_id')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                                        wire:model.defer="Cargos.nombre"
                                        type="text"
                                        class="form-control form-control-solid @error('Cargos.nombre') is-invalid @enderror"
                                        placeholder="Ej: Asistente Administrativo 1" />
                                    </div>
                                    @error('Cargos.nombre')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                    </div>
                                        <input
                                        wire:model.defer="Cargos.descripcion"
                                        type="text"
                                        class="form-control form-control-solid @error('Cargos.descripcion') is-invalid @enderror"
                                        placeholder="Ej: Cumple funciones en la Dirección Administrativa" />
                                    </div>
                                    @error('Cargos.descripcion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-header">
            <div class="card-toolbar">
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
