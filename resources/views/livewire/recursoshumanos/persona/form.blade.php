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
                                            wire:model.defer="Personas.tipodocumento_id"
                                            class="form-control selectpicker form-control-solid @error('Personas.tipodocumento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona un Tipo de Documento</option>
                                            @foreach ($tiposdocumento as $tipo)
                                                <option data-subtext="" value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Personas.tipodocumento_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
                                            wire:model.defer="Personas.identidad"
                                            type="text"
                                            class="form-control form-control-solid @error('Personas.identidad') is-invalid @enderror"
                                            placeholder="Ej: 0900786521" />
                                    </div>
                                    @error('Personas.identidad') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            wire:model.defer="Personas.sexo_id"
                                            class="form-control selectpicker form-control-solid @error('Personas.sexo_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una opción Sexo</option>
                                            @foreach ($sexos as $sexo)
                                                <option data-subtext="" value="{{ $sexo->id }}">{{ $sexo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Personas.sexo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
                                            wire:model.defer="Personas.nacionalidad_id"
                                            class="form-control selectpicker form-control-solid @error('Personas.nacionalidad_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Nacionalidad</option>
                                            @foreach ($nacionalidades as $nacionalidad)
                                                <option data-subtext="{{$nacionalidad->nacionalidad}}" value="{{ $nacionalidad->id }}">{{ $nacionalidad->nombrepais }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Personas.nacionalidad_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Estado Civil <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Personas.estadocivil_id"
                                            class="form-control selectpicker form-control-solid @error('Personas.estadocivil_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una opción Estado Civil</option>
                                            @foreach ($estadoscivil as $estciv)
                                                <option data-subtext="" value="{{ $estciv->id }}">{{ $estciv->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Personas.estadocivil_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
                                            wire:model.defer="Personas.nombres"
                                            type="text"
                                            class="form-control form-control-solid @error('Personas.nombres') is-invalid @enderror"
                                            placeholder="Ej: Juan Ernesto" />
                                    </div>
                                    @error('Personas.nombres') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            wire:model.defer="Personas.apellidos"
                                            type="text"
                                            class="form-control form-control-solid @error('Personas.apellidos') is-invalid @enderror"
                                            placeholder="Ej: Soto Medina" />
                                    </div>
                                    @error('Personas.apellidos') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Fecha Nacimiento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-date"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Personas.fechanacimiento"
                                            value="Personas.fechanacimiento"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Personas.fechanacimiento') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de nacimiento"
                                        />
                                    </div>
                                    @error('Personas.fechanacimiento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Tipo de Sangre <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Personas.tiposangre_id"
                                            class="form-control selectpicker form-control-solid @error('Personas.tiposangre_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una opción Tipo de Sangre</option>
                                            @foreach ($tipossangre as $tipsan)
                                                <option data-subtext="" value="{{ $tipsan->id }}">{{ $tipsan->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Personas.tiposangre_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Dirección <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Personas.direccion"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Personas.direccion') is-invalid @enderror"
                                            placeholder="Ej: Cdla. Santa Leonor mz.5 villa 17" />
                                    </div>
                                    @error('Personas.direccion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Teléfonos <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Personas.telefono"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Personas.telefono') is-invalid @enderror"
                                            placeholder="Ej: 042874612" />
                                    </div>
                                    @error('Personas.telefono') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Correo electrónico <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Personas.correo"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Personas.correo') is-invalid @enderror"
                                            placeholder="Ej: juan_rivera_2000@gmail.com" />
                                    </div>
                                    @error('Personas.correo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Hoja de Vida Digitalizada <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($PersonaTmp || $Personas->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removePersona', 'PersonaTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Persona">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removePersona"
                                                        style="position: absolute; left: 81px;">
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            x-data="{ isUploading: false, progress: 0 }"
                                            x-on:livewire-upload-start="isUploading = true"
                                            x-on:livewire-upload-finish="isUploading = false"
                                            x-on:livewire-upload-error="isUploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                                            >
                                            <div wire:ignore wire:key="Personafile">
                                                <input
                                                    wire:model.defer="PersonaTmp"
                                                    class="bfi form-control form-control-solid @error('PersonaTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf"
                                                    id="PersonaTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('PersonaTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
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
