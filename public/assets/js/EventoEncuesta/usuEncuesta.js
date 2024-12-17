


$( function () {

    //alert("Funciona");

    var saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', function () {
        var canvas = document.getElementById('myChart2000');
        canvas.toBlob(function (blob) {
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'chart.png';
            link.click();
        });
    });

    var tipoencu_id = $('#tipoencu_id').val();
    var id_evento   = $('#id_evento').val();

    graficoPrimario(tipoencu_id, id_evento);

    $('#tblGEncuestaUsuario').DataTable({
        processing: true,
        serverSide: true,
        lengthMenu: [8, 15, 25, 50, 100],
        ajax: {
            url: '/encuestas/getEncuestas?tipoencu_id='+tipoencu_id+'&id_evento='+id_evento, // La URL que devuelve los datos en JSON
        },
        columns: [
            { data: 'id',          name: 'id' },
            { data: 'servidor_publico', name: 'servidor_publico' },
            { data: 'nombre',      name: 'nombre'},
            { data: 'usuario',     name: 'usuario' },
            { data: 'fecha',       name: 'fecha' },
            {
                data: null,
                searchable: false ,
                render: function (data, type, full, meta) {
                var array = "";
                array =
                    '<div class="hidden-sm hidden-xs action-buttons d-flex justify-content-center align-items-center">'

                    + '<a id="btnDeleteEncuesta" data-id="'+full.id+'" title="Eliminar Encuesta" class="red show-tooltip">'
                    + '<i class="font-22 bi bi-trash text-danger"></i>'
                    + '</a>'

                    + '<a href="/encuestas/reportNoPresencial?id_encuesta='+full.id+'" data-id="'+full.id+'" type="button" title="Generar PDF" class="red show-tooltip" data-title="Generar PDF" target="_blank" download="reporte_encuesta.pdf" >'
                    + '<i class="font-22 bi bi-filetype-pdf text-warning"></i>'
                    + '</a>'

                    + '</div>';

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


    var table = $('#tblGDocumento').DataTable();

    /* FILTROS PARA BUSCAR SEGUIMIENTO */
    $('#nombreB, #tipoB, #fechaB, #estadoB, #departamentosB').on('change', function() {
        filtrar();
    });

    function filtrar(){
        // Obtener valores de los filtros
        var nombre  = $('#nombreB').val();
        var tipo    = $('#tipoB').val();
        var fechaB  = $('#fechaB').val();
        var estadoB = $('#estadoB').val();
        var departamentosB = $('#departamentosB').val();

        table.ajax.url('/gestion_documental?nombre=' + nombre + '&tipo=' + tipo+ '&fecha=' + fechaB+'&estado=' + estadoB+'&area=' + departamentosB).load();
    }
    /* FILTROS PARA BUSCAR SEGUIMIENTO */


    /* ELIMINAR SEGUIMIENTO */
    $(document).on('click', '#btnDeleteSeg', function(){


        Swal.fire({
            title: 'SoftInspi',
            text: 'Seguro que quieres eliminar este seguimiento?.',
            icon: 'warning',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((resultado) => {
            if (resultado.value) {

                var id_documento = $(this).data('id_documento');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: '/eliminarSeguimiento/'+id_documento,//PONER URL ELIMINAR
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    cache: false,
                    beforeSend: function () {
                        $('body').waitMe({
                            effect: 'roundBounce', //'roundBounce',//'bounce','win8','orbit','ios','win8_linear'
                            text: 'Por favor espere...', //'Please waiting...',
                            bg: 'rgba(255,255,255,0.7)',
                            color: '#A52A2A'
                        });
                    },
                    success: function(res){
                        //console.log(res);
                        Swal.fire({
                            title: 'SoftInspi',
                            text: res.message,
                            icon: 'success',
                            type: 'success',
                            confirmButtonText: 'Aceptar',
                            timer: 3500
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = '/gestion_documental';
                            }
                        });

                    }

                });
            }
        });

    });
    /* ELIMINAR SEGUIMIENTO */



    $(document).on('click', '#btnEditDocumento', function(){

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: 'gestion_documental/edit/'+$(this).data('id_documento'),
            data: {
                _token: "{{ csrf_token() }}",
                'id_documento': $(this).data('id_documento'),
            },
            cache: false,
            beforeSend: function () {
                $('body').waitMe({
                    effect: 'roundBounce', //'roundBounce',//'bounce','win8','orbit','ios','win8_linear'
                    text: 'Por favor espere...', //'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#A52A2A'
                });
            },
            success: function(res){

            var modalCrearCatalogo = bootbox.dialog({
                title: '<span> <i class="font-22 fadeIn animated bx bx-edit text-success"></i> Editar Documento </span>',
                message: res,
                className: "large",
                size: 'xs',
                show: false,

                buttons: {

                    submit:{
                        label: '<span class="lni lni-save"></span> Guardar',
                        className: "submit btnGuardar btn btn-primary btn-shadow font-weight-bold mr-2",
                        callback: function(){
                            var form = modalCrearCatalogo.find("#frmEditDocumento");
                            var datos = $(form).serialize() + '&' + $.param({ 'action': $(form).data('action') });

                            if($(form).valid()){

                                $.post(form[0].action, datos).done(function(request){
                                    modalCrearCatalogo.modal('hide');

                                    var oTable = $('#tblCatalogo').dataTable();
                                    oTable.fnDraw(false);

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'SoftInspi',
                                        type: 'success',
                                        text: 'El documento ha sido editado correctamente.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                  //  $('#datatable-crud').ajax.reload();
                                    table.ajax.reload();


                                })
                            }
                            return false;
                        }
                    },

                    cancel: {
                        label: '<span class="lni lni-close"></span> Cerrar',
                        className: "btn btn-danger btn-shadow font-weight-bold mr-2",
                        callback: function(){
                            modalCrearCatalogo.modal('hide');
                        }//fin callback
                    }//fin cancelar
                },
                onEscape: function () {
                    modalCrearCatalogo.modal("hide");
                },
                backdrop: "static",

            }).on('shown.bs.modal', function (e) {
                $('body').waitMe('hide');
                modalCrearCatalogo.attr("id", "modal-wizard-datatables");
                modalCrearCatalogo.css({ "overflow-y": "scroll" });

            });//fin modal
            // modalEditCatalogo.find("div.modal-header").css({ color: "#fff", "background-color": "#2471a3"});
            modalCrearCatalogo.find(".modal-header").addClass("modal-header-info");
            modalCrearCatalogo.find(".btnGuardar, .btnCancelar").css({"border-radius": "10px"});
            modalCrearCatalogo.modal('show');

            }//fin success

        });

    })


    /* ELIMINA LAS ENCUESTAS QUE NO SEAN NECESARIAS */
    $(document).on('click', '#btnDeleteEncuesta', function(){

        let id_encuesta = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            type:  'warning',
            title: 'SoftInspi',
            text: 'Seguro quiere eliminar esta Encuesta?.',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.value == true) {

                $.ajax({

                    type: 'POST',
                    //url: '{{ route("encuesta.saveEncuesta") }}',
                    url: '/encuestas/deleteEncuestaUser',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id_encuesta': id_encuesta,
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
        });


    });
    /* ELIMINA LAS ENCUESTAS QUE NO SEAN NECESARIAS */


});



