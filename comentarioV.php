<?php
require('includes/config.php'); 

$accion = $_REQUEST['accion'];
if($accion == 'eliminarcomentarioV'){
    $idComentarioV = $_REQUEST['idComentarioV'];

    $stmt = $db->prepare("DELETE FROM comentariosv WHERE idcomentarios = $idComentarioV");
    $stmt->execute();

}
