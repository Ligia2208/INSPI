function validarCampos() {
    let valido = true;
    let comentario = '';

    $('table tbody tr').each(function(index) {

        if ($(this).is(':visible')) {

            let tipo       = $(this).find('select[name="tipo[]"]').val();
            let total      = $(this).find('input[name="total[]"]').val();
            let justificacion = $(this).find('input[name="justificacion[]"]').val();
            let enero      = $(this).find('input[name="enero1[]"]').val();
            let febrero    = $(this).find('input[name="febrero1[]"]').val();
            let marzo      = $(this).find('input[name="marzo1[]"]').val();
            let abril      = $(this).find('input[name="abril1[]"]').val();
            let mayo       = $(this).find('input[name="mayo1[]"]').val();
            let junio      = $(this).find('input[name="junio1[]"]').val();
            let julio      = $(this).find('input[name="julio1[]"]').val();
            let agosto     = $(this).find('input[name="agosto1[]"]').val();
            let septiembre = $(this).find('input[name="septiembre1[]"]').val();
            let octubre    = $(this).find('input[name="octubre1[]"]').val();
            let noviembre  = $(this).find('input[name="noviembre1[]"]').val();
            let diciembre  = $(this).find('input[name="diciembre1[]"]').val();
    
            //sumar y comparar con el total
            if (tipo === null || tipo === "" ||
                total === null || total === "" ||
                justificacion === null || justificacion === "" ||
                enero === null || enero === "" ||
                febrero === null || febrero === "" ||
                marzo === null || marzo === "" ||
                abril === null || abril === "" ||
                mayo === null || mayo === "" ||
                junio === null || junio === "" ||
                julio === null || julio === "" ||
                agosto === null || agosto === "" ||
                septiembre === null || septiembre === "" ||
                octubre === null || octubre === "" ||
                noviembre === null || noviembre === "" ||
                diciembre === null || diciembre === "") {
    
                valido = false;
                comentario = 'Se cayó en la fila '+(index+1);
    
                return false; // Sale del bucle each() si encuentra algún campo vacío
            }

        }

    });

    // Validar justificación fuera del bucle each
    let justificacion = $('#justificacion').val();
    if (justificacion === null || justificacion === "") {
        valido = false;
        comentario = '¡Se requiere una justificación! Ingrese una justificación para editar la reforma.';
    }

    let tipo = $('#select_tipo').val();
    if (tipo === null || tipo.trim() === "") {
        valido = false;
        comentario = 'Seleccione el tipo Reforma que quiere realizar.';
    }

    let justifi = $('#justifi').val();
    if (justifi === null || justifi === "") {
        valido = false;
        comentario = '¡Se requiere una justificación del Área Requirente!';
    }

    if(!valido){

        Swal.fire({
            // icon: 'warning',
            icon: 'warning',
            title: 'Error',
            type: 'error',
            text: comentario,
            showConfirmButton: true
        });

    }

    return valido;


}

