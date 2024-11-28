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
                    <div class="col-xl-12">
                        <div class="my-5">
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Fecha Ingreso/Nacimiento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-date"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Especimenes.nacimiento_admision"
                                            value="Especimenes.nacimiento_admision"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Especimenes.nacimiento_admision') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de nacimiento/admisión"
                                        />
                                    </div>
                                    @error('Especimenes.nacimiento_admision') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Tipo/Especie <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Especimenes.especie_id" 
                                            class="form-control selectpicker form-control-solid @error('Especimenes.especie_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Especie</option>
                                            @foreach ($especies as $objEsp)
                                                <option data-subtext="" value="{{ $objEsp->id }}">{{ $objEsp->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Especimenes.especie_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                
                            </div>                
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Sexo/Especie <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Especimenes.sexo_id" 
                                            class="form-control selectpicker form-control-solid @error('Especimenes.sexo_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona Sexo de Especie</option>
                                            @foreach ($sexos as $objSex)
                                                <option data-subtext="" value="{{ $objSex->id }}">{{ $objSex->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Especimenes.sexo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Ubicación <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.ubicacion" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.ubicacion') is-invalid @enderror"  
                                            placeholder="Ej: Corral No. 1" />
                                    </div>
                                    @error('Especimenes.ubicacion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Procedencia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.procedencia" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.procedencia') is-invalid @enderror"  
                                            placeholder="Ej: Caballerizas en Quito" />
                                    </div>
                                    @error('Especimenes.procedencia') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Veterinario <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.veterinario" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.veterinario') is-invalid @enderror"  
                                            placeholder="Ej: María Albuja" />
                                    </div>
                                    @error('Especimenes.veterinario') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Edad (años)<span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.edad" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.edad') is-invalid @enderror"  
                                            placeholder="Ej: 12.5" />
                                    </div>
                                    @error('Especimenes.edad') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Peso (Kgs)<span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.peso" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.peso') is-invalid @enderror"  
                                            placeholder="Ej: 324" />
                                    </div>
                                    @error('Especimenes.peso') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Color <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.color" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.color') is-invalid @enderror"  
                                            placeholder="Ej: Café" />
                                    </div>
                                    @error('Especimenes.color') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Señas Particulares <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.marcas_particulares" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.marcas_particulares') is-invalid @enderror"  
                                            placeholder="Ej: Blanca con manchas café" />
                                    </div>
                                    @error('Especimenes.marcas_particulares') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Código / Nombre <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Especimenes.codigo_nombre" 
                                            type="text" 
                                            class="form-control form-control-solid @error('Especimenes.codigo_nombre') is-invalid @enderror"  
                                            placeholder="Ej: E-BIO-01" />
                                    </div>
                                    @error('Especimenes.codigo_nombre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="form-row" align="center">
                                <label for="inputCodigo">Consideraciones varias. Marque las opciones de ser necesario. <span class="text-danger"></label>
                                <div class="form-group col-6">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Especimenes.intervenciones"
                                            class="form-control-solid" 
                                            type="checkbox" 
                                            id="intervenciones">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Intervenciones Quirúrgicas</label>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <div class="form-check form-switch">
                                        <input 
                                            wire:model.defer="Especimenes.alergias"
                                            class="form-control-solid" 
                                            type="checkbox" 
                                            id="alergias">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Alergias</label>
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
