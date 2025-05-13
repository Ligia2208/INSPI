$(function(){
    //populateYearSelect(2020);
    $('.basic-single').select2({
        width: '100%',
    });

    //populateYearSelect(2023);

    // Generar el reporte PDF
    $(document).on('click', '#btnGenerarPDFResultados', function() {

        /*
        var elaboraSelect = $('#elabora').val();
        var revisaSelect  = $('#revisa').val();
        var apruebaSelect = $('#aprueba').val();
        var cargo_elabora = $('#cargo_elabora').val();
        var cargo_revisa  = $('#cargo_revisa').val();
        var cargo_aprueba = $('#cargo_aprueba').val();

        var filterAnio         = $('#filterAnio').val();
        var filterItem         = $('#filterItem').val();
        var filterSubActividad = $('#filterSubActividad').val();

        var id_direccion  = $('#id_direccion').val();


        if (elaboraSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (revisaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (apruebaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_elabora == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_revisa == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_aprueba == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else {

        */
            $.ajax({
                type: 'GET',
                url: '/laminas/reporteResultadosCompleto',
                data: {

                    /*
                    elabora:       elaboraSelect,
                    revisa:        revisaSelect,
                    aprueba:       apruebaSelect,
                    cargo_elabora: cargo_elabora,
                    cargo_revisa:  cargo_revisa,
                    cargo_aprueba: cargo_aprueba,
                    id_direccion:  id_direccion,

                    filterAnio:    filterAnio,        
                    filterItem:    filterItem,        
                    filterSubActividad, filterSubActividad,
                    */
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_laminas_completo_' + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    //$('#addReportDetalle').modal('hide');
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'CoreInspi',
                        text: 'Error al generar el PDF',
                        showConfirmButton: true,
                    });
                }
            });
        /*}*/
    });

})

//==========================================VISTA DETALLE USER================================================

//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    var table = $('#tblPlanificacionIndex').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        autoWidth: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/laminas_bacteriologia', // La URL que devuelve los datos en JSON
        },
        columnDefs: [
            //{ width: '400px', targets: 2 } // Ajusta el índice según la posición de "Obj. Operativo"
        ],
        
        columns: [
            
            { data: 'unicodigo',     name: 'unicodigo' },
            { data: 'instituto',     name: 'instituto' },
            { data: 'recepta',       name: 'recepta' },
            { data: 'analita',       name: 'analita' },
            { data: 'total_laminas', name: 'total_laminas' },
            { data: 'mes_recepcion', name: 'mes_recepcion' },
            { data: 'fecha_recep',   name: 'fecha_recep' },
            {
                data: null,
                render: function (data, type, full, meta) {

                    return `

                        <div class="action-buttons">

                            <a id="" class="ml-1" data-id_editar="${full.id}" href="/laminas/editar_bact/${full.id}" title="Editar Ingreso" data-title="Editar Ingreso">
                                <i class="bi bi-pen icon-ingreso"></i>
                            </a>

                            <a id="" class="ml-1" href="/laminas/visualizar_bact/${full.id}" title="Visualizar Ingreso" data-title="Visualizar Ingreso">
                                <i class="bi bi-eye icon-ingreso"></i>
                            </a>

                            <a id="btnEliminarIngreso" class="ml-1" data-id_borrar="${full.id}" title="Eliminar Ingreso" data-title="Eliminar Ingreso">
                                <i class="bi bi-trash icon-ingreso"></i>
                            </a>

                            <a id="btnPDF_calidad_bact" class="ml-1" data-id_lamina="${full.id}" title="Generar PDF Control Calidad Bact" data-title="Generar PDF Control Calidad Bact">
                                <i class="bi bi-file-earmark-pdf text-danger"></i>
                            </a>

                            <a id="btnPDF_calidad_indirecto" class="ml-1" data-id_lamina="${full.id}" title="Generar PDF Control Calidad Indirecto" data-title="Generar PDF Control Calidad Indirecto">
                                <i class="bi bi-file-earmark-pdf text-dark"></i>
                            </a>
                        </div>`;
                }
            },
        ],
        order: [
            [6, 'desc']
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

    var table = $('#tblPlanificacionIndex').DataTable();

    //ELIMINAR INGRESO DE LAMINAS
    $(document).on('click', '#btnEliminarIngreso', function(){

        let id_ingreso = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: '¿Seguro que quiere eliminar este Ingreso?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/laminas/eliminar_bact',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_ingreso,
                    },
                    success: function(response) {

                        //console.log(response.data['id_chat'])
                        if(response.data){

                            if(response['data'] == true){
                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                }).then((result) => {
                                    table.ajax.reload(); 
                                });

                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                });
                            }
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon:  'success',
                            title: 'CoreInspi',
                            type:  'success',
                            text:   error,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });
    });


    //ELIMINAR DESGLOSE DE LAMINAS
    $(document).on('click', '#btnEliminarDesglose', function(){

        let id_ingreso = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: '¿Seguro que quiere eliminar este Desglose?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/laminas/eliminar_desglose',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_ingreso,
                    },
                    success: function(response) {

                        //console.log(response.data['id_chat'])
                        if(response.data){

                            if(response['data'] == true){
                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                }).then((result) => {
                                    table.ajax.reload(); 
                                });

                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                });
                            }
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon:  'success',
                            title: 'CoreInspi',
                            type:  'success',
                            text:   error,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });
    });

});

