
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('assets/js/EventoEncuesta/usuEncuesta.js?v0.0.2')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <!-- <h2 class="mb-0 text-uppercase text-center mt-2"> <i class='font-32 text-success bx bx-dock-top'></i> Visualizar encuentas de los Usuarios </h2>
        <hr/> -->

        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <div class="row">

            <input type="hidden" value="{{$tipoencu_id}}" id="tipoencu_id">
            <input type="hidden" value="{{$id_evento}}" id="id_evento">
            
            <h2 class="mb-0 text-uppercase text-primary text-center mt-5"> <i class='font-32 text-success bx bx-table'></i> {{$laboratorio_name}} - {{$tipo_name}}  </h2>
            <hr/>

            <a class="col-2 btn btn-danger px-1 d-flex align-items-center justify-content-center mb-4" href="{{ route('encuesta') }}" type="button" >
                <i class="bi bi-arrow-return-left"></i> Regresar
            </a>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblGEncuestaUsuario" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Servidor</th>
                                    <th>Encuesta</th>
                                    <th>Usuario</th>
                                    <th> <center> Fecha </center></th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>id</th>
                                    <th>Servidor</th>
                                    <th>Encuesta</th>
                                    <th>Usuario</th>
                                    <th> <center> Fecha </center></th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" id="contGraficos">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">   
                            <canvas id="myChart2000" style="width='200'; height='200';"></canvas>
                        </div>
                        <button id="saveButton">Guardar Gráfico</button>
                    </div> 
                </div> 


                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body" id="contenedorPreguntas">  
                            <div class="mb-4 row">
                                <h2 class="mb-0 text-secondary col-lg-6">Total de Encuestas: <strong id="encuestadosT" class="text-primary fs-1">  </strong> </h2>
                                <h2 class="mb-0 text-secondary col-lg-6">Promedio: <strong id="promedioT" class="text-primary fs-1">  </strong> </h2>
                                <hr>
                            </div> 
                            <div class="mb-4">
                                <h2 class="mb-0 text-secondary">Promedios de las preguntas</h2>
                            </div> 



                        </div>

                    </div>
                </div> 
            </div>




            <div class="accordion mb-5" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Comentarios Hospitales
                    </button>
                    </h2>

                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <!-- <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>-->
                    </div> 

                </div>
            </div>


        </div>
    </div>
</div>
@endsection


