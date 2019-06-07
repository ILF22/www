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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
	<title><?php if (isset($title)) {
						echo $title;
					} ?></title>
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="style/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style/main.css">
	<link rel="stylesheet" href="style/vistausuario.css">
	<link rel="stylesheet" href="style/paginausuarios.css">
	<link rel="stylesheet" href="style/perfil.css">
	<link rel="stylesheet" href="style/resultado.css">
	<link rel="stylesheet" href="style/resetPassword.css">

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

					<?php
					if (isset($_SESSION['usuarioID'])) {
						//Si la sesion esta abierta, muestra lo siguiente
						if ($_SESSION['usuarioID'] != "") {
							echo '
			<form id="form1" name="form1" method="get" action="">
					<div class="input-group bg-dark search-bar">
					  <input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
					  <div class="input-group-append search-button ">
					  <input type="image" onclick="confirmarBusqueda()" name="submit" width="30px" height="30px"  src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg " tabindex="5">
						<!--<span class="input-group-text" id="basic-addon2"><img width="30px" height="30px"  src="img/lupa.png" alt="Lupa" /></span>-->
					  </div>
					</div>
			</form>
				<li class="nav-item">
					<a class="nav-link" href="http://localhost/www/wsChat/client/" target="_blank">Chat</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="logout.php">Cerrar sesión</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="deleteusuario.php">Eliminar cuenta</a>
				</li>
				<li class="nav-item">
					<a class=" nav-link autor">Irene Jose David</a>';
				  /*  <form id="form2" name="form2" method="get" action="">
                            <div class="input-group bg-dark search-bar">
                                <input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
                                <div class="input-group-append search-button">
                                    <input type="image" onclick="confirmarBusqueda2()" name="submit" width="30px" height="30px" src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg" tabindex="5">
                                </div>
                            </div>
                      </form> */
				echo '</li>
				<!--Boton para editar perfil-->
				<li class="nav-item">
					<a href="perfil.php">
						<img class="imgConf" src="img/app/man.png" alt="Config" width="50" height="50" />
					</a>
				</li>
		';
							//Fucion de busqueda 
							echo "<script type='text/javascript'>
				function confirmarBusqueda(){
					<!--Verifica si el campo esta vacio, o es igual a nulo, o la longuitud es 0-->
					var x = document.forms['form1']['buscar'].value;
                    var y=x.trim();
					if ( y == null || y == '' || y.length == 0 ) {
						alert('Introduce una palabra para buscar.');
						return false;
					}else
					{
						document.getElementById('form1').action = 'resultado.php';
						document.form1.submit(); 
					}				
					
				} ";
				/* function confirmarBusqueda2() {
                    <!--Verifica si el campo esta vacio, o es igual a nulo, o la longuitud es 0-- >
                    var x = document.forms['form2']['buscar'].value;
                    if (x == null || x == '' || x.length == 0) {
                        alert('Introduce una palabra para buscar.');
                        return false;
                    } else {
                        document.getElementById('form2').action = 'resultado2.php';
                        document.form2.submit();
                    }
                } */
				echo "
			  </script>";
						} else {
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
					} else {
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