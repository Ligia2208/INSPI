<div class="col-xl-12">
    @if ($count >= 0)
        <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span
                            class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span>
                        </span>
                </h3>
                <a href="{{ route('analiticacd4.index')}}" class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i class="fa fa-sticky-note"></i> Registrar resultados CD4</a>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <div class="card card-body">
                    <div class="mb-5 ">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select id="idsede" wire:model="csedes" class="form-control" data-size="7"
                                                data-live-search="true" data-show-subtext="true" required>
                                                <option value="">{{ __('Seleccione una Sede') }}</option>
                                                @foreach ($sedes as $objSede)
                                                    <option data-subtext="" value="{{ $objSede->id }}">
                                                        {{ $objSede->descripcion }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select id="idcrn" wire:model="claboratorios" class="form-control" data-size="7"
                                                data-live-search="true" data-show-subtext="true" required>
                                                <option value="">{{ __('Seleccione un CRN - Laboratorio') }}
                                                </option>
                                                @if (!is_null($crns))
                                                    @foreach ($crns as $objCrn)
                                                        <option data-subtext="" value="{{ $objCrn->id }}">
                                                            {{ $objCrn->descripcion }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select id="idevn" wire:model="ceventos" class="form-control" data-size="7"
                                                data-live-search="true" data-show-subtext="true" required>
                                                <option value="">{{ __('Seleccione un Evento') }}</option>
                                                @if (!is_null($eventos))
                                                    @foreach ($eventos as $objEven)
                                                        <option data-subtext="" value="{{ $objEven->id }}">
                                                            {{ $objEven->simplificado }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <br>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input wire:model="searchm" type="search" class="form-control"
                                                placeholder="Muestra...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select id="idtipo" wire:model="controlf" class="form-control" data-size="7"
                                                data-live-search="true" data-show-subtext="true" required>
                                                <option value="0">{{ __('Seleccione Tipo fecha') }}</option>
                                                <option data-subtext="" value="1">Fecha recepción</option>
                                                <option data-subtext="" value="2">Fecha registro</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Inicio') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input id="idfinicio" wire:model="fechainicio" type="date"
                                                    class="form-control form-control-solid @error('fechainicio') is-invalid @enderror"
                                                    placeholder="Ej: 17/04/2024" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Fin') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input id="idffin" wire:model="fechafin" type="date"
                                                    class="form-control form-control-solid @error('fechafin') is-invalid @enderror"
                                                    placeholder="Ej: 27/06/2024" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <br>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input wire:model="searchc" type="search" class="form-control"
                                                placeholder="Cédula...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input wire:model="searchp" type="search" class="form-control"
                                                placeholder="Apellidos o Nombres...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Mostrar:</label>
                                            <select class="form-control" wire:model="perPage">
                                                <option value="25">25 Entradas</option>
                                                <option value="50">50 Entradas</option>
                                                <option value="100">100 Entradas</option>
                                                <option value="250">250 Entradas</option>
                                                <option value="500">500 Entradas</option>
                                                <option value="1000">1000 Entradas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-danger font-weight-bold mr-2"
                                                onclick="generarExcel()"><i
                                                    class="fa fa-file-excel" aria-hidden="true"></i>
                                                {{ __('Genera archivo xlsx') }}</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <a target="_blank" class="btn btn-success font-weight-bold mr-2 dropdown-item" href="{{ Storage::url('descargas/'.$csedes.'/'.$claboratorios.'/descarga_muestras.xlsx') }}"><i class="fas fa-download mr-2"></i> Descarga archivo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-3">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table id="data"
                        class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Código Muestra</th>
                                <th>Fecha Recepción</th>
                                <th>CRN - Laboratorio</th>
                                <th>Evento</th>
                                <th>Cédula</th>
                                <th>Paciente</th>
                                <th>Referencia</th>
                                <th>Muestra</th>
                                <th>Ingreso por</th>
                                <th>Técnica</th>
                                <th>Resultado</th>
                                <th>Fecha Resultado</th>
                                <th>Usuario Resultado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($analiticas as $analitica)
                                <tr>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->codigo_calidad }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->preanalitica->fecha_recepcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->crns->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->evento->simplificado }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->preanalitica->paciente->identidad }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->preanalitica->paciente->apellidos }} {{ $analitica->preanalitica->paciente->nombres }}</span>
                                    </td>
                                    @if ($analitica->codigo_externo == '')
                                        <td>
                                            <span
                                                class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ str_pad($analitica->codigo_muestra, 5, '0', STR_PAD_LEFT) }}-{{ str_pad($analitica->codigo_secuencial, 2, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                    @else
                                        <td>
                                            <span
                                                class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $analitica->codigo_externo }}</span>
                                        </td>
                                    @endif
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->muestra->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($analitica->preanalitica->ingresa_por==1) Sede Central - Guayaquil @endif @if($analitica->preanalitica->ingresa_por==2) CZ6 - Cuenca @endif @if($analitica->preanalitica->ingresa_por==3) CZ9 - Quito @endif @if($analitica->preanalitica->ingresa_por==4) OFTEC - Tena @endif @if($analitica->preanalitica->ingresa_por==0) Autogenerada @endif</span>
                                    </td>
                                    <td>
                                        @if ($analitica->tecnica_id > 0)
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->tecnica->descripcion }}</span>
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        @if ($analitica->resultado_id > 0)
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->resultado->descripcion }}</span>
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->fecha_resultado }}</span>
                                    </td>
                                    <td>
                                        @if ($analitica->usuarior_id > 0)
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->usuarior->name }}</span>
                                        @else
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if ($analitica->usuariop_id == 0)
                                            <i class="navi-item" data-toggle="modal" data-target="_self">
                                                @if($analitica->crns_id == 1)
                                                <a href="{{ route('analiticasmicolo.edit', $analitica) }}"
                                                    class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="ace-icon fa fa-pen" style="color:lightblue"
                                                            title="Editar"></i>
                                                    </span>
                                                </a>
                                                @elseif($analitica->crns_id == 9)
                                                <a href="{{ route('analiticasgen.edit', $analitica) }}"
                                                    class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="ace-icon fa fa-pen" style="color:lightblue"
                                                            title="Editar"></i>
                                                    </span>
                                                </a>
                                                @else
                                                <a href="{{ route('analitica.edit', $analitica) }}"
                                                    class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="ace-icon fa fa-pen" style="color:lightblue"
                                                            title="Editar"></i>
                                                    </span>
                                                </a>
                                                @endif
                                            </i>
                                        @endif
                                        @if ($analitica->usuarior_id == 0 && $analitica->validado == 'N')
                                            <i class="navi-item"
                                                onclick="event.preventDefault(); confirmDuplicate({{ $analitica->id }})">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="ace-icon fa fa-plus"
                                                            style="color:rgb(139, 139, 139)" title="Duplicar"></i>
                                                    </span>
                                                </a>
                                            </i>
                                        @endif
                                        @if ($analitica->archivo != null)
                                        <i class="navi-item" data-toggle="modal" data-target="#">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-file-pdf" style="color:rgb(238, 51, 51)" onclick="veroficio('{{$analitica->archivo}}')" title="Descargar Informe"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @else
                                        <i class="navi-item" data-toggle="modal" data-target="#">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-ban" style="color:gray" title="Sin Informe"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <!--begin::Col-->
                                <div class="col-12">
                                    <div class="alert alert-custom alert-notice alert-light-dark fade show mb-5"
                                        role="alert">
                                        <div class="alert-icon">
                                            <i class="flaticon-questions-circular-button"></i>
                                        </div>
                                        <div class="alert-text">Sin resultados "{{ $searchm }}"</div>
                                    </div>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->

                {{ $analiticas->links() }}
            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ningun Área/Dirección.
                        <br> Ponga en marcha SoftInspi añadiendo su primer Área/Dirección
                    </p>
                    <a data-toggle="modal" data-target=".create" href="#" class="btn btn-primary">Agregar
                        Área/Dirección</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt=""
                        src="{{ asset('assets/media/ilustrations/areas.png') }}">
                </div>
            </div>
        </div>
    @endif

    @section('footer')
        <script language="javascript">
            function veroficio(nombre){
            window.open('/storage/'+nombre);
            }
        </script>
        <script>
            Livewire.on('closeModal', function() {
                $('.modal').modal('hide');
            });

            function confirmDestroy(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá recuperar este Área/Dirección y los servicios creados con este tipo se quedarán sin vinculación",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, eliminar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('destroy', id);
                    }
                });
            }

            function confirmDuplicate(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "El registro para los resultados analíticos se duplicarán para su posterior edición",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-check'></i> <span class='text-white'>Si, duplicar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('duplicate', id);
                    }
                });
            }

            function exportToExcel(tableID, filename = '') {
                // Tipo de exportación
                if (!filename) filename = 'excel_data.xls';
                let dataType = 'application/vnd.ms-excel';

                // Origen de los datos
                let tableSelect = document.getElementById(tableID);
                let tableHTML = tableSelect.outerHTML;

                // Crea el archivo descargable
                let blob = new Blob([tableHTML], {
                    type: dataType
                });

                // Crea un enlace de descarga en el navegador
                if (window.navigator && window.navigator.msSaveOrOpenBlob) { // Descargar para IExplorer
                    window.navigator.msSaveOrOpenBlob(blob, filename);
                } else { // Descargar para Chrome, Firefox, etc.
                    let a = document.createElement("a");
                    document.body.appendChild(a);
                    a.style = "display: none";
                    let csvUrl = URL.createObjectURL(blob);
                    a.href = csvUrl;
                    a.download = filename;
                    a.click();
                    URL.revokeObjectURL(a.href)
                    a.remove();
                }
            }

            function confirmAmpliada01(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "Se solicitará se efectúen pruebas ampliadas de acuerdo al EVENTO y al RESULTADO obtenido, la información del caso se remitirá al CRN pertinente",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, generar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('ampliada01', id);
                    }
                });
            }

            function confirmDiferencial01(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "Se solicitará se efectúen pruebas diferenciales de acuerdo al EVENTO y al RESULTADO obtenido, la información del caso se remitirá al CRN pertinente",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, generar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('diferencial01', id);
                    }
                });
            }

            function confirmDiferencial02(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "Se solicitará se efectúen pruebas diferenciales de acuerdo al EVENTO y al RESULTADO obtenido, la información del caso se remitirá al CRN pertinente",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, generar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('diferencial02', id);
                    }
                });
            }

            function confirmGeneradodif(id) {
                swal.fire({
                    title: "Pruebas Diferenciales",
                    text: "Las pruebas diferenciales fueron generadas y remitidas al CRN correspondiente",
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: false,
                    confirmButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-white'>Ok, Cerrar</span>",
                    reverseButtons: true,
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function() {

                });
            }

            function confirmGeneradoamp(id) {
                swal.fire({
                    title: "Pruebas Ampliadas",
                    text: "Las pruebas ampliadas fueron generadas y remitidas al CRN correspondiente",
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: false,
                    confirmButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-white'>Ok, Cerrar</span>",
                    reverseButtons: true,
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function() {

                });
            }

            function generarExcel() {
                var idsede = document.getElementById('idsede');
                var idcrn = document.getElementById('idcrn');
                var idevn = document.getElementById('idevn');
                var idtipo = document.getElementById('idtipo');
                var idfinicio = document.getElementById('idfinicio');
                var idffin = document.getElementById('idffin');
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "Se generará un archivo con formato excel con los parámetros selecionados",
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-check'></i> <span class='text-white'>Si, generar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('descargarExcel', idsede.value,idcrn.value,idevn.value,idtipo.value,idfinicio.value,idffin.value);
                    }
                });
            }
        </script>
    @endsection
</div>
