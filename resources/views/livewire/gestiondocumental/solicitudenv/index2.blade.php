<div class="container" >
    @if ($count)
            
        <!--Filters-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">({{ $count }}) Solicitudes</span>
                </h3>
            </div>
            <!--end::Header-->
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
                                            placeholder="Buscar numero documento ...">
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
        
        <!--begin::Row-->
        
        <div class="table-responsive">
            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
            <thead>
                <tr class="text-uppercase">
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Solicitudesenv as $solicitudenv)
                <tr>
                    <td>
                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $solicitudenv->numerodocumento }}</span>
                    </td>
                    <td>
                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $solicitudenv->fechadocumento }}</span>
                    </td>
                    <td>
                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $solicitudenv->fecharecepcion }}</span>
                    </td>
                    <td align="center">
                        <i class="navi-item" data-toggle="modal" data-target="_self">
                            <a href="{{ route('solicitudenv.edit', $solicitudenv) }}" class="navi-link">
                            <span class="navi-icon">
                                <i class="ace-icon fa fa-edit" style="color:lightblue" title="Editar"></i>
                            </span>
                            </a>
                        </i>
                        &nbsp
                        <i class="navi-item" data-toggle="modal" data-target="_self">
                            <a href="{{ route('solicitudenv.show', $solicitudenv) }}" class="navi-link">
                            <span class="navi-icon">
                                <i class="ace-icon fa fa-eye" style="color:lightgreen" title="Mostrar"></i>
                            </span>
                            </a>
                        </i>
                        &nbsp
                        <i class="navi-item" onclick="event.preventDefault(); confirmDestroy({{ $solicitudenv->id }})">
                            <a href="#" class="navi-link">
                            <span class="navi-icon">
                                <i class="ace-icon fa fa-trash-alt" style="color:red" alt="Eliminar"></i>
                            </span>
                            </a>
                        </i>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
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

        </div>
        <!--end::Row-->

        {{ $Solicitudesenv->links() }}

    @else

        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Solicitud Asignada.
                    <br> Ponga en marcha softInspi añadiendo su primera Solicitud Asignada</p>
                    
                    
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/files.png') }}">
                </div>
            </div>
        </div>
        
    @endif

    @push('footer')
        <script>
            function confirmDestroyQuotation(id){
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrás recuperar esta cotización",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='font-weight-bold'>Si, eliminar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i>  <span class='text-dark font-weight-bold'>No, cancelar",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('destroy', id);
                    }
                });
            }
        </script>
    @endpush
</div>
