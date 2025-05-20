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
                <span>
                <a href="{{ route('preanaliticacd4.create') }}" class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i
                        class="fa fa-sticky-note"></i> Agregar</a>
                        <a href="{{ route('eliminar') }}" class="btn btn-danger btn-shadow font-weight-bold mr-2 "><i
                            class="fa fa-trash"></i> Eliminar</a>
                </span>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <div class="card card-body">
                    <div class="mb-5 ">
                        <div class="row align-items-center">
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
                                            <input wire:model="search" type="search" class="form-control"
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
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="card-header border-0 py-5">
                                            <form action="{{ route('importar') }}"
                                                method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-8">
                                                        <input type="file" name="file" class="form-control form-control-solid" accept=".xlsx">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <button class="btn btn-success">Subir Archivo</button>
                                                    </div>
                                                </div>
                                            </form>

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
                                <th>Id</th>
                                <th>Fecha toma</th>
                                <th>Hora toma</th>
                                <th>Identidad</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Fecha nacimiento</th>
                                <th>Sexo</th>
                                <th>Direccion</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cargapacientes as $objPac)
                                @if($objPac->id_paciente>0)
                                <tr style="background-color:rgb(255, 205, 200)">
                                @else
                                <tr>
                                @endif
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objPac->id }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objPac->fecha_toma }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->hora_toma }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->identidad }} </span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->apellidos }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->nombres }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->fechanacimiento }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->sexo }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->direccion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objPac->telefono }}</span>
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
                                        <div class="alert-text">Sin resultados "{{ $search }}"</div>
                                    </div>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
                {{ $cargapacientes->links('pagination::bootstrap-4') }}
            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Muestra registrada.
                        <br> Ponga en marcha CoreInspi añadiendo su primer Muestra
                    </p>
                    <a data-toggle="modal" data-target=".create" href="#" class="btn btn-primary">Agregar
                        Muestras</a>
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
            function confirmDestroy(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá recuperar este registro y los servicios asociados con este se quedarán sin vinculación",
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
