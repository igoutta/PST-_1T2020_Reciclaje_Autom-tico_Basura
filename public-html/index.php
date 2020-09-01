<?php
include("conexion.php");
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Grupo 8: Reciclaje Automatizado</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="css/simple-line-icons.css"/>
<link rel="stylesheet" type="text/css" href="css/animate.css"/>
<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" type="text/css" href="css/owl.carousel.css"/>
<link rel="stylesheet" type="text/css" href="css/owl.theme.css"/>
<link rel="stylesheet" type="text/css" href="css/owl.transitions.css"/>
<link rel="stylesheet" href="tabla.css"/>
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
        <a class="navbar-brand" href="#">Grupo 8</a> </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li class="active"><a href="#banner">Inicio</a></li>
          <li><a href="#features">Información</a></li>
          <li><a href="#work">Gráficas</a></li>
          <li><a href="#testimonials">Testimonios</a></li>
          <li><a href="#about">Acerca de</a></li>
        </ul>
      </div>
    </div>
  </nav>
</div>
<div class="banner" id="banner">
  <div class="bg-overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="banner-text">
            <h2>Reciclaje <span>Automático</span> de Basura</h2>
            <p>Aplicación Web</p>
            <p>Elaborada por el Grupo 8</p>
            <a href="https://github.com/igoutta/PST_1T2020_Reciclaje_Automatico_Basura" target="_blank" rel="noopener noreferrer" class="banner-button"> Ir al Repositorio GitHub</a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="features" id= "features">
  <div class="container">
    <div class="row">

      <?php
        for($i=1; $i<=3; $i++) {
      ?>
          <div class="col-md-12" id="table<?php echo $i?>">

            <table>
            <caption>Deposito <?php echo $i ?></caption>
            <thead>
            <tr>
              <th scope="col">Contenedor</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Peso</th>
              <th scope="col">Estado</th>
            </tr>
            </thead>
            
            <?php
            $result = mysqli_query($con, "SELECT tipo, cantidad, peso, lleno from Contenedor where num_deposito = ".$i);
            $j=0;
            while($row = mysqli_fetch_array($result)){
            ?>
            
            <tr>
              <td id="tipo<?php echo $i; echo $j;?>"></td>
              <td id="cantidad<?php echo $i; echo $j;?>"></td>
              <td id="peso<?php echo $i; echo $j;?>"></td>
              <td id="lleno<?php echo $i; echo $j;?>"></td>
            </tr>

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
            <script type="text/javascript">
              var auto_refresh = setInterval(
              function ()
              {
                document.getElementById("tipo<?php echo $i; echo $j;?>").innerHTML = "<?php echo $row['tipo'] ?>";
                document.getElementById("cantidad<?php echo $i; echo $j;?>").innerHTML = "<?php echo $row['cantidad']; ?>";
                document.getElementById("peso<?php echo $i; echo $j;?>").innerHTML = "<?php echo $row['peso']; ?>";
                document.getElementById("lleno<?php echo $i; echo $j;?>").innerHTML = 
                "<?php if ($row['lleno'] == 0){
                  echo 'Disponible';
                }else{
                    echo 'Lleno';
                } ?>";
              }, 1000);
            </script>

            <?php
            $j++;
            }
            ?>
            </table>
            <?php
            mysqli_free_result($result);
            ?>
            <br>

          </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>


