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
                    <a href="{{ route('solicitudenv.index') }}" class="navi-link">
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
                            <div class="form-group row" style="display: none">
                                <div class="col-5">
                                    <label for="inputOrigen">Origen del Documento <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model="selectedOrigen"
                                            wire:model.defer="Solicitudesenv.origen_id"
                                            class="form-control selectpicker show-tick form-control-solid @error('Solicitudesenv.origen_id') is-invalid @enderror" 
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
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select  
                                            wire:model.defer="Solicitudesenv.dependencia_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudesenv.dependencia_id') is-invalid @enderror" 
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
                                <div class="col-6">
                                    <label for="inputDescripcion">Remitente <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudesenv.remitente" 
                                            type="text" 
                                            required
                                            class="form-control @error('Solicitudesenv.remitente') is-invalid @enderror"  
                                            placeholder="Ej: Paula Ximena Villacreses Morales (MSP)" />
                                    </div>
                                    @error('Solicitudesenv.remitente') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputDescripcion">Entidad <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudesenv.entidad" 
                                            type="text" 
                                            required
                                            class="form-control @error('Solicitudesenv.entidad') is-invalid @enderror"  
                                            placeholder="Ej: Ministerio de Salud Pública" />
                                    </div>
                                    @error('Solicitudesenv.entidad') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="inputDocumento">No. Documento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudesenv.numerodocumento" 
                                            type="text" 
                                            required
                                            class="form-control @error('Solicitudesenv.numerodocumento') is-invalid @enderror"  
                                            placeholder="Ej: DIR-INSPI-0982-2022-O" />
                                    </div>
                                    @error('Solicitudesenv.numerodocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputDocumento">Referencia <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudesenv.referencia" 
                                            type="text" 
                                            required
                                            class="form-control @error('Solicitudesenv.referencia') is-invalid @enderror"  
                                            placeholder="Ej: DIR-INSPI-0982-2022-O" />
                                    </div>
                                    @error('Solicitudesenv.referencia') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>  
                                <div class="col-4">
                                    <label for="inputFechaDoc">Fecha Documento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input
                                            wire:model.defer="Solicitudesenv.fechadocumento"
                                            value="Solicitudesenv.fechadocumento"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudesenv.fechadocumento') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha del documento"
                                        />
                                    </div>
                                    @error('Solicitudesenv.fechadocumento') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            wire:model.defer="Solicitudesenv.descripcion"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Solicitudesenv.descripcion') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del asunto del documento" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudesenv.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResp">Sumillado <span class="text-danger"></span></label> 
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                        <textarea 
                                            wire:model.defer="Solicitudesenv.sumillado"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Solicitudesenv.sumillado') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del sumillado de Dirección Ejecutiva" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudesenv.sumillado') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-7">
                                    <label for="inputDependencia">Dependencia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model.defer="Solicitudesenv.destino_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudesenv.destino_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona el Área/Dirección</option>
                                            @foreach ($areas as $objAre)
                                                <option data-subtext="" value="{{ $objAre->id }}">{{ $objAre->nombre }}</option>
                                            @endforeach             
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <label for="inputResp">Tiempo de Respuesta <span class="text-danger">*</span></label> 
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-sort"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Solicitudesenv.tiempo" 
                                            type="number"
                                            required
                                            class="form-control form-control-solid @error('Solicitudesenv.tiempo') is-invalid @enderror"  
                                            placeholder="Ej: 1" />
                                        <label for="inputLey">  Tiempo Estimado en días <span class="text-danger"></span></label>
                                    </div>
                                    @error('Solicitudesenv.tiempo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResp">Respuesta <span class="text-danger"></span></label> 
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                        <textarea 
                                            wire:model.defer="Solicitudesenv.respuesta"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Solicitudesenv.respuesta') is-invalid @enderror" 
                                            placeholder="Ej: Respuesta para Dirección Ejecutiva" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudesenv.respuesta') <span class="text-danger">{{ $message }}</span> @enderror
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
