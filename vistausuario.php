<?php
require('includes/config.php');

//Si no ha iniciado sesión, redirija a la página de inicio de sesión
if (!$user->is_logged_in()) {
	header('Location: login.php');
	exit();
}

//define titulo de la pagina
$title = 'Vista Usuario';

//Incluir plantilla de encabezado
require('layout/header.php');
?>


<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

			<!--LLama al nombre de usuario para mostrarlo cuando entra en una de ellos-->
			<h2>Perfil de
				<?php
				$nombreusuario = $_GET['nombreusuario'];
				echo htmlspecialchars($nombreusuario, ENT_QUOTES);
				?>
			</h2>
			<hr>
			<!--Boton volver para ir a la pagina anterior-->
			<div class="row mt-5">
				<div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" 
				tabindex="5" href="paginausuarios.php">Volver</a></div>
			</div>

			<div id="respuesta"></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
			<div class="row">
				<div class="col-md-10">
					<!--Definimos el color y la opacidad de este -->
					<div style="padding:30px;border:3px solid white; text-align:center;background:rgba(255,255,255,0.4)">
						<p id="idusuario" style="display:none;"><?php echo $_SESSION['usuarioID'] ?> </p>
						<p id="idNombre" style="display:none;"><?php echo $nombreusuario = $_GET['nombreusuario'] ?> </p>
						<p id="idPerfil" style="display:none;"><?php echo $_GET['id'] ?> </p>
						<!--Hacemos la consulta para mostrar todo las imagenes del usuario seleccionado-->
						<?php
						$id = $_GET['id'];
						$cont = 0;
						$stmt = $db->query("SELECT * FROM imagen WHERE usuarioID = " . $id);
						while ($row = $stmt->fetch()) {
							//Definimos el diseño de las imagenes
							echo '<img style="width:100%;height:auto;padding:5px;border:1px solid black;" 
							src="imagenes/' . $row['nombre'] . '">' . "\n";


							//header("Content-type: image/png");
							//Definimos el nombre
							$foto = $row['nombre'];

							//Mostramos la descripcion de la foto
							echo '<br/><br/>' . $row['descripcion'] . '<br/><br/>';
							$idDelaFoto = $row['idfoto'];
							//Creamos boton like 
							echo '<button type="button" id="' . $row['idfoto'] . '" class="comment-ico btn btn-light like" style="height: 39px; margin-bottom: 10px;"><img src="img/app/heart.png">';

							echo '<div style=" position: relative;
							bottom: 25px;" class="contadorLikes">';

										$stmt2 = $db->query("SELECT likes FROM imagen WHERE idfoto =" . $row['idfoto']);
										$contenedor = [];
										while ($row = $stmt2->fetch()) {
											array_push($contenedor, $row['likes']);
										}
										echo $contenedor[0];
							echo '</div></button>';
							$cont++;



					echo'		<div class="detailBox">
							<div class="titleBox">
							  <label>Comentarios</label>
							</div>
							<div class="commentBox">
								<p class="taskDescription">Últimos comentarios.</p>
							</div>
							<div class="actionBox">
								<ul class="commentList">';
								$var3 = $idDelaFoto;
										
										if(isset($_POST["submit".$var3]))  {
											$idUsuario =  $_SESSION['usuarioID'];
											$comentario = $_POST['comentario'];
											//preparamos stmt
											$stmt3 = $db->prepare("INSERT INTO comentarios (idUsuario, comentario, idfoto) VALUES (:var1, :var2, :var3)");
											$stmt3->bindParam(':var1', $var1);
											$stmt3->bindParam(':var2', $var2);
											$stmt3->bindParam(':var3', $var3);
											$var1 = $idUsuario;
											$var2 = $comentario;
											$var3 = $idDelaFoto;

											$stmt3->execute();
									
										}

										if($resultado = $db->query("SELECT * from comentarios WHERE idfoto = $idDelaFoto")) {
											while ($row2 = $resultado->fetch()) {
													echo '<li>';
														echo '<div class="commentText">';
															echo "<p class='nombre'>";
															$resultado2 = $db->query(
																"SELECT username from usuarios WHERE usuarioID = ".$row2['idUsuario']);
															while ($row3 = $resultado2->fetch()) {
																echo $row3['username'];
															}
															
															
															
														echo ": " .$row2['comentario']."</p>";

														if($_SESSION['usuarioID'] == $row2['idUsuario']){
															echo "<button id='".$row2['idcomentarios']."' type='buttom' 
															class='eliminarComentario'>Eliminar</button>";
														}
														
														
														
														
														
														
														echo '</div>';
													echo '</li>';
												
											}
										}else {
											echo "Falló la sentencia"; 
										}
									
							echo'	</ul>
								<form class="form-inline" role="form" action="#" method="post">
									<div class="form-group">
										<textarea class="form-control" maxlength="128" name="comentario" placeHolder="Escriba aquí su comentario máximo 128 caracteres"></textarea>
										<input type="submit" class="btn btn-dark" name="submit'.$var3.'" value="Añadir">
									</div>
								</form>
							</div>
						</div>';


						}
						//Si el usuario no tiene fotos se muestra el siguiente mensaje
						if ($cont == 0) {
							echo '<span>ESTE USUARIO NO TIENE IMAGENES</span>';
						}
						?>


					</div>
				</div>

			</div>
		</div>
		<!--VIDEO---->
		<div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
				<div class="row">
					<div  class="col-md-10">
					<!--Definimos el color y la opacidad de este -->	
						<div style="padding:30px;border:3px solid white; text-align:center;background:rgba(255,255,255,0.4)">
						<!--Hacemos la consulta para mostrar todo los videos del usuario seleccionado-->	
							<?php
							$id=$_GET['id'];
							$cont = 0;
							$stmt = $db->query("SELECT * FROM video WHERE usuarioID = ".$id);
							while ($row = $stmt->fetch()) {
								//Definimos el diseño de las video
								echo '<div id="todo">';
								echo '<video style ="width:100%;height:auto;padding:5px;border:1px solid black;margin-bottom:10px" width="320" height="240" controls>';
								echo '<source src="imagenes/'.$row['nombre'].'" type="video/mp4">';
								echo '<source src="imagenes/'.$row['nombre'].'" type="video/avi">';
								echo '<source src="imagenes/'.$row['nombre'].'" type="video/3gpp">';
								echo '<source src="imagenes/'.$row['nombre'].'" type="video/mpg">';
								echo '<source src="imagenes/'.$row['nombre'].'" type="video/mpeg">';
								echo 'Your browser does not support the video tag.';
								echo '</video>';
								
								//Mostramos la descripcion del video
								echo '<br/><br/>'.$row['descripcion'].'<br/><br/>';	
								$cont++;					
							}		
							//Si el usuario no tiene videos se muestra el siguiente mensaje
							if($cont == 0)
							{
								echo '<span>ESTE USUARIO NO TIENE VIDEOS</span>';	
							}
							?>
							<?php
							//Visitas Contador
							if($_SESSION['usuarioID']!= $id){
								$stmt = $db->query("UPDATE usuarios SET visitas = visitas +1 WHERE usuarioID = " . $id . ";");
							}
							?>

						</div>
					</div>
					
				</div>
			</div>
	</div>
	<script>
		var botonPulsado;
		var botonEliminarPulsado;
		$(document).ready(function() {
			$('.like').click(function() {
				botonPulsado = this;
				var idImagen = $(botonPulsado).attr('id');
				var idUsuario = $('#idusuario').html();
				var idVideo = $(botonPulsado).attr('id');
				

				var nombrePerfil = $('#idNombre').html();
				var idPerfil = $('#idPerfil').html();

				$.ajax({
					type: "POST",
					url: "likes.php?id=" + idImagen + "&accion=annadirlikes",
				}).done(function(resultado) {
					cargarLikes(idImagen);
					
				});
				$.ajax({
					type: "POST",
					url: "likesV.php?id=" + idVideo + "&accion=annadirlikesV",
				}).done(function(resultado) {
					cargarLikes(idVideo);
					
				});
			})

			$('.eliminarComentario').click(function(){
				botonEliminarPulsado = this;
				var idComentario = $(botonEliminarPulsado).attr('id');
				$.ajax({
					type: "POST",
					url: "comentario.php?idComentario=" + idComentario + "&accion=eliminarcomentario",
				}).done(function(resultado) {
					console.log(resultado);
					
				});
			})
		})

		function cargarLikes(idImagen) {
			$.ajax({
				type: "POST",
				url: "likes.php?id=" + idImagen + "&accion=cargarLikes",
			}).done(function(resultado) {
				$(botonPulsado).children('div').html(resultado);
			});
		}

	</script>
</div>
<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>