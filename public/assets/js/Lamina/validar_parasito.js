$(function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.single-select').select2({
        width: '100%',
    });

    $('#total_laminas').on('input', function() {
        ajustarFilasPorTotal();
    });
    

    
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */
    $(document).on('click', '#btnGuardarSolicitud', function () {

        let id_ingreso   = $('#id_ingreso').val();

        Swal.fire({
            icon: 'warning',
            title: 'CoreInspi',
            text: '¿Desea Validar estas láminas?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {

                let id_resultado = $('#id_resultado').val();
                let observacion  = $('#observacion').val();
        
                if (id_resultado == '') {
                    Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe seleccionar un Resultado.', showConfirmButton: true });
                } else if (!observacion) {
                    Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar una observación.', showConfirmButton: true });
                } else {

                    // Si todo es válido
                    $.ajax({
                        type: 'POST',
                        url: '/laminas/guardar_laminas_validacion',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: {
                            'id_ingreso'          :id_ingreso,
                            'id_resultado'        :id_resultado,  
                            'observacion'         :observacion,  
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: response.success ? 'success' : 'error',
                                title: 'CoreInspi',
                                text: response.message,
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    window.location.href = "/laminas_parasitologia_validar";
                                }
                            });
                        },

                        error: function (error) {
                            var response = error.responseJSON;
                            Swal.fire({
                                icon: 'error',
                                title: 'CoreInspi',
                                text: response.message,
                                showConfirmButton: true,
                            });
                        }
                    });

                }

            }
        });

    });
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */


});

