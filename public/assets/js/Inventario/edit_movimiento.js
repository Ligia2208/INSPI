var contMovimiento = 0;
var contEgreso = 0;

$( function () {

    //ocualta el cuerpo del traspaso/egreso
    $('#cuerpoEgreso').hide();
    $('#cuerpoIngreso').show();

    //$('#usuarios').select2();

    $('.js-example-basic-single').select2({
        width: '100%',
    });

    // ==================== INICIALIZAR LOS SELECTS
    var id_tipoSele = document.getElementById('id_tipoSele').value;
    var selectElement = document.getElementById('tipo');
    selectElement.value = id_tipoSele;
    selectTipo();

    var id_destSele = document.getElementById('id_destinoSele').value;
    $('#destino').val(id_destSele).trigger('change.select2');

    var id_recibSele = document.getElementById('id_recibeSele').value;
    $('#recibe').val(id_recibSele).trigger('change.select2');
    // ==================== INICIALIZAR LOS SELECTS

    cargarMovimientos();


    /* ============================================================== CARGA MASIVA ============================================================== */

    document.getElementById('importButton').addEventListener('click', function() {
        var form = document.getElementById('importForm');
        var formData = new FormData(form);

        let nombre      = $('#nombre').val();
        let fecha       = $('#fecha').val();
        let tipo        = $('#tipo').val();
        let origen      = $('#origen').val();
        let descripcion = $('#descripcion').val();

        let proveedor   = $('#proveedor').val();
        let destino     = $('#destino').val();
        let recibe      = $('#recibe').val();
        let noIngreso   = $('#noIngreso').val();
        let numero      = $('#numero').val();
    
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
    
        }else if(proveedor == ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un proveedor',
                showConfirmButton: true,
            });
    
        }else if(destino == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el laboratorio de destino',
                showConfirmButton: true,
            });
    
        }else if(recibe == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la persona que recibe',
                showConfirmButton: true,
            });
    
        }else if(noIngreso == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un Número de Ingreso',
                showConfirmButton: true,
            });
    
        }else if(numero == ''){
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un Número',
                showConfirmButton: true,
            });
    
        }else{

            formData.append('nombre', nombre);
            formData.append('fecha', fecha);
            formData.append('tipo', tipo);
            formData.append('origen', origen);
            formData.append('descripcion', descripcion);

            formData.append('proveedor', proveedor);
            formData.append('destino', destino);
            formData.append('recibe', recibe);
            formData.append('noIngreso', noIngreso);
            formData.append('numero', numero); 

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


    });

    /* ============================================================== CARGA MASIVA ============================================================== */



});



