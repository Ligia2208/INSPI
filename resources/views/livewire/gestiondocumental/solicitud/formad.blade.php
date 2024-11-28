<div class="container" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection
   
    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-header" wire:ignore>
            <div class="card-title">
                <h3 class="card-label">@yield('title')</h3>
            </div>
            <div class="card-toolbar">
                <i class="navi-item" data-toggle="modal" data-target="_self">
                    <a href="{{ route('solicitud.index') }}" class="navi-link">
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
                    Guardar cambios
                </button>
            </div>
        </div>
        <div class="card-body">

            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>

                            @include('component.error-list')
                             <div class="form-group row">
                                <label class="col-3">Origen del Documento <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model="selectedOrigen"
                                            wire:model.defer="Solicitudes.origen_id"
                                            class="form-control selectpicker show-tick form-control-solid @error('Solicitudes.origen_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-show-subtext="true"                                            
                                            required>
                                            <option value="">Selecciona el origen del documento</option>
                                            @foreach ($origenes as $objOri)
                                                <option data-subtext="" value="{{ $objOri->id }}">{{ $objOri->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el origen del documento</span>
                                    @error('Solicitudes.origen_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Dependencia <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model.defer="Solicitudes.dependencia_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudes.dependencia_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona la dependencia</option>
                                            @if (!is_null($dependencias))
                                            @foreach ($dependencias as $objDep)
                                                <option data-subtext="" value="{{ $objDep->id }}">{{ $objDep->nombre }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la dependencia</span>
                                    @error('Solicitudes.dependencia_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">No. Documento <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <input 
                                            wire:model.defer="Solicitudes.numerodocumento" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Solicitudes.numerodocumento') is-invalid @enderror"  
                                            placeholder="Ej: DIR-INSPI-0982-2022-O" />
                                    </div>
                                    @error('Solicitudes.numerodocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-3">Fecha Documento <span class="text-danger">*</span></label>
                                <div class="col-9" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Solicitudes.fechadocumento"
                                            value="Solicitudes.fechadocumento"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudes.fechadocumento') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha del documento"
                                        />
                                    </div>
                                    @error('Solicitudes.fechadocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Fecha Recepción <span class="text-danger">*</span></label>
                                <div class="col-9" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Solicitudes.fecharecepcion"
                                            value="Solicitudes.fecharecepcion"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudes.fecharecepcion') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de recepción del documento"
                                        />
                                    </div>
                                    @error('Solicitudes.fecharecepcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>                     
                            <div class="form-group row">
                                <label class="col-3">Descripción </label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <textarea 
                                            wire:model.defer="Solicitudes.descripcion"
                                            id="" 
                                            cols="30" 
                                            rows="3"
                                            class="form-control form-control-solid @error('Solicitudes.descripcion') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del asunto del documento" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudes.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Documento Digitalizado <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div class="d-flex jutify-content-start mb-3" >
                                        @if ($SolicitudTmp || $Solicitudes->archivo)
                                            <img 
                                                width="65" 
                                                src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                >
                                            <span 
                                                x-on:click="removeFile('removeSolicitud', 'SolicitudTmp')"
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove" 
                                                style="position: inherit;"
                                                title="Remover cotización">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                <span 
                                                    wire:loading.class="spinner spinner-primary spinner-sm"
                                                    wire:target="removeSolicitud"
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
                                        <div wire:ignore wire:key="Solicitudfile">
                                            <input 
                                                wire:model.defer="SolicitudTmp" 
                                                class="bfi form-control form-control-solid @error('SolicitudTmp') is-invalid @enderror" 
                                                type="file" 
                                                accept=".pdf"
                                                id="SolicitudTmp"
                                                required
                                            />
                                        </div>
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    @error('SolicitudTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2"></div>
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
