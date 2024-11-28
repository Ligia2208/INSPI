@extends('layouts.main')

@section('title', 'Evidencias')

@section('content')
<div class="container">
    @if ($count)
         <!--begin::Advance Table Widget 3-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->

            <div class="card-header" wire:ignore>
                <div class="card-title">
                @forelse ($Evento as $objEven)
                    <h3 class="card-label">@yield('title') - {{ $objEven->nombreactividad }} </h3>
                @empty 
                @endforelse
                </div>
                <div class="card-toolbar">
                    <input type="hidden" name="idevento" id="idevento" value="{{ $objEven->id }}" />
                    <i class="navi-item" data-toggle="modal" data-target="_self">
                        <a href="{{ route('evento.index') }}" class="navi-link">
                        <span class="navi-icon">
                        <i class="ace-icon fa fa-reply" style="color:orange" title="Regresar"></i>
                        </span>
                        </a>
                    </i>
                    &nbsp;&nbsp;
                    <a href="/evidencias/agregar/{{ $objEven->id }}" class="btn btn-primary">Nuevo</a>
                    
                </div>
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
                <input type="hidden" name="idevento" id="idevento" value="{{ $id }}" />
                <div class="table-responsive">
                    <table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                        <thead>
                            <tr class="text-uppercase">
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Evidencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($Evidencias as $objEvid)
                                <tr>
                                    <td>
                                        <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $objEvid->tipoevidencia->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objEvid->descripcion }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark-25 font-weight-bolder d-block font-size-lg">{{ $objEvid->archivo }}</span>
                                    </td>
                                    <td align="center">
                                        <i class="navi-item" data-toggle="modal" data-target="#edit-{{ $objEvid->id }}">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-edit" style="color:lightblue" alt="Editar"></i>
                                            </span>
                                            </a>
                                        </i>
                                        <i class="navi-item" onclick="event.preventDefault(); confirmDestroyQuotation({{ $objEvid->id }})">
                                            <a href="#" class="navi-link">
                                            <span class="navi-icon">
                                                <i class="ace-icon fa fa-trash-alt" style="color:red" alt="Eliminar"></i>
                                            </span>
                                            </a>
                                        </i>
                                    </td>
                                </tr>
                                @include('intranet.evidencia.edit')
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

                {{ $Evidencias->links() }}

            </div>
            <!--end::Body-->
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <input type="hidden" name="idevento" id="idevento" value="{{ $id }}" />
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">El Evento </p>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ninguna Evidencia.</p>
                    <a href="{{ route('evento.index') }}" class="btn btn-primary">Regresar</a>
                    <a href="/evidencias/agregar/{{ $id }}" class="btn btn-primary">Agregar Evidencia</a>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt="" src="{{ asset('assets/media/ilustrations/areas.png') }}">

                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets') }}/plugins/custom/flot/flot.bundle.js"></script>
    <script src="{{ asset('assets') }}/js/pages/features/charts/flotcharts.js"></script>
@endsection
@push('footer')
        <script>
            function confirmDestroyQuotation(id){
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrás recuperar este evento",
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
