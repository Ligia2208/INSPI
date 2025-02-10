<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
        <script src="{{asset('assets')}}/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
              selector: '#mytextarea',
              license_key: 'gpl|<your-license-key>'
            });
          </script>
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-header" >
            <div class="card-title">
                <h3 class="card-label">@yield('title')</h3>
            </div>
            <div class="card-toolbar">
                <i class="navi-item" data-toggle="modal" data-target="_self">
                    <a href="{{ route('resolucion.index') }}" class="navi-link">
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
                                    <label>Titulo de la Resolución </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Resoluciones.titulo"
                                            id=""
                                            cols="30"
                                            rows="2"
                                            class="form-control form-control-solid @error('Resoluciones.titulo') is-invalid @enderror"
                                            placeholder="Ej: Breve descripción del asunto">
                                        </textarea>
                                    </div>
                                    @error('Resoluciones.titulo')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Tipo de Resolucion<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Resoluciones.tipo_id"
                                            class="form-control selectpicker form-control-solid @error('Resoluciones.tipo_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($tipos as $objTip)
                                                <option data-subtext="" value="{{ $objTip->id }}">{{ $objTip->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Tipo de Resolucion</span>
                                    @error('Resoluciones.tipo_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="inputResumen">Número Resolución <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input
                                            wire:model.defer="Resoluciones.numero"
                                            type="text"
                                            required
                                            class="form-control @error('Resoluciones.numero') is-invalid @enderror"
                                            placeholder="Ej: Convenio especifico para la ejecución" />
                                    </div>
                                    @error('Resoluciones.numero') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputResumen">Año-Periodo <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input
                                            wire:model.defer="Resoluciones.anio"
                                            type="text"
                                            required
                                            class="form-control @error('Resoluciones.anio') is-invalid @enderror"
                                            placeholder="Ej: Convenio especifico para la ejecución" />
                                    </div>
                                    @error('Resoluciones.anio') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Fecha Firma<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Resoluciones.fechafirma"
                                            value="Resoluciones.fechafirma"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Resoluciones.fechafirma') is-invalid @enderror"
                                            placeholder="Seleccione la fecha firma del convenio"
                                        />
                                    </div>
                                    @error('Resoluciones.fechafirma')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Director Ejecutivo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Resoluciones.director_id"
                                            class="form-control selectpicker form-control-solid @error('Resoluciones.director_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            @foreach ($directores as $objDir)
                                                <option data-subtext="" value="{{ $objDir->id }}">{{ $objDir->nombre_director }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Director</span>
                                    @error('Resoluciones.director_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Acuerdos de la Resolucion </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Resoluciones.resolucion"
                                            id="mytextarea"
                                            cols="50"
                                            rows="4"
                                            class="form-control form-control-solid @error('Resoluciones.resolucion') is-invalid @enderror"
                                            placeholder="Ej: Transcripción de la sección ACUERDA"
                                            >
                                        </textarea>
                                    </div>
                                    @error('Resoluciones.resolucion')
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
                                            @if ($ResolucionTmp || $Resoluciones->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removeResolucion', 'ResolucionTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Resolucion">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeResolucion"
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
                                            <div wire:ignore wire:key="Resolucionfile">
                                                <input
                                                    wire:model.defer="ResolucionTmp"
                                                    class="bfi form-control form-control-solid @error('ResolucionTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf"
                                                    id="ResolucionTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('ResolucionTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
