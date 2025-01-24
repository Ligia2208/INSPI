$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblReformaIndex').DataTable({ //id de la tabla en el visual (index)
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion/reformaPrincipal', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nro_solicitud',        name: 'nro_solicitud' },
            { data: 'area',        name: 'area' },
            { data: 'justificacion',   name: 'justificacion' },
            { data: 'fecha',         name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                    var array = "";

                    if(full.estado == 'A' ){
                        array = '<div class="text-center"><span class="badge badge-primary text-bg-primary">Ingresado</span><div>';
                    }else if(full.estado == 'O'){
                        array = '<div class="text-center"><span class="badge badge-success text-bg-success">Validado</span>';
                    }else if(full.estado == 'V'){
                        array = '<div class="text-center"><span class="badge badge-secondary text-bg-secondary">Aprobado</span>';
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

                    if(full.estado == 'O' ){
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                            <a id="btnValidarReforma" data-id_reforma="${full.id_reforma}" data-estado="${full.estado}" title="Validar Reforma" class="show-tooltip mr-1" data-title="Validar Reforma">
                                <i class="font-22 bi bi-layer-backward text-warning"></i>
                            </a>

                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                        </div>
                        `;
                    }else if(full.estado == 'V' ){
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>

                            <a id="btnPDF_POA" data-id_POA="${full.id}" title="PDF POA" class="text-secondary show-tooltip" data-title="PDF POA">
                                <i class="font-22 bi bi-filetype-pdf"></i>
                            </a>
                        </div>
                        `;
                    }else if(full.estado == 'R'){
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                        </div>
                        `;
                    }else{
                        array =`
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>        
                            <a id="btnRevisarReforma" data-id_editar="${full.id_reforma}" data-nombre="${full.nombre}" title="Revisión" class="show-tooltip mr-1" data-title="Revisión">
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


    /* VALIDAR LOS CAMBIOS EN LA REFORMA */
    $(document).on('click', '#btnValidarReforma', function(){

        var id_reforma = $(this).data('id_reforma');
        var estado     = $(this).data('estado');

        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'CoreInspi',
            text: 'Seguro que quiere aplicar los cambios de la reforma a la planificación?',
            showConfirmButton: true,
            confirmButtonText: 'Sí, aplicar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'PUT',
                    url: '/planificacion/actualizarCalendarioPoa',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id_reforma:    id_reforma,
                        estadoReforma: estado,
                        justificacion: 'La reforma fue aplicada a la planificación',
                    }, 
                    cache: false,
                    success: function(res){
        
                        if(res.valor){

                            table.ajax.reload();

                            Swal.fire({
                                icon: 'success',
                                title: 'CoreInspi',
                                type: 'success',
                                text: res.message,
                                showConfirmButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Aceptar',
                                timer: 2500
                            });
                            
        
                        }else{
        
                            Swal.fire({
                                icon: 'error',
                                title: 'CoreInspi',
                                type: 'error',
                                text: res.message,
                                showConfirmButton: true,
                                confirmButtonText: 'Aceptar',
                                timer: 3500
                            });
        
                        }
        
                    }
        
                });

            }
        });

    });
    /* VALIDAR LOS CAMBIOS EN LA REFORMA */
    



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
    $(document).on('click', '#btnRevisarReforma', function(){
        let id_reforma = $(this).data('id_editar');

        window.location.href = '/planificacion/revisionReforma/'+ id_reforma;

    });
    /* CARGAR REGISTRO */
})


//========================================================================================================


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