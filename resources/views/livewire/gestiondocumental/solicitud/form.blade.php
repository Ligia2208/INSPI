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
                    <div class="col-xl-1"></div>
                    <div class="col-xl-10">
                        <div class="my-5">
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>

                            @include('component.error-list')
                            <div class="form-group row">
                                <div class="col-5">
                                    <label for="inputOrigen">Origen del Documento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-bars"></i>
                                        </span>
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
                                </div>
                                <div class="col-7">
                                    <label for="inputDependencia">Dependencia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-bars"></i>
                                        </span>
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
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputDocumento">No. Documento - Referencia Documento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudes.numerodocumento" 
                                            type="text" 
                                            required
                                            class="form-control @error('Solicitudes.numerodocumento') is-invalid @enderror"  
                                            placeholder="Ej: DIR-INSPI-0982-2022-O" />
                                    </div>
                                    @error('Solicitudes.numerodocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>  
                            </div>  
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="inputFechaDoc">Fecha Documento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
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
                                <div class="col-6">
                                    <label for="inputFechaRec">Fecha Recepción <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
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
                                <div class="col-12">
                                    <label for="inputDescripcion">Descripción - Asunto <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
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
