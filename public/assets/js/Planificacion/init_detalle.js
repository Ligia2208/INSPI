$( function () {

    populateYearSelect(2020);

    $('.js-example-basic-single').select2({
        width: '100%',
    });

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionIndex').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'coordinacion',        name: 'coordinacion' },
            { data: 'POA',                 name: 'POA' },
            { data: 'obj_operativo',       name: 'obj_operativo' },
            { data: 'act_operativa',       name: 'act_operativa' },
            { data: 'sub_actividad',       name: 'sub_actividad' },
            { data: 'fecha',               name: 'fecha' },
            //{ data: 'estado',              name: 'estado' },

            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                if(full.estado == 'A' ){
                    array = '<div class="center"><span class="badge badge-primary text-bg-primary">Ingresado</span><div>';
                }else if(full.estado == 'O'){
                    array = '<div class="center"><span class="badge badge-success text-bg-success">Aprobado</span>';
                }else if(full.estado == 'R'){
                    array = '<div class="center"><span class="badge badge-warning text-bg-warning">Rechazado</span>';
                }else if(full.estado == 'C'){
                    array = '<div class="center"><span class="badge badge-info text-bg-info">Corregido</span>';
                }else{
                    array = '<div class="center"><span class="badge badge-warning text-bg-warning">Indefinido</span>';
                }

                return array;
                }
            },

            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";

                if(full.estado == 'O' ){
                    array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <!--
                            <a id="btnEliminarPOA" data-id_borrar="${full.id}" title="Eliminar registro" class="red show-tooltip" data-title="Eliminar registro">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                            -->
                        </div>
                    `;
                }else if(full.estado == 'R'){
                    array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                            <a id="btnComentarioRef" data-id_comentario="${full.id_reforma}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <!--
                            <a id="btnEliminarPOA" data-id_borrar="${full.id}" title="Eliminar registro" class="red show-tooltip" data-title="Eliminar registro">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                            -->
                        </div>
                    `;
                } else{
                    array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>

                            <a id="btnEditarPlan" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Revisión" class="show-tooltip" data-title="Revisión">
                                <i class="font-22 fadeIn animated bi bi-pen" ></i>
                            </a>
                            <!--
                            <a id="btnEliminarPOA" data-id_borrar="${full.id}" title="Eliminar registro" class="red show-tooltip" data-title="Eliminar registro">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                            -->
                        </div>
                    `;

                }


                return array;

                }
            },
        ],
        order: [
            [5, 'desc']
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


    var table = $('#tblPlanificacionIndex').DataTable();

});

//------------------------------------------------------------------------------------------------

//CÓDIGO PARA REDIRIGIR AL FORMULARIO PARA ACEPTAR/RECHAZAR POA
$(function(){
    /* CARGAR REGISTRO */
    $(document).on('click', '#btnEditarPlan', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/editarEstadoPlanificacion/'+ id_planificacion;

    });
    /* CARGAR REGISTRO */
})


//------------------------------------------------------------------------------------------------

//CÓDIGO PARA BOTÓN DE BORRAR
$(function(){
    $(document).on('click', '#btnEliminarPOA', function(){
        //alert('funciona');

        let id_POA = $(this).data('id_borrar');

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
                    url: '/planificacion/deletePoa',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id_POA,
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

    var table = $('#tblPlanificacionIndex').DataTable();


})

//------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------


//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionDetalle').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion/detalle', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'Area',                name: 'Area' },
            { data: 'POA',                 name: 'POA' },
            { data: 'obj_operativo',       name: 'obj_operativo' },
            { data: 'act_operativa',       name: 'act_operativa' },
            { data: 'sub_actividad',       name: 'sub_actividad' },

            { data: 'enero',               name: 'enero' },
            { data: 'febrero',             name: 'febrero' },
            { data: 'marzo',               name: 'marzo' },
            { data: 'abril',               name: 'abril' },
            { data: 'mayo',                name: 'mayo' },
            { data: 'junio',               name: 'junio' },
            { data: 'julio',               name: 'julio' },
            { data: 'agosto',              name: 'agosto' },
            { data: 'septiembre',          name: 'septiembre' },
            { data: 'octubre',             name: 'octubre' },
            { data: 'noviembre',           name: 'noviembre' },
            { data: 'diciembre',           name: 'diciembre' },
            // { data: 'descripcion_item',    name: 'descripcion_item' },
            // { data: 'item_presup',         name: 'item_presup' },
            // { data: 'monto',               name: 'monto' },
            // { data: 'monto_item',          name: 'monto_item' },
            // { data: 'justificacion',       name: 'justificacion' },
            // { data: 'id',                  name: 'id' },



            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =`
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnEditarPlan" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Revisión" class="show-tooltip" href="javascript:void(0);" data-title="Revisión">
                                <i class="font-22 fadeIn animated bx bx-edit" ></i>
                            </a>
                        </div>
                    `;

                return array;

                }
            },
        ],
        order: [
            [6, 'desc']
        ],

        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Totalizar cada columna de suma
            var sumColumns = [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
            for (var i = 0; i < sumColumns.length; i++) {
                var columnIndex = sumColumns[i];
                var total = api
                    .column(columnIndex, { page: 'current' })
                    .data()
                    .reduce(function (acc, val) {
                        return parseFloat(acc) + parseFloat(val);
                    }, 0);

                // Mostrar el total en el footer de la columna
                $(api.column(columnIndex).footer()).html(total);
            }
        },

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


    var table = $('#tblPlanificacionDetalle').DataTable();

});

//CÓDIGO PARA MOSTRAR COMENTARIOS
$(function(){

    $(document).on('click','#btnComentarios', function(){

        let id_Poa = $(this).data('id_comentario');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/planificacion/obtenerComentarios/' + id_Poa,
            data: {
                _token: "{{ csrf_token() }}",

            },
            cache: false,
            success: function(res){
                console.log(res);

                let id_poa         = res.poa.id;

                let comentarios    = res.comentarios;
                let created_at     = res.comentarios.created_at;


                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Comentarios del registro ${id_poa}</h5>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                `;

                if (comentarios.length > 0) {
                    // Agregamos cada comentario a la lista dentro del modal
                    comentarios.forEach(function(comentario) {
                        html += `
                        <li class="list-group-item">
                            <strong>Usuario:</strong> ${comentario.id_usuario} <br>
                            <strong>Comentario:</strong> ${comentario.comentario} <br>
                            <strong>Fecha de creación:</strong> ${comentario.fecha} <br>
                            <strong>Estado de la planificación:</strong> ${comentario.estado_planificacion} <br>

                        </li>
                        `;
                    });
                } else {
                    // Mostrar mensaje de que no existen comentarios
                    html += `
                        <li class="list-group-item">
                            No existen comentarios para este registro.
                        </li>
                    `;
                }

                html += `
                                </ul>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="btnCerrarModalCat" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;



                $('#contModalComentarios').append(html);
                // Abre el modal una vez que se ha creado
                $(`#modalComentarios`).modal('show');

            },
            error: function(error) {
                console.error('Error al obtener comentarios:', error);
            }

        });

    })


         /* CERRAR EL MODAL DE MANERA MANUAL */
        $(document).on('click', '#btnCerrarModalCat, #btnCerrarModalCat2', function() {
        $('#modalComentarios').modal('hide');
        });
        /* CERRAR EL MODAL DE MANERA MANUAL */


})




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



