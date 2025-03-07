
$( function () {
    //CÓDIGO PARA BUSCAR ITEM PRESUPUESTARIO EN LA VISTA DE EDITAR PLANIFICACIÓN
    $('.single-select').select2({
        width: '100%',
    });

    const selectedItem = document.querySelector('#item_presupuestario').value;
    if (selectedItem) {
        fetchItemData(selectedItem);
    }

    $(document).on('change', '#monto, #frecuencia', function() {

        limpiar();

        var monDisp = $('#monDisp').val();
        var monto = $('#monto').val();
        var frecuencia = $('#frecuencia').val();

        monto = parseFloat(monto);    
        monDisp = parseFloat(monDisp);

        //var isValid = /^\d+$/.test(monto);
        var isValid = /^\d+(\.\d+)?$/.test(monto);

        if(monto === 0 && monDisp !== 0 && frecuencia !== '8' ){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'CoreInspi',
                text: 'Debe de ingresar un monto',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'CoreInspi',
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

                case '7':
                    limpiar();

                    break;

            }

        }


    });


    $('#monto').on('input', function () {
        validarInputNumerico(this);
    });

    $('#unidad_ejecutora').on('change', function() {

        var id_unidad = $('#unidad_ejecutora').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_programa_id?id_unidad='+id_unidad, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var programaSelect = $('#programa');
                programaSelect.empty(); // Limpia las opciones actuales

                programaSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un programa'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, programa) {
                    programaSelect.append($('<option>', {
                        value: programa.id,
                        text:  programa.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del programa', error);
            }
        });
    });

    $('#programa').on('change', function() {

        var id_programa = $('#programa').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_proyecto_id?id_programa='+id_programa, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var proyectoSelect = $('#proyecto');
                proyectoSelect.empty(); // Limpia las opciones actuales

                proyectoSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione un proyecto'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, proyecto) {
                    proyectoSelect.append($('<option>', {
                        value: proyecto.id,
                        text:  proyecto.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });

    $('#proyecto').on('change', function() {

        var id_proyecto = $('#proyecto').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_actividad_id?id_proyecto='+id_proyecto, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var actividadSelect = $('#actividad');
                actividadSelect.empty(); // Limpia las opciones actuales

                actividadSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione una actividad'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, actividad) {
                    actividadSelect.append($('<option>', {
                        value: actividad.id,
                        text:  actividad.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });

    $('#actividad').on('change', function() {

        var id_actividad = $('#actividad').val();

        // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/planificacion/get_fuente_id?id_actividad='+id_actividad, // Ruta en tu servidor para obtener las opciones
            success: function(data) {
                var fuenteSelect = $('#fuente_financiamiento');
                fuenteSelect.empty(); // Limpia las opciones actuales

                fuenteSelect.append($('<option>', {
                    value: 0,
                    text: 'Seleccione una fuente de financiamiento'
                }));

                // Agrega las nuevas opciones basadas en la respuesta del servidor
                $.each(data.valores, function(index, fuente) {
                    fuenteSelect.append($('<option>', {
                        value: fuente.id,
                        text:  fuente.nombre
                    }));
                });
            },
            error: function(error) {
                console.error('Error al obtener opciones del proyecto', error);
            }
        });
    });
});

function agregarComentario(){
    var formData = new FormData();

    let id_poa      = $('#id_poa').val();
    let estadoPoa      = $('#estadoPoa').val();
    let justificacionPoa  = $('#justificacionPoa').val();

    if(estadoPoa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar el estado de la actividad',
            showConfirmButton: true,
        });

    }else if(justificacionPoa == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe justificar su selección con un comentario',
            showConfirmButton: true,
        });

    }else{
        $.ajax({

            type: 'POST',
            url: '/planificacion/agregarComentario',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_poa : id_poa,
                justificacionPoa: justificacionPoa,
                estadoPoa: estadoPoa,
            },
            success: function(response) {

                if(response.data){

                    if(response['data'] == true){
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'CoreInspi',
                            text: response['message'],
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value == true) {

                                window.location.href = '/planificacion';

                            }
                        });

                    }
                }
            },
            error: function(error) {
                Swal.fire({
                    icon:  'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text:   error,
                    showConfirmButton: true,
                });
            }
        });
    }
    var table = $('#tblPlanificacionIndex').DataTable();

}

