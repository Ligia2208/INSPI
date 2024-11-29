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
                    <a href="{{ route('solicitudcor.index') }}" class="navi-link">
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
                                <label class="col-3">No. Documento <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <input 
                                            wire:model.defer="Solicitudescor.numerodocumento" 
                                            type="text" 
                                            required
                                            class="form-control form-control-solid @error('Solicitudescor.numerodocumento') is-invalid @enderror"  
                                            placeholder="Ej: DIR-INSPI-0982-2022-O" readonly/>
                                    </div>
                                    @error('Solicitudescor.numerodocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label class="col-3">Fecha Documento <span class="text-danger">*</span></label>
                                <div class="col-3" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Solicitudescor.fechadocumento"
                                            value="Solicitudescor.fechadocumento"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudescor.fechadocumento') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha del documento" readonly
                                        />
                                    </div>
                                    @error('Solicitudescor.fechadocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <label class="col-3">Fecha Recepción <span class="text-danger">*</span></label>
                                <div class="col-3" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Solicitudescor.fecharecepcion"
                                            value="Solicitudescor.fecharecepcion"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudescor.fecharecepcion') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de recepción del documento" readonly
                                        />
                                    </div>
                                    @error('Solicitudescor.fecharecepcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>                     
                            <div class="form-group row">
                                <label class="col-3">Descripción </label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <textarea 
                                            wire:model.defer="Solicitudescor.descripcion"
                                            id="" 
                                            cols="30" 
                                            rows="3"
                                            class="form-control form-control-solid @error('Solicitudescor.descripcion') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del asunto del documento" readonly
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudescor.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Área/Dirección <span class="text-danger">*</span></label>
                                <div class="col-4">
                                    <div>
                                        <select 
                                            wire:model.defer="Solicitudescor.area_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudescor.area_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona el Área/Dirección</option>
                                            @foreach ($areas as $objAre)
                                                <option data-subtext="" value="{{ $objAre->id }}">{{ $objAre->nombre }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <span class="form-text text-muted"></span>
                                    @error('Solicitudescor.area_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <label class="col-2">Fecha Asignación a Dirección <span class="text-danger">*</span></label>
                                <div class="col-3" wire:ignore wire:key="start_date">
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class=""></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Solicitudescor.fechaasignacionde"
                                            value="Solicitudescor.fechaasignacionde"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Solicitudescor.fechaasignacionde') is-invalid @enderror"  
                                            placeholder="Seleccione la fecha de recepción del documento" readonly
                                        />
                                    </div>
                                    @error('Solicitudescor.fechaasignacionde') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Sumillado </label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <textarea 
                                            wire:model.defer="Solicitudescor.sumillado"
                                            id="" 
                                            cols="30" 
                                            rows="3"
                                            class="form-control form-control-solid @error('Solicitudescor.sumillado') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del sumillado de Dirección Ejecutiva" readonly
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudescor.sumillado') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label class="col-3">Sumillado Coordinación General </label>
                                <div class="col-9">
                                    <div class="input-group input-group-solid">
                                        <textarea 
                                            wire:model.defer="Solicitudescor.sumillado_dirgen"
                                            id="" 
                                            cols="30" 
                                            rows="3"
                                            class="form-control form-control-solid @error('Solicitudescor.sumillado_dirgen') is-invalid @enderror" 
                                            placeholder="Ej: Transcripción del sumillado de Coordinación" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Solicitudescor.sumillado_dirgen') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Direcciones Técnicas <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div>
                                        <select 
                                            wire:model.defer="Solicitudescor.dirtecnica_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudescor.dirtecnica_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona la Dirección Técnica</option>
                                            @foreach ($dirtecnicas as $objDirTec)
                                                <option data-subtext="" value="{{ $objDirTec->id }}">{{ $objDirTec->nombre }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <span class="form-text text-muted"></span>
                                    @error('Solicitudescor.dirtecnica_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3">Estado Solicitud <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <div>
                                        <select 
                                            wire:model.defer="Solicitudescor.estado_id" 
                                            class="form-control selectpicker form-control-solid @error('Solicitudescor.estado_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona el Estado de la Solicitud</option>
                                            @foreach ($estados as $objEst)
                                                <option data-subtext="" value="{{ $objEst->id }}">{{ $objEst->nombre }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                    <span class="form-text text-muted"></span>
                                    @error('Solicitudescor.estado_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
