//variables globales

var contPregunta = 1;
var contOpciones = 0;

$( function () {





});



function guardar(){

    var usuarios        = document.getElementById("usuarios").value;
    var laboratorio_id  = document.getElementById("laboratorio_id").value;
    var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;

    if(usuarios == '0'){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar un usuario.',
            showConfirmButton: true,
        });

    }else {

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/saveUsuarioPre',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'usuarios':        usuarios,
                'laboratorio_id':  laboratorio_id,
                'tipoencuesta_id': tipoencuesta_id,
            },
            success: function(response) {

                //console.log(response.data['id_chat'])
                if(response.data){

                    Swal.fire({
                        icon: 'success',
                        type:  'success',
                        title: 'SoftInspi',
                        text: response['message'],
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = '/encuestas/listarEncuesta';
                        }
                    });

                    //se recarga la lista de usuarios

                    var usuariosLabHTML = '';
                    if (response.usuariosLab.length > 0) {
                        response.usuariosLab.forEach(function(usuario) {

                            usuariosLabHTML += `
                                <li class="list-group-item mb-2">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            ${usuario.nombre}
                                        </div>
                                        <div class="col-lg-3">
                                            <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                                <span class="lni lni-close"></span>
                                            </a>
                                        </div>
                                    </div>
                                </li> `;

                        });
                    } else {
                        usuariosLabHTML += '<li class="list-group-item mb-2">Aun no hay usuarios para este laboratorio</li>';
                    }
                    $('.list-group').html(usuariosLabHTML);


                }else{

                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:   response['message'],
                        showConfirmButton: true,
                    });

                }

            },
            error: function(error) {

                Swal.fire({
                    icon:  'success',
                    title: 'SoftInspi',
                    type:  'success',
                    text:   error,
                    showConfirmButton: true,
                });

                //console.error('Error al enviar el mensaje', error);
                //$('#send-message, #message').prop('disabled', false);
            }
        });

    }


}


function deleteUser(usuario_id, laboratorio_id, id_labusu){


    Swal.fire({
        title: 'SoftInspi',
        text: 'Seguro que quieres eliminar este usuario?.',
        icon: 'warning',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((resultado) => {
        if (resultado.value) {

            $.ajax({

                type: 'POST',
                //url: '{{ route("encuesta.saveEncuesta") }}',
                url: '/encuestas/deleteUsuarioPre',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'usuario_id':     usuario_id,
                    'laboratorio_id': laboratorio_id,
                    'id_labusu':      id_labusu,
                },
                success: function(response) {

                    //console.log(response.data['id_chat'])
                    if(response.data){

                        Swal.fire({
                            icon: 'success',
                            type:  'success',
                            title: 'SoftInspi',
                            text: response['message'],
                            showConfirmButton: true,
                        })/* .then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                window.location.href = '/encuestas/listarEncuesta';
                            }
                        }) */;

                        //se recarga la lista de usuarios

                        var usuariosLabHTML = '';
                        if (response.usuariosLab.length > 0) {
                            response.usuariosLab.forEach(function(usuario) {

                                usuariosLabHTML += `
                                    <li class="list-group-item mb-2">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                ${usuario.nombre}
                                            </div>
                                            <div class="col-lg-3">
                                                <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                                    <span class="lni lni-close"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </li> `;

                            });
                        } else {
                            usuariosLabHTML += '<li class="list-group-item mb-2">Aun no hay usuarios para este laboratorio</li>';
                        }
                        $('.list-group').html(usuariosLabHTML);


                    }else{

                        Swal.fire({
                            icon:  'error',
                            title: 'SoftInspi',
                            type:  'error',
                            text:   response['message'],
                            showConfirmButton: true,
                        });

                    }

                },
                error: function(error) {

                    Swal.fire({
                        icon:  'success',
                        title: 'SoftInspi',
                        type:  'success',
                        text:   error,
                        showConfirmButton: true,
                    });

                    //console.error('Error al enviar el mensaje', error);
                    //$('#send-message, #message').prop('disabled', false);
                }
            });

        }
    });

}
