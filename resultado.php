<?php
require('includes/config.php');

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if (!$user->is_logged_in()) {
	header('Location: login.php');
	exit();
}

//define page title
$title = 'Multimedia';

//Incluir plantilla de encabezado
require('layout/header.php');
?>

<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

			<h2>Resultados de busqueda de multimedia y usuarios.</h2>

			<div class="row mt-5">
				<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php">Volver</a></div>
			</div>

			<div id="respuesta"></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
			<div class="row">
				<div class="col-md-12">
					<div class="contenedorTodo">
					<div >
						<?php
						//Recogemos los datos y mostramos la imagen que se ha buscado por descripcion. 
						$buscar = trim(strtoupper($_GET['buscar']));
                        if ($buscar!=""){
						$cont = 0;
				      //$stmt = $db->query("SELECT * FROM imagen WHERE descripcion LIKE '%" . $buscar);
                       $stmt = $db->query("SELECT * FROM imagen WHERE UPPER(descripcion) LIKE '%" . $buscar . "%'");

						while ($row = $stmt->fetch()) {
							//echo $row['nombre']."<br />\n";
							echo '<img class="foto" src="imagenes/' . $row['nombre'] . '">' . "\n";


							//header("Content-type: image/png");
							$foto = $row['nombre'];

							//Mostramos la descripcion de la foto
							echo '<br/><br/>' . ucfirst($row['descripcion']) . '<br/><br/>';
							$cont++;
						}
						?>
					</div>
					<div >
						<?php 
						//Video
						$stmt = $db->query("SELECT * FROM video WHERE UPPER(descripcion) LIKE '%" . $buscar . "%'");
						while ($row = $stmt->fetch()) {
							//echo $row['nombre']."<br />\n";
							echo '<video class="videoUsu" controls>';
                            echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mp4">';
                            echo '<source src="imagenes/' . $row['nombre'] . '" type="video/avi">';
                            echo '<source src="imagenes/' . $row['nombre'] . '" type="video/3gpp">';
                            echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpg">';
                            echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpeg">';
                            echo 'Your browser does not support the video tag.';
                            echo '</video>';


							//Mostramos la descripcion de la foto
							echo '<br/><br/>' . ucfirst($row['descripcion']) . '<br/><br/>';
							$cont++;
						}
					?>
					</div>
					<div >
						<?php
						//Usuarios
						$stmt = $db->query("SELECT * FROM usuarios WHERE UPPER(username) LIKE '%" . $buscar . "%'");
						//var_dump($buscar);
						while ($row = $stmt->fetch()) {
							//echo $row['nombre']."<br />\n";
							$nombre = $row['username'];
							$id = $row['usuarioID'];
							if(empty($row['imagen'])){
								$imagen = "usuario.jpg";
							}else{
								$imagen = $row['imagen'];
							}
							
							echo '<img width="150" height="150" src="imagenes/' . $imagen . '">' . "\n";
							echo "<h4 color='green'><a href='vistausuario.php?id=$id&nombreusuario=$nombre'>$nombre</a></h4>";

							$cont++;
						}
                            
						//Si no hay imagenes se muestra el siguiente mensaje
						if ($cont == 0) {
							echo '<span>NO HAY RESULTADOS</span>';
						}
                            
                        }else{
                            echo '<span>vacio</span>';
                            
                        }
                            
                            
						?>
					</div>
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