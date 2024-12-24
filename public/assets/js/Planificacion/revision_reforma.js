
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
