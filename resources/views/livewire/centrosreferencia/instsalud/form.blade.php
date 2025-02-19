<div class="container" x-data="app()">

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
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Clasificacion <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Instituciones.clasificacion_id"
                                            class="form-control selectpicker form-control-solid @error('Instituciones.clasificacion_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una clasificación</option>
                                            @foreach ($clasificaciones as $objClas)
                                                <option data-subtext="" value="{{ $objClas->id }}">{{ $objClas->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Instituciones.clasificacion_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Nivel <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Instituciones.nivel_id"
                                            class="form-control selectpicker form-control-solid @error('Instituciones.nivel_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona un Nivel</option>
                                            @foreach ($niveles as $objNivel)
                                                <option data-subtext="" value="{{ $objNivel->id }}">{{ $objNivel->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Instituciones.nivel_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputCodigo">Tipología <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Instituciones.tipologia_id"
                                            class="form-control selectpicker form-control-solid @error('Instituciones.tipologia_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Tipología</option>
                                            @foreach ($tipologias as $objTip)
                                                <option data-subtext="" value="{{ $objTip->id }}">{{ $objTip->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Instituciones.tipologia_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputCodigo">Unicodigo <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Instituciones.unicodigo"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Instituciones.unicodigo') is-invalid @enderror"
                                            placeholder="Ej: Santa Leonor" />
                                    </div>
                                    @error('Instituciones.unicodigo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Nombre <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Instituciones.descripcion"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Instituciones.descripcion') is-invalid @enderror"
                                            placeholder="Ej: Santa Leonor" />
                                    </div>
                                    @error('Instituciones.descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Provincia <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Instituciones.provincia_id"
                                            class="form-control selectpicker form-control-solid @error('Instituciones.provincia_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Provincia</option>
                                            @foreach ($provincias as $objPro)
                                                <option data-subtext="" value="{{ $objPro->id }}">{{ $objPro->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Instituciones.provincia_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCodigo">Cantón <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Instituciones.canton_id"
                                            class="form-control selectpicker form-control-solid @error('Instituciones.canton_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona un Cantón</option>
                                            @foreach ($cantones as $objCan)
                                                <option data-subtext="" value="{{ $objCan->id }}">{{ $objCan->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Instituciones.canton_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
        </div>
        <div class="card-header" wire:ignore>
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
    </div>
    <!--end::Card-->
    @push('footer')
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
                    liveSearch: true,
                    showSubtext: true
                });
            });
        </script>
    @endpush
</div>