function agregarMovimiento(){

    $('#cuerpoTablaMovimiento').append(
        `
        <tr id="trDeleteMov${contMovimiento}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticulo(${contMovimiento})">
                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="hidden" id="id_movimiento${contMovimiento}" name="id_movimiento" value="0" >
                <input type="number" id="unidades${contMovimiento}" name="unidades" class="form-control" required autofocus value="0" onchange="cargarTotal('${contMovimiento}')">
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td>
                <select id="nameArticulo${contMovimiento}" name="nameArticulo" class="form-select single-select js-example-basic-single">
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>

            <td>
                <!-- <input type="text" id="cantidad" name="cantidad" class="form-control" required="" autofocus="" value=""> -->
                <select id="cantidad${contMovimiento}" name="cantidad" class="form-select single-select js-example-basic-single">

                </select>
            </td>
            <td>
                <label class="switch"> 
                    <input type="checkbox" id="caduca${contMovimiento}" name="caduca" checked onchange="toggleFechas(${contMovimiento})">
                    <span class="slider round"></span>
                </label>
            </td>
            <td><input type="date" id="elaF${contMovimiento}" name="elaF" class="form-control" required="" autofocus="" value=""></td>
            <td><input type="date" id="expF${contMovimiento}" name="expF" class="form-control" required="" autofocus="" value=""></td>
            <td>
                <input type="hidden" id="id_lote" name="id_lote" value="0"></input>
                <input type="text" id="lote" name="lote" class="form-control" required="" autofocus="" value="">
            </td>
            <!--
            <td>
                <select id="marcaArticulo${contMovimiento}" name="marcaArticulo" class="form-select single-select js-example-basic-single">
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>
            -->
            <td>
                <input type="number" id="costo${contMovimiento}" name="costo" class="form-control" required="" autofocus="" value="0" onchange="cargarTotal('${contMovimiento}')">
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td><input type="text" id="costoTotal${contMovimiento}" name="costoTotal" class="form-control" required="" autofocus="" value="" disabled></td>
        </tr>
        `
    );

    agregarOpciones('nameArticulo'+contMovimiento);
    //cargarMarca('marcaArticulo'+contMovimiento);
    cargarUnidad('cantidad'+contMovimiento);

    $('#unidades' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Evento para validar costo
    $('#costo' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Función para validar input numérico
    function validarInputNumerico(input) {
        var inputValue = input.value;
        var isValid = /^-?\d*\.?\d+$/.test(inputValue);
    
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

    $('#cuerpoTablaMovimiento').append(`
    
        <tr id="totalMovimiento">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <!-- <td></td> -->
            <td></td>
            <td><strong class="fs-4">Total:</strong></td>
            <td><input type="text" id="total" name="total" class="form-control" required="" autofocus="" value="" disabled></td>
        </tr>

    `);

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
        url: '/inventario/obtenerArticulos',
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


/* TRAE TODAS LAS MARCAS */
function cargarMarca(id){

    var selectMarca = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerMarcas',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            selectMarca.empty();
            selectMarca.append('<option value="0">Seleccione Opción</option>');

            $.each(res, function (index, marca) {
                selectMarca.append('<option value="' + marca.id + '">' + marca.nombre + '</option>');
            });

            agregarSelect();

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
/* TRAE TODAS LAS MARCAS */


/* TRAE TODAS LAS UNIDADES DE MEDIDA */
function cargarUnidad(id){

    var selectMarca = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/unidad',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            selectMarca.empty();
            selectMarca.append('<option value="0">Seleccione Opción</option>');

            $.each(res.data, function (index, marca) {
                selectMarca.append('<option value="' + marca.id + '">' + marca.nombre + ' - '+ marca.abreviatura + '</option>');
            });

            agregarSelect();

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
/* TRAE TODAS LAS UNIDADES DE MEDIDA */


function cargarTotal(dato){

    let cantidad = parseInt($('#unidades' + dato).val(), 10);
    let costo = $('#costo' + dato).val();

    let total = cantidad * costo;

    $('#costoTotal'+dato).val(total);

    //calcular total
    calcularTotalCosto();

}


function calcularTotalCosto() {

    let elementosCostoTotal = $('input[name="costoTotal"]');
    let total = 0;

    elementosCostoTotal.each(function () {
        let valor = parseFloat($(this).val()) || 0; 
        total += valor;
    });

    $('#total').val(total);

}



function eliminarArticulo(dato){
    
    $('#trDeleteMov'+dato).remove();

}


function guardarMovimiento(){

    let id_acta     = $('#id_acta').val();

    let nombre      = $('#nombre').val();
    let fecha       = $('#fecha').val();
    let tipo        = $('#tipo').val();
    let descripcion = $('#descripcion').val();
    let total       = $('#total').val();

    let proveedor   = $('#proveedor').val();
    let destino     = $('#destino').val();
    let recibe      = $('#recibe').val();
    
    let n_contrato  = $('#n_contrato').val();
    let factura     = $('#factura').val();

    Swal.fire({
        icon: 'warning',
        type: 'warning',
        title: 'SoftInspi',
        text: 'Seguro que quiere aplicar la transacción.',
        showConfirmButton: true,
        confirmButtonText: 'Sí, aplicar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value == true) {

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
        
            }else if(descripcion == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de ingresar una descripción',
                    showConfirmButton: true,
                });
        
            }else if(proveedor == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de ingresar un proveedor',
                    showConfirmButton: true,
                });
        
            }else if(destino == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de ingresar el laboratorio de destino',
                    showConfirmButton: true,
                });
        
            }else if(recibe == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de seleccionar la persona que recibe',
                    showConfirmButton: true,
                });
        
            }else if(tipo == 'C' && factura == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de ingresar un Número factura',
                    showConfirmButton: true,
                });
        
            }else if(n_contrato == ''){
        
                Swal.fire({
                    icon: 'warning',
                    type:  'warning',
                    title: 'SoftInspi',
                    text: 'Debe de ingresar un Número de contrato/compra/catálogo.',
                    showConfirmButton: true,
                });
        
            }else if(validarArticulos()){
        
                var arraryData = capturarDatos();
                //console.log(arraryData);
        
                $.ajax({
        
                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/inventario/editMovimiento',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id_acta':     id_acta,
                        'nombre':      nombre,
                        'fecha':       fecha,
                        'tipo':        tipo,
                        'descripcion': descripcion,
                        'total':       total,
                        'proveedor':   proveedor,
                        'destino':     destino,
                        'recibe':      recibe,
                        'factura':     factura,
                        'n_contrato':  n_contrato,
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
    });

}


