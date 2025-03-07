$( function () {

    populateYearSelect(2020);

    $('.basic-single').select2({
        width: '100%',
    });


    var table = $('#tblPlanificacionDetalle').DataTable({
        processing: false,
        serverSide: false,
        lengthMenu: [15, 25, 50, 100],
        ajax: {
            url: '/planificacion/detalle',
            data: function (d) {
                d.anio = $('#filterAnio').val();
                d.direccion = $('#filterDireccion').val();
                d.item = $('#filterItem').val();
                d.sub_actividad = $('#filterSubActividad').val();
                d.unidad = $('#filterUnidad').val();
            }
        },
        columns: [
            { data: 'Area', name: 'Area' },

            { data: 'u_ejecutora', name: 'u_ejecutora' },
            { data: 'programa',    name: 'programa' },
            { data: 'proyecto',    name: 'proyecto' },
            { data: 'actividad',   name: 'actividad' },
            { data: 'fuente',      name: 'fuente' },

            { data: 'proceso',     name: 'proceso' },
            { data: 'obj_operativo', name: 'obj_operativo' },
            { data: 'act_operativa', name: 'act_operativa' },
            { data: 'sub_actividad', name: 'sub_actividad' },

            { data: 'item', name: 'item' },
            { data: 'monto_item', name: 'monto_item' },

            { data: 'monto', name: 'monto' },
            { data: 'enero', name: 'enero' },
            { data: 'febrero', name: 'febrero' },
            { data: 'marzo', name: 'marzo' },
            { data: 'abril', name: 'abril' },
            { data: 'mayo', name: 'mayo' },
            { data: 'junio', name: 'junio' },
            { data: 'julio', name: 'julio' },
            { data: 'agosto', name: 'agosto' },
            { data: 'septiembre', name: 'septiembre' },
            { data: 'octubre', name: 'octubre' },
            { data: 'noviembre', name: 'noviembre' },
            { data: 'diciembre', name: 'diciembre' },
            
            {
                data: null,
                render: function (data, type, full, meta) {
                    return `
                        <div class="action-buttons">
                            <a id="btnEditarPlan" data-id_editar="${full.id}" href="javascript:void(0);">
                                <i class="bx bx-edit"></i>
                            </a>
                        </div>`;
                }
            },
        ],
        order: [[0, 'desc']],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
    
            // Función para sumar valores de una columna
            var intVal = function (i) {
                return typeof i === 'string' ? 
                    parseFloat(i.replace(/[\$,]/g, '')) : 
                    typeof i === 'number' ? i : 0;
            };
    
            // Sumar columnas de enero a diciembre
            for (let col = 12; col <= 24; col++) { // Índices de columnas de enero a diciembre
                let total = api
                    .column(col, { page: 'current' }) // Solo suma los valores visibles en la página actual
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
    
                // Actualizar el pie de la tabla con los totales
                $(api.column(col).footer()).html(total.toFixed(2));
            }
        },
        language: { /* Opciones de idioma */ },
    });
    

    // Recargar tabla al cambiar filtros
    $('.filter').on('change', function () {
        table.ajax.reload();
    });


});

//------------------------------------------------------------------------------------------------

//CÓDIGO PARA REDIRIGIR AL FORMULARIO PARA ACEPTAR/RECHAZAR POA
$(function(){
    /* CARGAR REGISTRO */
    $(document).on('click', '#btnEditarPlan', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/editarEstadoPlanificacion/'+ id_planificacion;

    });
    /* CARGAR REGISTRO */
})


//------------------------------------------------------------------------------------------------

//CÓDIGO PARA BOTÓN DE BORRAR
$(function(){
    $(document).on('click', '#btnEliminarPOA', function(){
        //alert('funciona');

        let id_POA = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Seguro quiere eliminar este registro.',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/planificacion/deletePoa',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_POA,
                    },
                    success: function(response) {

                        //console.log(response.data['id_chat'])
                        if(response.data){

                            if(response['data'] == true){
                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                }).then((result) => {
                                    if (result.value == true) {
                                        table.ajax.reload(); //actualiza la tabla
                                    }
                                });

                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'CoreInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
                                });
                            }
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            icon:  'success',
                            title: 'CoreInspi',
                            type:  'success',
                            text:   error,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });

    });

    var table = $('#tblPlanificacionIndex').DataTable();


})

//------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------

