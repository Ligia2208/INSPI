<div class="col-xl-12">
    @if ($count >= 0)
        <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span
                            class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span></span>
                </h3>
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
                                            <select wire:model="csedes" class="form-control" data-size="7"
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
                                            <select wire:model="claboratorios" class="form-control" data-size="7"
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
                                            <select wire:model="ceventos" class="form-control" data-size="7"
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
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select wire:model="controlf" class="form-control" data-size="7"
                                                data-live-search="true" data-show-subtext="true" required>
                                                <option value="0">{{ __('Seleccione Tipo fecha') }}</option>
                                                <option data-subtext="" value="1">Fecha toma de muestra</option>
                                                <option data-subtext="" value="2">Fecha llegada al CRN</option>
                                                <option data-subtext="" value="3">Fecha reporte</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Inicio') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input wire:model="fechainicio" type="date"
                                                    class="form-control form-control-solid @error('fechainicio') is-invalid @enderror"
                                                    placeholder="Ej: 17/04/2024" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Fin') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input wire:model="fechafin" type="date"
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
                                            <div class="col-md-2 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input wire:model="searchc" type="search" class="form-control"
                                                        placeholder="Cédula...">
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
                                                <div class="input-icon">
                                                    <input wire:model="searchp" type="search" class="form-control"
                                                        placeholder="Apellidos o Nombres...">
                                                    <span>
                                                        <i class="flaticon2-search-1 text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 my-2 my-md-0">
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
                                <th>Intitución Salud</th>
                                <th>Fecha Atención</th>
                                <th>Identidad</th>
                                <th>Paciente</th>
                                <th>CRN - Laboratorio</th>
                                <th>Evento</th>
                                <th>Resultado</th>
                                <th>Usuario Resultado</th>
                                <th>Fecha Validación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($analiticas as $postanalitica)
                                <tr>
                                    @forelse ($postanalitica->analitica as $objPos)
                                        @if($objPos->codigo_secuencial==1)
                                        <?php  $codigo = $objPos->codigo_calidad; ?>
                                        @endif
                                    @empty
                                    @endforelse
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $codigo }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->instituciones->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->fecha_atencion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->paciente->identidad }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->paciente->apellidos }} {{ $postanalitica->paciente->nombres }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->crns->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->evento->simplificado }}</span>
                                    </td>
                                    <td>
                                        @if($postanalitica->resultado_id>0)
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->resultado->descripcion }}</span>
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        @if($postanalitica->usuarior_id>0)
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->usuarior->name }}</span>
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $postanalitica->fecha_resultado }}</span>
                                    </td>
                                    <td align="center">
                                        @if($postanalitica->usuarior_id==0)
                                        <i class="navi-item" data-toggle="modal" data-target="_self">
                                            <a href="{{ route('postanalitica.edit', $postanalitica) }}" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="ace-icon fa fa-tag" style="color:lightblue"
                                                        title="Validar"></i>
                                                </span>
                                            </a>
                                        </i>
                                        @endif
                                        <i class="navi-item" data-toggle="modal" data-target="_self">
                                            <a href="{{ route('postanalitica.show', $postanalitica) }}" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="ace-icon fa fa-eye" style="color:rgb(122, 122, 122)"
                                                        title="Mostrar_Detalles"></i>
                                                </span>
                                            </a>
                                        </i>
                                        @if($postanalitica->usuarior_id>0)
                                        <i class="navi-item">
                                            <a href="/informefinal/informep/{{ $postanalitica->id }}" target="_blank" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="fa fa-print" style="color:lightgray" title="Imprimir_Reporte"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @endif
                                        @if($postanalitica->crns_id==8)
                                            @if($postanalitica->evento_id==154 || $postanalitica->evento_id==155)
                                                @if ($postanalitica->resultado_id==66 || $postanalitica->resultado_id==68)
                                                    @if($postanalitica->cdiferencial==0)
                                                        <i class="navi-item" onclick="event.preventDefault(); confirmDiferencial02({{ $postanalitica->id }})">
                                                            <a href="" target="_blank" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="fa fa-toggle-on" style="color:rgb(216, 20, 20)" Title="Generar_Diferencial"></i>
                                                            </span>
                                                            </a>
                                                        </i>
                                                    @else
                                                        <i class="navi-item" onclick="event.preventDefault(); confirmGeneradodif({{ $postanalitica->id }})">
                                                            <a href="" target="_blank" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="fa fa-toggle-off" style="color:rgb(153, 149, 149)" Title="Generado" enable="false"></i>
                                                            </span>
                                                            </a>
                                                        </i>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if($postanalitica->crns_id==8)
                                            @if($postanalitica->evento_id==159 || $postanalitica->evento_id==160)
                                                @if($postanalitica->resultado_id==67)
                                                    @if($postanalitica->cdiferencial==0)
                                                        <i class="navi-item" onclick="event.preventDefault(); confirmDiferencial01({{ $postanalitica->id }})">
                                                            <a href="" target="_blank" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="fa fa-toggle-on" style="color:rgb(216, 20, 20)" Title="Generar_Diferencial"></i>
                                                            </span>
                                                            </a>
                                                        </i>
                                                    @else
                                                        <i class="navi-item" onclick="event.preventDefault(); confirmGeneradodif({{ $postanalitica->id }})">
                                                            <a href="" target="_blank" class="navi-link">
                                                            <span class="navi-icon">
                                                                <i class="fa fa-toggle-off" style="color:rgb(153, 149, 149)" Title="Generado" enable="false"></i>
                                                            </span>
                                                            </a>
                                                        </i>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                        @if($postanalitica->crns_id==8 && $postanalitica->resultado_id==67)
                                            @if ($postanalitica->evento_id==116 || $postanalitica->evento_id==117 || $postanalitica->evento_id==118 || $postanalitica->evento_id==119 || $postanalitica->evento_id==120 || $postanalitica->evento_id==125 || $postanalitica->evento_id==165 || $postanalitica->evento_id==166)
                                                @if($postanalitica->campliada==0)
                                                <i class="navi-item" data-toggle="modal" data-target="_self">
                                                    <a href="{{ route('postanalitica.edit', $postanalitica) }}" class="navi-link">
                                                        <span class="navi-icon">
                                                            <i class="ace-icon fa fa-bookmark" style="color:rgb(216, 20, 20)"
                                                                title="Generar_Ampliada"></i>
                                                        </span>
                                                    </a>
                                                </i>
                                                @else
                                                    <i class="navi-item" onclick="event.preventDefault(); confirmGeneradoamp({{ $postanalitica->id }})">
                                                        <a href="" target="_blank" class="navi-link">
                                                        <span class="navi-icon">
                                                            <i class="fa fa-bookmark" style="color:rgb(153, 149, 149)" Title="Generado" enable="false"></i>
                                                        </span>
                                                        </a>
                                                    </i>
                                                @endif
                                            @endif
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

            function confirmInforme(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "Se generará el reporte de resultados referente a la muestra seleccionada",
                    icon: "info",
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
                        @this.call('informe', id);
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
        </script>
    @endsection
</div>