$(document).ready(function() {

    $('.single-select').select2({
        width: '100%',
    });

    actualizarTotales();

    // Función para calcular el total de los meses
    function calcularTotal($inputsMeses) {
        let total = 0;
        $inputsMeses.each(function() {
            let valor = parseFloat($(this).val()) || 0;
            total += valor;
        });
        return total;
    }

    // Función para actualizar el campo total
    function actualizarTotal($inputsMeses, $inputTotal) {
        let total = calcularTotal($inputsMeses);
        $inputTotal.val(total.toFixed(2));
    }


    // Evento de cambio para el select de tipo de inversión
    $('#tblActividadesEditar').on('change', 'select[name="tipo[]"]', function() {
        // Obtener el valor seleccionado (DISMINUYE o AUMENTA)
        let tipo = $(this).val();

        // Obtener la fila actual
        let $fila = $(this).closest('tr');

        // Obtener los campos de meses y total de la fila actual
        let $inputsMeses = $fila.find('input[name^="enero1"], input[name^="febrero1"], input[name^="marzo1"], input[name^="abril1"], input[name^="mayo1"], input[name^="junio1"], input[name^="julio1"], input[name^="agosto1"], input[name^="septiembre1"], input[name^="octubre1"], input[name^="noviembre1"], input[name^="diciembre1"]');
        let $inputTotal = $fila.find('input[name="total1[]"]').prop('disabled', true);

        // Actualizar el total al cambiar cualquier campo de meses
        $inputsMeses.off('input').on('input', function() {
            actualizarTotal($inputsMeses, $inputTotal);
            actualizarTotales();
        });

        // Inicializar el total al cargar la página
        actualizarTotal($inputsMeses, $inputTotal);
        actualizarTotales();
    });

    // Llamar al evento de cambio al cargar la página para inicializar el estado de los campos
    $('select[name="tipo[]"]').trigger('change');

    agregarEstructura()

    $('#unidad_ejecutora').on('change', function() {

        var id_unidad = $('#unidad_ejecutora').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_programa_id?id_unidad='+id_unidad, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var programaSelect = $('#programa');
                programaSelect.empty(); // Limpia las opciones actuales

                programaSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un programa'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, programa) {
                    programaSelect.append($('<option>', {
                        value: programa.id,
                        text:  programa.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del programa', error);
            }
        });
    });

    $('#programa').on('change', function() {

        var id_programa = $('#programa').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_proyecto_id?id_programa='+id_programa, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var proyectoSelect = $('#proyecto');
                proyectoSelect.empty(); // Limpia las opciones actuales

                proyectoSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un proyecto'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, proyecto) {
                    proyectoSelect.append($('<option>', {
                        value: proyecto.id,
                        text:  proyecto.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });

    $('#proyecto').on('change', function() {

        var id_proyecto = $('#proyecto').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_actividad_id?id_proyecto='+id_proyecto, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var actividadSelect = $('#actividad');
                actividadSelect.empty(); // Limpia las opciones actuales

                actividadSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione una actividad'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, actividad) {
                    actividadSelect.append($('<option>', {
                        value: actividad.id,
                        text:  actividad.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });

    $('#actividad').on('change', function() {

        var id_actividad = $('#actividad').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_fuente_id?id_actividad='+id_actividad, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var fuenteSelect = $('#fuente_financiamiento');
                fuenteSelect.empty(); // Limpia las opciones actuales

                fuenteSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione una fuente de financiamiento'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, fuente) {
                    fuenteSelect.append($('<option>', {
                        value: fuente.id,
                        text:  fuente.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });
});


function actualizarReforma() {
    if (validarCampos()) {
        var formData = [];
        var justificacion = $('#justificacion').val();
        var id_reforma    = $('#id_reforma').val();
        var justifi       = $('#justifi').val(); //Obtener el valore del textarea de justificación del área requirente
        var id_direccion  = $('#id_direccion').val();
        let tipo_refor    = $('#select_tipo').val();

        // Variables para los totales
        let totalDisminuye = 0;
        let totalAumenta = 0;

        $('#tblActividadesEditar tbody tr').each(function(index) {

            if ($(this).is(':visible')) {
                let id_actividad = $(this).find('input[name="id_actividad[]"]').val();
                let solicitud    = $(this).find('input[name="solicitud[]"]').val();
                let id_area_soli = $(this).find('input[name="id_area_soli[]"]').val();
                let id_poa       = $(this).find('input[name="id_poa[]"]').val();
                let tipo         = $(this).find('select[name="tipo[]"]').val();
                let enero        = $(this).find('input[name="enero1[]"]').val();
                let febrero      = $(this).find('input[name="febrero1[]"]').val();
                let marzo        = $(this).find('input[name="marzo1[]"]').val();
                let abril        = $(this).find('input[name="abril1[]"]').val();
                let mayo         = $(this).find('input[name="mayo1[]"]').val();
                let junio        = $(this).find('input[name="junio1[]"]').val();
                let julio        = $(this).find('input[name="julio1[]"]').val();
                let agosto       = $(this).find('input[name="agosto1[]"]').val();
                let septiembre   = $(this).find('input[name="septiembre1[]"]').val();
                let octubre      = $(this).find('input[name="octubre1[]"]').val();
                let noviembre    = $(this).find('input[name="noviembre1[]"]').val();
                let diciembre    = $(this).find('input[name="diciembre1[]"]').val();
                let total        = $(this).find('input[name="total1[]"]').val();
                let subActividad = $(this).find('input[name="subActividad[]"]').val();


                formData.push({
                    id_actividad: id_actividad,
                    solicitud:    solicitud,
                    tipo:         tipo,
                    enero:        enero,
                    febrero:      febrero,
                    marzo:        marzo,
                    abril:        abril,
                    mayo:         mayo,
                    junio:        junio,
                    julio:        julio,
                    agosto:       agosto,
                    septiembre:   septiembre,
                    octubre:      octubre,
                    noviembre:    noviembre,
                    diciembre:    diciembre,
                    total:        total,
                    estado:       'A',
                    subActividad: subActividad,
                    id_area_soli: id_area_soli,
                    id_poa:       id_poa,

                });

                // Sumar los totales según el tipo
                if (tipo === 'DISMINUYE') {
                    totalDisminuye += parseFloat(total) || 0;
                } else if (tipo === 'AUMENTA') {
                    totalAumenta += parseFloat(total) || 0;
                }

            }else{
                let id_actividad = $(this).find('input[name="id_actividad[]"]').val();
                let solicitud    = $(this).find('input[name="solicitud[]"]').val();
                let id_area_soli = $(this).find('input[name="id_area_soli[]"]').val();
                let id_poa       = $(this).find('input[name="id_poa[]"]').val();
                let tipo         = $(this).find('select[name="tipo[]"]').val();
                let enero        = $(this).find('input[name="enero1[]"]').val();
                let febrero      = $(this).find('input[name="febrero1[]"]').val();
                let marzo        = $(this).find('input[name="marzo1[]"]').val();
                let abril        = $(this).find('input[name="abril1[]"]').val();
                let mayo         = $(this).find('input[name="mayo1[]"]').val();
                let junio        = $(this).find('input[name="junio1[]"]').val();
                let julio        = $(this).find('input[name="julio1[]"]').val();
                let agosto       = $(this).find('input[name="agosto1[]"]').val();
                let septiembre   = $(this).find('input[name="septiembre1[]"]').val();
                let octubre      = $(this).find('input[name="octubre1[]"]').val();
                let noviembre    = $(this).find('input[name="noviembre1[]"]').val();
                let diciembre    = $(this).find('input[name="diciembre1[]"]').val();
                let total        = $(this).find('input[name="total1[]"]').val();
                let subActividad = $(this).find('input[name="subActividad[]"]').val();

                formData.push({
                    id_actividad: id_actividad,
                    solicitud:    solicitud,
                    tipo:         tipo,
                    enero:        enero,
                    febrero:      febrero,
                    marzo:        marzo,
                    abril:        abril,
                    mayo:         mayo,
                    junio:        junio,
                    julio:        julio,
                    agosto:       agosto,
                    septiembre:   septiembre,
                    octubre:      octubre,
                    noviembre:    noviembre,
                    diciembre:    diciembre,
                    total:        total,
                    estado:       'E',
                    subActividad: subActividad,
                    id_area_soli: id_area_soli,
                    id_poa:       id_poa,

                });
            }
        });

        // Comparar los totales
        if (Math.abs(totalDisminuye - totalAumenta) > 0.01) { // Utiliza un margen de error pequeño para evitar problemas de precisión
            Swal.fire({
                icon:  'error',
                title: 'CoreInspi',
                type:  'error',
                text: 'Los totales de disminución y aumento no coinciden. Por favor, ajuste los valores.',
                showConfirmButton: true
            });
            return; // Detener el proceso si los totales no coinciden
        }

        // let id_reforma = obtenerIdReformaDeLaURL();

        if (formData.length > 0) {

            $.ajax({
                type: 'PUT',
                url: `/planificacion/actualizarReforma/${id_reforma}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    formData:      formData,
                    justificacion: justificacion,
                    justifi:       justifi,
                    id_direccion:  id_direccion,
                    tipo_refor:    tipo_refor,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        type:  'success',
                        title: 'CoreInspi',
                        text: 'Reforma actualizada correctamente.',
                        showConfirmButton: true
                    }).then((result) => {
                        if (result.value) {
                            window.location.href = '/planificacion/reformaIndex';
                        }
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon:  'error',
                        title: 'CoreInspi',
                        type:  'error',
                        text: 'Error al actualizar la reforma: ' + error.responseJSON.message,
                        showConfirmButton: true,
                    });
                }
            });
        }else {
            // Mostrar mensaje de error si no hay datos para enviar
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                type:  'error',
                text: 'No hay datos para guardar. Por favor, agregue al menos una actividad.',
                showConfirmButton: true
            });
        }
    }
}

function eliminarFila(button) {
    // Obtener la fila a la que pertenece el botón
    var fila = button.closest('tr');
    // Ocultar la fila (no eliminarla del DOM para mantener el índice de atributos)
    fila.style.display = 'none';
    actualizarTotales();
}

let formularioVisible = false;

function mostrarFormularioActividad() {
    $('#formularioActividad').show();
    $('#contenedorBotonAgregarActividad').hide(); // Oculta el contenedor del botón
}

function cerrarFormularioActividad() {
    $('#formularioActividad').hide();
    $('#contenedorBotonAgregarActividad').show(); 
}

function guardarNuevaActividad() {

    let coordina = $('#coordina').val();
    let fecha = $('#fecha').val();
    let poa = $('#poa').val();
    let obOpera = $('#obOpera').val();
    let actOpera = $('#actOpera').val();
    let subActi = $('#subActi').val();

    let id_item_dir         = $('#item_presupuestario').val();
    let selectedOption      = $(`#item_presupuestario option[value="${id_item_dir}"]`);
    let item_presupuestario = selectedOption.attr("data-id_item");

    let monDisp    = $('#monDisp').val();
    let desItem    = $('#desItem').val();
    let plurianual = $('#plurianual').is(':checked');
    let id_reforma = $('#id_reforma').val();
    var unidad_ejecutora = $('#unidad_ejecutora').val();
    var programa   = $('#programa').val();
    var proyecto   = $('#proyecto').val();
    var actividad  = $('#actividad').val();
    var fuente_financiamiento = $('#fuente_financiamiento').val();
    let justifi2   = $('#justifi2').val();
    var proceso    = $('#proceso').val();

    if(coordina == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Coordinación/Dirección/Proyecto.',
            showConfirmButton: true,
        });

    }else if(fecha == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Fecha.',
            showConfirmButton: true,
        });

    }else if(poa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de selecionar un tipo de Gasto.',
            showConfirmButton: true,
        });

    }else if( proceso == '' || proceso == 0 ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de seleccionar un Tipo de Proceso.',
            showConfirmButton: true,
        });
    }else if( justifi2 == '' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Justificación del área requirente.',
            showConfirmButton: true,
        });
    }else if(obOpera == '' || obOpera == 0){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar un Objetivo Operativo',
            showConfirmButton: true,
        });

    }else if(actOpera == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar la Actividad Operativa',
            showConfirmButton: true,
        });

    }else if(subActi == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar la Sub Actividad',
            showConfirmButton: true,
        });

    }else if(id_item_dir == '0'){
       Swal.fire({
       icon: 'warning',
       type:  'warning',
       title: 'CoreInspi',
       text: 'Debe seleccionar el Item Presupuestario.',
       showConfirmButton: true,
    });

   }else if(unidad_ejecutora == '0'){
    Swal.fire({
        icon: 'warning',
        type:  'warning',
        title: 'CoreInspi',
        text: 'Debe seleccionar una unidad ejecutora',
        showConfirmButton: true,
    });
    }else if(programa == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar un programa',
            showConfirmButton: true,
        });
    }else if(proyecto == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar un proyecto',
            showConfirmButton: true,
        });
    }else if(actividad == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar una actividad',
            showConfirmButton: true,
        });
    }else if(fuente_financiamiento == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar una fuente de financiamiento',
            showConfirmButton: true,
        });
    }else{
        $.ajax({
            type: 'POST',
            url: '/planificacion/guardarNuevaActividad',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                coordina:         coordina,
                fecha:            fecha,
                poa:              poa,
                obOpera:          obOpera,
                actOpera:         actOpera,
                subActi:          subActi,
                item_presupuestario: item_presupuestario,
                monDisp:          monDisp,
                unidad_ejecutora: unidad_ejecutora,
                programa:         programa,
                proyecto:         proyecto,
                actividad:        actividad,
                fuente_financiamiento: fuente_financiamiento,
                desItem:          desItem,
                plurianual:       plurianual ? 1 : 0,
                justifi2 :        justifi2,
                id_reforma:       id_reforma,
                proceso   :       proceso,
                id_item_dir:      id_item_dir,
            },
            success: function(response) {
                if (response.success) {
                    agregarFilaTabla(response.actividad);
                    $('#formularioActividad').hide();
                    limpiarFormulario();
                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'CoreInspi',
                        text: 'Actividad guardada correctamente',
                    });
                $('#contenedorBotonAgregarActividad').show();
                } else {
                    Swal.fire({
                        icon:  'error',
                        title: 'CoreInspi',
                        type:  'error',
                        text: 'No se pudo guardar la actividad: ' + response.message,
                    });
                }
            },
            // error: function(error) {
            //     console.error('Error:', error);
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Ocurrió un error al guardar la actividad: ' + error.responseJSON.message,
            //     });
            // }
        });
    }
}

