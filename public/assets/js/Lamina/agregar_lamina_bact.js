$(function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.single-select').select2({
        width: '100%',
    });


    /* ==================== GUARDAR INGRESO DE LAMINAS ==================== */
    $(document).on('click', '#btnGuardarSolicitud', function () {

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
                    let fecha_inicio        = document.getElementById('fecha_inicio').value.trim();
                    let fecha_fin           = document.getElementById('fecha_fin').value.trim();
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
                    } else if (!fecha_inicio) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha Inicial.', showConfirmButton: true });
                    } else if (!fecha_fin) {
                        Swal.fire({ icon: 'warning', title: 'CoreInspi', text: 'Debe ingresar la Fecha Final.', showConfirmButton: true });
                    } else if (!observacion) {
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
                            url: '/laminas/guardar_laminas_bact',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: {
                                'datos': datos,
                                //'id_ingreso': id_ingreso,
                                'fecha_recep'         :fecha_recep        ,  
                                'centro_salud'        :centro_salud       ,  
                                'evento'              :evento             ,  
                                'responsable'         :responsable        ,  
                                'fecha_recebcion'     :fecha_recebcion    ,  
                                'mes_recepcion'       :mes_recepcion      ,  
                                'total_laminas'       :total_laminas      ,  
                                'total_laminas_super' :total_laminas_super,  
                                'codigo'              :codigo             ,  
                                'fecha_inicio'        :fecha_inicio       ,  
                                'fecha_fin'           :fecha_fin          ,  
                                'observacion'         :observacion        ,  
                                'total_laminas_pos'   :total_laminas_pos  ,
                                'total_laminas_neg'   :total_laminas_neg  ,
                                'resultados'          : resultados,
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


    /* PARA QUE SOLO INGRESEN NUMEROS */
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



function actualizarMesRecepcion() {
    const inputsSemana = document.querySelectorAll('input[id^="semana_"]');
    let numeros = [];

    inputsSemana.forEach(input => {
        const valor = parseInt(input.value);
        if (!isNaN(valor)) {
            numeros.push(valor);
        }
    });

    if (numeros.length > 0) {
        const min = Math.min(...numeros);
        const max = Math.max(...numeros);
        const texto = (min === max) ? `semana ${min}` : `semana ${min} - ${max}`;
        document.getElementById('mes_recepcion').value = texto;
    } else {
        document.getElementById('mes_recepcion').value = '';
    }
}



function actualizarCodigoMicroscopista() {
    const select = document.getElementById('centro_salud');
    const inputCodigo = document.getElementById('codigo');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption && selectedOption.value !== "") {
        const unicodigo = selectedOption.getAttribute('data-unicodigo') || '';
        inputCodigo.value = unicodigo;
        inputCodigo.disabled = true;

        // NUEVA LÓGICA: actualizar todos los campos codigo_micro_*
        const totalLaminas = document.getElementById('total_laminas');
        const total = parseInt(totalLaminas.value) || 0;

        for (let i = 1; i <= total; i++) {
            const input = document.getElementById(`codigo_micro_${i}`);
            if (input) {
                input.value = unicodigo;
                input.disabled = true; // opcional, si quieres que no lo puedan editar
            }
        }
    } else {
        inputCodigo.value = '';
        inputCodigo.disabled = true;

        // Limpiar también los campos codigo_micro_*
        const totalLaminas = document.getElementById('total_laminas');
        const total = parseInt(totalLaminas.value) || 0;

        for (let i = 1; i <= total; i++) {
            const input = document.getElementById(`codigo_micro_${i}`);
            if (input) {
                input.value = '';
                input.disabled = true;
            }
        }
    }
}


// variables globales
const resultados = {};


/* VALIDAR CAMPOS DE CADA FILA DE LA TABLA */
function validarCampos() {
    let valido = true;
    let mensaje = "";

    document.querySelectorAll("#tabla_body tr").forEach((fila, index) => {
        let fecha = fila.querySelector(`input[name^='fecha_']`).value.trim();
        let semana = fila.querySelector(`input[name^='semana_']`).value.trim();
        let codigoMicro = fila.querySelector(`input[name^='codigo_micro_']`).value.trim();
        let numLamina = fila.querySelector(`input[name^='num_lamina_']`).value.trim();
        let diagnosticoCalidad = fila.querySelector(`select[name^='diagnostico_calidad_']`).value;
        //let recuentoControlVivax = fila.querySelector(`input[name^='recuento_control_vivax_']`).value.trim();
        //let recuentoControlFalciparum = fila.querySelector(`input[name^='recuento_control_falciparum_']`).value.trim();
        //let presenciaControl = fila.querySelector(`input[name^='presencia_control_']`).value.trim();
        let diagnosticoMicro = fila.querySelector(`select[name^='diagnostico_microscopista_']`).value;
        //let recuentoMicroVivax = fila.querySelector(`input[name^='recuento_microscopista_vivax_']`).value.trim();
        //let recuentoMicroFalciparum = fila.querySelector(`input[name^='recuento_microscopista_falciparum_']`).value.trim();
        //let presenciaMicro = fila.querySelector(`input[name^='presencia_microscopista_']`).value.trim();

        if (
            !fecha || !semana || !codigoMicro || !numLamina || !diagnosticoCalidad || !diagnosticoMicro 
        ) {
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


/* CAPTURAR DATOS DE LA TABLA Y ENVIARLOS */
function capturarDatos() {
    if (!validarCampos()) return;

    let datos = [];

    document.querySelectorAll("#tabla_body tr").forEach((fila) => {
        let obj = {
            fecha: fila.querySelector(`input[name^='fecha_']`).value.trim(),
            semana: fila.querySelector(`input[name^='semana_']`).value.trim(),
            codigo_micro: fila.querySelector(`input[name^='codigo_micro_']`).value.trim(),
            num_lamina: fila.querySelector(`input[name^='num_lamina_']`).value.trim(),
            diagnostico_calidad: fila.querySelector(`select[name^='diagnostico_calidad_']`).value,
            recuento_control_vivax: fila.querySelector(`input[name^='recuento_control_vivax_']`).value.trim(),
            recuento_control_falciparum: fila.querySelector(`input[name^='recuento_control_falciparum_']`).value.trim(),
            presencia_control: fila.querySelector(`input[name^='presencia_control_']`).value.trim(),
            diagnostico_microscopista: fila.querySelector(`select[name^='diagnostico_microscopista_']`).value,
            recuento_microscopista_vivax: fila.querySelector(`input[name^='recuento_microscopista_vivax_']`).value.trim(),
            recuento_microscopista_falciparum: fila.querySelector(`input[name^='recuento_microscopista_falciparum_']`).value.trim(),
            presencia_microscopista: fila.querySelector(`input[name^='presencia_microscopista_']`).value.trim(),
        };

        datos.push(obj);
    });

    //console.log(datos); // Aquí puedes enviar con fetch o AJAX

    Swal.fire({
        icon: 'success',
        title: 'Datos capturados correctamente',
        text: 'Puedes enviarlos al servidor',
    });

    return datos;
}





/* ==================== OBTENER RESULTADOS ==================== */
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


function obtenerResultados() {
    const area = document.getElementById("codigo").value; // equivalente a F9
    const desde = document.getElementById("fecha_inicio").value; // equivalente a M9
    const hasta = document.getElementById("fecha_fin").value; // equivalente a S9
    let total_laminas = document.getElementById("total_laminas").value;

    let resultadosEspecie = calcularResultadoEspecie();
    calcularResultadosRecuento(resultadosEspecie); // importante: primero calcula los recuentos

    

    const total = calcularSumaFiltrada(area, desde, hasta);
    const totalEspecie = calcularSumaEspecieFiltrada(area, desde, hasta, resultadosEspecie); // nuevo total
    const totalRecuento = calcularSumaRecuentoFiltrada(area, desde, hasta); // nuevo

    const totalResultados = calcularResultadoControlMicroscopia();
    const totalValorResultados = calcularValorResultado();
    const totalNuevoResultadoEspecie = calcularNuevoResultadoEspecie();

    const totalSumatoria = calcularTotalSumatoria(resultadosEspecie); // calcular la suma total de resultados

    let puntuacion = (totalSumatoria/(total_laminas*10)) * 100; // calcular puntuación

    let interpretacion = interpretacionResultado(puntuacion); // llamar a la función de interpretación

    let porcentajeResult = porcentajeResultado(total, totalValorResultados);
    let porcentajeEspe = porcentajeEspecie(totalEspecie, totalNuevoResultadoEspecie);
    let porcentajeRecuen = porcentajeRecuento(totalRecuento, totalNuevoResultadoEspecie);

    /*
    console.log("resultado_total: ", total); // mostrar resultado
    console.log("resultado_especie: ", totalEspecie);
    console.log("resultado_recuento: ", totalRecuento); // muestra nuevo resultado
    console.log("resultado_recuento_total: ", totalResultados);
    console.log("resultado_recuento_total_valor: ", totalValorResultados);
    console.log("resultado_recuento_total_especie: ", totalNuevoResultadoEspecie);
    console.log("resultado_total_sumatoria: ", totalSumatoria);
    console.log("puntuacion: ", puntuacion);
    console.log("interpretacion: ", interpretacion);

    console.log("porcentajeResult: ", porcentajeResult);
    console.log("porcentajeEspe: ", porcentajeEspe);
    console.log("porcentajeRecuen: ", porcentajeRecuen);
    */

    $('#puntuacion').val(puntuacion != null && puntuacion !== '' ? Number(puntuacion).toFixed(2) : '0.00');
    $('#interpretacion').val(interpretacion); // Este sigue siendo texto, así que no se redondea
    $('#porcentajeResult').val(porcentajeResult != null && porcentajeResult !== '' ? Number(porcentajeResult).toFixed(2) : '0.00');
    $('#porcentajeEspe').val(porcentajeEspe != null && porcentajeEspe !== '' ? Number(porcentajeEspe).toFixed(2) : '0.00');
    $('#porcentajeRecuen').val(porcentajeRecuen != null && porcentajeRecuen !== '' ? Number(porcentajeRecuen).toFixed(2) : '0.00');

    let resultado = contarDiagnosticos(total_laminas);
    
    /*
    console.log("Negativas:", resultado.negativas);
    console.log("Positivas:", resultado.positivas);
    console.log("Positivas Concordantes:", resultado.positivasConcordantes);
    console.log("Positivas Discordantes:", resultado.positivasDiscordantes);
    console.log("Negativas Concordantes:", resultado.negativasConcordantes);
    console.log("Negativas Discordantes:", resultado.negativasDiscordantes);
    */

    return {
        area,
        desde,
        hasta,
        total_laminas,
        total,
        totalEspecie,
        totalRecuento,
        totalResultados,
        totalValorResultados,
        totalNuevoResultadoEspecie,
        totalSumatoria,
        puntuacion,
        interpretacion,
        porcentajeResult,
        porcentajeEspe,
        porcentajeRecuen,
        //diagnosticos, 
        resultado
    };

}


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

function calcularResultadoEspecie() {
    const total = parseInt(document.getElementById("total_laminas").value) || 0;

    let resultadosEspecie = {};

    for (let i = 1; i <= total; i++) {

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


    return resultadosEspecie;
    
}


function calcularSumaEspecieFiltrada(areaFiltro, fechaInicio, fechaFin, resultadosEspecie) {
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

function calcularResultadoRV(i, resultadosEspecie) {
    const diagnosticoCalidad = document.querySelector(`[name="diagnostico_calidad_${i}"]`)?.value.trim();
    const diagnosticoMicroscopista = document.querySelector(`[name="diagnostico_microscopista_${i}"]`)?.value.trim();
    const recuentoControlVivax = parseFloat(document.getElementById(`recuento_control_vivax_${i}`)?.value) || 0;
    const recuentoControlFalciparum = document.getElementById(`recuento_control_falciparum_${i}`)?.value.trim();
    const recuentoMicroscopistaVivax = parseFloat(document.getElementById(`recuento_microscopista_vivax_${i}`)?.value) || 0;
    const recuentoMicroscopistaFalciparum = document.getElementById(`recuento_microscopista_falciparum_${i}`)?.value.trim();
    const resultadoEspecie = parseFloat(resultadosEspecie[i]) || 0;

    let total = 0;

    /*
    if (diagnosticoCalidad === "1" && diagnosticoMicroscopista === "1") {
        total += 1;
    }
    */

    // Ambos "V" (3) o "VF" (4) con resultado especie = 4 y Q13 >= 50
    if (
        resultadoEspecie === 4 &&
        ["1", "4"].includes(diagnosticoCalidad) &&
        ["1", "4"].includes(diagnosticoMicroscopista) &&
        recuentoControlFalciparum >= 50
    ){
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

function calcularResultadoRF(i, resultadosEspecie) {

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
        ["1"].includes(diagnosticoCalidad) &&
        ["1"].includes(diagnosticoMicroscopista) &&
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

function calcularResultadosRecuento(resultadosEspecie) {
    const total = parseInt(document.getElementById("total_laminas").value) || 0;

    for (let i = 1; i <= total; i++) {
        const rv = calcularResultadoRV(i, resultadosEspecie); // deberías tener esta función
        console.log('rv: ' + rv);
        const rf = calcularResultadoRF(i, resultadosEspecie); // deberías tener esta función
        console.log('rf: ' + rf);
        const suma = rv + rf;
        resultadosRecuento[i] = (suma === 2) ? 2 : suma;
    }
    //console.log(resultadosRecuento);
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
    //console.log(resultadosRecuento2);
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



function calcularTotalSumatoria(resultadosEspecie) {
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



function contarDiagnosticos(total) {
    let totalNegativas = 0;
    let totalPositivas = 0;

    let positivasConcordantes = 0;
    let positivasDiscordantes = 0;
    let negativasConcordantes = 0;
    let negativasDiscordantes = 0;

    const positivos = ["1", "3", "4"];

    for (let i = 1; i <= total; i++) {
        const diagCalidad = document.querySelector(`[name="diagnostico_calidad_${i}"]`)?.value;
        const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`)?.value;

        // Contar positivas y negativas (basado solo en calidad)
        if (diagCalidad === "2") {
            totalNegativas++;
        } else if (diagCalidad !== "") {
            totalPositivas++;
        }

        // Clasificaciones
        if (positivos.includes(diagCalidad) && positivos.includes(diagMicro)) {
            positivasConcordantes++;
        }

        if (positivos.includes(diagCalidad) && diagMicro === "2") {
            positivasDiscordantes++;
        }

        if (diagCalidad === "2" && diagMicro === "2") {
            negativasConcordantes++;
        }

        if (diagCalidad === "2" && positivos.includes(diagMicro)) {
            negativasDiscordantes++;
        }
    }

    return {
        negativas: totalNegativas,
        positivas: totalPositivas,
        positivasConcordantes,
        positivasDiscordantes,
        negativasConcordantes,
        negativasDiscordantes
    };
}



function asignarEventosFila(i) {
    const elementos = [
        `fecha_${i}`, `semana_${i}`, `codigo_micro_${i}`, `num_lamina_${i}`,
        `recuento_control_vivax_${i}`, `recuento_control_falciparum_${i}`,
        `presencia_control_${i}`, `recuento_microscopista_vivax_${i}`,
        `recuento_microscopista_falciparum_${i}`, `presencia_microscopista_${i}`
    ];

    elementos.forEach(id => {
        const input = document.getElementById(id);
        if (input) input.addEventListener('change', () => obtenerResultados());
    });

    const diagControl = document.querySelector(`[name="diagnostico_calidad_${i}"]`);
    const diagMicro = document.querySelector(`[name="diagnostico_microscopista_${i}"]`);

    if (diagControl && diagMicro) {
        diagControl.addEventListener("change", () => {
            obtenerResultados();
            calcularResultado(i);
        });
        diagMicro.addEventListener("change", () => {
            obtenerResultados();
            calcularResultado(i);
        });
    }


    //asignar para que solo se puedan escribir números
    const semanaInput = document.getElementById(`semana_${i}`);
    if (semanaInput) {
        validarSoloNumeros(semanaInput);

        // Actualizar el input "mes_recepcion" al cambiar
        semanaInput.addEventListener('input', actualizarMesRecepcion);
    }

}



document.addEventListener('DOMContentLoaded', function () {

    //const resultadosEspecie = {};

    const resultadosRV = {};
    const resultadosRF = {};

    const inputPos = document.getElementById('total_laminas_pos');
    const inputSuper = document.getElementById('total_laminas_super');
    const inputNeg = document.getElementById('total_laminas_neg');


    const totalLaminasInput = document.getElementById('total_laminas');
    const tablaBody = document.getElementById('tabla_body');
    const resultadosContainer = document.getElementById('resultados-container');

    totalLaminasInput.addEventListener('change', function () {
        const total = parseInt(this.value) || 0;
        const filasActuales = tablaBody.querySelectorAll('tr').length;
    
        if (total > filasActuales) {
            // Agregar las filas faltantes
            for (let i = filasActuales + 1; i <= total; i++) {
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
                                <option value="4">V/F - Vivax/Falciparum</option>
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
                                <option value="4">V/F - Vivax/Falciparum</option>
                            </select>
                        </td>
                        <td><input type="text" id="recuento_microscopista_vivax_${i}" name="recuento_microscopista_vivax_${i}" class="form-control" required></td>
                        <td><input type="text" id="recuento_microscopista_falciparum_${i}" name="recuento_microscopista_falciparum_${i}" class="form-control" required></td>
                        <td><input type="text" id="presencia_microscopista_${i}" name="presencia_microscopista_${i}" class="form-control" required></td>
                    </tr>
                `;
                tablaBody.insertAdjacentHTML('beforeend', row);
    
                // Asignar eventos después de agregar la fila
                asignarEventosFila(i);
            }
    
        } else if (total < filasActuales) {
            // Eliminar las filas sobrantes desde el final
            for (let i = filasActuales; i > total; i--) {
                const ultimaFila = tablaBody.lastElementChild;
                if (ultimaFila) tablaBody.removeChild(ultimaFila);
            }
        }
    
        actualizarCodigoMicroscopista(); // Si necesitas mantener esta función
    });

    

    /* PARA CALCULAR EL TOTAL DE LÁMINAS POSITIVAS Y NEGATIVAS */
    function actualizarNegativas() {
        const pos = parseInt(inputPos.value) || 0;
        const superVal = parseInt(inputSuper.value) || 0;
        let resultado = superVal - pos;

        // Evitar números negativos
        if (resultado < 0) {
            resultado = 0;
        }

        inputNeg.value = resultado;
    }
    

    inputPos.addEventListener('input', actualizarNegativas);
    inputSuper.addEventListener('input', actualizarNegativas);
    /* PARA CALCULAR EL TOTAL DE LÁMINAS POSITIVAS Y NEGATIVAS */

});



