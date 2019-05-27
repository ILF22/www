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
            <h2 style="font-weight: bold;">¡Bienvenido! <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
            <?php
            //Accede a los campos imagen y descripcion del usuario
            $stmt = $db->query("SELECT imagen, descripcion FROM usuarios WHERE usuarioID = " . $_SESSION['usuarioID']);
            while ($row = $stmt->fetch()) {
                //Comprueba si el campo imagen esta vacio para poner o no imagen por defecto
                if (empty($row['imagen'])) {
                    $imagenP = "usuario.jpg";
                } else {
                    $imagenP = $row['imagen'];
                }
                //Comprueba si el campo descripcion esta vacio para poner o no descripcion por defecto
                if (empty($row['descripcion'])) {
                    $descripcionP = "Descripcion";
                } else {
                    $descripcionP = $row['descripcion'];
                }
            }
            ?>
            <!--Muestra el perfil del usuario-->
            <div class="col-md-6">
                <div class="row" style="display: inline-block;">
                    <div style="">
                        <?php echo '<img class="imgPerfil" src="imagenes/' . $imagenP . '">' . "\n"; ?>
                    </div>
                    <div>
                        <h4 style="font-style:italic;">
                            <?php echo $descripcionP; ?>
                        </h4>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-6">
                <!--form de la subida de la imagen -->
                <form id="uploadimage" method="POST" action="imagen-ajax.php" enctype="multipart/form-data">
                    <h5><label>Subir imagen o video:</label></h5>
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
        </div>

        <!--Diseño del contenedor donde se muestran las imagenes -->
        <div class="col-xs-2 col-sm-2 col-md-12 col-sm-offset-12 col-md-offset-12">
            <div class="row">
                <div class="col-md-offset-1 col-md-2 col-xs-14 col-sm-14 users-table contenedorListas">
                    <div class="listas">
                        <form id="form2" name="form2" method="get" action="">
                            <div class="input-group bg-dark search-bar">
                                <input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
                                <div class="input-group-append search-button">
                                    <input type="image" onclick="confirmarBusqueda2()" name="submit" width="30px" height="30px" src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg" tabindex="5">
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



                </div>
                <div class="col-md-8">
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
                <!--<form id="form2" name="form2" method="get" action="">
					<div class="input-group bg-dark search-bar">
						<input type="text" class="form-control search-input" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="basic-addon2" name="buscar">
						<div class="input-group-append search-button">
							<input type="image" onclick="confirmarBusqueda2()" name="submit" width="30px" height="30px" src="img/app/lupa.png" class="btn btn-secondary btn-block btn-lg" tabindex="5">

						</div>
					</div>
				</form> -->
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
                <h4><img src='img/app/calendario.png'>Últimos visitados</h4>
                <?php
                //ULTIMOS VISITADOS
                $stmt = $db->query("SELECT * FROM usuarios WHERE active = 'Yes'");
                while ($row = $stmt->fetch()) {
                    $nombre = $row['username'];
                    $id = $row['usuarioID'];

                    if ($id != $_SESSION['usuarioID']) {
                        echo "<h5 color='green'><a href='vistausuario.php?id=$id&nombreusuario=$nombre'>$nombre</a></h5>";
                    }
                }
                ?>
            </div>
            <div class="listas">
                <h4><img src='img/app/binoculars.png'> Más Visitados</h4>
                <?php
                // TOP 5 MAS VISITADOS


                $stmt = $db->query("SELECT * FROM usuarios WHERE active = 'Yes'");

                while ($row = $stmt->fetch()) {
                    $nombre = $row['username'];
                    $id = $row['usuarioID'];
                    $nvisitas = $row['visitas'];
                    if ($id != $_SESSION['usuarioID']) {
                        echo "<h5 color='green'><a href='vistausuario.php?id=$id&nombreusuario=$nombre'>$nvisitas.  $nombre</a></h5>";
                    }
                }
                ?>
            </div>
            <div class="listas">
                <h4> <img src='img/app/heart.png'> Mejor Puntuados</h4>
                <?php
                //MEJOR PUNTUADOS
                $stmt = $db->query("SELECT *, 'ft' AS tipo FROM imagen UNION select *, 'vd' AS tipo from video order by likes DESC LIMIT 5");


                while ($row = $stmt->fetch()) {


                    //para quitar la extension al fichero
                    $descripcion = ucwords($row['descripcion']);
                    $usuarioID = $row['usuarioID'];
                    $id = $row['idfoto'];
                    $nlike = $row['likes'];

                    //QUITAR LA LLAMADA A BBDD Y CAMBIAR LA PRIMERA SELECT!!!!!!!!!!!!!!

                    $stmt2 = $db->query("SELECT username from usuarios where usuarioID=" . $usuarioID);
                    $nombre = $stmt2->fetch();
                    $nombre = $nombre['username'];

                    if ($row['tipo'] == "vd") {
                        $id = "vd" . $row['idfoto'];
                    }


                    if ($nombre != null) {
                        echo '<div class="contadorLikes2">';
                        echo "<h5 color='green'><a href='vistausuario.php?id=$usuarioID&nombreusuario=$nombre/#$id'>$nlike.  $descripcion ($nombre)</h5>";
                        echo '</div>';
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
        <!--Verifica si el campo esta vacio, o es igual a nulo, o la longuitud es 0-- >
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