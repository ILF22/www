<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/png" href="img/app/camaratrans.png" />
    <title><?php if(isset($title)){ echo $title; }?></title>
    <!-- Bootstrap core CSS -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/main.css">

    <script src="javascript/jquery.min.js"></script>
    <script src="javascript/bootstrap.bundle.min.js"></script>	
	
</head>
<body>
    <!-- Navegacion -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">Live Your Dreams</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
			
            <!--<li class="nav-item active">
              <a class="nav-link" href="/www/loginregister-master/">Inicio
                <span class="sr-only">(current)</span>
              </a>
            </li>-->
			

			
<?php
if( isset($_SESSION['usuarioID'])){	
	//Si la sesion esta abierta, muestra lo siguiente
	if( $_SESSION['usuarioID'] != ""){
		echo '
			<form id="form1" name="form1" method="get" action="">
					<div class="input-group bg-dark search-bar">
					  <input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
					  <div class="input-group-append search-button">
					  <input type="image" onclick="confirmarBusqueda()" name="submit" width="30px" height="30px"  src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg" tabindex="5">
						<!--<span class="input-group-text" id="basic-addon2"><img width="30px" height="30px"  src="img/lupa.png" alt="Lupa" /></span>-->
					  </div>
					</div>
			</form>
				<li class="nav-item">
				  <a class="nav-link" href="logout.php">Cerrar sesión</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="deleteusuario.php">Eliminar cuenta</a>
				</li>
				<li class="nav-item">
				  <a class=" nav-link autor">Irene Jose David</a>
				</li>
		';	
		//$message = "Introduce una palabra para buscar.";
		//Fucion de busqueda 
		echo "<script type='text/javascript'>
				function confirmarBusqueda(){
					<!--Verifica si el campo esta vacio, o es igual a nulo, o la longuitud es 0-->
					var x = document.forms['form1']['buscar'].value;
					if ( x == null || x == '' || x.length == 0 ) {
						alert('Introduce una palabra para buscar.');
						return false;
					}else
					{
						document.getElementById('form1').action = 'resultado.php';
						document.form1.submit(); 
					}				
					
				}
			  </script>";

	}else{
	//Si no se ha iniciado sesion muestra lo siguiente
		echo '        
				<li class="nav-item">
				  <a class="nav-link" href="login.php">Iniciar sesión</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="registro.php">Registro</a>
				</li>
				
				';		
	}
	//Si no se ha iniciado sesion muestra lo siguiente
}else{
		echo '        
				<li class="nav-item">
				  <a class="nav-link" href="login.php">Iniciar sesión</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="registro.php">Registro</a>
				</li>
				<li class="nav-item">
				  <a class=" nav-link autor">Irene Jose David</a>
				</li>
				';		
}

?>			
			
          </ul>
        </div>
      </div>
    </nav>
<section>