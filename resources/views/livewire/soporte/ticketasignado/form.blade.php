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
                                <div class="form-group col-md-8">
                                    <label for="inputCodigo">Tipo de Ticket <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tickets.tipo_id"
                                            class="form-control selectpicker form-control-solid @error('Tickets.tipo_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Tipo de Ticket</option>
                                            @foreach ($tipos as $objTipo)
                                                <option data-subtext="{{ $objTipo->descripcion }}"
                                                    value="{{ $objTipo->id }}">{{ $objTipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tickets.tipo_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Prioridad <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tickets.prioridad_id"
                                            class="form-control selectpicker form-control-solid @error('Tickets.prioridad_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Prioridad</option>
                                            @foreach ($prioridades as $objPrio)
                                                <option data-subtext=""
                                                    value="{{ $objPrio->id }}">{{ $objPrio->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tickets.prioridad_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Categoría <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tickets.categoria_id"
                                            class="form-control selectpicker form-control-solid @error('Tickets.categoria_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Categoría</option>
                                            @foreach ($categorias as $objCat)
                                                <option data-subtext=""
                                                    value="{{ $objCat->id }}">{{ $objCat->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tickets.categoria_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Identficador <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tickets.identificador_id"
                                            class="form-control selectpicker form-control-solid @error('Tickets.identificador_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Identificador</option>
                                            @foreach ($identificadores as $objIdent)
                                                <option data-subtext=""
                                                    value="{{ $objIdent->id }}">{{ $objIdent->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tickets.identificador_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputCodigo">Técnico Asignado <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Tickets.tecnico_id"
                                            class="form-control selectpicker form-control-solid @error('Tickets.tecnico_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Tipo de Ticket</option>
                                            @foreach ($tecnicos as $objTecn)
                                                <option data-subtext=""
                                                    value="{{ $objTecn->id }}">{{ $objTecn->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Tickets.tecnico_id')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Título <span class="text-danger">*</label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Tickets.titulo"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Tickets.titulo') is-invalid @enderror"
                                            placeholder="Ej: Servicio de redes y página web" />
                                    </div>
                                    @error('Tickets.titulo')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputCodigo">Descripción <span class="text-danger">*</label>
                                    <div class="input-group">
                                        <textarea class="form-control form-control-solid @error('Tickets.descripcion') is-invalid @enderror"
                                        wire:model.defer="Tickets.descripcion"
                                        rows=5
                                        placeholder="Ej: Descripción de lo solicitado en el ticket"></textarea>
                                    </div>
                                    @error('Tickets.descripcion')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Evidencia de lo solicitado <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-file"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex jutify-content-start mb-1" >
                                            @if ($EvidenciaTmp || $Tickets->archivo)
                                                <img
                                                    width="65"
                                                    src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                    >
                                                <span
                                                    x-on:click="removeFile('removeEvidencia', 'EvidenciaTmp')"
                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                    style="position: inherit;"
                                                    title="Remover Evidencia">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    <span
                                                        wire:loading.class="spinner spinner-primary spinner-sm"
                                                        wire:target="removeEvidencia"
                                                        style="position: absolute; left: 81px;">
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            x-data="{ isUploading: false, progress: 0 }"
                                            x-on:livewire-upload-start="isUploading = true"
                                            x-on:livewire-upload-finish="isUploading = false"
                                            x-on:livewire-upload-error="isUploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                                            >
                                            <div wire:ignore wire:key="Evidenciafile">
                                                <input
                                                    wire:model.defer="EvidenciaTmp"
                                                    class="bfi form-control form-control-solid @error('EvidenciaTmp') is-invalid @enderror"
                                                    type="file"
                                                    accept=".pdf,.png,.jpg"
                                                    id="EvidenciaTmp"
                                                    required
                                                />
                                            </div>
                                            <!-- Progress Bar -->
                                            <div x-show="isUploading">
                                                <progress max="100" x-bind:value="progress"></progress>
                                            </div>
                                        </div>
                                        @error('EvidenciaTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
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
            Livewire.on('renderJs', function(){
                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });
            });
        </script>
        <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'summary-ckeditor' );
        </script>
    @endpush
</div>
