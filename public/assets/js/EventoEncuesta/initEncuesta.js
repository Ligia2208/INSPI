
$( function () {

    //alert("Funciona");


    $('#tblGEncuestaIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/encuestas', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre',         name: 'nombre' },
            { data: 'laboratorio_id', name: 'laboratorio_id' },
            { data: 'anio',           name: 'anio'},
            { data: 'periodo',        name: 'periodo' },
            { data: 'estado',         name: 'estado' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =
                    '<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">'

                    + '<a id="btnLink" data-id="'+full.id+'" title="Link de Encuestas" data-toggle="modal" data-target="#modalLinkEncuesta" class="red show-tooltip" data-title="Link de Encuestas">' 
                    + '<i class="font-22 bi bi-link-45deg text-secondary"></i>'
                    + '</a>'

                    + '<a id="btnNotifica" data-id="'+full.id+'" title="Notificar el Evento" class="red show-tooltip" data-title="Notificar el Evento">'
                    + '<i class="font-22 bi bi-bell"></i>'
                    + '</a>'

                    + '<a id="btnFinalizar2" data-id="'+full.id+'" type="button" title="Ir a evento" class="red show-tooltip" data-toggle="modal" data-target="#miModal" data-title="Ir a evento">'
                    + '<i class="bi bi-clipboard-data font-22 text-warning"></i>'
                    + '</a>';

                    + '</div>';

                return array;

                }
            },
        ],
        order: [
            [3, 'desc']
        ],

        // Otras configuraciones de DataTables aquí
        language: {
            "emptyTable": "No hay información", //no hay datos disponibles
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior",
                            "showing": "Mostrando"
                        }
        },
    });


    var table = $('#tblGDocumento').DataTable();

    /* FILTROS PARA BUSCAR SEGUIMIENTO */
    $('#nombreB, #tipoB, #fechaB, #estadoB, #departamentosB').on('change', function() {
        filtrar();
    });

    function filtrar(){
        // Obtener valores de los filtros
        var nombre  = $('#nombreB').val();
        var tipo    = $('#tipoB').val();
        var fechaB  = $('#fechaB').val();
        var estadoB = $('#estadoB').val();
        var departamentosB = $('#departamentosB').val();

        table.ajax.url('/gestion_documental?nombre=' + nombre + '&tipo=' + tipo+ '&fecha=' + fechaB+'&estado=' + estadoB+'&area=' + departamentosB).load();
    }
    /* FILTROS PARA BUSCAR SEGUIMIENTO */


    /* ELIMINAR SEGUIMIENTO */
    $(document).on('click', '#btnDeleteSeg', function(){


        Swal.fire({
            title: 'SoftInspi',
            text: 'Seguro que quieres eliminar este seguimiento?.',
            icon: 'warning',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((resultado) => {
            if (resultado.value) {

                var id_documento = $(this).data('id_documento');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/eliminarSeguimiento/'+id_documento,//PONER URL ELIMINAR
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
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
                        //console.log(res);
                        Swal.fire({
                            title: 'SoftInspi',
                            text: res.message,
                            icon: 'success',
                            type: 'success',
                            confirmButtonText: 'Aceptar',
                            timer: 3500
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '/gestion_documental';
                            }
                        });

                    }

                });
            }
        });

    });
    /* ELIMINAR SEGUIMIENTO */



    $(document).on('click', '#btnEditDocumento', function(){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: 'gestion_documental/edit/'+$(this).data('id_documento'),
            data: {
                _token: "{{ csrf_token() }}",
                'id_documento': $(this).data('id_documento'),
            },
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

            var modalCrearCatalogo = bootbox.dialog({
                title: '<span> <i class="font-22 fadeIn animated bx bx-edit text-success"></i> Editar Documento </span>',
                message: res,
                className: "large",
                size: 'xs',
                show: false,

                buttons: {

                    submit:{
                        label: '<span class="lni lni-save"></span> Guardar',
                        className: "submit btnGuardar btn btn-primary btn-shadow font-weight-bold mr-2",
                        callback: function(){
                            var form = modalCrearCatalogo.find("#frmEditDocumento");
                            var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });

                            if($(form).valid()){

                                $.post(form[0].action, datos).done(function(request){
                                    modalCrearCatalogo.modal('hide');

                                    var oTable = $('#tblCatalogo').dataTable();
                                    oTable.fnDraw(false);

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'SoftInspi',
                                        type: 'success',
                                        text: 'El documento ha sido editado correctamente.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                  //  $('#datatable-crud').ajax.reload();
                                    table.ajax.reload();


                                })
                            }
                            return false;
                        }
                    },

                    cancel: {
                        label: '<span class="lni lni-close"></span> Cerrar',
                        className: "btn btn-danger btn-shadow font-weight-bold mr-2",
                        callback: function(){
                            modalCrearCatalogo.modal('hide');
                        }//fin callback
                    }//fin cancelar
                },
                onEscape: function () {
                    modalCrearCatalogo.modal("hide");
                },
                backdrop: "static",

            }).on('shown.bs.modal', function (e) {
                $('body').waitMe('hide');
                modalCrearCatalogo.attr("id", "modal-wizard-datatables");
                modalCrearCatalogo.css({ "overflow-y": "scroll" });

            });//fin modal
            // modalEditCatalogo.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
            modalCrearCatalogo.find(".modal-header").addClass("modal-header-info");
            modalCrearCatalogo.find(".btnGuardar, .btnCancelar").css({"border-radius": "10px"});
            modalCrearCatalogo.modal('show');

            }//fin success

        });

    })


});



