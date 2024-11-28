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
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Responsables.sedes_id"
                                            class="form-control selectpicker form-control-solid @error('Responsables.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">
                                                    {{ $objSed->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Responsables.sedes_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Centro de Referencia - Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Responsables.crns_id"
                                            class="form-control selectpicker form-control-solid @error('Responsables.crns_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un CRN</option>
                                            @if (!is_null($crns))
                                                @foreach ($crns as $objCrn)
                                                    <option data-subtext="" value="{{ $objCrn->id }}">
                                                        {{ $objCrn->descripcion }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('Responsables.crns_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Tipo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Responsables.tipo_id"
                                            class="form-control selectpicker form-control-solid @error('Responsables.tipo_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Tipo</option>
                                            @foreach ($tipos as $objTipo)
                                                <option data-subtext="" value="{{ $objTipo->id }}">
                                                    {{ $objTipo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Responsables.tipo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <textarea class="form-control form-control-solid @error('Responsables.descripcion') is-invalid @enderror"
                                            wire:model.defer="Responsables.descripcion" rows=5 placeholder="Ej: Descripción de la designación">{$Responsables->descripcion}</textarea>
                                    </div>
                                    @error('Responsables.descripcion')
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
                                        <select wire:model.defer="Responsables.usuario_id"
                                            class="form-control selectpicker form-control-solid @error('Responsables.usuario_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Usuario</option>
                                            @foreach ($usuarios as $objUser)
                                                <option data-subtext="" value="{{ $objUser->id }}">{{ $objUser->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Responsables.usuario_id')
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
                <button wire:click="{{ $method }}" wire:loading.class="spinner spinner-white spinner-right"
                    wire:loading.attr="disabled" wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
</div>
