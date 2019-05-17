<?php
require('includes/config.php');

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if (!$user->is_logged_in()) {
	header('Location: login.php');
	exit();
}

//define page title
$title = 'Pagina Usuario';

//Incluir plantilla de encabezado
require('layout/header.php');
?>

<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 mb-5">
			<!--Muestra el nombre de la sesion con la que has iniciado-->
			<h2>¡Bienvenido! <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
			<hr>
			<!--form de la subida de la imagen -->
			<form id="uploadimage" method="POST" action="imagen-ajax.php" enctype="multipart/form-data">
				<input type="file" name="file" id="file" class="btn btn-light btn-block btn-sm" required />
				<div class="row mt-3 nomargin">
					<!--Añade la descripcion de la imagen -->
					<input type="text" name="descripcion" id="des" class="form-control col-xs-12 col-md-12 mb-3" placeholder="Descripción...">
				</div>
				<div class="row">
					<!--Boton de subida de la imagen-->
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Subir" class="mt-2 btn btn-light btn-block btn-lg" tabindex="5" /></div>
				</div>
			</form>
			<div id="respuesta"></div>
		</div>
		<!--Diseño del contenedor donde se muestran las imagenes -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12">
			<div class="row">
				<div class="col-md-10">
					<div style="padding:30px;border:3px solid white; text-align:center;background:rgba(255,255,255,0.4)">

						<!--Diseño del contenedor donde se encuentra el contador -->
						<?php
						//Seleciona todo de los usuarios si la cuenta es activa
						$stmt = $db->query("SELECT visitas FROM usuarios WHERE usuarioID = " . $_SESSION['usuarioID']);
						$visitas = '';
						while ($row = $stmt->fetch()) {
							$visitas = $row['visitas'];
						}
						?><div>
							<img src="img/app/binoculars.png">
							<p>Visualizaciones</p>
							<p class="" data-count="2200"><?php echo $visitas ?></p>
						</div>




						<?php
						//Selecciona todas las imagenes para mostrar del usuario que inicia sesion
						$cont = 0;
						$stmt = $db->query("SELECT * FROM imagen WHERE usuarioID = " . $_SESSION['usuarioID']);
						while ($row = $stmt->fetch()) {
							//Disño de la imagen
							$row['nombre'] . "<br />\n";
							echo '<div id="todo"><img style=" width:100%;height:auto;padding:5px;border:1px solid black;margin-bottom:10px" src="imagenes/' . $row['nombre'] . '">' . "\n";
							?>
							<div>
								<!--Muestra la descripcion-->
								<span><?php echo $row['descripcion']; ?></span>
								<!--On click para borrar la imagen, de aqui va a la funcion confirmar  -->
								<a onclick="confirmar(<?php echo $row['idfoto']; ?>)"><img width="30px" height="30px" src="img/app/papelera.png" alt="Papelera" /></a>
							</div></br></br>
						</div>
						<?php


						$cont++;
					}
					//Si no tiene ninguna imagen, muestra el siguiente mensaje
					if ($cont == 0) {
						echo '<span>NO TIENES IMAGENES</span>';
					}
					?>
					<?php
					//Selecciona todos los videos para mostrar del usuario que inicia sesion
					$cont = 0;
					$stmt = $db->query("SELECT * FROM video WHERE usuarioID = " . $_SESSION['usuarioID']);
					while ($row = $stmt->fetch()) {
						//Disño del video
						$row['nombre'] . "<br />\n";
						echo '<div id="todo">';
						echo '<video style ="width:100%;height:auto;padding:5px;border:1px solid black;margin-bottom:10px" width="320" height="240" controls>';
						echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mp4">';
						echo '<source src="imagenes/' . $row['nombre'] . '" type="video/avi">';
						echo '<source src="imagenes/' . $row['nombre'] . '" type="video/3gpp">';
						echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpg">';
						echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpeg">';
						echo 'Your browser does not support the video tag.';
						echo '</video>';
						?>
						<div>
							<!--Muestra la descripcion-->
							<span><?php echo $row['descripcion']; ?></span>
							<!--On click para borrar el video, de aqui va a la funcion confirmar  -->
							<a onclick="confirmar2(<?php echo $row['idvideo']; ?>)"><img width="30px" height="30px" src="img/app/papelera.png" alt="Papelera" /></a>
						</div></br></br>
					</div>
					<?php

					$cont++;
				}
				//Si no tiene ningun video, muestra el siguiente mensaje
				if ($cont == 0) {
					echo '<span>NO TIENES VIDEOS</span>';
				}
				?>
			</div>
		</div>
		<!--Diseño del contenedor donde se encuentran los usuarios con cuenta activa -->
		<div class="col-md-offset-1 col-md-2 col-xs-12 col-sm-12 users-table" style=" color:black;text-align:right;">
			<div style="padding:30px 10px 30px 0;border:3px solid white; background:rgba(255,255,255,0.4)">
				<h2>Usuarios</h2>
				<?php
				//Seleciona todo de los usuarios si la cuenta es activa
				$stmt = $db->query("SELECT * FROM usuarios WHERE active = 'Yes'");
				while ($row = $stmt->fetch()) {
					$nombre = $row['username'];
					$id = $row['usuarioID'];

					if ($id != $_SESSION['usuarioID']) {
						echo "<h4 color='green'><a href='vistausuario.php?id=$id&nombreusuario=$nombre'>$nombre</a></h4>";
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
	$(document).ready(function() {
		setInterval(cargaVisitas, 300)
	})

	function cargaVisitas() {
		var id = $('#visitasPerfil').text();

		$.ajax({
			type: 'post',
			url: 'controller.php?accion=visita&id=' + id
		}).done(function(infoVisitas) {
			$('#Contttt').text(infoVisitas);
		})
	}
</script>
<script>
	//Funcion para borrar imagen.
	function confirmar(id) {
		var r = confirm("¿Confirma que desea eliminar la imagen?");
		if (r == false) {
			return false;
		} else {
			location.href = "borrarimagen.php?borrar=" + id;
			return true;
		}
	}

	function confirmar2(id) {
		var r = confirm("¿Confirma que desea eliminar el video?");
		if (r == false) {
			return false;
		} else {
			location.href = "borrarvideo.php?borrar=" + id;
			return true;
		}
	}
</script>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>