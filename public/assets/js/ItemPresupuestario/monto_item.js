$( function () {

    populateYearSelect(2020); //arma el select con los años
    $('.js-example-basic-single').select2({
        width: '100%',
    });

    agregarUnidad();

    actualizarMontos();

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblItemPresupuestarioIndex').DataTable({ //id de la tabla en el visual (index)
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/itemPresupuestario/monto_item', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'n_item',        name: 'n_item' },
            { data: 'nombre_item',   name: 'nombre_item' },
            { data: 'monto',         name: 'monto' },
            { data: 'fecha',         name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                        <!--
                        <a id="btnRecordItemP" data-id_item="${full.id}" title="Historial del Item" class="show-tooltip mr-1" data-title="Historial del Item" data-toggle="modal" data-target="#modalRecordItem">
                            <i class="font-22 bi bi-bar-chart-steps text-success"></i>
                        </a>
                        -->

                        <a id="btnEditarMonto" data-id_editar="${full.id}" title="Editar Monto" class="show-tooltip mr-1" data-title="Editar Monto">
                            <i class="font-22 fadeIn animated bi bi-pen" ></i>
                        </a>
                        <a id="btnEliminarMonto" data-id_borrar="${full.id}" title="Eliminar item" class="red show-tooltip" data-title="Eliminar item">
                            <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                        </a>

                    </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [3, 'desc']
        ],

        // Otras configuraciones de DataTables aquí
        language: {
            "emptyTable": "No hay información", //no hay datos disponibles
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior",
                            "showing": "Mostrando"
                        }
        },
    });


    var table = $('#tblItemPresupuestarioIndex').DataTable();

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



document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('item-select');
    const selectedItemsContainer = document.getElementById('selected-items');
    const addItemButton = document.getElementById('add-item');

    addItemButton.addEventListener('click', function () {
        const selectedOptions = Array.from(select.selectedOptions);

        selectedOptions.forEach(option => {
            const itemId = option.value?.trim(); // Asegúrate de que no sea nulo o espacios en blanco
            const itemName = option.text?.trim();

            if (itemId) { // Validar que el ID no sea nulo, vacío o inválido
                // Crear un campo editable para el ítem seleccionado
                const itemRow = document.createElement('div');
                itemRow.classList.add('mb-2');

                itemRow.innerHTML = `
                <div class="input-group">
                    <span class="input-group-text">${itemName}</span>
                    <input type="hidden" name="items[${itemId}][id]" value="${itemId}">
                    <input type="text" name="items[${itemId}][valor]" class="form-control" placeholder="Ingrese un valor">
                    <button type="button" class="btn btn-danger remove-item">X</button>
                </div>
                `;

                selectedItemsContainer.appendChild(itemRow);

                // Remover opción del select
                option.remove();

                // Agregar evento para eliminar el ítem de la lista seleccionada
                itemRow.querySelector('.remove-item').addEventListener('click', function () {
                    selectedItemsContainer.removeChild(itemRow);

                    // Reagregar al select
                    const newOption = new Option(itemName, itemId);
                    select.add(newOption);
                });
            }
        });
    });
});




