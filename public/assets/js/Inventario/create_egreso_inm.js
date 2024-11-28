var contMovimiento = 0;
var contExamen     = 0;
var contReExamen   = 0;
var contARN        = 0;
var contReactARN   = 1;
var contTermico    = 4;
var contStandar    = 3;
var contResulta    = 0;
var contControles  = 1;  

$( function () {

    $('#controlesSelect').select2({
        //dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
    });

    $('#controlCon0').select2({
        //dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
    });

    agregarArticulosARN(0);

    addTipoMuesta('tipoMuestraARN');
    agregarOpcionesCon('controlCon0');

    /*
    $('#list-resultados-list').click(function() {
        agregarResultados();
    });
    */

    $('#caduca0').change(function() {
        if ($(this).is(':checked')) {
            $('#bloqueTablaResultado').hide();
            $('#bloqueImportForm').show();
            $('#bloqueTablaARN').hide();
            $('#bloqueImportFormARN').show();
        } else {
            $('#bloqueTablaResultado').show();
            $('#bloqueImportForm').hide();
            $('#bloqueTablaARN').show();
            $('#bloqueImportFormARN').hide();
        }
    });

    $('#caduca0').prop('checked', false);

});



function agregarExamen(){

    //obtengo los valores de los select
    var valores = [];
    var valida  = true;
    var valLote = true;

    let abecedario = obtenerAbecedario();

    // Seleccionar todos los select con name igual a "reactivos"
    $('select[name="nameArticulo"]').each(function(index, select) {
        var texto = $(select).find('option:selected').text();
        var valor = $(select).val();
        valores.push(texto); 
        if (valor === '0') {
            valida = false;
        }
    });

    $('select[name="lote"]').each(function(index, select) {
        let valor = $(select).val();
        if (valor === '0') {
            valLote = false;
        }
    });

    var numeroRegistros = 3;

    if(numeroRegistros === 0){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar por lo menos un reactivo en la mezcla',
            showConfirmButton: true,
        });

    }else if(!valida){
        
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'No se han seleccionado todos los reactivos para la mezcla',
            showConfirmButton: true,
        });

    }else if(!valLote){
        
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'No se han seleccionado todos los lotes para la mezcla',
            showConfirmButton: true,
        });

    }else{

        var cuerpoTablaMezcla = '';

        for (var i = 0; i < numeroRegistros; i++) {
            cuerpoTablaMezcla += `
                <tr id="trMezcla${contReExamen}">
                    <td>
                        <input type="text" id="solucion" name="solucion" class="form-control" required autofocus value="Solucion de reacción ${abecedario[i]}" disabled>
                    </td>
                    <td>
                        <input type="number" id="rx${contReExamen}" name="rx" class="form-control" required autofocus value="0" onchange="calcularExamen('${contReExamen}', '${contExamen}')">
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Ingrese solo números</div>
                    </td>
                    <td>
                        <input type="number" id="rt${contReExamen}" name="rt" class="form-control" required autofocus value="0" disabled>
                        <div class="valid-feedback">¡Se ve bien!</div>
                        <div class="invalid-feedback">Ingrese solo números</div>
                    </td>
                </tr>
            `;
            contReExamen++;
        }
    
    
        $('#contentMezcla').append(`
            <div class="col-md-6 border-end border-3 border-primary pe-md-3 mt-2 border-top pt-4 position-relative" id="conteneExamen${contExamen}" >
    
                <button type="button" class="btn position-absolute top-0 end-0 text-danger" aria-label="Cerrar" onclick="eliminarDiv(${contExamen})">
                    <i class="bi bi-x-square"></i>
                </button>
    
                <div class="row mb-4">
    
                    <div class="col-md-4">
                        <label for="exaCantidad" class="form-label fs-6">Cantidad</label>
                        <input type="number" id="exaCantidad${contExamen}" name="exaCantidad" class="form-control" required="" autofocus="" value="0">
                        <div class="valid-feedback">Looks good!</div>
                    </div>

                    <!-- <button type="button" class="btn text-info" aria-label="Add Soluccion" onclick="agregarSolucion('cuerpoTablaMezcla${contExamen}')">
                         <i class="bi bi-node-plus"></i>
                    </button> -->
    
                </div>
    
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Opciones</th>
                            <th scope="col">1 rx(uL)</th>
                            <th scope="col">RX</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaMezcla${contExamen}" name="cuerpoTablaMezcla">
    
                    </tbody>
                </table>
    
            </div>
        `);

        //var cuerpoTablaMezcla = '';

        $(document).on('change', 'input[name="exaCantidad"]', function() {
            // Obtener el ID del contenedor de la fila correspondiente
            var containerId = $(this).closest('.border-end').attr('id');
            // Obtener el valor de la exaCantidad modificada
            var cantidad = $(this).val();
            // Seleccionar y actualizar solo los campos rt dentro de esa fila
            $('#' + containerId + ' input[name="rt"]').each(function() {
                var rxValue = parseFloat($(this).closest('tr').find('input[name="rx"]').val());
                $(this).val(rxValue * cantidad);
            });
        });

    
        $('#cuerpoTablaMezcla' + contExamen).html(cuerpoTablaMezcla);
    
        $('.js-example-basic-multiple').select2({
            //dropdownParent: $('.modal-body'),
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            height: '38px',
            placeholder: 'Selecciona una opción',
            allowClear: true,
        });

        agregarOpcionesExa('id_prueba'+contExamen);


        //actualiza rx y rt
        $(document).on('change', 'input[name="exaCantidad"]', function() {
            // Obtener el ID del contenedor de la fila correspondiente
            var containerId = $(this).closest('.border-end').attr('id');
            // Obtener el valor de la exaCantidad modificada
            var cantidad = $(this).val();
            // Seleccionar y actualizar solo los campos rt dentro de esa fila
            $('#' + containerId + ' input[name="rt"]').each(function() {
                var rxValue = parseFloat($(this).closest('tr').find('input[name="rx"]').val());
                $(this).val(rxValue * cantidad);
            });
        });
    
        contExamen++;
    

    }

}

