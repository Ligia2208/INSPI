<div class="container">
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
                                <th>Documento</th>
                                <th>Referencia</th>
                                <th>Fecha Documento</th>
                                <th>Asunto</th>
                                <th>Asignado a</th>
                                <th>Plazo</th>
                                <th>Fecha Respuesta</th>
                                <th>Atraso</th>
                                <th>Respuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Historicos as $objSeguir)
                                <?php
                                    $date1 = new DateTime($objSeguir->fechaasignacionde);
                                    $date2 = new DateTime($objSeguir->fecharespuesta);
                                    $diff = $date1->diff($date2);
                                    $atraso = $diff->days-$objSeguir->tiempo;
                                ?>
                                @if($diff->days == 0)
                                    <tr style="background-color:#D5F5E3">
                                @else
                                    @if($atraso < $objSeguir->tiempo)
                                        <tr style="background-color:#FCF3CF">
                                    @else
                                        <tr style="background-color:#FDEDEC">
                                    @endif
                                @endif
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->numerodocumento }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->referencia }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->fechaasignacionde }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->area->nombre }}</span>
                                    </td>
                                    <td align="center">
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->tiempo }}</span>
                                    </td>
                                    <td align="center">
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->fecharespuesta }}</span>
                                    </td>
                                    <td align="center">
                                        @if($atraso < 1)
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">--</span>
                                        @else
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg"><?php echo $atraso; ?> </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objSeguir->respuesta }}</span>
                                    </td>
                                    <td align="center">
                                        <i class="navi-item" data-toggle="modal" data-target="_self">
                                            <a href="{{ route('historico.show', $objSeguir) }}" class="navi-link">
                                                <span class="navi-icon">
                                                <i class="ace-icon fa fa-eye" style="color:lightgreen" title="Mostrar"></i>
                                                </span>
                                            </a>
                                        </i>
                                    </td>
                                </tr>
                                
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

                {{ $Historicos->links() }}

            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Dirección Técnica.
                    <br> Ponga en marcha SoftInspi añadiendo su primera Dirección Técnica</p>
                    <a data-toggle="modal" data-target=".create" href="#" class="btn btn-primary">Agregar Dirección Técnica</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/dirtecnica.png') }}">
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
                    text: "No podrá recuperar esta Dirección Técnica y los servicios creados con este tipo se quedarán sin vinculación",
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