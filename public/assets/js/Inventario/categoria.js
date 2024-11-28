
$( function () {

    $('#tblICategoriaIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/categoria', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre', name: 'nombre'},
            { data: 'estado', name: 'estado'},
            //{ data: 'fecha',  name: 'fecha' },
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
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array = `
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                        <a id="btnEditCategoria" data-id_update="${full.id}" data-nombre="${full.nombre}" title="Editar Categoría" data-title="Editar Categoría">
                            <i class="font-22 fadeIn animated bi bi-pen" ></i>
                        </a>
                        <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Categoría" data-title="Eliminar Categoría">
                        <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                        </a>
                    </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [2, 'desc']
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


    var table = $('#tblICategoriaIndex').DataTable();


    $(document).on('click', '#btnCategoria', function(){
        
        var nameCategoria = document.getElementById("nameCategoria").value;

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
                    if(response.data){
    
                        Swal.fire({
                            icon: 'success',
                            type: 'success',
                            title: 'SoftInspi',
                            text: response.message,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value == true) {
                                table.ajax.reload(); //actualiza la tabla 
                                document.getElementById('btnCerrarModal').click(); //cerrar modal
                                $('#nameCategoria').val('');
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
                                $('#nameCategoria').val('');
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


    /* ELIMINAR CATEGORÍA */
    $(document).on('click', '#btnDeleteSeg', function(){
        
        let id_categoria = $(this).data('id_delete');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere eliminar esta categoría.',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/inventario/deleteCategoria',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id_categoria': id_categoria,
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
    /* ELIMINAR CATEGORÍA */

    /* CARGAR UPDATE (Esto esta mal) */
    $(document).on('click', '#btnEditCategoria', function(){
        
        let id_categoria = $(this).data('id_update');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/inventario/obtenerCategoria/' + id_categoria,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_categ   = res.id;
                let nombre     = res.nombre;
                let estado     = res.estado;
                let created_at = res.created_at;
                let updated_at = res.updated_at;

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
                                        <input type="hidden" id="id_categ" name="id_categ" class="form-control" required="" autofocus="" value="${id_categ}">
                                        <div class="col-md-12">
                                            <label for="nameCategoriaU" class="form-label fs-6">Nombre de la categoría</label>
                                            <input type="text" id="nameCategoriaU" name="nameCategoriaU" class="form-control" required="" autofocus="" value="${nombre}">
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

        let id_categ = $('#id_categ').val();
        let nombre   = $('#nameCategoriaU').val();

        if(nombre === ''){

            Swal.fire({
                icon:  'warning',
                title: 'SoftInspi',
                type:  'warning',
                text:   'Debe de agregar un nombre',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'PUT',
                url: '/inventario/actualizarCategoria/' + id_categ, 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'nombre': nombre,
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