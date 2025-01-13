var contMovimiento = 0;
var contEgreso = 0;

$( function () {


    /* ============================================================== CARGA MASIVA ============================================================== */

    document.getElementById('importButton').addEventListener('click', function() {
        validarDatosResultadosInput()
        if(validarDatosResultadosInput()){

            var form = document.getElementById('importForm'); //Según esto aquí ya se está enviando el file
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: '/planificacion/import',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {

                        Swal.fire({
                            icon: 'success',
                            type:  'success',
                            title: 'CoreInspi',
                            text: response.message,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '/planificacion/vistaUser';
                            }
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            type:  'error',
                            title: 'CoreInspi',
                            text: response.message,
                            showConfirmButton: true,
                        });

                    }
                },
                error: function(error) {
                    
                    Swal.fire({
                        icon: 'error',
                        type:  'error',
                        title: 'CoreInspi',
                        text: 'Error al enviar la solicitud AJAX: '+ error,
                        showConfirmButton: true,
                    });

                }
            });


        }else{
            return;
        }

        
        


    });

    /* ============================================================== CARGA MASIVA ============================================================== */



});




function validarDatosResultadosInput() {
    let isValid = true;
    var inputFile = document.getElementById('file');

    if (inputFile.files.length > 0) {
        // Verificar si el archivo seleccionado es un CSV
        const file = inputFile.files[0];
        const fileName = file.name;
        const fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
        if (fileType.toLowerCase() !== 'csv') {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'CoreInspi',
                text: 'Por favor, seleccione un archivo CSV.',
                showConfirmButton: true,
            });
            isValid = false;
        }
    } else {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'CoreInspi',
            text: 'No se ha agregado ningún documento en el reporte de resultados.',
            showConfirmButton: true,
        });
        isValid = false;
    }

    return isValid;
}
