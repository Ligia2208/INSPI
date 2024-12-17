$(function(){
    //populateYearSelect(2020);
    $('.js-example-basic-single').select2({
        //dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        height: '38px',
        placeholder: 'Selecciona una opción',
        allowClear: true,
    });
})


//==========================================VISTA DETALLE USER================================================

//CÓDIGO PARA MOSTRAR POA EN EL CALENDARIO
$( function () {

    //CÓDIGO PARA MOSTRAR LA TABLA EN EL INDEX
    $('#tblPlanificacionDetalleUser').DataTable({ //id de la tabla en el visual (index)
        processing: false,
        serverSide: false,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/planificacion/detalleUser', // La URL que devuelve los datos en JSON
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

    });


    var table = $('#tblPlanificacionDetalleUser').DataTable();

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