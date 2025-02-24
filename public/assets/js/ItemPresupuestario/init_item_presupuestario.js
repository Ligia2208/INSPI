$( function () {

    populateYearSelect(2020); //arma el select con los años
    $('.js-example-basic-single').select2({
        width: '100%',
    });



    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblItemPresupuestarioIndex').DataTable({ //id de la tabla en el visual (index)
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/itemPresupuestario', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre',        name: 'nombre' },
            { data: 'descripcion',   name: 'descripcion' },
            { data: 'monto',         name: 'monto' },
            { data: 'fecha',         name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                        <a id="btnRecordItemP" data-id_item="${full.id}" title="Historial del Item" class="show-tooltip mr-1" data-title="Historial del Item" data-toggle="modal" data-target="#modalRecordItem">
                            <i class="font-22 bi bi-bar-chart-steps text-success"></i>
                        </a>

                        <a id="btnEditarItemP" data-id_editar="${full.id}" title="Editar item" class="show-tooltip mr-1" data-title="Editar item">
                            <i class="font-22 fadeIn animated bi bi-pen" ></i>
                        </a>
                        <a id="btnEliminarItemP" data-id_borrar="${full.id}" title="Eliminar item" class="red show-tooltip" data-title="Eliminar item">
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
    $(document).on('click', '#btnEliminarItemP', function(){
        //alert('funciona');

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
                    url: '/itemPresupuestario/deleteItemP',
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
    $(document).on('click', '#btnEditarItemP', function(){

        let id_itemPres = $(this).data('id_editar');
        console.log('ID a editar:', id_itemPres);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/itemPresupuestario/obtenerItemP/' + id_itemPres,
            data: {
                _token: "{{ csrf_token() }}",

            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_itemPres = res.itemP.id;
                let nombre      = res.itemP.nombre;
                let descripcion = res.itemP.descripcion;
                let monto       = res.itemP.monto;
                let estado         = res.itemP.estado;
                let created_at     = res.itemP.created_at;
                let updated_at     = res.itemP.updated_at;

                $('#contModalUpdateItemPres').text('');

                let html = '';

                html += `
                <div class="modal fade" id="updateItemP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar Item Presupuestario</h5>
                                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                                <div>
                                    <input type="hidden" id="id_itemPres" name="id_itemPres" class="form-control" required="" autofocus="" value="${id_itemPres}">
                                    <div class="col-md-12">
                                        <label for="nameItemPU" class="form-label fs-6">Nombre del item</label>
                                        <input type="text" id="nameItemPU" name="nameItemPU" class="form-control" required="" autofocus="" value="${nombre}">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="descripcionIPU" class="form-label fs-6">Descripción</label>
                                        <input type="text" id="descripcionIPU" name="descripcionIPU" class="form-control" required="" autofocus="" value="${descripcion}">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="montoIPU" class="form-label fs-6">Monto</label>
                                        <input type="text" id="montoIPU" name="montoIPU" class="form-control" required="" autofocus="" value="${monto}">
                                        <div class="valid-feedback">Looks good!</div>
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

        let id_itemP    = $('#id_itemPres').val();
        let nameItem   = $('#nameItemPU').val();
        let descripcion   = $('#descripcionIPU').val();
        let montoItem   = $('#montoIPU').val();

        if(nameItem === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un nombre',
                showConfirmButton: true,
            });

        }else if(descripcion === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una descripción',
                showConfirmButton: true,
            });

        }

        else if(montoItem === ''){

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
                type: 'PUT',
                url: '/itemPresupuestario/actualizarItemP/' + id_itemP,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'nombre' : nameItem,
                    'descripcion': descripcion,
                    'monto'  : montoItem,


                },
                success: function(response) {

                    $('#updateItemP').modal('hide');
                    table.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        type:  'success',
                        text: response.message,
                    });

                },
                error: function(error) {
                    console.error('Error al actualizar el item:', error);
                }
            });

        }

    });
    /* GUARDAR UPDATE */

    var table = $('#tblItemPresupuestarioIndex').DataTable();




    /* REINICIAR VALORES DE LOS ITEM */
    $(document).on('click', '#btnReboot', function(){

        Swal.fire({
            icon: 'warning',
            type: 'warning',
            title: 'SoftInspi',
            text: 'Seguro que quiere reiniciar todos los valores del los Items Presupuestarios.!',
            showConfirmButton: true,
            confirmButtonText: 'Sí, aplicar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value == true) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/itemPresupuestario/rebootItems',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    cache: false,
                    success: function(res){
        
                        if(res.valor){

                            table.ajax.reload();
        
                            Swal.fire({
                                icon: 'success',
                                title: 'SoftInspi',
                                type: 'success',
                                text: res.message,
                                showConfirmButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'Aceptar',
                                timer: 2500
                            });
                            
        
                        }else{
        
                            Swal.fire({
                                icon: 'error',
                                title: 'SoftInspi',
                                type: 'error',
                                text: 'Hubo un error al reiniciar los valores',
                                showConfirmButton: false,
                                timer: 1500
                            });
        
                        }
        
                    }
        
                });

            }
        });

    });
    /* REINICIAR VALORES DE LOS ITEM */


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

