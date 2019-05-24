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
					<div class="contenedorTodo">
						<!--Diseño del contenedor donde se encuentra el contador -->
						<?php
						//Seleciona todo de los usuarios si la cuenta es activa
						$stmt = $db->query("SELECT visitas FROM usuarios WHERE usuarioID = " . $_SESSION['usuarioID']);
						$visitas = '';
						while ($row = $stmt->fetch()) {
							$visitas = $row['visitas'];
						}
						?>
						<div class="visitas">
							<img src="img/app/binoculars.png">
							<p>Visitas</p>
							<img src="img/app/next.png">
							<p class="" data-count="2200"><?php echo $visitas ?></p>
						</div>

						<?php
						//Selecciona todas las imagenes para mostrar del usuario que inicia sesion
						$cont = 0;
						$stmt = $db->query("SELECT * FROM imagen WHERE usuarioID = " . $_SESSION['usuarioID']);
						while ($row = $stmt->fetch()) {
							//Diseño de la imagen
							$row['nombre'] . "<br />\n";
                            echo '<div id="foto"><img class="foto" src="imagenes/' . $row['nombre'] . '">' . "\n";
//                            echo '<div id="ft'.$row['idfoto'].'"><img class="foto" src="imagenes/' . $row['nombre'] . '">' . "\n";
							?>
							<div>
								<!--Muestra la descripcion-->
								<span><?php echo ucwords($row['descripcion']); ?></span>
								<!--On click para borrar la imagen, de aqui va a la funcion confirmar  -->
								<a onclick="confirmar(<?php echo $row['idfoto']; ?>)"><img class="imgEliminar" src="img/app/papelera.png" alt="Papelera" /></a>
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
//                        echo '<div id="vd'.$row['idvideo'].'">';
						echo '<video class="videoUsu" controls>';
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
							<span><?php echo ucwords($row['descripcion']); ?></span>
							<!--On click para borrar el video, de aqui va a la funcion confirmar  -->
							<a onclick="confirmar2(<?php echo $row['idvideo']; ?>)"><img class="imgEliminar" src="img/app/papelera.png" alt="Papelera" /></a>
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
		<div class="col-md-offset-1 col-md-2 col-xs-12 col-sm-12 users-table contenedorListas">
		<div class="listas">
		<form id="form2" name="form2" method="get" action="">
					<div class="input-group bg-dark search-bar">
						<input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
						<div class="input-group-append search-button">
							<input type="image" onclick="confirmarBusqueda2()" name="submit" width="30px" height="30px" src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg" tabindex="5">
							<!--<span class="input-group-text" id="basic-addon2"><img width="30px" height="30px"  src="img/lupa.png" alt="Lupa" /></span>-->
						</div>
					</div>
				</form>
				<h4>Usuarios</h4>
				<?php
				//USUARIOS
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
			<div class="listas">
				<h4>Últimos visitados</h4>
				<?php
				//ULTIMOS VISITADOS
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
			<div class="listas">
				<h4>+ Visitados</h4>
				<?php
				// TOP 5 MAS VISITADOS
                        
                
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
			<div class="listas">
				<h4>+ Puntuados</h4>
				<?php
				//MEJOR PUNTUADOS
                $stmt = $db->query("SELECT *, 'ft' AS tipo FROM imagen UNION select *, 'vd' AS tipo from video order by likes DESC LIMIT 5");               
                

				while ($row = $stmt->fetch()) {


					//para quitar la extension al fichero
					$descripcion = ucwords($row['descripcion']);
                    
                    
					$usuarioID = $row['usuarioID'];
                    $id = $row['idfoto'];
                    
                    $stmt2= $db->query("SELECT username from usuarios where usuarioID=".$usuarioID);
                    $nombre=$stmt2->fetch();
                    $nombre=$nombre['username'];
                   
                    if ($row['tipo']=="vd"){
                        
                        $id="vd".$row['idfoto'];
                                      
                    }                   
               
                     
                    if ($nombre!=null){

                        echo "<h5 color='green'><a href='vistausuario.php?id=$usuarioID&nombreusuario=$nombre/#$id'><img src='img/app/heart.png'>$descripcion ($nombre)</h5>";

                    }
                
                }
				?>
			</div>
		</div>
	</div>
</div>
<!--Diseño del contenedor donde se encuentra el contador -->
<div id="visitasPerfil"><?php echo $_SESSION['usuarioID'] ?></div>
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

	function confirmarBusqueda2() {
		<!--Verifica si el campo esta vacio, o es igual a nulo, o la longuitud es 0-->
		var x = document.forms['form2']['buscar'].value;
		if (x == null || x == '' || x.length == 0) {
			alert('Introduce una palabra para buscar.');
			return false;
		} else {
			document.getElementById('form2').action = 'resultado2.php';
			document.form2.submit();
		}
	}
</script>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>