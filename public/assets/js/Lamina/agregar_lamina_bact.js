$(function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.single-select').select2({
        width: '100%',
    });

    generarFilas();


    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */
    $(document).on('click', '#btnGuardarSolicitud', function () {

        if (!validarCampos()) {

        } else {
            //console.log(capturarDatos());

            var datos = capturarDatos();
            let id_ingreso = $('#id_ingreso').val();

            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: '¿Desea guardar las laminas?',
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    // Realizamos la llamada AJAX
                    $.ajax({
                        type: 'POST',
                        url: '/laminas/guardar_laminas',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: {
                            'datos': datos,
                            'id_ingreso': id_ingreso,
                        },
                        success: function (response) {
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

                        error: function (error) {
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

        }
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


    /* PARA QUE SOLO INGRESEN NUMEROS */
    function validarSoloNumeros(input) {
        input.addEventListener('input', function () {
            let value = this.value.replace(/[^0-9]/g, ''); // Elimina cualquier caracter que no sea número
            this.value = value;

            if (value === '') {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    // Aplicar la función a los inputs que quieres
    const inputsNumericos = ['total_laminas', 'total_laminas_super'];

    inputsNumericos.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            validarSoloNumeros(input);
        }
    });
    /* PARA QUE SOLO INGRESEN NUMEROS */


});



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



/* FUNCION PARA VALIDAR CAMPOS ANTES DE GUARDAR */
function validarCampos() {
    let valido = true;
    let mensaje = "";

    document.querySelectorAll("#tabla_body tr").forEach((fila, index) => {
        let numLamina = fila.querySelector("input[name^='num_lamina_']").value.trim();
        let lectura = fila.querySelector("input[name^='lectura_']").value.trim();
        let apariencia = fila.querySelector("select[name^='apariencia_']").value;
        let frotis = fila.querySelector("select[name^='frotis_']").value;
        let tincion = fila.querySelector("select[name^='tincion_']").value;

        if (numLamina === "" || lectura === "" || !apariencia || !frotis || !tincion) {
            valido = false;
            mensaje = `Faltan datos en la fila ${index + 1}`;
            return;
        }
    });

    if (!valido) {
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            text: mensaje,
        });
        return false;
    }

    return true;
}


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



document.addEventListener('DOMContentLoaded', function () {

    const resultados = {};
    const resultadosEspecie = {};

    const resultadosRV = {};
    const resultadosRF = {};


    const totalLaminasInput = document.getElementById('total_laminas');
    const tablaBody = document.getElementById('tabla_body');
    const resultadosContainer = document.getElementById('resultados-container');

    totalLaminasInput.addEventListener('change', function () {
        const total = parseInt(this.value) || 0;

        // Limpiar antes de agregar nuevas filas e inputs
        tablaBody.innerHTML = '';
        resultadosContainer.innerHTML = '';

        for (let i = 1; i <= total; i++) {
            // Crear la fila de la tabla
            const row = `
                <tr>
                    <td><input type="date" id="fecha_${i}" name="fecha_${i}" class="form-control" required></td>
                    <td><input type="text" id="semana_${i}" name="semana_${i}" class="form-control" required></td>
                    <td><input type="text" id="codigo_micro_${i}" name="codigo_micro_${i}" class="form-control" required></td>
                    <td><input type="text" id="num_lamina_${i}" name="num_lamina_${i}" class="form-control" required></td>
                    <td>
                        <select name="diagnostico_calidad_${i}" class="form-control single-select">
                            <option value="">Selecciona una Opción</option>
                            <option value="1">F - Falciparum</option>
                            <option value="2">N - Negativo</option>
                            <option value="3">V - Vivax</option>
                            <option value="4">V - F</option>
                        </select>
                    </td>
                    <td><input type="text" id="recuento_control_vivax_${i}" name="recuento_control_vivax_${i}" class="form-control" required></td>
                    <td><input type="text" id="recuento_control_falciparum_${i}" name="recuento_control_falciparum_${i}" class="form-control" required></td>
                    <td><input type="text" id="presencia_control_${i}" name="presencia_control_${i}" class="form-control" required></td>
                    <td>
                        <select name="diagnostico_microscopista_${i}" class="form-control single-select">
                            <option value="">Selecciona una Opción</option>
                            <option value="1">F - Falciparum</option>
                            <option value="2">N - Negativo</option>
                            <option value="3">V - Vivax</option>
                            <option value="4">V - F</option>
                        </select>
                    </td>
                    <td><input type="text" id="recuento_microscopista_vivax_${i}" name="recuento_microscopista_vivax_${i}" class="form-control" required></td>
                    <td><input type="text" id="recuento_microscopista_falciparum_${i}" name="recuento_microscopista_falciparum_${i}" class="form-control" required></td>
                    <td><input type="text" id="presencia_microscopista_${i}" name="presencia_microscopista_${i}" class="form-control" required></td>
                </tr>
            `;
            tablaBody.insertAdjacentHTML('beforeend', row);

            // Crear el input de resultado fuera de la tabla
            // const input = document.createElement("input");
            // input.type = "text";
            // input.id = `resultado_${i}`;
            // input.name = `resultado_${i}`;
            // input.className = "form-control my-2";
            // input.placeholder = `Resultado Lámina ${i}`;
            // input.disabled = true;
            // resultadosContainer.appendChild(input);
        }

        // Asociar los eventos a los selects para cálculo dinámico
        for (let i = 1; i <= total; i++) {
            const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
            const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`);

            if (diagControl && diagMicro) {
                diagControl.addEventListener("change", () => calcularResultado(i));
                diagMicro.addEventListener("change", () => calcularResultado(i));

                diagControl.addEventListener("change", () => calcularResultadoEspecie(i));
                diagMicro.addEventListener("change", () => calcularResultadoEspecie(i));


                diagControl.addEventListener("change", () => calcularResultadoRV(i));
                diagMicro.addEventListener("change", () => calcularResultadoRV(i));

                //diagControl.addEventListener("change", () => calcularResultadoRF(i));
                //diagMicro.addEventListener("change", () => calcularResultadoRF(i));


            }
        }
    });


    function calcularResultado(i) {
        const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
        const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`);

        const valControl = diagControl?.value || "";
        const valMicro = diagMicro?.value || "";

        let resultado = 0;

        if (valControl === "" && valMicro === "") {
            resultado = 0;
        } else if (valControl === "2" && valMicro === "2") {
            resultado = 10;
        } else if (valControl !== "2" && valMicro !== "2" && valControl !== "" && valMicro !== "") {
            resultado = 4;
        } else {
            resultado = 0;
        }

        // Guardar resultado en el objeto
        resultados[i] = resultado;
    }



    function calcularSumaFiltrada(areaFiltro, fechaInicio, fechaFin) {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaTotal = 0;

        for (let i = 1; i <= total; i++) {
            const fechaElem = document.getElementById(`fecha_${i}`);
            const semanaElem = document.getElementById(`codigo_micro_${i}`);
            //const resultadoElem = document.getElementById(`resultado_${i}`);

            if (!fechaElem || !semanaElem) continue;

            const fecha = new Date(fechaElem.value);
            const fechaIni = new Date(fechaInicio);
            const fechaFinD = new Date(fechaFin);
            const semana = semanaElem.value.trim();
            const resultado = resultados[i] || 0;

            // Aplicar condiciones tipo SUMAR.SI.CONJUNTO
            if (semana === areaFiltro &&
                fecha >= fechaIni &&
                fecha <= fechaFinD) {
                sumaTotal += resultado;
            }
        }

        return sumaTotal;
    }


    document.getElementById("calcular_suma").addEventListener("click", function () {
        const area = document.getElementById("codigo").value; // equivalente a F9
        const desde = document.getElementById("fecha_inicio").value; // equivalente a M9
        const hasta = document.getElementById("fecha_fin").value; // equivalente a S9
        let total_laminas = document.getElementById("total_laminas").value;

        calcularResultadosRecuento(); // importante: primero calcula los recuentos

        const total = calcularSumaFiltrada(area, desde, hasta);
        const totalEspecie = calcularSumaEspecieFiltrada(area, desde, hasta); // nuevo total
        const totalRecuento = calcularSumaRecuentoFiltrada(area, desde, hasta); // nuevo

        const totalResultados = calcularResultadoControlMicroscopia();
        const totalValorResultados = calcularValorResultado();
        const totalNuevoResultadoEspecie = calcularNuevoResultadoEspecie();

        const totalSumatoria = calcularTotalSumatoria(); // calcular la suma total de resultados

        let puntuacion = (totalSumatoria/(total_laminas*10)) * 100; // calcular puntuación

        let interpretacion = interpretacionResultado(puntuacion); // llamar a la función de interpretación

        let porcentajeResult = porcentajeResultado(total, totalValorResultados);
        let porcentajeEspe = porcentajeEspecie(totalEspecie, totalNuevoResultadoEspecie);
        let porcentajeRecuen = porcentajeRecuento(totalRecuento, totalNuevoResultadoEspecie);

        document.getElementById("resultado_total").value = total; // mostrar resultado
        document.getElementById("resultado_especie").value = totalEspecie;
        document.getElementById("resultado_recuento").value = totalRecuento; // muestra nuevo resultado
        document.getElementById("resultado_recuento_total").value = totalResultados;
        document.getElementById("resultado_recuento_total_valor").value = totalValorResultados;
        document.getElementById("resultado_recuento_total_especie").value = totalNuevoResultadoEspecie;
        document.getElementById("resultado_total_sumatoria").value = totalSumatoria;
        document.getElementById("puntuacion").value = puntuacion;
        document.getElementById("interpretacion").value = interpretacion;

        document.getElementById("porcentajeResult").value = porcentajeResult;
        document.getElementById("porcentajeEspe").value = porcentajeEspe;
        document.getElementById("porcentajeRecuen").value = porcentajeRecuen;

    });


    function porcentajeResultado(numerador, denominador) {
        if (!denominador || denominador === 0) {
            return "";
        }
        return (numerador / denominador) * 100;
    }

    function porcentajeEspecie(numerador, denominador) {
        if (!denominador || denominador === 0) {
            return "";
        }
        return (numerador / denominador) * 100;
    }

    function porcentajeRecuento(numerador, denominador) {
        if (!denominador || denominador === 0) {
            return "";
        }
        return (numerador / (denominador / 2)) * 100;
    }
    


    // ========================= calcular resultados especies 

    function calcularResultadoEspecie(i) {
        const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
        const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`);

        const valControl = diagControl?.value.trim() || "";
        const valMicro = diagMicro?.value.trim() || "";

        let resultado = 0;

        if (valControl === "" && valMicro === "") {
            resultado = 0;
        } else if (valControl !== "2" && valMicro !== "2") {
            if (
                (valControl === "4" && valMicro === "3") ||
                (valControl === "4" && valMicro === "1") ||
                (valControl === "1" && valMicro === "4") ||
                (valControl === "3" && valMicro === "4")
            ) {
                resultado = 2;
            } else if (valControl === valMicro) {
                resultado = 4;
            } else {
                resultado = 0;
            }
        } else {
            resultado = 0;
        }

        resultadosEspecie[i] = resultado;
    }


    function calcularSumaEspecieFiltrada(areaFiltro, fechaInicio, fechaFin) {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaTotal = 0;

        for (let i = 1; i <= total; i++) {
            const fechaElem = document.getElementById(`fecha_${i}`);
            const semanaElem = document.getElementById(`codigo_micro_${i}`);

            if (!fechaElem || !semanaElem || !(i in resultadosEspecie)) continue;

            const fecha = new Date(fechaElem.value);
            const fechaIni = new Date(fechaInicio);
            const fechaFinD = new Date(fechaFin);
            const semana = semanaElem.value.trim();
            const resultado = parseFloat(resultadosEspecie[i]) || 0;

            if (semana === areaFiltro && fecha >= fechaIni && fecha <= fechaFinD) {
                sumaTotal += resultado;
            }
        }

        return sumaTotal;
    }


    // ========================= calcular resultados RV

    function calcularResultadoRV(i) {
        const diagnosticoCalidad = document.querySelector(`[name="diagnostico_calidad_${i}"]`)?.value.trim();
        const diagnosticoMicroscopista = document.querySelector(`[name="diagnostico_microscopista_${i}"]`)?.value.trim();
        const recuentoControlVivax = parseFloat(document.getElementById(`recuento_control_vivax_${i}`)?.value) || 0;
        const recuentoControlFalciparum = document.getElementById(`recuento_control_falciparum_${i}`)?.value.trim();
        const recuentoMicroscopistaVivax = parseFloat(document.getElementById(`recuento_microscopista_vivax_${i}`)?.value) || 0;
        const recuentoMicroscopistaFalciparum = document.getElementById(`recuento_microscopista_falciparum_${i}`)?.value.trim();
        const resultadoEspecie = parseFloat(resultadosEspecie[i]) || 0;

        let total = 0;

        // Ambos "V" (3) o "VF" (4) con resultado especie = 4 y Q13 >= 50
        if (
            resultadoEspecie === 4 &&
            ["3", "4"].includes(diagnosticoCalidad) &&
            ["3", "4"].includes(diagnosticoMicroscopista) &&
            recuentoControlVivax >= 50
        ) {
            const min = recuentoControlVivax - (recuentoControlVivax * 0.25);
            const max = recuentoControlVivax + (recuentoControlVivax * 0.25);

            if (recuentoMicroscopistaVivax >= min && recuentoMicroscopistaVivax <= max) {
                total += 1;
            }
        }

        // Ambos "V" con Q13 < 50 y U13 <= 75
        if (
            diagnosticoCalidad === "3" &&
            diagnosticoMicroscopista === "3" &&
            recuentoControlVivax < 50 &&
            recuentoMicroscopistaVivax <= 75
        ) {
            total += 1;
        }

        // Ambos "VF" con Q13 < 50 y U13 <= 75
        if (
            diagnosticoCalidad === "4" &&
            diagnosticoMicroscopista === "4" &&
            recuentoControlVivax < 50 &&
            recuentoMicroscopistaVivax <= 75
        ) {
            total += 1;
        }

        // Ambos "V" y recuentos de falciparum vacíos
        if (
            diagnosticoCalidad === "3" &&
            diagnosticoMicroscopista === "3" &&
            recuentoControlFalciparum === "" &&
            recuentoMicroscopistaFalciparum === ""
        ) {
            total += 1;
        }

        //resultadosRV[i] = total;
        return total; // Cambié esto para que devuelva el total directamente
    }



    // ========================= calcular resultados RF

    function calcularResultadoRF(i) {

        const diagnosticoCalidad = document.querySelector(`[name="diagnostico_calidad_${i}"]`)?.value.trim();
        const diagnosticoMicroscopista = document.querySelector(`[name="diagnostico_microscopista_${i}"]`)?.value.trim();
        const recuentoControlFalciparumInput = document.getElementById(`recuento_control_falciparum_${i}`);
        const recuentoMicroscopistaFalciparumInput = document.getElementById(`recuento_microscopista_falciparum_${i}`);

        const recuentoControlFalciparum = parseFloat(recuentoControlFalciparumInput?.value) || 0;
        const recuentoMicroscopistaFalciparum = parseFloat(recuentoMicroscopistaFalciparumInput?.value) || 0;

        const recuentoControlFalciparumVacio = !recuentoControlFalciparumInput?.value;
        const recuentoMicroscopistaFalciparumVacio = !recuentoMicroscopistaFalciparumInput?.value;

        const resultadoEspecie = parseFloat(resultadosEspecie[i]) || 0;
        let total = 0;

        // Condición 1: resultadoEspecie = 4 y diagnósticos válidos con Q >= 50 y U dentro del 25%
        if (
            resultadoEspecie === 4 &&
            ["1", "4"].includes(diagnosticoCalidad) &&
            ["1", "4"].includes(diagnosticoMicroscopista) &&
            recuentoControlFalciparum >= 50
        ) {
            const min = recuentoControlFalciparum * 0.75;
            const max = recuentoControlFalciparum * 1.25;

            if (recuentoMicroscopistaFalciparum >= min && recuentoMicroscopistaFalciparum <= max) {
                total += 1;
            }
        }

        // Condición 2: ambos F, Q < 50, U <= 75
        if (
            diagnosticoCalidad === "1" &&
            diagnosticoMicroscopista === "1" &&
            recuentoControlFalciparum < 50 &&
            recuentoMicroscopistaFalciparum <= 75
        ) {
            total += 1;
        }

        // Condición 3: ambos VF, Q < 50, U <= 75
        if (
            diagnosticoCalidad === "4" &&
            diagnosticoMicroscopista === "4" &&
            recuentoControlFalciparum < 50 &&
            recuentoMicroscopistaFalciparum <= 75
        ) {
            total += 1;
        }

        // Condición 4: ambos F y Q y U vacíos
        if (
            diagnosticoCalidad === "1" &&
            diagnosticoMicroscopista === "1" &&
            recuentoControlFalciparumVacio &&
            recuentoMicroscopistaFalciparumVacio
        ) {
            total += 1;
        }

        return total;
    }





    const resultadosRecuento = [];
    const resultadosRecuento2 = [];

    function calcularResultadosRecuento() {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;

        for (let i = 1; i <= total; i++) {
            const rv = calcularResultadoRV(i); // deberías tener esta función
            console.log('rv: ' + rv);
            const rf = calcularResultadoRF(i); // deberías tener esta función
            console.log('rf: ' + rf);
            const suma = rv + rf;
            resultadosRecuento[i] = (suma === 2) ? 2 : suma;
        }
        console.log(resultadosRecuento);
    }



    function calcularSumaRecuentoFiltrada(areaFiltro, fechaInicio, fechaFin) {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaTotal = 0;

        for (let i = 1; i <= total; i++) {
            const fechaElem = document.getElementById(`fecha_${i}`);
            const areaElem = document.getElementById(`codigo_micro_${i}`);

            if (!fechaElem || !areaElem || !(i in resultadosRecuento)) continue;

            const fecha = new Date(fechaElem.value);
            const fechaIni = new Date(fechaInicio);
            const fechaFinD = new Date(fechaFin);
            const codigo = areaElem.value.trim();
            const resultado = parseFloat(resultadosRecuento[i]) || 0;

            if (codigo === areaFiltro && fecha >= fechaIni && fecha <= fechaFinD) {
                sumaTotal += resultado;
            }
        }

        return sumaTotal;
    }





    // ========================= calcular resultados

    function calcularResultados1(i) {
        const diagnosticoCalidad = document.querySelector(`[name="diagnostico_calidad_${i}"]`)?.value.trim();

        if (["1", "3", "4"].includes(diagnosticoCalidad)) {
            return 1;
        } else {
            return "-";
        }
    }


    function calcularResultados2(i) {
        const diagnosticoCalidad = document.querySelector(`[name="diagnostico_microscopista_${i}"]`)?.value.trim();

        if (["1", "3", "4"].includes(diagnosticoCalidad)) {
            return 1;
        } else {
            return "-";
        }
    }


    function calcularResultadosRecuento2() {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;

        for (let i = 1; i <= total; i++) {
            const result1 = calcularResultados1(i); // deberías tener esta función
            console.log('rv: ' + result1);
            const result2 = calcularResultados2(i); // deberías tener esta función
            console.log('rf: ' + result2);
            let suma = result1 + result2;
            resultadosRecuento2[i] = (suma === 2) ? 2 : suma;
        }
        console.log(resultadosRecuento2);
    }



    // ========================= calcular resultados
    function calcularResultadoControlMicroscopia() {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaResultados = 0;

        for (let i = 1; i <= total; i++) {
            const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
            const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`);

            const valControl = diagControl?.value || "";
            const valMicro = diagMicro?.value || "";

            // Evaluar combinaciones equivalentes a la fórmula Excel
            if (
                (valControl === "4" && valMicro === "3") || // VF y V
                (valControl === "4" && valMicro === "1") || // VF y F
                (valControl === "1" && valMicro === "4") || // F y VF
                (valControl === "3" && valMicro === "4") || // V y VF
                (valControl === "1" && valMicro === "3") || // F y V
                (valControl === "3" && valMicro === "1") || // V y F
                (valControl !== "" && valControl === valMicro) // Iguales y no vacíos
            ) {
                sumaResultados += 1;
            }
        }

        return sumaResultados;
    }


    function calcularValorResultado() {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaTotal = 0;

        for (let i = 1; i <= total; i++) {
            const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
            const valControl = diagControl?.value || "";

            if (valControl === "") {
                sumaTotal += 0;
            } else if (valControl === "2") { // "N - Negativo" tiene valor "2"
                sumaTotal += 10;
            } else {
                sumaTotal += 4;
            }
        }

        return sumaTotal;
    }


    function calcularNuevoResultadoEspecie() {
        const total = parseInt(document.getElementById("total_laminas").value) || 0;
        let sumaTotal = 0;

        for (let i = 1; i <= total; i++) {
            const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
            const valControl = diagControl?.value || "";

            let resultadoAnterior = 0;

            // Cálculo original
            if (valControl === "") {
                resultadoAnterior = 0;
            } else if (valControl === "2") { // "N - Negativo"
                resultadoAnterior = 10;
            } else {
                resultadoAnterior = 4;
            }

            // Nueva fórmula: =SI(AK13=4;4;0)
            if (resultadoAnterior === 4) {
                sumaTotal += 4;
            } else {
                sumaTotal += 0;
            }
        }

        return sumaTotal;
    }



    function calcularTotalSumatoria() {
        let total = 0;
        let total_laminas = parseInt(document.getElementById("total_laminas").value) || 0;

        // Sumar todos los valores del arreglo resultado
        for (let i = 1; i <= total_laminas; i++) {
            total += parseFloat(resultados[i]) || 0;
            total += parseFloat(resultadosEspecie[i]) || 0;
            total += parseFloat(resultadosRecuento[i]) || 0;
        }
        return total;
    }


    function interpretacionResultado(valor) {
        if (valor >= 90) {
            return "Excelente";
        } else if (valor >= 80 && valor <= 89) {
            return "Muy Bueno";
        } else if (valor >= 70 && valor <= 79) {
            return "Bueno";
        } else {
            return "Pobre";
        }
    }
    




});




