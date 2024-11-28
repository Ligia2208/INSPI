var contMovimiento = 0;

$( function () {

    $('.single-select').select2({
        width: '100%',
    });


    /* ============================================================== CARGA MASIVA ============================================================== */
    /*
    document.getElementById('importButton').addEventListener('click', function() {
        var form = document.getElementById('importForm');
        var formData = new FormData(form);

        let nombre      = $('#nombre').val();
        let fecha       = $('#fecha').val();
        let tipo        = $('#tipo').val();
        let origen      = $('#origen').val();
        let descripcion = $('#descripcion').val();
    
        if(nombre == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un nombre',
                showConfirmButton: true,
            });
    
        }else if(fecha == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una Fecha',
                showConfirmButton: true,
            });
    
        }else if(tipo == '0'){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar un tipo de movimiento',
                showConfirmButton: true,
            });
    
        }else if(origen == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un lugar de origen',
                showConfirmButton: true,
            });
    
        }else if(descripcion == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una descripción',
                showConfirmButton: true,
            });
    
        }else{

            formData.append('nombre', nombre);
            formData.append('fecha', fecha);
            formData.append('tipo', tipo);
            formData.append('origen', origen);
            formData.append('descripcion', descripcion);

            $.ajax({
                type: 'POST',
                url: '/inventario/import',
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
                            title: 'SoftInspi',
                            text: response.message,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '/inventario/movimiento';
                            }
                        });
    
                    } else {
    
                        Swal.fire({
                            icon: 'error',
                            type:  'error',
                            title: 'SoftInspi',
                            text: response.message,
                            showConfirmButton: true,
                        });
    
                    }
                },
                error: function(error) {
                    
                    Swal.fire({
                        icon: 'error',
                        type:  'error',
                        title: 'SoftInspi',
                        text: 'Error al enviar la solicitud AJAX: '+ error,
                        showConfirmButton: true,
                    });

                }
            });

        }


    });
    */
    /* ============================================================== CARGA MASIVA ============================================================== */



});



function agregarArticulo(){

    $('#cuerpoTablaMovimiento').append(
        `
        <tr id="trDeleteMov${contMovimiento}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticulo(${contMovimiento})">
                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="number" id="u_total${contMovimiento}" name="u_total" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>

            <input type="hidden" id="id_movimiento${contMovimiento}" name="id_movimiento" class="form-control" required autofocus value="0" disabled>
            <td>
                <select id="nameArticulo${contMovimiento}" name="nameArticulo" class="form-control single-select" onchange="cargarLote('nameArticulo${contMovimiento}', '${contMovimiento}')">
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>
            <td>
                <input type="text" id="cantidad${contMovimiento}" name="cantidad" class="form-control" required="" autofocus="" value="" disabled>
            </td>
            <td>
                <select id="lote${contMovimiento}" name="lote" class="form-control single-select" onchange="cargarUnidades('lote${contMovimiento}', '${contMovimiento}')">
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>

            <td>
                <input type="number" id="unidades${contMovimiento}" name="unidades" class="form-control" required autofocus value="0" onchange="validaUnidades('${contMovimiento}')">
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
        </tr>
        `
    );

    agregarOpciones('nameArticulo'+contMovimiento);

    $('.single-select').select2({
        width: '100%',
    });

    $('#unidades' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Evento para validar costo
    $('#u_total' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
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
    
    $('#totalMovimiento').remove();


    /*
    $('#cuerpoTablaMovimiento').append(`
    
        <tr id="totalMovimiento">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong class="fs-4">Total:</strong></td>
            <td><input type="text" id="total" name="total" class="form-control" required="" autofocus="" value="" disabled></td>
        </tr>

    `);
    */

    contMovimiento++;

}


function agregarOpciones(id) {

    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerArticulosLab',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(data){

            selectArticulo.empty();
            selectArticulo.append('<option value="0">Seleccione Opción</option>');

            $.each(data, function (index, articulo) {
                selectArticulo.append('<option value="' + articulo.id + '">' + articulo.nombre + '</option>');
            });

        },
        error: function (error) {
            console.error('Error al obtener la lista de artículos:', error);
        }
    });
}


/* CARGA EL SELECT DEL LOTE */
function cargarLote(id, dato){

    let id_articulo = $('#'+id).val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/articuloLote/' + id_articulo,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            let loteDatos = res.resultados;
            let selectLote = $('#lote' + dato);

            selectLote.empty();
            selectLote.append('<option value="0">Seleccione Opción</option>');

            $.each(loteDatos, function (index, lote) {
                selectLote.append('<option value="' + lote.id + '">' + lote.nombre +' - CAD. ' + lote.f_caduca+'</option>');
            });

            //llenamos las unidades
            $('#cantidad' + dato). val(res.unidades.abreviatura+'('+res.unidades.nombre+')');

        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL SELECT DEL LOTE */


/* CARGA EL VALOR DE LA UNIDAD */
function cargarUnidades(id, dato){

    let id_lote = $('#'+id).val();

    if(id_lote !== '0'){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/unidadLote/' + id_lote,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
    
                let loteDatos = res.movimientos;
    
                //llenamos las unidades
                $('#u_total' + dato).val(loteDatos.unidades);
                $('#id_movimiento' + dato).val(loteDatos.id);
    
                validaUnidades(dato);
    
            },
            error: function(error) {
                console.error('Error al obtener los datos de la categoría:', error);
            }
    
        });    

    }

}
/* CARGA EL VALOR DE LA UNIDAD */




