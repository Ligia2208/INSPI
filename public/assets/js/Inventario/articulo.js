
$( function () {


    $('.select2Core').select2({
        width: '100%', 
        dropdownParent: $('#addCategoria .modal-body')
    });


    $('#tblIArticuloIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/articulo', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre',      name: 'nombre' },
            //{ data: 'precio',      name: 'precio' },
            { data: 'categoria',   name: 'categoria' },
            { data: 'unidad',      name: 'unidad' },
            { data: 'estado',      name: 'estado'},
            { data: 'fecha',       name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array = `
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                        <a id="btnEditUnidad" data-id_update="${full.id}" data-nombre="${full.nombre}" title="Editar Artículo" data-title="Editar Artículo">
                            <i class="font-22 fadeIn animated bi bi-pen" ></i>
                        </a>
                        <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Artículo" data-title="Eliminar Artículo">
                        <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                        </a>
                    </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [4, 'desc']
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

    $(document).on('click', '#btnArticulo', function(){
        
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
    
                                table.ajax.reload(); //actualiza la tabla 
                                document.getElementById('btnCerrarModal').click(); //cerrar modal
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
                                
                                document.getElementById('btnCerrarModal').click(); //cerrar modal
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
                        text:  response.message,
                        showConfirmButton: true,
                    });
                }
            });

        }
    });



    /* ELIMINAR UNIDAD */
    $(document).on('click', '#btnDeleteSeg', function(){
        
        let id_articulo = $(this).data('id_delete');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere eliminar este Artículo.',
            showConfirmButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/inventario/deleteArticulo',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id_articulo': id_articulo,
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
                        var response = error.responseJSON;                
                        Swal.fire({
                            icon:  'error',
                            title: 'SoftInspi',
                            type:  'error',
                            text:  response.message,
                            showConfirmButton: true,
                        });
                    }
                });
            }
        });
    });
    /* ELIMINAR UNIDAD */



    /* CARGAR UPDATE */
    $(document).on('click', '#btnEditUnidad', function () {
        let id_articulo = $(this).data('id_update');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/obtenerArticulo/' + id_articulo,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function (res) {
                // Desglosar los datos recibidos
                let id_articulo = res.articulo.id;
                let nombre = res.articulo.nombre;
                let id_categoria = res.articulo.id_categoria;
                let id_unidad = res.articulo.id_unidad;

                let categorias = res.categorias;
                let unidades = res.unidades;

                $('#contModalUpdateCategoria').text('');
                let html = `
                    <div class="modal fade" id="updateCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Artículo</h5>
                                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <input type="hidden" id="id_articulo" name="id_articulo" class="form-control" value="${id_articulo}">
                                        <div class="col-md-12">
                                            <label for="nameArticuloU" class="form-label fs-6">Nombre del artículo</label>
                                            <input type="text" id="nameArticuloU" name="nameArticuloU" class="form-control" value="${nombre}">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="categoriaArtiU" class="form-label fs-6">Seleccione la Categoría</label>
                                            <select id="categoriaArtiU" name="categoriaArtiU" class="form-control select2Core" required>
                                                <option value="0">Seleccione Opción</option>
                                                ${categorias.map(categoria => `
                                                    <option value="${categoria.id}" ${categoria.id == id_categoria ? 'selected' : ''}>
                                                        ${categoria.nombre}
                                                    </option>
                                                `).join('')}
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="unidadaArticuloU" class="form-label fs-6">Seleccione la Unidad de medida</label>
                                            <select id="unidadaArticuloU" name="unidadaArticuloU" class="form-control select2Core" required>
                                                <option value="0">Seleccione Opción</option>
                                                ${unidades.map(unidad => `
                                                    <option value="${unidad.id}" ${unidad.id == id_unidad ? 'selected' : ''}>
                                                        ${unidad.abreviatura}
                                                    </option>
                                                `).join('')}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnCategoriaUpdate">Guardar</button>
                                    <button type="button" class="btn btn-secondary" id="btnCerrarModalCat" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#contModalUpdateCategoria').append(html);

                // Inicializa Select2 después de insertar el modal en el DOM
                $('#categoriaArtiU, #unidadaArticuloU').select2({
                    width: '100%', // Ocupa el 100% del ancho del contenedor
                    dropdownParent: $('#updateCategoria') // Asocia el dropdown al modal
                });

                // Abre el modal una vez que se ha creado
                $('#updateCategoria').modal('show');
            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:  response.message,
                    showConfirmButton: true,
                });
            }
        });
    });
    /* CARGAR UPDATE */




    /* CERRAR EL MODAL DE MANERA MANUAL */
    $(document).on('click', '#btnCerrarModalCat, #btnCerrarModalCat2', function() {
        $('#updateCategoria').modal('hide');
    });
    /* CERRAR EL MODAL DE MANERA MANUAL */



    /* GUARDAR UPDATE */
    $(document).on('click', '#btnCategoriaUpdate', function(){

        let id_articulo    = $('#id_articulo').val();
        let nameArticulo   = $('#nameArticuloU').val();
        //let precioArticulo = $('#precioArticuloU').val();
        let id_categoria   = $('#categoriaArtiU').val();
        let id_unidad      = $('#unidadaArticuloU').val();

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
                type: 'PUT',
                url: '/inventario/actualizarArticulo/' + id_articulo, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'nombre':       nameArticulo,
                    //'precio':       precioArticulo,
                    'id_categoria': id_categoria,
                    'id_unidad':    id_unidad,

                },
                success: function(response) {

                    $('#updateCategoria').modal('hide');
                    table.ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        type:  'success',
                        text: response.message,
                    });

                },
                error: function(error) {
                    var response = error.responseJSON;                
                    Swal.fire({
                        icon:  'error',
                        title: 'SoftInspi',
                        type:  'error',
                        text:  response.message,
                        showConfirmButton: true,
                    });
                }
            });

        }

    });
    /* GUARDAR UPDATE */

});