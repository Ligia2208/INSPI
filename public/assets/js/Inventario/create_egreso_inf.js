var contMovimiento = 0;
var contExamen     = 0;
var contReExamen   = 0;
var contARN        = 0;
var contReactARN   = 1;
var contTermico    = 4;
var contStandar    = 3;
var contResulta    = 0;
var contControles  = 1;  

var contMono       = 0;
var contMonoTabla  = 0;
var contPoli       = 0;

var contConsu      = 0;

var contInfA      = 0;
var contInfB      = 0;
var contCovid     = 0;
var contSincitial = 0;


$( function () {




    $('.js-example-basic-multiple').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });






    $('#controlesSelect').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });

    $('#controlCon0').select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });

    agregarArticulosARN(0);

    addTipoMuesta('tipoMuestraARN');

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

    var numeroRegistros = $('#cuerpoTablaMovimiento tr').length;

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
                <tr id="trMezcla${contExamen}_${i}">
                    <td>
                        <input type="text" class="form-control" required autofocus value="${valores[i]}" disabled>
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
            <div class="col-md-6 border-end border-3 border-primary pe-md-3 mt-2 border-top pt-4 position-relative col-lg-12" id="conteneExamen${contExamen}" >
    
                <button type="button" class="btn position-absolute top-0 right-0 text-danger" aria-label="Cerrar" onclick="eliminarDiv(${contExamen})">
                    <i class="bi bi-x-square"></i>
                </button>
    
                <div class="row mb-4">
    
                    <div class="col-md-2">
                        <label for="exaCantidad" class="form-label fs-6">Cantidad</label>
                        <input type="number" id="exaCantidad${contExamen}" name="exaCantidad" class="form-control" required="" autofocus="" value="0">
                        <div class="valid-feedback">Looks good!</div>
                    </div>
    
                </div>
    
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Reactivos</th>
                            <th scope="col">1 rx(uL)</th>
                            <th scope="col">RT-PCR</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaMezcla${contExamen}" name="cuerpoTablaMezcla">
    
                    </tbody>
                </table>
    
            </div>
        `);


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
            //theme: 'bootstrap4',
            width: '100%',
            //height: '38px',
            //placeholder: 'Selecciona una opción',
            //allowClear: true,
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

    var id_usuario = $('#id_usuario').val();

    $('#cuerpoARN').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="tableARN${contARN}">

        <h3 class="col-lg-12"> Prueba ${contARN+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarARN(${contARN})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaARN" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaARN${contARN}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioARN" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuario${contARN}" id="controlesSelect"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaARN${contARN}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaARN'+contARN, 1, 'ARN', contARN); //id de la tabla / id categoria

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuario'+contARN);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuario'+contARN).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contARN++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });



    /*
    $('#cuerpoTablaARN').append(
        `
        <tr id="tableARN${contARN}">
            <td>
                <a data-id_delete="6" title="Eliminar Registro" class="red show-tooltip" data-title="Eliminar Registro" onclick="eliminarARN(${contARN})">
                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                </a>
            </td>
            <td>                
                <input type="text" id="codMuestraARN${contARN}" name="codMuestraARN" class="form-control" required autofocus value="0">
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

    */

    //contARN++;

}



function eliminarARN(dato){
    $('#tableARN'+dato).remove();
}