function cargarResultados(){

    let muestras   = [];
    let id_muestra = [];
    let codigo     = [];

    $('select[name="tipoMuestraARN"]').each(function(index, select) {
        var tipoMuestra = $(select).find('option:selected').text();
        var valor = $(select).val();
        muestras.push(tipoMuestra); 
        id_muestra.push(valor); 
    });

    $('input[name="codMuestraARN"]').each(function(index, select) {
        var valor = $(select).val();
        codigo.push(valor); 
    });

    //verifico cuantos registros hay en extracción de ADN/ARN
    var numeroRegistros = $('#cuerpoTablaARN tr').length;

    //procedo a crear los registros 
    $('#cuerpoTablaResultado').text('');


    for (var i = 0; i < numeroRegistros; i++) {

        if (/^\d+$/.test(codigo[i])) {

            $('#cuerpoTablaResultado').append( `
            <tr id="">
                <td></td>
                <td>                
                    <input type="text" id="codigoRes" name="codigoRes" class="form-control" placeholder="Código" aria-label="Código" aria-describedby="Código" value="${codigo[i]}">
                </td>
                <td>
                    <input type="text" id="pacienteRes" name="pacienteRes" class="form-control" placeholder="Paciente" aria-label="Paciente" aria-describedby="Paciente" value="">
                </td>
                <td>
                    <input type="text" id="procedenciaRes" name="procedenciaRes" class="form-control" placeholder="Procedencia" aria-label="Procedencia" aria-describedby="Procedencia" value="">
                </td>
                <td>
                    <input type="text" id="resultadoRes" name="resultadoRes" class="form-control" placeholder="Resultado" aria-label="Resultado" aria-describedby="Resultado" value="">
                </td>
                <td>
                    <input type="text" id="ctRes" name="ctRes" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="CT" value="">
                </td>
                <td>
                    <input type="text" id="concentraRes" name="concentraRes" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="Concentración" value="">
                </td>
                <td>
                    <input type="text" id="observaRes" name="observaRes" class="form-control" placeholder="Observación" aria-label="Observación" aria-describedby="Observación" value="">
                </td>

            </tr>
        `);
        contReExamen++;

        }

    }

}

function eliminarDiv(dato){

    $('#conteneExamen'+dato).remove();

}

function agregarARN(){

    $('#cuerpoTablaARN').append(
        `
        <tr id="tableARN${contARN}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarARN(${contARN})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>                
                <input type="number" id="codMuestraARN${contARN}" name="codMuestraARN" class="form-control" required autofocus value="0">
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td>
                <select class="form-select" name="tipoMuestraARN"  id="tipoMuestraARN${contARN}">
                </select>
            </td>
        </tr>
        `
    );

    addTipoMuesta('tipoMuestraARN'+contARN);

    contARN++;

}



function eliminarARN(dato){
    $('#tableARN'+dato).remove();
}



/* AGREGAR PERFIL TERMICO */
function agregarTermico(){

    $('#cuerpoTablaTermico').append(
        `
        <tr id="tableTermico${contTermico}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarTermi(${contTermico})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>                
                <div class="input-group">
                    <input type="text" id="temperaPer${contTermico}" name="temperaPer" class="form-control" placeholder="Temperatura" aria-label="Temperatura" aria-describedby="basic-addon2" value="60">
                    <span class="input-group-text" id="basic-addon2">°C</span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" id="tiempoPer${contTermico}" name="tiempoPer" class="form-control" placeholder="Tiempo" aria-label="Tiempo" aria-describedby="basic-addon2" value="1">
                    <span class="input-group-text" id="basic-addon2">min</span>
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="text" id="ciclosPer${contTermico}" name="ciclosPer" class="form-control" placeholder="Ciclos" aria-label="Ciclos" aria-describedby="basic-addon2" value="45">
                    <span class="input-group-text" id="basic-addon2"><i class="bi bi-repeat"></i></span>
                </div>
            </td>
        </tr>
        `
    );

    contTermico++;
}
/* AGREGAR PERFIL TERMICO */


function eliminarTermi(dato){
    $('#tableTermico'+dato).remove();
}




/* AGREGAR PERFIL TERMICO */
function agregarStandar(){

    $('#cuerpoTablaStandar').append(
        `
        <tr id="tableStandar${contStandar}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarStandar(${contStandar})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>                
                <input type="text" id="standarSta${contStandar}" name="standarSta" class="form-control" placeholder="Standar" aria-label="Standar" aria-describedby="basic-addon2" value="-">
            </td>
            <td>
                <input type="text" id="concentraSta${contStandar}" name="concentraSta" class="form-control" placeholder="Concentración" aria-label="Concentración" aria-describedby="basic-addon2" value="-">
            </td>
            <td>
                <input type="text" id="ctSta${contStandar}" name="ctSta" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="basic-addon2" value="-">
            </td>
            <td>
                <input type="text" id="interSta${contStandar}" name="interSta" class="form-control" placeholder="Interpretación" aria-label="Interpretación" aria-describedby="basic-addon2" value="-">
            </td>
        </tr>
        `
    );

    contStandar++;
}
/* AGREGAR PERFIL TERMICO */


function eliminarStandar(dato){
    $('#tableStandar'+dato).remove();
}






/* AGREGAR RESULTADO */
function agregarResultado(){

    $('#cuerpoTablaResultado').append(
        `
        <tr id="tableResult${contResulta}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarResultado(${contResulta})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>                
                <input type="text" class="form-control" placeholder="Ubicación" aria-label="Ubicación" aria-describedby="Ubicación" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="F. Ingreso" aria-label="F. Ingreso" aria-describedby="F. Ingreso" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Código" aria-label="Código" aria-describedby="Código" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Paciente" aria-label="Paciente" aria-describedby="Paciente" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Procedencia" aria-label="Procedencia" aria-describedby="Procedencia" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="T. Muestra" aria-label="T. Muestra" aria-describedby="T. Muestra" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Ensayo" aria-label="Ensayo" aria-describedby="Ensayo" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="CT" aria-label="CT" aria-describedby="CT" value="">
            </td>
            <td>
                <input type="text" class="form-control" placeholder="Resultado" aria-label="Resultado" aria-describedby="Resultado" value="">
            </td>
        </tr>
        `
    );

    contResulta++;
}
/* AGREGAR RESULTADO */


