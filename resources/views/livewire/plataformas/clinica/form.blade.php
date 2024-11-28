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
                    <a href="{{ route('especimen.index') }}" class="navi-link">
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
                                <div class="col-12">
                                    <label for="inputTipo">Especimen <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Clinicas.especimen_id" 
                                            type="text" 
                                            required
                                            class="form-control @error('Clinicas.especimen_id') is-invalid @enderror"  
                                            />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Fecha Aplicación<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                            </div>
                                            <input
                                                wire:model.defer="Clinicas.fecha"
                                                value="Clinicas.fecha"
                                                type="date" 
                                                class="start_date form-control form-control-solid @error('Clinicas.fecha') is-invalid @enderror"  
                                                placeholder="Seleccione la fecha de compra del Artículo"
                                            />
                                        </div>
                                        @error('Clinicas.fecha') 
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                <div class="input-group input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </div>
                                    <input 
                                    wire:model.defer="Clinicas.descripcion" 
                                    type="text" 
                                    class="form-control form-control-solid @error('Clinicas.descripcion') is-invalid @enderror"  
                                    placeholder="Ej: via subcutanea normal" /> 
                                </div>
                                @error('Clinicas.descripcion') 
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
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