<!-- Portfolio -->
<div id="work" class="portfolio">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-lg-offset-1 text-center text">
        <h3>Gráficas</h3>
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <p>Información por Tipo de Objeto</p>
            <div class="portfolio-item"> <a href="graficaInfo.php"> <img class="img-portfolio img-responsive" src="images/grafica_info.jpg" alt=""> </a> </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <p>Uso de Contenedor a la Semana</p>
            <div class="portfolio-item"> <a href="graficaAverageUse.php"> <img class="img-portfolio img-responsive" src="images/grafica_averageuse.jpg" alt=""> </a> </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <p>Contenido Reciclado en Meses</p>
            <div class="portfolio-item"> <a href="graficaQuantityMonth.php"> <img class="img-portfolio img-responsive" src="images/grafica_quantitymonth.jpg" alt=""> </a> </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <p>Uso de Contenedores durante un día</p>
            <div class="portfolio-item"> <a href="graficaUseHours.php"> <img class="img-portfolio img-responsive" src="images/grafica_usehours.jpg" alt=""> </a> </div>
          </div>
        </div>
        <!-- /.row (nested) --> 
        <div class="col-md-6 col-sm-6 center">
          <p>Línea Temporal de Peso</p>
          <div class="portfolio-item"> <a href="graficaWeightOverTime.php"> <img class="img-portfolio img-responsive" src="images/grafica_weightovertime.jpg" alt=""> </a> </div>
        </div>

      </div>
          
      <!-- /.col-lg-10 --> 
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container --> 
</div>
<div class="testimonials" id="testimonials">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
          <h3>Nuestros Testimonios</h3>
        </div>
      </div>
      <div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10">
        <div id="owl-demo" class="owl-carousel owl-theme test">
          <div class="item">
            <p><sup><i class="fa fa-quote-left"></i></sup>Reciclar es más que una acción, es el valor de la responsabilidad por preservar los recursos naturales.<sup><i class="fa fa-quote-right"></i></sup></p>
            <div class="test-img"> <img src="images/team-img-01.jpg"/>
              <p><strong>Anonimo</strong></p>
            </div>
          </div>
          <div class="item">
            <p><sup><i class="fa fa-quote-left"></i></sup>Reciclar no es una obligación, es TU responsabilidad.<sup><i class="fa fa-quote-right"></i></sup></p>
            <div class="test-img"> <img src="images/team-img-02.jpg"/>
              <p><strong>Anonimo</strong></p>
            </div>
          </div>
          <div class="item">
            <p><sup><i class="fa fa-quote-left"></i></sup>Recicla, Reutiliza, Reduce e inventa…<sup><i class="fa fa-quote-right"></i></sup></p>
            <div class="test-img"> <img src="images/team-img-03.jpg"/>
              <p><strong>Anonimo</strong></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="call-to-action">
  <div class="call-overlay">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-10">
          <div class="subscribe-text">
            <h3>Observa nuestra presentación</h3>
            <p>¡Visualiza el trabajo que hemos logrado y apoyanos a lo grande!</p>
          </div>
        </div>
        <div class="col-md-4 text-center"> <a href="https://docs.google.com/presentation/d/1l7hmgHcI6HCH6Q_RzMAwZeVvDNTVY-84pTMNsJ367wQ/" class="subscribe-button">Ver Ahora</a> </div>
      </div>
    </div>
  </div>
</div>
<div class="about" id="about">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <h3>Acerca de</h3>
      </div>
      <div class="col-md-6">
        <div class="about-text">
          <p>Este proyecto busca promover el reciclaje en el país. Solo en la ciudad
            de Guayaquil se producen miles de toneladas de basura al día, de las cuales menos del
            11% se recicla, esto es un dato alarmante, dado que en pleno siglo XVI nuestros
            desechos siguen siendo depositados en rellenos sanitarios.
            </p>
          <p> Una de las grandes causas
            de este problema social y ambiental es la falta de conciencia y responsabilidad de la
            comunidad, dado que no reciclan sus desechos, sino que estos se mezclan. Por este motivo se diseño un prototipo con tecnologías IoT que permita tener
            un sistema de clasificación automática de basura para que esta pueda reciclarse
            adecuadamente, es decir, que categorice la basura dependiendo del tipo sea papel o metal, para poder separarla correctamente.
            </p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="portfolio-item">  <img class="img-portfolio img-responsive" src="images/guayaquil_reciclaje.jpg" alt=""> </a> </div>
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
          <li><a href="#"><em class="fa fa-twitter"></em></a> </li>
          <li><a href="#"><em class="fa fa-facebook"></em></a> </li>
          <li><a href="#"><em class="fa fa-linkedin"></em></a> </li>
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
<script type="text/javascript" src="js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="js/jquery.countTo.js"></script> 
<script type="text/javascript" src="js/jquery.waypoints.min.js"></script> 
<script>
$(document).ready(function() {
     
      $("#owl-demo").owlCarousel({
     
          navigation : false, // Show next and prev buttons
          slideSpeed : 500,
		  autoPlay : 3000,
          paginationSpeed : 400,
          singleItem:true
     
          // "singleItem:true" is a shortcut for:
          // items : 1, 
          // itemsDesktop : false,
          // itemsDesktopSmall : false,
          // itemsTablet: false,
          // itemsMobile : false
     
      });
     
    });

	/*$('.timer').each(count);*/
	jQuery(function ($) {
      // custom formatting example
      $('.timer').data('countToOptions', {
        formatter: function (value, options) {
          return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        }
      });


  // start all the timers
      $('#testimonials').waypoint(function() {
    $('.timer').each(count);
	});
 
      function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
      }
    });


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
