$(function(){
    //populateYearSelect(2020);
    $('.basic-single').select2({
        width: '100%',
    });

    populateYearSelect(2023);




    $(document).on('click', '#btnGeneratePDF', function() {
        document.getElementById('btnModalReportPOA').click();
    });

    // Cerrar el modal y limpiar los campos
    $(document).on('click', '#btnCerrarModalPOA', function() {
        $('#addReportDetalle').modal('hide');

        // Limpiar los campos del formulario
        $('#elabora').val('');
        $('#revisa').val('');
        $('#aprueba').val('');
        $('#cargo_elabora').val('');
        $('#cargo_revisa').val('');
        $('#cargo_aprueba').val('');
    });

    // Generar el reporte PDF
    $(document).on('click', '#btnGenerarReportPOA', function() {
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
            $.ajax({
                type: 'GET',
                url: '/planificacion/reportDetalleUser',
                data: {
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
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_anual_' + filterAnio + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    $('#addReportDetalle').modal('hide');
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
        }
    });



    $(document).on('click', '#.', function () {
        let id               = $('#id_lamina').val();
        let fechaRecepcion   = $('#fecha_recep').val();
        let totalLaminas     = $('#total_laminas').val();
        let responsable      = $('#responsable option:selected').text();
        let analista         = $('#analista option:selected').text();
        let nombreLaboratorio = $('#centro_salud option:selected').text();
        let procedencia      = $('#procedencia').val() || '---';
        let mesSupervisado   = $('#mes_recepcion').val();
        let observaciones    = $('#Observaciones').val();
        let realizadoPor     = $('#analista option:selected').text();

        let laminas_empacadas       = $('input[name="laminas_empacadas"]:checked').val();
        let laminas_legibles        = $('input[name="laminas_legibles"]:checked').val();
        let laminas_sin_id          = $('input[name="laminas_sin_id"]:checked').val();
        let laminas_sin_aceite      = $('input[name="laminas_sin_aceite"]:checked').val();
        let laminas_frotis_adecuado = $('input[name="laminas_frotis_adecuado"]:checked').val();
        let laminas_integras        = $('input[name="laminas_integras"]:checked').val();
        let laminas_documentacion   = $('input[name="laminas_documentacion"]:checked').val();

        $.ajax({
            type: 'GET',
            url: '/laminas/reporte',
            data: {
                id,
                fechaRecepcion,
                totalLaminas,
                responsable,
                analista,
                nombreLaboratorio,
                procedencia,
                mesSupervisado,
                observaciones,
                realizadoPor,
                laminas_empacadas,
                laminas_legibles,
                laminas_sin_id,
                laminas_sin_aceite,
                laminas_frotis_adecuado,
                laminas_integras,
                laminas_documentacion
            },
            xhrFields: { responseType: 'blob' },
            success: function (response) {
                const blob = new Blob([response], { type: 'application/pdf' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_laminas.pdf';
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar el PDF',
                });
            }
        });
    });




})









































//==========================================VISTA DETALLE USER================================================

//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionIndex').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        autoWidth: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/laminas', // La URL que devuelve los datos en JSON
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
                            <a id="btnPDF_ingreso" class="ml-1" data-id_editar="${full.id}" href="javascript:void(0);" title="PDF Ingreso de Láminas" data-title="PDF Ingreso de Láminas">
                                <i class="bi bi-file-pdf"></i>
                            </a>

                            <a id="btnAdd_laminas" class="ml-1" data-id_editar="${full.id}" href="/laminas/agregar_laminas/${full.id}" title="Desglose de Láminas" data-title="Desglose de Láminas">
                                <i class="bi bi-list-ul"></i>
                            </a>

                            <a id="btnAdd_control" class="ml-1" data-id_editar="${full.id}" href="/laminas/control_calidad/${full.id}" title="Control de Láminas" data-title="Control de Láminas">
                                <i class="bi bi-clipboard-check"></i>
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



});

//==========================================FIN VISTA DETALLE USER================================================


