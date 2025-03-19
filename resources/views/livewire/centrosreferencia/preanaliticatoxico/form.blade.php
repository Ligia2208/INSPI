<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card">
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            <a href="{{ route('preanaliticatoxico.index') }}"
                                class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha de Recepción<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_recepcion"
                                            value="Preanaliticastoxico.fecha_recepcion" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_recepcion') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Institución de Salud<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.instituciones_id"
                                            wire:model="changedInstitucion"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Institución de Salud</option>
                                            @foreach ($instituciones as $objIns)
                                                <option
                                                    data-subtext="{{ $objIns->provincia->descripcion }} - {{ $objIns->canton->descripcion }}"
                                                    value="{{ $objIns->id }}">{{ $objIns->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipología IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticastoxico.institucion_tipologia"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticastoxico.institucion_tipologia') is-invalid @enderror"
                                            placeholder="Ej: MSP - IESS - SOLCA" />
                                    </div>
                                    @error('Preanaliticastoxico.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Denominación IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticastoxico.institucion_nombre"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticastoxico.institucion_nombre') is-invalid @enderror"
                                            placeholder="Ej: Teodoro Maldonado C." />
                                    </div>
                                    @error('Preanaliticastoxico.institucion_nombre')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Clasificación IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticastoxico.institucion_clasificacion"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticastoxico.institucion_clasificacion') is-invalid @enderror"
                                            placeholder="Ej: Centro de Salud Tipo A" />
                                    </div>
                                    @error('Preanaliticastoxico.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nivel IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.institucion_nivel"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticastoxico.institucion_nivel') is-invalid @enderror"
                                            placeholder="Ej: Nivel 1" />
                                    </div>
                                    @error('Preanaliticastoxico.institucion_nivel')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Provincia - Cantón<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.institucion_ubicacion"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticastoxico.institucion_ubicacion') is-invalid @enderror"
                                            placeholder="Ej: Guayas - Guayaquil" />
                                    </div>
                                    @error('Preanaliticastoxico.institucion_ubicacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-1" style="display:none">
                                    <label>Id<span class="text-danger"></span></label>
                                    <input wire:model.defer="Preanaliticastoxico.paciente_id" type="text" required
                                        class="form-control form-control-solid @error('Preanaliticastoxico.paciente_id') is-invalid @enderror"
                                        placeholder="Ej: 123" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Identificación Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.identidad"
                                            wire:model="changedIdentidad" type="text" required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.identidad') is-invalid @enderror"
                                            placeholder="Ej: 0900786523" />
                                    </div>
                                    @error('Preanaliticastoxico.identidad')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Apellidos Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.paciente_apellidos" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.paciente_apellidos') is-invalid @enderror"
                                            placeholder="Ej: Jácome Castro" />
                                    </div>
                                    @error('Preanaliticastoxico.paciente_apellidos')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Nombres Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.paciente_nombres" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.paciente_nombres') is-invalid @enderror"
                                            placeholder="Ej: Fernanda Lorena" />
                                    </div>
                                    @error('Preanaliticastoxico.paciente_nombres')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Sexo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.paciente_sexo"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.paciente_sexo') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Sexo</option>
                                            @foreach ($sexos as $objSex)
                                                <option data-subtext="" value="{{ $objSex->id }}">
                                                    {{ $objSex->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Nacimiento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.paciente_fechanac"
                                            value="Preanaliticastoxico.paciente_fechanac" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.paciente_fechanac') is-invalid @enderror"
                                            placeholder="Seleccione la fecha nacimiento" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Dirección<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.paciente_direccion" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.paciente_direccion') is-invalid @enderror"
                                            placeholder="Ej: Urdesa Central" />
                                    </div>
                                    @error('Preanaliticastoxico.paciente_direccion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Teléfono<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.paciente_telefono" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.paciente_telefono') is-invalid @enderror"
                                            placeholder="Ej: 0998253411" />
                                    </div>
                                    @error('Preanaliticastoxico.paciente_telefono')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ubicación<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.paciente_ubicacion"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.paciente_ubicacion') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Cantón</option>
                                            @foreach ($cantonprov as $objCanton)
                                                <option data-subtext="{{ $objCanton->provincia->descripcion }}" value="{{ $objCanton->id }}">
                                                    {{ $objCanton->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Preanaliticastoxico.paciente_ubicacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nacionalidad<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.paciente_nacionalidad"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.paciente_nacionalidad') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Nacionalidad</option>
                                            @foreach ($nacionalidades as $objNacion)
                                                <option data-subtext="" value="{{ $objNacion->id }}">
                                                    {{ $objNacion->nacionalidad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Preanaliticastoxico.paciente_nacionalidad')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha de atención<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_atencion"
                                            value="Preanaliticastoxico.fecha_atencion" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_atencion') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de atención" />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nombre de quien notifica<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.quien_notifica" type="text" required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.quien_notifica') is-invalid @enderror"
                                            placeholder="Ej: Dr. Julio Robles" />
                                    </div>
                                    @error('Preanaliticastoxico.quien_notifica')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Referencia lugar<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.probable_infeccion" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticastoxico.probable_infeccion') is-invalid @enderror"
                                            placeholder="Ej: Sur de la ciudad" />
                                    </div>
                                    @error('Preanaliticastoxico.probable_infeccion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.sedes_id" wire:model="selectedSedep"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">
                                                    {{ $objSed->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Centro de Referencia - Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Preanaliticastoxico.crns_id"
                                            wire:model.live="selectedCrnp"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.crns_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required value=3>
                                            <option value="">Selecciona un CRN</option>
                                            @if (!is_null($crns))
                                                @foreach ($crns as $objCrn)
                                                    <option data-subtext="" value="{{ $objCrn->id }}">
                                                        {{ $objCrn->descripcion }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Evento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.evento_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Evento</option>
                                            @if (!is_null($eventos))
                                                @foreach ($eventos as $objEvento)
                                                    <option data-subtext="{{ $objEvento->descripcion }}"
                                                        value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ficha Digitalizada </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($PreanaliticaTmp || $Preanaliticastoxico->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removePreanalitica', 'PreanaliticaTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Ficha">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removePreanalitica"
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
                                            <div wire:ignore wire:key="Preanaliticafile">
                                                <input
                                                    wire:model.defer="PreanaliticaTmp"
                                                    class="bfi form-control form-control-solid @error('AnaliticaTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf"
                                                    id="PreanaliticaTmp"
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('PreanaliticaTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.clase_primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una clase muestra</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">
                                                    {{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Muestra Principal<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_toma_primera"
                                            value="Preanaliticastoxico.fecha_toma_primera" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_toma_primera') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.estado_primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.estado_primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.observacion_primera" type="text"
                                            class="form-control form-control-solid @error('Preanaliticastoxico.observacion_primera') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticastoxico.observacion_primera')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                &nbsp;&nbsp;
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="fa fa-plus icon-lg" onclick="ver_ocultar()"
                                        title="Agregar mas muestras"></i>
                                </button>
                            </div>
                            <div class="form-row" id="add_muestras" style="visibility:hidden">
                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.clase_segunda_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.clase_segunda_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona una clase muestra</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">
                                                    {{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.segunda_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.segunda_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_toma_segunda"
                                            value="Preanaliticastoxico.fecha_toma_segunda" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_toma_segunda') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.estado_segunda_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.estado_segunda_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.observacion_segunda" type="text"
                                            class="form-control form-control-solid @error('Preanaliticastoxico.observacion_segunda') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticastoxico.observacion_segunda')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.clase_tercera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.clase_tercera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona una clase muestra</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">
                                                    {{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.tercera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.tercera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_toma_tercera"
                                            value="Preanaliticastoxico.fecha_toma_tercera" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_toma_tercera') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.estado_tercera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.estado_tercera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.observacion_tercera" type="text"
                                            class="form-control form-control-solid @error('Preanaliticastoxico.observacion_tercera') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticastoxico.observacion_tercera')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.clase_cuarta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.clase_cuarta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona una clase muestra</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">
                                                    {{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.cuarta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.cuarta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_toma_cuarta"
                                            value="Preanaliticastoxico.fecha_toma_cuarta" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_toma_cuarta') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.estado_cuarta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.estado_cuarta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.observacion_cuarta" type="text"
                                            class="form-control form-control-solid @error('Preanaliticastoxico.observacion_cuarta') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticastoxico.observacion_cuarta')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.clase_quinta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.clase_quinta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona una clase muestra</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">
                                                    {{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.quinta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.quinta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.fecha_toma_quinta"
                                            value="Preanaliticastoxico.fecha_toma_quinta" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticastoxico.fecha_toma_quinta') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticastoxico.estado_quinta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticastoxico.estado_quinta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticastoxico.observacion_quinta" type="text"
                                            class="form-control form-control-solid @error('Preanaliticastoxico.observacion_quinta') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticastoxico.observacion_quinta')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
        </div>
        <div class="card-header">
            <div class="card-toolbar">
                <button wire:click="{{ $method }}" wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}" class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
    <!--end::Card-->

    @section('footer')
        <script src="{{ asset('assets/plugins/custom/bfi/bfi.js') }}"></script>
        <script src="{{ asset('assets') }}/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
        <script>
            function app() {
                return {
                    removeFile(functionRemove, fileId) {
                        @this.call(functionRemove);
                        bfi_clear('#' + fileId);
                    },
                }
            }

            Livewire.on('renderJs', function() {
                $('.selectpicker').selectpicker({
                    liveSearch: true
                });
            });

            function ver_ocultar() {
                var x = document.getElementById("add_muestras");
                if (x.style.visibility === "visible") {
                    x.style.visibility = "hidden";
                } else {
                    x.style.visibility = "visible";
                }
            }
        </script>
    @endsection

</div>
