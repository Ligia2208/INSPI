
$( function () {


    $(document).on('change', '#monto, #frecuencia', function() {

        limpiar();

        var monto = $('#monto').val();
        var isValid = /^\d+$/.test(monto);

        if(monto === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un monto',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'El monto no es un número',
                showConfirmButton: true,
            });

        }else{


            switch ($(this).val()) {
                case '1':
                    var cuota = monto / 12;
    
                    $('#enero').val(cuota.toFixed(2)); $('#febre').val(cuota.toFixed(2)); $('#marzo').val(cuota.toFixed(2));
                    $('#abril').val(cuota.toFixed(2)); $('#mayo').val(cuota.toFixed(2)); $('#junio').val(cuota.toFixed(2));
                    $('#julio').val(cuota.toFixed(2)); $('#agosto').val(cuota.toFixed(2)); $('#septiem').val(cuota.toFixed(2));
                    $('#octubre').val(cuota.toFixed(2)); $('#noviem').val(cuota.toFixed(2)); $('#diciem').val(cuota.toFixed(2));
    
                    break;
    
                case '2':
                    var cuota = monto / 6;
    
                    $('#febre').val(cuota.toFixed(2));
                    $('#abril').val(cuota.toFixed(2));$('#junio').val(cuota.toFixed(2));
                    $('#agosto').val(cuota.toFixed(2));
                    $('#octubre').val(cuota.toFixed(2));$('#diciem').val(cuota.toFixed(2));
    
                    break;
    
                case '3':
                    var cuota = monto / 4;
    
                    $('#marzo').val(cuota.toFixed(2));$('#junio').val(cuota.toFixed(2));
                    $('#septiem').val(cuota.toFixed(2));$('#diciem').val(cuota.toFixed(2));
    
                    break;
    
                case '4':
                    var cuota = monto / 3;
    
                    $('#abril').val(cuota.toFixed(2));$('#agosto').val(cuota.toFixed(2));
                    $('#diciem').val(cuota.toFixed(2));
    
                    break;
    
                case '5':
                    var cuota = monto / 2;
    
                    $('#junio').val(cuota.toFixed(2));$('#diciem').val(cuota.toFixed(2));
    
                    break;
    
                case '6':
                    var cuota = monto / 1;
    
                    $('#diciem').val(cuota.toFixed(2));
    
                    break;
    
            }

        }


    });


    $('#monto').on('input', function () {
        validarInputNumerico(this);
    });

});


// Función para validar input numérico
function validarInputNumerico(input) {
    var inputValue = input.value;
    var isValid = /^\d+$/.test(inputValue);

    if (!isValid) {
        input.setCustomValidity('Ingrese solo números');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    } else {
        input.setCustomValidity('');
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }
}
    


//Limpiar meses
function limpiar(){

    $('#enero').val('0'); $('#febre').val('0'); $('#marzo').val('0');
    $('#abril').val('0'); $('#mayo').val('0'); $('#junio').val('0');
    $('#julio').val('0'); $('#agosto').val('0'); $('#septiem').val('0');
    $('#octubre').val('0'); $('#noviem').val('0'); $('#diciem').val('0');

}



//Guardar poa

