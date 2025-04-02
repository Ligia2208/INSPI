$( function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.single-select').select2({
        width: '100%',
    });

    // Aplicar la validación a todos los campos "N° Lámina"
    document.querySelectorAll('.total-lamina').forEach(input => {
        input.addEventListener('input', function (e) {
            let value = this.value.replace(/[^0-9]/g, ''); // Filtra solo números
            this.value = value;
            
            if (value === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    //generarFilas();


    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */
    $(document).on('click', '#btnGuardarSolicitud', function() {


        const totalLaminasInput = document.getElementById("total_laminas");
        const totalPosInput = document.getElementById("total_laminas_pos");
        const totalNegInput = document.getElementById("total_laminas_neg");
        const porcentajePosInput = document.getElementById("porcentaje_laminas_pos");
        const porcentajeNegInput = document.getElementById("porcentaje_laminas_neg");
        const calificacionInput = document.getElementById("total_laminas_califica");
        const recomendacionInput = document.getElementById("recomendacion");
    
        let totalLaminas  = parseInt(totalLaminasInput.value) || 0;
        let totalPos      = parseInt(totalPosInput.value) || 0;
        let totalNeg      = parseInt(totalNegInput.value) || 0;
        let porcentajePos = parseFloat(porcentajePosInput.value) || 0;
        let porcentajeNeg = parseFloat(porcentajeNegInput.value) || 0;
        let calificacion  = parseFloat(calificacionInput.value) || 0;
        let recomendacion = recomendacionInput.value.trim();

        if (totalPos + totalNeg > totalLaminas) {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'La suma de láminas positivas y negativas no puede ser mayor que el total.', showConfirmButton: true });
            return;
        }
    
        if (porcentajePos > 100 || porcentajeNeg > 100) {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'Los porcentajes no pueden ser mayores a 100.', showConfirmButton: true });
            return;
        }
    
        if (recomendacion.length == '') {
            Swal.fire({ icon: 'warning', title: 'SoftInspi', text: 'La recomendación debe tener al menos 5 caracteres.', showConfirmButton: true });
    
            return;
        }

            let id_ingreso = $('#id_ingreso').val();

            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: '¿Desea guardar los resultados?',
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    // Realizamos la llamada AJAX
                    $.ajax({
                        type: 'POST',
                        url: '/laminas/resultados_laminas',  
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: {
                            'totalLaminas':  totalLaminas,
                            'totalPos':      totalPos,      
                            'totalNeg':      totalNeg,   
                            'porcentajePos': porcentajePos,
                            'porcentajeNeg': porcentajeNeg,
                            'calificacion':  calificacion,
                            'recomendacion': recomendacion,
                            'id_ingreso':    id_ingreso,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.success ? 'success' : 'error',
                                title: 'CoreInspi',
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

        
        /*
        // Capturamos los valores de los campos
        let fechaRecepcion = $('#fecha_recep').val();
        let centroSalud    = $('#centro_salud').val();
        let responsable    = $('#responsable').val();
        let analista       = $('#analista').val();
        let mesRecepcion   = $('#mes_recepcion').val();
        let observaciones  = $('#Observaciones').val();
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
        */
    });
    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */




    



});


/*
function generarFilas() {
    let totalLaminas = document.getElementById("total_laminas").value;
    let tablaBody = document.getElementById("tabla_body");

    // Limpiar filas previas
    tablaBody.innerHTML = "";

    for (let i = 1; i <= totalLaminas; i++) {
        let fila = `<tr>
            <td><input type="text" name="num_lamina_${i}" class="form-control num-lamina" required></td>
            <td><input type="text" name="lectura_${i}" class="form-control"></td>
            <!-- Apariencia Select -->
            <td>
                <select name="apariencia_${i}" class="form-control single-select">
                    <option value="">Selecciona Frotis</option>
                    <option value="1">Saliva</option>
                    <option value="2">Mucosa</option>
                    <option value="3">Mucopurulenta</option>
                    <option value="4">Sanguinolenta</option>
                </select>
            </td>

            <!-- Frotis Select -->
            <td>
                <select name="frotis_${i}" class="form-control single-select">
                    <option value="">Selecciona Frotis</option>
                    <option value="1">Bueno</option>
                    <option value="2">Grueso</option>
                    <option value="3">Fino</option>
                    <option value="4">No Homogéneo</option>
                </select>
            </td>

            <!-- Tinción Select -->
            <td>
                <select name="tincion_${i}" class="form-control single-select">
                    <option value="">Selecciona Tinción</option>
                    <option value="1">Buena</option>
                    <option value="2">Precipitados</option>
                    <option value="3">Mala Decoloración</option>
                </select>
            </td>
        </tr>`;
        tablaBody.innerHTML += fila;
    }

    // Aplicar la validación a todos los campos "N° Lámina"
    document.querySelectorAll('.num-lamina').forEach(input => {
        input.addEventListener('input', function (e) {
            let value = this.value.replace(/[^0-9]/g, ''); // Filtra solo números
            this.value = value;
            
            if (value === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });

    $('.single-select').select2({
        width: '100%',
    });
}
*/



document.addEventListener("DOMContentLoaded", function () {
    const totalLaminasInput = document.getElementById("total_laminas");
    const totalPosInput = document.getElementById("total_laminas_pos");
    const totalNegInput = document.getElementById("total_laminas_neg");
    const porcentajePosInput = document.getElementById("porcentaje_laminas_pos");
    const porcentajeNegInput = document.getElementById("porcentaje_laminas_neg");
    const calificacionInput = document.getElementById("total_laminas_califica");

    function actualizarTotales() {
        let totalLaminas = parseInt(totalLaminasInput.value) || 0;
        let totalPos = parseInt(totalPosInput.value) || 0;

        // Validar que el total no supere el total general
        if (totalPos > totalLaminas) {
            totalPosInput.value = totalLaminas;
            totalPos = totalLaminas;
        }

        totalNegInput.value = totalLaminas - totalPos;
    }

    function actualizarPorcentajes() {
        let porcentajePos = parseFloat(porcentajePosInput.value) || 0;
        let porcentajeNeg = parseFloat(porcentajeNegInput.value) || 0;

        // No permitir que el porcentaje supere 100
        if (porcentajePos > 100) {
            porcentajePosInput.value = 100;
            porcentajePos = 100;
        }
        if (porcentajeNeg > 100) {
            porcentajeNegInput.value = 100;
            porcentajeNeg = 100;
        }

        // Calcular la calificación sin afectar los totales
        let calificacion = (porcentajePos + porcentajeNeg) / 2;
        calificacionInput.value = calificacion.toFixed(2);
    }

    // Eventos de entrada
    totalPosInput.addEventListener("input", actualizarTotales);
    totalNegInput.addEventListener("input", actualizarTotales);
    porcentajePosInput.addEventListener("input", actualizarPorcentajes);
    porcentajeNegInput.addEventListener("input", actualizarPorcentajes);
});







/* FUNCION PARA CAPTURAR DATOS Y ENVIARLOS AL CONTROLADOR */
function capturarDatos() {
    if (!validarCampos()) return;

    let datos = [];

    document.querySelectorAll("#tabla_body tr").forEach((fila) => {
        let numLamina = fila.querySelector("input[name^='num_lamina_']").value.trim();
        let lectura = fila.querySelector("input[name^='lectura_']").value.trim();
        let apariencia = fila.querySelector("select[name^='apariencia_']").value;
        let frotis = fila.querySelector("select[name^='frotis_']").value;
        let tincion = fila.querySelector("select[name^='tincion_']").value;

        datos.push({
            num_lamina: numLamina,
            lectura: lectura,
            apariencia: apariencia,
            frotis: frotis,
            tincion: tincion
        });
    });

    console.log(datos); // Puedes enviarlo con fetch o AJAX al controlador
    Swal.fire({
        icon: 'success',
        title: 'Datos capturados correctamente',
        text: 'Puedes enviarlos al servidor',
    });

    return datos;
}


//===============================================================================================
