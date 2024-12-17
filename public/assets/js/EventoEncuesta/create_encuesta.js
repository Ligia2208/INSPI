//variables globales

var contPregunta = 1;
var contOpciones = 0;

$( function () {



});

/* FUNCION PARA AGREGAR PREGUNTA */
function agregarPregunta(){

    $('#contenedorEncuesta').append(`
        <hr class="my-2">
        <div class="my-5 px-0 col-md-12 row" id="contenedorPregunta${contPregunta}">
            <div class="col-md-12">
                <h3 class="mb-0 text-uppercase text-center ps-4 pe-0"> Pregunta ${contPregunta} </h3>
            </div>
            <div class="col-md-6 mt-2 ps-4 pe-0">
                <label for="preguntaName" class="form-label">Nombre de la Pregunta</label>
                <input type="text" id="preguntaName" name="preguntaName" class="form-control required="" autofocus="" placeholder="Ingrese el nombre de la pregunta">
            </div>
            <div class="col-md-3 mt-2 ps-4 pe-0">
                <label for="opcionesN" class="form-label">Número de Opciones</label>
                <input type="number" max="7" min="1" id="opcionesN${contPregunta}" name="opcionesN" class="form-control required="" autofocus="" placeholder="Ingrese el numero de opciones" onchange="validarOpciones(${contPregunta})">
                <p id="mensajeError${contPregunta}" style="color: red; display: none;">Ingrese un número entre 1 y 7.</p>
            </div>

            <div class="col-md-3 mt-2 ps-4 pe-0 d-flex justify-content-center align-items-center">
                <label for="abrindada" class="form-label mr-3">Atención Brindada</label> 
                <label class="switch2"> 
                    <input type="checkbox" id="abrindada${contPregunta}" name="abrindada">
                    <span class="slider round"></span>
                </label>
            </div>

        </div>
    `);

    contPregunta = contPregunta + 1;
}
/* FUNCION PARA AGREGAR PREGUNTA */


/* FUNCION PARA AGREGAR OPCION */
function agregarOpcion(valor){

    $('#contenedorPregunta'+valor).append(`
        <div class="col-md-6 mt-4 ps-4 pe-0" id="divOpcion${valor}">
            <label for="opcion${valor}" class="form-label">Nombre Opción</label>
            <input type="text" id="opcion${valor}" name="opcion${valor}" class="form-control required="" autofocus="" placeholder="Ingrese el asunto">
        </div>
    `);

}
/* FUNCION PARA AGREGAR OPCION */


/* VALIDA QUE EL NUMERO DE OPCIONES NO SEAN MAYORES A 7 */
function validarOpciones(valor) {

    var elementos = document.querySelectorAll('#opcion'+valor);

    var input = document.getElementById("opcionesN"+valor);
    
    var mensajeError = document.getElementById("mensajeError"+valor);

    if (input.value < 1 || input.value > 7) {
        mensajeError.style.display = "block";
        input.setCustomValidity("Ingrese un número entre 1 y 7");


    } else {
        mensajeError.style.display = "none";
        input.setCustomValidity("");

        if(elementos.length < input.value){ // si el numero de inputs es menor se debe de agregar
            contOpciones = input.value - elementos.length;

            for(let i = 0; i<contOpciones; i++){
                agregarOpcion(valor);
            }

        }else{
            contOpciones = elementos.length - input.value;

            for(let i = 0; i<contOpciones; i++){
                eliminarOpcion(valor);
            }

        }

    }
}
/* VALIDA QUE EL NUMERO DE OPCIONES NO SEAN MAYORES A 7 */


/* FUNCION PARA ELIMINAR OPCIONES(ELIMINA LA ULTIMA) */
function eliminarOpcion(valor) {
    var contenedor = document.getElementById("contenedorPregunta"+valor);
    var divsOpcion1 = contenedor.querySelectorAll("#divOpcion"+valor);

    if (divsOpcion1.length > 0) {
        var ultimoDiv = divsOpcion1[divsOpcion1.length - 1];
        ultimoDiv.remove();
    }
}
/* FUNCION PARA ELIMINAR OPCIONES(ELIMINA LA ULTIMA) */