function validarArticulos() {
    let rowCount = $('tbody#cuerpoTablaMovimiento tr').length;

    if (rowCount === 1) {
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
        let uni_medidas = $(row).find('select[name="cantidad"]');
        let unidades = $(row).find('input[name="unidades"]');
        let nameArticulos = $(row).find('select[name="nameArticulo"]');
        //let marcaArticulo = $(row).find('select[name="marcaArticulo"]');
        let expF = $(row).find('input[name="expF"]');
        let elaF = $(row).find('input[name="elaF"]');
        let lote = $(row).find('input[name="lote"]');
        let costo = $(row).find('input[name="costo"]');
        let caduca = $(row).find('input[name="caduca"]');
        let isCaducaChecked = caduca.is(':checked');

        if (uni_medidas.length !== 0) {
            if (
                uni_medidas.val() === '0' ||
                unidades.val().trim() === '' ||
                costo.val().trim() === '' ||
                costo.val().trim() === '0' ||
                nameArticulos.val() === '0' ||
                (isCaducaChecked && (expF.val().trim() === '' || elaF.val().trim() === '')) ||
                (isCaducaChecked && caduca.val() === '0')
                || lote.val().trim() === '' 
            ) {
                isValid = false;

                Swal.fire({
                    icon: 'warning',
                    type: 'warning',
                    title: 'SoftInspi',
                    text: 'Al menos un campo está vacío en el conjunto ' + (index + 1),
                    showConfirmButton: true,
                });

                return false;
            }
        }
    });

    return isValid;
}



function capturarDatos() {
    let movimientos = [];

    $('tbody#cuerpoTablaMovimiento tr').each(function(index, row) {
        let id_movimientos = $(row).find('input[name="id_movimiento"]');
        let uni_medidas   = $(row).find('select[name="cantidad"]');
        let unidades      = $(row).find('input[name="unidades"]');
        let nameArticulos = $(row).find('select[name="nameArticulo"]');
        //let marcaArticulo = $(row).find('select[name="marcaArticulo"]');
        let costos        = $(row).find('input[name="costo"]');
        let costoTotales  = $(row).find('input[name="costoTotal"]');
        let expFs         = $(row).find('input[name="expF"]');
        let elaFs         = $(row).find('input[name="elaF"]');
        let lotes         = $(row).find('input[name="lote"]');
        let caducaInputs  = $(row).find('input[name="caduca"]');
        let id_lotes      = $(row).find('input[name="id_lote"]');

        // Verificar si hay elementos en el conjunto actual
        if (uni_medidas.length > 0) {
            // Obtener valores del conjunto actual
            let uni_medida = uni_medidas.eq(0).val();  
            let unidad     = unidades.eq(0).val().trim();
            let articulo   = nameArticulos.eq(0).val();
            //let marca      = marcaArticulo.eq(0).val();        
            let costo      = costos.eq(0).val().trim();
            let costoTotal = costoTotales.eq(0).val().trim();
            let expF       = expFs.eq(0).val().trim();
            let elaF       = elaFs.eq(0).val().trim();
            let lote       = lotes.eq(0).val().trim();
            let caduca     = caducaInputs.eq(0).prop('checked');

            let id_movimiento = id_movimientos.eq(0).val().trim();
            let id_lote    = id_lotes.eq(0).val().trim();

            // Validar si todos los campos están llenos
            if (uni_medida !== '0' && unidad !== '' && articulo !== '0' && costo !== '' && costoTotal !== '' && lote !== '' && costo !== '' ) {

                movimientos.push({
                    id_movimiento: id_movimiento,
                    uni_medida: uni_medida,
                    unidad:     unidad,
                    articulo:   articulo,
                    //marca:    marca,
                    costo:      costo,
                    costoTotal: costoTotal,
                    caduca:     caduca,
                    expF:       expF,
                    elaF:       elaF,
                    lote:       lote,
                    id_lote:    id_lote,
                });

            }
        }
    });

    return movimientos;
}



