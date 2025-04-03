$( function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.single-select').select2({
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
    $(document).on('click', '#btnGuardarSolicitud', function() {
        // Capturamos los valores de los campos
        let fechaRecepcion = $('#fecha_recep').val();
        let centroSalud    = $('#centro_salud').val();
        let responsable    = $('#responsable').val();
        let analista       = $('#analista').val();
        let mesRecepcion   = $('#mes_recepcion').val();
        let observaciones  = $('#observaciones').val();
        let total_laminas  = $('#total_laminas').val();
    
        // Validación de campos
        if (centroSalud == 0) {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'Debe seleccionar un Centro de Salud.', showConfirmButton: true });
            return;
        } else if (responsable == 0) {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'Debe seleccionar un Responsable.', showConfirmButton: true });
            return;
        } else if (analista == 0) {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'Debe seleccionar un Analista.', showConfirmButton: true });
            return;
        } else if (total_laminas == 0 || total_laminas == '') {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'Debe ingresar un número de Láminas.', showConfirmButton: true });
            return;
        }
    
        let datosRadio = validarCalculos();
        if (!datosRadio) return; // Si la validación falla, detenemos la ejecución
    
        // Mensaje de confirmación
        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            text: '¿Desea guardar la solicitud?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                // Realizamos la llamada AJAX
                $.ajax({
                    type: 'POST',
                    url: '/laminas/guardar',  
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'fecha_recep':   fechaRecepcion,
                        'centro_salud':  centroSalud,
                        'responsable':   responsable,
                        'analista':      analista,
                        'mes_recepcion': mesRecepcion,
                        'observaciones': observaciones,
                        'total_laminas': total_laminas,
                        ...datosRadio // Agregamos los valores de los radios
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: response.success ? 'success' : 'error',
                            title: 'SoftInspi',
                            text: response.message,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.href = "/laminas"; 
                            }
                        });
                    },
                    
                    error: function(error) {
                        var response = error.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'SoftInspi',
                            text: response.message,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });
    });
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */






    function validarCalculos() {
        let valid = true;
        let datosRadio = {}; // Objeto para almacenar los valores de los radios
    
        // Lista de nombres de los radio buttons
        const camposRadio = [
            "laminas_empacadas",
            "laminas_legibles",
            "laminas_sin_id",
            "laminas_sin_aceite",
            "laminas_frotis_adecuado",
            "laminas_integras",
            "laminas_documentacion"
        ];
    
        camposRadio.forEach((campo) => {
            const seleccionado = document.querySelector(`input[name="${campo}"]:checked`);
            if (!seleccionado) {
                valid = false;
                Swal.fire({
                    icon:  'warning',
                    title: 'CoreInspi',
                    text:  `Por favor, selecciona una opción para: ${campo.replace(/_/g, ' ')}`,
                    showConfirmButton: true,
                });
            } else {
                datosRadio[campo] = seleccionado.value; // Guardamos el valor seleccionado
            }
        });
    
        return valid ? datosRadio : false; // Si es válido, retorna los datos; si no, retorna false
    }







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


    /* PARA QUE SOLO INGRESEN NUMEROS */
    document.getElementById('total_laminas').addEventListener('input', function (e) {
        let value = this.value.replace(/[^0-9]/g, ''); // Filtra solo números
        this.value = value;
        
        if (value === '') {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
    /* PARA QUE SOLO INGRESEN NUMEROS */


});




//===============================================================================================
