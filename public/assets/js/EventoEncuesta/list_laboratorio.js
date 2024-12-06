
$( function () {

    var table = $('#tblLaboratorioEnc').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/encuestas/listarLaboratorio', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'c_nombre', name: 'c_nombre' },
            { data: 'fecha', name: 'fecha' },
            { data: 'estado', name: 'estado'},
            // Otras columnas aquí
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =
                    '<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">'
                    + '<a id="btnEditLaboratorio" data-id="'+full.id+'" title="Editar Laboratorio" class="show-tooltip">'
                    + '<i class="font-22 bi bi-pencil-square" ></i>'
                    + '</a>'
                    + '<a id="btnDeleteLab" data-id="'+full.id+'" title="Eliminar Laboratorio" class="red show-tooltip">'
                    + '<i class="font-22 bi bi-trash3" style="color:indianred"></i>'
                    + '</a>'

                    + '</div>';

                return array;

                }
            },
        ],
        order: [
            [3, 'desc'] // La columna 3 (índice 3) es la columna 'fecha', y 'desc' indica orden descendente
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


    //var table = $('#tblLaboratorio').DataTable();


    /* ELIMINAR LABORATORIO */
    $(document).on('click', '#btnDeleteLab', function(){

        Swal.fire({
            title: 'SoftInspi',
            text: 'Seguro que quieres eliminar este laboratorio?.',
            icon: 'warning',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((resultado) => {
            if (resultado.value) {

                var id_laboratorio = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/encuestas/eliminarLaboratorio/'+id_laboratorio,//PONER URL ELIMINAR
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    cache: false,
                    success: function(res){

                        if(res.data){

                            table.ajax.reload();

                            Swal.fire({
                                title: 'SoftInspi',
                                text: res.message,
                                icon: 'success',
                                type: 'success',
                                confirmButtonText: 'Aceptar',
                                timer: 3500
                            });

                        }else{

                            Swal.fire({
                                title: 'SoftInspi',
                                text: res.message,
                                icon: 'error',
                                type: 'error',
                                confirmButtonText: 'Aceptar',
                                timer: 3500
                            });

                        }

                    }

                });
            }
        });

    });
    /* ELIMINAR LABORATORIO */


    /* EDITAR LABORATORIO */
    $(document).on('click', '#btnEditLaboratorio', function(){

        window.location.href = '/encuestas/editLaboratorio/'+ $(this).data('id');

    });
    /* EDITAR LABORATORIO */



});
