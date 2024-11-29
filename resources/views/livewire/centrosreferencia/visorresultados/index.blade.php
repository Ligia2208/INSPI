<div class="col-xl-12">
    @if ($count>=0)
        <!--begin::Advance Table Widget 3-->
        <style>
            #chartdiv1 {
            width: 100%;
            height: 500px;
            }
            #chartdiv2 {
            width: 100%;
            height: 500px;
            }
            #chartdiv3 {
            width: 100%;
            height: 500px;
            }
            #chartdiv4 {
            width: 100%;
            height: 500px;
            }
            #chartdiv5 {
            width: 100%;
            height: 500px;
            }
            #chartdiv6 {
            width: 100%;
            height: 500px;
            }
        </style>
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header border-0 py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">@yield('title')<span
                            class="text-muted mt-3 font-weight-bold font-size-sm"> ({{ $count }})</span></span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-0 pb-3">
                <div class="card card-body">
                    <div class="mb-5 ">
                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="csedes"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione una Sede") }}</option>
                                            @foreach ($sedes as $objSede)
                                                <option data-subtext="" value="{{ $objSede->id }}">{{ $objSede->descripcion }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="claboratorios"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione un CRN - Laboratorio") }}</option>
                                            @if(!is_null($crns))
                                            @foreach ($crns as $objCrn)
                                                <option data-subtext="" value="{{ $objCrn->id }}">{{ $objCrn->descripcion }}</option>
                                            @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 my-2 my-md-0">
                                        <div class="input-icon">
                                            <select
                                            wire:model="ceventos"
                                            class="form-control"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">{{ __("Seleccione un Evento") }}</option>
                                            @if(!is_null($eventos))
                                            @foreach ($eventos as $objEven)
                                                <option data-subtext="" value="{{ $objEven->id }}">{{ $objEven->simplificado }}</option>
                                            @endforeach
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-success font-weight-bold mr-2" onclick="recargar()"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <br>
                            </div>
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                              Fecha Toma Muestra
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                            <label class="form-check-label" for="exampleRadios2">
                                              Ingreso CRN - Lab.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 my-2 my-md-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                            <label class="form-check-label" for="exampleRadios2">
                                              Fecha Reporte
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __("Inicio") }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    wire:model="fechainicio"
                                                    type="date"
                                                    class="form-control form-control-solid @error('fechainicio') is-invalid @enderror"
                                                    placeholder="Ej: 17/04/2024" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-2 my-md-0">
                                        <div class="d-flex align-items-center">
                                            <label class="mr-3 mb-0 d-none d-md-block">{{ __("Fin") }}:</label>
                                            <div class="input-group input-group-solid">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                                <input
                                                    wire:model="fechafin"
                                                    type="date"
                                                    class="form-control form-control-solid @error('fechafin') is-invalid @enderror"
                                                    placeholder="Ej: 27/06/2024" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-3">
                <div class="mb-5 ">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-6 my-2 my-md-0">
                                    <div id="chartdiv1"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                                <div class="col-md-6 my-2 my-md-0">
                                    <div id="chartdiv2"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card-body pt-0 pb-3">
                <div class="mb-5 ">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-6 my-2 my-md-0">
                                    <div id="chartdiv5"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                                <div class="col-md-6 my-2 my-md-0">
                                    <div id="chartdiv6"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card-body pt-0 pb-3">
                <div class="mb-5 ">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-12 my-2 my-md-0">
                                    <div id="chartdiv3"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card-body pt-0 pb-3">
                <div class="mb-5 ">
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-xl-12">
                            <div class="row align-items-center">
                                <div class="col-md-12 my-2 my-md-0">
                                    <div id="chartdiv4"><h3>{{ $etiqueta }}</h3></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="card-px text-center py-5">
                    <h2 class="fs-2x fw-bolder mb-10">Hola!</h2>
                    <p class="text-gray-400 fs-4 fw-bold mb-10">Al parecer no tienes ningun Área/Dirección.
                        <br> Ponga en marcha SoftInspi añadiendo su primer Área/Dirección
                    </p>
                </div>
                <div class="text-center px-4 ">
                    <img class="img-fluid col-6" alt=""
                        src="{{ asset('assets/media/ilustrations/areas.png') }}">
                </div>
            </div>
        </div>
    @endif

    @section('footer')

        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>

        <script>
            Livewire.on('closeModal', function() {
                $('.modal').modal('hide');
            });

            function confirmDestroy(id) {
                swal.fire({
                    title: "¿Estas seguro?",
                    text: "No podrá recuperar este Área/Dirección y los servicios creados con este tipo se quedarán sin vinculación",
                    icon: "warning",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "<i class='fa fa-trash'></i> <span class='text-white'>Si, eliminar</span>",
                    cancelButtonText: "<i class='fas fa-arrow-circle-left'></i> <span class='text-dark'>No, cancelar</span>",
                    reverseButtons: true,
                    cancelButtonClass: "btn btn-light-secondary font-weight-bold",
                    confirmButtonClass: "btn btn-danger",
                    showLoaderOnConfirm: true,
                }).then(function(result) {
                    if (result.isConfirmed) {
                        @this.call('destroy', id);
                    }
                });
            }

            function exportToExcel(tableID, filename = '') {
                // Tipo de exportación
                if (!filename) filename = 'excel_data.xls';
                let dataType = 'application/vnd.ms-excel';

                // Origen de los datos
                let tableSelect = document.getElementById(tableID);
                let tableHTML = tableSelect.outerHTML;

                // Crea el archivo descargable
                let blob = new Blob([tableHTML], {type: dataType});

                // Crea un enlace de descarga en el navegador
                if (window.navigator && window.navigator.msSaveOrOpenBlob) { // Descargar para IExplorer
                    window.navigator.msSaveOrOpenBlob(blob, filename);
                } else { // Descargar para Chrome, Firefox, etc.
                    let a = document.createElement("a");
                    document.body.appendChild(a);
                    a.style = "display: none";
                    let csvUrl = URL.createObjectURL(blob);
                    a.href = csvUrl;
                    a.download = filename;
                    a.click();
                    URL.revokeObjectURL(a.href)
                    a.remove();
                }
            }
            function recargar(){
                location.reload();
            }

        </script>
        <script>
            $(function(){
                am5.ready(function() {
                    var root = am5.Root.new("chartdiv1");
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);
                    var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true,
                    paddingLeft:0,
                    paddingRight:1
                    }));
                    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                    cursor.lineY.set("visible", false);
                    var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30,
                    minorGridEnabled: true
                    });
                    xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                    });
                    xRenderer.grid.template.setAll({
                    location: 1
                    })
                    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "grupo",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                    }));
                    var yRenderer = am5xy.AxisRendererY.new(root, {
                    strokeOpacity: 0.1
                    })
                    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: yRenderer
                    }));
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total",
                    sequencedInterpolation: true,
                    categoryXField: "grupo",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                    }));
                    series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
                    series.columns.template.adapters.add("fill", function (fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                    });
                    series.columns.template.adapters.add("stroke", function (stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                    });
                    var data = <?php print_r($data_res);?> ;
                    xAxis.data.setAll(data);
                    series.data.setAll(data);
                    series.appear(1000);
                    chart.appear(1000, 100);
                });

                am5.ready(function() {

                    // Create root element
                    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                    var root = am5.Root.new("chartdiv2");

                    // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(
                    am5percent.PieChart.new(root, {
                        endAngle: 270
                    })
                    );

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        valueField: "total",
                        categoryField: "grupo",
                        endAngle: 270
                    })
                    );

                    series.states.create("hidden", {
                    endAngle: -90
                    });

                    series.data.setAll(<?php print_r($data_res);?>);

                    series.appear(1000, 100);

                });

                am5.ready(function() {

                    // Create root element
                    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                    var root = am5.Root.new("chartdiv3");

                    // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/
                    var chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: true,
                        panY: true,
                        wheelY: "zoomXY",
                        pinchZoomX: true
                    })
                    );

                    chart.get("colors").set("step", 2);

                    // Create axes
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

                    var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 50,
                    minorGridEnabled: true
                    });

                    var xAxis = chart.xAxes.push(
                    am5xy.CategoryAxis.new(root, {
                        categoryField: "provincia",
                        renderer: xRenderer,
                        tooltip: am5.Tooltip.new(root, {})
                    })
                    );

                    xRenderer.grid.template.setAll({
                    location: 1
                    })

                    var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        extraMax: 0.1,
                        extraMin: 0.1,
                        renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                        }),
                        tooltip: am5.Tooltip.new(root, {})
                    })
                    );

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                    var series = chart.series.push(
                    am5xy.LineSeries.new(root, {
                        calculateAggregates: true,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "eventos",
                        categoryXField: "provincia",
                        tooltip: am5.Tooltip.new(root, {
                        /* labelText: "value: {valueY}\nerror: {error}" */
                        labelText: "provincia: {provincia}\neventos: {eventos}"
                        })
                    })
                    );

                    // add error bullet
                    series.bullets.push(function() {
                    var graphics = am5.Graphics.new(root, {
                        strokeWidth: 2,
                        stroke: series.get("stroke"),
                        draw: function(display, target) {
                        var dataItem = target.dataItem;

                        var error = dataItem.dataContext.error;

                        var yPosition0 = yAxis.valueToPosition(0);
                        var yPosition1 = yAxis.valueToPosition(error);

                        var height =
                            (yAxis.get("renderer").positionToCoordinate(yPosition1) - yAxis.get("renderer").positionToCoordinate(yPosition0)) / 2;

                        display.moveTo(0, -height);
                        display.lineTo(0, height);

                        display.moveTo(-10, -height);
                        display.lineTo(10, -height);

                        display.moveTo(-10, height);
                        display.lineTo(10, height);
                        }
                    });

                    return am5.Bullet.new(root, {
                        dynamic: true,
                        sprite: graphics
                    });
                    });

                    // Add circle bullet
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
                    series.bullets.push(function() {
                    var graphics = am5.Circle.new(root, {
                        strokeWidth: 2,
                        radius: 5,
                        stroke: series.get("stroke"),
                        fill: root.interfaceColors.get("background")
                    });
                    return am5.Bullet.new(root, {
                        sprite: graphics
                    });
                    });

                    // Add cursor
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                    chart.set("cursor", am5xy.XYCursor.new(root, {
                    xAxis: xAxis,
                    yAxis: yAxis,
                    snapToSeries: [series]
                    }));

                    series.data.setAll(<?php print_r($data_prov);?>);
                    xAxis.data.setAll(<?php print_r($data_prov);?>);

                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear(1000);
                    chart.appear(1000, 100);

                });

                am5.ready(function() {

                    // Create root element
                    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                    var root = am5.Root.new("chartdiv4");

                    // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/
                    var chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: true,
                        panY: true,
                        wheelY: "zoomXY",
                        pinchZoomX: true
                    })
                    );

                    chart.get("colors").set("step", 2);

                    // Create axes
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

                    var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 50,
                    minorGridEnabled: true
                    });

                    var xAxis = chart.xAxes.push(
                    am5xy.CategoryAxis.new(root, {
                        categoryField: "canton",
                        renderer: xRenderer,
                        tooltip: am5.Tooltip.new(root, {})
                    })
                    );

                    xRenderer.grid.template.setAll({
                    location: 1
                    })

                    var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        extraMax: 0.1,
                        extraMin: 0.1,
                        renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                        }),
                        tooltip: am5.Tooltip.new(root, {})
                    })
                    );

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                    var series = chart.series.push(
                    am5xy.LineSeries.new(root, {
                        calculateAggregates: true,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "eventos",
                        categoryXField: "canton",
                        tooltip: am5.Tooltip.new(root, {
                        /* labelText: "value: {valueY}\nerror: {error}" */
                        labelText: "canton: {canton}\neventos: {eventos}"
                        })
                    })
                    );

                    // add error bullet
                    series.bullets.push(function() {
                    var graphics = am5.Graphics.new(root, {
                        strokeWidth: 2,
                        stroke: series.get("stroke"),
                        draw: function(display, target) {
                        var dataItem = target.dataItem;

                        var error = dataItem.dataContext.error;

                        var yPosition0 = yAxis.valueToPosition(0);
                        var yPosition1 = yAxis.valueToPosition(error);

                        var height =
                            (yAxis.get("renderer").positionToCoordinate(yPosition1) - yAxis.get("renderer").positionToCoordinate(yPosition0)) / 2;

                        display.moveTo(0, -height);
                        display.lineTo(0, height);

                        display.moveTo(-10, -height);
                        display.lineTo(10, -height);

                        display.moveTo(-10, height);
                        display.lineTo(10, height);
                        }
                    });

                    return am5.Bullet.new(root, {
                        dynamic: true,
                        sprite: graphics
                    });
                    });

                    // Add circle bullet
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
                    series.bullets.push(function() {
                    var graphics = am5.Circle.new(root, {
                        strokeWidth: 2,
                        radius: 5,
                        stroke: series.get("stroke"),
                        fill: root.interfaceColors.get("background")
                    });
                    return am5.Bullet.new(root, {
                        sprite: graphics
                    });
                    });

                    // Add cursor
                    // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                    chart.set("cursor", am5xy.XYCursor.new(root, {
                    xAxis: xAxis,
                    yAxis: yAxis,
                    snapToSeries: [series]
                    }));

                    series.data.setAll(<?php print_r($data_cant);?>);
                    xAxis.data.setAll(<?php print_r($data_cant);?>);

                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear(1000);
                    chart.appear(1000, 100);

                });

                am5.ready(function() {

                    // Create root element
                    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                    var root = am5.Root.new("chartdiv5");

                    // Set themes
                    // https://www.amcharts.com/docs/v5/concepts/themes/
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);

                    // Create chart
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                    var chart = root.container.children.push(
                    am5percent.PieChart.new(root, {
                        endAngle: 270
                    })
                    );

                    // Create series
                    // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                    var series = chart.series.push(
                    am5percent.PieSeries.new(root, {
                        valueField: "total",
                        categoryField: "grupo",
                        endAngle: 270
                    })
                    );

                    series.states.create("hidden", {
                    endAngle: -90
                    });

                    series.data.setAll(<?php print_r($data_sexo);?>);

                    series.appear(1000, 100);

                });

                am5.ready(function() {
                    var root = am5.Root.new("chartdiv6");
                    root.setThemes([
                    am5themes_Animated.new(root)
                    ]);
                    var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: true,
                    panY: true,
                    wheelX: "panX",
                    wheelY: "zoomX",
                    pinchZoomX: true,
                    paddingLeft:0,
                    paddingRight:1
                    }));
                    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                    cursor.lineY.set("visible", false);
                    var xRenderer = am5xy.AxisRendererX.new(root, {
                    minGridDistance: 30,
                    minorGridEnabled: true
                    });
                    xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 15
                    });
                    xRenderer.grid.template.setAll({
                    location: 1
                    })
                    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    maxDeviation: 0.3,
                    categoryField: "grupo",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                    }));
                    var yRenderer = am5xy.AxisRendererY.new(root, {
                    strokeOpacity: 0.1
                    })
                    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    maxDeviation: 0.3,
                    renderer: yRenderer
                    }));
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: "Series 1",
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: "total",
                    sequencedInterpolation: true,
                    categoryXField: "grupo",
                    tooltip: am5.Tooltip.new(root, {
                        labelText: "{valueY}"
                    })
                    }));
                    series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
                    series.columns.template.adapters.add("fill", function (fill, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                    });
                    series.columns.template.adapters.add("stroke", function (stroke, target) {
                    return chart.get("colors").getIndex(series.columns.indexOf(target));
                    });
                    var data = <?php print_r($data_edad);?> ;
                    xAxis.data.setAll(data);
                    series.data.setAll(data);
                    series.appear(1000);
                    chart.appear(1000, 100);
                });

            });
        </script>

    @endsection
</div>


