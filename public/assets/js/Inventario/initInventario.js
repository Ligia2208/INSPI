
$( function () {

    $('.js-example-basic-single').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
        //dropdownParent: $('#addReportInventario .modal-body')
    });

    $('#tblInventarioIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'id',       name: 'id' },
            { data: 'articulo', name: 'articulo' },
            { data: 'lote',     name: 'lote' },
            { data: 'f_caduca', name: 'f_caduca' },
            { data: 'cantidad', name: 'cantidad'},
            { data: 'laboratorio', name: 'laboratorio'},
            { data: 'estado',   name: 'estado' }, 
            { data: 'fecha',    name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                        
                        <a id="btnPDFInv" data-id_articulo="${full.id}" data-id_inventario="${full.id_inv}" title="PDF control de Inventario" class="text-secondary show-tooltip" data-title="PDF control de Inventario">
                            <i class="font-22 bi bi-filetype-pdf"></i>
                        </a>
                    
                        <!--
                        <a id="btnNotifica" data-id="'+full.id+'" title="Revisar Encuestas" class="red show-tooltip" href="javascript:void(0);"  data-title="Revisar Encuestas">
                            <i class="font-22 bx bx-envelope"></i>
                        </a>
                        <a id="btnFinalizar2" data-id="'+full.id+'" type="button" title="Ir a evento" class="red show-tooltip" data-toggle="modal" data-target="#miModal" data-title="Ir a evento">
                            <i class="font-22 fadeIn animated bx bx-check-square text-warning"></i>
                        </a>
                        -->

                    </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [7, 'desc']
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


    var table = $('#tblInventarioIndex').DataTable();


//modalContent
    /*
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
    */

    

    /*
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
    */
//===============================================PDF INVENTARIO=====================================================

    /* CARGAR MODAL PDF REACTIVO */
    $(document).on('click', '#btnPDFInv', function(){

        let id_articulo = $(this).data('id_articulo');
        let id_inventario = $(this).data('id_inventario');


        $('#id_articulo').val(id_articulo);
        $('#id_inventario').val(id_inventario);

        document.getElementById('btnModalReport').click();
    });
    /* CARGAR MODAL PDF REACTIVO */




    /* GENERAR REPORTE REACTIVO */
    $(document).on('click', '#btnGenerarReportReactivo', function(){

        var fInicio = $('#fInicioMono').val();
        var fFin    = $('#fFinMono').val();

        var id_articulo    = $('#id_articulo').val();
        var id_laboratorio = $('#id_laboratorio').val();
        let id_inventario = $('#id_inventario').val();

        

        if(fInicio === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha de inicio',
                showConfirmButton: true,
            });

        }else if(fFin === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha fin',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'GET',
                url: '/inventario/kardexInventario?fInicio=' + fInicio +
                        '&fFin=' + fFin +
                        '&id_laboratorio=' + id_laboratorio +
                        '&id_articulo=' + id_articulo +
                        '&id_inventario=' + id_inventario
                         ,
                xhrFields: {
                    responseType: 'blob'  
                },
                success: function(response, status, xhr) {

                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'pdf_Kardex_inventario.pdf';  // Filename for the download
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    //window.open(response.pdf_url, '_blank');
                },
                error: function(error) {
                    var response = error.responseJSON;                
                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:   response.message,
                        showConfirmButton: true,
                    });
                }
            });   
            
        }
    });

//==============================================PDF INVENTARIO=====================================================

    /* GENERAR REPORTE INVENTARIO */
    $(document).on('click', '#btnGenerarReportInvent', function() {

        var fCategoria   = $('#fCategoria').val();
        var fLaboratorio = $('#fLaboratorio').val();
    
        var fInicio = $('#fInicioR').val();
        var fFin    = $('#fFinR').val();
    
        var id_laboratorio = $('#id_laboratorio').val();
    
        if(fInicio === '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha de inicio',
                showConfirmButton: true,
            });
        } else if(fFin === '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha fin',
                showConfirmButton: true,
            });
        } else {
            // Convertir arrays en cadenas separadas por comas
            var fCategoriaStr = Array.isArray(fCategoria) ? fCategoria.join(',') : '';
            var fLaboratorioStr = Array.isArray(fLaboratorio) ? fLaboratorio.join(',') : '';
    
            $.ajax({
                type: 'GET',
                url: '/inventario/reportInventarioGeneral',
                data: {
                    fInicio: fInicio,
                    fFin: fFin,
                    id_laboratorio: id_laboratorio,
                    fCategoria: fCategoriaStr,
                    fLaboratorio: fLaboratorioStr
                },
                xhrFields: {
                    responseType: 'blob'  
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'pdfreactivos_invent.pdf';  // Filename for the download
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                },
                error: function(error) {
                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        text: 'Error al generar el reporte',
                        showConfirmButton: true,
                    });
                }
            });
        }
    });
    /* GENERAR REPORTE INVENTARIO */



    /* GENERAR REPORTE INVENTARIO - STOCK */
    $(document).on('click', '#btnGenerarReportStock', function(){

        var rFiltro = $('#rFiltro').val();

        var id_laboratorio = $('#id_laboratorio').val();

        $.ajax({
            type: 'GET',
            url: '/inventario/reportInventarioStockGeneral',
            data: {
                id_laboratorio: id_laboratorio,
                rFiltro:  rFiltro,
            },
            xhrFields: {
                responseType: 'blob'  
            },
            success: function(response, status, xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'pdf_stock_inventario_general.pdf';  // Filename for the download
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   'Error al generar el reporte - '+response.message,
                    showConfirmButton: true,
                });

            }
        });          

    });
    /* GENERAR REPORTE INVENTARIO - STOCK */


});