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
                    <a href="{{ route('evidencia.show', 1 ) }}" class="navi-link">
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
                            <div class="form-group row" hidden>
                                <div class="col-8">
                                    <label for="inputTipo">Tipo Evidencia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Evidencias.evento_id" 
                                            type="text" 
                                            required
                                            class="form-control @error('Evidencias.evento_id') is-invalid @enderror"  
                                            />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-8">
                                    <label for="inputTipo">Tipo Evidencia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model.defer="Evidencias.tipoevidencia_id" 
                                            class="form-control selectpicker form-control-solid @error('Evidencias.tipoevidencia_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            required>
                                            <option value="">Selecciona Tipo de evidencia</option>
                                            @foreach ($tiposevidencia as $objTie)
                                                <option data-subtext="" value="{{ $objTie->id }}">{{ $objTie->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>                   
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResumen">Descripción de la evidencia <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Evidencias.descripcion" 
                                            type="text" 
                                            required
                                            class="form-control @error('Evidencias.descripcion') is-invalid @enderror"  
                                            placeholder="Ej: Convenio especifico para la ejecución" />
                                    </div>
                                    @error('Evidencias.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="inputArchivo">Documento Digitalizado <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-file-pdf"></i>
                                        </span>
                                        <div class="d-flex jutify-content-start mb-3" >
                                            @if ($EvidenciaTmp || $Evidencias->archivo)
                                                <img 
                                                    width="65" 
                                                    src="{{ asset('assets') }}/media/svg/files/filex.svg" alt=""
                                                    >
                                                <span 
                                                    x-on:click="removeFile('removeEvidencia', 'EvidenciaTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove" 
                                                    style="position: inherit;"
                                                    title="Remover archivo">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span 
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeEvidencia"
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
                                            <div wire:ignore wire:key="Eventofile">
                                                <input 
                                                    wire:model.defer="EvidenciaTmp" 
                                                    class="bfi form-control form-control-solid @error('EvidenciaTmp') is-invalid @enderror" 
                                                    type="file" 
                                                    accept=".pdf||.png||.jpg||.jpeg"
                                                    id="EvidenciaTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('EvidenciaTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