function eliminarResultado(dato){
    $('#tableResult'+dato).remove();
}


/* AGREGAR CONTROLES */
function agregarControles(){

    $('#cuerpoTablaControles').append(
        `
        <tr id="tableControles${contControles}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarControles(${contControles})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>     
                <select id="controlCon${contControles}" name="controlCon" class="form-select single-select" data-placeholder="Selecciona una opción" >

                </select>
            </td>
            <td>
                <select class="form-select" name="resultadoCon"  id="resultadoCon${contControles}">
                    <option value="NEGATIVO"> NEGATIVO </option>
                    <option value="POSITIVO"> POSITIVO </option>
                </select>
            </td>
            <td>
                <input type="text" id="ctControl${contControles}" name="ctControl" class="form-control" placeholder="Tiempo" value="30">
            </td>
            <td>
                <input type="text" id="validaControl${contControles}" name="validaControl" class="form-control" placeholder="Tiempo" value="Si cumple: ">
            </td>
        </tr>
        `
    );

    agregarOpcionesCon('controlCon'+contControles);

    $('#controlCon'+contControles).select2({
        //dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
    });

    contControles++;

}
/* AGREGAR CONTROLES */

function eliminarControles(dato){
    $('#tableControles'+dato).remove();
}


function agregarArticulo(){

    $('#cuerpoTablaMovimiento').append(
        `
        <tr id="trDeleteMov${contMovimiento}">
            <td class="text-center"><a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarArticulo(${contMovimiento})">
                <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
            </a></td>
            <td>
                <input type="number" id="unidades${contMovimiento}" name="unidades" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <td>
                <input type="number" id="reactivos${contMovimiento}" name="reactivos" class="form-control" required autofocus value="0" disabled>
                <div class="valid-feedback">¡Se ve bien!</div>
                <div class="invalid-feedback">Ingrese solo números</div>
            </td>
            <input type="hidden" id="id_movimiento${contMovimiento}" name="id_movimiento" class="form-control" required autofocus value="0" disabled>
            <td>
                <select id="nameArticulo${contMovimiento}" name="nameArticulo" class="form-select single-select" onchange="cargarLote('nameArticulo${contMovimiento}', '${contMovimiento}')">
                    <option value="0">Seleccione Opción</option>
                    <option value="">  </option>
                </select>
            </td>
            <td>
                <input type="text" id="cantidad${contMovimiento}" name="cantidad" class="form-control" required="" autofocus="" value="" disabled>
            </td>
            <td>
                <select id="lote${contMovimiento}" name="lote" class="form-select single-select" onchange="cargarUnidades('lote${contMovimiento}', '${contMovimiento}')">
                    <option value="0">Seleccione Opción</option>
                </select>
            </td>
        </tr>
        `
    );

    agregarOpciones('nameArticulo'+contMovimiento);

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


/* AGREGA LAS PRUEBAS */
function agregarOpcionesExa(id) {

    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerExamenLab',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(data){

            selectArticulo.empty();
            selectArticulo.append('<option value="0">Seleccione Opción</option>');

            $.each(data, function (index, examen) {
                selectArticulo.append('<option value="' + examen.id + '">' + examen.nombre + '</option>');
            });

        },
        error: function (error) {
            console.error('Error al obtener la lista de Examenes:', error);
        }
    });
}
/* AGREGA LAS PRUEBAS */



/* AGREGA LOS CONTROLES */
function agregarOpcionesCon(id) {

    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerControlLab',
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(data){

            selectArticulo.empty();
            selectArticulo.append('<option value="0">Seleccione Opción</option>');

            $.each(data, function (index, examen) {
                selectArticulo.append('<option value="' + examen.id + '">' + examen.nombre + '</option>');
            });

        },
        error: function (error) {
            console.error('Error al obtener la lista de Controles:', error);
        }
    });
}
/* AGREGA LOS CONTROLES */




/* TRAE LOS ARTICULOS Y LOS PITAN EN EL SELECT DE ARN/ADN */
function agregarArticulosARN(dato) {

    var selectArticulo = $('#nameKitARN'+dato);

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

            $('#nameKitARN'+dato).select2({
                //dropdownParent: $('.modal-body'),
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                height: '38px',
                placeholder: 'Selecciona una opción',
                allowClear: true,
            });

        },
        error: function (error) {
            console.error('Error al obtener la lista de artículos:', error);
        }
    });


}

/* TRAE LOS ARTICULOS Y LOS PITAN EN EL SELECT DE ARN/ADN */



