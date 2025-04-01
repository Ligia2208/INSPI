$( function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.js-example-basic-single').select2({
        width: '100%',
    });


    // Obtener el mes y el año actual
    let fechaActual = new Date();
    let año = fechaActual.getFullYear();
    let meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    let mes = meses[fechaActual.getMonth()]; // Obtener el mes en letras

    // Asignar el valor al input
    $("#mes_recepcion").val(`${mes} - ${año}`);




    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */
    $(document).on('click', '#btnGuardarSolicitud', function(){

        let estado       = $('#estado').val();
        let id_solicitud = $('#id_solicitud').val();

        if(estado == '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de Aprobar o Rechazar la solicitud para continuar.',
                showConfirmButton: true,
            });

        }else{

            let mensaje;
            if(estado == 'aprobado'){
                mensaje = 'La solicitud será aprobada, desea continuar?'
            }else{
                mensaje = 'La solicitud será rechazada, desea continuar?'
            }
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: mensaje,
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value == true) {
    
                    $.ajax({
    
                        type: 'POST',
                        url: '/planificacion/aproSolicitud',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'id_solicitud': id_solicitud,
                            'estado': estado,
                        },
                        success: function(response) {
    
                            if(response.data){

                                table.ajax.reload(); //actualiza la tabla
                                document.getElementById('btnSolicitud').click();         

                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });

                            }else{

                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });
                                
                            }
                        },
                        error: function(error) {
                            var response = error.responseJSON;                
                            Swal.fire({
                                icon:  'error',
                                title: 'SoftInspi',
                                type:  'error',
                                text:   response.message,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });

        }

    });
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */


    /* ==================== MODAL SOLICITAR POA ==================== */
    $(document).on('click','#btnSolicitarPOA', function(){

        let id_Poa = $(this).data('id_actividad');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/planificacion/obtenerpoa/' + id_Poa,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                //console.log(res);
                let departamento   = res.poa.departamento;
                let id_poa         = res.poa.id;
                let actividad      = res.poa.actividad;
                let subactividad   = res.poa.subactividad;
                let monto          = res.poa.monto;

                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title mr-2" id="exampleModalLabel">Solicitud POA </h4>
                                    <strong>${departamento}</strong>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" value="${id_poa}" id="solicitud_id">
                                    <h4 class="modal-title">Actividad: </h4>
                                    <span>${actividad}</span>
                                    <h4 class="modal-title mt-4">Sub Actividad: </h4>
                                    <span>${subactividad}</span>

                                    <div class="col-md-12 mt-5">
                                        <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                                        <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="col-md-6 mt-5">
                                            <label for="total_P" class="form-label fs-6 text-green">Monto de la Actividad</label>
                                            <input disabled="" class="form-control disabled-green" type="text" id="total_P" name="total_P[]" value="${monto}">
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <label for="total_C" class="form-label fs-6 text-red">Monto a Certificar</label>
                                            <input class="form-control disabled-red" type="text" id="total_C" name="total_C[]" value="0.00" onchange="validarInputNumerico(this)">
                                            <div class="valid-feedback">¡Se ve bien!</div>
                                            <div class="invalid-feedback">Ingrese solo números</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnSolicitarPoa">Solicitar</button>
                                    <button type="button" class="btn btn-secondary" id="btnCerrarModalCat" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;



                $('#contModalComentarios').append(html);
                // Abre el modal una vez que se ha creado
                $(`#modalComentarios`).modal('show');

            },
            error: function(error) {
                console.error('Error al obtener comentarios:', error);
            }

        });

    });
    /* ==================== MODAL SOLICITAR POA ==================== */




});

//===============================================================================================