/* AGREGAR POLI */
function agregarPoliclonal(){

    var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoPoli').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaPoli${contPoli}">

        <h3 class="col-lg-12"> Prueba Policlonal ${contPoli+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarPoli(${contPoli})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaPoli" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaPoli${contPoli}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioPoli" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioPoli${contPoli}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaPoli${contPoli}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaPoli'+contPoli, 3, 'Poli', contPoli);


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioPoli'+contPoli);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioPoli'+contPoli).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contPoli++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarPoli(dato){
    $('#contePruebaPoli'+dato).remove();
}

/* AGREGAR POLI */







/* AGREGAR CONSUMIBLE */
function agregarConsumible(){

    //var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoConsumibles').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="conteConsumible${contConsu}">

        <h3 class="col-lg-12"> Consumibles ${contConsu+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarConsumible(${contConsu})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaConsumible" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaConsumible${contConsu}" name="fechaConsumible" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioConsumible" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioConsumible${contConsu}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaConsumible${contConsu}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaConsumible'+contConsu, 5, 'Consumible', contConsu);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioConsumible'+contConsu);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioConsumible'+contConsu).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contConsu++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarConsumible(dato){
    $('#conteConsumible'+dato).remove();
}

/* AGREGAR CONSUMIBLE */








/* AGREGAR MONO */
function agregarMono(){

    var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoMono').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaMono${contMono}">

        <h3 class="col-lg-12"> Prueba Monoclonal ${contMono+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarMono(${contMono})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaMono" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaMono${contMono}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioMono" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioMono${contMono}" id="controlesSelect"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaMono${contMono}">

            </tbody>
        </table>

    </div>

    `);


    agregarTabla('cuerpoTablaMono'+contMono, 4, 'Mono', contMono); //id de la tabla / id categoria


    $('#selectMono'+contMono).select2({
        //dropdownParent: $('.modal-body'),
        //theme: 'bootstrap4',
        width: '100%',
        //height: '38px',
        //placeholder: 'Selecciona una opción',
        //allowClear: true,
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioMono'+contMono);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioMono'+contMono).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contMono++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarMono(dato){
    $('#contePruebaMono'+dato).remove();
}

/* AGREGAR MONO */




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


function eliminarPCR(dato){
    $('#contePruebaPCR'+dato).remove();
}

function agregarArticulo(){


    var id_usuario = $('#id_usuario').val();

    $('#cuerpoPCR').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaPCR${contMovimiento}">

        <h3 class="col-lg-12"> Prueba ${contMovimiento+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarPCR(${contMovimiento})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaPCR" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaPCR${contMovimiento}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioPCR" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioPCR${contMovimiento}" id="controlesSelect"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaPCR${contMovimiento}">

            </tbody>
        </table>

    </div>

    `);


    agregarTabla('cuerpoTablaPCR'+contMovimiento, 2, 'PCR', contMovimiento);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioPCR'+contMovimiento);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioPCR'+contMovimiento).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contMovimiento++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}





function agregarTabla(id_tabla, id_categoria, name, valor_cont) {
    // Obtener el elemento select recién agregado
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerArticulosCate/' + id_categoria,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function (data) {

            $.each(data, function (index, articulo) {
                var currentIndex = valor_cont + '' + index; // Concatenate the strings properly

                $('#'+id_tabla).append(
                    `
                    <tr id="trDeleteMov${currentIndex}">

                        <input type="hidden" id="id_movimiento${name}${currentIndex}" name="id_movimiento${name}" class="form-control" required autofocus value="0" disabled>
                        <td>
                            <input type="text" id="stocks${name}${currentIndex}" name="stocks${name}" class="form-control" required="" autofocus="" value="" disabled>
                        </td>
                        <td>
                            <input type="text" id="articulo${name}${currentIndex}" name="articulo${name}" class="form-control" required="" autofocus="" value="${articulo.nombre}" disabled>
                        </td>
                        <td>
                            <select id="lote${name}${currentIndex}" name="lote" class="form-control single-select" onchange="cargar_idmovimiento('${name}${currentIndex}', '${currentIndex}')">
                                <option value="0">Seleccione Opción</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" id="valorDef${name}${currentIndex}" name="valorDef${name}" class="form-control" required="" autofocus="" value="">
                        </td>
                        <td>
                            <input type="text" id="cantidad${name}${currentIndex}" name="cantidad" class="form-control" required="" autofocus="" value="">
                        </td>
                        <td>
                            <input type="text" id="total${name}${currentIndex}" name="total${name}" class="form-control" required="" autofocus="" value="" disabled>
                        </td>

                    </tr>
                    `
                );

                // Add event listeners to the new fields
                $('#valorDef'+name+ currentIndex + ', #cantidad'+name + currentIndex).on('input', function () {
                    calculateTotal(name, currentIndex);
                });

                cargarLoteMono('lote'+name+currentIndex, articulo.id);

            });

            //contMonoTabla++;

        },
        error: function (error) {
            console.error('Error al obtener la lista de artículos:', error);
        }
    });
}

function calculateTotal(name, index) {
    var valorDef = parseFloat($('#valorDef'+name+index).val()) || 0;
    var cantidad = parseFloat($('#cantidad'+name+index).val()) || 0;
    var totalMono = valorDef * cantidad;
    $('#total'+name+ index).val(totalMono.toFixed(2));
}






