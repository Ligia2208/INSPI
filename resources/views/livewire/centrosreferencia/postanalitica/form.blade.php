<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                                <a href="{{ route('postanalitica.index') }}" class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.sedes_id"
                                            wire:model="selectedSede"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.sedes_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">{{ $objSed->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Centro de Referencia - Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.crns_id"
                                            wire:model.live="selectedCrn"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.crns_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona un CRN</option>
                                            @if(!is_null($crns))
                                            @foreach ($crns as $objCrn)
                                                <option data-subtext="" value="{{ $objCrn->id }}">{{ $objCrn->descripcion }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Evento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.evento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona un Evento</option>
                                            @if(!is_null($eventos))
                                            @foreach ($eventos as $objEvento)
                                                <option data-subtext="" value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Año - Período<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.anio_registro"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Analiticas.anio_registro') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.anio_registro')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Código Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.codigo_muestra"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Analiticas.codigo_muestra') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_muestra')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label class="text-black"><b>Resultado Cierre Caso</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.resultado_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.resultado_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Resultado</option>
                                            @if(!is_null($reportes))
                                            @foreach ($reportes as $objRep)
                                                <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="text-black"><b>Observación Responsable de la validación</b></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Analiticas.descripcion"
                                            id=""
                                            cols="30"
                                            rows="3"
                                            class="form-control form-control-solid @error('Analiticas.descripcion_responsable') is-invalid @enderror"
                                            placeholder="Ej: Datos relevantes a reportar"
                                            >
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
            @if ($Analiticas->resultado_id==67 && ($Analiticas->evento_id==116 || $Analiticas->evento_id==117 || $Analiticas->evento_id==118 || $Analiticas->evento_id==119 || $Analiticas->evento_id==120 || $Analiticas->evento_id==125))
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-black"><b>Generación Eventos para investigación ampliada</b><span class="text-danger">*</span></label>
                        <div class="input-group input-group-solid">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-list"></i>
                            </span>
                        </div>
                        <select
                            wire:model.defer="Analiticas.eventosav_id"
                            class="form-control selectpicker form-control-solid @error('Analiticas.eventosav_id') is-invalid @enderror"
                            data-size="7"
                            data-live-search="true"
                            data-show-subtext="true"
                            required multiple>
                            <option value="">Selecciona un Evento</option>
                            @foreach ($eventos as $objEvento)
                                <option data-subtext="" value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-header" >
            <div class="card-toolbar">
                <button
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar Cambios
                </button>
            </div>
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
