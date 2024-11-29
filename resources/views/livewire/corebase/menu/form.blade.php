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
                <button 
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right" 
                    wire:target="{{ $method }}" 
                    class="btn btn-success font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
            </div>
        </div>
        <div class="card-body">

            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Menú Contenedor <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-list"></i>
                                            </span>
                                            <select 
                                            wire:model.defer="Menues.padre_id" 
                                            class="form-control selectpicker form-control-solid @error('Menues.padre_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required id="slcMenu">
                                            <option value="">Selecciona Menú Principal</option>
                                            @foreach ($menus as $objMen)
                                                <option data-subtext="{{ $objMen->descripcion }}" value="{{ $objMen->nivel_id }}">{{ $objMen->titulo }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        
                                    </div>
                                    @error('Menues.tipo')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>                              
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Título <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Menues.titulo" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Menues.titulo') is-invalid @enderror"  
                                            placeholder="Ej: Intranet" />
                                    </div>
                                    @error('Menues.titulo')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Menues.descripcion" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Menues.descripcion') is-invalid @enderror"  
                                            placeholder="Ej: Grupo Administración Asistencias" />
                                    </div>
                                    @error('Menues.descripcion') 
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Ruta <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Menues.ruta" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Menues.ruta') is-invalid @enderror"  
                                            placeholder="Ej: gestion.index" />
                                    </div>
                                    @error('Menues.ruta')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Permiso <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Menues.permiso" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Menues.permiso') is-invalid @enderror"  
                                            placeholder="Ej: controles" />
                                    </div>
                                    @error('Menues.permiso')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">icono <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Menues.icono" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Menues.icono') is-invalid @enderror"  
                                            placeholder="Ej: fa fa-icono" />
                                    </div>
                                    @error('Menues.icono')
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
    </div>
    <!--end::Card-->
    @push('footer')
        <script src="{{ asset('assets/plugins/custom/bfi/bfi.js') }}"></script>
        <script src="{{ asset('assets') }}/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
        <script>
            Livewire.on('renderJs', function(){
                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });
            });
        </script>
    @endpush        
</div>
