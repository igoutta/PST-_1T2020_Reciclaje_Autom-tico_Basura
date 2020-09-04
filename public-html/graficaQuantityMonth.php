<?php
  include("dataQuantityMonth.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reciclaje Automático de Basura - Gráfica de Contenido en Meses</title>
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
      <div class="col-md-12">
      <!-- /. Se llamar a las librerías necesarias para gráficar y realizar mas acciones.
      Se han escogido estas gráficas debido a su versatilidad y su enfoque en este campo -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <figure class="highcharts-figure">
          <div id="container"></div>
        </figure>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- /. Para facilitar la construcción de estilos, se lo crea dentro de este archivo -->
        <style style="text/css">
          .highcharts-figure, .highcharts-data-table table {
            min-width: 360px; 
            max-width: 800px;
            margin: 1em auto;
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
        
        <!-- /. Se utiliza el maquetado de HTML para indicar el uso de Javascript dentro -->
        <script language="javascript">

          Highcharts.chart('container', {

          chart: {

            type: 'line'

          },

          title: {

            text: 'Contenido reciclado en Meses'

          },

          subtitle: {

            text: 'Objetos desechados en los contenedores clasificados por tipo'

          },

          // Al ser una libreía diferente usamos ejes y se usa el esquema de categorias
          // para introducir los nombres de los valores a analizar, en formato JSON
          // En este caso usamos la variable meses 
          xAxis: {

            categories: <?php echo json_encode($meses)?>

          },

          yAxis: {

            title: {

              text: 'Cantidad'

            }

          },

          plotOptions: {

            line: {

              dataLabels: {

                enabled: true

              },

              enableMouseTracking: false

            }

          },

          // Dentro de las series se introducen los valores a ser graficados
          // En este caso usamos la variable cuenta para el Papel y 
          // la variable cuenta para el Metal
          series: [{

            name: 'Papel',

            data: <?php echo json_encode($cuenta);?>

          }, {

            name: 'Metal',

            data: <?php echo json_encode($cuenta2);?>

          }]

        });

        </script>
        <div class="col-lg-10 col-lg-offset-1 text-center text">

        <!-- /. Se crea un botón para regresar al inicio --> 
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