function agregarFilaTabla(actividad) {

    let id_direccion = $('#id_direccion').val();

    var nuevaFila = `
        <tr>
            <input type="hidden" name="id_actividad[]" value="${actividad.id}">
            <input type="hidden" name="solicitud[]" value="${( actividad.id_area_soli == id_direccion ? 'true' : 'false')}">
            <input type="hidden" name="id_area_soli[]" value="${actividad.id_area_soli}">
            <input type="hidden" name="id_poa[]" value="${actividad.id_poa}">
            <td class="d-flex justify-content-center align-items-center">
                <i type="button" class="font-22 fadeIn animated bi bi-trash text-danger" title="Eliminar actividad" onclick="eliminarFila(this)">
            </i>
            </td>
            <td>${actividad.nombreActividadOperativa}</td>
            <td>
                <input class ="form-control" style="width: 350px;" type="text" name="subActividad[]" value="${(actividad.nombreSubActividad)}">
            </td>
            <td>${actividad.nombreItem}</td>
            <td>${actividad.descripcionItem}</td>
            <td class="width">
                <select class="form-control" name="tipo[]" onchange="cambioSelect(this)">
                    <option value="">Seleccionar tipo...</option>
                    <option value="DISMINUYE">Disminuye</option>
                    <option value="AUMENTA" selected>Aumenta</option>
                    <option value="IGUAL">Igual</option>
                    <option value="AJUSTE">Ajuste</option>
                    <option value="AMPLIA">Amplia</option>
                </select>
            </td>
            <td><input class="form-control" style="width: 125px;" type="text" name="enero1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="febrero1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="marzo1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="abril1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="mayo1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="junio1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="julio1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="agosto1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="septiembre1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="octubre1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="noviembre1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="diciembre1[]" value="0"></td>
            <td><input class="form-control" style="width: 125px;" type="text" name="total1[]" value="0"></td>
        </tr>
    `;
    $('#tblActividadesEditar tbody').append(nuevaFila);
}

