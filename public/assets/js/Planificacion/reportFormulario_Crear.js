$(document).ready(function () {
    //console.log("jQuery ha sido cargado y el DOM está listo.");

    $(document).on("click", "#CrearUsuario", function (event) {
        event.preventDefault();
        //console.log("¡El botón fue detectado y clickeado!");
      

        var nombre = $('#nombre').val().trim();
        var apellido = $('#apellido').val().trim();
        var correo = $('#correo').val().trim();
        var telefono = $('#telefono').val().trim();

        //console.log("Valores obtenidos:", { nombre, apellido, correo, telefono });

        if (!nombre || !apellido || !correo || !telefono) {
            console.log("Faltan campos por llenar.");
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Todos los campos son obligatorios.',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

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
                    text: response.success ? 'Usuario guardado correctamente.' : 'Hubo un problema al guardar el usuario.',
                    confirmButtonText: 'Aceptar'
                });

                if (response.success) limpiarCampos();


            },
            error: function (_xhr, _status, error) {
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
