<?php
require('includes/config.php');
//Recoge la variable de la clase pagina usuario
$borrar = $_GET['borrar'];
//Borra el video por id
$sentencia = $db->prepare("DELETE FROM video WHERE idvideo = '$borrar'");

if($sentencia->execute()){
	header("Location: paginausuarios.php");
}else{
	//Si no se ha podido eliminar mandand el siguiente mensaje
	echo "No se ha podido eliminar el video";
}
?>	