//CÓDIGO PARA GUARDAR ITEM PRESUPUESTARIO
function guardarItemPres(){
    let nameItem = $('#nameItem').val();
    let descripcion = $('#descripcion').val();
    let montoItem = $('#montoItem').val();
    let estado = 'A'

    if(nameItem === ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un nombre',
            showConfirmButton: true,
        });

    }
    else if(descripcion === ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar una descripción',
            showConfirmButton: true,
        });

    }

    else if(montoItem === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de ingresar un monto',
            showConfirmButton: true,
        });

    }
    else{

        $.ajax({

            type: 'POST',
            url: '/itemPresupuestario/saveItemPres',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'nameItem'   :   nameItem,
                'descripcion':   descripcion,
                'montoItem'  :   montoItem,
                'estado'     :   estado,
            },
            success: function(response) {

                if(response.data){

                    if(response['data'] == true){
                        document.getElementById('btnCerrarItemPres').click(); //cerrar modal

                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'SoftInspi',
                            text: response['message'],
                            showConfirmButton: true,
                        }).then((result) => {
                              if (result.value == true) {
                                  table.ajax.reload(); //actualiza la tabla
                                  $('#nameItem').val('');
                                  $('#descripcion').val('');
                                  $('#montoItem').val('');
                                  actualizarMontos();
                             }
                        });

                    }else{
                        Swal.fire({
                            icon: 'error',
                            type:  'error',
                            title: 'SoftInspi',
                            text: response['message'],
                            showConfirmButton: true,
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

    var table = $('#tblItemPresupuestarioIndex').DataTable();
}

//------------------------------------------------------------------------------------------------


//CÓDIGO PARA BOTÓN DE BORRAR
$(function(){
    $(document).on('click', '#btnEliminarMonto', function(){

        let id_itemP = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere eliminar este registro.',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/itemPresupuestario/deleteItemDireccion',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_itemP,
                    },
                    success: function(response) {

                        //console.log(response.data['id_chat'])
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
                                        table.ajax.reload(); //actualiza la tabla
                                        actualizarMontos();
                                    }
                                });

                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'SoftInspi',
                                    text: response['message'],
                                    showConfirmButton: true,
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
        });

    });

    var table = $('#tblItemPresupuestarioIndex').DataTable();


})

//=================================================================================

