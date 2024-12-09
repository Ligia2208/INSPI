var cont = 1;
var contAtencion = 0;

$( function () {

    $('#servicioName').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });

});


function limpiarRadios() {

    var comentarios = document.getElementById("comentarios").value;
    var radios      = document.querySelectorAll('input[type="radio"]');
    radios.forEach(function(radio) {
        radio.checked = false;
    });

    $('#comentarios').val('');

}

function guardarPreguntas(){

    var preguntasEncuesta = [];

    var form = document.getElementById("frmCreateEncuesta");//busca el formulario

    let preguntas = form.preguntaName;
    let opcionesN = form.opcionesN;

    if(preguntas.length){

        for (let for2 = 0; for2 < preguntas.length; for2++) {

            var opciones = form.querySelectorAll(`[name="opcion${for2 + 1}"]`);

            if(opciones.length){

                var opcionesEncuesta = [];

                for (let for1 = 0; for1 < opciones.length; for1++) {
                    opcionesEncuesta.push({name: opciones[for1].value, id: for2+1 });
                }

            }else{
                opcionesEncuesta.push({name: opciones.value, id: for1 });
            }

            preguntasEncuesta.push({name: preguntas[for2].value, opcionesN: opcionesN[for2].value, opciones: opcionesEncuesta});

        }

    }else{

        var opciones = form.querySelectorAll(`[name="opcion${1}"]`);

        if(opciones.length){
            var opcionesEncuesta = [];

            for (let for2 = 0; for2 < opciones.length; for2++) {
                opcionesEncuesta.push({name: opciones[for2].value, id: 1 });
            }

        }else{
            opcionesEncuesta.push({name: opciones.value, id: 1 });
        }

        preguntasEncuesta.push({name: preguntas.value, opcionesN: opcionesN.value, opciones: opcionesEncuesta});

    }

    return preguntasEncuesta;
}


function validar(){
    var form = document.getElementById("frmCreateEncuesta");
    cont = 1;
    console.log(form);

    // Obtener todos los inputs
    var inputs = document.querySelectorAll('input[type="radio"]');

    // Objeto para almacenar los inputs agrupados por nombre
    var inputsAgrupados = {};

    // Recorrer todos los inputs y agruparlos por su nombre
    inputs.forEach(function(input) {
        var nombre = input.getAttribute('name');
        if (nombre && nombre !== 'flexRadioDefault') {
            if (!inputsAgrupados[nombre]) {
                inputsAgrupados[nombre] = [];
            }
            inputsAgrupados[nombre].push(input);
        }
    });


    for (var nombreInput in inputsAgrupados) {
        if (inputsAgrupados.hasOwnProperty(nombreInput)) {
            var inputs = inputsAgrupados[nombreInput];
            var radioMarcado = false;

            // Verificar si al menos un radio está marcado en el grupo
            inputs.forEach(function(input) {
                if (input.checked) {
                    radioMarcado = true;
                }
            });

            // Si no hay ningún radio marcado en el grupo, mostrar error
            if (!radioMarcado) {
                //console.log(`Error: Ningún radio marcado en el grupo '${nombreInput}'.`);
                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `Error: Ninguna opción marcada en la pregunta '${cont}'.`,
                    showConfirmButton: true,
                });

                return false;

            }
        }
        cont++;
    }
    console.log(inputsAgrupados);

    return true;

}


function obtenerEncuesta(){

    var conta = 0;

    var conjuntoDatos = [];
    var inputs = document.querySelectorAll('input[type="radio"]');
    var form = document.getElementById("frmCreateEncuesta").pregunta;

    // Objeto para almacenar los inputs agrupados por nombre
    var inputsAgrupados = {};

    // Recorrer todos los inputs y agruparlos por su nombre
    inputs.forEach(function(input) {
        var nombre = input.getAttribute('name');
        if (nombre && nombre !== 'flexRadioDefault') {
            if (!inputsAgrupados[nombre]) {
                inputsAgrupados[nombre] = [];
            }
            inputsAgrupados[nombre].push(input);
        }
    });


    for (var nombreInput in inputsAgrupados) {
        if (inputsAgrupados.hasOwnProperty(nombreInput)) {
            var inputs = inputsAgrupados[nombreInput];
            
            var inputsOpciones  = [];
            var nombrePregunata = ''; 
            var idPregunta      = '';

            nombrePregunata = form[conta].value;
            idPregunta      = form[conta].getAttribute('data-id');

            conta++;
            // Verificar si al menos un radio está marcado en el grupo
            inputs.forEach(function(input) {

                if (input.checked) {
                    //radioMarcado = true;
                    let id_pregunta = input.getAttribute('data-idPregunta');
                    let id_opcion   = input.getAttribute('data-id');
                    let nombreOp    = input.getAttribute('data-nombre');

                    inputsOpciones.push({ pregunta_id: id_pregunta, id: id_opcion, nombre: nombreOp, resp: 'true' });

                }else{

                    let id_pregunta = input.getAttribute('data-idPregunta');
                    let id_opcion   = input.getAttribute('data-id');
                    let nombreOp    = input.getAttribute('data-nombre');

                    inputsOpciones.push({ pregunta_id: id_pregunta, id: id_opcion, nombre: nombreOp, resp: 'false' });

                }

            });

            conjuntoDatos.push({ pregunta_id: idPregunta, nombre: nombrePregunata, opciones:inputsOpciones });
            
        }

    }

    return conjuntoDatos;
    //console.log(conjuntoDatos);
    
}


