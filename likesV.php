<?php
require('includes/config.php'); 

$accion = $_REQUEST['accion'];
if($accion == 'annadirlikesV'){
    $id = $_SESSION['usuarioID'];
    $idVideo = $_REQUEST['id'];

    //Comprobar like
    $stmt = $db->query("SELECT idlikes_usuarios FROM likesv WHERE idlikes_usuarios = $id AND idlikes_video = $idVideo");
    $contenedor = [];
    while ($row = $stmt->fetch()) {
        array_push($contenedor, $row['idlikes_usuarios']);
    }

    if (count($contenedor) > 0) {
        $stmt = $db->prepare("DELETE FROM likesv WHERE idlikes_usuarios = $id AND idlikes_video = $idVideo");
        $stmt->execute();

        $db->query("UPDATE video SET likesv = likesv -1 WHERE idvideo = " . $idVideo . ";");
    } else {
        $stmt = $db->prepare("INSERT INTO fotografia.likesv VALUES (:var1,:var2);");		
        $stmt->bindParam(':var1', $var1);
        $stmt->bindParam(':var2', $var2);

        $var1 = $_SESSION['usuarioID'];
        $var2 = $_REQUEST['id'];		
        $stmt->execute();

        //Sumar like a video
        $db->query("UPDATE video SET likesv = likesv +1 WHERE idvideo = " . $idVideo . ";");
    }
    
} elseif($accion == 'cargarLikesV'){
    $idVideo = $_REQUEST['id'];
    $stmt = $db->query("SELECT likesv FROM video WHERE idvideo = $idVideo");
    $contenedor = [];
    while ($row = $stmt->fetch()) {
        echo $row['likesv'];
    }

}
