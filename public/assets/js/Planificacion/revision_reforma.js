
$( function () {

    $('.single-select').select2({
        width: '100%',
    });

    actualizarTotales();

});

function agregarComentarioReforma() {

    let id_reforma = $('#id_reforma').val();
    let estadoReforma = $('#estadoReforma').val();
    let justificacion_Reforma = $('#justificacion_Reforma').val();

    if (estadoReforma == '0') {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar el estado de la reforma',
            showConfirmButton: true,
        });
    } else if (justificacion_Reforma == '') {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'CoreInspi',
            text: 'Debe justificar su selección con un comentario',
            showConfirmButton: true,
        });
    } else {
        $.ajax({
            type: 'POST',
            url: '/planificacion/agregarComentarioReforma',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_reforma: id_reforma,
                justificacion_Reforma: justificacion_Reforma,
                estadoReforma: estadoReforma,
            },
            
            success: function(response) {
                if (response.data) {
                    if (response.data == true) {

                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'CoreInspi',
                            text: 'Se ha revisado la reforma',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '/planificacion/reformaPrincipal'; // Redirigir a la página deseada
                            }
                        });

                    }
                }
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'CoreInspi',
                    type: 'error',
                    text: error,
                    showConfirmButton: true,
                });
            }
        });
    }
}




function actualizarTotales() {
    let totalAumenta = 0;
    let totalDisminuye = 0;

    // Seleccionar solo las filas visibles
    $('#tblActividades tbody tr:visible').each(function() {
        let $fila = $(this);
        let tipo = $fila.find('select[name="tipo[]"]').val();
        let totalFila = 0;

        // Sumar valores de los meses
        $fila.find('input[name^="total_R"]').each(function() {
            let valor = parseFloat($(this).val()) || 0;
            totalFila += valor;
        });

        // Sumar al total correspondiente solo si la fila está visible
        if (tipo === 'AUMENTA') {
            totalAumenta += totalFila;
        } else if (tipo === 'DISMINUYE') {
            totalDisminuye += totalFila;
        }
    });

    // Actualizar los totales en los inputs
    $('#aumTotal').val(totalAumenta);
    $('#disTotal').val(totalDisminuye);
}
