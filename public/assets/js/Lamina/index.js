$(function(){
    //populateYearSelect(2020);
    $('.basic-single').select2({
        width: '100%',
    });

    //populateYearSelect(2023);


    $(document).on('click', '#btnGenerarPDF', function () {
        console.log('🟢 Click detectado');
    
        $.ajax({
            type: 'GET',
            url: '/laminas/reporte',
            xhrFields: { responseType: 'blob' },
            success: function (response) {
                console.log('🟢 PDF recibido. Intentando abrir en nueva pestaña...');
    
                const blob = new Blob([response], { type: 'application/pdf' });
                const url = window.URL.createObjectURL(blob);
    
                // Intento 1: abrir en nueva pestaña
                const opened = window.open(url, '_blank');
                if (!opened) {
                    console.warn('⚠️ El navegador bloqueó la nueva pestaña');
                    Swal.fire({
                        icon: 'info',
                        title: 'Atención',
                        text: 'El navegador bloqueó la apertura del PDF. Permite pop-ups o descárgalo manualmente.',
                    });
                }
            },
            error: function (xhr) {
                console.error('❌ Error AJAX:', xhr.status, xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo generar el PDF',
                });
            }
        });
    });
    
    
    
})



//==========================================VISTA DETALLE USER================================================

//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionIndex').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        autoWidth: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/laminas', // La URL que devuelve los datos en JSON
        },
        columnDefs: [
            //{ width: '400px', targets: 2 } // Ajusta el índice según la posición de "Obj. Operativo"
        ],
        
        columns: [
            
            { data: 'unicodigo',     name: 'unicodigo' },
            { data: 'instituto',     name: 'instituto' },
            { data: 'recepta',       name: 'recepta' },
            { data: 'analita',       name: 'analita' },
            { data: 'total_laminas', name: 'total_laminas' },
            { data: 'mes_recepcion', name: 'mes_recepcion' },
            { data: 'fecha_recep',   name: 'fecha_recep' },
            {
                data: null,
                render: function (data, type, full, meta) {
                    return `
                        <div class="action-buttons">
                            <a id="btnPDF_ingreso" class="ml-1" data-id_editar="${full.id}" href="javascript:void(0);" title="PDF Ingreso de Láminas" data-title="PDF Ingreso de Láminas">
                                <i class="bi bi-file-pdf"></i>
                            </a>

                            <a id="btnAdd_laminas" class="ml-1" data-id_editar="${full.id}" href="/laminas/agregar_laminas/${full.id}" title="Desglose de Láminas" data-title="Desglose de Láminas">
                                <i class="bi bi-list-ul"></i>
                            </a>

                            <a id="btnAdd_control" class="ml-1" data-id_editar="${full.id}" href="/laminas/control_calidad/${full.id}" title="Control de Láminas" data-title="Control de Láminas">
                                <i class="bi bi-clipboard-check"></i>
                            </a>

                        </div>`;
                }
            },
        ],
        order: [
            [6, 'desc']
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



});

//==========================================FIN VISTA DETALLE USER================================================


