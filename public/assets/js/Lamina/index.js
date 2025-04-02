$(function () {
    $('.basic-single').select2({ width: '100%' });

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
});