/* CARGA EL SELECT DEL LOTE ARN */
function cargarLoteARN(dato){

    let id_articulo = $('#nameKitARN'+dato).val();

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
            let selectLote = $('#loteARN'+dato);

            selectLote.empty();
            //selectLote.append('<option value="0">Seleccione Opción</option>');

            $.each(loteDatos, function (index, lote) {
                selectLote.append('<option value="' + lote.id + '">' + lote.nombre +' - CAD. ' + lote.f_caduca+'</option>');
            });

        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL SELECT DEL LOTE ARN */



/* CARGA EL VALOR DE LA UNIDAD PARA ARN */
function cargarUnidadesARN(id, dato){

    let id_lote = $('#'+id).val();

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
            $('#id_movimientoARN' + dato).val(loteDatos.id);
            $('#fechaReactARN' + dato).val(loteDatos.f_elabora);

        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL VALOR DE LA UNIDAD PARA ARN */

 

/* AGREGAR REACTIVO */
function addReactivoARN(){
    
    $('#contenARN').append(
        `
        <div class="row mt-1" id="contenARN${contReactARN}">

            <div class="d-flex justify-content-end align-items-center">
                <button class="btn btn-danger float-end btn-sm" onclick="deleteReactivoARN('${contReactARN}')">
                    x
                </button>
            </div>

            <div class="col-md-4 mt-2">
                <input type="hidden" id="id_movimientoARN${contReactARN}" name="id_movimientoARN" class="form-control" required="" autofocus="" value="">
                <label for="nameKitARN" class="form-label fs-6">Nombre de Kit</label> 
                <select id="nameKitARN${contReactARN}" name="nameKitARN" class="form-select single-select" data-placeholder="Selecciona una opción" onchange="cargarLoteARN(${contReactARN})">
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label for="loteARN" class="form-label fs-6">Lote</label>
                <select id="loteARN${contReactARN}" name="loteARN" class="form-select single-select" onchange="cargarUnidadesARN('loteARN${contReactARN}', ${contReactARN})">
                    <option value="0">Seleccione Opción</option>
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label for="fechaReactARN" class="form-label fs-6">Fecha</label>
                <input type="date" id="fechaReactARN${contReactARN}" name="fechaReactARN" class="form-control" required="" autofocus="" value="">
                <div class="valid-feedback">Looks good!</div>
            </div>
        </div>
        `
    );

    agregarArticulosARN(contReactARN);

    contReactARN++;

}
/* AGREGAR REACTIVO */



/* ELIMINAR REACTIVO */
function deleteReactivoARN(dato){
    $('#contenARN'+dato).remove();
}
/* ELIMINAR REACTIVO */



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
            $('#unidades' + dato).val(loteDatos.unidades);
            $('#id_movimiento' + dato).val(loteDatos.id);
            $('#reactivos' + dato).val(loteDatos.cantidad);


        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL VALOR DE LA UNIDAD */


function calcularExamen(dato, dato2){

    let cantidad = parseFloat( $('#exaCantidad' + dato2).val() );

    if(cantidad == '0'){
        cantidad = 0;
    }

    let rx = parseFloat( $('#rx' + dato).val() );
    
    if (!isNaN(cantidad) && !isNaN(rx)) {

        let resultado = cantidad * rx;
        $('#rt' + dato).val(resultado.toFixed(2));

        //console.log('El resultado de la multiplicación es: ' + resultado);
    } else {

        Swal.fire({
            icon:  'warning',
            title: 'SoftInspi',
            type:  'warning',
            text:  'Uno o ambos valores no son números válidos.',
            showConfirmButton: true,
        });

    }

}


function eliminarArticulo(dato){
    
    $('#trDeleteMov'+dato).remove();

}


function guardarMovimiento(){

    var formData = new FormData();

    let tecnica = $('#tecnica').val();
    let para    = $('#para').val();
    //let hora    = $('#hora').val();
    let fecha   = $('#fechaCorrida').val();
    let tipo    = $('#tipo').val();
    let equipos = $('#equipos').val();
    let numero  = $('#numero').val();
    let equiposExt = $('#equiposExt').val();


    if(tecnica == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el nombre de la tecnica',
            showConfirmButton: true,
        });

    }else if(para == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar para que prueba es',
            showConfirmButton: true,
        });

    }else if(numero == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el número de la corrida',
            showConfirmButton: true,
        });

    }else if(equipos == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar los equipos usados',
            showConfirmButton: true,
        });

    }else if(equiposExt == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar los equipos usados en la Extracción',
            showConfirmButton: true,
        });

    }else if( validarDatosReaccion() && validarDatosPerfil() && validarDatosControles() ){
       
        var estado = $('#caduca0').is(':checked');

        if (estado) {

            //switch marcado
            if(validarDatosResultadosInput() && validarDatosADNInput()){

                var f_reporte = $('#freporteResult').val();
                var f_procesa = $('#fprocesaResult').val();
                var observaci = $('#observaResult').val();
                
                var inputFile = document.getElementById('file');//editar
                var file = inputFile.files[0];

                var inputFileADN = document.getElementById('fileADN');//editar
                var fileADN = inputFileADN.files[0];

                var arnData = capturarDatosARN();
                var reaccionData = capturarDatosReaccion();
                var perfilData = capturarDatosPerfil();
                var controlesData = capturarDatosControles();
                var estandarData = capturarDatosEstandar();

            
                // Agregar los datos de ARN al FormData
                arnData.forEach(function(arnItem, index) {
                    // Agregar cada kit al formData
                    arnItem.kits.forEach(function(kit, kitIndex) {
                        formData.append('arn[' + index + '][kits][' + kitIndex + '][nombreKit]', kit.nombreKit);
                        formData.append('arn[' + index + '][kits][' + kitIndex + '][lote]', kit.lote);
                        formData.append('arn[' + index + '][kits][' + kitIndex + '][fecha]', kit.fecha);
                        formData.append('arn[' + index + '][kits][' + kitIndex + '][observa]', kit.observa);
                        formData.append('arn[' + index + '][kits][' + kitIndex + '][id_movimiento]', kit.id_movimiento);
                    });
                
                    // Agregar las muestras al formData
                    arnItem.muestras.forEach(function(muestra, muestraIndex) {
                        formData.append('arn[' + index + '][muestras][' + muestraIndex + '][codMuestra]', muestra.codMuestra);
                        formData.append('arn[' + index + '][muestras][' + muestraIndex + '][tipoMuestra]', muestra.tipoMuestra);
                    });
                });
            
                // Agregar los datos de reacción al FormData
                reaccionData.forEach(function(reaccionItem, index) {
                    // Agregar datos de la tabla de movimiento al FormData
                    reaccionItem.tablaMovimiento.forEach(function(movimiento, movimientoIndex) {
                        formData.append('reaccion[' + index + '][tablaMovimiento][' + movimientoIndex + '][id_articulo]', movimiento.id_articulo);
                        formData.append('reaccion[' + index + '][tablaMovimiento][' + movimientoIndex + '][lote]', movimiento.lote);
                        formData.append('reaccion[' + index + '][tablaMovimiento][' + movimientoIndex + '][id_inventario]',  movimiento.id_inventario);
                    });
                
                    // Agregar datos de la tabla de mezcla al FormData
                    reaccionItem.tablaMezcla.forEach(function(mezcla, mezclaIndex) {
                        formData.append('reaccion[' + index + '][tablaMezcla][' + mezclaIndex + '][cantidad]', mezcla.cantidad);
                        formData.append('reaccion[' + index + '][tablaMezcla][' + mezclaIndex + '][pruebas]', JSON.stringify(mezcla.pruebas));
                
                        // Agregar datos de las pruebas de la tabla de mezcla al FormData
                        mezcla.datosPruebas.forEach(function(prueba, pruebaIndex) {
                            formData.append('reaccion[' + index + '][tablaMezcla][' + mezclaIndex + '][datosPruebas][' + pruebaIndex + '][rx]', prueba.rx);
                            formData.append('reaccion[' + index + '][tablaMezcla][' + mezclaIndex + '][datosPruebas][' + pruebaIndex + '][rt]', prueba.rt);
                            formData.append('reaccion[' + index + '][tablaMezcla][' + mezclaIndex + '][datosPruebas][' + pruebaIndex + '][solucion]', prueba.solucion);
                        });
                    });
                });


                // Agregar los datos de perfil al FormData
                perfilData.forEach(function(perfilItem, index) {
                    // Agregar datos termicos al FormData
                    perfilItem.datosTermico.forEach(function(termico, termicoIndex) {
                        formData.append('perfil[' + index + '][datosTermico][' + termicoIndex + '][temperatura]', termico.temperatura);
                        formData.append('perfil[' + index + '][datosTermico][' + termicoIndex + '][tiempo]', termico.tiempo);
                        formData.append('perfil[' + index + '][datosTermico][' + termicoIndex + '][ciclos]', termico.ciclos);
                    });
                    // Agregar el número de canales al FormData
                    formData.append('perfil[' + index + '][canales]', perfilItem.canales);
                });
            

                // Agregar los datos de controles al FormData
                controlesData.forEach(function(controlItem, index) {
                    // Agregar los datos de cada control
                    controlItem.datosControl.forEach(function(control, controlIndex) {
                        formData.append('controles[' + index + '][datosControl][' + controlIndex + '][controlCon]', control.controlCon);
                        formData.append('controles[' + index + '][datosControl][' + controlIndex + '][ctControl]', control.ctControl);
                        formData.append('controles[' + index + '][datosControl][' + controlIndex + '][resultadoCon]', control.resultadoCon);
                        formData.append('controles[' + index + '][datosControl][' + controlIndex + '][validaControl]', control.validaControl);
                    });
                    
                    // Agregar otros datos relacionados con los controles
                    formData.append('controles[' + index + '][umbral]', controlItem.umbral);
                    formData.append('controles[' + index + '][isChecked]', controlItem.isChecked);
                });

                // Agregar los datos de standar al FormData
                estandarData.forEach(function(estandarItem, index) {
                    // Agregar otros datos relacionados con los controles
                    formData.append('estandar[' + index + '][estandar]', estandarItem.estandar);
                    formData.append('estandar[' + index + '][concentra]', estandarItem.concentra);
                    formData.append('estandar[' + index + '][ct]', estandarItem.ct);
                    formData.append('estandar[' + index + '][interpreta]', estandarItem.interpreta);
                });

                //resultados
                formData.append('f_reporte', f_reporte);
                formData.append('f_procesa', f_procesa);
                formData.append('observacion', observaci);
                formData.append('file', file);
                formData.append('fileADN', fileADN);

                //datos generales
                formData.append('tecnica', tecnica);
                formData.append('para', para);
                //formData.append('hora', hora);
                formData.append('fecha', fecha);
                formData.append('tipo', tipo);
                formData.append('equipos', equipos);

                formData.append('numero', numero);
                formData.append('equiposExt', equiposExt);

                
                $.ajax({

                    type: 'POST',
                    url: '/inventario/saveCorridaInm',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
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
                            icon:  'success',
                            title: 'SoftInspi',
                            type:  'success',
                            text:   error,
                            showConfirmButton: true,
                        });
                    }
                });

            }

        } else {

            if(validarDatosResultados() && validarDatosARN()){
                //arn
                var arn = capturarDatosARN();
                console.log(capturarDatosARN());

                //reaccion
                var reaccion = capturarDatosReaccion();
                console.log(capturarDatosReaccion());

                //estandar
                var estandar = capturarDatosEstandar();
                console.log(capturarDatosEstandar());

                //perfil
                var perfil = capturarDatosPerfil();
                console.log(capturarDatosPerfil());

                //resultados
                let resultados = capturarDatosResultados();
                console.log(capturarDatosResultados());

                //controles
                var controles = capturarDatosControles();
                console.log(capturarDatosControles());
                


                $.ajax({

                    type: 'POST',
                    url: '/inventario/saveCorridaManInm',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        tecnica: tecnica,
                        para:    para,
                        fecha:   fecha,
                        tipo:    tipo,
                        equipos: equipos,
                        numero:  numero,
                        equiposExt:  equiposExt,

                        arn:        arn,
                        reaccion:   reaccion,
                        perfil:     perfil,
                        resultados: resultados,
                        controles:  controles,
                        estandar:   estandar, 
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
        let lote   = $(row).find('select[name="lote"]');
        let rts    = $(row).find('input[name="rt"]');  

        let isNameArticuloEmpty = nameArticulos.val() === '0';
        let isLoteEmpty = lote.val() === '0';
        let rt = rts.val().trim() === '0';

        // Verificar si los campos están deshabilitados
        let unidades = $(row).find('input[name="unidades"]:not([disabled])');
        let reactivos = $(row).find('input[name="reactivos"]:not([disabled])');

        if ((isNameArticuloEmpty || isLoteEmpty || rt) && unidades.length > 0 && reactivos.length > 0) {
            isValid = false;

            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Al menos un campo está vacío en la fila ' + (index + 1),
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

        let id_inventarios = $(row).find('input[name="id_movimiento"]');
        let rts    = $(row).find('input[name="rt"]');

        // Verificar si hay elementos en el conjunto actual
        if (id_inventarios.length > 0) {
            // Obtener valores del conjunto actual
            let id_inventario = id_inventarios.eq(0).val().trim();  
            let rt     = rts.eq(0).val().trim();  

            // Validar si todos los campos están llenos
            if (id_inventario !== '' && rt !== '') {

                movimientosArray.push({

                    id_inventario: id_inventario,
                    rt:            rt,
                });

            }
        }
    });

    return movimientosArray;
}


function addTipoMuesta(dato){

    let id_laboratorio = $('#id_laboratorio').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/muestrasLaborat/' + id_laboratorio,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            let muestras = res.muestras;
            let selectMuestra = $('#' + dato);

            selectMuestra.empty();
            selectMuestra.append('<option value="0">Seleccione Opción</option>');

            $.each(muestras, function (index, muestra) {
                selectMuestra.append('<option value="' + muestra.id + '">' + muestra.nombre +'</option>');
            });


        },
        error: function(error) {
            console.error('Error al obtener los datos de la muestra:', error);
        }

    });

}