//==========================================FIN VISTA DETALLE USER================================================






    // Generar el reporte PDF
    $(document).on('click', '#btnPDF_calidad', function() {

        var id_lamina = $(this).data('id_lamina');
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte_control_calidad',
            data: {
                id_lamina:       id_lamina,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, _status, _xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_laminas_completo_' + '.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
                //$('#addReportDetalle').modal('hide');
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    type: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el PDF',
                    showConfirmButton: true,
                });
            }
        });
        
    });

    // Generar el reporte PDF PAR
    $(document).on('click', '#btnPDF_calidad_bact', function() {
        var id = $(this).data('id_lamina');  // Obtiene el ID del botón

        $.ajax({
            type: 'GET',
            url: '/laminas/reporte_control_calidad_par/' + id,  // La URL de la acción que genera el PDF
            xhrFields: {
                responseType: 'blob'  // Indica que la respuesta será un archivo binario (PDF)
            },
            success: function(response) {
                // Crear un Blob con la respuesta (el archivo PDF)
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);  // Crear una URL de objeto para el Blob

                // Crear un enlace para la descarga del archivo
                var a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_control_calidad_par_' + id + '.pdf';  // Nombre del archivo a descargar
                document.body.appendChild(a);  // Añadir el enlace al DOM
                a.click();  // Simular un clic en el enlace para descargar el archivo

                // Liberar la URL creada para el Blob
                window.URL.revokeObjectURL(url);
                a.remove();  // Eliminar el enlace del DOM
            },
            error: function() {
                // Mostrar un mensaje de error si la solicitud falla
                Swal.fire({
                    icon: 'error',
                    type: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el PDF',
                    showConfirmButton: true,
                });
            }
        });
    });


    // Generar el reporte PDF CONTROL_CALIDAD INDIRECTO
    $(document).on('click', '#btnPDF_calidad_indirecto', function() {
        var id_lamina = $(this).data('id_lamina');  
        
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte_control_calidad_indirecto/' + id_lamina,  
            xhrFields: {
                responseType: 'blob'  
            },
            success: function(response, _status, _xhr) {

                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;

                a.download = 'reporte_control_calidad_indirecto_' + id_lamina + '.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
            },
            error: function(_error) {
                Swal.fire({
                    icon: 'error',
                    type: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el PDF',
                    showConfirmButton: true,
                });
            }
        });
    });

    
    $(document).on('click', '#btnPDF_ingreso', function() {

        var id_lamina = $(this).data ('id_editar');
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte_ingreso',
            data: {
                id_lamina:       id_lamina,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, _status, _xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'ingreso de laminas' + '.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    type: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el PDF',
                    showConfirmButton: true,
                });
            }
        });
        
    });


    $(document).on('click', '#btnPDF_desglose', function() {

        var id_lamina = $(this).data ('id_editar');
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte_desglose',
            data: {
                id_lamina:       id_lamina,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, _status, _xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'desglose de lamina' + '.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    type: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el PDF',
                    showConfirmButton: true,
                });
            }
        });
        
    });