function limpiarFormulario() {
    //$('#coordina').val('');
    //$('#fecha').val('');
    $('#poa').val('');
    $('#obOpera').val('');
    $('#actOpera').val('');
    $('#subActi').val('');
    $('#item_presupuestario').val('');
    $('#monDisp').val('');
    $('#desItem').val('');
    $('#plurianual').prop('checked', false);
    //$('#unidad_ejecutora').val('');
    //$('#programa').val('');
    //$('#proyecto').val('');
    //$('#actividad').val('');
    //$('#fuente').val('');
    //$('#justifi').val('');
}

function fetchItemData(itemId) {
    $.ajax({
        type: 'GET',
        url: '/planificacion/obtenerDatosItem/' + itemId,
        success: function(response) {
            // Rellenar los campos con los datos obtenidos
            $('#monDisp').val(response.monto);
            $('#desItem').val(response.descripcion);
        },
        error: function(error) {
            console.error('Error al obtener datos del item: ', error);
        }
    });
}

function cerrarFormulario() {
    $('#formularioActividad').hide();
    formularioVisible = false;
    limpiarFormulario();
    $('#contenedorBotonAgregarActividad').show();
}

// function validarCampos() {
//     let valido = true;
//     let comentario = '';

//     $('table tbody tr').each(function(index) {
//         let tipo = $(this).find('select[name="tipo[]"]').val();
//         let total = $(this).find('input[name="total1[]"]').val();