//         select.appendChild(option);
//     }
// }


function actualizarTabla() {

    let anio = $('#yearSelect').val();

    if(anio !== '0'){

        $.ajax({
            url: '/planificacion/detalle',
            type: 'GET',
            data: { anio: anio },
            success: function(data) {
                // Limpiar la tabla
                $('#tblPlanificacionDetalle').DataTable().clear();
                // Agregar los nuevos datos a la tabla
                $('#tblPlanificacionDetalle').DataTable().rows.add(data.data).draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }

}

$(document).on('click', '#btnGeneratePDF', function(){

    let id_poa = $(this).data('id_poa');

    $('#id_poa').val(id_poa);

    document.getElementById('btnModalReportPOA').click();

});

$(document).ready(function() {
    // Manejar clic en el botón para generar PDF
    $(document).on('click', '#btnGeneratePDF', function() {
        document.getElementById('btnModalReportPOA').click();
    });

    // Cerrar el modal y limpiar los campos
    $(document).on('click', '#btnCerrarModalPOA', function() {
        $('#addReportDetalle').modal('hide');

        // Limpiar los campos del formulario
        $('#elabora').val('');
        $('#revisa').val('');
        $('#aprueba').val('');
        $('#cargo_elabora').val('');
        $('#cargo_revisa').val('');
        $('#cargo_aprueba').val('');
    });

    // Generar el reporte PDF
    $(document).on('click', '#btnGenerarReportPOA', function() {
        var elaboraSelect = $('#elabora').val();
        var revisaSelect = $('#revisa').val();
        var apruebaSelect = $('#aprueba').val();
        var cargo_elabora = $('#cargo_elabora').val();
        var cargo_revisa = $('#cargo_revisa').val();
        var cargo_aprueba = $('#cargo_aprueba').val();
        var yearSelected = $('#yearSelect').val();

        if (elaboraSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (revisaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (apruebaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_elabora == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el cargo del usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_revisa == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el cargo del usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_aprueba == '') {
            Swal.fire({
                icon: 'warning',
                title: 'SoftInspi',
                text: 'Debe ingresar el cargo del usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else {
            $.ajax({
                type: 'GET',
                url: '/planificacion/reportDetalle',
                data: {
                    elabora: elaboraSelect,
                    revisa: revisaSelect,
                    aprueba: apruebaSelect,
                    cargo_elabora: cargo_elabora,
                    cargo_revisa: cargo_revisa,
                    cargo_aprueba: cargo_aprueba,
                    year: yearSelected
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_anual_' + yearSelected + '.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    a.remove();
                    $('#addReportDetalle').modal('hide');
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'SoftInspi',
                        text: 'Error al generar el PDF',
                        showConfirmButton: true,
                    });
                }
            });
        }
    });
});
