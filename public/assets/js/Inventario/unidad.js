
$( function () {

    var table = $('#tblIUnidadIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/unidad', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'abreviatura', name: 'abreviatura' },
            { data: 'estado', name: 'estado' },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, row) {
                    // Aquí formateamos la fecha como necesitemos
                    return moment(data).format('YYYY-MM-DD HH:mm:ss');
                }
            },
            {
                data: null,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnEditUnidad" data-id_update="${full.id}" data-nombre="${full.nombre}" title="Editar Unidad de Medida" data-title="Editar Unidad de Medida">
                                <i class="font-22 fadeIn animated bi bi-pen" ></i>
                            </a>
                            <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Unidad de Medida" data-title="Eliminar Unidad de Medida">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                        </div>
                    `;
                }
            },
        ],
        order: [[3, 'desc']],
        language: {
            // Configuración de idioma
        },
    });

    // Filtros por cada columna
    $('#tblIUnidadIndex thead input').on('keyup change', function () {
        let colIndex = $(this).parent().index(); // Obtén el índice de la columna
        table.column(colIndex).search(this.value).draw();
    });


    //var table = $('#tblIUnidadIndex').DataTable();


    $(document).on('click', '#btnUnidad', function(){
        
        var nameUnidad    = document.getElementById("nameUnidad").value;
        var abreviaUnidad = document.getElementById("abreviaUnidad").value;

        if(nameUnidad === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un nombre',
                showConfirmButton: true,
            });

        }else if(abreviaUnidad === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una abreviatura',
                showConfirmButton: true,
            });

        }else{

            $.ajax({

                type: 'POST',
                //url: '{{ route("encuesta.saveEncuesta") }}',
                url: '/inventario/saveUnidad',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'nameUnidad':    nameUnidad,
                    'abreviaUnidad': abreviaUnidad,
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
                                    document.getElementById('btnCerrarModal').click(); //cerrar modal
                                    $('#nameUnidad').val('');
                                    $('#abreviaUnidad').val('');
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



    /* ELIMINAR UNIDAD */
    $(document).on('click', '#btnDeleteSeg', function(){
        
        let id_unidad = $(this).data('id_delete');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere eliminar esta unidad de medida.',
            showConfirmButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/inventario/deleteUnidad',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id_unidad': id_unidad,
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
    /* ELIMINAR UNIDAD */



    /* CARGAR UPDATE */
    $(document).on('click', '#btnEditUnidad', function(){
        
        let id_unidad = $(this).data('id_update');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/obtenerUnidad/' + id_unidad,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_unidad    = res.id;
                let nombre      = res.nombre;
                let abreviatura = res.abreviatura;
                let estado      = res.estado;
                let created_at  = res.created_at;
                let updated_at  = res.updated_at;

                $('#contModalUpdateCategoria').text('');
                //var uniqueModalId = 'updateCategoria_' + new Date().getTime(); // Genera un ID único basado en la marca de tiempo
                $('#contModalUpdateCategoria').append(`
                    <div class="modal fade" id="updateCategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Crear Categoría</h5>
                                    <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close" id="btnCerrarModalCat2">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Aquí se mostrarán los datos traidos desde el controlador -->
                                    <div>
                                        <input type="hidden" id="id_unidad" name="id_unidad" class="form-control" required="" autofocus="" value="${id_unidad}">
                                        <div class="col-md-12">
                                            <label for="nameUnidadU" class="form-label fs-6">Nombre de la categoría</label>
                                            <input type="text" id="nameUnidadU" name="nameUnidadU" class="form-control" required="" autofocus="" value="${nombre}">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="abreviaUnidadU" class="form-label fs-6">Nombre de la abreviatura</label>
                                            <input type="text" id="abreviaUnidadU" name="abreviaUnidadU" class="form-control" required="" autofocus="" value="${abreviatura}">
                                            <div class="valid-feedback">Looks good!</div>
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
                `);
                
                // Abre el modal una vez que se ha creado
                $(`#updateCategoria`).modal('show');

            },
            error: function(error) {
                console.error('Error al obtener los datos de la categoría:', error);
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

        let id_unidad    = $('#id_unidad').val();
        let nombre      = $('#nameUnidadU').val();
        let abreviatura = $('#abreviaUnidadU').val();

        if(nombre === ''){

            Swal.fire({
                icon:  'warning',
                title: 'SoftInspi',
                type:  'warning',
                text:   'Debe de agregar un nombre',
                showConfirmButton: true,
            });

        }else if(abreviatura === ''){

            Swal.fire({
                icon:  'warning',
                title: 'SoftInspi',
                type:  'warning',
                text:   'Debe de agregar una abreviatura',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'PUT',
                url: '/inventario/actualizarUnidad/' + id_unidad, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'nombre':      nombre,
                    'abreviatura': abreviatura,
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
                    console.error('Error al actualizar la categoría:', error);
                }
            });

        }

    });
    /* GUARDAR UPDATE */

});