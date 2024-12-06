//variables globales

var contPregunta = 1;
var contOpciones = 0;

$( function () {


});




function guardarEncuesta(dato){

var id_encuesta  = document.getElementById(dato).value;
var id_tipo      = document.getElementById(dato).dataset.id;


    $.ajax({

        type: 'POST',
        //url: '{{ route("encuesta.saveEncuesta") }}',
        url: '/encuestas/saveTipoEncuesta',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id_encuesta' : id_encuesta,
            'id_tipo'     : id_tipo,
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
                });

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