//CÓDIGO PARA EDITAR LOS ITEM PRESUPUESTARIOS
$(function(){
    /* CARGAR UPDATE */
    $(document).on('click', '#btnEditarMonto', function(){

        let id_monto = $(this).data('id_editar');
        //console.log('ID a editar:', id_itemPres);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/itemPresupuestario/obtenerDireccionItem/' + id_monto,
            data: {
                _token: "{{ csrf_token() }}",

            },
            cache: false,
            success: function(res){
                //console.log(res);

                let id_monto    = res.datos.id;
                let nombre      = res.datos.nombre;
                let descripcion = res.datos.descripcion;
                let monto       = res.datos.monto;
                let estado         = res.datos.estado;
                let created_at     = res.datos.created_at;
                let updated_at     = res.datos.updated_at;

                $('#contModalUpdateItemPres').text('');

                let html = '';

                html += `
                <div class="modal fade" id="updateItemP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Presupuesto del Item</h5>
                                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                                <div>

                                    <input type="hidden" id="id_item_monto" name="id_item_monto" class="form-control" required="" autofocus="" value="${id_monto}">

                                    <div class="col-md-12">
                                        <label for="montoEdit" class="form-label fs-6">Monto</label>
                                        <input type="text" id="montoEdit" name="montoEdit" class="form-control" required="" autofocus="" value="${monto}">
                                        <div class="valid-feedback">¡Se ve bien!</div>
                                        <div class="invalid-feedback">Ingrese solo números</div>
                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btnItemPUpdate">Guardar</button>
                                <button type="button" class="btn btn-secondary" id="btnCerrarModalCat" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                $('#contModalUpdateItemPres').append(html);

                // Abre el modal una vez que se ha creado
                $(`#updateItemP`).modal('show');

                $('#montoEdit').on('input', function () {
                    validarInputNumerico(this);
                });

            },
            error: function(error) {
                console.error('Error al obtener los datos:', error);
            }

        });

    });
    /* CARGAR UPDATE */

     /* CERRAR EL MODAL DE MANERA MANUAL */
     $(document).on('click', '#btnCerrarModalCat, #btnCerrarModalCat2', function() {
        $('#updateItemP').modal('hide');
    });
    /* CERRAR EL MODAL DE MANERA MANUAL */


    /* GUARDAR UPDATE */
    $(document).on('click', '#btnItemPUpdate', function(){

        let id_direccion = $('#id_item_monto').val();
        let montoEdit    = $('#montoEdit').val();
        let isValid = /^\d+(\.\d+)?$/.test(montoEdit);

        if(montoEdit === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un monto',
                showConfirmButton: true,
            });
        }else if (!isValid) {

            Swal.fire({
                icon: 'error',
                title: 'SoftInspi',
                text: 'El valor ingresado no es válido. Debe ser un número entero o decimal.',
                showConfirmButton: true,
            });
        }else if (parseFloat(montoEdit) < 0) {
            // Validación si el monto es negativo
            Swal.fire({
                icon: 'error',
                title: 'SoftInspi',
                text: 'El monto no puede ser negativo.',
                showConfirmButton: true,
            });
        }else{

            $.ajax({
                type: 'PUT',
                url: '/itemPresupuestario/actualizarItemMonto/' + id_direccion,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'monto' : montoEdit,
                },
                success: function(response) {

                    if(response.error){

                        Swal.fire({
                            icon: 'error',
                            title: 'CoreInspi',
                            type:  'error',
                            text: response.message,
                        });

                    }else{

                        $('#updateItemP').modal('hide');
                        table.ajax.reload();
                        actualizarMontos();
    
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            type:  'success',
                            text: response.message,
                        });

                    }

                },
                error: function(error) {

                    let response = JSON.parse(error.responseText);
                    if(response.error){

                        Swal.fire({
                            icon: 'error',
                            title: 'CoreInspi',
                            type:  'error',
                            text: response.message,
                        });

                    }
                }
            });

        }

    });
    /* GUARDAR UPDATE */

    var table = $('#tblItemPresupuestarioIndex').DataTable();



    /* ABRIL MODAL PARA GENERAR EL HISTORIAL */
    $(document).on('click', '#btnRecordItemP', function(){

        var itemId = $(this).data('id_item');
        $('#id_itemPres').val(itemId);

    });
    /* ABRIL MODAL PARA GENERAR EL HISTORIAL */



    /* GENERAR REPORTE */
    $(document).on('click', '#btGeneHistorial', function(){

        document.getElementById('btGeneHistorialCerrar').click();
        document.getElementById('btnModalAbrir').click();

        var id_item = $('#id_itemPres').val();
        var anio = $('#yearSelect').val();
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/itemPresupuestario/traerHistorial?id_item='+id_item+'&anio='+anio,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){

                if(res.valor){

                    $('#contenedorHistorial').empty();

                    $('#contenedorHistorial').append(`
                        <p class="small p-2 mb-1 rounded-3 text-center" style="background-color: #f5f6f7;"> <strong>Item presupuestario: </strong>${res.nombre}</p>
                        <p class="small p-2 mb-1 rounded-3 text-center" style="background-color: #f5f6f7;"><strong>Monto Inicial:</strong> ${res.monto_ini} </p>
                    `);

                    
                    res.historiales.forEach(function(historial) {

                        let actOpera  = historial.actOpera;
                        let subActi   = historial.subActi;
                        let tipo      = historial.tipo;
                        let consumido = historial.consumido;
                        let monto     = historial.monto;
                        let fecha     = historial.fecha;

                        if(tipo == 'I'){

                            $('#contenedorHistorial').append(`
                                <div class="d-flex flex-row justify-content-start">
    
                                    <div>
                                        <p class="small ms-3 mt-4 mb-0 rounded-3 text-muted"><strong> Tipo: </strong> Ingreso -- <strong> Fecha: </strong> ${fecha} </p>
                                        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;"> 
                                            <strong> Actividad: </strong> ${actOpera} <br>
                                            <strong> Sub-Actividad: </strong> ${subActi}
                                        </p>
                                        <p class="small ms-3 mb-3 rounded-3 text-muted"><strong> Consumido: </strong>${consumido}  - <strong> Saldo: </strong> ${monto} </p>
                                    </div>
    
                                </div>
                            `);
    
                        }else{
    
                            $('#contenedorHistorial').append(`
                                <div class="d-flex flex-row justify-content-end mt-4 pt-1">
                                    <div>
                                        <p class="small ms-3 mb-0 rounded-3 text-muted"> <strong> Tipo: </strong> Egreso -- <strong> Fecha: </strong> ${fecha}  </p>
                                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
                                            <strong> Actividad: </strong>${actOpera}<br>
                                            <strong> Sub-Actividad: </strong> ${subActi}
                                        </p>
                                        <p class="small ms-3 mb-3 rounded-3 text-muted"><strong> Consumido: </strong>${consumido}  -  <strong> Saldo: </strong> ${monto} </p>
                                    </div>
                                </div>
                            `);
    
                        }

                    });

                    //console.log(res);

                }else{



                }

            }

        });
        

    });
    /* GENERAR REPORTE */


});




