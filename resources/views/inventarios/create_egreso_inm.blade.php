
@extends('layouts.Rocker.index')

@section("style")
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/Inventario/create_egreso_inm.js?v0.0.1')}}"></script>
	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content mb-5">

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta position-relative" onclick="redireccionEncuesta('laboratorio')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bi bi-inboxes"></i>
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
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('corrida')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bi bi-card-checklist"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">List Corrida</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta" onclick="redireccionEncuesta('transferencia')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bi bi-folder-symlink"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Transferencía</h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-primary encuesta position-relative" onclick="redireccionEncuesta('agregarUnidades')">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <div class="widgets-icons-2 rounded-circle bg-primary text-white me-2"><i class="bi bi-plus-slash-minus"></i>
                            </div>

                            <div>
                                <h4 class="my-1 text-primary ms-auto">Unidades</h4>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{$cantKits}}+
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <h2 class="mb-0 text-uppercase text-center mt-5"><i class="font-32 text-success bi bi-clipboard2-pulse"></i> Registrar Corrida Inmunohematología </h2>
        
        <hr/>

        <div class="card">

            <div class="card-head">
                <div class="d-flex align-items-center p-3 text-white bg-primary rounded shadow-sm">
                    <div class="lh-1">
                        <h1 class="h3 mb-0 text-white lh-1">Datos de la Corrida</h1>
                        <input type="hidden" id="id_laboratorio" name="id_laboratorio" class="form-control" required="" autofocus="" value="{{ $labora->id }}">
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row p-2">

                    <div class="col-md-4">
                        <label for="tecnica" class="form-label fs-6">Técnica</label>
                        <input type="text" id="tecnica" name="tecnica" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-4">
                        <label for="para" class="form-label fs-6">Para</label>
                        <input type="text" id="para" name="para" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-4">
                        <label for="numero" class="form-label fs-6">N° de Corrida</label>
                        <input type="text" id="numero" name="numero" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="fechaCorrida" class="form-label fs-6">Fecha</label>
                        <input type="date" id="fechaCorrida" name="fechaCorrida" class="form-control" required="" autofocus="" value="<?php echo date('Y-m-d'); ?>" >
                        <div class="valid-feedback">Looks good!</div>
                    </div>


                    <div class="col-md-6 mt-2">
                        <label for="tipo" class="form-label fs-6">Seleccione el Tipo</label>
                        <select id="tipo" name="tipo" class="form-select single-select" required disabled>
                            <option value="0">Seleccione Opción</option>
                            <option value="I"> Ingreso </option>
                            <option value="E" selected> Corrida </option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="equipos" class="form-label fs-6">Equipos Usados</label>
                        <input type="text" id="equipos" name="equipos" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="equiposExt" class="form-label fs-6">Equipos de Extracción</label>
                        <input type="text" id="equiposExt" name="equiposExt" class="form-control" required="" autofocus="" value="">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                </div>

            </div>
        </div>


        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder active" id="list-arn-list" data-bs-toggle="list" href="#list-arn" role="tab" aria-controls="list-arn">ARN/ADN</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Reacciones</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder" id="list-standar-list" data-bs-toggle="list" href="#list-standar" role="tab" aria-controls="list-standar">Estandar</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder" id="list-termico-list" data-bs-toggle="list" href="#list-termico" role="tab" aria-controls="list-termico">P. Termico</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder" id="list-resultados-list" data-bs-toggle="list" href="#list-resultados" role="tab" aria-controls="list-resultados">Resultados</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fs-5 fw-bolder" id="list-controles-list" data-bs-toggle="list" href="#list-controles" role="tab" aria-controls="list-controles">Controles</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">

                <div class="tab-content" id="nav-tabContent">

                    <!-- EXTRACION DE ARN -->
                    <div class="tab-pane fade active show" id="list-arn" role="tabpanel" aria-labelledby="list-arn-list">

                        <div class="d-flex justify-content-end align-items-center">
                            <label class="form-label fs-4 text-primary"> Carga Masiva </label>

                            <label class="switch"> 
                                <input type="checkbox" id="caduca0" name="caduca" checked="">
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button class="btn btn-primary float-end" onclick="addReactivoARN()">
                                <i class="bi bi-node-plus"></i>ADD
                            </button>
                        </div>

                        <h2 class="text-center">Extracción de ARN/ADN</h2>

                        <div class="row">

                            <div class="row" id="contenARN">

                                <div class="col-md-4 mt-2">
                                    <input type="hidden" id="id_movimientoARN0" name="id_movimientoARN" class="form-control" required="" autofocus="" value="">
                                    <label for="nameKitARN" class="form-label fs-6">Nombre de Kit</label> 
                                    <select id="nameKitARN0" name="nameKitARN" class="form-select single-select" data-placeholder="Selecciona una opción" onchange="cargarLoteARN('0')">
                                    </select>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label for="loteARN" class="form-label fs-6">Lote</label>
                                    <select id="loteARN0" name="loteARN" class="form-select single-select" onchange="cargarUnidadesARN('loteARN0', '0')">
                                        <option value="0">Seleccione Opción</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <label for="fechaReactARN" class="form-label fs-6">Fecha</label>
                                    <input type="date" id="fechaReactARN0" name="fechaReactARN" class="form-control" required="" autofocus="" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>

                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="observaARN" class="form-label fs-6">Observación</label>
                                <textarea id="observaARN" name="observaARN" class="form-control" required="" autofocus="" rows="4"></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div id="bloqueTablaARN" class="mt-2" style="display: block;">
                                <table class="table table-striped table-hover mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">Acciones</th>
                                            <th scope="col">Código Muestra</th>
                                            <th scope="col">Tipo de Muestra</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cuerpoTablaARN">
                                        <tr id="totalMovimiento">
                                            <td></td>
                                            <td>                
                                                <input type="number" id="codMuestraARN" name="codMuestraARN" class="form-control" required autofocus value="0">
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                                <div class="invalid-feedback">Ingrese solo números</div>
                                            </td>
                                            <td>
                                                <select class="form-select" name="tipoMuestraARN"  id="tipoMuestraARN">
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-12 mt-2 d-flex align-items-center justify-content-start">
                                    <button id="importButton" class="btn btn-success" type="button" onclick="agregarARN()">
                                        <i class="bi bi-file-plus"></i> Agregar
                                    </button>
                                </div>

                            </div>

                            <div id="bloqueImportFormARN" class="mt-2" style="display: none;">
                                <div class="d-flex justify-content-end align-items-center mb-2">
                                    <a href="{{ asset('assets/doc/plantilla_adn.csv') }}" download="plantilla_adn.csv" class="btn btn-primary">
                                        Descargar Plantilla
                                        <i class='bx bx-download'></i>
                                    </a>
                                </div>

                                <div class="border p-5 pt-2">
                                    <label class="form-label fs-4 fw-bolder" for="customFile">Ingrese la matriz</label>
                                    <input type="file" class="form-control" name="fileADN" required id="fileADN" />
                                </div>
                            </div>

                        </div>

                    </div> 
                    <!-- EXTRACION DE ARN -->



                    <!-- MEZCLA DE REACCIONES -->
                    <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">

                        <h2 class="mb-4 text-primary" > Mezcla de reacciones </h2>

                        <div class="col-md-12 mt-2">
                            <label for="observaReacc" class="form-label fs-6">Observación</label>
                            <textarea id="observaReacc" name="observaReacc" class="form-control" required="" autofocus="" rows="4"></textarea>
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Acciones</th>
                                    <th scope="col" class="unidades">Kits</th>
                                    <th scope="col" class="unidades">Determinación</th>
                                    <th scope="col">Artículo</th>
                                    <th scope="col" class="cantidad">Cantidad(unidades)</th>
                                    <th scope="col">Lote</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaMovimiento">

                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-primary d-flex align-items-center justify-content-center float-start" type="button" id="btnAddMovimiento" onclick="agregarArticulo()">
                                    <i class="lni lni-circle-plus"></i> Agregar Reactivo
                                </a>
                            </div>
                        </div>


                        <div id="contentMezcla" class="mt-2 row">



                        </div>


                        <div class="row mt-2">
                            <div class="col-6">

                                <a class="btn btn-primary d-flex align-items-center justify-content-center float-start me-2" type="button" id="btnAddMovimiento" onclick="agregarExamen()">
                                    <i class="lni lni-circle-plus"></i> Agregar Prueba
                                </a>

                            </div>
                        </div>

                    </div>
                    <!-- MEZCLA DE REACCIONES -->


                    <!-- STANDAR DE CUANTIFICACION -->
                    <div class="tab-pane fade" id="list-standar" role="tabpanel" aria-labelledby="list-standar-list">

                        <h2> Corrida de Standares de Cuantificación </h2>

                        <div class="row">

                            <table class="table table-striped table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Estándar</th>
                                        <th scope="col">Concentración</th>
                                        <th scope="col">CT</th>
                                        <th scope="col">Interpretación</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaStandar">
                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <input type="text" id="standarSta0" name="standarSta" class="form-control" placeholder="Standar" aria-label="Standar" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="concentraSta0" name="concentraSta" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="ctSta0" name="ctSta" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="interSta0" name="interSta" class="form-control" placeholder="Interpretación" aria-label="Interpretación" aria-describedby="basic-addon2" value="-">
                                        </td>
                                    </tr>

                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <input type="text" id="standarSta1" name="standarSta" class="form-control" placeholder="Standar" aria-label="Standar" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="concentraSta1" name="concentraSta" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="ctSta1" name="ctSta" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="interSta1" name="interSta" class="form-control" placeholder="Interpretación" aria-label="Interpretación" aria-describedby="basic-addon2" value="-">
                                        </td>
                                    </tr>

                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <input type="text" id="standarSta2" name="standarSta" class="form-control" placeholder="Standar" aria-label="Standar" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="concentraSta2" name="concentraSta" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="ctSta2" name="ctSta" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="basic-addon2" value="-">
                                        </td>
                                        <td>
                                            <input type="text" id="interSta2" name="interSta" class="form-control" placeholder="Interpretación" aria-label="Interpretación" aria-describedby="basic-addon2" value="-">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div class="col-6 mt-2">
                                <button id="importButton" class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" onclick="agregarStandar()">
                                    <i class="bi bi-file-plus"></i> Agregar
                                </button>
                            </div>

                        </div>

                    </div> 
                    <!-- STANDAR DE CUANTIFICACION -->


                    <!-- PERFIL TERMICO -->
                    <div class="tab-pane fade" id="list-termico" role="tabpanel" aria-labelledby="list-termico-list">

                        <h2> Perfíl Termico </h2>

                        <div class="row">

                            <div class="col-md-4 mt-2">
                                <label for="canalesPer" class="form-label fs-6">Canales</label>
                                <input type="text" id="canalesPer" name="canalesPer" class="form-control" required="" autofocus="" value="FAN y VIC">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <table class="table table-striped table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Temperatura</th>
                                        <th scope="col">Tiempo</th>
                                        <th scope="col">Ciclos</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaTermico">
                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <div class="input-group">
                                                <input type="text" id="temperaPer0" name="temperaPer" class="form-control" placeholder="Temperatura" aria-label="Temperatura" aria-describedby="basic-addon2" value="50">
                                                <span class="input-group-text" id="basic-addon2">°C</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="tiempoPer0" name="tiempoPer" class="form-control" placeholder="Tiempo" aria-label="Tiempo" aria-describedby="basic-addon2" value="30">
                                                <span class="input-group-text" id="basic-addon2">min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="ciclosPer0" name="ciclosPer" class="form-control" placeholder="Ciclos" aria-label="Ciclos" aria-describedby="basic-addon2" value="45">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-repeat"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <div class="input-group">
                                                <input type="text" id="temperaPer1" name="temperaPer" class="form-control" placeholder="Temperatura" aria-label="Temperatura" aria-describedby="basic-addon2" value="95">
                                                <span class="input-group-text" id="basic-addon2">°C</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="tiempoPer1" name="tiempoPer" class="form-control" placeholder="Tiempo" aria-label="Tiempo" aria-describedby="basic-addon2" value="2">
                                                <span class="input-group-text" id="basic-addon2">min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="ciclosPer1" name="ciclosPer" class="form-control" placeholder="Ciclos" aria-label="Ciclos" aria-describedby="basic-addon2" value="45">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-repeat"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <div class="input-group">
                                                <input type="text" id="temperaPer2" name="temperaPer" class="form-control" placeholder="Temperatura" aria-label="Temperatura" aria-describedby="basic-addon2" value="95">
                                                <span class="input-group-text" id="basic-addon2">°C</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="tiempoPer2" name="tiempoPer" class="form-control" placeholder="Tiempo" aria-label="Tiempo" aria-describedby="basic-addon2" value="15">
                                                <span class="input-group-text" id="basic-addon2">min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="ciclosPer2" name="ciclosPer" class="form-control" placeholder="Ciclos" aria-label="Ciclos" aria-describedby="basic-addon2" value="45">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-repeat"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <div class="input-group">
                                                <input type="text" id="temperaPer3" name="temperaPer" class="form-control" placeholder="Temperatura" aria-label="Temperatura" aria-describedby="basic-addon2" value="60">
                                                <span class="input-group-text" id="basic-addon2">°C</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="tiempoPer3" name="tiempoPer" class="form-control" placeholder="Tiempo" aria-label="Tiempo" aria-describedby="basic-addon2" value="1">
                                                <span class="input-group-text" id="basic-addon2">min</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" id="ciclosPer3" name="ciclosPer" class="form-control" placeholder="Ciclos" aria-label="Ciclos" aria-describedby="basic-addon2" value="45">
                                                <span class="input-group-text" id="basic-addon2"><i class="bi bi-repeat"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="col-6 mt-2">
                                <button id="importButton" class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" onclick="agregarTermico()">
                                    <i class="bi bi-file-plus"></i> Agregar
                                </button>
                            </div>

                        </div>

                    </div> 
                    <!-- PERFIL TERMICO -->


                    <!-- REPORTE DE RESULTADOS -->
                    <div class="tab-pane fade" id="list-resultados" role="tabpanel" aria-labelledby="list-resultados-list">

                        <h2> Reporte de Resultados </h2>

                        <div class="row">

                            <div class="col-md-12 mt-2">
                                <label for="observaResult" class="form-label fs-6">Observación</label>
                                <textarea id="observaResult" name="observaResult" class="form-control" required="" autofocus="" rows="4"></textarea>
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                        </div>

                        <div id="bloqueTablaResultado" class="mt-2" style="display: block;">

                            <div class="col-12 mt-2 d-flex justify-content-center align-items-center">
                                <div class="col-2">
                                    <button id="importButton" class="btn btn-success d-flex align-items-center justify-content-center float-end" type="button" onclick="cargarResultados()">
                                        <i class="bi bi-plus-square-dotted"></i> Cargar Resultados
                                    </button>
                                </div>
                            </div>

                            <table class="table table-striped table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Acciones</th>
                                        <th scope="col">Código</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Procedencia</th>
                                        <th scope="col">Resultado</th>
                                        <th scope="col">CT</th>
                                        <th scope="col">Concentración</th>
                                        <th scope="col">Observación</th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaResultado">

                                    <tr id="">
                                        <td></td>
                                        <td>                
                                            <input type="text" id="codigoRes" name="codigoRes" class="form-control" placeholder="Código" aria-label="Código" aria-describedby="Código" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="pacienteRes" name="pacienteRes" class="form-control" placeholder="Paciente" aria-label="Paciente" aria-describedby="Paciente" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="procedenciaRes" name="procedenciaRes" class="form-control" placeholder="Procedencia" aria-label="Procedencia" aria-describedby="Procedencia" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="resultadoRes" name="resultadoRes" class="form-control" placeholder="Resultado" aria-label="Resultado" aria-describedby="Resultado" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="ctRes" name="ctRes" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="CT" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="concentraRes" name="concentraRes" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="Concentración" value="">
                                        </td>
                                        <td>
                                            <input type="text" id="observaRes" name="observaRes" class="form-control" placeholder="Observación" aria-label="Observación" aria-describedby="Observación" value="">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <div id="bloqueImportForm" class="mt-2" style="display: none;">
                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <a href="{{ asset('assets/doc/plantilla_resultados_inm.csv') }}" download="plantilla_resultados.csv" class="btn btn-primary">
                                    Descargar Plantilla
                                    <i class='bx bx-download'></i>
                                </a>
                            </div>

                            <div class="border p-5 pt-2">
                                <label class="form-label fs-4 fw-bolder" for="customFile">Ingrese la matriz</label>
                                <input type="file" class="form-control" name="file" required id="file" />
                            </div>
                        </div>

                    </div> 
                    <!-- REPORTE DE RESULTADOS -->


                    <!-- USO DE CONTROLES -->
                    <div class="tab-pane fade" id="list-controles" role="tabpanel" aria-labelledby="list-controles-list">

                        <h2> Uso de Controles </h2>

                        <div class="row">

                            <div class="col-md-4 mt-2">
                                <label for="umbralCon" class="form-label fs-6">Valor del Umbral</label>
                                <input type="text" id="umbralCon" name="umbralCon" class="form-control" required="" autofocus="" value="449.26">
                                <div class="valid-feedback">Looks good!</div>
                            </div>

                            <div class="col-md-4 mt-2 d-flex justify-content-center align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="autoCon" name="autoCon" required autofocus value="true">
                                    <label class="form-check-label fs-6" for="autoCon">Automatic</label>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            </div>

                        </div>

                        <table class="table table-striped table-hover mt-4">
                            <thead>
                                <tr>
                                    <th scope="col">Acciones</th>
                                    <th scope="col">Control</th>
                                    <th scope="col">Resultado</th>
                                    <th scope="col" class="unidades">CT</th>
                                    <th scope="col">C. Validación</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaControles">
                                <tr id="">
                                    <td></td>
                                    <td>     
                                        <select id="controlCon0" name="controlCon" class="form-select single-select" data-placeholder="Selecciona una opción" >
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="resultadoCon"  id="resultadoCon0">
                                            <option value="NEGATIVO"> NEGATIVO </option>
                                            <option value="POSITIVO"> POSITIVO </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" id="ctControl0" name="ctControl" class="form-control" placeholder="Tiempo" value="">
                                    </td>
                                    <td>
                                        <input type="text" id="validaControl0" name="validaControl" class="form-control" placeholder="Tiempo" value="Si cumple: ">
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="col-12 mt-2 d-flex align-items-center justify-content-start">
                            <button class="btn btn-success" type="button" onclick="agregarControles()">
                                <i class="bi bi-file-plus"></i> Agregar
                            </button>
                        </div>

                    </div> 
                    <!-- USO DE CONTROLES -->


                </div>

                <hr>

                <div class="col-12 mt-2 d-flex align-items-center justify-content-center">

                    <a class="btn btn-secondary" type="button" id="btnSaveMovimiento" onclick="guardarMovimiento()">
                        <i class='bx bxs-save'></i> Guardar
                    </a>

                </div>

            </div>
        </div>


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


    <div class="modal fade" id="addCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Artículo</h5>
                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                    <div id="modalContent">
                        <!-- Aquí se mostrarán los datos -->
                        <div class="col-md-12">
                            <label for="nameArticulo" class="form-label fs-6">Nombre del artículo</label>
                            <input type="text" id="nameArticulo" name="nameArticulo" class="form-control" required="" autofocus="" value="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="precioArticulo" class="form-label fs-6">Precio del Artículo</label>
                            <input type="text" id="precioArticulo" name="precioArticulo" class="form-control" required autofocus value="">
                            <div class="valid-feedback">¡Se ve bien!</div>
                            <div class="invalid-feedback">Ingrese solo números</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="categoriaArti" class="form-label fs-6">Seleccione la Categoría</label>
                            <select id="categoriaArti" name="categoriaArti" class="form-select single-select" required>
                                <option value="0">Seleccione Opción</option>
                                @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id}}"> {{ $categoria->nombre}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                        <div class="col-md-12 mt-1">
                            <label for="unidadaArticulo" class="form-label fs-6">Seleccione la Unidad de medida</label>
                            <select id="unidadaArticulo" name="unidadaArticulo" class="form-select single-select" required>
                                <option value="0">Seleccione Opción</option>
                                @foreach($unidades as $unidad)
                                        <option value="{{ $unidad->id}}"> {{ $unidad->abreviatura}} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione una Opción.</div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnArticulo">Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="contModalUpdateCategoria">
    </div>



@endsection

<script>

    function redireccionEncuesta(dato){

        if(dato == 'corrida'){
            //window.location.href = '/inventario/crearEgreso';
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