function guardarPoa(){

    var formData = new FormData();

    let obOpera  = $('#obOpera').val();
    let actOpera = $('#actOpera').val();
    let subActi  = $('#subActi').val();
    let desItem  = $('#desItem').val();
    let item     = $('#item').val();
    let monto    = $('#monto').val();
    let monDisp  = $('#monDisp').val();
    let coordina = $('#coordina').val();
    let nPOA     = $('#nPOA').val();
    let fecha    = $('#fecha').val();
    let poa      = $('#poa').val();
    let justifi  = $('#justifi').val();

    var frecuencia = $('#frecuencia').val();

    if(obOpera == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un Objetivo Operativo',
            showConfirmButton: true,
        });

    }else if(actOpera == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar la Actividad Operativa',
            showConfirmButton: true,
        });

    }else if(subActi == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar la Sub Actividad',
            showConfirmButton: true,
        });

    }else if(desItem == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar la descripción del Item Presupuestario.',
            showConfirmButton: true,
        });

    }else if(item == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el Item Presupuestario.',
            showConfirmButton: true,
        });

    }else if(monto == '0' || monto == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un Monto.',
            showConfirmButton: true,
        });

    }else if(monDisp == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el Monto Disponible.',
            showConfirmButton: true,
        });

    }else if(coordina == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una Coordinación/Dirección/Proyecto.',
            showConfirmButton: true,
        });

    }else if(nPOA == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un número de POA.',
            showConfirmButton: true,
        });

    }else if(fecha == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una Fecha.',
            showConfirmButton: true,
        });

    }else if(poa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de selecionar un tipo de POA.',
            showConfirmButton: true,
        });

    }else if( justifi == '' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una Justificación.',
            showConfirmButton: true,
        });

    }else if( frecuencia == '0' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar la Frecuencia.',
            showConfirmButton: true,
        });

    }else{
       
        if(validarCalculos()){

            let meses = obtenerMeses();

            let fecha = $('#fecha').val();
            let partesFecha = fecha.split('-');
            let anio = partesFecha[0];
            
            $.ajax({

                type: 'POST',
                url: '/planificacion/savePoa',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    obOpera : obOpera , 
                    actOpera: actOpera, 
                    subActi : subActi , 
                    desItem : desItem , 
                    item    : item    , 
                    monto   : monto   , 
                    monDisp : monDisp , 
                    coordina: coordina, 
                    nPOA    : nPOA    , 
                    fecha   : fecha   , 
                    poa     : poa     , 
                    justifi : justifi ,

                    frecuencia: frecuencia,
                    meses: meses,
                    anio:  anio,
                },
                success: function(response) {
    
                    if(response.data){
    
                        if(response['data'] == true){
                            Swal.fire({
                                icon: 'success',
                                type: 'success',
                                title: 'SoftInspi',
                                text: response['message'],
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.value == true) {
    
                                    //window.location.href = '/inventario/laboratorio';
    
                                }
                            });
    
                        }
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

}


function validarCalculos() {

    var enero   = parseFloat($('#enero').val() || 0);
    var febre   = parseFloat($('#febre').val() || 0);
    var marzo   = parseFloat($('#marzo').val() || 0);
    var abril   = parseFloat($('#abril').val() || 0);
    var mayo    = parseFloat($('#mayo').val() || 0);
    var junio   = parseFloat($('#junio').val() || 0);
    var julio   = parseFloat($('#julio').val() || 0);
    var agosto  = parseFloat($('#agosto').val() || 0);
    var septiem = parseFloat($('#septiem').val() || 0);
    var octubre = parseFloat($('#octubre').val() || 0);
    var noviem  = parseFloat($('#noviem').val() || 0);
    var diciem  = parseFloat($('#diciem').val() || 0);

    var suma = enero + febre + marzo + abril + mayo + junio + julio + agosto + septiem + octubre + noviem + diciem;
    var monto = parseFloat($('#monto').val() || 0);

    if (suma === monto) {
        return true;
    } else {

        let comentario = '';

        if(monto > suma){
            var diferencia = monto - suma;
            comentario='Faltan $'+diferencia+' para llegar al monto indicado.';
        }else{
            var diferencia = suma -monto;
            comentario='Tiene un excedente de $'+diferencia+'.';
        }


        Swal.fire({
            icon:  'error',
            title: 'SoftInspi',
            type:  'error',
            text:   comentario,
            showConfirmButton: true,
        });

        return false;
    }
}



function obtenerMeses() {

    var enero   = parseFloat($('#enero').val() || 0);
    var febre   = parseFloat($('#febre').val() || 0);
    var marzo   = parseFloat($('#marzo').val() || 0);
    var abril   = parseFloat($('#abril').val() || 0);
    var mayo    = parseFloat($('#mayo').val() || 0);
    var junio   = parseFloat($('#junio').val() || 0);
    var julio   = parseFloat($('#julio').val() || 0);
    var agosto  = parseFloat($('#agosto').val() || 0);
    var septiem = parseFloat($('#septiem').val() || 0);
    var octubre = parseFloat($('#octubre').val() || 0);
    var noviem  = parseFloat($('#noviem').val() || 0);
    var diciem  = parseFloat($('#diciem').val() || 0);

    var meses = {
        'Enero' : enero, 
        'Febrero': febre, 
        'Marzo': marzo, 
        'Abril': abril,
        'Mayo': mayo, 
        'Junio': junio, 
        'Julio': julio, 
        'Agosto': agosto, 
        'Septiembre': septiem, 
        'Octubre': octubre, 
        'Noviembre': noviem, 
        'Diciembre': diciem
    };

    return meses;
}