/* VALIDAR UNIDADES A TRANSFERIR */
function validaUnidades(dato){

    var u_total    = $('#u_total' + dato).val();
    var inputValue = $('#unidades' + dato).val();
    var isValid = /^\d+$/.test(inputValue);

    var nameArticulo = $('#nameArticulo' + dato).val();
    var lote = $('#lote' + dato).val();

    var nuevoDato = parseInt(dato) + 1;

    if((nameArticulo !== '0' && lote !== '0')){

        if (!isValid) {

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar números enteros en el campo Unidades Fila ' + nuevoDato,
                showConfirmButton: true,
            });
    
        } else {
    
            var resp = u_total - inputValue;
    
            if (resp < 0) {
    
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'No se puede transferir mas Unidades de las que dispone en la Fila ' + nuevoDato,
                    showConfirmButton: true,
                });
    
            }
    
        }

    }
    
}

/* VALIDAR UNIDADES A TRANSFERIR */




function eliminarArticulo(dato){
    
    $('#trDeleteMov'+dato).remove();

}


function guardarMovimiento(){

    let nombre      = $('#nombre').val();
    let fecha       = $('#fecha').val();
    let tipo        = $('#tipo').val();
    let destino     = $('#destino').val();
    let descripcion = $('#descripcion').val();

    if(nombre == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un nombre',
            showConfirmButton: true,
        });

    }else if(fecha == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una Fecha',
            showConfirmButton: true,
        });

    }else if(tipo == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar un tipo de movimiento',
            showConfirmButton: true,
        });

    }else if(destino == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un laboratorio de destino',
            showConfirmButton: true,
        });

    }else if(descripcion == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una descripción',
            showConfirmButton: true,
        });

    }else if(validarArticulos()){

        var arraryData = capturarDatos();

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/saveTransferencia',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombre':      nombre,
                'fecha':       fecha,
                'tipo':        tipo,
                'destino':     destino,
                'descripcion': descripcion,
                'arraryData':  arraryData,
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

                                window.location.href = '/inventario/laboratorio';

                            }
                        });

                    }
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
            }
        });



    }


}



function validarArticulos() {
    let rowCount = $('tbody#cuerpoTablaMovimiento tr').length;

    if (rowCount === 0) {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: 'Debe tener al menos un movimiento',
            showConfirmButton: true,
        });
        return false;
    }

    let isValid = true;

    $('tbody#cuerpoTablaMovimiento tr').each(function(index, row) {

        let nameArticulos = $(row).find('select[name="nameArticulo"]');
        let lote = $(row).find('select[name="lote"]');
        let unidades = $(row).find('input[name="unidades"]');
        let uTotal = $(row).find('input[name="u_total"]');

        let isNameArticuloEmpty = nameArticulos.val() === '0';
        let isLoteEmpty = lote.val() === '0';
        let isUnidadesEmpty = unidades.val().trim() === '0';

        let uTotalValue = parseInt(uTotal.val());
        let unidadesValue = parseInt(unidades.val());

        // Validar que unidades sea un número entero
        let unidadesRegex = /^[0-9]+$/;
        let isUnidadesValid = unidadesRegex.test(unidades.val().trim());

        if (isNameArticuloEmpty || isLoteEmpty || isUnidadesEmpty || !isUnidadesValid) {
            isValid = false;

            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Al menos un campo está vacío o el campo unidades no es un número entero en el conjunto ' + (index + 1),
                showConfirmButton: true,
            });

            return false;
        }

        let resultadoResta = uTotalValue - unidadesValue;
        if (resultadoResta < 0) {
            isValid = false;

            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'La resta de u_total y unidades es negativa en el conjunto ' + (index + 1),
                showConfirmButton: true,
            });

            return false;
        }

    });

    return isValid;
}





function capturarDatos() {
    let movimientosArray = [];

    $('tbody#cuerpoTablaMovimiento tr').each(function(index, row) {

        let movimientos = $(row).find('input[name="id_movimiento"]');
        let unidades    = $(row).find('input[name="unidades"]');
        let uTotales    = $(row).find('input[name="u_total"]');
        let lotes       = $(row).find('select[name="lote"]');
        let id_articulos= $(row).find('select[name="nameArticulo"]');


        // Verificar si hay elementos en el conjunto actual
        if (movimientos.length > 0) {
            // Obtener valores del conjunto actual
            let movimiento = movimientos.eq(0).val().trim();  
            let unidad     = unidades.eq(0).val().trim();  
            let uTotal     = uTotales.eq(0).val().trim();  
            let lote       = lotes.eq(0).val();
            let id_articulo= id_articulos.eq(0).val();

            // Validar si todos los campos están llenos
            if (movimiento !== '') {

                movimientosArray.push({

                    movimiento: movimiento,
                    unidad: unidad,
                    uTotal: uTotal,
                    lote:   lote,
                    id_articulo: id_articulo,

                });

            }
        }
    });

    return movimientosArray;
}
