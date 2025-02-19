<div class="col-xl-12" >
    @if ($count)

        <!--Filters-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">({{ $count }}) Convenios</span>
                </h3>
                @if(auth()->user()->roles()->first()->name=="Transferencia" || auth()->user()->roles()->first()->name=="Administrador")
                <a href="{{ route('convenio.create') }}" class="btn btn-primary btn-shadow font-weight-bold mr-2 "><i class="fa fa-sticky-note"></i> Agregar</a>
                @endif
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
            @forelse ($Convenios as $objCon)
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
                                        <a href="{{ route('convenio.show', $objCon) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-eye" style="color:lightgreen" title="Mostrar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp
                                    @if(auth()->user()->roles()->first()->name=="Transferencia" || auth()->user()->roles()->first()->name=="Administrador")
                                    <i class="navi-item" data-toggle="modal" data-target="_self">
                                        <a href="{{ route('convenio.edit', $objCon) }}" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-pen" style="color:lightblue" title="Editar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    &nbsp
                                    <i class="navi-item" onclick="event.preventDefault(); confirmDestroyQuotation({{ $objCon->id }})">
                                        <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                            <i class="ace-icon fa fa-trash-alt" style="color:red" title="Eliminar"></i>
                                            </span>
                                        </a>
                                    </i>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="d-flex flex-column align-items-center">
                                <!--begin: Icon-->
                                <div>
                                    <p class="text-dark-75 font-weight-bold my-4 font-size-lg">Fecha firma: {{ $objCon->fechafirma }}</p>
                                </div>

                                    <center>
                                    <div>
                                    <a href="{{ route('convenio.show', $objCon) }}">
                                        <img alt="{{ $objCon->id }}" class="max-h-65px" src="{{ asset('assets') }}/media/svg/files/pdf.svg"/>
                                    </a>
                                        <!--begin: Tite-->
                                        <p></p>
                                        <p>{{ $objCon->nombre }}</p>
                                        <p class="text-dark-75 font-weight-bold my-4 font-size-lg">Fecha vigencia: {{ $objCon->fechavigencia }}</p>

                                    </div>
                                    </center>

                                <a class="text-dark-75 font-weight-bold mt-1 font-size-lg">Estado: {{ $objCon->estadoconvenio->descripcion }}</a>
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

        {{ $Convenios->links() }}

    @else

        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ningún Convenio.
                    <br> Ponga en marcha softInspi añadiendo su primer Convenio</p>

                    <a href="{{ route('convenio.create') }}" class="btn btn-primary">Agregar Convenio</a>
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
