
$( function () {

    $('#destino').select2({
        //dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
        dropdownParent: $('#modalTransferir .modal-body')
    });

    $('#tblIActaIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/list_ajuste',
        },
        columns: [
            { data: 'numero',       name: 'numero' },
            { data: 'nombre',      name: 'nombre' },
            {   data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                    var array = "";
                    switch (full.tipo) {
                        case 'I':
                            array = '<center><span class="badge bg-primary text-center">Donación</span></center>';
                            break;

                        case 'C':
                            array = '<center><span class="badge bg-success text-center">Compra Local</span></center>';
                            break;

                        case 'T':
                            array = '<center><span class="badge bg-secondary text-center"> Traspaso </span></center>';
                            break;

                        case 'E':
                            array = '<center><span class="badge bg-info text-center">Egreso</span></center>';
                            break;
                        case 'A':
                            array = '<center><span class="badge bg-warning text-center">Ajuste</span></center>';
                            break;
                    }

                    return array;
                },
            },

            { data: 'origen',      name: 'origen' },
            { 
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                    var array = "";
                    switch (full.estado) {
                        case 'A':
                            array = '<center><span class="badge bg-primary text-center">Por Aprovar</span></center>';
                            break;

                        case 'V':
                            array = '<center><span class="badge bg-success text-center">Aprovado</span></center>';
                            break;

                        case 'R':
                            array = '<center><span class="badge bg-secondary text-center"> Rechazado </span></center>';
                            break;

                    }

                    return array;
                }

            },
            { data: 'fecha',       name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {

                    var array = `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                    `;

                    //Condición para mostrar íconos dependiendo si es ingreso o egreso
                    if(full.tipo =='E' || full.tipo =='T'){
                        array += `
                        <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                            <a id="btnPDFout" data-id_update="${full.id}" data-nombre="${full.nombre}" title="PDF OUT" class="text-secondary show-tooltip" href="/inventario/generate-pdf_out?id_acta=${full.id}" data-title="PDF OUT">
                                <i class="font-22 bi bi-filetype-pdf"></i>
                            </a>

                            <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Seguimiento" class="red show-tooltip" href="javascript:void(0);"  data-title="Eliminar Registro Documento">
                            <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                            </a>

                            <a id="btnReport1" data-id_report1="${full.id}" data-toggle="modal" data-target="#addReport1" title="Reporte 1" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 1">
                            <i class="font-22 bi bi-1-square-fill"></i>
                            </a>

                            <a id="btnReport2" data-id_report2="${full.id}" data-toggle="modal" data-target="#addReport2" title="Reporte 2" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 2">
                            <i class="font-22 bi bi-2-square-fill"></i>
                            </a>

                            <a id="btnReport3" data-id_report3="${full.id}" data-toggle="modal" data-target="#addReport3" title="Reporte 3" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 3">
                            <i class="font-22 bi bi-3-square-fill"></i>
                            </a>

                        </div>
                        `;

                    }else if(full.tipo =='C' || full.tipo =='I'){

                        if (full.transferible == 'false') {
                            array += `
                            <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                                
                                <a id="btnTransferir" data-id_acta="${full.id}" title="Transferir Movimiento" class="text-secondary show-tooltip" data-title="Transferir Movimiento" data-toggle="modal" data-target="#modalTransferir">
                                    <i class="font-22 bi bi-arrow-right-square"></i>
                                </a>
                        
                                <a id="btnVisualizarMovimiento" data-id_acta="${full.id}" title="Ver Movimiento" class="show-tooltip" data-title="Ver Movimiento">
                                     <i class="font-22 bi bi-eye"></i>
                                 </a>
                        
                                <a id="btnPDFin" data-id_update="${full.id}" data-nombre="${full.nombre}" title="PDF IN" class="text-secondary show-tooltip" href="/inventario/generate-pdf_in?id_acta=${full.id}" data-title="PDF IN">
                                    <i class="font-22 bi bi-filetype-pdf"></i>
                                </a>
                        
                                <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Seguimiento" class="red show-tooltip" href="javascript:void(0);"  data-title="Eliminar Registro Documento">
                                <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                                </a>
                        
                                <a id="btnReport1" data-id_report1="${full.id}" data-toggle="modal" data-target="#addReport1" title="Reporte 1" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 1">
                                <i class="font-22 bi bi-1-square-fill"></i>
                                </a>
                        
                                <a id="btnReport2" data-id_report2="${full.id}" data-toggle="modal" data-target="#addReport2" title="Reporte 2" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 2">
                                <i class="font-22 bi bi-2-square-fill"></i>
                                </a>
                        
                                <a id="btnReport3" data-id_report3="${full.id}" data-toggle="modal" data-target="#addReport3" title="Reporte 3" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 3">
                                <i class="font-22 bi bi-3-square-fill"></i>
                                </a>
                        
                            </div>
                            `;
                        } else {
                            array += `
                            <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
                        
                                <a id="btnVisualizarMovimiento" data-id_acta="${full.id}" title="Ver Movimiento" class="show-tooltip" data-title="Ver Movimiento">
                                     <i class="font-22 bi bi-eye"></i>
                                 </a>
                        
                                <a id="btnPDFin" data-id_update="${full.id}" data-nombre="${full.nombre}" title="PDF IN" class="text-secondary show-tooltip" href="/inventario/generate-pdf_in?id_acta=${full.id}" data-title="PDF IN">
                                    <i class="font-22 bi bi-filetype-pdf"></i>
                                </a>
                        
                                <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Seguimiento" class="red show-tooltip" href="javascript:void(0);"  data-title="Eliminar Registro Documento">
                                <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                                </a>
                        
                                <a id="btnReport1" data-id_report1="${full.id}" data-toggle="modal" data-target="#addReport1" title="Reporte 1" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 1">
                                <i class="font-22 bi bi-1-square-fill"></i>
                                </a>
                        
                                <a id="btnReport2" data-id_report2="${full.id}" data-toggle="modal" data-target="#addReport2" title="Reporte 2" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 2">
                                <i class="font-22 bi bi-2-square-fill"></i>
                                </a>
                        
                                <a id="btnReport3" data-id_report3="${full.id}" data-toggle="modal" data-target="#addReport3" title="Reporte 3" class="red show-tooltip" href="javascript:void(0);"  data-title="Reporte 3">
                                <i class="font-22 bi bi-3-square-fill"></i>
                                </a>
                        
                            </div>
                            `;
                        }

                    }else{

                        if(full.estado == 'A'){

                            array += `
                            <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
    
                                <a id="btnAprobarAjuste" data-id_acta="${full.id}" data-toggle="modal" data-target="#validaAjuste" title="Validar Ajuste" class="text-primary show-tooltip"  data-title="Validar Ajuste">
                                    <i class="font-22 bi bi-bookmark-check"></i>
                                </a>
    
                                <a id="btnPDFin" data-id_update="${full.id}" data-nombre="${full.nombre}" title="PDF AJUSTE" class="text-secondary show-tooltip" href="/inventario/generate-pdf_ajuste?id_acta=${full.id}" data-title="PDF Ajuste">
                                    <i class="font-22 bi bi-filetype-pdf"></i>
                                </a>
    
                                <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Ajuste" class="red show-tooltip" data-title="Eliminar Ajuste">
                                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                                </a>
    
                            </div>
                            `;

                        }else{

                            array += `
                            <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">
    
                                <a id="btnPDFin" data-id_update="${full.id}" data-nombre="${full.nombre}" title="PDF AJUSTE" class="text-secondary show-tooltip" href="/inventario/generate-pdf_ajuste?id_acta=${full.id}" data-title="PDF Ajuste">
                                    <i class="font-22 bi bi-filetype-pdf"></i>
                                </a>
    
                                <a id="btnDeleteSeg" data-id_delete="${full.id}" title="Eliminar Ajuste" class="red show-tooltip" data-title="Eliminar Ajuste">
                                    <i class="font-22 fadeIn animated bx bx-trash" style="color:indianred"></i>
                                </a>
    
                            </div>
                            `;

                        }

                    }
                    array += `</div>`;
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

//BOTÓN PARA EDITAR, REMOVIDO POR EL MOMENTO
    // <a id="btnEditMovimiento" data-id_movimiento="${full.id}" data-nombre="${full.nombre}" title="Editar Movimiento" class="show-tooltip" data-title="Editar Movimiento">
    //     <i type= "hidden" class="font-22 fadeIn animated bx bx-edit" ></i>
    // </a>

    var table = $('#tblIActaIndex').DataTable();

    /*
    document.getElementById('precioArticulo').addEventListener('input', function () {
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
    */



    $(document).on('click', '#btnGenerarReport3', function(){
        
        var entidadReport3   = document.getElementById("entidadReport3").value;
        var ejecutoraReport3 = document.getElementById("ejecutoraReport3").value;
        var desconcenReport3 = document.getElementById("desconcenReport3").value;
        var tipoPReport3     = document.getElementById("tipoPReport3").value;
        var presenReport3    = document.getElementById("presenReport3").value;
        var obserReport3     = document.getElementById("obserReport3").value;
        var inactReport3     = document.getElementById("inactReport3").value;
        var mayorReport3     = document.getElementById("mayorReport3").value;
        var subCuent1Report3 = document.getElementById("subCuent1Report3").value;
        var subCuent2Report3 = document.getElementById("subCuent2Report3").value;
        var estadoReport3    = document.getElementById("estadoReport3").value;


        //obtenemos el data-id_report1 
        var btnReport3 = document.getElementById('btnReport3');
        var idReport3 = '';

        if (btnReport3) {
            idReport3 = btnReport3.getAttribute('data-id_report3');
        }
        

        //var isValid = /^\d+$/.test(precioArticulo);

        if(entidadReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la entidad',
                showConfirmButton: true,
            });

        }else if(ejecutoraReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la unidad ejecutora',
                showConfirmButton: true,
            });

        }else if(desconcenReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la unidad desconcentrada',
                showConfirmButton: true,
            });

        }else if(tipoPReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el tipo de producto',
                showConfirmButton: true,
            });

        }else if(presenReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de presentación',
                showConfirmButton: true,
            });

        }else if(obserReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar la observación',
                showConfirmButton: true,
            });

        }else if(inactReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar si el producto esta inactivo(S/N)',
                showConfirmButton: true,
            });

        }else if(mayorReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de mayor',
                showConfirmButton: true,
            });

        }else if(subCuent1Report3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de subcuenta 1',
                showConfirmButton: true,
            });

        }else if(subCuent2Report3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de subcuenta 2',
                showConfirmButton: true,
            });

        }else if(estadoReport3 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el estado del producto',
                showConfirmButton: true,
            });

        }
        else{

            $.ajax({
                type: 'POST',
                url: '/inventario/report3',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'entidadReport3'   :  entidadReport3,
                    'ejecutoraReport3' :  ejecutoraReport3,
                    'desconcenReport3' :  desconcenReport3,
                    'tipoPReport3'     :  tipoPReport3,
                    'presenReport3'    :  presenReport3,
                    'obserReport3'     :  obserReport3,
                    'inactReport3'     :  inactReport3,
                    'mayorReport3'     :  mayorReport3,
                    'subCuent1Report3' :  subCuent1Report3,
                    'subCuent2Report3' :  subCuent2Report3,
                    'estadoReport3'    :  estadoReport3,

                    'idReport3'        : idReport3,

                },
                success: function(result, status, xhr) {

                    var archivoUrl = '/download/'+result.url; //se creo una ruta para que se puedan realizar las descargas de xlsx
                    var link = document.createElement('a');
                    link.href = archivoUrl;
                    link.download = 'reporte3.xlsx'; 

                    document.body.appendChild(link);
                    link.click();
    
                    // Eliminar el enlace temporal
                    document.body.removeChild(link);
                    
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




    $(document).on('click', '#btnGenerarReport2', function(){
        
        var entidadReport2   = document.getElementById("entidadReport2").value;
        var ejecutoraReport2 = document.getElementById("ejecutoraReport2").value;
        var desconcenReport2 = document.getElementById("desconcenReport2").value;
        var actaNReport2     = document.getElementById("actaNReport2").value;
        var codReport2       = document.getElementById("codReport2").value;

        //obtenemos el data-id_report1 
        var btnReport2 = document.getElementById('btnReport2');
        var idReport2 = '';

        if (btnReport2) {
            idReport2 = btnReport2.getAttribute('data-id_report2');
        }
        

        //var isValid = /^\d+$/.test(precioArticulo);

        if(entidadReport2 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la entidad',
                showConfirmButton: true,
            });

        }else if(ejecutoraReport2 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la unidad ejecutora',
                showConfirmButton: true,
            });

        }else if(desconcenReport2 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la unidad desconcentrada',
                showConfirmButton: true,
            });

        }else if(actaNReport2 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número del acta',
                showConfirmButton: true,
            });

        }else if(codReport2 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número del código para hacer un secuencial',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'POST',
                url: '/inventario/report2',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'entidadReport2':   entidadReport2,  
                    'ejecutoraReport2': ejecutoraReport2,  
                    'desconcenReport2': desconcenReport2, 
                    'actaNReport2':     actaNReport2,     
                    'codReport2':       codReport2,        

                    'idReport2': idReport2,

                },
                success: function(result, status, xhr) {

                    var archivoUrl = '/download/'+result.url; //se creo una ruta para que se puedan realizar las descargas de xlsx
                    var link = document.createElement('a');
                    link.href = archivoUrl;
                    link.download = 'reporte2.xlsx'; 

                    document.body.appendChild(link);
                    link.click();
    
                    // Eliminar el enlace temporal
                    document.body.removeChild(link);
                    
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




    $(document).on('click', '#btnGenerarReport1', function(){
        
        var entidad         = document.getElementById('entidadReport1').value;
        var unidadEjecutora = document.getElementById('unidadEjeReport1').value;
        var unidadDesconcentrada = document.getElementById('unidadDesReport1').value;
        var tipoInventario  = document.getElementById('tipoInvReport1').value;
        var tipoProducto    = document.getElementById('tipoProReport1').value;
        var presentacion    = document.getElementById('presentaReport1').value;
        var serieInicial    = document.getElementById('serieIniReport1').value;
        var serieFinal      = document.getElementById('serieFinReport1').value;
        var observaciones   = document.getElementById('observaReport1').value;
        var inactivo        = document.getElementById('inactivoReport1').value;
        var mayor           = document.getElementById('mayorReport1').value;
        var subcuenta1      = document.getElementById('subcuenta1Report1').value;
        var codigoAnterior  = document.getElementById('codAnteReport1').value;
        var estadoProducto  = document.getElementById('estadoReport1').value;

        //obtenemos el data-id_report1 
        var btnReport1 = document.getElementById('btnReport1');
        var idReport1 = '';

        if (btnReport1) {
            idReport1 = btnReport1.getAttribute('data-id_report1');
        }
        

        //var isValid = /^\d+$/.test(precioArticulo);

        if(entidad === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la entidad',
                showConfirmButton: true,
            });

        }else if(unidadEjecutora === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de la Unidad Ejecutora',
                showConfirmButton: true,
            });

        }else if(unidadDesconcentrada === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar la Unidad Desconcentrada',
                showConfirmButton: true,
            });

        }else if(tipoInventario === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el tipo Inventario',
                showConfirmButton: true,
            });

        }else if(tipoProducto === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el tipo Producto',
                showConfirmButton: true,
            });

        }else if(presentacion === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de presentación',
                showConfirmButton: true,
            });

        }else if(observaciones === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar una observación',
                showConfirmButton: true,
            });

        }else if(inactivo === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de definir si esta Inactivo(S/N)',
                showConfirmButton: true,
            });

        }else if(mayor === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de definir Mayor',
                showConfirmButton: true,
            });

        }else if(subcuenta1 === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar el número de Subcuenta 1',
                showConfirmButton: true,
            });

        }else if(estadoProducto === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de definir si esta Inactivo(S/N)',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'POST',
                url: '/inventario/report1',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                    'entidad':         entidad,
                    'unidadEjecutora': unidadEjecutora,
                    'unidadDesconcentrada': unidadDesconcentrada,
                    'tipoInventario':  tipoInventario,
                    'tipoProducto':    tipoProducto,
                    'presentacion':    presentacion,
                    'serieInicial':    serieInicial,
                    'serieFinal':      serieFinal,
                    'observaciones':   observaciones,
                    'inactivo':        inactivo,
                    'mayor':           mayor,
                    'subcuenta1':      subcuenta1,
                    'codigoAnterior':  codigoAnterior,
                    'estadoProducto':  estadoProducto,

                    'idReport1': idReport1,

                },
                success: function(result, status, xhr) {

                    var archivoUrl = '/download/'+result.url; //se creo una ruta para que se puedan realizar las descargas de xlsx
                    //var archivoUrl = result.url;
                    var link = document.createElement('a');
                    link.href = archivoUrl;
                    link.download = 'nombre-del-archivo.xlsx'; 

                    document.body.appendChild(link);
                    link.click();
    
                    // Eliminar el enlace temporal
                    document.body.removeChild(link);
                    
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
    $(document).on('click', '#btnVisualizarMovimiento', function(){
        
        let id_acta = $(this).data('id_acta');

        window.location.href = '/inventario/editarMovimiento/'+id_acta;
            
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
        let precioArticulo = $('#precioArticuloU').val();
        let id_categoria   = $('#categoriaArtiU').val();
        let id_unidad      = $('#unidadaArticuloU').val();

        var isValid = /^\d+$/.test(precioArticulo);

        if(nameArticulo === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un nombre',
                showConfirmButton: true,
            });

        }else if(precioArticulo === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de ingresar un precio',
                showConfirmButton: true,
            });

        }else if(!isValid){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'El precio ingresado no es número',
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
                    'precio':       precioArticulo,
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
                    console.error('Error al actualizar la categoría:', error);
                }
            });

        }

    });
    /* GUARDAR UPDATE */



    /* TRAE LOS DATOS PARA TRANSFERIR EN EL MODAL */
    $(document).on('click', '#btnTransferir', function(){

        let id_acta = $(this).data('id_acta');



        $.ajax({
            url: '/inventario/get_tranferir', 
            type: 'GET',
            data: { id_acta: id_acta }, 
            success: function(data) {

                let acta = data.datosActa;
                let movimientos = data.datosMovimiento;

                
                $('#numero').text(acta.numero);
                $('#ruc').text(acta.nombre);
                $('#proveedor').text(acta.proveedor);
                $('#fecha').text(acta.fecha);
                $('#factura').text(acta.factura);
                $('#descripcion').text(acta.descripcion);

                $('#id_acta').val(id_acta);

                let tbody = document.querySelector("#tablaTransferir tbody");                
                tbody.innerHTML = '';
                movimientos.forEach(function(movimiento) {
                    let fila = `<tr>
                                    <td>${movimiento.unidad}</td>
                                    <td>${movimiento.articulo}</td>
                                    <td>${movimiento.presentacion}</td>
                                    <td>${movimiento.lote}</td>
                                    <td>${movimiento.costo_unitario}</td>
                                    <td>${movimiento.costo_total}</td>
                                </tr>`;
                    
                    // Añadir la fila al tbody
                    tbody.innerHTML += fila;
                });
            
            },
            error: function(xhr, status, error) {
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
    /* TRAE LOS DATOS PARA TRANSFERIR EN EL MODAL */





    /* TRANSFERIR ACTA A LABORATORIO */
    $(document).on('click', '#btnTranferirInventario', function(){
        
        var id_acta        = $('#id_acta').val();
        var id_laboratorio = $('#destino').val();

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere transferir los artículos de este movimiento?.',
            showConfirmButton: true,
            confirmButtonText: 'Sí, aplicar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value == true) {

                if(id_laboratorio == '0'){
                    Swal.fire({
                        icon: 'warning',
                        type:  'warning',
                        title: 'SoftInspi',
                        text: 'Debe de seleccionar un laboratorio.',
                        showConfirmButton: true,
                    });
                }else{

                    $.ajax({

                        type: 'POST',
                        //url: '{{ route("encuesta.saveEncuesta") }}',
                        url: '/inventario/sendTransferencia',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'id_acta':        id_acta,
                            'id_laboratorio': id_laboratorio,
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

            }
        });
    });
    /* TRANSFERIR ACTA A LABORATORIO */



    /* MODAL AJUSTE */
    $(document).on('click', '#btnAprobarAjuste', function(){
    
        let id_acta = $(this).data('id_acta');

        $('#id_acta_ajuste').val(id_acta);
            
    });
    /* MODAL AJUSTE */



    /* VALIDAR AJUSTE */
    $(document).on('click', '#btnSaveValidar', function(){

        let id_acta = $('#id_acta_ajuste').val();
        let valida = $('#selectAprobar').val();

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere validar este ajuste de inventario?.',
            showConfirmButton: true,
            confirmButtonText: 'Sí, aplicar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value == true) {

                if(valida == '0'){
                    Swal.fire({
                        icon: 'warning',
                        type:  'warning',
                        title: 'SoftInspi',
                        text: 'Debe de seleccionar SI o NO',
                        showConfirmButton: true,
                    });
                }else{

                    $.ajax({
                        url: '/inventario/validaAjuste', 
                        type: 'GET',
                        data: { 
                            id_acta: id_acta,
                            valida: valida,
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
                                            document.getElementById('btnSaveValida').click();
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
                        error: function(xhr, status, error) {
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

            }

        });

    });
    /* VALIDAR AJUSTE */



});