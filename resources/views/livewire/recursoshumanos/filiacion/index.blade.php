<div class="col-xl-12">
    @if ($count>=0)
         <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span></span>
                </h3>
                <a href="#" data-toggle="modal" data-target=".create" class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i class="fa fa-sticky-note"></i> Agregar</a>
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
                                            <select
                                            wire:model="sedes"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione una Sede") }}</option>
                                            @foreach ($sedesc as $objSede)
                                                <option data-subtext="" value="{{ $objSede->id }}">{{ $objSede->nombre }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="direcciones"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione un Área/Dirección") }}</option>
                                            @foreach ($areasc as $objArea)
                                                <option data-subtext="" value="{{ $objArea->id }}">{{ $objArea->nombre }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="gestiones"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione una Gestión") }}</option>
                                            @foreach ($direccionesc as $objDir)
                                                <option data-subtext="" value="{{ $objDir->id }}">{{ $objDir->nombre }}</option>
                                            @endforeach
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
                                            <select
                                            wire:model="modalidades"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione una Modalidad") }}</option>
                                            @foreach ($modalidadesc as $objMod)
                                                <option data-subtext="" value="{{ $objMod->id }}">{{ $objMod->nombre }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="escalas"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione una Escala") }}</option>
                                            @foreach ($escalasc as $objEsc)
                                                <option data-subtext="" value="{{ $objEsc->id }}">{{ $objEsc->grupoocupacional }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="cargos"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione un Cargo") }}</option>
                                            @foreach ($cargosc as $objCargo)
                                                <option data-subtext="" value="{{ $objCargo->id }}">{{ $objCargo->nombre }}</option>
                                            @endforeach
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
                                            <input
                                                wire:model="searchi"
                                                type="searchi"
                                                class="form-control"
                                                placeholder="Identidad...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <input
                                                wire:model="searchn"
                                                type="searchn"
                                                class="form-control"
                                                placeholder="Nombres y/o Apellidos...">
                                            <span>
                                                <i class="flaticon2-search-1 text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
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
                            <tr class="text-lowercase">
                                <th>Id</th>
                                <th>Cédula</th>
                                <th>Nombres Completos</th>
                                <th>Dirección</th>
                                <th>Gestión</th>
                                <th>Modalidad</th>
                                <th>Escala</th>
                                <th>Cargo</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($filiaciones as $objFil)
                                <tr>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objFil->id }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objFil->persona->identidad }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objFil->persona->apellidos }} {{ $objFil->persona->nombres }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objFil->area->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->direccion->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->modalidad->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->escala->grupoocupacional }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->cargo->nombre }}</span>
                                    </td>
                                    <td align="center">
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->fechaingreso }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->fechasalida }}</span>
                                    </td>


                                    <td align="center">

                                        @if ($objFil->fechasalida=="")
                                        <i class="navi-item" data-toggle="modal" data-target="#edit-{{ $objFil->id }}">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-pen" style="color:lightblue" title="Editar"></i>
                                            </span>
                                            </a>
                                        </i>
                                        <i class="navi-item" onclick="event.preventDefault(); confirmDestroy({{ $objFil->id }})">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-trash-alt" style="color:red" title="Eliminar"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @endif
                                        @if ($objFil->archivo != null)
                                        <i class="navi-item" data-toggle="modal" data-target="#">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-address-card" style="color:gray" onclick="veroficio('{{$objFil->archivo}}')" title="Descargar Contrato"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @else
                                        <i class="navi-item" data-toggle="modal" data-target="#">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-ban" style="color:gray" title="Sin Contrato"></i>
                                            </span>
                                            </a>
                                        </i>
                                        @endif
                                    </td>

                                </tr>
                                @include('recursoshumanos.filiacion.edit')
                            @empty
                                <!--begin::Col-->
                                <div class="col-12">
                                    <div class="alert alert-custom alert-notice alert-light-dark fade show mb-5" role="alert">
                                        <div class="alert-icon">
                                            <i class="flaticon-questions-circular-button"></i>
                                        </div>
                                        <div class="alert-text">Sin resultados "{{ $searchi }}"</div>
                                    </div>
                                </div>
                           @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->

                {{ $filiaciones->links() }}

            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Contratación con los datos indicados.
                    <br> Ponga en marcha CoreInspi añadiendo una nueva Contratación</p>
                    <a href="{{ route('filiacion.index') }}" class="btn btn-primary">Regresar</a>
                    <a data-toggle="modal" data-target=".create" href="#" class="btn btn-primary">Agregar Contratación</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/users.png') }}">
                </div>
            </div>
        </div>
    @endif

    @include('recursoshumanos.filiacion.create')

    @section('footer')
        <script language="javascript">
            function veroficio(nombre){
            window.open('/storage/'+nombre);
            }
        </script>
        <script>

            Livewire.on('closeModal', function(){
                $('.modal').modal('hide');
            });

            function confirmDestroy(id){
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá recuperar esta Contratación y los servicios creados con este tipo se quedarán sin vinculación",
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
        </script>

    @endsection
</div>
