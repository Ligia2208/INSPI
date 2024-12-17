
$( function () {

    $('#btn_Editar').hide();
    $('#btn_Cancelar').hide();

});



function guardar(){

    var nombreUser   = document.getElementById("nombreUser").value;
    var apellidoUser = document.getElementById("apellidoUser").value;
    var correoUser   = document.getElementById("correoUser").value;
    var hospitalUser = document.getElementById("hospitalUser").value;

    var laboratorio_id  = document.getElementById("laboratorio_id").value;
    var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;

    if(nombreUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un nombre.',
            showConfirmButton: true,
        });

    }else if(apellidoUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un apellido.',
            showConfirmButton: true,
        });

    }else if(correoUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un correo.',
            showConfirmButton: true,
        });

    }else if(hospitalUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un hospital.',
            showConfirmButton: true,
        });

    }else {

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/saveUsuarioNopre',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombreUser':      nombreUser,
                'apellidoUser':    apellidoUser,
                'correoUser':      correoUser,
                'hospitalUser':    hospitalUser,
                'laboratorio_id':  laboratorio_id,
                'tipoencuesta_id': tipoencuesta_id,
            },
            success: function(response) {

                limpiar();                
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
                    cargarUsuarios(response.usuariosLab);


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
                    icon:  'error',
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
                url: '/encuestas/deleteUsuarioNopre',
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
                        cargarUsuarios(response.usuariosLab);

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
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:   error,
                        showConfirmButton: true,
                    });


                }
            });

        }
    });

}


function moveUser(usuario_id, laboratorio_id, id_labusu){

    Swal.fire({
        title: 'SoftInspi',
        text: 'Seguro que quieres mover este usuario a la lista de usuarios agregados?.',
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
                url: '/encuestas/moveUsuarioNopre',
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
                        cargarUsuarios(response.usuariosLab);


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
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
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




function editUser(usuario_id, laboratorio_id, id_labusu){


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/encuestas/editUsuario_nopre?id_usuario='+usuario_id+'&id_laboratorio='+laboratorio_id+'&id_lab_usu='+id_labusu,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){


            if(res.data == true){

                var usuario = res.usuariosLab;

                var usu = divideName(usuario.nombre);

                $('#nombreUser').val(usu.firstName);
                $('#apellidoUser').val(usu.lastName);
                $('#correoUser').val(usuario.correo);
                $('#hospitalUser').val(usuario.hospital);
                $('#id_usuario').val(usuario.id);

                $('#btn_Guardar').hide();
                $('#btn_Editar').show();
                $('#btn_Cancelar').show();

            }else{

                //console.log(res);
                Swal.fire({
                    title: 'SoftInspi',
                    text: res.message,
                    icon: 'error',
                    type: 'error',
                    confirmButtonText: 'Aceptar',
                    timer: 3500
                });


            }

        }

    });



}



function divideName(fullName) {
    fullName = fullName.trim();
    
    const nameParts = fullName.split(' ');

    let firstName = '';
    let lastName = '';

    if (nameParts.length >= 5) {
        firstName = nameParts.slice(0, 3).join(' ');
        lastName = nameParts.slice(3).join(' ');
    } else if (nameParts.length >= 3) {
        firstName = nameParts.slice(0, 2).join(' ');
        lastName = nameParts.slice(2).join(' ');
    } else if (nameParts.length >= 2) {
        firstName = nameParts.slice(0, 1).join(' ');
        lastName = nameParts.slice(1).join(' ');
    } else {
        firstName = fullName;
    }

    return {
        firstName: firstName,
        lastName: lastName
    };
}


function cancelar(){

    $('#btn_Guardar').show();
    $('#btn_Editar').hide();
    $('#btn_Cancelar').hide();

    limpiar();

}


function limpiar(){

    $('#nombreUser').val('');
    $('#apellidoUser').val('');
    $('#correoUser').val('');
    $('#hospitalUser').val('');

}


function editar(){


    var nombreUser   = document.getElementById("nombreUser").value;
    var apellidoUser = document.getElementById("apellidoUser").value;
    var correoUser   = document.getElementById("correoUser").value;
    var hospitalUser = document.getElementById("hospitalUser").value;

    var laboratorio_id  = document.getElementById("laboratorio_id").value;
    var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;

    var id_usuario = document.getElementById("id_usuario").value;

    if(nombreUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un nombre.',
            showConfirmButton: true,
        });

    }else if(apellidoUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un apellido.',
            showConfirmButton: true,
        });

    }else if(correoUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un correo.',
            showConfirmButton: true,
        });

    }else if(hospitalUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de ingresar un hospital.',
            showConfirmButton: true,
        });

    }else {

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/saveEditUsuarioNopre',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombreUser':      nombreUser,
                'apellidoUser':    apellidoUser,
                'correoUser':      correoUser,
                'hospitalUser':    hospitalUser,
                'laboratorio_id':  laboratorio_id,
                'tipoencuesta_id': tipoencuesta_id,
                'id_usuario':      id_usuario,
            },
            success: function(response) {

                limpiar();                
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
                    cargarUsuarios(response.usuariosLab);

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
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   error,
                    showConfirmButton: true,
                });

            }
        });

    }


}



function cargarUsuarios(arrayUsu){
    
    var usuariosLabHTML = '';
    var usuariosAntLabHTML = '';
    if (arrayUsu.length > 0) {

        //para la lista de los anteriores
        arrayUsu.forEach(function(usuario) {

            if(usuario.estado == 'A'){

                usuariosLabHTML += `
                <li class="list-group-item mb-2">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span><strong>Nombre: </strong>${usuario.nombre}</span>
                                <span><strong>Correo: </strong>${usuario.correo}</span>
                                <span><strong>Hospital: </strong>${usuario.hospital}</span>
                            </div>
                        </div>

                        <div class="col-lg-3">

                            <a tupe="buttom" class="btn btn-success btn-sm" onclick="editUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                <i class="bi bi-pen"></i>
                            </a>

                            <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                <i class="bi bi-file-x"></i>
                            </a>

                        </div>
                    </div>
                </li> `;

            }else{

                usuariosAntLabHTML += `
                <li class="list-group-item mb-2">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <span><strong>Nombre: </strong>${usuario.nombre}</span>
                                <span><strong>Correo: </strong>${usuario.correo}</span>
                                <span><strong>Hospital: </strong>${usuario.hospital}</span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                                       
                            <a tupe="buttom" class="btn btn-success btn-sm" onclick="editUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                <i class="bi bi-pen"></i>
                            </a>

                            <a tupe="buttom" class="btn btn-primary btn-sm" onclick="moveUser( ${usuario.id}, ${usuario.laboratorio_id}, ${usuario.id_labusu} )">
                                <i class="bi bi-arrow-left-square"></i>
                            </a>

                        </div>
                    </div>
                </li> `;

            }


        });

    } else {
        usuariosLabHTML += '<li class="list-group-item mb-2">Aun no hay usuarios para este laboratorio</li>';
        usuariosAntLabHTML += '<li class="list-group-item mb-2">Aun no hay usuarios para este laboratorio</li>';
    }
    $('.list-group').html(usuariosLabHTML);
    $('#usuariosAnteriores').html(usuariosAntLabHTML);
}
