$(document).ready(function () {

    $(document).on("click", "#EditarUsuario", function () {
        
      // console.log("¡El botón fue detectado y clickeado!");

        //var id = parseInt($('#id').val().trim());
        var id       = $('#id').val().trim();
        var nombre   = $('#nombre').val().trim();
        var apellido = $('#apellido').val().trim();
        var correo   = $('#correo').val().trim();
        var telefono = $('#telefono').val().trim();


        var datosUsuario = {
            id: id,
            nombre: nombre,
            apellido: apellido,
            correo: correo,
            telefono: telefono,
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log("Enviando datos:", datosUsuario);

        
        $.ajax({
            url: '/planificacion/editar_usuario',
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
          
            
            error: function (xhr, _status, error) {
                console.error("Error en la solicitud AJAX:", error);
                console.log("Código de estado HTTP:", xhr.status);
                console.log("Respuesta del servidor:", xhr.responseText);
                debugger;  // Pausa el código aquí
            }
            
        });

    });

    function limpiarCampos() {
        $('#id').val('');
        $('#nombre').val('');
        $('#apellido').val('');
        $('#correo').val('');
        $('#telefono').val('');

    }
});
