$( function () {

    //CÓDIGO PARA BUSCAR USUARIO EN EL MODAL DE GENERAR PDF
    $('.js-example-basic-single').select2({
        width: '100%',
    });


    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX

    $('#tblPlanificacionVistaUser').DataTable({ //id de la tabla en el visual (index)

        processing: true,
        serverSide: true,
        lengthMenu: [50, 100],

        ajax: {
            url: '/planificacion/vistaUser', // La URL que devuelve los datos en JSON
            data: function (d) {
                d.estado = $('#filterEstado').val();
                d.item = $('#filterItem').val();
            }
        },
        columns: [
            { data: 'coordinacion',        name: 'coordinacion' },
            { data: 'POA',                 name: 'POA' },
            { data: 'obj_operativo',       name: 'obj_operativo' },
            { data: 'act_operativa',       name: 'act_operativa' },
            { data: 'sub_actividad',       name: 'sub_actividad' },
            { data: 'item',                name: 'item' },
            { data: 'monto',               name: 'monto' },
            { data: 'proceso',             name: 'proceso' },
            { data: 'fecha',               name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {

                    var array = "";
                    if(full.estado == 'A' ){
                        array = '<div class="center"><span class="badge badge-primary text-bg-primary">Registrado</span><div>';
                    }else if(full.estado == 'O'){
                        array = '<div class="center"><span class="badge badge-success text-bg-success">Aprobado</span>';
                    }else if(full.estado == 'R'){
                        array = '<div class="center"><span class="badge badge-warning text-bg-warning">Rechazado</span>';
                    }else if(full.estado == 'C'){
                        array = '<div class="center"><span class="badge badge-info text-bg-info">Corregido</span>';
                    }else if(full.estado == 'S'){
                        array = '<div class="center"><span class="badge badge-info text-bg-info">Solicitado</span>';
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
                    if(full.estado_solicitud == 'pendiente' ){
                        array = '<div class="text-center"><span class="badge text-bg-primary">Pendiente<i class="bi bi-exclamation-octagon parpadeo ms-1"></i></span><div>';
                    }else if(full.estado_solicitud == 'aprobado'){
                        array = '<div class="text-center"><span class="badge text-bg-success">Aprobado</span>';
                    }else if(full.estado_solicitud == 'rechazado'){
                        array = '<div class="text-center"><span class="badge text-bg-warning">Rechazado</span>';
                    }else if(full.estado_solicitud == null){
                        array = '<div class="text-center"><span class="badge text-bg-info">No solicitada</span>';
                    }

                return array;
                }

            },


            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {

                    let btnCancelarPoa = '';
                    if( full.estado == 'O'){

                        btnCancelarPoa = `
                            <a id="btnEliminarCerti" data-id_borrar="${full.id}" title="Eliminar certificación" class="red show-tooltip ml-1" data-title="Eliminar certificación">
                                <i class="font-22 fadeIn animated bi bi-file-earmark-x text-danger"></i>
                            </a>
                        `;
                        
                    }

                    let btnEditar = '';
                    if(!full.estado_pro){
                        btnEditar = `
                            <a id="btnEditarPOA" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Editar registro" class="show-tooltip mr-1" data-title="Editar registro">
                                <i class="font-22 fadeIn animated bi bi-pen"></i>
                            </a>

                            <a id="btnEliminarPOA" data-id_borrar="${full.id}" title="Eliminar registro" class="red show-tooltip" data-title="Eliminar registro">
                                <i class="font-22 fadeIn animated bi bi-trash" style="color:indianred"></i>
                            </a>
                        `;
                    }

                    if(!full.descargado){

                        if(full.id_area == 17 || full.id_area == 18){

                            btnDescarga = `
                            <a id="btnPDF_POAZonal" data-id_POA="${full.id}" title="PDF POA" class="text-secondary show-tooltip" data-title="PDF POA">
                                <i class="font-22 bi bi-filetype-pdf"></i>
                            </a>
                            `;

                        }else{

                            btnDescarga = `
                            <a id="btnPDF_POA" data-id_POA="${full.id}" title="PDF POA" class="text-secondary show-tooltip" data-title="PDF POA">
                                <i class="font-22 bi bi-filetype-pdf"></i>
                            </a>
                            `;

                        }

                    }else{
                        btnDescarga = `
                            <a id="btnPDF_descargado" data-id_POA="${full.id}" title="PDF Descargado" class="show-tooltip" data-title="PDF Descargado">
                                <i class="font-22 bi bi-check2-circle text-success"></i>
                            </a>
                            `;
                        
                        
                    }

                    var array = `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                    `;
        
                    // Condición para mostrar el ícono si estado_solicitud es 'pendiente'
                    if (full.estado_solicitud == 'pendiente') {
                        array += `
                            <a id="btnPrestar" data-id_solicitud="${full.id_solicitud}" title="Prestar Actividad" class="text-secondary show-tooltip mr-1" data-title="Prestar Actividad" data-toggle="modal" data-target="#apruebaSolicitud">
                                <i class="bi bi-check-square font-22"></i>
                            </a>
                        `;
                    }
            
                    // Condición si full.estado es 'O'
                    if (full.estado == 'O') {
                        array += `
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnVisualizaPOA" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Visualizar" class="show-tooltip mr-1" data-title="Visualizar">
                                <i class="font-22 fadeIn animated bi bi-eye" style="color:black"></i>
                            </a>
                            ${btnDescarga}
                            ${btnCancelarPoa}
                        `;
                    }else if(full.estado == 'S'){

                        array += `
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>
                            <a id="btnVisualizaPOA" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Editar registro" class="show-tooltip mr-1" data-title="Editar registro">
                                <i class="font-22 fadeIn animated bi bi-eye" style="color:black"></i>
                            </a>
                        `;

                        if(full.id_area == 17 || full.id_area == 18 ){

                            array += `
                                <a id="btnEditarPlan" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Revisión" class="show-tooltip" data-title="Revisión">
                                    <i class="font-22 fadeIn animated bi bi-pen" ></i>
                                </a>
                            `;

                        }

                    }else if(full.estado == 'R'){

                        array += `
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>

                            <a id="btnEditarPOARechazo" data-id_editar="${full.id}" data-nombre="${full.nombre}" title="Editar registro" class="show-tooltip mr-1" data-title="Editar registro">
                                <i class="font-22 fadeIn animated bi bi-pen"></i>
                            </a>

                        `;


                    }else {
                        array += `
                            <a id="btnComentarios" data-id_comentario="${full.id}" title="Comentarios" class="red show-tooltip mr-1" data-title="Comentarios">
                                <i class="font-22 fadeIn animated bi bi-journal-text" style="color:green"></i>
                            </a>

                            <a id="btnSolicitarPOA" data-id_actividad="${full.id}" data-nombre="${full.nombre}" title="Solicitar POA" class="show-tooltip mr-1" data-title="Solicitar POA">
                                <i class="font-22 fadeIn animated bi bi-file-earmark-text  text-warning"></i>
                            </a>

                            ${btnEditar}

                        `;
                    }
            
                    array += `</div>`;
                    return array;

                }
            },
        ],
        order: [
            [8, 'desc']
        ],

        footerCallback: function (row, data, start, end, display) {
            let api = this.api();
    
            // Calcula el total de la columna "Monto"
            let total = api
                .column(6, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);
    
            // Actualiza el tfoot con el total
            $(api.column(6).footer()).html('Total: $' + total.toFixed(2));
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


    var table = $('#tblPlanificacionVistaUser').DataTable();

    /*
    $('#filterItem').on('change', function() {
        var itemId = $(this).val(); // Obtener el valor seleccionado del filtro Item
        $('#tblPlanificacionVistaUser').DataTable().ajax.url('/planificacion/vistaUser?item=' + itemId).load();
    });
    */

    // **Actualizar la tabla cuando cambien los filtros**
    $('#filterEstado, #filterItem').on('change', function () {
        table.ajax.reload();
    });


    /* VALIDAR CERTIFICACION */
    $(document).on('click', '#btnEditarPlan', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/edit_estado_planificacion_zonal/'+ id_planificacion;

    });
    /* VALIDAR CERTIFICACION */


    /* CARGAR REGISTRO PARA EDITAR */
    $(document).on('click', '#btnEditarPOA', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/editarPlanificacion/'+ id_planificacion;

    });
    /* CARGAR REGISTRO PARA EDITAR */



    /* CARGAR REGISTRO PARA EDITAR EL RECHAZO */
    $(document).on('click', '#btnEditarPOARechazo', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/editarPlanificacionRechazo/'+ id_planificacion;

    });
    /* CARGAR REGISTRO PARA EDITAR EL RECHAZO */



    /* REDIRECCIONA A LA VISUALIZACION DE LA ACTIVIDAD */
    $(document).on('click', '#btnVisualizaPOA', function(){
        let id_planificacion = $(this).data('id_editar');

        window.location.href = '/planificacion/visualizarPlanificacion/'+ id_planificacion;

    });
    /* REDIRECCIONA A LA VISUALIZACION DE LA ACTIVIDAD */


    //validar solicitud
    $(document).on('click', '#btnPrestar', function(){
        let id_solicitud = $(this).data('id_solicitud');

        
        $.ajax({
            type: 'GET',
            url: '/planificacion/get_actividades_id',
            data:{
                id_solicitud: id_solicitud,
            },
            success: function(response, status, xhr) {

                $('#id_solicitud').val(id_solicitud);

                let actividades = response.valoresSoli;
                let solicitante = response.solicitud.solicitante;

                // Limpiar la tabla antes de agregar nuevas filas
                $("#tblSolicitud tbody").empty();
        
                // Iterar sobre cada actividad y generar una fila
                actividades.forEach(actividad => {
                    let nuevaFila = `
                        <tr>
                            <td>${solicitante}</td> 
                            <td>${actividad.sub_actividad}</td>
                            <td>${actividad.item}</td>
                            <td>${actividad.tipo}</td>
                            <td>${actividad.disponible} </td>
                            <td><input type="number" disabled class="form-control disabled-green" value="${actividad.tipo === 'AUMENTA' ? actividad.total : 0}"></td>
                            <td><input type="number" disabled class="form-control disabled-red" value="${actividad.tipo === 'DISMINUYE' ? actividad.total : 0}"></td>
                        </tr>
                    `;
        
                    // Agregar la fila a la tabla
                    $("#tblSolicitud tbody").append(nuevaFila);
                });

            },
            error: function(error) {
                var response = error.responseJSON;                
                Swal.fire({
                    icon:  'error',
                    title: 'SoftInspi',
                    type:  'error',
                    text:   response.message,
                    showConfirmButton: true,
                });
            }
        });
        

    });

    $(document).on('click', '#btnGuardarSolicitud', function(){

        let estado       = $('#estado').val();
        let id_solicitud = $('#id_solicitud').val();

        if(estado == '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de Aprobar o Rechazar la solicitud para continuar.',
                showConfirmButton: true,
            });

        }else{

            let mensaje;
            if(estado == 'aprobado'){
                mensaje = 'La solicitud será aprobada, desea continuar?'
            }else{
                mensaje = 'La solicitud será rechazada, desea continuar?'
            }
    
            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: mensaje,
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value == true) {
    
                    $.ajax({
    
                        type: 'POST',
                        url: '/planificacion/aproSolicitud',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'id_solicitud': id_solicitud,
                            'estado': estado,
                        },
                        success: function(response) {
    
                            if(response.data){

                                table.ajax.reload(); //actualiza la tabla
                                document.getElementById('btnSolicitud').click();         

                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });

                            }else{

                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });
                                
                            }
                        },
                        error: function(error) {
                            var response = error.responseJSON;                
                            Swal.fire({
                                icon:  'error',
                                title: 'SoftInspi',
                                type:  'error',
                                text:   response.message,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });

        }

    });


     /* ==================== SOLICITAR POA ==================== */

    $(document).on('click','#btnSolicitarPOA', function(){

        let id_Poa = $(this).data('id_actividad');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/planificacion/obtenerpoa/' + id_Poa,
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){
                //console.log(res);
                let departamento   = res.poa.departamento;
                let id_poa         = res.poa.id;
                let actividad      = res.poa.actividad;
                let subactividad   = res.poa.subactividad;
                let monto          = res.poa.monto;

                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title mr-2" id="exampleModalLabel">Solicitud POA </h4>
                                    <strong>${departamento}</strong>
                                </div>
                                <div class="modal-body">

                                    <input type="hidden" value="${id_poa}" id="solicitud_id">
                                    <h4 class="modal-title">Actividad: </h4>
                                    <span>${actividad}</span>
                                    <h4 class="modal-title mt-4">Sub Actividad: </h4>
                                    <span>${subactividad}</span>

                                    <div class="col-md-12 mt-5">
                                        <label for="justifi" class="form-label fs-6">Justificación área requirente</label>
                                        <textarea id="justifi" name="justifi" class="form-control" required="" autofocus="" rows="4"></textarea>
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>

                                    <div class="col-md-12 row">
                                        <div class="col-md-6 mt-5">
                                            <label for="total_P" class="form-label fs-6 text-green">Monto de la Actividad</label>
                                            <input disabled="" class="form-control disabled-green" type="text" id="total_P" name="total_P[]" value="${monto}">
                                        </div>
                                        <div class="col-md-6 mt-5">
                                            <label for="total_C" class="form-label fs-6 text-red">Monto a Certificar</label>
                                            <input class="form-control disabled-red" type="text" id="total_C" name="total_C[]" value="0.00" onchange="validarInputNumerico(this)">
                                            <div class="valid-feedback">¡Se ve bien!</div>
                                            <div class="invalid-feedback">Ingrese solo números</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btnSolicitarPoa">Solicitar</button>
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

    });
    /* ==================== SOLICITAR POA ==================== */


    /* CERRAR EL MODAL DE MANERA MANUAL */
    $(document).on('click', '#btnCerrarModalCat, #btnCerrarModalCat2', function() {
        $('#modalComentarios').modal('hide');
    });
    /* CERRAR EL MODAL DE MANERA MANUAL */



    $(document).on('click', '#btnSolicitarPoa', function(){

        let solicitud_id = $('#solicitud_id').val();
        let justifi      = $('#justifi').val();
        let disponible   = $('#total_P').val();
        let certificado  = $('#total_C').val();

        var isValid = /^\d+(\.\d+)?$/.test(certificado);

        //para verificar si se excede
        disponible  = parseFloat(disponible);
        certificado = parseFloat(certificado);

        if(justifi == ''){

            Swal.fire({
                icon:  'warning',
                type:  'warning',
                title: 'CoreInspi',
                text:  'Debe de agregar un justificación del área.',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon:  'warning',
                type:  'warning',
                title: 'CoreInspi',
                text:  'El monto a certificar debe de ser un número.',
                showConfirmButton: true,
            });

        }else if(certificado <= 0){

            Swal.fire({
                icon:  'warning',
                type:  'warning',
                title: 'CoreInspi',
                text:  'El monto a certificar no puede ser 0.',
                showConfirmButton: true,
            });

        }else if(certificado > disponible){

            Swal.fire({
                icon:  'warning',
                type:  'warning',
                title: 'CoreInspi',
                text:  'El monto que quiere certificar, excede al monto disponible.',
                showConfirmButton: true,
            });

        }else{

            Swal.fire({
                icon:  'warning',
                type:  'warning',
                title: 'CoreInspi',
                text:  'Seguro que quiere realizar la solicitud de POA',
                showConfirmButton: true,
                showCancelButton: true,
            }).then((result) => {
                if (result.value == true) {
    
                    $.ajax({
    
                        type: 'POST',
                        url: '/planificacion/solicitadPOA',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'solicitud_id': solicitud_id,
                            'justifi'     : justifi,
                            'certificado' : certificado,
                        },
                        success: function(response) {
    
                            if(response.data){

                                document.getElementById('btnCerrarModalCat').click();         
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });

                            }else{

                                Swal.fire({
                                    icon: 'error',
                                    type:  'error',
                                    title: 'SoftInspi',
                                    text: response.message,
                                    showConfirmButton: true,
                                });
                                
                            }
                        },
                        error: function(error) {
                            var response = error.responseJSON;                
                            Swal.fire({
                                icon:  'error',
                                title: 'SoftInspi',
                                type:  'error',
                                text:   response.message,
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });

        }

    });



});

//===============================================================================================




// ---------------------------------------------------------------------------------------------

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

    $(document).on('click', '#btnEliminarCerti', function(){
        //alert('funciona');

        let id_POA = $(this).data('id_borrar');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere anular esta Certificación.',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/planificacion/deleteCertificacion',
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

    var table = $('#tblPlanificacionVistaUser').DataTable();


})

//------------------------------------------------------------------------------------------------




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
                //console.log(res);
                let departamento   = res.poa.departamento;
                let id_poa         = res.poa.id;
                let comentarios    = res.comentarios;
                let created_at     = res.comentarios.created_at;

                $('#contModalComentarios').text('');

                // Construimos el contenido del modal

                let html = `
                    <div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Comentarios del registro: "${departamento}"</h5>
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


});

//===============================================Aquí inicia PDF=======================================================

$(document).on('click', '#btnPDF_POA', function(){

    let id_POA = $(this).data('id_poa');

    $('#id_poa').val(id_POA);

    document.getElementById('btnModalReportPOA').click();

});

//  Para los zonales 
$(document).on('click', '#btnPDF_POAZonal', function(){

    let id_POA = $(this).data('id_poa');

    $('#id_poa2').val(id_POA);

    document.getElementById('btnModalReportPOAZonal').click();

});
//  Para los zonales 



$(document).on('click', '#btnPDF_descargado', function(){

    Swal.fire({
        icon: 'warning',
        type:  'warning',
        title: 'SoftInspi',
        text: 'Esta Certificación POA ya fue descargada!',
        showConfirmButton: true,
    });

});



/* CERRAR EL MODAL Y LIMPIAR LOS CAMPOSL */
$(document).on('click', '#btnCerrarModalPOA', function() {
    $('#addReportPOA').modal('hide');

    // Limpia los campos del formulario
    $('#creado').val('');
    $('#autorizado').val('');
    $('#reporta').val('');
    //$('#areaReq').val('');
    //$('#planificacionYG').val('');
    $('#cargo_creado').val('');
    $('#cargo_autorizado').val('');
    $('#cargo_reporta').val('');
    //$('#cargo_areaReq').val('');
    //$('#cargo_planificacionYG').val('');
});


$(document).on('click', '#btnGenerarReportPOA', function(){

     var creadoSelect          = $('#creado').val();
     var autorizadoSelect      = $('#autorizado').val();
     var reportaSelect         = $('#reporta').val();
     var areaReqSelect         = $('#areaReq').val();
     var planificacionYGSelect = $('#planificacionYG').val();
     var id_poa                = $('#id_poa').val();

     var cargo_creado          = $('#cargo_creado').val();
     var cargo_autorizado      = $('#cargo_autorizado').val();
     var cargo_reporta         = $('#cargo_reporta').val();
     var cargo_areaReq         = $('#cargo_areaReq').val();
     var cargo_planificacionYG = $('#cargo_planificacionYG').val();

     if(creadoSelect == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que elaboró la planificación',
             showConfirmButton: true,
         });

     }else if(autorizadoSelect == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que autorizó la planificación',
             showConfirmButton: true,
         });

     }else if(reportaSelect == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que generó el reporte',
             showConfirmButton: true,
         });

     }else if(areaReqSelect == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que valida la planificación',
             showConfirmButton: true,
         });

     }else if(planificacionYGSelect == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que aprueba la planificación',
             showConfirmButton: true,
         });

     }else if(cargo_creado == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el cargo del usuario que crea la planificación',
             showConfirmButton: true,
         });

     }else if(cargo_autorizado == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el cargo del usuario que autorizó la planificación',
             showConfirmButton: true,
         });

     }else if(cargo_reporta == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el cargo del usuario que revisó la planificación',
             showConfirmButton: true,
         });

     }else if(cargo_areaReq == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el cargo del usuario que  la planificación',
             showConfirmButton: true,
         });

     }else if(cargo_planificacionYG == ''){

         Swal.fire({
             icon: 'warning',
             type:  'warning',
             title: 'SoftInspi',
             text: 'Debe ingresar el usuario que autorizó la planificación',
             showConfirmButton: true,
         });

     }else{
         $.ajax({
             type: 'GET',
             url: '/planificacion/reportHexa?id_creado=' + creadoSelect +
                 '&id_autorizado=' + autorizadoSelect +
                 '&id_reporta=' + reportaSelect +
                 '&id_areaReq=' + areaReqSelect +
                 '&id_planificacionYG=' + planificacionYGSelect +
                 '&id_poa=' + id_poa,
             data:{
                 cargo_creado: cargo_creado,
                 cargo_autorizado: cargo_autorizado,
                 cargo_reporta: cargo_reporta,
                 cargo_areaReq: cargo_areaReq,
                 cargo_planificacionYG: cargo_planificacionYG,
             },
             xhrFields: {
                 responseType: 'blob'
             },
             success: function(response, status, xhr) {
                 var blob = new Blob([response], { type: 'application/pdf' });
                 var url = window.URL.createObjectURL(blob);
                 var a = document.createElement('a');
                 a.href = url;
                 a.download = 'Certificacion_POA.pdf';
                 document.body.appendChild(a);
                 a.click();
                 window.URL.revokeObjectURL(url);
                 a.remove();

                 //si todo esta bien, entonces actualizamos el estado de descarga
                 descarga(id_poa);

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



 $(document).on('click', '#btnGenerarReportPOA2', function(){

    var creadoSelect          = $('#creado2').val();
    var autorizadoSelect      = $('#autorizado2').val();
    var reportaSelect         = $('#reporta2').val();
    var areaReqSelect         = $('#areaReq2').val();
    var planificacionYGSelect = $('#planificacionYG2').val();
    var id_poa                = $('#id_poa2').val();

    var cargo_creado          = $('#cargo_creado2').val();
    var cargo_autorizado      = $('#cargo_autorizado2').val();
    var cargo_reporta         = $('#cargo_reporta2').val();
    var cargo_areaReq         = $('#cargo_areaReq2').val();
    var cargo_planificacionYG = $('#cargo_planificacionYG2').val();

    if(creadoSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que elaboró la planificación',
            showConfirmButton: true,
        });

    }else if(autorizadoSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else if(reportaSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que generó el reporte',
            showConfirmButton: true,
        });

    }else if(areaReqSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que valida la planificación',
            showConfirmButton: true,
        });

    }else if(planificacionYGSelect == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que aprueba la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_creado == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el cargo del usuario que crea la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_autorizado == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el cargo del usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_reporta == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el cargo del usuario que revisó la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_areaReq == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el cargo del usuario que  la planificación',
            showConfirmButton: true,
        });

    }else if(cargo_planificacionYG == ''){

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Debe ingresar el usuario que autorizó la planificación',
            showConfirmButton: true,
        });

    }else{
        $.ajax({
            type: 'GET',
            url: '/planificacion/reportHexa?id_creado=' + creadoSelect +
                '&id_autorizado=' + autorizadoSelect +
                '&id_reporta=' + reportaSelect +
                '&id_areaReq=' + areaReqSelect +
                '&id_planificacionYG=' + planificacionYGSelect +
                '&id_poa=' + id_poa,
            data:{
                cargo_creado: cargo_creado,
                cargo_autorizado: cargo_autorizado,
                cargo_reporta: cargo_reporta,
                cargo_areaReq: cargo_areaReq,
                cargo_planificacionYG: cargo_planificacionYG,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response, status, xhr) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'Certificacion_POA.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();

                //si todo esta bien, entonces actualizamos el estado de descarga
                descarga(id_poa);

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




 function ejecutar(){

    alert('funciona');

    window.location.href = 'planificacion/ejecutarPla';

 }




 function descarga(id_poa){

    $.ajax({
        type: 'GET',
        url: '/planificacion/actualizaDescarga?id_poa=' + id_poa,
        success: function(response, status, xhr) {

            if(response.success){
                //si todo esta bien, entonces actualizamos el estado de descarga
                var table = $('#tblPlanificacionVistaUser').DataTable();
                table.ajax.reload();
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



 // Función para validar input numérico
function validarInputNumerico(input) {
    var inputValue = input.value;
    //var isValid = /^\d+$/.test(inputValue);
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