<?php require('includes/config.php');


/*$rand = range(1, 10);
shuffle($rand);
foreach ($rand as $val) {
	echo $val . '<br />';
}*/
//Array aleatorio para la muestra de imagenes en el carrusel
$valores = array();
$max_num = 5;
$x=0;
while($x<$max_num) {	
  $num_aleatorio = rand(1,5);
	if (!in_array($num_aleatorio, $valores)) {
		array_push($valores,$num_aleatorio);
		$x++;
	} 
}
//for ($x=0;$x<count($valores);$x++)
  //echo $valores[$x]."<br/>";


//Definir el título de la página
$title = 'Inicio';

//Incluir plantilla de encabezado
require('layout/header.php');

/**if ( isset( $_GET['action'] ) && $_GET['action'] == 'deleted') {
	echo "<script>alert('Usuario eliminado');</script>";
}*/

?>
	    <!-- Contenido de página -->

      <div class="container">
        <div class="row">
          <div class="col-lg-6">
			<form role="form" method="post" action="" autocomplete="off">
				<h1 class="mt-5 text-center">Live Your Dreams</h1>
				<h3 class="mt-5 text-center">Disfruta de tus fotografias y vive tus sueños, subiendolas a tu página. </h3>
				<div class="row mt-5">
					<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg mb-3" tabindex="5" href="login.php" >Iniciar sesión</a></div>
					<div class="col-xs-6 col-md-6"><a class="btn btn-secondary btn-block btn-lg" tabindex="5" href="registro.php">Registro</a></div>
				</div>
			</form>
          </div>
        </div>
      </div>
	  
	<div class="container mt-5 mb-5 item img">	
	  <!-- Carrusel -->
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			</ol>
		  
		  <div class="carousel-inner" role="listbox">
			<div class="carousel-item active">
				<img class="d-block img-fluid text-center" src="img/<?php echo $valores[0]; ?>.jpeg" alt="First slide">
			</div>
			<div class="carousel-item">
				<img class="d-block img-fluid text-center" src="img/<?php echo $valores[1]; ?>.jpeg" alt="Second slide">
			</div>
			<div class="carousel-item">
				<img class="d-block img-fluid text-center" src="img/<?php echo $valores[2]; ?>.jpeg" alt="Third slide">
			</div>
		  </div>
		  
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		  </a>
		</div>
	</div>


<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>