//         if (tipo === "" || total === "" || isNaN(parseFloat(total))) {
//             valido = false;
//             comentario = 'Hay campos incompletos o inválidos en la fila ' + (index + 1);
//             return false;
//         }
//     });

//     let justificacion = $('#justificacion').val();
//     if (justificacion.trim() === "") {
//         valido = false;
//         comentario = 'La justificación no puede estar vacía';
//     }

//     if (!valido) {
//         Swal.fire({
//             icon: 'warning',
//             title: 'Error de validación',
//             text: comentario,
//             showConfirmButton: true
//         });
//     }

//     return valido;
// }


/*
function agregarUnidad(){
    // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
    $.ajax({
        type: 'GET', // O el método que estés utilizando en tu ruta
        url: '/planificacion/get_unidad', // Ruta en tu servidor para obtener las opciones
        success: function(data) {
            var unidadSelect = $('#unidad_ejecutora');
            unidadSelect.empty(); // Limpia las opciones actuales

            unidadSelect.append($('<option>', {
                value: 0,
                text: 'Seleccione una unidad ejecutora'
            }));

            // Agrega las nuevas opciones basadas en la respuesta del servidor
            $.each(data.valores, function(index, unidad) {
                unidadSelect.append($('<option>', {
                    value: unidad.id,
                    text:  unidad.nombre+' - '+unidad.descripcion
                }));
            });
        },
        error: function(error) {
            console.error('Error al obtener opciones de la unidad ejecutora', error);
        }
    });
}
*/


function cambioSelect(selectElement) {
    // Obtener la fila donde se encuentra el select que cambió
    var row = selectElement.closest('tr');
    
    // Obtener todos los inputs de la fila, excepto el último (el total)
    var inputs = row.querySelectorAll('input[type="text"]');
    
    if(selectElement.value !== ''){
        // Verificar si la opción seleccionada es "DISMINUYE"
        if (selectElement.value === 'DISMINUYE') {
            // Recorrer cada input en la fila
            inputs.forEach(function(input, index) {
                // Obtener el valor del div que sigue al input
                var formText = input.nextElementSibling;
                if (formText && formText.classList.contains('form-text')) {
                    var value = parseFloat(formText.textContent.trim());
                    // Si el valor es diferente de 0.00, habilitar el input
                    if (value !== 0.00 && index < inputs.length - 1) {
                        input.removeAttribute('disabled');
                    } else if (index < inputs.length - 1) {
                        // Si es 0.00 y no es el último input, deshabilitarlo
                        input.setAttribute('disabled', 'disabled');
                    }
                }
            });
        }if(selectElement.value === 'IGUAL'){

            inputs.forEach(function(input, index) {
                if(index !== 0){
                    input.value = '0.00';
                    input.setAttribute('disabled', 'disabled');
                }
            });

        } else {
            // Si no es "DISMINUYE", deshabilitar todos los inputs en la fila excepto el último
            inputs.forEach(function(input, index) {
                if (index < inputs.length - 1) {
                    //input.setAttribute('disabled', 'disabled');
                    input.removeAttribute('disabled');
                }
            });
        }
    }


}