function agregarComentarioEstado(){
    var formData = new FormData();

    let id_poa            = $('#id_poa').val();
    let estadoPoa         = $('#estadoPoa').val();
    let justificacionPoa  = $('#justificacionPoa').val();
    let montoDis          = $('#montoDis').val();

    if(estadoPoa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar el estado de la actividad',
            showConfirmButton: true,
        });

    }else if(justificacionPoa == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe justificar su selección con un comentario',
            showConfirmButton: true,
        });

    }else if(montoDis == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de agregar el monto disponible del Item',
            showConfirmButton: true,
        });

    }else{
        $.ajax({

            type: 'POST',
            url: '/planificacion/agregarComentarioEstado',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_poa:           id_poa,
                justificacionPoa: justificacionPoa,
                estadoPoa:        estadoPoa,
                montoDis:         montoDis,
            },
            success: function(response) {

                if(response.data){

                    if(response['data'] == true){
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'CoreInspi',
                            text: response['message'],
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value == true) {

                                window.location.href = '/planificacion';

                            }
                        });

                    }
                }
            },
            error: function(error) {
                Swal.fire({
                    icon:  'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text:   error,
                    showConfirmButton: true,
                });
            }
        });
    }
    var table = $('#tblPlanificacionIndex').DataTable();

}



function agregarComentarioEstadoZonal(){
    var formData = new FormData();

    let id_poa      = $('#id_poa').val();
    let estadoPoa      = $('#estadoPoa').val();
    let justificacionPoa  = $('#justificacionPoa').val();
    let montoDis          = $('#montoDis').val();

    if(estadoPoa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar el estado de la actividad',
            showConfirmButton: true,
        });

    }else if(justificacionPoa == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe justificar su selección con un comentario',
            showConfirmButton: true,
        });

    }else if(montoDis == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de agregar el monto disponible del Item',
            showConfirmButton: true,
        });

    }else{
        $.ajax({

            type: 'POST',
            url: '/planificacion/agregarComentarioEstado',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id_poa:           id_poa,
                justificacionPoa: justificacionPoa,
                estadoPoa:        estadoPoa,
                montoDis:         montoDis,
            },
            success: function(response) {

                if(response.data){

                    if(response['data'] == true){
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'CoreInspi',
                            text: response['message'],
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value == true) {

                                window.location.href = '/planificacion/vistaUser';

                            }
                        });

                    }
                }
            },
            error: function(error) {
                Swal.fire({
                    icon:  'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text:   error,
                    showConfirmButton: true,
                });
            }
        });
    }
    var table = $('#tblPlanificacionIndex').DataTable();

}




//------------------------------------------------------------------------------------------------