function toggleFechas(contMovimiento) {
    var checkbox = document.getElementById(`caduca${contMovimiento}`);
    var elaF = document.getElementById(`elaF${contMovimiento}`);
    var expF = document.getElementById(`expF${contMovimiento}`);

    elaF.disabled = !checkbox.checked;
    expF.disabled = !checkbox.checked;

    if (!checkbox.checked) {
        elaF.value = '';
        expF.value = '';
    }

}



function selectTipo(){
    var tipoMovi = $('#tipo').val();

    if(tipoMovi != '0'){

        if(tipoMovi == 'I'){
            $('#cuerpoEgreso').hide();
            $('#cuerpoIngreso').show();
            document.getElementById('factura').disabled = true;
            document.getElementById('proveedor').disabled = true;
            document.getElementById('n_contrato').disabled = true;
        }else if(tipoMovi == 'E' || tipoMovi == 'T' || tipoMovi == 'A'){

            $('#cuerpoEgreso').show();
            $('#cuerpoIngreso').hide();
            document.getElementById('factura').disabled = true;
            document.getElementById('proveedor').disabled = true;
            document.getElementById('n_contrato').disabled = true;

        }else{
            //solo porque ahora es visualizar
            $('#cuerpoEgreso').hide();
            $('#cuerpoIngreso').show();
            //document.getElementById('factura').disabled = false;
            //document.getElementById('proveedor').disabled = false;
            //document.getElementById('n_contrato').disabled = false;

            document.getElementById('factura').disabled = true;
            document.getElementById('proveedor').disabled = true;
            document.getElementById('n_contrato').disabled = true;
        }

    }

}



/* ====================================== GUARDAR ARTICULO ====================================== */
$(document).on('click', '#btnArticuloM', function(){
        
    var nameArticulo   = document.getElementById("nameArticulo").value;
    var id_categoria   = document.getElementById("categoriaArti").value;
    var id_unidad      = document.getElementById("unidadaArticulo").value;

    //var isValid = /^\d+$/.test(precioArticulo);

    if(nameArticulo === ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un nombre',
            showConfirmButton: true,
        });

    }else if(id_categoria === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar una categoría',
            showConfirmButton: true,
        });

    }else if(id_unidad === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar una unidad de medida',
            showConfirmButton: true,
        });

    }else{

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/saveArticulo',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nameArticulo':   nameArticulo,
                //'precioArticulo': precioArticulo,
                'id_categoria':   id_categoria,
                'id_unidad':      id_unidad,
            },
            success: function(response) {

                if(response.data){

                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'SoftInspi',
                        text: response['message'],
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {

                            //table.ajax.reload(); //actualiza la tabla 
                            document.getElementById('btnCerrarModal').click(); 
                            $('#nameArticulo').val('');
                            $('#categoriaArti').val('0'); 
                            $('#unidadaArticulo').val('0'); 

                        }
                    });

                }else{
                    Swal.fire({
                        icon: 'error',
                        type:  'error',
                        title: 'SoftInspi',
                        text: response.message,
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {

                            document.getElementById('btnCerrarModal').click(); 
                            $('#nameArticulo').val('');
                            $('#categoriaArti').val('0'); 
                            $('#unidadaArticulo').val('0'); 

                        }
                    });
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
});

