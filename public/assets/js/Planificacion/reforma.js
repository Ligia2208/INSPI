$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblReformaIndex').DataTable({ //id de la tabla en el visual (index)
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion/reformaIndex', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nro_solicitud',  name: 'nro_solicitud' },
            { data: 'justificacion',  name: 'justificacion' },
            { data: 'total_monto',           name: 'total_monto' },
            { data: 'fecha',          name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                    var array = "";

                    if(full.estado == 'A' ){
                        array = '<div class="text-center"><span class="badge badge-primary text-bg-primary">Ingresado</span><div>';
                    }else if(full.estado == 'V'){
                        array = '<div class="text-center"><span class="badge badge-secondary text-bg-secondary">Aprobado</span>';
                    }else if(full.estado == 'O'){
                        array = '<div class="text-center"><span class="badge badge-success text-bg-success">Validado</span>';
                    }else if(full.estado == 'R'){
                        array = '<div class="text-center"><span class="badge badge-warning text-bg-warning">Rechazado</span>';
                    }else if(full.estado == 'C'){
                        array = '<div class="text-center"><span class="badge badge-info text-bg-info">Corregido</span>';
                    }else{
                        array = '<div class="text-center"><span class="badge badge-warning text-bg-warning">Indefinido</span>';
                    }

                    return array;
                }
            },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                    var array = "";

                    if(full.estado == 'O' || full.estado == 'V' ){
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnPDF_reforma" data-id_reforma="${full.id_reforma}" title="PDF REFORMA" class="show-tooltip" data-title="PDF REFORMA">
                                <i class="font-22 bi bi-filetype-pdf text-primary"></i>
                            </a>
                        </div>
                        `;
                    } else{
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnEditarReforma" data-id_editar="${full.id_reforma}" data-nombre="${full.nombre}" title="Editar reforma" class="show-tooltip mr-1" data-title="Editar reforma">
                                <i class="font-22 fadeIn animated bi bi-pen" ></i>
                            </a>
                            <a id="btnEliminarReforma" data-id_borrar="${full.id_reforma}" title="Eliminar reforma" class="red show-tooltip" data-title="Eliminar reforma">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                        </div>
                        `;
                    }
                    return array;
                }
            },
        ],
        order: [
            [0, 'desc']
        ],

        // Otras configuraciones de DataTables aquí
        language: {
            "emptyTable": "No hay información", //no hay datos disponibles
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior",
                            "showing": "Mostrando"
                        }
        },
    });


    var table = $('#tblReformaIndex').DataTable();

});

//CÓDIGO PARA BOTÓN DE BORRAR
$(function(){
    $(document).on('click', '#btnEliminarReforma', function(){
        //alert('funciona');

        let id_reforma = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: '¿Seguro que quiere eliminar esta reforma?',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/planificacion/deleteReforma',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_reforma,
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
    var table = $('#tblReformaIndex').DataTable();
})


//CÓDIGO PARA REDIRIGIR AL FORMULARIO PARA EDITAR REFORMA
$(function(){
    /* CARGAR REGISTRO */
    $(document).on('click', '#btnEditarReforma', function(){
        let id_reforma = $(this).data('id_editar');

        window.location.href = '/planificacion/editarReforma/'+ id_reforma;

    });
    /* CARGAR REGISTRO */
})

//================================================================================================================

//CÓDIGO PARA MOSTRAR COMENTARIOS
$(function(){

    $(document).on('click','#btnComentarioRef', function(){

        let id_Reforma = $(this).data('id_comentario');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/planificacion/obtenerComentariosReforma/' + id_Reforma,
            data: {
                _token: "{{ csrf_token() }}",

            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_reforma         = res.reforma.id;

                let comentariosRef    = res.comentariosRef;
                let created_at     = res.comentariosRef.created_at;


                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Comentarios del registro ${id_reforma}</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                `;

                if (comentariosRef.length > 0) {
                    // Agregamos cada comentario a la lista dentro del modal
                    comentariosRef.forEach(function(comentario) {
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


$(document).on('click', '#btnPDF_reforma', function(){

    let id_reforma = $(this).data('id_reforma');

    $('#id_reforma').val(id_reforma);
    document.getElementById('btnModalReportReforma').click();

});

/* CERRAR EL MODAL Y LIMPIAR LOS CAMPOSL */
$(document).on('click', '#btnCerrarModalReforma', function() {
    $('#addReportReforma').modal('hide');

    // Limpia los campos del formulario
    $('#creado').val('');
    $('#autorizado').val('');
    $('#reporta').val('');
    $('#areaReq').val('');
    $('#planificacionYG').val('');
    $('#cargo_creado').val('');
    $('#cargo_autorizado').val('');
    $('#cargo_reporta').val('');
    $('#cargo_areaReq').val('');
    $('#cargo_planificacionYG').val('');
});

/* GENERAR REPORTE */
$(document).on('click', '#btnGenerarReportReforma', function(){

    var creadoSelect          = $('#creado').val();
    var autorizadoSelect      = $('#autorizado').val();
    var reportaSelect         = $('#reporta').val();
    var areaReqSelect         = $('#areaReq').val();
    var planificacionYGSelect = $('#planificacionYG').val();
    var id_reforma                = $('#id_reforma').val();

    var cargo_creado          = $('#cargo_creado').val();
    var cargo_autorizado      = $('#cargo_autorizado').val();
    var cargo_reporta         = $('#cargo_reporta').val();
    var cargo_areaReq         = $('#cargo_areaReq').val();
    var cargo_planificacionYG = $('#cargo_planificacionYG').val();

    if(creadoSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que elaboró la planificación',
            showConfirmButton: true,
        });

    }else if(autorizadoSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else if(reportaSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que generó el reporte',
            showConfirmButton: true,
        });

    }else if(areaReqSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que valida la planificación',
            showConfirmButton: true,
        });

    }else if(planificacionYGSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que aprueba la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_creado == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el cargo del usuario que crea la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_autorizado == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el cargo del usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_reporta == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el cargo del usuario que revisó la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_areaReq == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el cargo del usuario que  la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_planificacionYG == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar el usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else{
        $.ajax({
            type: 'GET',
            url: '/planificacion/reportReforma?id_creado=' + creadoSelect +
                '&id_autorizado=' + autorizadoSelect +
                '&id_reporta=' + reportaSelect +
                '&id_areaReq=' + areaReqSelect +
                '&id_planificacionYG=' + planificacionYGSelect +
                '&id_reforma=' + id_reforma,
            data:{
                cargo_creado: cargo_creado,
                cargo_autorizado: cargo_autorizado,
                cargo_reporta: cargo_reporta,
                cargo_areaReq: cargo_areaReq,
                cargo_planificacionYG: cargo_planificacionYG,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_planificacion.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
            },
            error: function(error) {
                Swal.fire({
                    icon:  'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text:   error,
                    showConfirmButton: true,
                });
            }
        });
    }
});
