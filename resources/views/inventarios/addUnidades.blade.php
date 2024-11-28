
@extends('layouts.main')

@section('title', 'Artículos y Unidades Inventario')

<!-- DataTables CSS -->
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="" kt-hidden-height="54">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-1">
            <div class="d-flex align-items-baseline mr-5">
                <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">Artículos y Unidades Inventario</h5></a>
            </div>
        </div>
    </div>
</div>

<div id="kt_content" class="content d-flex flex-column flex-column-fluid">

    <div class="container2">
        <div class="page-content">

        @if(!$permiso)
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Importante!</h4>
                <p>Usted no pertenece a ningún laboratorio. Por favor, contáctese con los encargados.</p>
                <hr>
                <p class="mb-0">INSPI</p>
            </div>
        @else


            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('laboratorio')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-inboxes py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Inventario</h4>
                                </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('corrida')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-card-checklist py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">List Corrida</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('transferencia')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-folder-symlink py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Transferencía</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card radius-10 border border-1 border-primary encuesta position-relative" onclick="redireccionEncuesta('agregarUnidades')">
                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <div class="bg-primary text-white mr-2 rounded-circle fs-1"><i class="bi bi-plus-slash-minus py-3 px-2 titulo-grande"></i>
                                </div>

                                <div>
                                    <h4 class="my-1 text-primary ms-auto">Unidades</h4>
                                    <span class="position-absolute top-0 right-0 translate-middle badge rounded-pill menu-label">
                                        <span class="label label-danger">{{$cantKits}}+</span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <h2 class="mb-0 text-uppercase text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> Artículos y Unidades </h2>

            @if($admin)

            <div class="col-md-12 mt-1">
                <label for="id_labora" class="form-label fs-6">Seleccione el laboratorio</label>
                <select id="id_labora" name="id_labora" class="form-select single-select" required>
                    <option value="0">Seleccione Opción</option>
                    @foreach($laboratorios as $laboratorio)
                    <option value="{{ $laboratorio->id}}"> {{ $laboratorio->nombre}} </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Por favor seleccione una Opción.</div>
            </div>

            @endif



            <div class="accordion2 mt-3" id="accordionExample">

                @foreach($pruebasLab as $index => $pruebas)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed{{$index}}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapseOne">
                        {{ $pruebas->descripcion }} 
                    </button>
                    </h2>
                    <div id="collapsed{{$index}}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body row">

                            <div class="col-md-6 mt-4 row">
                                <div class="col-md-12">
                                    <label for="id_art1" class="form-label">Reactivos</label>
                                    <select id="id_art1_{{$index}}" name="id_art1" class="form-control single-select" required="" autofocus="">
                                        <option value="0">Seleccione un artìculo</option>
                                        @foreach($articulos as $articulo)
                                        <option value="{{$articulo->id}}">{{$articulo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('r')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <a type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2" onclick="guardarArt('id_art1_{{$index}}', '1')">
                                        <span class="bi bi-save2"></span>
                                        Guardar
                                    </a>
                                </div>
                            </div>


                            <div class="col-md-6 mt-4 border text-center">

                                <h4 class="p-4"> {{ $pruebas->descripcion }} </h4>

                                <ul class="list-group" id="group1">

                                    @if(count($articulosList) > 0)
                                    @foreach($articulosList as $articulo)
                                    @if($articulo->id_prueba == $pruebas->id)
                                    <li class="list-group-item mb-2 ">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                {{$articulo->nombre}}
                                            </div>
                                            <div class="col-lg-3">
                                                <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteSub( {{$articulo->id}}, {{$articulo->id_prueba}} )">
                                                    <span class="bi bi-x-circle"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                    @else
                                    <!-- <li class="list-group-item active" aria-current="true"> -->
                                    <li class="list-group-item mb-2">
                                        Aun no hay reactivos para esta categoría
                                    </li>
                                    @endif

                                </ul>

                            </div>
                            
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <hr/>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblIArticuloIndex" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>N. Artículo</th>
                                    <th>Lote</th>
                                    <th>Stock</th>
                                    <th>Unidad Medida</th>
                                    <th>Categoría</th>
                                    <th>Cant. Utilizar</th>
                                    <th>Presentación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>    
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>N. Artículo</th>
                                    <th>Lote</th>
                                    <th>Stock</th>
                                    <th>Unidad Medida</th>
                                    <th>Categoría</th>
                                    <th>Cant. Utilizar</th>
                                    <th>Presentación</th>
                                    <th>Estado</th>
                                    <th>Acciones</th> 
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        @endif
        </div>

    </div>

</div>


<div id="contModalUpdateUnidades">   
</div>


@endsection

<script>

    function redireccionEncuesta(dato){

        if(dato == 'corrida'){
            window.location.href = '/inventario/list_corrida';
        }else if(dato == 'transferencia'){
            window.location.href = '/inventario/transferencia';
        }else if(dato == 'agregarUnidades'){
            window.location.href = '/inventario/agregarUnidades';
        }else if(dato == 'laboratorio'){
            window.location.href = "/inventario/laboratorio";
        }

    }


</script>

@push('scripts')
<!-- Script personalizado -->
<script src="{{asset('assets/js/Inventario/addUnidades.js?v0.0.0')}}"></script>
@endpush