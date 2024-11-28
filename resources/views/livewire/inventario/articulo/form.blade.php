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
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nombre Item </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea 
                                            wire:model.defer="Articulos.nombre"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Articulos.nombre') is-invalid @enderror" 
                                            placeholder="Ej: Computador de Escritorio">
                                        </textarea>
                                    </div>
                                    @error('Articulos.nombre') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Características del Item </label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea 
                                            wire:model.defer="Articulos.caracteristicas"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Articulos.caracteristicas') is-invalid @enderror" 
                                            placeholder="Ej: Disco duro 500Gb - Memoria RAM 8Gb - sistema integrado de controladores">
                                        </textarea>
                                    </div>
                                    @error('Articulos.caracteristicas') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Clase<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.clase_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.clase_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Clase</option>
                                            @foreach ($clases as $clase)
                                                <option data-subtext="" value="{{ $clase->id }}">{{ $clase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la Clase correspondiente al Artículo</span>
                                    @error('Articulos.clase_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Marca<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.marca_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.marca_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Marca</option>
                                            @foreach ($marcas as $marca)
                                                <option data-subtext="" value="{{ $marca->id }}">{{ $marca->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la Marca</span>
                                    @error('Convenios.marca_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>    
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Modelo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.modelo" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.modelo') is-invalid @enderror"  
                                            placeholder="Ej: Minitower" />
                                    </div>
                                    @error('Articulos.modelo') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Color<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.color" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.color') is-invalid @enderror"  
                                            placeholder="Ej: Azul" />
                                    </div>
                                    @error('Articulos.color') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Serie<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.serie" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.serie') is-invalid @enderror"  
                                            placeholder="Ej: 2222JJT45KM4501" />
                                    </div>
                                    @error('Articulos.serie') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>   
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Fecha Compra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Articulos.fechacompra"
                                            value="Articulos.fechacompra"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Articulos.fechacompra') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de compra del Artículo"
                                        />
                                    </div>
                                    @error('Articulos.fechacompra') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Valor de Compra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.valorcompra" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.valorcompra') is-invalid @enderror"  
                                            placeholder="Ej: Azul" />
                                    </div>
                                    @error('Articulos.valorcompra') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Código Inventario<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.codigoinventario" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.codigoinventario') is-invalid @enderror"  
                                            placeholder="Ej: 140098443200" />
                                    </div>
                                    @error('Articulos.codigoinventario') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Código EBYE<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.codigoebye" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.codigoebye') is-invalid @enderror"  
                                            placeholder="Ej: 1123AE34" />
                                    </div>
                                    @error('Articulos.codigoebye') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div> 
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="separator separator-dashed my-10"></div>
                            <h3 class="text-dark font-weight-bold mb-5">Ubicación y Estado</h3>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.sede_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.sede_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $sede)
                                                <option data-subtext="{{ $sede->descripcion }}" value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije la Sede correspondiente al Artículo</span>
                                    @error('Articulos.sede_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Edificio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.edificio_id"
                                            class="form-control selectpicker form-control-solid @error('Articulos.edificio_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Edificio</option>
                                            @foreach ($edificios as $edifi)
                                                <option data-subtext="{{ $edifi->descripcion }}" value="{{ $edifi->id }}">{{ $edifi->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Edificio correspondiente al Artículo</span>
                                    @error('Articulos.edificio_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sector<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.sector_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.sector_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona un Sector</option>
                                            @foreach ($sectores as $sector)
                                                <option data-subtext="" value="{{ $sector->id }}">{{ $sector->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Sector correspondiente al Artículo</span>
                                    @error('Articulos.sector_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>   
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Factura<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.factura" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.factura') is-invalid @enderror"  
                                            placeholder="Ej: 001-001-000293" />
                                    </div>
                                    @error('Articulos.factura') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>CUR<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.cur" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.cur') is-invalid @enderror"  
                                            placeholder="Ej: 90021" />
                                    </div>
                                    @error('Articulos.cur') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Valor en libros<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.valorlibros" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.valorlibros') is-invalid @enderror"  
                                            placeholder="Ej: 1290,00" />
                                    </div>
                                    @error('Articulos.valorlibros') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>   
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Tiempo Depreciación<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input 
                                            wire:model.defer="Articulos.depreciacion" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Articulos.depreciacion') is-invalid @enderror"  
                                            placeholder="Ej: 4 años" />
                                    </div>
                                    @error('Articulos.depreciacion') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Origen<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.origen_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.origen_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona el Origen</option>
                                            @foreach ($origenes as $origen)
                                                <option data-subtext="" value="{{ $origen->id }}">{{ $origen->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Origen correspondiente al Artículo</span>
                                    @error('Articulos.edificio_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Estado<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.estado_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.estado_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona el Estado</option>
                                            @foreach ($estados as $estado)
                                                <option data-subtext="" value="{{ $estado->id }}">{{ $estado->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Estado correspondiente al Artículo</span>
                                    @error('Articulos.estado_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>   
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Custodio Administrativo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.custodio_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.custodio_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Custodio creado</option>
                                            @foreach ($users as $user)
                                                <option data-subtext="{{ $user->email}}" value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Custodio correspondiente al Artículo</span>
                                    @error('Articulos.custodio_id') 
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Usuario Asignado<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select 
                                            wire:model.defer="Articulos.usuario_id" 
                                            class="form-control selectpicker form-control-solid @error('Articulos.usuario_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Usuario creado</option>
                                            @foreach ($users as $user)
                                                <option data-subtext="{{ $user->email}}" value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="form-text text-muted">Elije el Usuario correspondiente al Artículo</span>
                                    @error('Articulos.usuario_id') 
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