/* =========================================== VALIDAR Y CAPTURAR ARN/ADN =========================================== */


function validarDatosARN() {

    let isValid = true;
    let comentario = '';

    // Iterar sobre los elementos con ID comenzando con "nameKitARN"
    $('[id^="nameKitARN"]').each(function(index, select) {
        var nombreKit = $(select).val();
        var loteId    = $(select).attr('id').replace('nameKitARN', 'loteARN');
        var lote      = $('#' + loteId).val();
        var fechaId   = $(select).attr('id').replace('nameKitARN', 'fechaReactARN');
        var fecha     = $('#' + fechaId).val();

        // Verificar si alguno de los campos está vacío
        if (nombreKit === '0' || lote === '0' || fecha === '') {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de Extracción de ARN/ADN'; 
        }
    });


    //se valida la tabla
    $('#cuerpoTablaARN tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        const codMuestra = $(row).find('input[name="codMuestraARN"]').val();
        const tipoMuestra = $(row).find('select[name="tipoMuestraARN"]').val();

        // Verificar si alguno de los campos está vacío
        if (codMuestra === '' || tipoMuestra === '0' || tipoMuestra === null) {
            isValid = false;
            comentario = 'Al menos un código o tipo de muestra está vacío en la fila '+ (index+1) + ' de Extracción de ARN/ADN'; 
        }
    });

    if (!isValid) {
        Swal.fire({
            icon:  'warning',
            type:  'warning',
            title: 'SoftInspi',
            text:  comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}

function validarDatosADNInput() {
    let isValid = true;
    var inputFile = document.getElementById('fileADN');

    if (inputFile.files.length > 0) {
        // Verificar si el archivo seleccionado es un CSV
        const file = inputFile.files[0];
        const fileName = file.name;
        const fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
        if (fileType.toLowerCase() !== 'csv') {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Por favor, seleccione un archivo CSV. En  ADN',
                showConfirmButton: true,
            });
            isValid = false;
        }
    } else {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: 'No se ha agregado ningún documento con los códigos de ADN.',
            showConfirmButton: true,
        });
        isValid = false;
    }

    return isValid;
}


