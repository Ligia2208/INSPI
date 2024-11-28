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
                                            wire:model.defer="Areas.nombre"
                                            type="text"
                                            class="form-control form-control-solid @error('Areas.nombre') is-invalid @enderror"
                                            placeholder="Ej: Gestión de redes sociales" />
                                    </div>
                                    @error('Areas.nombre')
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
                                            wire:model.defer="Areas.descripcion"
                                            type="text"
                                            class="form-control form-control-solid @error('Areas.descripcion') is-invalid @enderror"
                                            placeholder="Ej: Funciones de la Dirección" />
                                    </div>
                                    @error('Areas.descripcion')
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
