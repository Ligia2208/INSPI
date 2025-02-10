$(function(){
    //populateYearSelect(2020);
    $('.basic-single').select2({
        width: '100%',
    });

    populateYearSelect(2023);




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
        var revisaSelect  = $('#revisa').val();
        var apruebaSelect = $('#aprueba').val();
        var cargo_elabora = $('#cargo_elabora').val();
        var cargo_revisa  = $('#cargo_revisa').val();
        var cargo_aprueba = $('#cargo_aprueba').val();

        var filterAnio         = $('#filterAnio').val();
        var filterItem         = $('#filterItem').val();
        var filterSubActividad = $('#filterSubActividad').val();

        var id_direccion  = $('#id_direccion').val();

        if (elaboraSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (revisaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (apruebaSelect == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_elabora == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que elaboró el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_revisa == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que revisó el reporte',
                showConfirmButton: true,
            });
        } else if (cargo_aprueba == '') {
            Swal.fire({
                icon: 'warning',
                title: 'CoreInspi',
                text: 'Debe ingresar el cargo del usuario que aprobó el reporte',
                showConfirmButton: true,
            });
        } else {
            $.ajax({
                type: 'GET',
                url: '/planificacion/reportDetalleUser',
                data: {
                    elabora:       elaboraSelect,
                    revisa:        revisaSelect,
                    aprueba:       apruebaSelect,
                    cargo_elabora: cargo_elabora,
                    cargo_revisa:  cargo_revisa,
                    cargo_aprueba: cargo_aprueba,
                    id_direccion:  id_direccion,

                    filterAnio:    filterAnio,        
                    filterItem:    filterItem,        
                    filterSubActividad, filterSubActividad,
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var blob = new Blob([response], { type: 'application/pdf' });
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'reporte_anual_' + filterAnio + '.pdf';
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
                        title: 'CoreInspi',
                        text: 'Error al generar el PDF',
                        showConfirmButton: true,
                    });
                }
            });
        }
    });




})


//==========================================VISTA DETALLE USER================================================

//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionDetalleUser').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        autoWidth: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion/detalleUser', // La URL que devuelve los datos en JSON
            data: function (d) {
                d.anio = $('#filterAnio').val();
                d.item = $('#filterItem').val();
                d.sub_actividad = $('#filterSubActividad').val();
            }
        },
        columnDefs: [
            { width: '400px', targets: 2 } // Ajusta el índice según la posición de "Obj. Operativo"
        ],
        
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
            [0, 'desc']
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
        createdRow: function (row, data, dataIndex) {
            // Aquí aplicas el colspan a la celda deseada (por ejemplo, la celda de la columna "enero")
            /*
            if (data.POA) {
                // Buscas la celda correspondiente y le aplicas colspan
                $(row).find('td:eq(5)').attr('colspan', 3);  // Aplica colspan a la columna 5 (enero) para que ocupe 3 columnas
            }
            */
        },
        

    });


    $('.filter').on('change', function () {
        $('#tblPlanificacionDetalleUser').DataTable().ajax.reload();
    });

    var table = $('#tblPlanificacionDetalleUser').DataTable();




    // Generar el reporte EXCEL
    $(document).on('click', '#btnGenerateExcel', function() {

        var id_direccion       = $('#id_direccion').val();
        var filterAnio         = $('#filterAnio').val();
        var filterItem         = $('#filterItem').val();
        var filterSubActividad = $('#filterSubActividad').val();

        $.ajax({
            type: 'GET',
            url: '/planificacion/reportDetalleExcelUser',
            data: {
                filterAnio         : filterAnio,
                filterItem         : filterItem,
                filterSubActividad : filterSubActividad,
                id_direccion       : id_direccion,
            },
            xhrFields: {
                responseType: 'blob'  // Definir que esperamos una respuesta de tipo blob (archivo)
            },
            success: function(response, status, xhr) {
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }); // Tipo para Excel
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'reporte_detalle_' + filterAnio + '.xlsx'; // Extensión .xlsx para el archivo Excel
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                a.remove();
                $('#addReportDetalle').modal('hide');
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'CoreInspi',
                    text: 'Error al generar el archivo Excel.',
                    showConfirmButton: true,
                });
            }
        });

    });



});

//==========================================FIN VISTA DETALLE USER================================================

function actualizarTabla() {

    let anio = $('#yearSelect').val();

    if(anio !== '0'){

        $.ajax({
            url: '/planificacion/detalleUser',
            type: 'GET',
            data: { anio: anio },
            success: function(data) {
                // Limpiar la tabla
                $('#tblPlanificacionDetalleUser').DataTable().clear();
                // Agregar los nuevos datos a la tabla
                $('#tblPlanificacionDetalleUser').DataTable().rows.add(data.data).draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }

}


function populateYearSelect(startYear) {
    var currentYear = new Date().getFullYear();
    var select = document.getElementById('filterAnio');

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
