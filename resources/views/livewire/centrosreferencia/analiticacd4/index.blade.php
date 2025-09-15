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
                @if(Session::has('message'))
                    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                        <p><b>{!! Session::get('message') !!}</b></p>
                   </div>
                @endif
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <form action="{{ route('guardar_validar_cd4') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body pt-0 pb-3">
                <div class="card card-body">
                    <div class="mb-5 ">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-5 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Fecha llegada Laboratorio') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input id="idfinicio" name="idfinicio" wire:model="fechainicio" type="date"
                                                    class="form-control form-control-solid @error('fechainicio') is-invalid @enderror"
                                                    placeholder="Ej: 17/04/2024" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __('Fecha de Procesamiento') }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input id="idffin" name="idffin" wire:model="fechafin" type="date"
                                                    class="form-control form-control-solid @error('fechafin') is-invalid @enderror"
                                                    placeholder="Ej: 27/06/2024" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-2 my-md-0">
                                        <span>
                                            <button class="btn btn-primary btn-shadow font-weight-bold mr-2 ">
                                            <i class="fa fa-save"></i> Guardar y validar</button>
                                        </span>
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
                                <th>Resultado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            @forelse ($analiticas as $analitica)
                                <tr>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $analitica->codigo_calidad }}
                                        </span>
                                        <input
                                            name = "codes[{{ $i }}]"
                                            value={{ $analitica->id }}
                                            type="number"
                                            class="form-control form-control-solid" style="align:center" hidden/>
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
                                        <input
                                            name = "resultados[{{ $i }}]"
                                            value={{ $analitica->carga_viral }}
                                            type="number"
                                            max="10000"
                                            min="0"
                                            step=".01"
                                            size="4"
                                            class="form-control form-control-solid" style="align:center"/>
                                    </td>
                                    <td align="center">
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
                            <?php $i=$i+1; ?>
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
                            <?php $i=$i+1; ?>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->

                {{ $analiticas->links() }}
            </div>
            </form>
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
