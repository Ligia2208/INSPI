
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js')}}"></script> -->

@extends('layouts.Rocker.index')

@section("style")
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>

	@endsection

@section('wrapper')
<!--start page wrapper -->
<!-- <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-columns"></i> Gestión Documental </h6> -->

<div class="page-wrapper">
	<div class="page-content">
        <h6 class="mb-0 text-uppercase"><i class="font-22 text-success fadeIn animated bx bx-paste"></i> ASIGNAR RESPONSABLE DEL DOCUMENTO </h6>
        <!-- <hr/> -->
            <!-- <button class="btn btn-primary px-5  d-flex align-items-center" id="btnCreateCatalogo" name="btnCreateCatalogo" type="button" >
                <i class="lni lni-circle-plus"></i> Agregar
            </button> -->
        <hr/>


        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet">

        <?php

            $data = json_decode($documento, true);

            // Verifica si la decodificación fue exitosa
            if ($data !== null) {
                $primerElemento = $data[0];
            }

        ?>




        <div class="row">
            <div class="col-xl-12 mx-auto">

                <div class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="mb-0 text-uppercase mt-4 ms-3">
                                        <i class="font-22 text-success fadeIn animated bx bx-clipboard"></i>
                                        DATOS DEL SEGUMIENTO
                                    </h6>
                                </div>
                                <div class="col-5 mt-4">
                                    <div class="d-flex justify-content-end">
                                        @if($primerElemento['estado'] == 'E')
                                        <span class="badge bg-secondary fs-6">Eliminado</span>
                                        @elseif($primerElemento['estado'] == 'V')
                                        <span class="badge bg-danger fs-6">Expirado</span>
                                        @else
                                        <span class="badge bg-success fs-6">Activo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="p-4 border rounded">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Número de Documento:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['nombre'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Fecha de Creación:</strong> </label>
                                    <spam class="fs-6"> {{ $fechaFormateada = date("Y-m-d", strtotime($primerElemento['fecha'])) }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Tipo de Documneto:</strong> </label>
                                    @if($primerElemento['tipo'] == '1')
                                    <spam class="fs-6"> Correo <spam>
                                    @else
                                    <spam class="fs-6"> Quipux <spam>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Departamento Asignado:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['asignado'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Fecha de Vencimiento:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['f_plazo'] }} <spam>
                                </div>

                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fs-6"> <strong>Días faltantes:</strong> </label>
                                    <spam class="fs-6"> {{ $primerElemento['dias_faltantes'] }} <spam>
                                </div>

                            </div>

                            <!-- [{"nombre":"12","tipo":"1","fecha":"2023-09-20 00:00:00","f_plazo":null,"id_usuario":null,"estado":"A","asignado":null,"cargo":null,"id_documento":14}] -->


                        </div>
                            <hr>

                        <div class="p-4 border rounded">

                            <form id="frmCreateCatalogo" action="{{ route('gestion.storeappoint') }}" method="post" class="row g-3 needs-validation " novalidate>
                            @csrf

                                <input type="hidden" id="id_asignacion" name="id_asignacion" class="form-control"  readonly="readonly" required="" value="{{ $primerElemento['id_asignacion'] }}" autofocus>

                                <div class="col-md-6">
                                    <label for="departamentos" class="form-label">Departamento</label>
                                    <select id="departamento" name="departamento" class="form-select single-select  @error('departamento') is-invalid @enderror" required="" autofocus="">
                                        <option value="">Seleccione un Departamento</option>
                                        @foreach($departamentos as $dep)
                                            <option value="{{ $dep->id}}"> {{ $dep->nombre}} </option>
                                        @endforeach
                                    </select>
                                    @error('departamento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="usuario" class="form-label">Usuario Designado</label>
                                    <select id="usuario" name="usuario" class="form-select @error('usuario') is-invalid @enderror">
                                        <option value="" >Seleccione Usuario</option>
                                        @foreach($usuariosDepa as $usuarios)
                                        <option value="{{$usuarios->id}}" @if(old('usuario') == '{{$usuarios->id}}') selected @endif> {{$usuarios->nombre}} </option>
                                        @endforeach
                                    </select>
                                    @error('usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="modal-footer mt-4">
                                    <button type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2">
                                        <span class="lni lni-save"></span>
                                        Guardar
                                    </button>
                                    <a type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 bootbox-cancel" href="{{ route('documentos') }}">
                                        <span class="lni lni-close"></span>
                                        Cerrar
                                    </a>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>

    <script>
        $(document).ready(function() {

            $('#departamento').on('change', function() {
                var selectedDepar = $(this).val();
                // Realiza una solicitud AJAX para obtener las opciones de departamento
                $.ajax({
                    type: 'GET', // O el método que estés utilizando en tu ruta
                    url: '/obtenerUsuarios/' + selectedDepar, // Ruta en tu servidor para obtener las opciones
                    success: function(data) {
                        var departamentoSelect = $('#usuario');
                        departamentoSelect.empty(); // Limpia las opciones actuales

                        // Agrega las nuevas opciones basadas en la respuesta del servidor
                        $.each(data, function(index, departamento) {
                            departamentoSelect.append($('<option>', {
                                value: departamento.id,
                                text: departamento.nombre
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al obtener opciones de departamento', error);
                    }
                });
            });
        });
    </script>

</div>
@endsection