function guardar(){

    var fechaUser    = document.getElementById("fechaUser").value;
    var servicioName = document.getElementById("servicioName").value;
    var areaName     = document.getElementById("areaName").value;
    var ciudad       = document.getElementById("ciudad").value;
    var comentarios  = document.getElementById("comentarios").value;

    var servidor_publico = document.getElementById("comServP");
    var motivo_califica  = document.getElementById("comMotC");

    if(fechaUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'La encuesta debe de tener una fecha.',
            showConfirmButton: true,
        });

    }else if(servicioName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese un nombre del servicio.',
            showConfirmButton: true,
        });

    }else if(areaName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la area a la que presto el servicio.',
            showConfirmButton: true,
        });

    }else if(ciudad == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la ciudad a la que pertenece.',
            showConfirmButton: true,
        });

    }else if(validar()){

        var valorComServP = '';
        var valorCalifica = '';

        if(servidor_publico !== null) { 

            
            if(valorComServP.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el nombre del servidor publico.',
                    showConfirmButton: true,
                });

                return;

            }else if(valorCalifica.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el motivo de la calificación.',
                    showConfirmButton: true,
                });

                return;

            }else{

                valorComServP = servidor_publico.value;
                valorCalifica = motivo_califica.value;

            }

        }else{

            valorComServP = '';
            valorCalifica = '';

        }

        var arrayEncuesta = obtenerEncuesta();
        console.log(arrayEncuesta);

        var nombreEncuesta = document.getElementById("nombreEncuesta").value;
        var idEncuesta     = document.getElementById("idEncuesta").value;
        var descripcion    = document.getElementById("descripcion").value;

        var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;
        var laboratorio_id  = document.getElementById("laboratorio_id").value;

        var id_evento       = document.getElementById("id_evento").value;
        
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveUser") }}',
            url: '/encuestas/saveUser',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombreEncuesta': nombreEncuesta,
                'idEncuesta':     idEncuesta,
                'descripcion':    descripcion,
                'fechaUser':      fechaUser,
                'servicioName':   servicioName,
                'areaName':       areaName,
                'ciudad':         ciudad,
                'comentarios':    comentarios,
                'arrayEncuesta':  arrayEncuesta,
                'motivo_califica':  valorCalifica,
                'servidor_publico': valorComServP,
                'tipoencuesta_id': tipoencuesta_id,
                'laboratorio_id':  laboratorio_id,
                'id_evento':       id_evento,      
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
                        if (result.value) {
                            window.location.href = '/homeUsuario';
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


function guardarExterno(){

    var fechaUser    = document.getElementById("fechaUser").value;
    var servicioName = document.getElementById("servicioName").value;
    var areaName     = document.getElementById("areaName").value;
    var ciudad       = document.getElementById("ciudad").value;
    var comentarios  = document.getElementById("comentarios").value;

    var servidor_publico = document.getElementById("comServP");
    var motivo_califica  = document.getElementById("comMotC");

    if(fechaUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'La encuesta debe de tener una fecha.',
            showConfirmButton: true,
        });

    }else if(servicioName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese un nombre del servicio.',
            showConfirmButton: true,
        });

    }else if(areaName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la area a la que presto el servicio.',
            showConfirmButton: true,
        });

    }else if(ciudad == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la ciudad a la que pertenece.',
            showConfirmButton: true,
        });

    }else if(validar()){

        var valorComServP = '';
        var valorCalifica = '';

        if(servidor_publico !== null) { 

            
            if(valorComServP.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el nombre del servidor publico.',
                    showConfirmButton: true,
                });

                return;

            }else if(valorCalifica.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el motivo de la calificación.',
                    showConfirmButton: true,
                });

                return;

            }else{

                valorComServP = servidor_publico.value;
                valorCalifica = motivo_califica.value;

            }

        }else{

            valorComServP = '';
            valorCalifica = '';

        }

        var arrayEncuesta = obtenerEncuesta();
        console.log(arrayEncuesta);

        var nombreEncuesta = document.getElementById("nombreEncuesta").value;
        var idEncuesta     = document.getElementById("idEncuesta").value;
        var descripcion    = document.getElementById("descripcion").value;

        var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;
        var laboratorio_id  = document.getElementById("laboratorio_id").value;

        var id_evento       = document.getElementById("id_evento").value;
        
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveUser") }}',
            url: '/encuestas/guardarEncuesta',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombreEncuesta': nombreEncuesta,
                'idEncuesta':     idEncuesta,
                'descripcion':    descripcion,
                'fechaUser':      fechaUser,
                'servicioName':   servicioName,
                'areaName':       areaName,
                'ciudad':         ciudad,
                'comentarios':    comentarios,
                'arrayEncuesta':  arrayEncuesta,
                'motivo_califica':  valorCalifica,
                'servidor_publico': valorComServP,
                'tipoencuesta_id': tipoencuesta_id,
                'laboratorio_id':  laboratorio_id,
                'id_evento':       id_evento,      
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
                        if (result.value) {
                            window.location.href = '/completed';
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


function guardarExternoLink(){

    var fechaUser    = document.getElementById("fechaUser").value;
    var areaName     = document.getElementById("areaName").value;
    var ciudad       = document.getElementById("ciudad").value;
    var comentarios  = document.getElementById("comentarios").value;
    var name_unidad  = document.getElementById("name_unidad").value;

    var servidor_publico = document.getElementById("comServP");
    var motivo_califica  = document.getElementById("comMotC");

    if(fechaUser == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'La encuesta debe de tener una fecha.',
            showConfirmButton: true,
        });

    }else if(areaName == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la area a la que presto el servicio.',
            showConfirmButton: true,
        });

    }else if(ciudad == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese la ciudad a la que pertenece.',
            showConfirmButton: true,
        });

    }else if(name_unidad == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Ingrese el nombre de la unidad de salud.',
            showConfirmButton: true,
        });

    }else if(validar()){

        var valorComServP = '';
        var valorCalifica = '';

        if(servidor_publico !== null) { 

            
            if(valorComServP.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el nombre del servidor publico.',
                    showConfirmButton: true,
                });

                return;

            }else if(valorCalifica.value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: 'Ingrese el motivo de la calificación.',
                    showConfirmButton: true,
                });

                return;

            }else{

                valorComServP = servidor_publico.value;
                valorCalifica = motivo_califica.value;

            }

        }else{

            valorComServP = '';
            valorCalifica = '';

        }

        var arrayEncuesta = obtenerEncuesta();
        console.log(arrayEncuesta);

        var nombreEncuesta = document.getElementById("nombreEncuesta").value;
        var idEncuesta     = document.getElementById("idEncuesta").value;
        var descripcion    = document.getElementById("descripcion").value;

        var tipoencuesta_id = document.getElementById("tipoencuesta_id").value;
        var laboratorio_id  = document.getElementById("laboratorio_id").value;

        var id_evento       = document.getElementById("id_evento").value;
        
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveUser") }}',
            url: '/encuestas/guardarEncuesta',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombreEncuesta': nombreEncuesta,
                'idEncuesta':     idEncuesta,
                'descripcion':    descripcion,
                'fechaUser':      fechaUser,
                'areaName':       areaName,
                'ciudad':         ciudad,
                'comentarios':    comentarios,
                'arrayEncuesta':  arrayEncuesta,
                'motivo_califica':  valorCalifica,
                'servidor_publico': valorComServP,
                'tipoencuesta_id': tipoencuesta_id,
                'laboratorio_id':  laboratorio_id,
                'id_evento':       id_evento,   
                'name_unidad':     name_unidad,   
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
                        if (result.value) {
                            window.location.href = '/completed';
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


function deleteUser(usuario_id, laboratorio_id){


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
                                                <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( ${usuario.id}, ${usuario.laboratorio_id} )">
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


function presentar(dato){

    //var abrindada = form.querySelector(`#abrindada${for2+1}`).checked;
    //var evaluar = document.getElementById(dato).checked;

    if(dato <= 2){

        if(contAtencion == 0){

            $('#conteAbrindada').append(`
        
            <div class="col-md-12">
                <div class="form-group mt-2">
                    <label for="comment" class="mt-2"><strong>En caso de que su respuesta sea menos a 3 respecto a la atención brindada por el servidor público y 
                                        para que nos ayude a mejorar el servicio, por favor indicarnos el nombre del servidor público que le 
                                        atendió y el motivo de la calificación:</strong> 
                    </label>
                    <div class="row mt-2">
                        <div class="col-md-6 mt-2">
                            <label for="comServP" class="form-label">Nombre del Servidor Público</label>
                            <input type="text" id="comServP" name="comServP" class="form-control" required="" autofocus="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>     
                        <div class="col-md-6 mt-2">
                            <label for="comMotC" class="form-label">Motivo de la calificación</label>
                            <input type="text" id="comMotC" name="comMotC" class="form-control" required="" autofocus="">
                            <div class="valid-feedback">Looks good!</div>
                        </div>  
                    </div>                                               
                </div>
            </div>
    
            `);
    
            contAtencion++;

        }

        //console.log('funciona');
    }else{

        if(contAtencion == 1){

            $('#conteAbrindada').text('');
            contAtencion--;

        }

    }


}
