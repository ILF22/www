<?php
require('includes/config.php');
//Recoge la variable de la clase pagina usuario
$borrar = $_GET['borrar'];
//Borra la imagen por id
$sentencia = $db->prepare("DELETE FROM imagen WHERE idfoto = '$borrar'");

if($sentencia->execute()){
	header("Location: paginausuarios.php");
}else{
	//Si no se ha podido eliminar mandanda el siguiente mensaje
	echo "No se ha podido eliminar la imagen";
}
?>	