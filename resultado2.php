<?php
require('includes/config.php');

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if (!$user->is_logged_in()) {
	header('Location: login.php');
	exit();
}

//define page title
$title = 'Usuarios';

//Incluir plantilla de encabezado
require('layout/header.php');
?>


<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

			<h2>Resultado de busqueda de usuarios.</h2>

			<div class="row mt-5">
				<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php">Volver</a></div>
			</div>

			<div id="respuesta"></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
			<div class="row">
				<div class="col-md-12">
					<div class="contenedorTodo">
						<?php
						//Recogemos los datos y mostramos la imagen que se ha buscado por descripcion. 
						$buscar = $_GET['buscar'];
						$cont = 0;
						$stmt = $db->query("SELECT * FROM usuarios WHERE username LIKE '%" . $buscar . "%'");
						//var_dump($buscar);
						while ($row = $stmt->fetch()) {
							//echo $row['nombre']."<br />\n";
							$nombre = $row['username'];
							$id = $row['usuarioID'];
							echo "<h4 color='green'><a href='vistausuario.php?id=$id&nombreusuario=$nombre'>$nombre</a></h4>";

							$cont++;
						}
						//Si no hay imagenes se muestra el siguiente mensaje
						if ($cont == 0) {
							echo '<span>NO HAY RESULTADOS</span>';
						}
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>