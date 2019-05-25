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
			<?php
				//Accede a los campos imagen y descripcion del usuario visitado
				$stmt = $db->query("SELECT imagen, descripcion FROM usuarios WHERE usuarioID = " . $_GET['id']);
				while ($row = $stmt->fetch()) {
					//Comprueba si el campo imagen esta vacio para poner o no imagen por defecto
					if(empty($row['imagen'])){
						$imagenP = "usuario.jpg";
					}else{
						$imagenP = $row['imagen'];
					}
					//Comprueba si el campo descripcion esta vacio para poner o no descripcion por defecto
					if(empty($row['descripcion'])){
						$descripcionP = "Descripcion";
					}else{
						$descripcionP = $row['descripcion'];
					}
				}
			?>
			<!--Muestra el perfil del usuario-->
			<table>
				<tr>
					<td rowspan="2"><?php echo '<div id="todo"><img width="150" height="150" src="imagenes/' . $imagenP . '">' . "\n"; ?></td>
					<td><h2>Perfil de <?php echo htmlspecialchars($_GET['nombreusuario'], ENT_QUOTES); ?></h2></td>
				</tr>
				<tr>
					<td><h5><?php echo $descripcionP;?></h5></td>
				</tr>
			</table>
            
            <hr>
            <!--Boton volver para ir a la pagina anterior-->
            <div class="row mt-5">
                <div class="col-xs-6 col-md-6"><a class="btn btn-light btn-block btn-lg" tabindex="5" href="paginausuarios.php">Volver</a></div>
            </div>

            <div id="respuesta"></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-sm-offset-12 col-md-offset-12 mt-5">
            <div class="row">
                <div class="col-md-12">
                    <!--Definimos el color y la opacidad de este -->
                    <div class="contenedorTodo">
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
							echo '<img id="' . $row['idfoto'] . '" class="foto"
							src="imagenes/' . $row['nombre'] . '">' . "\n";

							//Definimos el nombre
							$foto = $row['nombre'];

							//Mostramos la descripcion de la foto
							echo '<br/><br/>' . $row['descripcion'] . '<br/><br/>';
							$idDelaFoto = $row['idfoto'];

							//Creamos boton like 
							echo '<button type="button" id="' . $row['idfoto'] . '" class="comment-ico btn btn-light like"><img src="img/app/heart.png">';

							echo '<div class="contadorLikes">';

							$stmt2 = $db->query("SELECT likes FROM imagen WHERE idfoto =" . $row['idfoto']);
							$contenedor = [];
							while ($row = $stmt2->fetch()) {
								array_push($contenedor, $row['likes']);
							}
							echo $contenedor[0];
							echo '</div></button>';
							$cont++;

							echo '<div class="detailBox" >
							<div class="commentBox">
								<p class="taskDescription"> Comentarios.</p>
							</div>
							<div class="actionBox">
								<div class="cajaComent">
								<ul class="commentList" id="ul' . $idDelaFoto . '">';
							$var3 = $idDelaFoto;

							if (isset($_POST["submit" . $var3])) {
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

							if ($resultado = $db->query("SELECT * from comentarios WHERE idfoto = $idDelaFoto")) {
								while ($row2 = $resultado->fetch()) {
									echo '<li>';
									echo '<div class="commentText">';
									echo "<p class='nombre'>";
									$resultado2 = $db->query(
										"SELECT username from usuarios WHERE usuarioID = " . $row2['idUsuario']
									);
									while ($row3 = $resultado2->fetch()) {
										echo $row3['username'];
									}



									echo ": " . $row2['comentario'] . "</p>";

									if ($_SESSION['usuarioID'] == $row2['idUsuario']) {
										echo "<p id='" . $idDelaFoto . "' class='pInvisible'></p>
															<button id='" . $row2['idcomentarios'] . "' type='buttom' 
															class='comment-ico btn btn-light eliminarComentario'>
															<br>
															<img class='imgPapelera' src='img/app/remove.png'>
															</button>";
									}

									echo '</div>';
									echo '</li>';
								}
							} else {
								echo "Falló la sentencia";
							}

							echo '	</ul></div>
								<form class="form-inline" role="form" action="#" method="post">
									<div class="form-group">
									<input type="text" class="form-control" maxlength="128" name="comentario" placeHolder="Añadir comentario.">
										<input type="submit" class="btn btn-dark" name="submit' . $var3 . '" value="Añadir">
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

                        <!-----------------------------------------------------VIDEO-------------------------------------------------------------->

                        <!--Hacemos la consulta para mostrar todo los videos del usuario seleccionado-->
                        <?php
						$id = $_GET['id'];
						$cont = 0;
						$stmt = $db->query("SELECT * FROM video WHERE usuarioID = " . $id);
						while ($row = $stmt->fetch()) {
							//Definimos el diseño de las video
//							echo '<div id="todo">';
                            echo '<div id="vd'.$row['idvideo'].'">';
							echo '<video class="video" controls>';
							echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mp4">';
							echo '<source src="imagenes/' . $row['nombre'] . '" type="video/avi">';
							echo '<source src="imagenes/' . $row['nombre'] . '" type="video/3gpp">';
							echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpg">';
							echo '<source src="imagenes/' . $row['nombre'] . '" type="video/mpeg">';
							echo 'Your browser does not support the video tag.';
							echo '</video>';

							//Mostramos la descripcion del video
							echo '<br/><br/>' . $row['descripcion'] . '<br/><br/>';

							echo '<button type="button" id="' . $row['idvideo'] . '" class="comment-ico btn btn-light likeVideo">
							<img src="img/app/heart.png">';
							$idVD = $row['idvideo'];

							echo '<div class="contadorLikes">';

							$stmt4 = $db->query("SELECT likes FROM video WHERE idvideo =" . $row['idvideo']);
							$contenedor = [];
							while ($row = $stmt4->fetch()) {
								array_push($contenedor, $row['likes']);
							}
							echo $contenedor[0];
							echo '</div></button>';

							$cont++;

							/*COMENTARIO VIDEO*/

							echo '<div class="detailBox">
							<div class="commentBox">
								<p class="taskDescription"> Comentarios.</p>
							</div>
							<div class="actionBox">
								<div class="cajaComent">
								<ul class="commentList" id="ulV' . $idVD . '">';
							$var3 = $idVD;

							if (isset($_POST["submitV" . $var3])) {
								$idUsuario =  $_SESSION['usuarioID'];
								$comentarioV = $_POST['comentarioV'];
								//preparamos stmt
								$stmt5 = $db->prepare("INSERT INTO comentariosv (idUsuario, comentario, idvideo) VALUES (:varV1, :varV2, :varV3)");
								$stmt5->bindParam(':varV1', $var1);
								$stmt5->bindParam(':varV2', $var2);
								$stmt5->bindParam(':varV3', $var3);
								$var1 = $idUsuario;
								$var2 = $comentarioV;
								$var3 = $idVD;

								$stmt5->execute();
							}

							if ($resultado3 = $db->query("SELECT * from comentariosv WHERE idvideo =$idVD")) {
								while ($row2 = $resultado3->fetch()) {
									echo '<li>';
									echo '<div class="commentText">';
									echo "<p class='nombre'>";
									$resultado4 = $db->query(
										"SELECT username from usuarios WHERE usuarioID = " . $row2['idUsuario']
									);
									while ($row3 = $resultado4->fetch()) {
										echo $row3['username'];
									}



									echo ": " . $row2['comentario'] . "</p>";

									if ($_SESSION['usuarioID'] == $row2['idUsuario']) {
										echo "<p id='" . $idVD . "' class='pInvisible'></p>
															<button id='" . $row2['idcomentarios'] . "' type='buttom' 
															class='comment-ico btn btn-light eliminarComentarioV'><img class='imgPapelera' src='img/app/remove.png'></button>";
									}

									echo '</div>';
									echo '</li>';
								}
							} else {
								echo "Falló la sentencia";
							}

							echo '	</ul></div>
								<form class="form-inline" role="form" action="#" method="post">
									<div class="form-group">
									<input type="text" class="form-control" maxlength="128" name="comentarioV" placeHolder="Añadir comentario.">
										<input type="submit" class="btn btn-dark" name="submitV' . $var3 . '" value="Añadir">
									</div>
								</form>
							</div>
						</div>';
						}

						//Si el usuario no tiene videos se muestra el siguiente mensaje
						if ($cont == 0) {
							echo '<span>ESTE USUARIO NO TIENE VIDEOS</span>';
						}
						?>

                        <?php
						//Visitas Contador
						if ($_SESSION['usuarioID'] != $id) {
							$stmt = $db->query("UPDATE usuarios SET visitas = visitas +1 WHERE usuarioID = " . $id . ";");
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/likes.js"></script>
    <script src="js/eliminarComentario.js"></script>
</div>
<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>