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

        let id_ingreso = $('#id_ingreso').val();

        if (!validarCampos()) {

        } else {
            //console.log(capturarDatos());

            var datos = capturarDatos();
            //let id_ingreso = $('#id_ingreso').val();

            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: '¿Desea guardar las laminas?',
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {

                    let fecha_recep         = document.getElementById('fecha_recep').value.trim();
                    let centro_salud        = document.getElementById('centro_salud').value.trim();
                    let evento              = document.querySelector('select[name="evento"]').value.trim();
                    let responsable         = document.getElementById('responsable').value.trim();
                    let fecha_recebcion     = document.getElementById('fecha_recebcion').value.trim();
                    let mes_recepcion       = document.getElementById('mes_recepcion').value.trim();
                    let total_laminas       = document.getElementById('total_laminas').value.trim();
                    let total_laminas_super = document.getElementById('total_laminas_super').value.trim();
                    let codigo              = document.getElementById('codigo').value.trim();
                    let codigo_lec          = document.getElementById('codigo_lec').value.trim();
                    //let fecha_inicio        = document.getElementById('fecha_inicio').value.trim();
                    //let fecha_fin           = document.getElementById('fecha_fin').value.trim();
                    let observacion         = document.getElementById('observacion').value.trim();

                    let total_laminas_pos   = document.getElementById('total_laminas_pos').value.trim();
                    let total_laminas_neg   = document.getElementById('total_laminas_neg').value.trim();
            
                    if (!fecha_recep) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha de Recepción.', showConfirmButton: true });
                    } else if (!centro_salud) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar el nombre del Laboratorio Supervisado.', showConfirmButton: true });
                    } else if (!evento) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe seleccionar un Evento.', showConfirmButton: true });
                    } else if (!responsable) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar el Responsable de Recepción.', showConfirmButton: true });
                    } else if (!fecha_recebcion) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha de Recepción de láminas.', showConfirmButton: true });
                    } else if (!mes_recepcion) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Semana o Mes de Recepción.', showConfirmButton: true });
                    } else if (!total_laminas) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar el Total de Láminas.', showConfirmButton: true });
                    } else if (!total_laminas_super) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar el Total de Láminas Recibidas.', showConfirmButton: true });
                    } else if (!codigo) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe seleccionar un Código de Microscopista.', showConfirmButton: true });
                    } else if (!codigo_lec) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe seleccionar un Código del Lector.', showConfirmButton: true });
                    }  /*else if (!fecha_inicio) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha Inicial.', showConfirmButton: true });
                    } else if (!fecha_fin) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha Final.', showConfirmButton: true });
                    }*/ else if (!observacion) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar una Observación.', showConfirmButton: true });
                    }else if (!total_laminas_pos) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar un Total de Láminas Positivas.', showConfirmButton: true });
                    }else if (!total_laminas_neg) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar una Total de Láminas Negativas.', showConfirmButton: true });
                    } else {

                        let resultados = obtenerResultados();

                        // Si todo es válido
                        $.ajax({
                            type: 'POST',
                            url: '/laminas/editar_laminas_bact',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: {
                                'datos'               :datos,
                                'id_ingreso'          :id_ingreso,
                                'fecha_recep'         :fecha_recep        ,  
                                'centro_salud'        :centro_salud       ,  
                                'evento'              :evento             ,  
                                'responsable'         :responsable        ,  
                                'fecha_recebcion'     :fecha_recebcion    ,  
                                'mes_recepcion'       :mes_recepcion      ,  
                                'total_laminas'       :total_laminas      ,  
                                'total_laminas_super' :total_laminas_super,  
                                'codigo'              :codigo             ,  
                                //'fecha_inicio'        :fecha_inicio       ,  
                                //'fecha_fin'           :fecha_fin          ,  
                                'observacion'         :observacion        ,  
                                'total_laminas_pos'   :total_laminas_pos  ,
                                'total_laminas_neg'   :total_laminas_neg  ,
                                'resultados'          :resultados,
                                'codigo_lec'          :codigo_lec,
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: response.success ? 'success' : 'error',
                                    title: 'CoreInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                }).then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        window.location.href = "/laminas_bacteriologia";
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

        }

    });
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */


    // Aplicar la función a los inputs que quieres
    const inputsNumericos = ['total_laminas', 'total_laminas_super', 'total_laminas_pos', 'total_laminas_neg'];

    inputsNumericos.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            validarSoloNumeros(input);
        }
    });
    /* PARA QUE SOLO INGRESEN NUMEROS */



});

