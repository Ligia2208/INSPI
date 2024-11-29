<div class="col-xl-12">
    @if ($count)
         <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span></span>
                </h3>
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
                                <th>Articulo</th>
                                <th>Características</th>
                                <th>Código</th>
                                <th>Ebye</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Articulos as $objArt)
                                <tr>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objArt->id }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objArt->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objArt->caracteristicas }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objArt->codigoinventario }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objArt->codigoebye }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objArt->estado->descripcion }}</span>
                                    </td>
                                    <td align="center">
                                        <i class="navi-item" data-toggle="modal" data-target="#edit-{{ $objArt->id }}">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-edit" style="color:lightblue" alt="Editar"></i>
                                            </span>
                                            </a>
                                        </i>
                                        <i class="navi-item" onclick="event.preventDefault(); confirmDestroy({{ $objArt->id }})">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-trash-alt" style="color:red" alt="Eliminar"></i>
                                            </span>
                                            </a>
                                        </i>
                                    </td>
                                </tr>
                                @include('inventario.articulo.edit')
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

                {{ $Articulos->links() }}

            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ningún Artículo.
                    <br> Ponga en marcha SoftInspi añadiendo su primer Artículo</p>
                    <a href="{{ route('articulo.create') }}" class="btn btn-primary font-weight-bold mr-2 ">Agregar Artículo</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/articulos.png') }}">
                </div>
            </div>
        </div>
    @endif

    @section('footer')
        <script>

            Livewire.on('closeModal', function(){
                $('.modal').modal('hide');
            });

            function confirmDestroy(id){
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá recuperar este Artículo y los servicios creados con este se quedarán sin vinculación",
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
