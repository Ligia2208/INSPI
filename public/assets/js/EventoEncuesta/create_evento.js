//variables globales

$( function () {

    $('#coordina').on('change', function() {
        var selectedCoordina = $(this).val();

        // Realiza una solicitud AJAX para obtener las opciones de departamento
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/obtenerLaboratoriosEncuesta/' + selectedCoordina, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var departamentoSelect = $('#laboratorio');
                departamentoSelect.empty(); // Limpia las opciones actuales

                departamentoSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un Laboratorio'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data, function(index, departamento) {
                    departamentoSelect.append($('<option>', {
                        value: departamento.id,
                        text:  departamento.descripcion
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones de departamento', error);
            }
        });

    });



    flatpickr("#anio", {
        dateFormat: "Y", // Mostrar solo el año
        mode: "single",
        disable: [
            function(date) {
            // Desactivar días para mostrar solo los años
            return !(date.getFullYear());
            }
        ],
        
        /*
        onYearChange: function(selectedDates, dateStr, instance) {
        // Actualizar el input cuando se cambia de año
        instance.setDate(selectedDates[0]);
        } */
    });




});



function guardar(){

    var eventoName  = document.getElementById("eventoName").value;
    var coordina    = document.getElementById("coordina").value;
    var laboratorio = document.getElementById("laboratorio").value;
    //var fechaDesde  = document.getElementById("fechaDesde").value;
    //var fechaHasta  = document.getElementById("fechaHasta").value;
    var anio        = document.getElementById("anio").value;
    var periodo     = document.getElementById("periodo").value;

    if(eventoName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de agregar un nombre al evento',
            showConfirmButton: true,
        });

    }else if(coordina == 0){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar una Coordinación',
            showConfirmButton: true,
        });

    }else if(laboratorio == 0){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar un Laboratorio',
            showConfirmButton: true,
        });

    }else if(anio == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar un año',
            showConfirmButton: true,
        });

    }else if(periodo == 0){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar un periodo',
            showConfirmButton: true,
        });

    }else{

        //se guarda la info
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/saveEvento',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'eventoName':  eventoName,
                'coordina':    coordina,
                'laboratorio': laboratorio,
                'periodo':     periodo,
                'anio':        anio,
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
                        if (result.value || result.isDismissed) {
                            window.location.href = '/encuestas';
                        }
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



}
