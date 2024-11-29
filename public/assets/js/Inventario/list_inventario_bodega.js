
$( function () {

    $('.js-example-basic-single').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
        dropdownParent: $('#addReportInventario .modal-body')
    });

    $('#rFiltro').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
        dropdownParent: $('#addReportStock .modal-body')
    });

    $('#tblIArticuloIndex').DataTable({
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/bodega', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre',      name: 'nombre' },
            //{ data: 'precio',      name: 'precio' },
            { data: 'categoria',   name: 'categoria' },
            { data: 'unidad',      name: 'unidad' },
            { data: 'stock',       name: 'stock' },
            { data: 'cant_minima', name: 'cant_minima' },
            { data: 'f_caduca',    name: 'f_caduca' },
            { 
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                if(full.estado == 'A'){
                    
                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge text-bg-success">Activo</span>
                            </div>`;
                }else if(full.estado == 'C'){

                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge text-bg-warning">Caducado</span>
                            </div>`;

                }else{

                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge text-bg-danger">Eliminado</span>
                            </div>`;

                }

                return array;

                }

            },
            { data: 'fecha',       name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                array = `
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                        <a id="btnPDFReactivo" data-id_articulo="${full.id}" title="PDF Kardex por artículo" class="text-secondary show-tooltip" data-title="PDF Kardex por artículo">
                            <i class="font-22 bi bi-filetype-pdf"></i>
                        </a>

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


    var table = $('#tblIArticuloIndex').DataTable();


    /* CARGAR MODAL PDF REACTIVO */
    $(document).on('click', '#btnPDFReactivo', function(){

        let id_articulo = $(this).data('id_articulo');

        $('#id_articulo').val(id_articulo);
        document.getElementById('btnModalReport').click();
        
    });
    /* CARGAR MODAL PDF REACTIVO */



    /* GENERAR REPORTE REACTIVO */
    $(document).on('click', '#btnGenerarReportReactivo', function(){

        var fInicio = $('#fInicioMono').val();
        var fFin    = $('#fFinMono').val();

        var id_articulo    = $('#id_articulo').val();
        var id_laboratorio = $('#id_laboratorio').val();
        

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
                url: '/inventario/reportBodegaInvetario?fInicio=' + fInicio +
                        '&fFin=' + fFin +
                        '&id_laboratorio=' + id_laboratorio +
                        '&id_articulo=' + id_articulo,
                xhrFields: {
                    responseType: 'blob'  
                },
                success: function(response, status, xhr) {

                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'pdf_Kardex_invent.pdf';  // Filename for the download
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
    /* GENERAR REPORTE REACTIVO */




    /* GENERAR REPORTE INVENTARIO - MOVIMIENTOS GENERAL */
    $(document).on('click', '#btnGenerarReportInvent', function(){

        var fCategoria   = $('#fCategoria').val();
        //var fLaboratorio = $('#fLaboratorio').val();

        var fInicio = $('#fInicioR').val();
        var fFin    = $('#fFinR').val();

        var id_laboratorio = $('#id_laboratorio').val();

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

            var fCategoriaStr = Array.isArray(fCategoria) ? fCategoria.join(',') : '';
            //var fLaboratorioStr = Array.isArray(fLaboratorio) ? fLaboratorio.join(',') : '';
    
            $.ajax({
                type: 'GET',
                url: '/inventario/reportMovimientoGeneral',
                data: {
                    fInicio: fInicio,
                    fFin: fFin,
                    id_laboratorio: id_laboratorio,
                    fCategoria: fCategoriaStr,
                    //fLaboratorio: fLaboratorioStr
                },
                xhrFields: {
                    responseType: 'blob'  
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'pdf_kardex_general.pdf';  // Filename for the download
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

        }
    });
    /* GENERAR REPORTE INVENTARIO - MOVIMIENTOS GENERAL */



    /* GENERAR REPORTE INVENTARIO - STOCK */
    $(document).on('click', '#btnGenerarReportStock', function(){

        var rFiltro = $('#rFiltro').val();

        var id_laboratorio = $('#id_laboratorio').val();

        $.ajax({
            type: 'GET',
            url: '/inventario/reportInventarioStock',
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
                a.download = 'pdf_stock_inventario.pdf';  // Filename for the download
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




function actualizarTabla() {

    let id_laboratorio = $('#id_labora').val();

    if(id_laboratorio !== '0'){

        $.ajax({
            url: '/inventario/laboratorio', 
            type: 'GET',
            data: { laboratorioId: id_laboratorio }, 
            success: function(data) {
                // Limpiar la tabla
                $('#tblIArticuloIndex').DataTable().clear();
                // Agregar los nuevos datos a la tabla
                $('#tblIArticuloIndex').DataTable().rows.add(data.data).draw();
            },
            error: function(xhr, status, error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:  response.message,
                    showConfirmButton: true,
                });
            }
        });

    }

}