//modalContent
    $(document).on('click', '#btnFinalizar2', function(){
        //alert('funciona');

        let id_evento = $(this).data('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/laboratoriosTipo/'+id_evento,//PONER URL ELIMINAR
            data: {
                _token: "{{ csrf_token() }}",
            },
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

                $('#modalContent').text('');

                console.log(res);

                if (res.hasOwnProperty('laboratorios')) {
                    // Obtener la lista de laboratorios
                    var laboratorios = res.laboratorios;
        
                    // Iterar sobre la lista de laboratorios
                    for (var laboratorio of laboratorios) {
                        // Acceder a las propiedades de cada laboratorio
                        var tipoencuesta_id = laboratorio.tipoencuesta_id;
                        var nombre          = laboratorio.nombre;
                        var valor           = laboratorio.valor;
                        var id              = laboratorio.id;
                        var tipo            = laboratorio.tipo;
                        var id_evento       = laboratorio.id_evento;
        
                        // Hacer lo que necesites con cada laboratorio
                        console.log('Tipo Encuesta ID:', tipoencuesta_id);
                        console.log('Nombre:', nombre);
                        console.log('Valor:', valor);
                        console.log('ID:', id);
                        console.log('Tipo:', tipo);
                        //id_evento

                        $('#modalContent').append(`
                        <div class="row mt-1 d-flex justify-content-center align-items-center">
        
                            <a class="col-5 btn btn-primary mx-1 mt-2 d-flex justify-content-center align-items-center" href="/encuestas/usuEncuesta?tipoencu_id=${id}&id_evento=${id_evento}" type="button">
                                <i class="lni lni-circle-plus"></i> ${nombre}
                            </a>
        
                        </div>
                        `);

                    }
                } else {

                    //no existe

                }

            }

        });

    });

    

    $(document).on('click', '#btnNotifica', function(){
        //alert('funciona');

        let id_evento = $(this).data('id');


        //swet alert

        Swal.fire({
            title: 'SoftInspi',
            text: 'Seguro que quieres notificar el evento?.',
            icon: 'warning',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/eventoCorreo/'+id_evento,//PONER URL ELIMINAR
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
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

                        if(res.data){

                            Swal.fire({
                                icon: 'success',
                                title: 'SoftInspi',
                                type: 'success',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }else{

                            Swal.fire({
                                icon: 'error',
                                title: 'SoftInspi',
                                type: 'error',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }

                    }

                });
        

            }
        });


    });



    $(document).on('click', '#btnLink', function(){
        //alert('funciona');

        let id_evento = $(this).data('id');
                
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/obtenerLink/'+id_evento,//PONER URL ELIMINAR
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function () {
                $('body').waitMe({
                    effect: 'roundBounce', //'roundBounce',//'bounce','win8','orbit','ios','win8_linear'
                    text: 'Por favor espere...', //'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#A52A2A'
                });
            },
            success: function(res) {
                console.log(res);
            
                var datos = res.links;
            
                if (res.data) {
                    // Limpiar el contenido del modal antes de agregar nuevos enlaces
                    $('#modalContentLink').empty();
            
                    // Recorrer cada enlace y agregarlo al modal
                    datos.forEach(function(link) {
                        $('#modalContentLink').append(`
                            <div class="col-md-12 mt-3">
                                <label for="link_acceso" class="form-label">Link de Acceso: ${link.nombre}</label>
                                <input type="text" class="form-control" value="${link.url}" required="" placeholder="Ingrese el Link">
                                <button class="btn btn-primary mt-2 copiar-link" data-url="${link.url}">Copiar</button>
                            </div>
                        `);
                    });
            
                    // Agregar evento de clic para copiar el enlace
                    $('.copiar-link').on('click', function() {
                        const url = $(this).data('url');
                        navigator.clipboard.writeText(url).then(function() {

                            Swal.fire({
                                title: 'SoftInspi',
                                text: 'Enlace copiado al portapapeles',
                                icon: 'success',
                                type: 'success',
                                confirmButtonText: 'Aceptar',
                                timer: 1500
                            });

                        }, function(err) {

                            Swal.fire({
                                title: 'SoftInspi',
                                text: 'Error al copiar el enlace: ', err,
                                icon: 'error',
                                type: 'error',
                                confirmButtonText: 'Aceptar',
                                timer: 1500
                            });
                        });
                    });

                }
            }

        });
        


    });