// ================================FORMULARIO PARA AGREGAR ACTIVIDAD POR ÁREA===================================

let formularioActVisible = false;

function mostrarFormActArea() {
    $('#formularioActArea').show();
    $('#contenedorBotonAgregarActividad').hide(); // Oculta el contenedor del botón
}

function cerrarFormularioAct() {
    $('#formularioActArea').hide();
    formularioActVisible = false;
    limpiarTblAct();
    $('#contenedorBotonAgregarActividad').show();
}

function limpiarTblAct() {
    $('#czonal').val('0');
    $('#area').val('0');
    $('#tblActArea').hide();

}


/*
//Función para filtrar por área dependiendo de la coordinación zonal
$(document).on('change', '#czonal', function(){
    var czonal_id = $(this).val();
    // var url = $(this).data('url');

    $.ajax({
        type: 'GET', // O el método que estés utilizando en tu ruta
        url: '/planificacion/getAreas/' + czonal_id, // Ruta en tu servidor para obtener las opciones
        success: function(data) {
            var areaSelect = $('#area');
            areaSelect.empty(); // Limpia las opciones actuales

            areaSelect.append($('<option>', {
                value: 0,
                text: 'Seleccione el area'
            }));

            // Agrega las nuevas opciones basadas en la respuesta del servidor
            $.each(data, function(index, area) {
                areaSelect.append($('<option>', {
                    value: area.id,
                    text:  area.nombre
                }));
            });
        },
        error: function(error) {
            console.error('Error al obtener el área', error);
        }
    });

});
*/


//Función para filtrar actividades por área
$( function () {

    $('#area').on('change', function() {
        var area_id = $(this).val(); //Obtiene el ID del area seleccionada


        if (area_id == 0) {
            // Si no se ha seleccionado un área, ocultar la tabla
            $('#tblActArea').hide();
            return;
        }

        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/TblActArea', // Ruta en tu servidor para obtener los datos de la tabla
            data: { id: area_id },
            success: function(datos) {

                var data = datos.data;
                var actividades = datos.actividades;

                var tableBody = $('#tblActArea tbody');
                tableBody.empty(); // Limpia las filas actuales

                // Agrega nuevas filas basadas en la respuesta del servidor
                $.each(data, function(index, actividadArea) {
                    tableBody.append(
                        '<tr>' +
                        '<input type="hidden" name="id_poa[]" value="' + actividadArea.id + '">' +
                        '<td><i type="button" class="font-22 fadeIn animated bi bi-plus-square" title="Agregar actividad" onclick="CrearActArea(this)"></i></td>' +
                        '<td>' + actividadArea.departamento + '</td>' +
                        '<td>' + actividadArea.nombreActividadOperativa + '</td>' +
                        '<td>' + actividadArea.nombreSubActividad + '</td>' +
                        '<td>' + actividadArea.nombreItem + '</td>' +
                        '<td>' + actividadArea.descripcionItem + '</td>' +
                        '<td>' + actividadArea.monto + '</td>' +
                        '</tr>'
                    );
                });
                // Mostrar la tabla
                $('#tblActArea').show();
                //$('#contenedorBotonAgregarActividad').show();


                // ========== para pintar el select
                var select = $("#selectActivi"); // Referencia al select
                select.empty(); // Limpiamos el select antes de agregar opciones
                select.append('<option value="">Seleccione una actividad</option>'); // Opción por defecto
            
                // Recorremos las actividades y las agregamos al select
                actividades.forEach(function(actividad) {
                    select.append('<option value="' + actividad.id + '">' + actividad.nombreSubActividad + '</option>');
                });
            
                // Si estás usando select2, vuelve a inicializarlo
                select.trigger('change'); 
                
                
            },
            error: function(error) {
                console.error('Error al obtener los datos de la tabla', error);
            }
        });
    });


    $('#selectActivi').on('change', function() {

        var id_sub  = $(this).val(); 
        var area_id = $('#area').val();

        if (area_id == 0) {
            // Si no se ha seleccionado un área, ocultar la tabla
            $('#tblActArea').hide();
            return;
        }

        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/TblActArea', // Ruta en tu servidor para obtener los datos de la tabla
            data: { id: area_id, id_sub: id_sub },
            success: function(datos) {

                var data = datos.data;

                var tableBody = $('#tblActArea tbody');
                tableBody.empty(); // Limpia las filas actuales

                // Agrega nuevas filas basadas en la respuesta del servidor
                $.each(data, function(index, actividadArea) {
                    tableBody.append(
                        '<tr>' +
                            '<input type="hidden" name="id_poa[]" value="' + actividadArea.id + '">' +
                            '<td><i type="button" class="font-22 fadeIn animated bi bi-plus-square" title="Agregar actividad" onclick="CrearActArea(this)"></i></td>' +
                            '<td>' + actividadArea.departamento + '</td>' +
                            '<td>' + actividadArea.nombreActividadOperativa + '</td>' +
                            '<td>' + actividadArea.nombreSubActividad + '</td>' +
                            '<td>' + actividadArea.nombreItem + '</td>' +
                            '<td>' + actividadArea.descripcionItem + '</td>' +
                            '<td>' + actividadArea.monto + '</td>' +
                        '</tr>'
                    );
                });
                // Mostrar la tabla
                $('#tblActArea').show();

            },
            error: function(error) {
                console.error('Error al obtener los datos de la tabla', error);
            }
        });
    });


});


