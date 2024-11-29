<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-header" >
            <div class="card-title">
                <h3 class="card-label">@yield('title')</h3>
            </div>
            <div class="card-toolbar">
                <i class="navi-item" data-toggle="modal" data-target="_self">
                    <a href="{{ route('convenio.index') }}" class="navi-link">
                    <span class="navi-icon">
                    <i class="ace-icon fa fa-reply" style="color:orange" title="Regresar"></i>
                    </span>
                    </a>
                </i>
                &nbsp;&nbsp;
                <button
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
        <div class="card-body">

            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-1"></div>
                    <div class="col-xl-10">
                        <div class="my-5">
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>

                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nombre del Convenio </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Convenios.nombre"
                                            id=""
                                            cols="30"
                                            rows="3"
                                            class="form-control form-control-solid @error('Convenios.nombre') is-invalid @enderror"
                                            placeholder="Ej: Transcripción del nombre del convenio">
                                        </textarea>
                                    </div>
                                    @error('Convenios.nombre')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Institución Principal<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.institucionprincipal_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.institucionprincipal_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($instituciones as $objIns)
                                                <option data-subtext="" value="{{ $objIns->id }}">{{ $objIns->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la Institución</span>
                                    @error('Convenios.institucionprincipal_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Institución Secundaria</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.institucionsecundaria_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.institucionsecundaria_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($instituciones as $objIns)
                                                <option data-subtext="" value="{{ $objIns->id }}">{{ $objIns->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la Institución</span>
                                    @error('Convenios.institucionsecundaria_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Ámbito del Convenio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.ambitoconvenio_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.ambitoconvenio_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($ambitos as $objAmb)
                                                <option data-subtext="" value="{{ $objAmb->id }}">{{ $objAmb->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el ámbito del Convenio</span>
                                    @error('Convenios.ambitoconvenio_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tipo de Convenio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.tipoconvenio_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.tipoconvenio_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($tipos as $objTip)
                                                <option data-subtext="" value="{{ $objTip->id }}">{{ $objTip->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Tipo de Convenio</span>
                                    @error('Convenios.tipoconvenio_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Articulación IES<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.articulaies_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.articulaies_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($ies as $objIes)
                                                <option data-subtext="" value="{{ $objIes->id }}">{{ $objIes->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Tipo de IES</span>
                                    @error('Convenios.articulaies_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Articulación Sectores<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.articulasector_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.articulasector_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($sectores as $objSec)
                                                <option data-subtext="" value="{{ $objSec->id }}">{{ $objSec->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Sector Público - Privado</span>
                                    @error('Convenios.articulasector_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Articulación Internacional<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.articulaubica_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.articulaubica_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($ubicaciones as $objUbi)
                                                <option data-subtext="" value="{{ $objUbi->id }}">{{ $objUbi->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije Articulación Internacional</span>
                                    @error('Convenios.articulaubica_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Fecha Firma<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Convenios.fechafirma"
                                            value="Convenios.fechafirma"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Convenios.fechafirma') is-invalid @enderror"
                                            placeholder="Seleccione la fecha firma del convenio"
                                        />
                                    </div>
                                    @error('Convenios.fechafirma')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Fecha Vigencia<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Convenios.fechavigencia"
                                            value="Convenios.fechavigencia"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Convenios.fechavigencia') is-invalid @enderror"
                                            placeholder="Seleccione la fecha vigencia del convenio"
                                        />
                                    </div>
                                    @error('Convenios.fechavigencia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tiempo Vigencia<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Convenios.tiempovigencia"
                                            type="number"
                                            required
                                            class="form-control form-control-solid @error('Convenios.tiempovigencia') is-invalid @enderror"
                                            placeholder="Ej: 8 años" />
                                    </div>
                                    @error('Convenios.tiempovigencia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Objetivo del Convenio </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Convenios.objetivo"
                                            id=""
                                            cols="30"
                                            rows="4"
                                            class="form-control form-control-solid @error('Convenios.objetivo') is-invalid @enderror"
                                            placeholder="Ej: Transcripción del objetivo del convenio"
                                            >
                                        </textarea>
                                    </div>
                                    @error('Convenios.objetivo')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Acuerdos del Convenio - Responsabilidad INSPI </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Convenios.acuerdos"
                                            id=""
                                            cols="30"
                                            rows="4"
                                            class="form-control form-control-solid @error('Convenios.acuerdos') is-invalid @enderror"
                                            placeholder="Ej: Transcripción de los acuerdos del convenio - INSPI"
                                            >
                                        </textarea>
                                    </div>
                                    @error('Convenios.acuerdos')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Acuerdos del Convenio - Responsabilidad Externos </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Convenios.acuerdosexternos"
                                            id=""
                                            cols="30"
                                            rows="4"
                                            class="form-control form-control-solid @error('Convenios.acuerdosexternos') is-invalid @enderror"
                                            placeholder="Ej: Transcripción de los acuerdos del convenio - Parte Externa"
                                            >
                                        </textarea>
                                    </div>
                                    @error('Convenios.acuerdosexternos')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Contacto Interno<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.contactointerno_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.contactointerno_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($users as $objUse)
                                                <option data-subtext="" value="{{ $objUse->id }}">{{ $objUse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Contacto Interno</span>
                                    @error('Convenios.contactointerno_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Estado Convenio</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Convenios.estadoconvenio_id"
                                            class="form-control selectpicker form-control-solid @error('Convenios.estadoconvenio_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($estados as $objEst)
                                                <option data-subtext="" value="{{ $objEst->id }}">{{ $objEst->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el estado del convenio</span>
                                    @error('Convenios.estadoconvenio_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Contacto Externo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                        wire:model.defer="Convenios.contactoexterno"
                                        type="text"
                                        required
                                        class="form-control form-control-solid @error('Convenios.contactoexterno') is-invalid @enderror"
                                        placeholder="Ej: Ing. Carlos Luis Morales" />
                                    </div>
                                    @error('Convenios.contactoexterno')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Correo Contacto Externo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                        wire:model.defer="Convenios.correoexterno"
                                        type="text"
                                        required
                                        class="form-control form-control-solid @error('Convenios.correoexterno') is-invalid @enderror"
                                        placeholder="Ej: contacto@institucion.com" />
                                    </div>
                                    @error('Convenios.correoexterno')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Documento Digitalizado <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($ConvenioTmp || $Convenios->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removeConvenio', 'ConvenioTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Convenio">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeConvenio"
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
                                            <div wire:ignore wire:key="Conveniofile">
                                                <input
                                                    wire:model.defer="ConvenioTmp"
                                                    class="bfi form-control form-control-solid @error('ConvenioTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf"
                                                    id="ConvenioTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('ConvenioTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-1"></div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
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
                        bfi_clear('#'+fileId);
                    },
                }
            }

            Livewire.on('renderJs', function(){
                $('.selectpicker').selectpicker({
                    liveSearch: true
                });
            });
        </script>
    @endsection

</div>
