<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card">
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            <a href="{{ route('preanalitica.index') }}"
                                class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha de Recepción<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_recepcion"
                                            value="Preanaliticas.fecha_recepcion" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_recepcion') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Institución de Salud<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.instituciones_id"
                                            wire:model="changedInstitucion"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Institución de Salud</option>
                                            @foreach ($instituciones as $objIns)
                                                <option
                                                    data-subtext="{{ $objIns->provincia->descripcion }} - {{ $objIns->canton->descripcion }}"
                                                    value="{{ $objIns->id }}">{{ $objIns->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tipología IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticas.institucion_tipologia"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_tipologia') is-invalid @enderror"
                                            placeholder="Ej: MSP - IESS - SOLCA" />
                                    </div>
                                    @error('Preanaliticas.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Denominación IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticas.institucion_nombre"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_nombre') is-invalid @enderror"
                                            placeholder="Ej: Teodoro Maldonado C." />
                                    </div>
                                    @error('Preanaliticas.institucion_nombre')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Clasificación IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Preanaliticas.institucion_clasificacion"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_clasificacion') is-invalid @enderror"
                                            placeholder="Ej: Centro de Salud Tipo A" />
                                    </div>
                                    @error('Preanaliticas.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nivel IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_nivel"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_nivel') is-invalid @enderror"
                                            placeholder="Ej: Nivel 1" />
                                    </div>
                                    @error('Preanaliticas.institucion_nivel')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Provincia - Cantón<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_ubicacion"
                                            wire:ignore
                                            type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_ubicacion') is-invalid @enderror"
                                            placeholder="Ej: Guayas - Guayaquil" />
                                    </div>
                                    @error('Preanaliticas.institucion_ubicacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Nombre médico solicitante<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.quien_notifica" type="text" required
                                            class="form-control form-control-solid @error('Preanaliticas.quien_notifica') is-invalid @enderror"
                                            placeholder="Ej: Dr. Julio Robles" />
                                    </div>
                                    @error('Preanaliticas.quien_notifica')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Muestra Principal<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model="Preanaliticas.sedes_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">
                                                    {{ $objSed->descripcion }}</option>
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
                                            wire:model="Preanaliticas.crns_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.crns_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un CRN</option>
                                                @foreach ($crns as $objCrn)
                                                    <option data-subtext="" value="{{ $objCrn->id }}">
                                                        {{ $objCrn->descripcion }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Evento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model="Preanaliticas.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.evento_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Evento</option>
                                                @foreach ($eventos as $objEvento)
                                                    <option data-subtext="{{ $objEvento->descripcion }}"
                                                        value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}
                                                    </option>
                                                @endforeach
                                        </select>
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
        <div class="card-header">
            <div class="card-toolbar">
                <button wire:click="{{ $method }}" wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}" class="btn btn-primary font-weight-bolder mr-2">
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
                        bfi_clear('#' + fileId);
                    },
                }
            }

            Livewire.on('renderJs', function() {
                $('.selectpicker').selectpicker({
                    liveSearch: true
                });
            });

            function ver_ocultar() {
                var x = document.getElementById("add_muestras");
                if (x.style.visibility === "visible") {
                    x.style.visibility = "hidden";
                } else {
                    x.style.visibility = "visible";
                }
            }
        </script>
    @endsection

</div>
