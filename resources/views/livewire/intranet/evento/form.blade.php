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
                    <a href="{{ route('evento.index') }}" class="navi-link">
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
                                <div class="col-4">
                                    <label for="inputInforme">Tipo Informe <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model.defer="Eventos.tipoinforme_id" 
                                            class="form-control selectpicker form-control-solid @error('Eventos.tipoinforme_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            required>
                                            <option value="">Selecciona Tipo de información</option>
                                            @foreach ($tiposinforme as $objTii)
                                                <option data-subtext="" value="{{ $objTii->id }}">{{ $objTii->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <label for="inputOrigen">Área - Dirección <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model.defer="Eventos.area_id"
                                            class="form-control selectpicker show-tick form-control-solid @error('Eventos.origen_id') is-invalid @enderror" 
                                            data-live-search="true"
                                            data-size="7"
                                            required>
                                            <option value="">Selecciona el área/dirección </option>
                                            @foreach ($areas as $objAre)
                                                <option data-subtext="" value="{{ $objAre->id }}">{{ $objAre->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label for="inputDocumento">Tipo de Evento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-list"></i>
                                        </span>
                                        <select 
                                            wire:model.defer="Eventos.tipoactividad_id" 
                                            class="form-control selectpicker form-control-solid @error('Eventos.tipoinforme_id') is-invalid @enderror" 
                                            data-size="7"
                                            data-live-search="true"
                                            required>
                                            <option value="">Selecciona Tipo de Evento</option>
                                            @foreach ($tiposactividad as $objAct)
                                                <option data-subtext="" value="{{ $objAct->id }}">{{ $objAct->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <label for="inputDocumento">Nombre de Actividad o Evento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Eventos.nombreactividad" 
                                            type="text" 
                                            required
                                            class="form-control @error('Eventos.nombreactividad') is-invalid @enderror"  
                                            placeholder="Ej: Congreso Casa Abierta" />
                                    </div>
                                    @error('Eventos.numerodocumento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>  
                            </div>  
                            <div class="form-group row">
                                <div class="col-3">
                                    <label for="inputFechaDoc">Fecha de Inicio <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input
                                            wire:model.defer="Eventos.fechaevento"
                                            value="Eventos.fechaevento"
                                            type="date" 
                                            class="start_date form-control form-control-solid @error('Eventos.fechaevento') is-invalid @enderror"  
                                        />
                                    </div>
                                    @error('Eventos.fechaevento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-3">
                                    <label for="inputFechaRec">Hora de Inicio <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid" wire:ignore wire:key="start_date">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input
                                            wire:model.defer="Eventos.horaevento"
                                            value="Eventos.horaevento"
                                            type="time" 
                                            class="start_date form-control form-control-solid @error('Eventos.horaevento') is-invalid @enderror"  
                                        />
                                    </div>
                                    @error('Eventos.horaevento') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputLugar">Lugar del Evento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Eventos.lugar" 
                                            type="text" 
                                            required
                                            class="form-control @error('Eventos.lugar') is-invalid @enderror"  
                                            placeholder="Ej: Centro de Convenciones" />
                                    </div>
                                    @error('Eventos.lugar') <span class="text-danger">{{ $message }}</span> @enderror
                                </div> 
                            </div>                     
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResumen">Resumen de actividades del evento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                        <textarea 
                                            wire:model.defer="Eventos.resumen"
                                            id="" 
                                            cols="30" 
                                            rows="4"
                                            class="form-control form-control-solid @error('Eventos.resumen') is-invalid @enderror" 
                                            placeholder="Ej: Breve descripción de las actividades del evento" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Eventos.resumen') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResumen">Participantes <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                        <textarea 
                                            wire:model.defer="Eventos.participantes"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Eventos.participantes') is-invalid @enderror" 
                                            placeholder="Ej: Participantes del Evento" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Eventos.participantes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResumen">Comentarios y Observaciones <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-paragraph"></i>
                                        </span>
                                        <textarea 
                                            wire:model.defer="Eventos.comentarios"
                                            id="" 
                                            cols="30" 
                                            rows="2"
                                            class="form-control form-control-solid @error('Eventos.comentarios') is-invalid @enderror" 
                                            placeholder="Ej: Comentarios y Sugerencias" 
                                            >
                                        </textarea>
                                    </div>
                                    @error('Eventos.comentarios') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="inputResumen">Responsables de la Organización del Evento <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <span class="input-group-text">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <input 
                                            wire:model.defer="Eventos.responsables" 
                                            type="text" 
                                            required
                                            class="form-control @error('Eventos.responsables') is-invalid @enderror"  
                                            placeholder="Ej: Juan Carlos Contreras" />
                                    </div>
                                    @error('Eventos.responsables') <span class="text-danger">{{ $message }}</span> @enderror
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
