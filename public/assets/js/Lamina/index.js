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




})
