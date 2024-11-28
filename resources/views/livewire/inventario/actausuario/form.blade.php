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
                    <div class="col-xl-1"></div>
                    <div class="col-xl-10">
                        <div class="my-5">
                            <div class="form-group row">
                                <label class="col-3">Persona <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model.defer="Filiaciones.persona_id" 
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.persona_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            disabled>
                                            <option value="">Selecciona una Persona</option>
                                            @foreach ($personas as $persona)
                                                <option data-subtext="{{ $persona->identidad }}" value="{{ $persona->id }}">{{ $persona->apellidos }} {{ $persona->nombres }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.persona_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-3">Fecha Ingreso <span class="text-danger">*</span></label>
                                <div class="col-9" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Filiaciones.fechaingreso"
                                            value="Filiaciones.fechaingreso"
                                            type="date"
                                            disabled 
                                            class="start_date form-control form-control-solid @error('Filiaciones.fechaingreso') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de ingreso"
                                        />
                                    </div>
                                    @error('Filiaciones.fechaingreso') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-3">Área/Dirección <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model.defer="Filiaciones.area_id"
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.area_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            disabled>
                                            <option value="">Selecciona un Área/Dirección</option>
                                            @foreach ($areas as $area)
                                                <option data-subtext="" value="{{ $area->id }}">{{ $area->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.area_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-3">Cargo Asignado <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model.defer="Filiaciones.cargo_id" 
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.cargo_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            disabled>
                                            <option value="">Selecciona un Cargo</option>
                                            @foreach ($cargos as $cargo)
                                                <option data-subtext="" value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.cargo_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-3">Sede <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div >
                                        <select 
                                            wire:model.defer="Filiaciones.sede_id" 
                                            class="form-control selectpicker form-control-solid @error('Filiaciones.sede_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            disabled>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $sede)
                                                <option data-subtext="{{ $sede->descripcion }}" value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Filiaciones.sede_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <ul class="list-group list-group-flush">
                                        @forelse ($articulos as $objArt)
                                            <li class="list-group-item">{{$objArt->nombre}}</li>
                                        @empty
                                        @endforelse
                                    </ul>   
                                </div>
                                <div class="col-4">
                                    <ul class="list-group list-group-flush">
                                        @forelse ($articulos as $objArt)
                                            <li class="list-group-item">{{$objArt->caracteristicas}}</li>
                                        @empty
                                        @endforelse
                                    </ul>   
                                </div>
                                <div class="col-3">
                                    <ul class="list-group list-group-flush">
                                        @forelse ($articulos as $objArt)
                                            <li class="list-group-item">Inv.:{{$objArt->codigoinventario}} Ebye:{{$objArt->codigoebye}}</li>
                                        @empty
                                        @endforelse
                                    </ul>   
                                </div>
                                <div class="col-2">
                                    <ul class="list-group list-group-flush">
                                        @forelse ($articulos as $objArt)
                                            <li class="list-group-item">{{$objArt->estado->descripcion}} <br><br></li>
                                        @empty
                                        @endforelse
                                    </ul>   
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
