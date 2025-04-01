$(function(){

    $('.basic-single').select2({
        width: '100%',
    });


    $(document).on('click', '#btnGenerarPDF', function () {
        let id             = $('#id_lamina').val(); 
        let fechaRecepcion = $('#fecha_recep').val();
        let totalLaminas   = $('#total_laminas').val();
        let responsable    = $('#responsable').val();
        let analista       = $('#analista').val();
        let nombreLab      = $('#centro_salud option:selected').text(); // si es select
        let procedencia    = $('#procedencia').val() || '---'; // opcional
        let mesSupervisado = $('#mes_recepcion').val();
        let observaciones  = $('#Observaciones').val();
        let realizadoPor   = $('#analista option:selected').text(); 
    
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte',
            data: {
                id: id,
                fechaRecepcion: fechaRecepcion,
                totalLaminas: totalLaminas,
                responsable: responsable,
                analista: analista,
                nombreLaboratorio: nombreLab,
                procedencia: procedencia,
                mesSupervisado: mesSupervisado,
                observaciones: observaciones,
                realizadoPor: realizadoPor,
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