//CÓDIGO PARA MOSTRAR COMENTARIOS
$(function(){

    $(document).on('click','#btnComentarios', function(){

        let id_Poa = $(this).data('id_comentario');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/planificacion/obtenerComentarios/' + id_Poa,
            data: {
                _token: "{{ csrf_token() }}",

            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_poa         = res.poa.id;

                let comentarios    = res.comentarios;
                let created_at     = res.comentarios.created_at;


                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Comentarios del registro ${id_poa}</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                `;

                if (comentarios.length > 0) {
                    // Agregamos cada comentario a la lista dentro del modal
                    comentarios.forEach(function(comentario) {
                        html += `
                        <li class="list-group-item">
                            <strong>Usuario:</strong> ${comentario.id_usuario} <br>
                            <strong>Comentario:</strong> ${comentario.comentario} <br>
                            <strong>Fecha de creación:</strong> ${comentario.fecha} <br>
                            <strong>Estado de la planificación:</strong> ${comentario.estado_planificacion} <br>

                        </li>
                        `;
                    });
                } else {
                    // Mostrar mensaje de que no existen comentarios
                    html += `
                        <li class="list-group-item">
                            No existen comentarios para este registro.
                        </li>
                    `;
                }

                html += `
                                </ul>
                                </div>
                                <div class="modal-footer">
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

    })


         /* CERRAR EL MODAL DE MANERA MANUAL */
        $(document).on('click', '#btnCerrarModalCat, #btnCerrarModalCat2', function() {
        $('#modalComentarios').modal('hide');
        });
        /* CERRAR EL MODAL DE MANERA MANUAL */


})




function populateYearSelect(startYear) {
    var currentYear = new Date().getFullYear();
    var select = document.getElementById('filterAnio');

     for (var year = startYear; year <= currentYear; year++) {
         var option = document.createElement('option');
        option.value = year;
         option.text = year;

        if (year === currentYear) {
            option.selected = true;
        }

        select.appendChild(option);
    }
}



//         select.appendChild(option);
//     }
// }


function actualizarTabla() {

    let anio = $('#yearSelect').val();

    if(anio !== '0'){

        $.ajax({
            url: '/planificacion/detalle',
            type: 'GET',
            data: { anio: anio },
            success: function(data) {
                // Limpiar la tabla
                $('#tblPlanificacionDetalle').DataTable().clear();
                // Agregar los nuevos datos a la tabla
                $('#tblPlanificacionDetalle').DataTable().rows.add(data.data).draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }

}

/*
$(document).on('click', '#btnGeneratePDF', function(){

    let id_poa = $(this).data('id_poa');

    $('#id_poa').val(id_poa);

    document.getElementById('btnModalReportPOA').click();

});
*/

$(document).ready(function() {
    // Manejar clic en el botón para generar PDF
    $(document).on('click', '#btnGeneratePDF', function() {
        document.getElementById('btnModalReportPOA').click();
    });

    // Cerrar el modal y limpiar los campos
    $(document).on('click', '#btnCerrarModalPOA', function() {
        $('#addReportDetalle').modal('hide');

        // Limpiar los campos del formulario
        $('#elabora').val('');
        $('#revisa').val('');
        $('#aprueba').val('');
        $('#cargo_elabora').val('');
        $('#cargo_revisa').val('');
        $('#cargo_aprueba').val('');
    });

    // Generar el reporte PDF
    $(document).on('click', '#btnGenerarReportPOA', function() {
        var elaboraSelect = $('#elabora').val();
        var revisaSelect = $('#revisa').val();
        var apruebaSelect = $('#aprueba').val();
        var cargo_elabora = $('#cargo_elabora').val();
        var cargo_revisa = $('#cargo_revisa').val();
        var cargo_aprueba = $('#cargo_aprueba').val();

        var filterAnio         = $('#filterAnio').val();
        var filterDireccion    = $('#filterDireccion').val();
        var filterItem         = $('#filterItem').val();
        var filterSubActividad = $('#filterSubActividad').val();

        if (elaboraSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (revisaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (apruebaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_elabora == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_revisa == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_aprueba == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else {
            $.ajax({
                type: 'GET',
                url: '/planificacion/reportDetalle',
                data: {
                    elabora:       elaboraSelect,
                    revisa:        revisaSelect,
                    aprueba:       apruebaSelect,
                    cargo_elabora: cargo_elabora,
                    cargo_revisa:  cargo_revisa,
                    cargo_aprueba: cargo_aprueba,
                    //year:          yearSelected,

                    filterAnio         : filterAnio,
                    filterDireccion    : filterDireccion,
                    filterItem         : filterItem,
                    filterSubActividad : filterSubActividad,

                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_anual_' + filterAnio + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    $('#addReportDetalle').modal('hide');
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'CoreInspi',
                        text: 'Error al generar el PDF - La información es muy grande, genere un archivo EXCEL.',
                        showConfirmButton: true,
                    });
                }
            });
        }
    });
    



    // Generar el reporte EXCEL
    $(document).on('click', '#btnGenerateExcel', function() {

        var filterAnio         = $('#filterAnio').val();
        var filterDireccion    = $('#filterDireccion').val();
        var filterItem         = $('#filterItem').val();
        var filterSubActividad = $('#filterSubActividad').val();

        $.ajax({
            type: 'GET',
            url: '/planificacion/reportDetalleExcel',
            data: {
                filterAnio         : filterAnio,
                filterDireccion    : filterDireccion,
                filterItem         : filterItem,
                filterSubActividad : filterSubActividad,
            },
            xhrFields: {
                responseType: 'blob'  // Definir que esperamos una respuesta de tipo blob (archivo)
            },
            success: function(response, status, xhr) {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }); // Tipo para Excel
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_detalle_' + filterAnio + '.xlsx'; // Extensión .xlsx para el archivo Excel
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
                $('#addReportDetalle').modal('hide');
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el archivo Excel.',
                    showConfirmButton: true,
                });
            }
        });

    });

    




});



function prueba() {
    console.log('Funciona');

    let val1 = 0; 
    val1 = parseFloat($('#valor1').val()); 

    let val2 = 0; 
    val2 = parseFloat($('#valor2').val()); 

    alert('Funciona :) y La suma es: ' + (val1 + val2));
}


function prueba2() {
    console.log('Funciona');

    let text1 = $('#text1').val();

    alert('Funciona :D ' + text1);
}



