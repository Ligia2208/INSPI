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
                    <a href="{{ route('ticket.index') }}" class="navi-link">
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
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Título del ticket<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                        wire:model.defer="Tickets.titulo" 
                                        type="text" 
                                        required
                                        class="form-control form-control-solid @error('Tickets.titulo') is-invalid @enderror"  
                                        placeholder="Ej: Sin acceso a internet" />
                                    </div>
                                    @error('Tickets.titulo') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descripción del Ticket <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-paragraph"></i>
                                            </span>
                                        </div>
                                        <textarea 
                                            wire:model.defer="Tickets.descripcion"
                                            id="" 
                                            cols="30" 
                                            rows="4"
                                            class="form-control form-control-solid @error('Tickets.descripcion') is-invalid @enderror" 
                                            placeholder="Ej: Detalle del problema y/o requerimiento del ticket" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Tickets.descripcion') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Evidencia Digitalizada <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file-pdf"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($TicketTmp || $Tickets->archivo)
                                                <img 
                                                    width="65" 
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.png" alt=""
                                                    >
                                                <span 
                                                    x-on:click="removeFile('removeTicket', 'TicketTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove" 
                                                    style="position: inherit;"
                                                    title="Remover Evidencia del Ticket">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span 
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeTicket"
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
                                            <div wire:ignore wire:key="Ticketfile">
                                                <input 
                                                    wire:model.defer="TicketTmp" 
                                                    class="bfi form-control form-control-solid @error('TicketTmp') is-invalid @enderror" 
                                                    type="file" 
                                                    accept=".jpg,.png,.jpeg"
                                                    id="TicketTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('TicketTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
