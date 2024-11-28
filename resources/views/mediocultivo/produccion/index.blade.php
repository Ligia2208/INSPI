@extends('layouts.main')

@section('title', 'Produccion')

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
                <!--<div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right mb-2">
                            <a id="createProduccion" class="btn btn-primary btn-shadow font-weight-bold mr-2" href="javascript:void(0)">
                                <i class="fa fa-plus"></i> Nuevo
                            </a>
                        </div>
                    </div>
                </div>-->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="datatable-produccion" name="datatable-produccion">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Id_Requerimiento</th>
                                        <th>Id_Producto</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Producto</th>
                                        <th>Material</th>
                                        <th>Volumen</th>
                                        <th>Observacion</th>
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

                    $('#datatable-produccion').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ url('produccion') }}",
                        columns: [
                            {   data: 'id',                         name: 'id',                         'visible': false},
                            {   data: 'id_registro_requerimiento',  name: 'id_registro_requerimiento',  'visible': false},
                            {   data: 'id_producto',                name: 'id_producto',                'visible': false},
                            {   data: 'estado_produccion',          name: 'estado_produccion'},
                            {   data: 'fecha_solicitud',            name: 'fecha'},
                            {   data: 'producto',                   name: 'producto'},
                            {   data: 'cantynombre_material_ent',   name: 'material'},
                            {   data: 'volumen_requerido_ml',       name: 'volumen'},
                            {   data: 'observacion',                name: 'observacion'},
                            {   data: null,
                                render: function (data, type, full, meta) {
                                    var array = "";

                                    array = '<a title="Procesar" id="procesarProduccion" href="javascript:void(0)" data-id="'+ full.id +'" data-id_registro_requerimiento="'+ full.id_registro_requerimiento +'" data-id_producto="'+ full.id_producto +'" data-producto="'+ full.producto +'" data-material="'+ full.material +'" data-volumen="'+ full.volumen +'" data-observacion="'+ full.observacion +'" data-estado="'+ full.estado +'" data-toggle="tooltip" data-original-title="Edit" class="edit">'
                                        + '<i class="ace-icon fa fa-edit" style="color:green"></i>'
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

                    /*$(document).on('click', '#createRequerimiento', function(){
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'GET',
                            url: "{{url('requerimiento.create')}}",
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
                            var modalNewRequerimiento = bootbox.dialog({
                                title: "<i class=' glyphicon glyphicon-th-large'></i> Agregar Requerimiento",
                                message: res,
                                className: "large",
                                size: 'large',
                                show: false,

                                buttons: {
                                    submit:{
                                        label: '<span class="fa fa-floppy"></span> Guardar',
                                        className: "btnGuardarProducto submit btn btn-primary btn-shadow font-weight-bold mr-2",
                                        callback: function(){
                                            var x = $('input[name="cod[]"]').map(function(){
                                                return this.value;
                                            }).get();
                                            var form = modalNewRequerimiento.find("#frmCrearRequerimiento");
                                            var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });
                                            //alert(datos);
                                            if($(form).valid()){
                                                $.get(form[0].action, datos).done(function(request){
                                                    //alert(request);
                                                    modalNewRequerimiento.modal('hide');
                                                    window.location.replace("{{route('requerimiento.index')}}");
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
                                            modalNewRequerimiento.modal('hide');
                                        }//fin callback
                                    }//fin cancelar
                                },
                                onEscape: function () {
                                    modalNewRequerimiento.modal("hide");
                                },
                                backdrop: "static",

                            }).on('shown.bs.modal', function (e) {
                                $('body').waitMe('hide');
                                modalNewRequerimiento.attr("id", "modal-wizard-datatables");
                                modalNewRequerimiento.css({ "overflow-y": "scroll" });
                            });//fin modal
                            // modalNewRequerimiento.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
                            modalNewRequerimiento.find(".modal-header").addClass("modal-header-info");
                            modalNewRequerimiento.modal('show');

                            }//fin success

                        });
                    });

                    $(document).on('click', '#editRequerimiento', function(){
                        var id                      = $(this).data('id');
                        var fecha_solicitud         = $(this).data('fecha_solicitud');
                        var hora_solicitud          = $(this).data('hora_solicitud');
                        var area                    = $(this).data('id_area');
                        var numero_pedido           = $(this).data('numero_pedido');
                        var solicitante             = $(this).data('solicitante');
                        var auxiliar                = $(this).data('auxiliar_mdc');
                        var responsable             = $(this).data('responsable_mdc');
                        var estado                  = $(this).data('estado');

                        var url = '{{route("requerimiento.edit", ":id")}}';

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            type: "GET",
                            url: url.replace(':id', id),
                            data: { id: id},
                            cache: false,
                            success: function(res){

                                var modalEditRequer = bootbox.dialog({
                                    title: "<i class=' glyphicon glyphicon-th-large'></i>Editar Requerimiento",
                                    message: res,
                                    className: "large",
                                    show: false,
                                    size: 'large',
                                    buttons: {

                                        nuevo: {
                                            label: '<span class="fa fa-save"></span> Actualizar',
                                            className: "submit btn btn-primary btn-shadow font-weight-bold mr-2",
                                            callback: function(){
                                                var form = modalEditRequer.find("#frmEditarRequerimiento");
                                                var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });
                                                //alert(datos);
                                                if($(form).valid()){
                                                    $.get(form[0].action, datos).done(function(request){
                                                        modalEditRequer.modal('hide');
                                                        window.location.replace("{{route('requerimiento.index')}}");
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
                                                modalEditRequer.modal('hide');
                                                //$('#datatable-crud').DataTable().ajax.reload();
                                                window.location.replace("{{route('requerimiento.index')}}");
                                            }//fin callback

                                        }//fin cancelar
                                    },
                                    onEscape: function () {
                                        modalEditRequer.modal("hide");
                                        window.location.replace("{{route('requerimiento.index')}}");
                                    },
                                    backdrop: "static",

                                }).on('shown.bs.modal', function (e) {
                                    $('body').waitMe('hide');
                                    modalEditRequer.attr("id", "modal-wizard-datatables");
                                    modalEditRequer.css({ "overflow-y": "scroll" });
                                });//fin modal
                                //modalObjEst.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
                                modalEditRequer.find(".modal-header").addClass("modal-header-info");
                                modalEditRequer.modal('show');
                                $('#txtIdRequer').val(id);
                                $('#txtFechaRequer').val(fecha_solicitud);
                                $('#txtHoraRequer').val(hora_solicitud);
                                alert(auxiliar);
                                $('#slcAreaRequer').val(area).trigger("change.select2").select2("focus");
                                $('#txtNumPedidoRequer').val(numero_pedido);
                                $('#txtSolicitanteRequer').val(solicitante);
                                $('#txtAuxiliarRequer').val(auxiliar);
                                $('#txtResponsableRequer').val(responsable);
                                $('#slcEstadoRequer').val(estado).trigger("change.select2").select2("focus");
                            }//fin success
                        });//fin ajax

                        return false;
                    })*/

                    $(document).on('click', '#deleteProduccion', function () {
                        if (confirm("Desea eliminar registro?") == true) {
                            var id = $(this).data('id');
                            // ajax
                            $.ajax({
                                    type:"POST",
                                    url: "{{ url('produccion.delete') }}",
                                    data: { id: id,
                                            _token: "{{ csrf_token() }}"
                                    },
                                    dataType: 'json',
                                    success: function(res){
                                    var oTable = $('#datatable-produccion').dataTable();
                                    oTable.fnDraw(false);
                                    }//fin success
                            });//fin ajax
                        }//fin if
                    });

                });

                /*function agregarproducto() {
                    
                    var sel = $('#slcProductoRequer option:selected').val(); //Capturo el Value del Producto
                    var text = $('#slcProductoRequer option:selected').text();//Capturo el Nombre del Producto- Texto dentro del Select
                    

                    var sptext = text.split();
                    //alert(text);
                    var newtr = '<tr class="item" data-id="'+sel+'">'
                     + '<td> <input  class="form-control" id="cod[]" name="cod[]" value="'+sel+'" /></td>'
                     + '<td class="iProduct">' + text + '</td>'
                     + '<td> <input  class="form-control" id="material" name="material[]" required /></td>'
                     + '<td><input  class="form-control" id="volumen" name="volumen[]" required /></td>'
                     + '<td><input  class="form-control"  id="observacion" name="observacion[]" required /></td>'
                     + '<td><button type="button" class="btn btn-danger btn-xs remove-item"><i class="fa fa-times"></i></button></td></tr>';
                    //alert(newtr);
                    $('#ProSelected').append(newtr); //Agrego el Producto al tbody de la Tabla con el id=ProSelected
                    
                    $('input [name="cod[]"]').each(function(e,index){
                        alert(${index});
                    });
                    //RefrescaProducto();//Refresco Productos
                        
                    $('.remove-item').off().click(function(e) {
                        $(this).parent('td').parent('tr').remove(); //En accion elimino el Producto de la Tabla
                        if ($('#ProSelected tr.item').length == 0)
                            $('#ProSelected .no-item').slideDown(300); 
                        //RefrescaProducto();
                    });        
                    $('.iProduct').off().change(function(e) {
                        RefrescaProducto();
                    });
                }*/

                /*{   data: null,
                    render: function(data, type, full, meta){
                        var array = '';
                        switch (full.numero_pedido) {
                            case '1':
                                array = '<label style="background-color red">'+full.numero_pedido+'</label>';
                                break;
                        
                            default:
                                break;
                        }
                    }
                },*/
            </script>
        </div>
    </div>

@endsection


