<div class="container" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-body">

            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Tipo de Documento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Pacientes.tipodocumento_id"
                                            class="form-control selectpicker form-control-solid @error('Pacientes.tipodocumento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona un Tipo de Documento</option>
                                            @foreach ($tiposdocumento as $tipo)
                                                <option data-subtext="" value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Pacientes.tipodocumento_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Identidad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.identidad"
                                            type="text"
                                            class="form-control form-control-solid @error('Pacientes.identidad') is-invalid @enderror"
                                            placeholder="Ej: 0900786521" />
                                    </div>
                                    @error('Pacientes.identidad') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Sexo <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Pacientes.sexo_id"
                                            class="form-control selectpicker form-control-solid @error('Pacientes.sexo_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una opción Sexo</option>
                                            @foreach ($sexos as $sexo)
                                                <option data-subtext="" value="{{ $sexo->id }}">{{ $sexo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Pacientes.sexo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="inputCodigo">Nacionalidad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Pacientes.nacionalidad_id"
                                            class="form-control selectpicker form-control-solid @error('Pacientes.nacionalidad_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Nacionalidad</option>
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option data-subtext="{{$nacionalidad->nacionalidad}}" value="{{ $nacionalidad->id }}">{{ $nacionalidad->nombrepais }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Pacientes.nacionalidad_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Fecha Nacimiento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-date"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.fechanacimiento"
                                            value="Pacientes.fechanacimiento"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Pacientes.fechanacimiento') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de nacimiento"
                                        />
                                    </div>
                                    @error('Pacientes.fechanacimiento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Nombres <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.nombres"
                                            type="text"
                                            class="form-control form-control-solid @error('Pacientes.nombres') is-invalid @enderror"
                                            placeholder="Ej: Juan Ernesto" />
                                    </div>
                                    @error('Pacientes.nombres') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Apellidos <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.apellidos"
                                            type="text"
                                            class="form-control form-control-solid @error('Pacientes.apellidos') is-invalid @enderror"
                                            placeholder="Ej: Soto Medina" />
                                    </div>
                                    @error('Pacientes.apellidos') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputCodigo">Dirección <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.direccion"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Pacientes.direccion') is-invalid @enderror"
                                            placeholder="Ej: Cdla. Santa Leonor mz.5 villa 17" />
                                    </div>
                                    @error('Pacientes.direccion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCodigo">Teléfonos <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Pacientes.telefono"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Pacientes.telefono') is-invalid @enderror"
                                            placeholder="Ej: 042874612" />
                                    </div>
                                    @error('Pacientes.telefono') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Provincia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Pacientes.provincia_id"
                                            class="form-control selectpicker form-control-solid @error('Pacientes.provincia_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Provincia</option>
                                            @foreach ($provincias as $objPro)
                                                <option data-subtext="" value="{{ $objPro->id }}">{{ $objPro->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Pacientes.provincia_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Cantón <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Pacientes.canton_id"
                                            class="form-control selectpicker form-control-solid @error('Pacientes.canton_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona un Cantón</option>
                                            @foreach ($cantones as $objCan)
                                                <option data-subtext="" value="{{ $objCan->id }}">{{ $objCan->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Pacientes.canton_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
        </div>
        <div class="card-header" wire:ignore>
            <div class="card-toolbar">
                <button
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar cambios
                </button>
            </div>
        </div>
    </div>
    <!--end::Card-->
    @push('footer')
        <script src="{{ asset('assets/plugins/custom/bfi/bfi.js') }}"></script>
        <script src="{{ asset('assets') }}/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
        <script>
            function app() {
                return {
                    removeFile(functionRemove, fileId) {
                        @this.call(functionRemove);
                        bfi_clear('#'+fileId);
                    },
                }
            }
            Livewire.on('renderJs', function(){
                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });
            });
        </script>
    @endpush
</div>
