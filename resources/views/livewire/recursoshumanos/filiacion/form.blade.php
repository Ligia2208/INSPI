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
                                <div class="form-group col-md-8">
                                    <label for="inputCodigo">Persona <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.persona_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.persona_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Persona</option>
                                            @foreach ($personas as $persona)
                                                <option data-subtext="{{ $persona->identidad }}" value="{{ $persona->id }}">{{ $persona->apellidos }} {{ $persona->nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.persona_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Fecha Ingreso <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Filiaciones.fechaingreso"
                                            value="Filiaciones.fechaingreso"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Filiaciones.fechaingreso') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de ingreso"
                                        />
                                    </div>
                                    @error('Filiaciones.fechaingreso') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Dirección <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.area_id"
                                            wire:model="selectedArea"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.area_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Área/Dirección</option>
                                            @foreach ($areas as $area)
                                                <option data-subtext="" value="{{ $area->id }}">{{ $area->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.area_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Dirección <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.direccion_id"
                                            wire:model="selectedDireccion"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.direccion_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona una Gestión</option>
                                            @if(!is_null($direcciones))
                                            @foreach ($direcciones as $direccion)
                                                <option data-subtext="" value="{{ $direccion->id }}">{{ $direccion->nombre }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('Filiaciones.direccion_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">CRN - Laboratorio - Gestión <span class="text-danger"></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.direcciontecnica_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.direccion_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona una Gestión</option>
                                            @if(!is_null($direccionestecnicas))
                                            @foreach ($direccionestecnicas as $directec)
                                                <option data-subtext="" value="{{ $directec->id }}">{{ $directec->nombre }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('Filiaciones.direccion_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Cargo Asignado <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.cargo_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.cargo_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Cargo</option>
                                            @foreach ($cargos as $cargo)
                                                <option data-subtext="" value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.cargo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Escala Salarial <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.escala_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.escala_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Escala Remunerativa</option>
                                            @foreach ($escalas as $escala)
                                                <option data-subtext="{{ $escala->remuneracion}}" value="{{ $escala->id }}">{{ $escala->grupoocupacional }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.escala_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Sede <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.sede_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.sede_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $sede)
                                                <option data-subtext="{{ $sede->descripcion }}" value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.sede_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Modalidad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.modalidad_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.modalidad_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Modalidad</option>
                                            @foreach ($modalidades as $modalidad)
                                                <option data-subtext="" value="{{ $modalidad->id }}">{{ $modalidad->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.modalidad_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputCodigo">Tipo Discapacidad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.tipodiscapacidad_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.tipodiscapacidad_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Tipo de Discapacidad</option>
                                            @foreach ($tiposdiscapacidad as $tipodisc)
                                                <option data-subtext="" value="{{ $tipodisc->id }}">{{ $tipodisc->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.tipodiscapacidad_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCodigo">Porcentaje <span class="text-danger"></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>

                                        <input
                                            wire:model.defer="Filiaciones.porcentaje"
                                            type="number"
                                            required
                                            value=0
                                            class="form-control form-control-solid @error('Filiaciones.porcentaje') is-invalid @enderror"
                                            placeholder="Ej: 80%" />
                                    </div>
                                    @error('Filiaciones.porcentaje') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Carnet Discapacidad <span class="text-danger"></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Filiaciones.carnet"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Filiaciones.carnet') is-invalid @enderror"
                                            placeholder="Ej: 000293-2021" />
                                    </div>
                                    @error('Filiaciones.carnet') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Correo Institucional <span class="text-danger"></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Filiaciones.mailinstitucional"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Filiaciones.mailinstitucional') is-invalid @enderror"
                                            placeholder="Ej: jmena@inspi.gob.ec" />
                                    </div>
                                    @error('Filiaciones.mailinstitucional') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Usuario asignado <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Filiaciones.user_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.sexo_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Usuario creado</option>
                                            @foreach ($users as $user)
                                                <option data-subtext="{{ $user->email}}" value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.user_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Contrato Digitalizado <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($FiliacionTmp || $Filiaciones->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removeFiliacion', 'FiliacionTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Filiacion">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeFiliacion"
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
                                            <div wire:ignore wire:key="Filiacionfile">
                                                <input
                                                    wire:model.defer="FiliacionTmp"
                                                    class="bfi form-control form-control-solid @error('FiliacionTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf"
                                                    id="FiliacionTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('FiliacionTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
                                </div>
                                @if ($method=='update')
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Fecha de salida <span class="text-danger"></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Filiaciones.fechasalida"
                                            value="Filiaciones.fechasalida"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Filiaciones.fechasalida') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de salida"
                                        />
                                    </div>
                                    @error('Filiaciones.fechasalida') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                @endif
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