//modalContent
    $(document).on('click', '#btnFinalizar2', function(){

        let id_evento = $(this).data('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/laboratoriosTipo/'+id_evento,//PONER URL ELIMINAR
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            beforeSend: function () {
                $('body').waitMe({
                    effect: 'roundBounce', //'roundBounce',//'bounce','win8','orbit','ios','win8_linear'
                    text: 'Por favor espere...', //'Please waiting...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#A52A2A'
                });
            },
            success: function(res){

                $('#modalContent').text('');

                console.log(res);

                if (res.hasOwnProperty('laboratorios')) {
                    // Obtener la lista de laboratorios
                    var laboratorios = res.laboratorios;
        
                    // Iterar sobre la lista de laboratorios
                    for (var laboratorio of laboratorios) {
                        // Acceder a las propiedades de cada laboratorio
                        var tipoencuesta_id = laboratorio.tipoencuesta_id;
                        var nombre = laboratorio.nombre;
                        var valor = laboratorio.valor;
                        var id = laboratorio.id;
                        var tipo = laboratorio.tipo;
        
                        // Hacer lo que necesites con cada laboratorio
                        console.log('Tipo Encuesta ID:', tipoencuesta_id);
                        console.log('Nombre:', nombre);
                        console.log('Valor:', valor);
                        console.log('ID:', id);
                        console.log('Tipo:', tipo);

                        $('#modalContent').append(`
                        <div class="row mt-1 d-flex justify-content-center align-items-center">
        
                            <a class="col-5 btn btn-primary mx-1 mt-2 d-flex justify-content-center align-items-center" href="/encuestas/usuEncuesta?tipoencu_id=${id}" type="button">
                                <i class="lni lni-circle-plus"></i> ${nombre}
                            </a>
        
                        </div>
                        `);

                    }
                } else {

                    //no existe

                }

            }

        });


    });


    function graficoPrimario(tipoencu_id, id_evento){

        //var tipoencu_id = 18;
        var conta = 0;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: '/encuestas/getEncuestasTotales?tipoencu_id='+tipoencu_id+'&id_evento='+id_evento,//PONER URL ELIMINAR
            data: {
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            success: function(res){

                //console.log(res.data);
                cargarComentarios(res.data);

                var encuestadosT = res.totalEncuestas;
                $('#encuestadosT').append(`${encuestadosT}`);
                var totalOpciones = 0;
                var porcentaje = 0;

                var resultadosAgrupados = res.resultadosAgrupados;

                var resulTotales = [];
                var nombresPregunta = [];

                for (var key in resultadosAgrupados) {
                    if (resultadosAgrupados.hasOwnProperty(key)) {
                        // key es la clave exterior (por ejemplo, "11", "12", etc.)
                        var opciones = resultadosAgrupados[key];
                        
                        var idPregunta = opciones.idPregunta;
                        var nombre = opciones.nombre;

                        nombresPregunta.push(nombre);

                        var opcionesO = opciones.opciones;
                        var nombres  = opciones.nombres;

                        var opcion = [];
                        var nombreO = [];

                        let contaOpcion = 1;
                        let trest = 0;
                        for (var key in opcionesO) {
                            console.log(key, opcionesO[key]);
                            opcion.push(opcionesO[key]);
                            rest = contaOpcion * opcionesO[key];
                            trest = rest + trest;
                            contaOpcion++;
                        }

                        resulTotales.push(trest);


                        for (var key in nombres) {
                            nombreO.push(nombres[key]);
                        }

                        totalOpciones = opcion.length;

                        console.log(opcion);
                        console.log(nombreO);

                        // Iterar sobre las claves del objeto interior (opciones)
                        //for (var opcion in opcionesO) {

                            $('#contGraficos').append(`
                
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">   
                                        <canvas id="myChart${conta}" style="width='200'; height='200';"></canvas>
                                    </div>
                                </div> 
                            </div> 

            
                            `);
                            let ctx = document.getElementById('myChart'+conta).getContext('2d');

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: nombreO,
                                    datasets: [{
                                        label: nombre,
                                        data: opcion,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            conta++;

                            /*

                            if (opciones.hasOwnProperty(opcion)) {
                                // opcion es la clave interior (por ejemplo, "14", "15", etc.)
                                var countTrue = opciones[opcion];
                                
                                // Ahora puedes usar key, opcion y countTrue como necesites
                                console.log("Pregunta:", key, "Opción:", opcion, "Count True:", countTrue);
                            }
                            */
                        //}
                    }
                }

                console.log(res);
                console.log(resulTotales);

                
                var porcentajesArray = [];
                var colores = [];

                resulTotales.forEach(elemento => {
 
                    porcentaje = elemento / (encuestadosT*totalOpciones);
                    porcentaje = porcentaje * 100; //lo transformamos al 100%
                    porcentajesArray.push(porcentaje.toFixed(2));
                    colores.push(generarColorAlAzar(0.5));

                });
                
                console.log(porcentajesArray);

                // Uso de la función
                //var colorAlAzar = generarColorAlAzar(0.5); // 0.5 es la opacidad
                //console.log(colorAlAzar);

                var ctx = document.getElementById('myChart2000').getContext('2d');

                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: nombresPregunta,
                        datasets: [{
                            label: 'Ventas mensuales',
                            data: porcentajesArray,
                            /*backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',*/
                            backgroundColor: colores,
                            borderColor: colores,
                            borderWidth: 1
                        }]
                    },
                    options: {

                        plugins: {
                            datalabels: {
                                color: '#000', // color del texto
                                anchor: 'end', // posición de las etiquetas (end, start, center, ...)
                                align: 'start', // alineación del texto (start, end, center, ...)
                                offset: 5, // distancia entre el borde y las etiquetas
                                formatter: (value, context) => {
                                    return value + '%'; // formato de la etiqueta
                                }
                            }
                        }

                        // scales: {
                        //     y: {
                        //         beginAtZero: true
                        //     }
                        // }
                    }
                });

                let suma = 0;

                for (let i = 0; i < nombresPregunta.length; i++) {

                    $('#contenedorPreguntas').append(`

                    <div class="card radius-10 border shadow-none mt-2">
                        <div class="card-body row">
                            <div class="d-flex align-items-center">
                                <div class="col-lg-9 px-2">
                                    <h5 class="my-1 text-secondary">${nombresPregunta[i]}</h5>
                                </div>
                                <div class="col-lg-3">
                                    <h3 class="my-1 text-secondary">${porcentajesArray[i]}%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    `);

                    suma += parseInt(porcentajesArray[i]);

                }

                // Calcular el promedio dividiendo la suma por la cantidad de elementos
                let promedio = suma / porcentajesArray.length;
                $('#promedioT').append(promedio.toFixed(2));

            

            }

        });

    }


    function generarColorAlAzar(opacidad) {
        var letras = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letras[Math.floor(Math.random() * 16)];
        }
        return color + (opacidad !== undefined ? Math.round(opacidad * 255).toString(16) : '');
    }


    function cargarComentarios(data){

        var hospital = '';

        data.forEach(function(element) {

            if(element.comentario != ''){

                if(element.hospital == ''){
                    hospital = 'Encuestado';
                }else{
                    hospital = element.hospital;
                }

                $('#collapseOne').append(`

                <div class="accordion-body">
                    <strong>${hospital}</strong> ${element.comentario}.
                </div>
                
                `);

            }

        });

    }




    

