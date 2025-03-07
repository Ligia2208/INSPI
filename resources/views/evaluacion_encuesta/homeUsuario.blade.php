@extends('layouts.main')

@section('title', 'Modulo encuesta usuario')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Modulo encuesta usuario</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content mb-5">

            <h1 class="mb-0 text-uppercase text-success text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Lista de Encuestas </h1>
                <!-- <hr/>
                <a class="col-2 btn btn-primary px-1 d-flex align-items-center justify-content-center" href="{{ route('encuesta.createEvento') }}" type="button" >
                    <i class="lni lni-circle-plus"></i> Crear Evento
                </a>
                <hr/>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tblGEncuestaIndex" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Laboratorio ID</th>
                                        <th>Fecha Desde</th>
                                        <th>Fecha Hasta</th>
                                        <th> <center> Estado </center></th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Laboratorio ID</th>
                                        <th>Fecha Desde</th>
                                        <th>Fecha Hasta</th>
                                        <th> <center> Estado </center></th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div> -->


            <!-- @foreach($encuestas as $encuesta)

                @if($encuesta->tipoencuesta_id == 1)

                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Internas </h2>

                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{$encuesta->id}}')">
                            <div class="card-header">
                                <div class="h4">Encuesta</div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta->name}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @elseif($encuesta->tipoencuesta_id == 2)

                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Externas Presenciales </h2>

                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{$encuesta->id}}')">
                            <div class="card-header">
                                <div class="h4">Encuesta</div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta->name}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @elseif($encuesta->tipoencuesta_id == 3)

                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Externas No Presenciales </h2>

                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{$encuesta->id}}')">
                            <div class="card-header">
                                <div class="h4">Encuesta</div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta->name}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif

            @endforeach -->




            @foreach($eventosArray as $evento)

                <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> {{ $evento['nombre'] }} - {{ $evento['periodo'] }}  - {{ $evento['anio'] }} </h2>
                <div class="row mt-4">

                @foreach($evento['encuetas'] as $encuesta)

                @if($encuesta['tipoencuesta_id'] == 1)

                <!-- <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Internas </h2> -->

                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{ $encuesta['id']}}', '{{ $evento['id']}} ', '{{$encuesta['realizado']}}', '{{$encuesta['tipoencuesta_id']}}')">
                            <div class="card-header">

                                <div class="d-flex align-items-center">
                                    <div class="h4 col-lg-10">Encuestas Internas</div>
                                    @if($encuesta['realizado'] == 'true')
                                    <div class="dropdown ms-auto">
                                        <div class="dropdown-toggle dropdown-toggle-nocaret"><i class='bx bxs-check-circle text-success fs-25'></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta['name']}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($encuesta['tipoencuesta_id'] == 2)

                <!-- <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Externas Presenciales </h2> -->

                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{$encuesta['id']}}', '{{$evento['id']}}', '{{$encuesta['realizado']}}', '{{$encuesta['tipoencuesta_id']}}')">
                            <div class="card-header">

                                <div class="d-flex align-items-center">
                                    <div class="h4 col-lg-10">Encuestas Externas Presenciales</div>
                                    @if($encuesta['realizado'] == 'true')
                                    <div class="dropdown ms-auto">
                                        <div class="dropdown-toggle dropdown-toggle-nocaret"><i class='bx bxs-check-circle text-success fs-25'></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta['name']}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($encuesta['tipoencuesta_id'] == 3)

                <!-- <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Encuestas Externas No Presenciales </h2> -->

                    <div class="col-lg-4">
                        <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('{{$encuesta['id']}}', '{{ $evento['id'] }}', '{{$encuesta['realizado']}}', '{{$encuesta['tipoencuesta_id']}}')">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <div class="h4 col-lg-10">Encuestas Externas No Presenciales</div>
                                    @if($encuesta['realizado'] == 'true')
                                    <div class="dropdown ms-auto">
                                        <div class="dropdown-toggle dropdown-toggle-nocaret"><i class='bx bxs-check-circle text-success fs-25'></i>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center">

                                    <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class='bx bxs-flask'></i>
                                    </div>

                                    <div>
                                        <h4 class="my-1 text-primary ms-auto"> {{$encuesta['name']}} </h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                @endif
                @endforeach
                </div>

            @endforeach

        </div>


        




        @if(session('success'))
        <script>
            Swal.fire({
                title: 'SoftInspi',
                text: '{{ session('success') }}',
                icon: 'success',
                type: 'success',
                confirmButtonText: 'Aceptar',
                timer: 3500
            });
        </script>
        @endif

    </div>

</div>



@endsection

<script>

    function redireccionEncuesta(dato, id_evento, estado, tipo){

        //aqui validar que la encuesta ya fue hecha
        if(estado == 'true' && tipo != 2 ){
            window.location.href = '/encuestas/finishEncuesta?tipousu_id='+dato+'&id_evento='+id_evento;

        }else{
            window.location.href = '/encuestas/doEncuesta?tipousu_id='+dato+'&id_evento='+id_evento;
        }

    }


</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/EventoEncuesta/initEncuesta.js?v0.0.0')}}"></script>
@endpush