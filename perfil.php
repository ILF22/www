<?php
require('includes/config.php');

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if (!$user->is_logged_in()) {
	header('Location: login.php');
	exit();
}

//define page title
$title = 'Editar Perfil';

//Incluir plantilla de encabezado
require('layout/header.php');
?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3 mb-5">
		
		<h2>Editar perfil de <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
		<hr>
			<!--Formulario de modificacion de imagen-->
			<form id="uploadimage" method="POST" action="imagen_perfil.php" enctype="multipart/form-data">
				<!--Añade la imagen-->
				<h5 class="subtitulo"><label>Para modificar la imagen del perfil:</label></h5>
				
				<input type="file" name="file" id="file" required />
				<label for="file" class="seleccionImg">
					<i class="material-icons">
						add_photo_alternate
					</i> &nbsp;
					Selecciona una imagen.
				</label>
				<div class="row mt-3 nomargin"></div>
				<div class="row">
					<!--Boton de modificacion de la imagen-->
					<div class="col-xs-6 col-md-12"><input type="submit" name="submit" value="Modificar" class="mt-2 btn btn-light btn-block btn-lg" tabindex="5" /></div>
				</div>
			</form>
			
			<br><hr><br/>
			<!--Formulario de modificacion de descripcion-->
			<form id="uploadimage" method="POST" action="descripcion_perfil.php" enctype="multipart/form-data">
				<h5 class="subtitulo"><label>Para modificar la descripcion del perfil:</label></h5>
				<div class="row mt-3 nomargin">
					<!--Añade la descripcion -->
					<input type="text" name="descripcion" id="des" class="form-control col-xs-12 col-md-12 mb-3" placeholder="Descripción..."  />
				</div>
				<div class="row">
					<!--Boton de modificacion de descripcion-->
					<div class="col-xs-6 col-md-12"><input type="submit" name="submit" value="Modificar" class="mt-2 btn btn-light btn-block btn-lg" tabindex="5" /></div>
				</div>
			</form>
			<!--Boton volver a la pagina usuario-->
			<div class="row mt-5">
					<div class="col-xs-6 col-md-12"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php">Volver</a></div>
				</div>
		</div>
	</div>
</div>
<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>