<?php
require('includes/config.php'); 

$accion = $_REQUEST['accion'];
if($accion == 'eliminarcomentario'){
    $idComentario = $_REQUEST['idComentario'];

    $stmt = $db->prepare("DELETE FROM comentarios WHERE idcomentarios = $idComentario");
    $stmt->execute();

}
