@extends('layouts.main')

@section('title', 'Reportes Eventos Comunicación')

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="origen"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="hoy"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="origensem"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                <div class="pie-chart-container">
                        <canvas id="semanal"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="origenmes"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="chart-container">
                <div class="pie-chart-container">
                        <canvas id="mensual"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="total"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_origen; ?>`);
        var ctx = $("#origen");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Eventos Diarios Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1,1,1,1,1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Difusión Eventos hoy",
            fontSize: 18,
            fontColor: "#111"
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });
    
        });    
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_diario; ?>`);
        var ctx = $("#hoy");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Eventos Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1, 1, 1, 1, 1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Eventos reportados hoy",
            fontSize: 18,
            fontColor: "#111"
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: 10
            }
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    
        });
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_origen_semanal; ?>`);
        var ctx = $("#origensem");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Eventos Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1,1,1,1,1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Difusión Eventos últimos 7 días",
            fontSize: 18,
            fontColor: "#111"
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });
    
        });    
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_semana; ?>`);
        var ctx = $("#semanal");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Eventos Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1, 1, 1, 1, 1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Eventos reportados últimos 7 días",
            fontSize: 18,
            fontColor: "#111"
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: 10
            }
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    
        });
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_origen_mes; ?>`);
        var ctx = $("#origenmes");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Origen Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1,1,1,1,1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Difusión Eventos últimos 30 días",
            fontSize: 18,
            fontColor: "#111"
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "pie",
            data: data,
            options: options
        });
    
        });    
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_mes; ?>`);
        var ctx = $("#mensual");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Solicitudes Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                "#A9A9A9",
                "#DC143C",
                "#F4A460",
                "#2E8B57",
                "#1D7A46",
                "#CDA776",
                ],
                borderColor: [
                "#CDA776",
                "#989898",
                "#CB252B",
                "#E39371",
                "#1D7A46",
                "#F4A460",
                "#CDA776",
                ],
                borderWidth: [1, 1, 1, 1, 1,1,1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Difusión Eventos últimos 30 días",
            fontSize: 18,
            fontColor: "#111"
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: 10
            }
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    
        });
    </script>
    <script>
        $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data_total; ?>`);
        var ctx = $("#total");
    
        //pie chart data
        var data = {
            labels: cData.label,
            datasets: [
            {
                label: "Solicitudes Conteo",
                data: cData.data,
                backgroundColor: [
                "#DEB887",
                ],
                borderColor: [
                "#CDA776",
                ],
                borderWidth: [1, 1]
            }
            ]
        };
    
        //options
        var options = {
            responsive: true,
            title: {
            display: true,
            position: "top",
            text: "Cantidad Eventos por fecha últimos 30 días",
            fontSize: 18,
            fontColor: "#111"
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: 10
            }
            },
            legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
            },
        };
    
        //create Pie Chart class object
        var chart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    
        });
    </script>
@endsection
