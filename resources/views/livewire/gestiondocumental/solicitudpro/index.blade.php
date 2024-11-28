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
            @forelse ($Solicitudespro as $solicitudpro)
                <!--begin::Col-->
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <!--begin::Card-->
                    @if ($solicitudpro->procesado==4)
                        <div class="card card-custom gutter-b card-stretch" style="background-color: #deeafc;">
                    @else
                    <div class="card card-custom gutter-b card-stretch" style="background-color: #E8F8F5;">
                    @endif
                        <div class="card-header border-0">
                            <h3 class="card-title"></h3>
                            <div class="card-toolbar">
                                <!--start::Toolbar-->
                                <div class="d-flex justify-content-end">
                                    <div class="dropdown dropdown-inline" data-toggle="tooltip"  data-placement="left">
                                        <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('solicitudpro.show', $solicitudpro) }}"><i class="fa fa-eye mr-2"></i> Ver</a>
                                            @if ($solicitudpro->procesado==2)
                                                <a class="dropdown-item" href="{{ route('solicitudpro.edit', $solicitudpro) }}"><i class="fa fa-pen mr-2"></i> Editar</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                           
                            <div class="d-flex flex-column align-items-center">
                                <!--begin: Icon-->
                                <center>
                                <div>
                                    <label>Fecha asignación:</label>
                                    {{ $solicitudpro->fechaasignaciondg }}
                                </div>
                                <a href="{{ route('solicitudpro.show', $solicitudpro) }}">
                                    <div>
                                        <img alt="{{ $solicitudpro->numerodocumento }}" class="max-h-65px" src="{{ asset('assets') }}/media/svg/files/pdf.svg"/>
                                        <!--begin: Tite-->
                                        <p></p>
                                        <p>{{ $solicitudpro->numerodocumento }} ({{ $solicitudpro->solicitud->fechadocumento }})</p>                                        
                                        <p>{{ $solicitudpro->solicitud->descripcion }}</p>
                                    </div>  
                                </a>
                                <p class="text-dark-75 font-weight-bold my-4 font-size-lg">{{ $solicitudpro->area->nombre }}</p>
                                <a class="text-dark-75 font-weight-bold mt-1 font-size-lg">{{ $solicitudpro->solicitud->sumillado }}</a>
                                </center>
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

        {{ $Solicitudespro->links() }}

    @else

        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Solicitud Asignada.
                    <br> softInspi detectará apenas llegué su primera Solicitud Asignada</p>
                    
                    
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
