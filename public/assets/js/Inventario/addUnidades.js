
$( function () {

    $('.single-select').select2({
        width: '100%',
    });

    $('#tblIArticuloIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/agregarUnidades', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'name_articulo', name: 'name_articulo' },
            { data: 'name_lote',     name: 'name_lote' },
            { data: 'cantidad',      name: 'cantidad' },
            { data: 'name_unidad',   name: 'name_unidad'},
            { data: 'name_categoria',name: 'name_categoria' },
            { data: 'valor',         name: 'valor' },

            {
                data: 'kit_cantidad',
                name: 'kit_cantidad',
                render: function (data, type, full, meta) {
                    return data || '<span class="badge text-bg-warning">Sin Asignar</span>'; 
                }
            },

            { data: 'estado',        name: 'estado' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array = `
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                        <a id="btnEditUnidad" data-id_kit="${full.id}" data-toggle="modal" data-target="#addKits" title="Agregar Presentación" class="show-tooltip" data-title="Agregar Presentación">
                            <i class="font-22 bi bi-node-plus"-></i>
                        </a>

                        <a id="btnEditNombre" data-id_articulo="${full.id_articulo}" data-toggle="modal" data-target="#addNombre" title="Agregar Nombre" class="show-tooltip ml-2" data-title="Agregar Nombre">
                            <i class="font-22 bi bi-alphabet-uppercase"></i>
                        </a>

                        <a id="btnEditValor" data-id_kit="${full.id}" data-toggle="modal" data-target="#addValor" title="Agregar Cant. Utilizar" class="show-tooltip ml-2" data-title="Agregar Cant. Utilizar">
                            <i class="font-22 bi bi-123"></i>
                        </a>

                    </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [0, 'desc']
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


    var table = $('#tblIArticuloIndex').DataTable();


    $(document).on('click', '#btnGuardarKit', function(){

        /*
        var idKit = document.getElementById("btnEditUnidad").dataset.id_kit;        
        var kit   = document.getElementById("kit").value;
        */
        var kit    = document.getElementById("kit").value;
        var id_kit = document.getElementById("id_kit").value;

        var isValid = /^\d+$/.test(kit);

        if(kit === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una valor',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar solo Números enteros',
                showConfirmButton: true,
            });

        }else{

            $.ajax({

                type: 'POST',
                //url: '{{ route("encuesta.saveEncuesta") }}',
                url: '/inventario/updateKit',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'idKit': id_kit,
                    'kit':   kit,
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

                                    table.ajax.reload();  
                                    document.getElementById('btnCerrarModalCat2').click(); 
                                    //$('#contModalUpdateUnidades').text('');
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



    /* CERRAR EL MODAL DE MANERA MANUAL */
    $(document).on('click', '#btnCerrarModal, #btnCerrarModalCat2', function() {
        $('#addKits').modal('hide');
        $('#addValor').modal('hide');
        $('#contModalUpdateUnidades').text('');
    });
    /* CERRAR EL MODAL DE MANERA MANUAL */


    /* CARGAR UPDATE */
    $(document).on('click', '#btnEditUnidad', function(){
    
        let id_kit = $(this).data('id_kit');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/obtenerKit/' + id_kit,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_kit   = res.id;
                let cantidad = res.cantidad;

                $('#contModalUpdateUnidades').text('');
                //var uniqueModalId = 'updateCategoria_' + new Date().getTime(); // Genera un ID único basado en la marca de tiempo
                $('#contModalUpdateUnidades').append(`
                    <div class="modal fade" id="addKits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cantidad de Kits</h5>
                                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                                    <div id="modalContent">
                                        <!-- Aquí se mostrarán los datos -->
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <input type="hidden" id="id_kit" name="id_kit" class="form-control" required="" autofocus="" value="${id_kit}">

                                            <div class="col-md-4">
                                                <label for="kit" class="form-label fs-6">Cantidad de Kits</label>
                                                <input type="text" id="kit" name="kit" class="form-control" required="" autofocus="" value="${cantidad}">
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                                <div class="invalid-feedback">Ingrese solo números</div>
                                            </div>
                
                                        </div>
                
                                    </div>
                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnGuardarKit">Guardar</button>
                                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);


                document.getElementById('kit').addEventListener('input', function () {
                    var inputValue = this.value;
                    var isValid = /^\d+$/.test(inputValue);
            
                    if (!isValid) {
                        this.setCustomValidity('Ingrese solo números');
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
                
                // Abre el modal una vez que se ha creado
                $(`#addKits`).modal('show');

            },
            error: function(error) {
                console.error('Error al obtener los datos del Kit:', error);
            }

        });
        
    });
    /* CARGAR UPDATE */



    /* CERRAR EL MODAL DE MANERA MANUAL */
    $(document).on('click', '.btnCerrarModalName', function() {
        const modalId = $(this).closest('.modal').attr('id');
        $('#' + modalId).modal('hide');
        $('#' + modalId).remove(); // Elimina el modal del DOM
    });
    /* CERRAR EL MODAL DE MANERA MANUAL */

    /* ACTUALIZAR NOMBRE */
    $(document).on('click', '#btnEditNombre', function(){
        let id_articulo = $(this).data('id_articulo');
        let uniqueModalId = 'addNombre_' + new Date().getTime(); // Genera un ID único basado en la marca de tiempo
        
        $('#contModalUpdateUnidades').text('');
        
        $('#contModalUpdateUnidades').append(`
            <div class="modal fade" id="${uniqueModalId}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cantidad de Kits</h5>
                            <button type="button" class="close btn btn-danger " aria-label="Close" id="btnCerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                            <div id="modalContent">
                                <!-- Aquí se mostrarán los datos -->
                                <div class="row d-flex align-items-center justify-content-center">
                                    <input type="hidden" id="id_articulo" name="id_articulo" class="form-control" required="" autofocus="" value="${id_articulo}">

                                    <div class="col-md-4">
                                        <label for="kit" class="form-label fs-6">Nuevo Nombre</label>
                                        <input type="text" id="newNombre" name="newNombre" class="form-control" required="" autofocus="" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnGuardarNombre">Guardar</button>
                            <button type="button" class="btn btn-secondary btnCerrarModalName" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `);

        // Abre el modal una vez que se ha creado
        $(`#${uniqueModalId}`).modal('show');
    });
    /* ACTUALIZAR NOMBRE */



    $(document).on('click', '#btnGuardarNombre', function(){

        var id_articulo = document.getElementById("id_articulo").value;
        var newNombre   = document.getElementById("newNombre").value;


        if(newNombre === ''){

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
                url: '/inventario/updateNameReactivo',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id_articulo': id_articulo,
                    'newNombre':   newNombre,
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

                                    table.ajax.reload();  
                                    let modal = document.querySelector('.modal.show');
                                    if (modal) {
                                        $(modal).modal('hide');
                                    }
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



    /* CARGAR UPDATE */
    $(document).on('click', '#btnEditValor', function(){

        let id_kit = $(this).data('id_kit');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/obtenerKit/' + id_kit,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_kit   = res.id;
                let valor = res.valor;

                $('#contModalUpdateUnidades').text('');
                //var uniqueModalId = 'updateCategoria_' + new Date().getTime(); // Genera un ID único basado en la marca de tiempo
                $('#contModalUpdateUnidades').append(`
                    <div class="modal fade" id="addValor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cantidad de Kits</h5>
                                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                                    <div id="modalContent">
                                        <!-- Aquí se mostrarán los datos -->
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <input type="hidden" id="id_kitv" name="id_kitv" class="form-control" required="" autofocus="" value="${id_kit}">

                                            <div class="col-md-4">
                                                <label for="valor" class="form-label fs-6">Valor por defecto del Kits</label>
                                                <input type="text" id="valor" name="valor" class="form-control" required="" autofocus="" value="${valor}">
                                                <div class="valid-feedback">¡Se ve bien!</div>
                                                <div class="invalid-feedback">Ingrese solo números</div>
                                            </div>
                
                                        </div>
                
                                    </div>
                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnGuardarValor">Guardar</button>
                                    <button type="button" class="btn btn-secondary" id="btnCerrarModal" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);


                document.getElementById('valor').addEventListener('input', function () {
                    var inputValue = this.value;
                    var isValid = /^\d+(\.\d+)?$/.test(inputValue);
            
                    if (!isValid) {
                        this.setCustomValidity('Ingrese solo números');
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
                
                // Abre el modal una vez que se ha creado
                $(`#addValor`).modal('show');

            },
            error: function(error) {
                console.error('Error al obtener los datos del Kit:', error);
            }

        });
        
    });
    /* CARGAR UPDATE */


    /* GUARDAR VALOR */
    $(document).on('click', '#btnGuardarValor', function(){

        /*
        var idKit = document.getElementById("btnEditUnidad").dataset.id_kit;        
        var kit   = document.getElementById("kit").value;
        */
        var valor  = document.getElementById("valor").value;
        var id_kit = document.getElementById("id_kitv").value;

        var isValid = /^\d+(\.\d+)?$/.test(valor);

        if(valor === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una valor',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar solo Números enteros o decimales',
                showConfirmButton: true,
            });

        }else{

            $.ajax({

                type: 'POST',
                //url: '{{ route("encuesta.saveEncuesta") }}',
                url: '/inventario/updateValor',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'idKit': id_kit,
                    'valor': valor,
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

                                    table.ajax.reload();  
                                    document.getElementById('btnCerrarModalCat2').click(); 
                                    //$('#contModalUpdateUnidades').text('');
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
    /* GUARDAR VALOR */


});



function guardarArt(id_select, id_subcategoria){

    var id_articulo = document.getElementById(id_select).value;

    if(id_articulo === '' || id_articulo === '0' ){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe de seleccionar un artículo',
            showConfirmButton: true,
        });

    }else{

        $.ajax({

            type: 'POST',
            //url: '{{ route("encuesta.saveEncuesta") }}',
            url: '/inventario/updateSubcategoria',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id_articulo': id_articulo,
                'id_subcategoria':   id_subcategoria,
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

                                var articulosHTML = '';
                                if (response.articulosList.length > 0) {
                                    response.articulosList.forEach(function(usuario) {
            
                                        articulosHTML += `
                                            <li class="list-group-item mb-2">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        ${usuario.nombre}
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteSub( ${usuario.id}, ${id_subcategoria} )">
                                                            <span class="bi bi-x-circle"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li> `;
            
                                    });
                                } else {
                                    articulosHTML += '<li class="list-group-item mb-2">Aun no hay reactivos para esta categoría</li>';
                                }
                                $('#group'+id_subcategoria).html(articulosHTML);


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


function deleteSub(id_articulo, id_subcategoria){

    $.ajax({

        type: 'POST',
        //url: '{{ route("encuesta.saveEncuesta") }}',
        url: '/inventario/deleteSubcategoria',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'id_articulo':     id_articulo,
            'id_subcategoria': id_subcategoria,
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

                            var articulosHTML = '';
                            if (response.articulosList.length > 0) {
                                response.articulosList.forEach(function(usuario) {
        
                                    articulosHTML += `
                                        <li class="list-group-item mb-2">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    ${usuario.nombre}
                                                </div>
                                                <div class="col-lg-3">
                                                    <a tupe="buttom" class="btn btn-danger btn-sm" onclick="deleteUser( ${usuario.id}, ${id_subcategoria} )">
                                                        <span class="bi bi-x-circle"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </li> `;
        
                                });
                            } else {
                                articulosHTML += '<li class="list-group-item mb-2">Aun no hay reactivos para esta categoría</li>';
                            }
                            $('#group'+id_subcategoria).html(articulosHTML);


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
                icon:  'error',
                title: 'SoftInspi',
                type:  'error',
                text:   error,
                showConfirmButton: true,
            });
        }
    });

}