function capturarDatosARN() {

    var datos  = [];
    var kits  = [];
    var muestras = [];

    // Iterar sobre los elementos con ID comenzando con "nameKitARN"
    $('[id^="nameKitARN"]').each(function(index, select) {
        var nombreKit = $(select).val();
        var loteId    = $(select).attr('id').replace('nameKitARN', 'loteARN');
        var lote      = $('#' + loteId).val();
        var fechaId   = $(select).attr('id').replace('nameKitARN', 'fechaReactARN');
        var fecha     = $('#' + fechaId).val();

        var id_movimientod = $(select).attr('id').replace('nameKitARN', 'id_movimientoARN');
        var id_movimiento  = $('#' + id_movimientod).val();

        var observa   = $('#observaARN').val();
        
        // Verificar si alguno de los campos está vacío
        if (nombreKit && lote && fecha) {

            kits.push({
                nombreKit: nombreKit,
                lote:    lote,
                fecha:   fecha,
                observa: observa,
                id_movimiento: id_movimiento
            });

        } 

    });

    $('#cuerpoTablaARN tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        const codMuestra = $(row).find('input[name="codMuestraARN"]').val();
        const tipoMuestra = $(row).find('select[name="tipoMuestraARN"]').val(); 

        muestras.push({
            codMuestra:  codMuestra,
            tipoMuestra: tipoMuestra,
        });

    });

    datos.push({
        kits: kits, muestras: muestras
    })

    return datos;
}


/* =========================================== VALIDAR Y CAPTURAR ARN/ADN =========================================== */





/* =========================================== VALIDAR Y CAPTURAR MEZCLA DE REACCIONES =========================================== */


