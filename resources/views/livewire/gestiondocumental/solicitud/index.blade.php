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
        
        <div class="row">
            @forelse ($Solicitudes as $solicitud)
                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b card-stretch">
                        <div class="card-header border-0">
                            <h3 class="card-title"></h3>
                            <div class="card-toolbar">
                                <!--start::Toolbar-->
                                <div class="d-flex justify-content-end">
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('solicitud.edit', $solicitud) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-edit" style="color:lightblue" title="Editar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('solicitud.show', $solicitud) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-eye" style="color:lightgreen" title="Mostrar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp
                                    <i class="navi-item" onclick="event.preventDefault(); confirmDestroyQuotation({{ $solicitud->id }})">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-trash-alt" style="color:red" title="Eliminar"></i>
                                            </span>
                                        </a>
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           
                            <div class="d-flex flex-column align-items-center">
                                <!--begin: Icon-->
                                <div>
                                    <label>Fecha recepción:</label>
                                    {{ $solicitud->fecharecepcion }}
                                </div>
                                <a href="{{ route('solicitud.show', $solicitud) }}">
                                    <center>
                                    <div>
                                    <!--begin: Tite-->
                                        <p class="text-dark-75 font-weight-bold my-4 font-size-lg">{{ $solicitud->dependencia->nombre }}</p>
                                        <p>{{ $solicitud->numerodocumento }}</p>
                                        <p>{{ $solicitud->fechadocumento }}</p>
                                        
                                    </div>  
                                    </center>
                                </a>
                                <a class="text-dark-75 font-weight-bold mt-1 font-size-lg">{{ $solicitud->descripcion }}</a>
                                <!--end: Tite-->
                            </div>
                       
                        </div>
                    </div>
                    <!--end:: Card-->
                </div>
                <!--end::Col-->
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

        {{ $Solicitudes->links() }}

    @else

        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Solicitud.
                    <br> Ponga en marcha softInspi añadiendo su primera Solicitud</p>
                    
                    <a href="{{ route('solicitud.create') }}" class="btn btn-primary">Agregar Solicitud</a>
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
