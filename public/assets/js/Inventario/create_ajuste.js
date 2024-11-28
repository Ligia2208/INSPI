var contMovimiento = 0;
var contEgreso = 0;

$( function () {

    $('#usuarios').select2();

    $('.js-example-basic-single').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });

    //INICIALIZAR EL SELECT EN 0
    var selectElement = document.getElementById('tipo');
    selectElement.value = 'A';

    var selectDestino = $('#destino');
    selectDestino.val('0').trigger('change.select2');

});


function agregarOpciones(id) {


    var id_laboratorio = $('#destino').val();
    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerArticulosIdLab?id_laboratorio='+id_laboratorio,
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

            agregarSelect();

        },
        error: function (error) {
            var response = error.responseJSON;                
            Swal.fire({
                icon:  'error',
                title: 'SoftInspi',
                type:  'error',
                text:   response.message,
                showConfirmButton: true,
            });
        }
    });
}


function getName(input){

    var ruc = input.value;
    var isValid = /^\d{13}$/.test(ruc);

    if (!isValid) {
        input.setCustomValidity('El RUC no es válido');
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    } else {
        input.setCustomValidity('');
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/get_proveedor?ruc='+ruc,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
    
                var proveedor = res.nombre;
                $('#proveedor').val(proveedor);
    
            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   response.message,
                    showConfirmButton: true,
                });
            }
    
        });
    }
}


function agregarSelect(){
    $('.js-example-basic-single').select2({
        //theme: 'bootstrap4',
        width: '100%',
        //height: '30px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });
}

// ========================================================== EGRESO ==========================================================
function agregarArticuloEgre(){

    $('#cuerpoTablaEgreso').append(
        `
        <tr id="trDeleteEgre${contEgreso}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticuloE(${contEgreso})">
                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="number" id="u_total${contEgreso}" name="u_total" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>

            <input type="hidden" id="id_inventario${contEgreso}" name="id_inventario" class="form-control" required autofocus value="0" disabled>
            <td>
                <select id="nameArticuloE${contEgreso}" name="nameArticuloE" class="form-select single-select js-example-basic-single" onchange="cargarLote('nameArticuloE${contEgreso}', '${contEgreso}')">

                </select>
            </td>
            <td>
                <input type="text" id="cantidadE${contEgreso}" name="cantidadE" class="form-control" required="" autofocus="" value="" disabled>
            </td>
            <td>
                <select id="lote${contEgreso}" name="lote" class="form-select single-select js-example-basic-single" onchange="cargarUnidades('lote${contEgreso}', '${contEgreso}')">
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>

            <td>
                <input type="number" id="unidades${contEgreso}" name="unidades" class="form-control" required autofocus value="0" onchange="validaUnidades('${contEgreso}')">
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
        </tr>
        `
    );

    agregarOpciones('nameArticuloE'+contEgreso);

    $('#unidades' + contEgreso).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Evento para validar costo
    $('#u_total' + contEgreso).on('input', function () {
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
    
    //$('#totalMovimiento').remove();

    contEgreso++;

}



/* CARGA EL SELECT DEL LOTE */
function cargarLote(id, dato){

    let id_articulo    = $('#'+id).val();
    var id_laboratorio = $('#destino').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/articuloLoteIdLab?id_articulo=' + id_articulo+'&id_laboratorio='+id_laboratorio,
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

        },
        error: function(error) {
            var response = error.responseJSON;                
            Swal.fire({
                icon:  'error',
                title: 'SoftInspi',
                type:  'error',
                text:   response.message,
                showConfirmButton: true,
            });
        }
    });
}
/* CARGA EL SELECT DEL LOTE */




/* CARGA EL VALOR DE LA UNIDAD */
function cargarUnidades(id, dato){

    let id_lote = $('#'+id).val();
    var id_laboratorio = $('#destino').val();

    if(id_lote !== '0'){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/unidadLoteIdLab?id_lote=' + id_lote+'&id_laboratorio='+id_laboratorio,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
    
                let loteDatos = res.movimientos;
    
                //llenamos las unidades
                $('#u_total' + dato).val(loteDatos.unidades);
                $('#id_inventario' + dato).val(loteDatos.id);
    
                //llenamos las unidades
                $('#cantidadE' + dato). val(loteDatos.abreviatura+'('+loteDatos.nombre+')');
    
            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   response.message,
                    showConfirmButton: true,
                });
            }
        });    

    }

}
/* CARGA EL VALOR DE LA UNIDAD */



function eliminarArticuloE(dato){
    
    $('#trDeleteEgre'+dato).remove();

}



function guardarEgreso(){

    let nombre      = $('#nombre').val();
    let fecha       = $('#fecha').val();
    let tipo        = $('#tipo').val();
    let destino     = $('#destino').val();
    let transaccion = $('#transaccion').val();
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

    }else if(transaccion == '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el tipo de ajuste que se realizará',
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

    }else if(validarArticulosEgre()){

        var arraryData = capturarDatosEgre();

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/saveAjuste',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nombre':      nombre,
                'fecha':       fecha,
                'tipo':        tipo,
                'destino':     destino,
                'transaccion': transaccion,
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

                                window.location.href = '/inventario/movimiento';

                            }
                        });
                    }
                }
            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   response.message,
                    showConfirmButton: true,
                });
            }
        });

    }

}



function validarArticulosEgre() {
    let rowCount = $('tbody#cuerpoTablaEgreso tr').length;
    let transaccion = $('#transaccion').val();

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

    $('tbody#cuerpoTablaEgreso tr').each(function(index, row) {

        let nameArticulos = $(row).find('select[name="nameArticuloE"]');
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
        if (resultadoResta < 0 && transaccion == 'negativo') {
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





function capturarDatosEgre() {
    let movimientosArray = [];

    $('tbody#cuerpoTablaEgreso tr').each(function(index, row) {

        let movimientos = $(row).find('input[name="id_inventario"]');
        let unidades    = $(row).find('input[name="unidades"]');
        let uTotales    = $(row).find('input[name="u_total"]');
        let lotes       = $(row).find('select[name="lote"]');
        let id_articulos= $(row).find('select[name="nameArticuloE"]');

        // Verificar si hay elementos en el conjunto actual
        if (movimientos.length > 0) {
            // Obtener valores del conjunto actual
            let id_inventario = movimientos.eq(0).val().trim();  
            let unidad     = unidades.eq(0).val().trim();  
            let uTotal     = uTotales.eq(0).val().trim();  
            let lote       = lotes.eq(0).val();
            let id_articulo= id_articulos.eq(0).val();

            // Validar si todos los campos están llenos
            if (id_inventario !== 'negativo') {

                movimientosArray.push({

                    id_inventario: id_inventario,
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


function selectLaboratorio(){

    $('#table_ajuste').find('tbody').empty();

}


/* VALIDAR UNIDADES A TRANSFERIR */
function validaUnidades(dato){

    var u_total    = $('#u_total' + dato).val();
    var inputValue = $('#unidades' + dato).val();
    let transaccion = $('#transaccion').val();
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
    
            if (resp < 0 && transaccion == 'negativo') {
    
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'No se puede Ajustar mas Unidades de las que dispone en la Fila ' + nuevoDato,
                    showConfirmButton: true,
                });
    
            }
    
        }

    }
    
}

/* VALIDAR UNIDADES A TRANSFERIR */
