<?php
    include("dataAverageUse.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reciclaje Automático de Basura - Gráfica de Uso por Días</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="css/simple-line-icons.css"/>
<link rel="stylesheet" type="text/css" href="css/animate.css"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" type="text/css" href="css/owl.theme.css"/>
<link rel="stylesheet" type="text/css" href="css/owl.transitions.css"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,100,200,300,500,600,800,900' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps:400,700' rel='stylesheet' type='text/css'>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<div class="main-header" id="main-header">
  <nav class="navbar mynav navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="#">Grupo 8</a>
        </div>
    </div>
  </nav>
</div>

<div class="banner" id="banner">
</div>

<div class="features" id= "features">
  <div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Comparación entre Cantidad y el Peso promedio de los Objetos reciclados en cada Semana</h3>
        </div>
        <br>
        <div class="col-md-12">
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/data.js"></script>

            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>

            <style style="text/css">
                .highcharts-figure, .highcharts-data-table table {
                    min-width: 320px; 
                    max-width: 800px;
                    margin: 1em auto;
                }

                .chart {
                    height: 260px;
                }

                .highcharts-data-table table {
                    font-family: Verdana, sans-serif;
                    border-collapse: collapse;
                    border: 1px solid #EBEBEB;
                    margin: 10px auto;
                    text-align: center;
                    width: 100%;
                    max-width: 500px;
                }
                .highcharts-data-table caption {
                    padding: 1em 0;
                    font-size: 1.2em;
                    color: #555;
                }
                .highcharts-data-table th {
                    font-weight: 600;
                    padding: 0.5em;
                }
                .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
                    padding: 0.5em;
                }
                .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
                    background: #f8f8f8;
                }
                .highcharts-data-table tr:hover {
                    background: #f1f7ff;
                }
            </style>

            <!-- http://doc.jsfiddle.net/use/hacks.html#css-panel-hack -->
            <meta name="viewport" content="width=device-width, initial-scale=1" />

            <script language="javascript">
                ['mousemove', 'touchmove', 'touchstart'].forEach(function (eventType) {
                    document.getElementById('container').addEventListener(
                        eventType,
                        function (e) {
                            var chart,
                                point,
                                i,
                                event;

                            for (i = 0; i < Highcharts.charts.length; i = i + 1) {
                                chart = Highcharts.charts[i];
                                // Find coordinates within the chart
                                event = chart.pointer.normalize(e);
                                // Get the hovered point
                                point = chart.series[0].searchPoint(event, true);

                                if (point) {
                                    point.highlight(e);
                                }
                            }
                        }
                    );
                });

                /**
                 * Override the reset function, we don't need to hide the tooltips and
                 * crosshairs.
                 */
                Highcharts.Pointer.prototype.reset = function () {
                    return undefined;
                };

                /**
                 * Highlight a point by showing tooltip, setting hover state and draw crosshair
                 */
                Highcharts.Point.prototype.highlight = function (event) {
                    event = this.series.chart.pointer.normalize(event);
                    this.onMouseOver(); // Show the hover marker
                    this.series.chart.tooltip.refresh(this); // Show the tooltip
                    this.series.chart.xAxis[0].drawCrosshair(event, this); // Show the crosshair
                };

                /**
                 * Synchronize zooming through the setExtremes event handler.
                 */
                function syncExtremes(e) {
                    var thisChart = this.chart;

                    if (e.trigger !== 'syncExtremes') { // Prevent feedback loop
                        Highcharts.each(Highcharts.charts, function (chart) {
                            if (chart !== thisChart) {
                                if (chart.xAxis[0].setExtremes) { // It is null while updating
                                    chart.xAxis[0].setExtremes(
                                        e.min,
                                        e.max,
                                        undefined,
                                        false,
                                        { trigger: 'syncExtremes' }
                                    );
                                }
                            }
                        });
                    }
                }

                var data = {"xData": <?php echo json_encode($dias, JSON_UNESCAPED_UNICODE)?>,
                    "datasets":[
                    {
                        "name" : "Peso",
                        "data" : <?php echo json_encode($peso)?>,
                        "unit" : "lb",
                        "type" : "area",
                        "valueDecimals" : 2
                    },{
                        "name" : "Cantidad",
                        "data" : <?php echo json_encode($quant)?>,
                        "unit" : "objetos",
                        "type" : "spline",
                        "valueDecimals" : 0
                    }]
                };

                data.datasets.forEach(function (dataset, i) {

                    // Add X values
                    dataset.data = Highcharts.map(dataset.data, function (val, j) {
                        return [data.xData[j], val];
                    });

                    var chartDiv = document.createElement('div');
                    chartDiv.className = 'chart';
                    document.getElementById('container').appendChild(chartDiv);

                    Highcharts.chart(chartDiv, {
                        chart: {
                            marginLeft: 40, // Keep all charts left aligned
                            spacingTop: 20,
                            spacingBottom: 20
                        },
                        title: {
                            text: dataset.name,
                            align: 'left',
                            margin: 0,
                            x: 30
                        },
                        credits: {
                            enabled: false
                        },
                        legend: {
                            enabled: false
                        },
                        xAxis: {
                            categories: data.xData,
                            crosshair: true,
                            events: {
                                setExtremes: syncExtremes
                            },
                            labels:{
                                x:-10,
                            }
                        },
                        yAxis: {
                            title: {
                                text: null
                            }
                        },
                        tooltip: {
                            positioner: function () {
                                return {
                                    // right aligned
                                    x: this.chart.chartWidth - this.label.width,
                                    y: 10 // align to title
                                };
                            },
                            borderWidth: 0,
                            backgroundColor: 'none',
                            pointFormat: '{point.y}',
                            headerFormat: '',
                            shadow: false,
                            style: {
                                fontSize: '18px'
                            },
                            valueDecimals: dataset.valueDecimals
                        },
                        series: [{
                            data: dataset.data,
                            name: dataset.name,
                            type: dataset.type,
                            color: Highcharts.getOptions().colors[i],
                            fillOpacity: 0.3,
                            tooltip: {
                                valueSuffix: ' ' + dataset.unit
                            }
                        }]
                    });
                });
            </script>
            <div class="col-lg-10 col-lg-offset-1 text-center text">

        <!-- /.row (nested) --> 
        <a href="index.php" class="view-more">Regresar</a> </div>
        </div>
    </div>
  </div>
</div>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4"> <span class="copyright">Copyright &copy; Ethereal 2018</span> </div>
      <div class="col-md-4">
        <ul class="list-inline social-buttons">
          <li><a href="#"><i class="fa fa-twitter"></i></a> </li>
          <li><a href="#"><i class="fa fa-facebook"></i></a> </li>
          <li><a href="#"><i class="fa fa-linkedin"></i></a> </li>
        </ul>
      </div>
      <div class="col-md-4">
        <ul class="list-inline quicklinks">
          <li>Designed by <a href="http://w3template.com">W3 Template</a> </li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<script src="js/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/jquery.waypoints.min.js"></script> 
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

  // Prevent default anchor click behavior
  event.preventDefault();

  // Store hash
  var hash = this.hash;

  // Using jQuery's animate() method to add smooth page scroll
  // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
  $('html, body').animate({
    scrollTop: $(hash).offset().top
  }, 900, function(){

    // Add hash (#) to URL when done scrolling (default click behavior)
    window.location.hash = hash;
    });
  });
})
</script>
</body>
</html>