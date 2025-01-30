$( function () {

    $('.js-example-basic-single').select2({
        width: '100%',
    });

    var table = $('#tblPlanificacionIndex').DataTable({
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion',
            data: function (d) {
                d.estado = $('#filterEstado').val();
                d.direccion = $('#filterDireccion').val();
                d.item = $('#filterItem').val();
            }
        },
        columns: [
            { data: 'coordinacion', name: 'coordinacion' },
            { data: 'item', name: 'item' },
            { data: 'obj_operativo', name: 'obj_operativo' },
            { data: 'act_operativa', name: 'act_operativa' },
            { data: 'sub_actividad', name: 'sub_actividad' },
            { data: 'proceso', name: 'proceso' },
            { data: 'monto', name: 'monto', render: $.fn.dataTable.render.number(',', '.', 2, '$') }, // Formato con separadores
            { data: 'fecha', name: 'fecha' },
            {
                data: 'estado',
                render: function (data, type, full, meta) {
                    let badgeClass = {
                        'A': 'badge-primary text-bg-primary',
                        'O': 'badge-success text-bg-success',
                        'R': 'badge-warning text-bg-warning',
                        'C': 'badge-info text-bg-info',
                        'S': 'badge-info text-bg-info'
                    }[data] || 'badge-secondary';
    
                    let estadoBadge = {
                        'A': 'Registrado',
                        'O': 'Aprobado',
                        'R': 'Rechazado',
                        'C': 'Corregido',
                        'S': 'Solicitado'
                    }[data] || 'badge-secondary';
    
                    return `<div class='center'><span class='badge ${badgeClass}'>${estadoBadge}</span></div>`;
                }
            },
            {
                data: null,
                searchable: false,
                render: function (data, type, full, meta) {
                    var array = "";
                    if (full.estado == 'O') {
                        array = `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnVisualizaPOA" data-id_editar="${full.id}" title="Editar registro" class="show-tooltip mr-1">
                                <i class="font-22 fadeIn animated bi bi-eye" style="color:black"></i>
                            </a>
                        </div>`;
                    } else if (full.estado == 'R') {
                        array = `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                        </div>`;
                    } else {
                        array = `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnEditarPlan" data-id_editar="${full.id}" title="Revisión" class="show-tooltip">
                                <i class="font-22 fadeIn animated bi bi-pen"></i>
                            </a>
                        </div>`;
                    }
                    return array;
                }
            },
        ],
        order: [[6, 'desc']],
        language: {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
    
        // Función para sumar los montos en el footer
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            var total = api
                .column(6, { page: 'current' }) // Seleccionar la columna de montos
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
    
            // Actualizar el pie de tabla
            $(api.column(6).footer()).html('$' + total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
    });
    
    // **Actualizar la tabla cuando cambien los filtros**
    $('#filterEstado, #filterDireccion, #filterItem').on('change', function () {
        table.ajax.reload();
    });
    

});

//------------------------------------------------------------------------------------------------

//CÓDIGO PARA REDIRIGIR AL FORMULARIO PARA ACEPTAR/RECHAZAR POA
$(function(){
    /* VALIDAR CERTIFICACION */
    $(document).on('click', '#btnEditarPlan', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/editarEstadoPlanificacion/'+ id_planificacion;

    });
    /* VALIDAR CERTIFICACION */


    /* REDIRECCIONA A LA VISUALIZACION DE LA ACTIVIDAD */
    $(document).on('click', '#btnVisualizaPOA', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/visualizarPlanificacion/'+ id_planificacion;

    });
    /* REDIRECCIONA A LA VISUALIZACION DE LA ACTIVIDAD */

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

$(document).on('click', '#btnGeneratePDF', function(){

    let id_poa = $(this).data('id_poa');

    $('#id_poa').val(id_poa);

    document.getElementById('btnModalReportPOA').click();

});

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
        var yearSelected = $('#yearSelect').val();

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
                    elabora: elaboraSelect,
                    revisa: revisaSelect,
                    aprueba: apruebaSelect,
                    cargo_elabora: cargo_elabora,
                    cargo_revisa: cargo_revisa,
                    cargo_aprueba: cargo_aprueba,
                    year: yearSelected
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_anual_' + yearSelected + '.pdf';
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
                        text: 'Error al generar el PDF',
                        showConfirmButton: true,
                    });
                }
            });
        }
    });
});