function agregarOpciones(id, id_categoria) {

    // Obtener el elemento select recién agregado
    var selectArticulo = $('#'+id);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerArticulosCate/'+id_categoria,
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
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
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
                <label for="nameKitARN" class="form-label fs-6">Nombre de Kit</label> 
                <select id="nameKitARN${contReactARN}" name="nameKitARN" class="form-control single-select" data-placeholder="Selecciona una opción" onchange="cargarLoteARN(${contReactARN})">
                </select>
            </div>

            <div class="col-md-4 mt-2">
                <label for="loteARN" class="form-label fs-6">Lote</label>
                <select id="loteARN${contReactARN}" name="loteARN" class="form-control single-select" required>
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




/* CARGA EL SELECT DEL LOTE MONO */
function cargarLoteMono(dato, id_articulo){

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
            let selectLote = $('#' + dato);

            selectLote.empty();
            selectLote.append('<option value="0">Seleccione Opción</option>');

            $.each(loteDatos, function (index, lote) {
                selectLote.append('<option value="' + lote.id + '">' + lote.nombre +' - CAD. ' + lote.f_caduca+'</option>');
            });


            $('#' + dato).select2({
                width: '100%',
            });


        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL SELECT DEL LOTE MONO */


/* CARGA EL VALOR DE LA UNIDAD MONO */
function cargar_idmovimiento(id, dato){

    let id_lote = $('#lote'+id).val();

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
            $('#id_movimiento' + id).val(loteDatos.id);
            $('#valorDef' + id).val(loteDatos.valor);
            $('#stocks' + id).val(loteDatos.unidades);

        },
        error: function(error) {
            console.error('Error al obtener los datos de la categoría:', error);
        }

    });

}
/* CARGA EL VALOR DE LA UNIDAD MONO */





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
    //let para    = $('#para').val();
    //let hora    = $('#hora').val();
    let fecha   = $('#fechaCorrida').val();
    let tipo    = $('#tipo').val();
    let protocolo   = $('#protocolo').val();
    let estacional  = $('#estacional').val();
    let variante    = $('#variante').val();
    let observacion = $('#observacion').val();

    if(tecnica == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el nombre de la tecnica',
            showConfirmButton: true,
        });

    }else if(protocolo == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar el protocolo',
            showConfirmButton: true,
        });

    }else /*if( validarDatosReaccion() )*/{
       
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

            if(validarDatosPruebas('cuerpoPCR', 'Mezcla de reacciones')
            && validarDatosPruebas('cuerpoARN', 'Extracción de ARN')
            && validarDatosPruebas('cuerpoMono', 'Monoclonales')
            && validarDatosPruebas('cuerpoPoli', 'Policlonales')
            && validarDatosPruebas('cuerpoInfluA', 'Influenza A')
            && validarDatosPruebas('cuerpoInfluB', 'Influenza B')
            && validarDatosPruebas('cuerpoCOVID', 'COVID')
            && validarDatosPruebas('cuerpoSincitial', 'Sincitial')
            && validarDatosPruebas('cuerpoConsumibles', 'Insumos')){

            //extraccion
            var extraccion = capturarDatosPruebasARN();
            console.log(capturarDatosPruebasARN());

            var pcr = capturarDatosPruebasPCR();
            console.log(capturarDatosPruebasPCR());

            var mono = capturarDatosMono();
            console.log(capturarDatosMono());

            var poli = capturarDatosPoli();
            console.log(capturarDatosPoli());

            var influA    = capturarDatosInfA()
            console.log(capturarDatosInfA());

            var influB    = capturarDatosInfB()
            console.log(capturarDatosInfB());

            var covid     = capturarDatosCovid()
            console.log(capturarDatosCovid());

            var sincitial = capturarDatosSincitial()
            console.log(capturarDatosSincitial());

            var insumos   = capturarDatosInsumos()
            console.log(capturarDatosInsumos());

            
            $.ajax({

                type: 'POST',
                url: '/inventario/saveCorridaManInf',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    tecnica: tecnica,
                    fecha:   fecha,
                    tipo:    tipo,
                    protocolo:   protocolo,
                    //estacional:  estacional,
                    //variante:    variante,
                    observacion: observacion,

                    extraccion: extraccion,
                    pcr:        pcr,
                    mono:       mono,
                    poli:       poli,
                    influA:     influA,
                    influB:     influB,
                    covid:      covid,
                    sincitial:  sincitial,
                    insumos:    insumos,
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

    /*
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
    */


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

        var observa   = $('#observaARN').val();
        
        // Verificar si alguno de los campos está vacío
        if (nombreKit && lote && fecha) {

            kits.push({
                nombreKit: nombreKit,
                lote:    lote,
                fecha:   fecha,
                observa: observa
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
            id_articulo: id_articulo,
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




/* =========================================== CAPTURAR MONOCLONALES =========================================== */
function capturarMono() {
    var datosMono = [];

    const cuerpoMono = document.getElementById('cuerpoMono');
    const contePruebaMonos = cuerpoMono.querySelectorAll('[id^=contePruebaMono]');
    
    Array.from(contePruebaMonos).forEach(contePruebaMono => {
        const id = contePruebaMono.id.replace('contePruebaMono', '');
        const fechaPrueba = document.getElementById(`fechaPrueba${id}`).value;
        const selectUsuario = document.getElementById(`selectUsuario${id}`).value;
        const selectMono = Array.from(document.getElementById(`selectMono${id}`).selectedOptions).map(option => option.value);
        const selectPrueba = Array.from(document.getElementById(`selectPrueba${id}`).selectedOptions).map(option => option.value);
        
        datosMono.push({
            id:            id,
            fechaPrueba:   fechaPrueba,
            selectUsuario: selectUsuario,
            selectMono:    selectMono,
            selectPrueba:  selectPrueba,
        });
    });

    return datosMono;
}




function validarDatosMono() {
    var datosMono = capturarMono();
    var isValid = true;
    var comentario = '';

    datosMono.forEach((dato, index) => {
        if (!dato.fechaPrueba || !dato.selectUsuario || dato.selectMono.length === 0 || dato.selectPrueba.length === 0) {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la prueba ' + (index + 1) + ' de la sección de datos de monoclonales';
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}



/* =========================================== CAPTURAR MONOCLONALES =========================================== */



/* =========================================== CAPTURAR POLICLONALES =========================================== */

function capturarPoli() {
    var datosPoli = [];

    const cuerpoPoli = document.getElementById('cuerpoPoli');
    const contePruebaPolis = cuerpoPoli.querySelectorAll('[id^=contePruebaPoli]');
    
    Array.from(contePruebaPolis).forEach(contePruebaPoli => {
        const id = contePruebaPoli.id.replace('contePruebaPoli', '');
        const fechaPrueba = document.getElementById(`fechaPruebaPoli${id}`).value;
        const selectUsuario = document.getElementById(`selectUsuarioPoli${id}`).value;
        const selectPoli = Array.from(document.getElementById(`selectPoli${id}`).selectedOptions).map(option => option.value);
        
        datosPoli.push({
            id:            id,
            fechaPrueba:   fechaPrueba,
            selectUsuario: selectUsuario,
            selectPoli:    selectPoli,
        });
    });

    return datosPoli;
}


function validarDatosPoli() {
    var datosPoli = capturarPoli();
    var isValid = true;
    var comentario = '';

    datosPoli.forEach((dato, index) => {
        if (!dato.fechaPrueba || !dato.selectUsuario || dato.selectPoli.length === 0) {
            isValid = false;
            comentario = 'Al menos un campo está vacío en la prueba ' + (index + 1) + ' de la sección de datos policlonales';
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: comentario,
            showConfirmButton: true,
        });
    }

    return isValid;
}

/* =========================================== CAPTURAR POLICLONALES =========================================== */



function obtenerMuestras(){

    // Crear un array para almacenar los valores únicos de ARN
    var valoresARN = [];

    $('#cuerpoTablaARN tr').each(function(index, row) {

        // Obtener los valores de los campos en la fila actual
        var codigo = $(row).find('input[name="codMuestraARN"]').val();
        valoresARN.push(codigo);

    });

    return valoresARN;
}


/* =========================================== CAPTURAR ARN =========================================== */
function capturarDatosPruebasARN() {
    const cuerpoARN = document.getElementById('cuerpoARN');
    const pruebas = cuerpoARN.querySelectorAll('.row.mt-2.mx-0.border-3');
    let datosPruebas = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector('[name="fechaPrueba"]').value,
            usuario: prueba.querySelector('[name="selectUsuario[]"]').value,

            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {

                id_movimiento: fila.querySelector(`[name="id_movimientoARN"]`).value,
                articulo: fila.querySelector(`[name="articuloARN"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefARN"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalARN"]`).value

            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosPruebas.push(pruebaDatos);
    });

    return datosPruebas;
}
/* =========================================== CAPTURAR ARN =========================================== */



/* =========================================== CAPTURAR PCR =========================================== */
function capturarDatosPruebasPCR() {
    const cuerpoPCR = document.getElementById('cuerpoPCR');
    const pruebas = cuerpoPCR.querySelectorAll('.row.mt-2.mx-0.border-3');
    let datosPruebas = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoPCR"]`).value,
                articulo: fila.querySelector(`[name="articuloPCR"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefPCR"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalPCR"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosPruebas.push(pruebaDatos);
    });

    return datosPruebas;
}


function validarDatosPruebas(id_cuerpo, pruebaNombre) {
    const cuerpoPCR = document.getElementById(id_cuerpo);
    const pruebas = cuerpoPCR.querySelectorAll('.row.mt-2.mx-0.border-3');
    
    let isValid = true;
    let comentario = '';

    pruebas.forEach((prueba, index) => {
        let fecha = prueba.querySelector(`[name="fechaPrueba"]`).value;
        let usuario = prueba.querySelector(`[name="selectUsuario[]"]`).value;
        
        // Validar fecha
        if (fecha === '') {
            isValid = false;
            comentario = `Debe seleccionar una fecha en la prueba ${index + 1} de la sección de ${pruebaNombre}`;
            return; // Sale del ciclo actual si hay un error
        }

        // Validar usuario
        if (usuario == 0) {
            isValid = false;
            comentario = `Debe seleccionar un usuario en la prueba ${index + 1} de la sección de ${pruebaNombre}`;
            return;
        }

        const filas = prueba.querySelectorAll('tbody tr');
        let loteSeleccionado = false;
        let cantidadValida = true;

        filas.forEach((fila, filaIndex) => {
            let lote = fila.querySelector(`[name="lote"]`).value;

            // Verificar si se seleccionó un lote
            if (lote !== '0') {
                loteSeleccionado = true;

                let cantidad = fila.querySelector(`[name="cantidad"]`).value;
                if (cantidad === '' || cantidad == 0 || cantidad == '0') {
                    isValid = false;
                    comentario = `No se ha ingresado ninguna cantidad en la prueba ${index + 1} de la sección de ${pruebaNombre}`;
                    cantidadValida = false;
                    //return;
                }
            }
        });

        // Verificar si se seleccionó al menos un lote
        if (!loteSeleccionado) {
            isValid = false;
            comentario = `No se ha seleccionado ningún lote en la prueba ${index + 1} de la sección de ${pruebaNombre}`;
            //return;
        }
    });

    // Mostrar el mensaje si hay un error y retornar false
    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: comentario,
            showConfirmButton: true,
        });
        return false;
    }

    return true;
}


/* =========================================== CAPTURAR PCR =========================================== */



/* =========================================== CAPTURAR MONO =========================================== */
function capturarDatosMono() {
    const cuerpoMono = document.getElementById('cuerpoMono');
    const pruebas = cuerpoMono.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosMono = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value, 
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value, 
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoMono"]`).value,
                articulo: fila.querySelector(`[name="articuloMono"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefMono"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalMono"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosMono.push(pruebaDatos);
    });

    return datosMono;
}
/* =========================================== CAPTURAR MONO =========================================== */


/* =========================================== CAPTURAR POLI =========================================== */
function capturarDatosPoli() {
    const cuerpoPoli = document.getElementById('cuerpoPoli');
    const pruebas = cuerpoPoli.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosPoli = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoPoli"]`).value,
                articulo: fila.querySelector(`[name="articuloPoli"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefPoli"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalPoli"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosPoli.push(pruebaDatos);
    });

    return datosPoli;
}
/* =========================================== CAPTURAR POLI =========================================== */



/* =========================================== CAPTURAR INFLUENZA A =========================================== */
function capturarDatosInfA() {
    const cuerpoInfluA = document.getElementById('cuerpoInfluA');
    const pruebas = cuerpoInfluA.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosInfA = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoInfA"]`).value,
                articulo: fila.querySelector(`[name="articuloInfA"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefInfA"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalInfA"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosInfA.push(pruebaDatos);
    });

    return datosInfA;
}
/* =========================================== CAPTURAR INFLUENZA A =========================================== */




/* =========================================== CAPTURAR INFLUENZA B =========================================== */
function capturarDatosInfB() {
    const cuerpoInfluB = document.getElementById('cuerpoInfluB');
    const pruebas = cuerpoInfluB.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosInfB = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoInfB"]`).value,
                articulo: fila.querySelector(`[name="articuloInfB"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorDefInfB"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalInfB"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosInfB.push(pruebaDatos);
    });

    return datosInfB;
}
/* =========================================== CAPTURAR INFLUENZA B =========================================== */




/* =========================================== CAPTURAR COVID =========================================== */
function capturarDatosCovid() {
    const cuerpoCOVID = document.getElementById('cuerpoCOVID');
    const pruebas = cuerpoCOVID.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosCovid = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoCovid"]`).value,
                articulo: fila.querySelector(`[name="articuloCovid"]`).value,
                lote: fila.querySelector(`[name="lote"]`).value,
                valorDef: fila.querySelector(`[name="valorCovid"]`).value,
                cantidad: fila.querySelector(`[name="cantidad"]`).value,
                total: fila.querySelector(`[name="totalCovid"]`).value
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosCovid.push(pruebaDatos);
    });

    return datosCovid;
}
/* =========================================== CAPTURAR COVID =========================================== */




/* =========================================== CAPTURAR SINCITIAL =========================================== */
function capturarDatosSincitial() {
    const cuerpoSincitial = document.getElementById('cuerpoSincitial');
    const pruebas = cuerpoSincitial.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosSincitial = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fechaPrueba"]`).value,
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value,
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoSincitial"]`).value, 
                articulo: fila.querySelector(`[name="articuloSincitial"]`).value, 
                lote: fila.querySelector(`[name="lote"]`).value, 
                valorDef: fila.querySelector(`[name="valorDefSincitial"]`).value, 
                cantidad: fila.querySelector(`[name="cantidad"]`).value, 
                total: fila.querySelector(`[name="totalSincitial"]`).value 
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosSincitial.push(pruebaDatos);
    });

    return datosSincitial;
}
/* =========================================== CAPTURAR SINCITIAL =========================================== */



/* =========================================== CAPTURAR INSUMOS =========================================== */
function capturarDatosInsumos() {
    const cuerpoConsumibles = document.getElementById('cuerpoConsumibles');
    const pruebas = cuerpoConsumibles.querySelectorAll('.row.mt-2.mx-0.border-3');

    let datosConsumibles = [];

    pruebas.forEach((prueba, index) => {
        let pruebaDatos = {
            prueba: prueba.querySelector('h3').textContent.trim(),
            fecha: prueba.querySelector(`[name="fecha"]`).value, 
            usuario: prueba.querySelector(`[name="selectUsuario[]"]`).value, 
            filas: []
        };

        const filas = prueba.querySelectorAll('tbody tr');
        filas.forEach((fila, filaIndex) => {
            let filaDatos = {
                id_movimiento: fila.querySelector(`[name="id_movimientoConsumible"]`).value, 
                articulo: fila.querySelector(`[name="articuloConsumible"]`).value, 
                lote: fila.querySelector(`[name="lote"]`).value, 
                valorDef: fila.querySelector(`[name="valorDefConsumible"]`).value, 
                cantidad: fila.querySelector(`[name="cantidad"]`).value, 
                total: fila.querySelector(`[name="totalConsumible"]`).value 
            };

            pruebaDatos.filas.push(filaDatos);
        });

        datosConsumibles.push(pruebaDatos);
    });

    return datosConsumibles;
}
/* =========================================== CAPTURAR INSUMOS =========================================== */



/* AGREGAR INFLUENZA A */
function agregarInfluenzaA(){

    //var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoInfluA').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaInfA${contInfA}">

        <h3 class="col-lg-12"> Prueba Influenza A ${contInfA+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarInfluenzaA(${contInfA})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaInfA" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaInfA${contInfA}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioInfA" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioInfA${contInfA}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl X1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaInfA${contInfA}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaInfA'+contInfA, 6, 'InfA', contInfA);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioInfA'+contInfA);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioInfA'+contInfA).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contInfA++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarInfluenzaA(dato){
    $('#contePruebaInfA'+dato).remove();
}

/* AGREGAR INFLUENZA A */



/* AGREGAR INFLUENZA B */
function agregarInfluenzaB(){

    //var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoInfluB').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaInfB${contInfB}">

        <h3 class="col-lg-12"> Prueba Influenza B ${contInfB+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarInfluenzaB(${contInfB})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaInfB" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaInfB${contInfB}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioInfB" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioInfB${contInfB}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaInfB${contInfB}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaInfB'+contInfB, 9, 'InfB', contInfB);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioInfB'+contInfB);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioInfB'+contInfB).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contInfB++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarInfluenzaB(dato){
    $('#contePruebaInfB'+dato).remove();
}

/* AGREGAR INFLUENZA B */




/* AGREGAR COVID */
function agregarCovid(){

    //var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoCOVID').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaCovid${contCovid}">

        <h3 class="col-lg-12"> Prueba Covid ${contCovid+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarCovid(${contCovid})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaCovid" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaCovid${contCovid}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioCovid" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioCovid${contCovid}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaCovid${contCovid}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaCovid'+contCovid, 7, 'Covid', contCovid);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioCovid'+contCovid);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioCovid'+contCovid).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contCovid++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarCovid(dato){
    $('#contePruebaCovid'+dato).remove();
}

/* AGREGAR COVID */



/* AGREGAR COVID */
function agregarSincitial(){

    //var arrayMuestra = obtenerMuestras();
    var id_usuario = $('#id_usuario').val();

    $('#cuerpoSincitial').append(`

    <div class="row mt-2 mx-0 border-3 border-primary pe-md-3 border-bottom position-relative col-lg-12" id="contePruebaSincitial${contSincitial}">

        <h3 class="col-lg-12"> Prueba Virus sincitial respiratorio ${contSincitial+1} </h3>

        <button type="button" class="btn position-absolute top-0 right-0 text-danger col-lg-1" aria-label="Cerrar" onclick="eliminarSincitial(${contSincitial})">
            <i class="bi bi-x-square"></i>
        </button>

        <div class="col-md-6 mt-4">
            <label for="fechaPruebaSincitial" class="form-label fs-6">Fecha</label>
            <input type="date" id="fechaPruebaSincitial${contSincitial}" name="fechaPrueba" class="form-control" required="" autofocus="" value="" >
            <div class="valid-feedback">Looks good!</div>
        </div>

        <div class="col-md-6 col-sm-6 col-6 mt-4">
            <label for="selectUsuarioSincitial" class="form-label fs-6">Usuario que realizo la Prueba</label>
            <select class="js-example-basic-multiple form-control single-select" name="selectUsuario[]" id="selectUsuarioSincitial${contSincitial}"
                    data-width="100%" data-placeholder="Selecciona una opción" data-allow-clear="true">
                
            </select>
        </div>

        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="unidades">Stocks</th>
                    <th scope="col">Reactivos</th>
                    <th scope="col" class="">Lote</th>
                    <th scope="col" class="unidades">μl x1</th>
                    <th scope="col" class="unidades">Rx-N</th>
                    <th scope="col" class="unidades">Total</th>
                </tr>
            </thead>
            <tbody id="cuerpoTablaSincitial${contSincitial}">

            </tbody>
        </table>

    </div>

    `);

    agregarTabla('cuerpoTablaSincitial'+contSincitial, 8, 'Sincitial', contSincitial);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: '/inventario/obtenerUsuariosLab/' + id_usuario,
        data: {
            _token: "{{ csrf_token() }}",
        },
        cache: false,
        success: function(res){

            var selectUsuario = $('#selectUsuarioSincitial'+contSincitial);
            selectUsuario.empty();
        
            selectUsuario.append('<option value="0">Seleccione un Usuario</option>');
        
            $.each(res, function(index, usuario) {
                var option = $('<option></option>').attr('value', usuario.id).text(usuario.name);
                selectUsuario.append(option);
            });    
            
            $('#selectUsuarioSincitial'+contSincitial).select2({
                //dropdownParent: $('.modal-body'),
                //theme: 'bootstrap4',
                width: '100%',
                //height: '38px',
                //placeholder: 'Selecciona una opción',
                //allowClear: true,
            });

            contSincitial++;

        },
        error: function(error) {
            console.error('Error al obtener los datos del usuario:', error);
        }

    });

}


function eliminarSincitial(dato){
    $('#contePruebaSincitial'+dato).remove();
}

/* AGREGAR COVID */


