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
                <a href="#" data-toggle="modal" data-target=".create"
                    class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i class="fa fa-sticky-note"></i>
                    Agregar</a>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <div class="card card-body">
                    <div class="mb-5 ">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-6 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input wire:model="search" type="search" class="form-control"
                                                placeholder="Buscar...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">Mostrar:</label>
                                            <select class="form-control" wire:model="perPage">
                                                <option value="10">10 Entradas</option>
                                                <option value="20">20 Entradas</option>
                                                <option value="50">50 Entradas</option>
                                                <option value="100">100 Entradas</option>
                                            </select>
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
                    <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th>Sede</th>
                                <th>CRN - Laboratorio</th>
                                <th>Usuario</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($responsables as $objResp)
                                <tr>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objResp->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objResp->tipo->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objResp->sedes->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objResp->crns->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objResp->usuario->name }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objResp->vigente_desde }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objResp->vigente_hasta }}</span>
                                    </td>
                                    <td align="center">
                                        @if ($objResp->vigente_hasta=='')
                                        <i class="navi-item" data-toggle="modal"
                                            data-target="#edit-{{ $objResp->id }}">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="ace-icon fa fa-pen" style="color:lightblue"
                                                        title="Editar"></i>
                                                </span>
                                            </a>
                                        </i>
                                        <i class="navi-item"
                                            onclick="event.preventDefault(); confirmDestroy({{ $objResp->id }})">
                                            <a href="#" class="navi-link">
                                                <span class="navi-icon">
                                                    <i class="ace-icon fa fa-ban" style="color:red"
                                                        title="Deshabilitar"></i>
                                                </span>
                                            </a>
                                        </i>
                                        @endif
                                    </td>
                                </tr>
                                @include('centrosreferencia.responsable.edit')
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

                {{ $responsables->links() }}
            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ningún Técnico/Responsable.
                        <br> Ponga en marcha CoreInspi añadiendo su primer Rsponsable
                    </p>
                    <a data-toggle="modal" data-target=".create" href="#" class="btn btn-primary">Agregar
                        Responsable</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt=""
                        src="{{ asset('assets/media/ilustrations/areas.png') }}">
                </div>
            </div>
        </div>
    @endif

    @include('centrosreferencia.responsable.create')

    @section('footer')
        <script>
            Livewire.on('closeModal', function() {
                $('.modal').modal('hide');
            });

            function confirmDestroy(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá volver a habilitar al Técnico/Responsable y se quedará sin acceso a la aplicación",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, deshabilitar</span>",
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
        </script>
    @endsection
</div>