/* ====================================== GUARDAR ARTICULO ====================================== */



$(document).on('click', '#btnCategoriaM', function(){
        
    var nameCategoria = document.getElementById("nameCategoriaM").value;

    if(nameCategoria === ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un nombre',
            showConfirmButton: true,
        });

    }else{

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/saveCategoria',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nameCategoria': nameCategoria,
            },
            success: function(response) {

                //console.log(response.data['id_chat'])
                if(response.data){

                    listCategoria();
                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'SoftInspi',
                        text: response['message'],
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {
                            document.getElementById('btnCerrarModalCate').click(); //cerrar modal
                            $('#nameCategoriaM').val('');
                        }
                    });

                }else{
                    Swal.fire({
                        icon: 'error',
                        type:  'error',
                        title: 'SoftInspi',
                        text: response.message,
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {
                            document.getElementById('btnCerrarModalCate').click(); //cerrar modal
                            $('#nameCategoriaM').val('');
                        }
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
});



$(document).on('click', '#btnMarcaM', function(){
        
    var nameMarca = document.getElementById("nameMarcaM").value;

    if(nameMarca === ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un nombre',
            showConfirmButton: true,
        });

    }else{

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/saveMarca',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nameMarca': nameMarca,
            },
            success: function(response) {

                //console.log(response.data['id_chat'])
                if(response.data){

                    Swal.fire({
                        icon: 'success',
                        type: 'success',
                        title: 'SoftInspi',
                        text: response['message'],
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {
                            document.getElementById('btnCerrarModalMarca').click(); //cerrar modal
                            $('#nameMarcaM').val('');
                        }
                    });

                }else{
                    Swal.fire({
                        icon: 'error',
                        type:  'error',
                        title: 'SoftInspi',
                        text: response.message,
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.value == true) {
                            document.getElementById('btnCerrarModalMarca').click(); //cerrar modal
                            $('#nameMarcaM').val('');
                        }
                    });
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
});