function validarDatosReaccion() {
    let isValid = true;
    let comentario = '';

    const tablaMovimiento = $('#cuerpoTablaMovimiento');
    if (tablaMovimiento.find('tr').length === 0) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'No se a creado ninguna mezcla en la pestaña de reacciones.',
            showConfirmButton: true,
        });
        return false;
    }

    // Validar la tabla de movimiento
    $('#cuerpoTablaMovimiento tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        const id_articulo = $(row).find('select[name="nameArticulo"]').val();
        const lote = $(row).find('select[name="lote"]').val();

        // Verificar si alguno de los campos está vacío
        if (id_articulo === '0' || lote === '0') {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de sección de mezclas'; 
            return false; 
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: comentario,
            showConfirmButton: true,
        });
        return false; 
    }

    // Validar la tabla de mezcla
    const tablaMezcla = $('#contentMezcla');
    if (tablaMezcla.find('div').length === 0) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'No se a creado ninguna prueba en la pestaña de reacciones.',
            showConfirmButton: true,
        });
        return false;
    }


        
    tablaMezcla.find('div[id^="conteneExamen"]').each(function(i, contenedor) {

        const cantidadInput = $(contenedor).find('input[name="exaCantidad"]');
        const pruebasSelect = $(contenedor).find('select[name="id_prueba[]"]');

        let pruebas = i+1;

        if (cantidadInput.val() === '') {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Por favor, ingrese la cantidad de muestras de la prueba '+pruebas+'.',
                showConfirmButton: true,
            });
            return false;
        }
    
        if (pruebasSelect.val() === null || pruebasSelect.val() === 0) {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Por favor, seleccione al menos un examen en la prueba '+pruebas+'.',
                showConfirmButton: true,
            });
            return false;
        }

        $(contenedor).find('tbody[name="cuerpoTablaMezcla"]').each(function(index, tabla) {

            $(tabla).find('tr').each(function(index, row) {
                const rx = $(row).find('input[name="rx"]').val();
                const rt = $(row).find('input[name="rt"]').val();

                const pruebaSelect = $(row).closest('.row').find('select[name="id_prueba[]"]');

                // Verificar si alguno de los campos está vacío
                if (rx === '0' || rt === '') {
                    isValid = false;
                    comentario = 'Al menos un campo está vacío en la fila '+ (pruebas) + ' de la sección de exámenes'; 
                    return false; // Salir del bucle each
                }
            });
        });
    });
    



    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}





function capturarDatosReaccion() {
    var datos = [];
    var datosTablaMovimiento = [];
    var datosTablaMezcla = [];

    // Capturar datos de la tabla de movimiento
    $('#cuerpoTablaMovimiento tr').each(function(index, row) {
        var id_articulo = $(row).find('select[name="nameArticulo"]').val();
        var lote = $(row).find('select[name="lote"]').val();
        var id_inventario = $(row).find('input[name="id_movimiento"]').val();

        datosTablaMovimiento.push({
            id_articulo:   id_articulo,
            lote: lote,
            id_inventario: id_inventario,
        });
    });

    // Capturar datos de la tabla de mezcla
    $('#contentMezcla').find('div[id^="conteneExamen"]').each(function(i, contenedor) {
        var cantidad = $(contenedor).find('input[name="exaCantidad"]').val();
        var pruebas = $(contenedor).find('select[name="id_prueba[]"]').val();
        var datosPruebas = [];

        $(contenedor).find('tbody[name="cuerpoTablaMezcla"] tr').each(function(index, row) {
            var rx = $(row).find('input[name="rx"]').val();
            var rt = $(row).find('input[name="rt"]').val();
            var solucion = $(row).find('input[name="solucion"]').val();


            datosPruebas.push({
                rx: rx,
                rt: rt,
                solucion: solucion,
            });
        });

        datosTablaMezcla.push({
            cantidad: cantidad,
            pruebas: pruebas,
            datosPruebas: datosPruebas,
        });
    });

    // Agregar los datos capturados al arreglo principal
    datos.push({
        tablaMovimiento: datosTablaMovimiento,
        tablaMezcla: datosTablaMezcla,
    });

    return datos;
}




/* =========================================== VALIDAR Y CAPTURAR MEZCLA DE REACCIONES =========================================== */




/* =========================================== VALIDAR Y CAPTURAR ESTANDAR DE CUANTIFICACIÒN =========================================== */

function validarDatosEstandar() {

    let isValid    = true;
    let comentario = '';

    $('#cuerpoTablaStandar tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        var estandar   = $(row).find('input[name="standarSta"]').val();
        var concentra  = $(row).find('input[name="concentraSta"]').val();
        var ct         = $(row).find('input[name="ctSta"]').val();
        var interpreta = $(row).find('input[name="interSta"]').val();

        if (estandar === '' || concentra === '' || ct === '' || interpreta === '') {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de la sección de Estandar de Cuantificación';
        }

    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text:  comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}





function capturarDatosEstandar() {
    var datosEstandar = [];

    // Recorrer cada fila de la tabla
    $('#cuerpoTablaStandar tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        var estandar   = $(row).find('input[name="standarSta"]').val();
        var concentra  = $(row).find('input[name="concentraSta"]').val();
        var ct         = $(row).find('input[name="ctSta"]').val();
        var interpreta = $(row).find('input[name="interSta"]').val();
    
        // Agregar los datos de la fila al array
        datosEstandar.push({
            estandar:   estandar,
            concentra:  concentra,
            ct:         ct,
            interpreta: interpreta

        });
    });

    return datosEstandar;
}

/* =========================================== VALIDAR Y CAPTURAR ESTANDAR DE CUANTIFICACIÒN =========================================== */






/* =========================================== VALIDAR Y CAPTURAR PERFIL TERMICO =========================================== */

function validarDatosPerfil() {

    let isValid    = true;
    let comentario = '';

    $('#cuerpoTablaTermico tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        var temperatura = $(row).find('input[name="temperaPer"]').val();
        var tiempo = $(row).find('input[name="tiempoPer"]').val();
        var ciclos = $(row).find('input[name="ciclosPer"]').val();
    
        if (temperatura === '' || tiempo === '' || ciclos === '') {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de la sección de Perfíl Termico';
        }

    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text:  comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}





function capturarDatosPerfil() {
    var datos = [];
    var datosTermico = [];

    var canales = $('#canalesPer').val();


    // Recorrer cada fila de la tabla
    $('#cuerpoTablaTermico tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        var temperatura = $(row).find('input[name="temperaPer"]').val();
        var tiempo = $(row).find('input[name="tiempoPer"]').val();
        var ciclos = $(row).find('input[name="ciclosPer"]').val();
    
        // Agregar los datos de la fila al array
        datosTermico.push({
            temperatura: temperatura,
            tiempo:      tiempo,
            ciclos:      ciclos
        });
    });
    // Agregar los datos capturados al arreglo principal
    datos.push({
        datosTermico: datosTermico,
        canales:      canales
    });

    return datos;
}