// Función para validar input numérico
function validarInputNumerico(input) {
    var inputValue = input.value;
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




function populateYearSelect(startYear) {
    var currentYear = new Date().getFullYear();
    var select = document.getElementById('yearSelect');

    for (var year = startYear; year <= currentYear; year++) {
        var option = document.createElement('option');
        option.value = year;
        option.text = year;

        if (year === currentYear) {
            option.selected = true;
        }

        select.appendChild(option);
    }
}


function agregarUnidad(){
    // Realiza una solicitud AJAX para obtener las opciones de la unidad ejecutora
    $.ajax({
        type: 'GET', // O el método que estés utilizando en tu ruta
        url: '/planificacion/get_unidad', // Ruta en tu servidor para obtener las opciones
        success: function(data) {
            var unidadSelect = $('#unidad_ejecutora');
            unidadSelect.empty(); // Limpia las opciones actuales

            unidadSelect.append($('<option>', {
                value: 0,
                text: 'Seleccione una unidad ejecutora'
            }));

            // Agrega las nuevas opciones basadas en la respuesta del servidor
            $.each(data.valores, function(index, unidad) {
                unidadSelect.append($('<option>', {
                    value: unidad.id,
                    text:  unidad.nombre+' - '+unidad.descripcion
                }));
            });

            agregarEstructura();

        },
        error: function(error) {
            console.error('Error al obtener opciones de la unidad ejecutora', error);
        }
    });
}

function guardarEstructura(){

    let fuente_financiamiento = $('#fuente_financiamiento').val();
    let unidad_ejecutora = $('#unidad_ejecutora').val();
    let programa         = $('#programa').val();
    let proyecto         = $('#proyecto').val();
    let actividad        = $('#actividad').val();
    let id_direccion     = $('#id_direccion').val();


    if(unidad_ejecutora === '' || unidad_ejecutora === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar una Unidad Ejecutora',
            showConfirmButton: true,
        });

    }
    else if(programa === '' || programa === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar un Programa',
            showConfirmButton: true,
        });

    }
    else if(proyecto === '' || proyecto === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar un Proyecto',
            showConfirmButton: true,
        });

    }
    else if(actividad === '' || actividad === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar un Actividad',
            showConfirmButton: true,
        });

    }
    else if(fuente_financiamiento === '' || fuente_financiamiento === '0'){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar una Fuente de Financiamiento',
            showConfirmButton: true,
        });

    }else{

        $.ajax({
            type: 'PUT',
            url: '/itemPresupuestario/actualizarEstructura',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id_fuente'   : fuente_financiamiento,
                'id_direccion': id_direccion,
            },
            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'CoreInspi',
                    type:  'success',
                    text: response.message,
                });

            },
            error: function(error) {
                console.error('Error al actualizar el item:', error);
            }
        });


    }


}


function guardarItemsSeleccionados() {

    let table = $('#tblItemPresupuestarioIndex').DataTable();

    const idDireccion = $('#id_dir').val();
    const items = [];

    // Recorre los ítems seleccionados y crea un array con sus datos
    $('#selected-items .input-group').each(function () {
        const itemId = $(this).find('input[name$="[id]"]').val();
        const itemValor = $(this).find('input[name$="[valor]"]').val();

        if (itemId && itemValor) {
            items.push({
                id: itemId,
                valor: itemValor
            });
        }
    });

    if (items.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'SoftInspi',
            text: 'Debe seleccionar y asignar valores a los ítems antes de guardar.',
            showConfirmButton: true,
        });
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/itemPresupuestario/actualizarItems',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id_direccion: idDireccion,
            items: items
        },
        success: function (response) {
            table.ajax.reload();
            actualizarMontos();
            Swal.fire({
                icon: 'success',
                title: 'SoftInspi',
                text: response.message,
                showConfirmButton: true,
            });

            $('#selected-items').text('');

        },
        error: function (error) {

            let response = JSON.parse(error.responseText);
            if(response.error){

                Swal.fire({
                    icon: 'error',
                    title: 'CoreInspi',
                    type:  'error',
                    text: response.message,
                });
            }

        }
    });
}