function listCategoria(){

    var selectCategoria = $('#categoriaArti');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/categoria',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            selectCategoria.empty();
            selectCategoria.append('<option value="0">Seleccione Opción</option>');

            $.each(res.data, function (index, categ) {
                selectCategoria.append('<option value="' + categ.id + '">' + categ.nombre + '</option>');
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
                console.error('Error al obtener el nombre del proveedor:', error);
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
                <input type="hidden" id="id_movimiento${contEgreso}" name="id_movimiento" value="0" >
                <input type="number" id="u_total${contEgreso}" name="u_total" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>

            <input type="hidden" id="id_movimiento${contEgreso}" name="id_movimiento" class="form-control" required autofocus value="0" disabled>
            <td>
                <select id="nameArticuloE${contEgreso}" name="nameArticuloE" class="form-select single-select js-example-basic-single" onchange="cargarLote('nameArticuloE${contEgreso}', '${contEgreso}')" disabled>
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>
            <td>
                <input type="text" id="cantidadE${contEgreso}" name="cantidadE" class="form-control" required="" autofocus="" value="" disabled>
            </td>
            <td>
                <select id="lote${contEgreso}" name="lote" class="form-select single-select js-example-basic-single" onchange="cargarUnidades('lote${contEgreso}', '${contEgreso}')" disabled>
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>

            <td>
                <input type="number" id="unidades${contEgreso}" name="unidades" class="form-control" required autofocus value="0" onchange="validaUnidades('${contEgreso}')" disabled>
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
            $('#cantidadE' + dato). val(res.unidades.abreviatura+'('+res.unidades.nombre+')');

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
    
                //validaUnidades(dato);
    
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
    let descripcion = $('#descripcion').val();

    let id_acta     = $('#id_acta').val();

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

    }else if(validarArticulosEgre()){

        var arraryData = capturarDatosEgre();

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/editTransferencia',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id_acta':     id_acta,
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





function capturarDatosEgre() {
    let movimientosArray = [];

    $('tbody#cuerpoTablaEgreso tr').each(function(index, row) {

        let id_movimientos = $(row).find('input[name="id_movimiento"]');
        let id_inventarios = $(row).find('input[name="id_inventario"]');
        let unidades    = $(row).find('input[name="unidades"]');
        let uTotales    = $(row).find('input[name="u_total"]');
        let lotes       = $(row).find('select[name="lote"]');
        let id_articulos= $(row).find('select[name="nameArticuloE"]');

        // Verificar si hay elementos en el conjunto actual
        if (movimientos.length > 0) {
            // Obtener valores del conjunto actual
            let id_movimiento = id_movimientos.eq(0).val().trim();  
            let id_inventario = id_inventarios.eq(0).val().trim();  
            let unidad     = unidades.eq(0).val().trim();  
            let uTotal     = uTotales.eq(0).val().trim();  
            let lote       = lotes.eq(0).val();
            let id_articulo= id_articulos.eq(0).val();

            // Validar si todos los campos están llenos
            if (movimiento !== '') {

                movimientosArray.push({

                    id_inventario: id_inventario,
                    id_movimiento: id_movimiento,
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




/* CARGA LOS MOVIMIENTOS QUE SE HICIERON */
function cargarMovimientos(){

    let id_acta = $('#id_acta').val();
    let tipo    = $('#tipo').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/getMoviemientos/' + id_acta,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            let loteDatos = res;

            loteDatos.forEach(function(datos) {
                //console.log(item.id, item.nombre);
                if(tipo == 'I' || tipo == 'C'){
                    agregarMovimientoEdit(datos);
                }else if(tipo == 'E' || tipo == 'T' || tipo == 'A'){
                    agregarArticuloEgreEdit(datos);
                }

            });

            //console.log(loteDatos);

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
/* CARGA LOS MOVIMIENTOS QUE SE HICIERON */


function agregarMovimientoEdit(datos){

    $('#cuerpoTablaMovimiento').append(
        `
        <tr id="trDeleteMov${contMovimiento}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticulo(${contMovimiento})">
                <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="hidden" id="id_movimiento${contMovimiento}" name="id_movimiento" value="${datos.id}" >
                <input type="number" id="unidades${contMovimiento}" name="unidades" class="form-control" required autofocus value="${datos.unidades}" onchange="cargarTotal('${contMovimiento}')" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td>
                <select id="nameArticulo${contMovimiento}" name="nameArticulo" class="form-select single-select js-example-basic-single" disabled>
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>

            <td>
                <select id="cantidad${contMovimiento}" name="cantidad" class="form-select single-select js-example-basic-single" disabled>
                </select>
            </td>
            <td>
                <label class="switch"> 
                <input type="checkbox" id="caduca${contMovimiento}" name="caduca" ${ datos.caduca == 'true' ? 'checked' : '' }  onchange="toggleFechas(${contMovimiento})" disabled>
                    <span class="slider round"></span>
                </label>
            </td>
            <td><input type="date" id="elaF${contMovimiento}" name="elaF" class="form-control" required="" autofocus="" value="${datos.f_elabora}" disabled></td>
            <td><input type="date" id="expF${contMovimiento}" name="expF" class="form-control" required="" autofocus="" value="${datos.f_caduca}" disabled></td>
            <td>
                <input type="hidden" id="id_lote" name="id_lote" class="form-control" required="" autofocus="" value="${datos.id_lote}">
                <input type="text" id="lote" name="lote" class="form-control" required="" autofocus="" value="${datos.nombre}" disabled>
            </td>
            <td>
                <input type="number" id="costo${contMovimiento}" name="costo" class="form-control" required="" autofocus="" value="${datos.precio}" onchange="cargarTotal('${contMovimiento}')" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td><input type="text" id="costoTotal${contMovimiento}" name="costoTotal" class="form-control" required="" autofocus="" value="${datos.precio_total}" disabled></td>
        </tr>
        `
    );

    agregarOpcionesEdit('nameArticulo'+contMovimiento, datos.id_articulo, 0, contMovimiento);
    //cargarMarca('marcaArticulo'+contMovimiento);
    cargarUnidadEdit('cantidad'+contMovimiento, datos.id_unidad);

    $('#unidades' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Evento para validar costo
    $('#costo' + contMovimiento).on('input', function () {
        validarInputNumerico(this);
    });
    
    // Función para validar input numérico
    function validarInputNumerico(input) {
        var inputValue = input.value;
        var isValid = /^-?\d*\.?\d+$/.test(inputValue);
    
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

    $('#cuerpoTablaMovimiento').append(`
    
        <tr id="totalMovimiento">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <!-- <td></td> -->
            <td></td>
            <td><strong class="fs-4">Total:</strong></td>
            <td><input type="text" id="total" name="total" class="form-control" required="" autofocus="" value="" disabled></td>
        </tr>

    `);

    contMovimiento++;

}


function agregarOpcionesEdit(id_select, id_value, id_lote, contMovimiento) {

    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id_select);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerArticulos',
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

            selectArticulo.val(id_value).trigger('change.select2');

            //si se envia el lote entonces, se cargan los lotes, esto es para traspaso y egreso 
            if(id_lote != '0'){

                cargarLoteEdit(id_value, contMovimiento, id_lote);

            }

        },
        error: function (error) {
            console.error('Error al obtener la lista de artículos:', error);
        }
    });
}


/* TRAE TODAS LAS UNIDADES DE MEDIDA */
function cargarUnidadEdit(id_select, id_value){

    var selectMarca = $('#'+id_select);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/unidad',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            selectMarca.empty();
            selectMarca.append('<option value="0">Seleccione Opción</option>');

            $.each(res.data, function (index, marca) {
                selectMarca.append('<option value="' + marca.id + '">' + marca.nombre + ' - '+ marca.abreviatura + '</option>');
            });

            agregarSelect();

            selectMarca.val(id_value).trigger('change.select2');

        },
        error: function(error) {
            console.error('Error al obtener la lista de las Unidades:', error);
        }

    });

}
/* TRAE TODAS LAS UNIDADES DE MEDIDA */





function agregarArticuloEgreEdit(datos){

    $('#cuerpoTablaEgreso').append(
        `
        <tr id="trDeleteEgre${contEgreso}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticuloE(${contEgreso})">
                <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="hidden" id="id_movimiento${contEgreso}" name="id_movimiento" value="${datos.id}" >
                <input type="number" id="u_total${contEgreso}" name="u_total" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>

            <input type="hidden" id="id_inventario${contEgreso}" name="id_inventario" class="form-control" required autofocus value="0" disabled>
            <td>
                <select id="nameArticuloE${contEgreso}" name="nameArticuloE" class="form-select single-select js-example-basic-single" onchange="cargarLote('nameArticuloE${contEgreso}', '${contEgreso}')" disabled>
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>
            <td>
                <input type="text" id="cantidadE${contEgreso}" name="cantidadE" class="form-control" required="" autofocus="" value="${datos.unidad+'('+datos.abreviatura+')'}" disabled>
            </td>
            <td>
                <select id="lote${contEgreso}" name="lote" class="form-select single-select js-example-basic-single" onchange="cargarUnidades('lote${contEgreso}', '${contEgreso}')" disabled>
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>

            <td>
                <input type="number" id="unidades${contEgreso}" name="unidades" class="form-control" required autofocus value="${datos.unidades}" onchange="validaUnidades('${contEgreso}')" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
        </tr>
        `
    );

    agregarOpcionesEdit('nameArticuloE'+contEgreso, datos.id_articulo, datos.id_lote, contEgreso);

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

    contEgreso++;

}


/* CARGA EL SELECT DEL LOTE EDITAR */
function cargarLoteEdit(id_articulo, dato, id_value){

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
            //$('#cantidadE' + dato). val(res.unidades.abreviatura+'('+res.unidades.nombre+')');

            selectLote.val(id_value).trigger('change.select2');

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
/* CARGA EL SELECT DEL LOTE EDITAR */
