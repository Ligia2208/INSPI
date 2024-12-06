//variables globales

var contPregunta = 1;
var contOpciones = 0;

$( function () {

    var id_tipoSele = document.getElementById('id_zonal').value;
    if(id_tipoSele != ''){

        var selectElement = document.getElementById('coordina');
        selectElement.value = id_tipoSele;
        iniciarSelect();

    }



    $('#departamento').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
        //dropdownParent: $('#addArticuloM .modal-body')
    });


    
    $('#coordina').on('change', function() {
        var selectedCoordina = $(this).val();

        // Realiza una solicitud AJAX para obtener las opciones de departamento
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/obtenerDepartamentosEncuesta/' + selectedCoordina, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var departamentoSelect = $('#departamento');
                departamentoSelect.empty(); // Limpia las opciones actuales

                departamentoSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un Departamento'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data, function(index, departamento) {
                    departamentoSelect.append($('<option>', {
                        value: departamento.id,
                        text: departamento.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones de departamento', error);
            }
        });

    });
    

});




function iniciarSelect() {
    var id_zonal = $('#coordina').val();
    var id_area = $('#id_area').val();

    if (id_area) {
        $.ajax({
            type: 'GET',
            url: '/obtenerDepartamentosEncuesta/' + id_zonal,
            success: function(data) {
                var departamentoSelect = $('#departamento');
                departamentoSelect.empty(); // Limpia las opciones actuales
    
                departamentoSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un Departamento'
                }));
    
                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data, function(index, departamento) {
                    departamentoSelect.append($('<option>', {
                        value: departamento.id,
                        text: departamento.nombre,
                        selected: departamento.id == id_area // Selecciona si coincide
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones de departamento', error);
                alert('Hubo un problema al obtener las opciones del departamento. Por favor, intenta nuevamente.');
            }
        });
    }
}




function validaTipo(){

    const elementos = document.querySelectorAll('input[name="tipoEncuestaLab"]');
    let contadorFalse = 0;

    elementos.forEach(elemento => {
        if (!elemento.checked) {
            contadorFalse++;
        }
    });

    if (contadorFalse === elementos.length) {
        return true;
    }else{
        return false;
    }

}


function obtenerTipo(){
    const elementos = document.querySelectorAll('input[name="tipoEncuestaLab"]');
    const valores = [];

    elementos.forEach(elemento => {

        let idDelCheckbox = elemento.dataset.id;

        valores.push({valor: elemento.checked, id: idDelCheckbox});

    });

    return valores;
}


function guardar(){

    var validacionLab  = document.getElementById("validacionLab");

    var descripcion  = document.getElementById("descripLab").value;
    var coordina     = document.getElementById("coordina").value;
    var departamento = document.getElementById("departamento").value;

    //var interno      = document.getElementById("flexSwitchInterno").checked;
    //var presencialNo = document.getElementById("flexSwitchNoPresencial").checked;
    //var presencial   = document.getElementById("flexSwitchPresencial").checked;

    if(validacionLab){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'No puede ingresar un laboratorio sin antes agregar un Tipo de Encuesta',
            showConfirmButton: true,
        });

    }else if(descripcion == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de agregar una descripcion al Laboratorio',
            showConfirmButton: true,
        });

    }else if(validaTipo()){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de checkear al menos un tipo de Encuesta para este laboratorio.',
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

    }else if(departamento == 0){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de seleccionar un Laboratorio',
            showConfirmButton: true,
        });

    }else{

        let tipos = obtenerTipo();

        //se guarda la info
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/saveLaboratorio',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'coordina'    : coordina,
                'descripcion' : descripcion,
                'departamento': departamento,
                'tipos'       : tipos,
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
                            window.location.href = '/encuestas/listarLaboratorio';
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