function CrearActArea(element){
    // Encuentra la fila de la tabla que contiene el botón que se ha clicado
    let fila = $(element).closest('tr');

    // Obtén el ID de la actividad (POA) desde el input oculto
    let id_poa = fila.find('input[name="id_poa[]"]').val();

    let id_reforma = $('#id_reforma').val();


    $.ajax({
        type: 'POST',
        url: '/planificacion/crearActArea',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 
            id_poa: id_poa, 
            id_reforma: id_reforma 
        }, // Incluye id_reforma si es necesario
        
        success: function(response) {
            if (response.success) {

                console.log(response.poa); // Muestra el objeto Poa en la consola
                agregarActAreaFila(response.actividadPoa);
                //$('#formularioActArea').hide();
                // limpiarFormulario();
                Swal.fire({
                    icon: 'success',
                    type: 'success',
                    title: 'CoreInspi',
                    text: 'Actividad agregada correctamente',
                });

                // ====== PINTAR LA FILA SELECCIONADA ======
                fila.addClass('fila-seleccionada');

            // $('#contenedorBotonAgregarActividad').show();
            } else {
                Swal.fire({
                    icon:  'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text: 'No se pudo guardar la actividad: ' + response.message,
                });
            }
        },

    });
}


function agregarActAreaFila(actividadPoa) {

    let id_direccion = $('#id_direccion').val();

    var nuevaFila =`
        <tr>
            <input type="hidden" name="id_actividad[]" value="${(actividadPoa.id)}">
            <input type="hidden" name="solicitud[]" value="${( actividadPoa.id_areaS == id_direccion ? 'true' : 'false')}">
            <input type="hidden" name="id_area_soli[]" value="${(actividadPoa.id_areaS)}">
            <input type="hidden" name="id_poa[]" value="${(actividadPoa.id_poa)}">
            <td class="d-flex justify-content-center align-items-center">
                <i type="button" class="font-22 fadeIn animated bi bi-trash text-danger" title="Eliminar actividad" onclick="eliminarFila(this)">
            </td>
            <td>${(actividadPoa.nombreActividadOperativa)}</td>
            <td>
                <input class ="form-control" style="width: 350px;" type="text" name="subActividad[]" value="${(actividadPoa.nombreSubActividad)}">
            </td>
            <td>${(actividadPoa.nombreItem)}</td>
            <td>${(actividadPoa.descripcionItem)}</td>
            <td class="width">
                <select class="form-control" name="tipo[]" onchange="cambioSelect(this)">
                    <option value="" selected disabled>Seleccionar tipo...</option>
                    <option value="DISMINUYE">Disminuye</option>
                    <option value="AUMENTA">Aumenta</option>
                    <option value="IGUAL">Igual</option>
                    <option value="AJUSTE">Ajuste</option>
                    <option value="AMPLIA">Amplia</option>
                </select>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="enero1[]" value="0">
                <div class="form-text">${actividadPoa.enero}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="febrero1[]" value="0">
                <div class="form-text">${actividadPoa.febrero}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="marzo1[]" value="0">
                <div class="form-text">${actividadPoa.marzo}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="abril1[]" value="0">
                <div class="form-text">${actividadPoa.abril}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="mayo1[]" value="0">
                <div class="form-text">${actividadPoa.mayo}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="junio1[]" value="0">
                <div class="form-text">${actividadPoa.junio}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="julio1[]" value="0">
                <div class="form-text">${actividadPoa.julio}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="agosto1[]" value="0">
                <div class="form-text">${actividadPoa.agosto}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="septiembre1[]" value="0">
                <div class="form-text">${actividadPoa.septiembre}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="octubre1[]" value="0">
                <div class="form-text">${actividadPoa.octubre}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="noviembre1[]" value="0">
                <div class="form-text">${actividadPoa.noviembre}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="diciembre1[]" value="0">
                <div class="form-text">${actividadPoa.diciembre}</div></td>
            </td>
            <td>
                <input class ="form-control" style="width: 125px;" type="text" name="total1[]" value="0.00">
                <div class="form-text">${actividadPoa.total}</div></td>
            </td>
        </tr>`
    ;
    $('#tblActividadesEditar tbody').append(nuevaFila);

    cerrarFormularioActividad();

}


