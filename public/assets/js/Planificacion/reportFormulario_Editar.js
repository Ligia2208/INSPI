$(document).ready(function () {
    //console.log("jQuery ha sido cargado y el DOM está listo.");

    $(document).on("click", "#EditarUsuario", function () {
        //console.log("¡El botón fue detectado y clickeado!");

        var nombre = $('#nombre').val().trim();
        var apellido = $('#apellido').val().trim();
        var correo = $('#correo').val().trim();
        var telefono = $('#telefono').val().trim();

        //console.log("Valores obtenidos:", { nombre, apellido, correo, telefono });

        var datosUsuario = {
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            telefono: telefono,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log("Enviando datos:", datosUsuario);

        
        $.ajax({
            url: '/planificacion/crear_usuario',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: datosUsuario,
            success: function (response) {

                console.log("Respuesta del servidor:", response);

                Swal.fire({
                    icon: response.success ? 'success' : 'error',
                    title: response.success ? 'Éxito' : 'Error',
                    text: response.success ? 'Usuario editado correctamente.' : 'Hubo un problema al editar el usuario.',
                    confirmButtonText: 'Aceptar'
                });

                if (response.success) limpiarCampos();


            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud. Intente de nuevo.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });

    });

    function limpiarCampos() {
        $('#nombre').val('');
        $('#apellido').val('');
        $('#correo').val('');
        $('#telefono').val('');
    }
});