function validarPreguntas(){

    var form = document.getElementById("frmCreateEncuesta");//busca el formulario

    let preguntas = form.preguntaName;
    let opcionesN = form.opcionesN;

    if(preguntas == undefined){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: `No se han agregado preguntas a la encuesta.`,
            showConfirmButton: true,
            //timer: 1500
        });
        return true;

    }else if(preguntas.length){

        for (let for2 = 0; for2 < preguntas.length; for2++) {
            if(preguntas[for2].value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `El nombre de la pregunta ${for2+1} esta vacia`,
                    showConfirmButton: true,
                    //timer: 1500
                });
                return true;

            }else if(opcionesN[for2].value == ''){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `El número de opciones no puede estar vacio, en la pregunta ${for2+1}`,
                    showConfirmButton: true,
                    //timer: 1500
                });
                return true;

            }else if(opcionesN[for2].value < 0 && opcionesN[for2].value > 8){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `El numero de opciones debe de estar entre 1 y 7, en la pregunta ${for2+1}`,
                    showConfirmButton: true,
                    //timer: 1500
                });
                return true;

            }

            //se valida las opciones
            var opciones = form.querySelectorAll(`[name="opcion${for2 + 1}"]`);

            if(opciones == undefined){

                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `No se han agregado opciones en la pregunta ${for2+1}`,
                    showConfirmButton: true,
                    //timer: 1500
                });
                return true;

            }else if(opciones.length){

                for (let for1 = 0; for1 < opciones.length; for1++) {
                    if(opciones[for1].value == ''){
                        Swal.fire({
                            icon: 'warning',
                            title: 'SoftInspi',
                            type: 'warning',
                            text: `La opción ${for1+1} de la pregunta ${for2+1} no puede esta vacia`,
                            showConfirmButton: true,
                            //timer: 1500
                        });
                        return true;
                    }
                }

            }else{
                if(opciones.value == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: 'SoftInspi',
                        type: 'warning',
                        text: `La opción ${1} de la pregunta ${1} no puede esta vacia`,
                        showConfirmButton: true,
                        //timer: 1500
                    });
                    return true;
                }
            }

        }

        return false;

    }else{

        //se valida las opciones
        var opciones = form.querySelectorAll(`[name="opcion${1}"]`);

        if(opciones.length){

            for (let for1 = 0; for1 < opciones.length; for1++) {
                if(opciones[for1].value == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: 'SoftInspi',
                        type: 'warning',
                        text: `La opción ${for1+1} de la pregunta ${1} no puede esta vacia`,
                        showConfirmButton: true,
                        //timer: 1500
                    });
                    return true;
                }
            }

        }else{
            if(opciones.value == ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'SoftInspi',
                    type: 'warning',
                    text: `La opción ${1} de la pregunta ${1} no puede esta vacia`,
                    showConfirmButton: true,
                    //timer: 1500
                });
                return true;
            }
        }

        if(preguntas.value == ''){

            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                type: 'warning',
                text: `El nombre de la pregunta esta vacia`,
                showConfirmButton: true,
                //timer: 1500
            });
            return true;

        }else if(opcionesN.value == ''){

            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                type: 'warning',
                text: 'El número de opciones no puede estar vacio',
                showConfirmButton: true,
                //timer: 1500
            });
            return true;

        }else if(opcionesN.value < 0 && opcionesN.value > 8){

            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                type: 'warning',
                text: 'El numero de opciones debe de estar entre 1 y 7',
                showConfirmButton: true,
                //timer: 1500
            });
            return true;

        }else{

            return false;

        }

    }

}


function guardarPreguntas(){

    var preguntasEncuesta = [];

    var form = document.getElementById("frmCreateEncuesta");//busca el formulario
    //var inputAbrindada = document.getElementById("abrindada"+valor);
    //let abrindada = form.abrindada;

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

            // Obtener el estado del checkbox
            var abrindada = form.querySelector(`#abrindada${for2+1}`).checked;

            preguntasEncuesta.push({name: preguntas[for2].value, opcionesN: opcionesN[for2].value, opciones: opcionesEncuesta, abrindada: abrindada });

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

        let abrindada = form.abrindada;
        //var abrindada = form.querySelector(`#abrindada${for2}`).checked;

        preguntasEncuesta.push({name: preguntas.value, opcionesN: opcionesN.value, opciones: opcionesEncuesta, abrindada: abrindada.checked});

    }

    return preguntasEncuesta;

    //console.log(preguntasEncuesta);

}


function guardar(){

    //guardarPreguntas();

    var nombre = document.getElementById("nombreEncue").value;
    var descripcion = document.getElementById("descripEncue").value;

    if(nombre == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de agregar un nombre a la encuesta',
            showConfirmButton: true,
        });

    }else if(descripcion == ''){

        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            type: 'warning',
            text: 'Debe de agregar una descripcion a la encuesta',
            showConfirmButton: true,
        });

    }else if(!validarPreguntas()){

        //se guarda la info
        var encuesta =guardarPreguntas();

        //console.log(encuesta);
        
        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/encuestas/save',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombre': nombre,
                'descripcion': descripcion,
                'encuesta': encuesta,
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
                        if (result.isConfirmed || result.isDismissed || result.value) {
                            window.location.href = '/encuestas/listarEncuesta';
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