function agregarEstructura(){

    let id_fuente = $('#id_fuente').val();

    if(id_fuente != 0 || id_fuente != ''){

        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/itemPresupuestario/get_estructura/'+id_fuente, // Ruta en tu servidor para obtener las opciones
            success: function(response) {
    
                if (response.success) {
                    let data        = response.data;
                    let programas   = response.programa;
                    let proyectos   = response.proyecto;
                    let actividades = response.actividadPre;
                    let fuentes     = response.fuente;
                    let unidad      = response.unidad;
    
                    //$('#unidad_ejecutora').val(data.id_unidad);
                    $('#unidad_ejecutora').empty();
                    unidad.forEach(programa => {
                        $('#unidad_ejecutora').append(
                            `<option value="${programa.id}" ${programa.id == data.id_uni ? 'selected' : ''}>
                                ${programa.nombre} - ${programa.descripcion}
                            </option>`
                        );

                        //programa.id == data.id_unidad ? alert('Funciona') : '';

                    });
    
                    // Cargar y seleccionar el valor en Programa
                    $('#programa').empty();
                    programas.forEach(programa => {
                        $('#programa').append(
                            `<option value="${programa.id}" ${programa.id == data.id_programa ? 'selected' : ''}>
                                ${programa.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Proyecto
                    $('#proyecto').empty();
                    proyectos.forEach(proyecto => {
                        $('#proyecto').append(
                            `<option value="${proyecto.id}" ${proyecto.id == data.id_proyecto ? 'selected' : ''}>
                                ${proyecto.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Actividad
                    $('#actividad').empty();
                    actividades.forEach(actividad => {
                        $('#actividad').append(
                            `<option value="${actividad.id}" ${actividad.id == data.id_actividad ? 'selected' : ''}>
                                ${actividad.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Fuente
                    $('#fuente_financiamiento').empty();
                    fuentes.forEach(fuente => {
                        $('#fuente_financiamiento').append(
                            `<option value="${fuente.id}" ${fuente.id == data.id_fuente ? 'selected' : ''}>
                                ${fuente.nombre}
                            </option>`
                        );
                    });
                }
    
    
            },
            error: function(error) {
                console.error('Error al obtener opciones de la unidad ejecutora', error);
            }
        });

    }

}

// calcula los totales y los muestra en los inputs
function actualizarTotales() {
    let totalAumenta = 0;
    let totalDisminuye = 0;
    let totalAjuste  = 0;
    let totalAmplia  = 0;

    // Seleccionar solo las filas visibles
    $('#tblActividadesEditar tbody tr:visible').each(function() {
        let $fila = $(this);
        let tipo = $fila.find('select[name="tipo[]"]').val();
        let totalFila = 0;

        // Sumar valores de los meses
        $fila.find('input[name^="enero"], input[name^="febrero"], input[name^="marzo"], input[name^="abril"], input[name^="mayo"], input[name^="junio"], input[name^="julio"], input[name^="agosto"], input[name^="septiembre"], input[name^="octubre"], input[name^="noviembre"], input[name^="diciembre"]').each(function() {
            let valor = parseFloat($(this).val()) || 0;
            totalFila += valor;
        });

        // Sumar al total correspondiente solo si la fila está visible
        if (tipo === 'AUMENTA') {
            totalAumenta += totalFila;
        } else if (tipo === 'DISMINUYE') {
            totalDisminuye += totalFila;
        } else if (tipo === 'AJUSTE') {
            totalAjuste += totalFila;
        }else if (tipo === 'AMPLIA') {
            totalAmplia += totalFila;
        }

    });

    // Actualizar los totales en los inputs
    $('#aumTotal').val(totalAumenta);
    $('#disTotal').val(totalDisminuye);
    $('#ajuTotal').val(totalAjuste);
    $('#ampTotal').val(totalAmplia);
}