/* =========================================== VALIDAR Y CAPTURAR PERFIL TERMICO =========================================== */





/* =========================================== VALIDAR Y CAPTURAR REPORTE DE RESULTADOS =========================================== */

function validarDatosResultados() {

    let isValid    = true;
    let comentario = '';

    $('#cuerpoTablaResultado tr').each(function(index, row) {
        // Obtener los valores de los campos en la fila actual
        var codigo      = $(row).find('input[name="codigoRes"]').val();
        var paciente    = $(row).find('input[name="pacienteRes"]').val();
        var procedencia = $(row).find('input[name="procedenciaRes"]').val();
        var resultado   = $(row).find('input[name="resultadoRes"]').val();
        var ct          = $(row).find('input[name="ctRes"]').val();
        var concentra   = $(row).find('input[name="concentraRes"]').val();
        var observa     = $(row).find('input[name="observaRes"]').val();
    
        if (codigo === '' || paciente === '' || procedencia === '' ) {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de la sección de Reporte de Resultados';
        }

    });
        
    

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text:  comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}




function validarDatosResultadosInput() {
    let isValid = true;
    var inputFile = document.getElementById('file');

    if (inputFile.files.length > 0) {
        // Verificar si el archivo seleccionado es un CSV
        const file = inputFile.files[0];
        const fileName = file.name;
        const fileType = fileName.slice((fileName.lastIndexOf(".") - 1 >>> 0) + 2);
        if (fileType.toLowerCase() !== 'csv') {
            Swal.fire({
                icon: 'warning',
                type: 'warning',
                title: 'SoftInspi',
                text: 'Por favor, seleccione un archivo CSV.',
                showConfirmButton: true,
            });
            isValid = false;
        }
    } else {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: 'No se ha agregado ningún documento en el reporte de resultados.',
            showConfirmButton: true,
        });
        isValid = false;
    }

    return isValid;
}




function capturarDatosResultados() {
    var datos = [];
    var datosResult = [];

    var observaci = $('#observaResult').val();

    // Recorrer cada fila de la tabla
    $('#cuerpoTablaResultado tr').each(function(index, row) {

        // Obtener los valores de los campos en la fila actual
        var codigo      = $(row).find('input[name="codigoRes"]').val();
        var paciente    = $(row).find('input[name="pacienteRes"]').val();
        var procedencia = $(row).find('input[name="procedenciaRes"]').val();
        var resultado   = $(row).find('input[name="resultadoRes"]').val();
        var ct          = $(row).find('input[name="ctRes"]').val();
        var concentra   = $(row).find('input[name="concentraRes"]').val();
        var observa     = $(row).find('input[name="observaRes"]').val();
    
        // Agregar los datos de la fila al array
        datosResult.push({
            codigo      : codigo,
            paciente    : paciente,
            procedencia : procedencia,
            resultado   : resultado,
            ct          : ct,
            concentra   : concentra,
            observa     : observa,

        });
    });
    // Agregar los datos capturados al arreglo principal
    datos.push({
        datosResult:  datosResult,
        observaci:    observaci,
    });

    return datos;
}

/* =========================================== VALIDAR Y CAPTURAR REPORTE DE RESULTADOS =========================================== */




/* =========================================== VALIDAR Y CAPTURAR USO DE CONTROLES =========================================== */

function validarDatosControles() {

    let isValid    = true;
    let comentario = '';

    var umbral = $('#umbralCon').val();

    if(umbral === ''){
        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text:  'El campo Umbral esta vacio en Controles',
            showConfirmButton: true,
        });
    }else{

        $('#cuerpoTablaControles tr').each(function(index, row) {

            var controlCon   = $(row).find('select[name="controlCon"]').val();
            var ctControl    = $(row).find('input[name="ctControl"]').val();
            var resultadoCon = $(row).find('select[name="resultadoCon"]').val();
            var validaControl = $(row).find('input[name="validaControl"]').val();

            if (controlCon === '' || ctControl === '' || resultadoCon === '' || validaControl === 'Si cumple: ') {
                isValid = false;
                if(validaControl === 'Si cumple: '){
                    comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de la sección de Uso de Controles. Falta la razón de *Si cumple*';
                }else{
                    comentario = 'Al menos un campo está vacío en la fila '+ (index+1) + ' de la sección de Uso de Controles';
                }
            }
    
        });
    
        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text:  comentario,
                showConfirmButton: true,
            });
        }

    }


    return isValid;
}





function capturarDatosControles() {
    var datos = [];
    var datosControl = [];

    var umbral = $('#umbralCon').val();
    var checkbox = document.getElementById("autoCon");
    var isChecked = checkbox.checked;

    // Recorrer cada fila de la tabla
    $('#cuerpoTablaControles tr').each(function(index, row) {

        var controlCon   = $(row).find('select[name="controlCon"]').val();
        var ctControl    = $(row).find('input[name="ctControl"]').val();
        var resultadoCon = $(row).find('select[name="resultadoCon"]').val();
        var validaControl = $(row).find('input[name="validaControl"]').val();

        datosControl.push({
            controlCon:   controlCon,
            ctControl:    ctControl,
            resultadoCon: resultadoCon,
            validaControl: validaControl
        });
    });
    // Agregar los datos capturados al arreglo principal
    datos.push({
        umbral:       umbral,
        isChecked:    isChecked,
        datosControl: datosControl
    });

    return datos;
}

/* =========================================== VALIDAR Y CAPTURAR USO DE CONTROLES =========================================== */



function obtenerAbecedario() {
    return Array.from({length: 26}, (_, i) => String.fromCharCode(65 + i));
}

