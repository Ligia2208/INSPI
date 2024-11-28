<div class="container">
    @if ($count)
         <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span></span>
                </h3>
                <a href="{{ route('articulo.create') }}" data-toggle="modal" data-target=".create" class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i class="fa fa-plus"></i> Enviar Notificación</a>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">

                <div class="mb-5 ">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="row align-items-center">
                                <div class="col-md-6 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input 
                                            wire:model="search"
                                            type="search" 
                                            class="form-control"
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
                                <th>Fecha</th>
                                <th>Años</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Filiaciones as $objFil)
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
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->area->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->direccion->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objFil->persona->fechanacimiento }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg"><?php $fecha = time() - strtotime($objFil->persona->fechanacimiento); $edad = floor($fecha / 31556926); echo $edad; ?></span>
                                    </td>
                                    <td align="center">
                                        <i class="navi-item" data-toggle="modal" data-target="#edit-{{ $objFil->id }}">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-gift" style="color:lightgreen" alt="Personalizado"></i>
                                            </span>
                                            </a>
                                        </i>
                                        <i class="navi-item" onclick="event.preventDefault(); confirmDestroy({{ $objFil->id }})">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-trash-alt" style="color:red" alt="Eliminar"></i>
                                            </span>
                                            </a>
                                        </i>
                                    </td>
                                </tr>
                                @include('cambiocultura.cumpleano.edit')    
                            @empty 
                                <!--begin::Col-->
                                <div class="col-12">
                                    <div class="alert alert-custom alert-notice alert-light-dark fade show mb-5" role="alert">
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

                {{ $Filiaciones->links() }}

            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tenemos Cumpleañeros hoy.
                    <br> Pronto CoreInspi te informará de los próximos cumpleañeros</p>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/users.png') }}">
                </div>
            </div>
        </div>
    @endif


    @include('cambiocultura.cumpleano.create')
    @section('footer')
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