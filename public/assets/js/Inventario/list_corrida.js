/*
$(document).ready(function() {
    $('#addReport').on('shown.bs.modal', function () {
        $('.js-example-basic-single').select2();
    });
});
*/


$( function () {

    $('#tblIActaIndex').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/inventario/list_corrida', // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'tecnica',  name: 'tecnica' },
            { data: 'servicio', name: 'servicio' },
            { data: 'equipos',  name: 'equipos' },
            { data: 'estado',   name: 'estado'},
            { data: 'fecha',    name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array = `
                    <div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">

                        <!--
                        <a id="btnEditUnidad" data-id_update="${full.id}" data-nombre="${full.nombre}" title="Editar Documento de Seguimiento" class="show-tooltip"  data-title="Editar Registro Documento">
                            <i class="font-22 fadeIn animated bx bx-edit" ></i>
                        </a>
                        -->

                        <a id="btnPDFCorrida" data-id_corrida="${full.id}" title="PDF Corrida" class="text-secondary show-tooltip" data-title="PDF Corrida">
                            <i class="font-22 bi bi-filetype-pdf"></i>
                        </a>

                        <a id="" data-id_corrida="${full.id}" title="PDF Corrida" class="text-secondary show-tooltip" href="/inventario/pdf_corrida?id_corrida=${full.id}" data-title="PDF Corrida">
                            <i class="font-22 bi bi-filetype-pdf"></i>
                        </a>

                        <!--
                        <a id="btnPDFMono" data-id_corrida="${full.id}" title="PDF Monoclonal" class="text-secondary show-tooltip" data-title="PDF Monoclonal">
                            <i class="font-22 bi bi-circle-fill"></i>
                        </a>
                        -->

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


    var table = $('#tblIActaIndex').DataTable();


    /* GENERAR REPORTE */
    $(document).on('click', '#btnGenerarReport', function(){

        var revisadoSelect = $('#revisado').val();
        var aprovadoSelect = $('#aprovado').val();
        var realizoSelect  = $('#realizo').val();
        var id_corrida     = $('#id_corrida').val();
        var id_laboratorio = $('#id_laboratorio').val();
        

        if(revisadoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Revisó',
                showConfirmButton: true,
            });

        }else if(aprovadoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Aprobó',
                showConfirmButton: true,
            });

        }else if(realizoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Generó',
                showConfirmButton: true,
            });

        }else{



            $.ajax({
                type: 'GET',
                url: '/inventario/reportHexa?id_revisado=' + revisadoSelect +
                     '&id_autoriza=' + aprovadoSelect +
                     '&id_reporta=' + realizoSelect +
                     '&id_laboratorio=' + id_laboratorio +
                     '&id_corrida=' + id_corrida,
                success: function(response, status, xhr) {
                    
                    window.open(response.pdf_url, '_blank');
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
    /* GENERAR REPORTE */



    /* GENERAR REPORTE */
    $(document).on('click', '#btnGenerarReportMono', function(){

        var fInicioMono = $('#fInicioMono').val();
        var fFinMono    = $('#fFinMono').val();

        var revisadoSelect = $('#revisadoMono').val();
        var aprovadoSelect = $('#aprovadoMono').val();
        var realizoSelect  = $('#realizoMono').val();
        var id_corrida     = $('#id_corridaMono').val();
        var id_laboratorio = $('#id_laboratorio').val();
        

        if(revisadoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Revisó',
                showConfirmButton: true,
            });

        }else if(aprovadoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Aprobó',
                showConfirmButton: true,
            });

        }else if(realizoSelect === '0'){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar el usuario que Generó',
                showConfirmButton: true,
            });

        }else if(fInicioMono === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha de inicio',
                showConfirmButton: true,
            });

        }else if(fFinMono === ''){

            Swal.fire({
                icon: 'warning',
                type:  'warning',
                title: 'SoftInspi',
                text: 'Debe de seleccionar la fecha fin',
                showConfirmButton: true,
            });

        }else{

            $.ajax({
                type: 'GET',
                url: '/inventario/reportMono?fInicioMono=' + fInicioMono +
                        '&fFinMono=' + fFinMono +
                        '&id_laboratorio=' + id_laboratorio +
                        '&id_corrida=' + id_corrida +
                        '&id_revisado=' + revisadoSelect +
                        '&id_autoriza=' + aprovadoSelect +
                        '&id_reporta=' + realizoSelect,
                success: function(response, status, xhr) {
                    window.open(response.pdf_url, '_blank');
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
    /* GENERAR REPORTE */




    /* CARGAR CORRIDA */
    /*
    $(document).on('click', '#btnPDFCorrida', function(){

        let id_corrida = $(this).data('id_corrida');

        $('#id_corrida').val(id_corrida);
        document.getElementById('btnModalReport').click();

        //$('#addReport').on('shown.bs.modal', function () {
            //$('.js-example-basic-single').select2();
        //});

        //$('#revisado').select2();

    });
    */
    /* CARGAR CORRIDA */


    $(document).on('click', '#btnPDFCorrida', function(){
        let id_corrida = $(this).data('id_corrida');
        $('#id_corrida').val(id_corrida);

        // Mostrar el modal
        //$('#btnModalReport').click();
        document.getElementById('btnModalReport').click();

        // Inicializar Select2 después de que el modal esté completamente abierto
        
            $('.single-select').select2({
                width: 'resolve', // Ajustar el ancho al contenedor
                dropdownParent: $('#addReport .modal-body')
            });
        

    });





    /* CARGAR CORRIDA */
    $(document).on('click', '#btnPDFMono', function(){

        let id_corrida = $(this).data('id_corrida');

        $('#id_corridaMono').val(id_corrida);
        document.getElementById('btnModalReportMono').click();
        
    });
    /* CARGAR CORRIDA */



});

/*
$(document).ready(function() {
    $('.single-select').select2({
        dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
});
*/ 