function agregarEstructura(){

    let id_fuente = $('#id_fuente').val();

    if(id_fuente != 0 || id_fuente != ''){

        $.ajax({
            type: 'GET', // O el método que estés utilizando en tu ruta
            url: '/itemPresupuestario/get_estructura/'+id_fuente, // Ruta en tu servidor para obtener las opciones
            success: function(response) {
    
                if (response.success) {
                    let data        = response.data;
                    let programas   = response.programa;
                    let proyectos   = response.proyecto;
                    let actividades = response.actividadPre;
                    let fuentes     = response.fuente;
    
                    // Cargar y seleccionar el valor en Unidad Ejecutora
                    /*
                    $('#unidad_ejecutora').empty();
                    programas.forEach(programa => {
                        $('#unidad_ejecutora').append(
                            `<option value="${programa.id}" ${programa.id == data.id_unidad ? 'selected' : ''}>
                                ${programa.nombre}
                            </option>`
                        );
                    });
                    */
    
                    $('#unidad_ejecutora').val(data.id_unidad);
    
                    // Cargar y seleccionar el valor en Programa
                    $('#programa').empty();
                    programas.forEach(programa => {
                        $('#programa').append(
                            `<option value="${programa.id}" ${programa.id == data.id_programa ? 'selected' : ''}>
                                ${programa.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Proyecto
                    $('#proyecto').empty();
                    proyectos.forEach(proyecto => {
                        $('#proyecto').append(
                            `<option value="${proyecto.id}" ${proyecto.id == data.id_proyecto ? 'selected' : ''}>
                                ${proyecto.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Actividad
                    $('#actividad').empty();
                    actividades.forEach(actividad => {
                        $('#actividad').append(
                            `<option value="${actividad.id}" ${actividad.id == data.id_actividad ? 'selected' : ''}>
                                ${actividad.nombre}
                            </option>`
                        );
                    });
    
                    // Cargar y seleccionar el valor en Fuente
                    $('#fuente_financiamiento').empty();
                    fuentes.forEach(fuente => {
                        $('#fuente_financiamiento').append(
                            `<option value="${fuente.id}" ${fuente.id == data.id_fuente ? 'selected' : ''}>
                                ${fuente.nombre}
                            </option>`
                        );
                    });
                }
    
    
            },
            error: function(error) {
                console.error('Error al obtener opciones de la unidad ejecutora', error);
            }
        });

    }

}


function actualizarMontos(){

    let id_direccion     = $('#id_direccion').val();

    $.ajax({
        type: 'GET', // O el método que estés utilizando en tu ruta
        url: '/itemPresupuestario/get_montos/'+id_direccion, // Ruta en tu servidor para obtener las opciones
        success: function(response) {

            if (response.success) {
                let monto_total   = response.monto_total;
                let total_ocupado = response.total_ocupado;
                let por_ocupar    = response.por_ocupar;

                $('#monto_total').text('');
                $('#monto_total').text('$'+monto_total);

                $('#total_ocupado').text('');
                $('#total_ocupado').text('$'+total_ocupado);

                $('#por_ocupar').text('');
                $('#por_ocupar').text('$'+por_ocupar);

                if(por_ocupar < 0){
                    Swal.fire({
                        icon:  'warning',
                        title: 'CoreInspi',
                        type:  'warning',
                        text:  'Se ha pasado del monto asignado por $' +por_ocupar,
                    });
                }

            }

        },
        error: function(error) {
            console.error('Error al obtener opciones de la unidad ejecutora', error);
        }
    });

}