function actualizarPlanificacion(){

    var formData = new FormData();
    let obOpera  = $('#obOpera').val();
    let actOpera = $('#actOpera').val();
    let subActi  = $('#subActi').val();

    let objetivo_op  = $('#id_obj_operativo').val();
    let actividad_op = $('#id_actividad_operativa').val();
    let sub_act  = $('#id_sub_actividad').val();
    // let desItem  = $('#desItem').val();
    let id_item_dir         = $('#item_presupuestario').val();
    let selectedOption      = $(`#item_presupuestario option[value="${id_item_dir}"]`);
    let item_presupuestario = selectedOption.attr("data-id_item");
    var proceso    = $('#proceso').val();

    let monto    = $('#monto').val();
    let monDisp  = $('#monDisp').val();
    monto   = parseFloat(monto);    
    monDisp = parseFloat(monDisp);
    // let presupuesto_proyectado    = $('#presupuesto_proyectado').val();
    // let monDisp  = $('#monDisp').val();
    let coordina = $('#coordina').val();
    // let nPOA     = $('#nPOA').val();
    let fecha    = $('#fecha').val();
    let poa      = $('#poa').val();
    let justifi  = $('#justifi').val();
    let comentario = $('#comentarioRetro').val();
    let plurianual = $('#plurianual').is(':checked') ? 1 : 0;

    let id_poa      = $('#id_poa').val();

    var frecuencia = $('#frecuencia').val();

    var unidad_ejecutora = $('#unidad_ejecutora').val();
    var programa = $('#programa').val();
    var proyecto = $('#proyecto').val();
    var actividad = $('#actividad').val();
    var fuente_financiamiento = $('#fuente_financiamiento').val();

    if(coordina == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Coordinación/Dirección/Proyecto.',
            showConfirmButton: true,
        });

    }else if(fecha == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Fecha.',
            showConfirmButton: true,
        });

    }else if(poa == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de selecionar un tipo de POA.',
            showConfirmButton: true,
        });

    }else if( proceso == '' || proceso == 0 ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de seleccionar un Tipo de Proceso.',
            showConfirmButton: true,
        });
    }else if( justifi == '' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar una Justificación del área requirente.',
            showConfirmButton: true,
        });

    }else if(obOpera == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar un Objetivo Operativo',
            showConfirmButton: true,
        });

    }else if(actOpera == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar la Actividad Operativa',
            showConfirmButton: true,
        });

    }else if(subActi == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar la Sub Actividad',
            showConfirmButton: true,
        });

    }else if(item_presupuestario == '0'){
       Swal.fire({
       icon: 'warning',
       type:  'warning',
       title: 'CoreInspi',
       text: 'Debe seleccionar el Item Presupuestario.',
       showConfirmButton: true,
    });

   }else if((monto == '0' || monto == '') && monDisp !== 0 && frecuencia !== '8' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de ingresar un Monto.',
            showConfirmButton: true,
        });

    }else if(unidad_ejecutora == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar una unidad ejecutora',
            showConfirmButton: true,
        });
    }else if(programa == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar un programa',
            showConfirmButton: true,
        });
    }else if(proyecto == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar un proyecto',
            showConfirmButton: true,
        });
    }else if(actividad == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar una actividad',
            showConfirmButton: true,
        });
    }else if(fuente_financiamiento == '0'){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe seleccionar una fuente de financiamiento',
            showConfirmButton: true,
        });
    }else if( frecuencia == '0' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe de seleccionar la Frecuencia.',
            showConfirmButton: true,
        });

    }else if (comentario == ''){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'CoreInspi',
            text: 'Debe describir la edición realizada.',
            showConfirmButton: true,
        });
    }else{
        if(validarCalculos()){

            let meses = obtenerMeses();

            let fecha = $('#fecha').val();
            let partesFecha = fecha.split('-');
            let anio = partesFecha[0];

            $.ajax({

                type: 'PUT',
                url: '/planificacion/actualizarPlanificacion/' + id_poa,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    obOpera : obOpera ,
                    actOpera: actOpera,
                    subActi : subActi ,
                    objetivo_op: objetivo_op,
                    actividad_op: actividad_op,
                    sub_act : sub_act,
                    // desItem : desItem ,
                    item_presupuestario: item_presupuestario,
                    id_item_dir:         id_item_dir,
                    monto:               monto,
                    // presupuesto_proyectado : presupuesto_proyectado,
                    unidad_ejecutora: unidad_ejecutora,
                    programa: programa,
                    proyecto: proyecto,
                    actividad: actividad,
                    fuente_financiamiento: fuente_financiamiento,
                    // monDisp : monDisp ,
                    coordina: coordina,
                    // nPOA    : nPOA    ,
                    fecha   : fecha   ,
                    poa     : poa     ,
                    justifi : justifi ,
                    comentario : comentario,
                    plurianual : plurianual,

                    frecuencia: frecuencia,
                    meses: meses,
                    anio:  anio,
                    proceso   : proceso,
                },
                success: function(response) {

                    if(response.data){

                        if(response['data'] == true){
                            Swal.fire({
                                icon: 'success',
                                type: 'success',
                                title: 'CoreInspi',
                                text: response['message'],
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.value == true) {

                                    window.location.href = '/planificacion/vistaUser';

                                }
                            });

                        }
                    }
                },
                error: function(error) {
                    Swal.fire({
                        icon:  'error',
                        title: 'CoreInspi',
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

    var montoDip   = parseFloat($('#monDisp').val() || 0);

    if(montoDip === '0.00'){

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
    
        // Redondear valores a dos decimales
        enero   = parseFloat(enero.toFixed(2));
        febre   = parseFloat(febre.toFixed(2));
        marzo   = parseFloat(marzo.toFixed(2));
        abril   = parseFloat(abril.toFixed(2));
        mayo    = parseFloat(mayo.toFixed(2));
        junio   = parseFloat(junio.toFixed(2));
        julio   = parseFloat(julio.toFixed(2));
        agosto  = parseFloat(agosto.toFixed(2));
        septiem = parseFloat(septiem.toFixed(2));
        octubre = parseFloat(octubre.toFixed(2));
        noviem  = parseFloat(noviem.toFixed(2));
        diciem  = parseFloat(diciem.toFixed(2));
    
        var suma = enero + febre + marzo + abril + mayo + junio + julio + agosto + septiem + octubre + noviem + diciem;

        if(suma === 0){

            return true;

        }else{

            let comentario = 'Si el monto del item es 0, su monto presupuestado debe de ser 0.';

            Swal.fire({
                icon: 'error',
                title: 'CoreInspi',
                text: comentario,
                showConfirmButton: true,
            });
    
            return false;

        }

    }else{

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
    
        // Redondear valores a dos decimales
        enero   = parseFloat(enero.toFixed(2));
        febre   = parseFloat(febre.toFixed(2));
        marzo   = parseFloat(marzo.toFixed(2));
        abril   = parseFloat(abril.toFixed(2));
        mayo    = parseFloat(mayo.toFixed(2));
        junio   = parseFloat(junio.toFixed(2));
        julio   = parseFloat(julio.toFixed(2));
        agosto  = parseFloat(agosto.toFixed(2));
        septiem = parseFloat(septiem.toFixed(2));
        octubre = parseFloat(octubre.toFixed(2));
        noviem  = parseFloat(noviem.toFixed(2));
        diciem  = parseFloat(diciem.toFixed(2));
    
        var suma = enero + febre + marzo + abril + mayo + junio + julio + agosto + septiem + octubre + noviem + diciem;
        var monto = parseFloat($('#monto').val() || 0);
    
        // Definir una tolerancia pequeña para la comparación
        var tolerancia = 0.01; // Aquí puedes ajustar la tolerancia según tus necesidades
    
        if (Math.abs(suma - monto) <= tolerancia) {
            return true;
        } else {
            let comentario = '';
    
            if (monto > suma) {
                var diferencia = (monto - suma).toFixed(2);
                comentario = 'Faltan $' + diferencia + ' para llegar al monto indicado.';
            } else {
                var diferencia = (suma - monto).toFixed(2);
                comentario = 'Tiene un excedente de $' + diferencia + '.';
            }
    
            Swal.fire({
                icon:  'error',
                title: 'CoreInspi',
                type:  'error',
                text: comentario,
                showConfirmButton: true,
            });
    
            return false;
        }

    }

}

$(document).on('change', '#monto, #frecuencia', function() {
    limpiar();

    var monto = parseFloat($('#monto').val());
    //var isValid = /^\d+$/.test(monto);
    var isValid = /^\d+(\.\d+)?$/.test(monto);

    if (monto === 0 || isNaN(monto)) {
        Swal.fire({
            icon: 'warning',
            title: 'CoreInspi',
            text: 'Debe ingresar un monto válido',
            showConfirmButton: true,
        });
    } else if (!isValid) {
        Swal.fire({
            icon: 'warning',
            title: 'CoreInspi',
            text: 'El monto no es válido',
            showConfirmButton: true,
        });
    } else {
        switch ($(this).val()) {
            case '1':
                var cuota = monto / 12;
                asignarCuota(cuota);
                break;
            case '2':
                var cuota = monto / 6;
                asignarCuota(cuota);
                break;
            case '3':
                var cuota = monto / 4;
                asignarCuota(cuota);
                break;
            case '4':
                var cuota = monto / 3;
                asignarCuota(cuota);
                break;
            case '5':
                var cuota = monto / 2;
                asignarCuota(cuota);
                break;
            case '6':
                var cuota = monto;
                asignarCuota(cuota);
                break;
        }
    }
});

function asignarCuota(cuota) {
    $('#enero').val(cuota.toFixed(2));
    $('#febre').val(cuota.toFixed(2));
    $('#marzo').val(cuota.toFixed(2));
    $('#abril').val(cuota.toFixed(2));
    $('#mayo').val(cuota.toFixed(2));
    $('#junio').val(cuota.toFixed(2));
    $('#julio').val(cuota.toFixed(2));
    $('#agosto').val(cuota.toFixed(2));
    $('#septiem').val(cuota.toFixed(2));
    $('#octubre').val(cuota.toFixed(2));
    $('#noviem').val(cuota.toFixed(2));
    $('#diciem').val(cuota.toFixed(2));
}

// Función para validar input numérico
function validarInputNumerico(input) {
    var inputValue = input.value;
    //var isValid = /^\d+$/.test(inputValue);
    var isValid = /^\d+(\.\d+)?$/.test(inputValue);

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

function limpiar(){

    $('#enero').val('0'); $('#febre').val('0'); $('#marzo').val('0');
    $('#abril').val('0'); $('#mayo').val('0'); $('#junio').val('0');
    $('#julio').val('0'); $('#agosto').val('0'); $('#septiem').val('0');
    $('#octubre').val('0'); $('#noviem').val('0'); $('#diciem').val('0');

}

function fetchItemData(itemId) {
    $.ajax({
        type: 'GET',
        url: '/planificacion/obtenerDatosItem/' + itemId,
        success: function(response) {
            // Rellenar los campos con los datos obtenidos
            $('#monDisp').val(response.monto);
            $('#desItem').val(response.descripcion);
        },
        error: function(error) {
            console.error('Error al obtener datos del item: ', error);
        }
    });
}


// function agregarUnidad(){
//     // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
//     $.ajax({
//         type: 'GET', // O el método que estés utilizando en tu ruta
//         url: '/planificacion/get_unidad', // Ruta en tu servidor para obtener las opciones
//         success: function(data) {
//             var unidadSelect = $('#unidad_ejecutora');
//             unidadSelect.empty(); // Limpia las opciones actuales

//             unidadSelect.append($('<option>', {
//                 value: 0,
//                 text: 'Seleccione una unidad ejecutora'
//             }));

//             // Agrega las nuevas opciones basadas en la respuesta del servidor
//             $.each(data.valores, function(index, unidad) {
//                 unidadSelect.append($('<option>', {
//                     value: unidad.id,
//                     text:  unidad.nombre
//                 }));
//             });
//         },
//         error: function(error) {
//             console.error('Error al obtener opciones de la unidad ejecutora', error);
//         }
//     });
// }
