@extends('layouts.main')

@section('title', 'Producto')

@section('content')

    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center flex-wrap mr-1">
                <div class="d-flex align-items-baseline mr-5">
                    <a href="#"><h5 class="text-dark font-weight-bold my-2 mr-5">@yield('title')</h5></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <!-- HMACHUCA -->
            <link href="{{asset('assets')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
            <link href="{{asset('assets')}}/css/dataTables.min.css" rel="stylesheet" type="text/css" />

            <script src="{{asset('assets')}}/js/jquery.js"></script>
            <script src="{{asset('assets')}}/js/jquery.validate.js"></script>
            <script src="{{asset('assets')}}/js/dataTables.min.js"></script>
            <script src="{{asset('assets')}}/js/bootstrap.min.js"></script>
            <script src="{{asset('assets')}}/js/bootstrap4.min.js"></script>

            <!-- HMACHUCA -->

            <script src="{{asset('assets')}}/js/bootbox.js"></script>
            <script src="{{asset('assets')}}/js/select2/dist/js/select2.js"></script>
            <script src="{{asset('assets')}}/js/bootbox.min.js"></script>
            <script src="{{asset('assets')}}/js/waitMe/waitMe.min.js"></script>

            <div class="container mt-2">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right mb-2">
                            <a id="createProducto" class="btn btn-primary btn-shadow font-weight-bold mr-2" href="javascript:void(0)">
                                <i class="fa fa-plus"></i> Nuevo
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="datatable-producto">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Presentación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready( function () {
                    $.noConflict();
                    $.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#datatable-producto').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ url('producto') }}",
                        columns: [
                            {   data: 'id',                     name: 'id', 'visible': false},
                            {   data: 'codigo',                 name: 'codigo'},
                            {   data: 'nombre',                 name: 'nombre' },
                            {   data: 'presentacion',           name: 'presentacion'},
                            {   data: null,
                                render: function (data, type, full, meta) {
                                    var array = "";

                                    array = '<a title="Editar Producto" id="editProducto" href="javascript:void(0)" data-id="'+ full.id +'" data-codigo="'+ full.codigo +'" data-nombre="'+ full.nombre +'" data-almacenamiento="'+ full.almacenamiento +'" data-color="'+ full.color +'" data-consistencia="'+ full.consistencia +'" data-esterilizacion="'+ full.esterilizacion +'" data-temperatura_cent="'+ full.temperatura_cent +'" data-presion_lbs="'+ full.presion_lbs +'" data-tiempo_min="'+ full.tiempo_min +'" data-fecha_caducidad="'+ full.fecha_caducidad +'" data-lote="'+ full.lote +'" data-ph="'+ full.ph +'" data-presentacion="'+ full.presentacion +'" data-temp_conservacion="'+ full.temp_conservacion +'" data-registro_produccion="'+ full.registro_produccion +'" data-control_esterilidad="'+ full.control_esterilidad +'" data-control_microbiologico="'+ full.control_microbiologico +'" data-certificado="'+ full.certificado +'" data-estado="'+ full.estado +'" data-toggle="tooltip" data-original-title="Edit" class="edit">'
                                        + '<i class="ace-icon fa fa-edit" style="color:green"></i>'
                                        + '</a>'
                                        + ' '
                                        + '<a title="Eliminar Producto" id="deleteProducto" href="javascript:void(0)" data-id="'+ full.id +'" data-toggle="tooltip" data-original-title="Delete" class=" delete">'
                                        + '<i class="ace-icon fa fa-trash-alt" style="color:red"></i>'
                                        + '</a>'
                                        + '</div>';

                                    return array;
                                }
                            }
                        ],
                        language: {
                            emptyTable: "No hay información",
                            //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            //"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            //"infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            infoPostFix: "",
                            thousands: ",",
                            //"lengthMenu": "Mostrar _MENU_ Entradas",
                            loadingRecords: "Cargando...",
                            processing: "Procesando...",
                            search: "Buscar:",
                            zeroRecords: "Sin resultados encontrados"
                            //            "paginate": {
                            //                "first": "Primero",
                            //                "last": "Ultimo",
                            //                "next": "Siguiente",
                            //                "previous": "Anterior"
                            //            }
                        },
                        responsive: {
                            details: {
                                type: "column",
                                target: 0
                            }
                        },
                        columnDefs: [{
                            className: "control",
                            orderable: false,
                            targets: 0
                        }],
                        order: [[0, 'desc']]
                    });

                    $(document).on('click', '#createProducto', function(){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            url: "{{url('producto.create')}}",
                            cache: false,
                            beforeSend: function () {
                                $('body').waitMe({
                                    effect: 'roundBounce', //'roundBounce',//'bounce','win8','orbit','ios','win8_linear'
                                    text: 'Por favor espere...', //'Please waiting...',
                                    bg: 'rgba(255,255,255,0.7)',
                                    color: '#A52A2A'
                                });
                            },
                            success: function(res){
                            var modalNewProducto = bootbox.dialog({
                                title: "<i class=' glyphicon glyphicon-th-large'></i> Agregar Producto",
                                message: res,
                                className: "large",
                                size: 'large',
                                show: false,

                                buttons: {
                                    submit:{
                                        label: '<span class="fa fa-floppy"></span> Guardar',
                                        className: "submit btn btn-primary btn-shadow font-weight-bold mr-2",
                                        callback: function(){
                                            var form = modalNewProducto.find("#frmCrearProducto");
                                            var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });

                                            if($(form).valid()){
                                                $.get(form[0].action, datos).done(function(request){
                                                    modalNewProducto.modal('hide');
                                                    window.location.replace("{{route('producto.index')}}");
                                                    //console.log(request);
                                                })
                                            }
                                            return false;
                                        }
                                    },
                                    cancel: {
                                        label: '<span class="fa fa-close"></span> Cerrar',
                                        className: "btn btn-danger btn-shadow font-weight-bold mr-2",
                                        callback: function(){
                                            modalNewProducto.modal('hide');
                                        }//fin callback
                                    }//fin cancelar
                                },
                                onEscape: function () {
                                    modalNewProducto.modal("hide");
                                },
                                backdrop: "static",

                            }).on('shown.bs.modal', function (e) {
                                $('body').waitMe('hide');
                                modalNewProducto.attr("id", "modal-wizard-datatables");
                                modalNewProducto.css({ "overflow-y": "scroll" });
                            });//fin modal
                            // modalNewProducto.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
                            modalNewProducto.find(".modal-header").addClass("modal-header-info");
                            modalNewProducto.modal('show');

                            }//fin success

                        });
                    });

                    $(document).on('click', '#editProducto', function(){
                        var id                      = $(this).data('id');
                        var codigo                  = $(this).data('codigo');
                        var nombre                  = $(this).data('nombre');
                        var almacenamiento          = $(this).data('almacenamiento');
                        var color                   = $(this).data('color');
                        var consistencia            = $(this).data('consistencia');
                        var esterilizacion          = $(this).data('esterilizacion');
                        var temperatura_cent        = $(this).data('temperatura_cent');
                        var presion_lbs             = $(this).data('presion_lbs');
                        var tiempo_min              = $(this).data('tiempo_min');
                        var fecha_caducidad         = $(this).data('fecha_caducidad');
                        var lote                    = $(this).data('lote');
                        var ph                      = $(this).data('ph');
                        var presentacion            = $(this).data('presentacion');
                        var temp_conservacion       = $(this).data('temp_conservacion');
                        var registro_produccion     = $(this).data('registro_produccion');
                        var control_esterilidad     = $(this).data('control_esterilidad');
                        var control_microbiologico  = $(this).data('control_microbiologico');
                        var certificado             = $(this).data('certificado');
                        var estado                  = $(this).data('estado');

                        var url = '{{route("producto.edit", ":id")}}';

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "GET",
                            url: url.replace(':id', id),
                            data: { id: id},
                            cache: false,
                            success: function(res){

                                var modalEditProducto = bootbox.dialog({
                                    title: "<i class=' glyphicon glyphicon-th-large'></i>Editar Producto",
                                    message: res,
                                    className: "large",
                                    show: false,
                                    size: 'large',
                                    buttons: {

                                        nuevo: {
                                            label: '<span class="fa fa-save"></span> Guardar',
                                            className: "submit btn btn-primary btn-shadow font-weight-bold mr-2",
                                            callback: function(){
                                                var form = modalEditProducto.find("#frmEditarProducto");
                                                var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });

                                                if($(form).valid()){
                                                    $.get(form[0].action, datos).done(function(request){
                                                        modalEditProducto.modal('hide');
                                                        window.location.replace("{{route('producto.index')}}");
                                                        //console.log(request);
                                                    })
                                                }
                                                return false;
                                            },
                                        },

                                        cancel: {
                                            label: '<span class="fa fa-close"></span> Cerrar',
                                            className: "btn btn-danger btn-shadow font-weight-bold mr-2",
                                            callback: function(){
                                                modalEditProducto.modal('hide');
                                                //$('#datatable-crud').DataTable().ajax.reload();
                                                window.location.replace("{{route('producto.index')}}");
                                            }//fin callback

                                        }//fin cancelar
                                    },
                                    onEscape: function () {
                                        modalEditProducto.modal("hide");
                                        window.location.replace("{{route('producto.index')}}");
                                    },
                                    backdrop: "static",

                                }).on('shown.bs.modal', function (e) {
                                    $('body').waitMe('hide');
                                    modalEditProducto.attr("id", "modal-wizard-datatables");
                                    modalEditProducto.css({ "overflow-y": "scroll" });
                                });//fin modal
                                //modalObjEst.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
                                modalEditProducto.find(".modal-header").addClass("modal-header-info");
                                modalEditProducto.modal('show');
                                $('#txtCodigoProducto').val(codigo);
                                $('#txtNombreProducto').val(nombre);
                                $('#txtAlmacenProducto').val(almacenamiento);
                                $('#txtColorProducto').val(color);
                                $('#txtConsistenciaProducto').val(consistencia);
                                $('#txtEsteriliProducto').val(esterilizacion);
                                $('#txtTemperaturaProducto').val(temperatura_cent);
                                $('#txtPresionProducto').val(presion_lbs);
                                $('#txtTiempoProducto').val(tiempo_min);
                                $('#txtCaducidadProducto').val(fecha_caducidad);
                                $('#txtLoteProducto').val(lote);
                                $('#txtPhProducto').val(ph);
                                $('#txtPresentacionProducto').val(presentacion);
                                $('#txtTempConservProducto').val(temp_conservacion);
                                $('#txtRegProduccionProducto').val(registro_produccion);
                                $('#txtCtrlEsterilProducto').val(control_esterilidad);
                                $('#txtCtrlMicrobioProducto').val(control_microbiologico);
                                $('#txtCertificadoProducto').val(certificado);
                                $('#slcEstadoProducto').val(estado).trigger("change.select2").select2("focus");
                            }//fin success
                        });//fin ajax

                        return false;
                    })

                    $(document).on('click', '#deleteProducto', function () {
                        if (confirm("Desea eliminar registro?") == true) {
                            var id = $(this).data('id');
                            // ajax
                            $.ajax({
                                    type:"POST",
                                    url: "{{ url('producto.delete') }}",
                                    data: { id: id,
                                            _token: "{{ csrf_token() }}"
                                    },
                                    dataType: 'json',
                                    success: function(res){
                                    var oTable = $('#datatable-producto').dataTable();
                                    oTable.fnDraw(false);
                                    }//fin success
                            });//fin ajax
                        }//fin if
                    });

                });
            </script>
        </div>
    </div>

@endsection