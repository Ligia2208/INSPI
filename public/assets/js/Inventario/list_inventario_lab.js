
$( function () {

    $('.js-example-basic-single').select2({
        width: '100%',
        //dropdownParent: $('#addReportInventario .modal-body')
    });

    $('#tblIArticuloIndex').DataTable({
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/laboratorio', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre',      name: 'nombre' },
            //{ data: 'precio',      name: 'precio' },
            { data: 'categoria',   name: 'categoria' },
            { data: 'unidad',      name: 'unidad' },
            { //data: 'stock',       name: 'stock' 

                data: null,
                searchable: false,
                render: function (data, type, full, meta) {
                    var array = "";
                
                    let stock = full.stock;
                    let cant_minima = full.cant_minima;
                
                    // Aplicar el color según el valor de stock
                    if (stock <= cant_minima) {
                        array = `<span class="badge text-danger">${stock} <i class="bi bi-exclamation-diamond-fill ms-2 parpadeo text-danger"></i></span>`;
                    } else if (stock <= 2 * cant_minima) {
                        array = `<span class="badge text-warning">${stock} <i class="bi bi-exclamation-circle-fill ms-2 parpadeo text-warning"></i></span>`;
                    } else if (stock >= 3 * cant_minima) {
                        array = `<span class="badge text-success">${stock}</span>`;
                    }
                
                    return array;
                }

            },
            { data: 'cant_minima', name: 'cant_minima' },
            { //data: 'f_caduca',    name: 'f_caduca' 
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                const fecha = new Date(full.f_caduca);

                // Obtener la fecha actual
                const fechaActual = new Date();
        
                // Calcular la diferencia en meses
                const diferenciaMeses = (fecha.getFullYear() - fechaActual.getFullYear()) * 12 + (fecha.getMonth() - fechaActual.getMonth());
        
                // Aplicar el color según la proximidad de la fecha
                if (diferenciaMeses <= 1) {
                    array = `<span class="badge text-danger">${full.f_caduca} <i class="bi bi-exclamation-diamond-fill ms-2 parpadeo text-danger"></i></span>`;
                } else if (diferenciaMeses <= 3) {
                    array = `<span class="badge text-warning">${full.f_caduca}<i class="bi bi-exclamation-circle-fill ms-2 parpadeo text-warning"></i></span>`;
                } else if (diferenciaMeses >= 4) {
                    array = `<span class="badge text-bg-success">${full.f_caduca} </span>`;
                }
                return array;
                }

            },
            { 
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                if(full.estado == 'A'){
                    
                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge bg-success">Activo</span>
                            </div>`;
                }else if(full.estado == 'C'){

                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge bg-warning">Caducado</span>
                            </div>`;

                }else{

                    array = `<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                <span class="badge bg-danger">Eliminado</span>
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
                        <!--
                        <a id="btnEditUnidad" data-id_update="${full.id}" data-nombre="${full.nombre}" title="Editar Documento de Seguimiento" class="show-tooltip" href="javascript:void(0);" data-title="Editar Registro Documento">
                            <i class="font-22 fadeIn animated bx bx-edit" ></i>
                        </a>
                        -->

                        <a id="btnPDFReactivo" data-id_articulo="${full.id}" title="PDF control de Reactivos" class="text-secondary show-tooltip" data-title="PDF control de Reactivos">
                            <i class="font-22 bi bi-filetype-pdf"></i>
                        </a>

                        <a id="btnKardexReactivo" data-id_articulo="${full.id}" title="PDF Kardex de Reactivo" class="text-secondary show-tooltip" data-title="PDF Kardex de Reactivo">
                            <i class="font-22 bi bi-file-earmark-pdf"></i>
                        </a>

                        <!--
                        <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Seguimiento" class="red show-tooltip" href="javascript:void(0);"  data-title="Eliminar Registro Documento">
                        <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
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


    var table = $('#tblIArticuloIndex').DataTable();


    /* CARGAR MODAL PDF REACTIVO */
    $(document).on('click', '#btnPDFReactivo', function(){

        let id_articulo = $(this).data('id_articulo');

        $('#id_articulo').val(id_articulo);
        document.getElementById('btnModalReport').click();
        
    });
    /* CARGAR MODAL PDF REACTIVO */


    /* CARGAR MODAL PDF REACTIVO USANDO KARDEX */
    $(document).on('click', '#btnKardexReactivo', function(){

        let id_articulo = $(this).data('id_articulo');

        $('#id_articuloKardex').val(id_articulo);
        document.getElementById('btnModalReportkARDEX').click();
        
    });
    /* CARGAR MODAL PDF REACTIVO USANDO KARDEX */



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
                url: '/inventario/reportReactivo?fInicio=' + fInicio +
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
                    a.download = 'pdfreactivos_invent.pdf';  // Filename for the download
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    //window.open(response.pdf_url, '_blank');
                },
                error: function(error) {
                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:   error,
                        showConfirmButton: true,
                    });
                }
            });   
            
        }
    });
    /* GENERAR REPORTE REACTIVO */




    /* GENERAR REPORTE KARDEX REACTIVO */
    $(document).on('click', '#btnGenerarReportReactivoKardex', function(){

        var fInicio = $('#fInicioKardex').val();
        var fFin    = $('#fFinKardex').val();

        var id_articulo    = $('#id_articuloKardex').val();
        var id_laboratorio = $('#id_laboratorioKardex').val();
        

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
                url: '/inventario/reportReactivoKardex?fInicio=' + fInicio +
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
                    a.download = 'pdfreactivos_invent.pdf';  // Filename for the download
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    //window.open(response.pdf_url, '_blank');
                },
                error: function(error) {
                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:   error,
                        showConfirmButton: true,
                    });
                }
            });   
            
        }
    });
    /* GENERAR REPORTE KARDEX REACTIVO */






    /* GENERAR REPORTE INVENTARIO */
    $(document).on('click', '#btnGenerarReportInvent', function(){

        var fCategoria   = $('#fCategoria').val();
        var fLaboratorio = $('#fLaboratorio').val();

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
            var fLaboratorioStr = Array.isArray(fLaboratorio) ? fLaboratorio.join(',') : '';
    
            $.ajax({
                type: 'GET',
                url: '/inventario/reportInventario',
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




    $('#filterForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "/inventario/filtrar",
            method: 'GET',
            data: $(this).serialize(),
            success: function (data) {
                var tbody = $('#resultsTable tbody');
                tbody.empty(); // Clear existing rows

                if (data.length > 0) {
                    $.each(data, function (index, articulo) {
                        var row = '<tr>' +
                            '<td>' + articulo.id + '</td>' +
                            '<td>' + articulo.nombre + '</td>' +
                            '<td>' + articulo.lote + '</td>' +
                            '<td>' + articulo.categoria + '</td>' +
                            '<td>' + articulo.abreviatura +'('+ articulo.unidad + ')'+'</td>' +
                            '<td>' + articulo.stock + '</td>' +
                            '<td>' + articulo.f_caduca + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                } else {
                    tbody.append('<tr><td colspan="6" class="text-center">No se encontraron resultados.</td></tr>');
                }
            },
            error: function (xhr, status, error) {
                alert('Ocurrió un error: ' + error);
            }
        });
    });



    $('#generarReporte').on('click', function (e) {
    //$(document).on('click', '#btnGenerarReportReactivo', function(){

        e.preventDefault();

        var formData = $('#filterForm').serialize();
        //console.log(formData);

        $.ajax({
            url: "/inventario/filtrarReporte",
            method: 'GET',
            data: formData,
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
        

    });



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
                console.error(xhr.responseText);
            }
        });

    }

}


