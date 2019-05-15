<?php
require('includes/config.php'); 

$accion = $_REQUEST['accion'];
if($accion == 'annadirlikes'){
    $id = $_SESSION['usuarioID'];
    $idImagen = $_REQUEST['id'];

    //Comprobar like
    $stmt = $db->query("SELECT idlikes_usuarios FROM likes WHERE idlikes_usuarios = $id AND idlikes_imagenes = $idImagen");
    $contenedor = [];
    while ($row = $stmt->fetch()) {
        array_push($contenedor, $row['idlikes_usuarios']);
    }

    if (count($contenedor) > 0) {
        $stmt = $db->prepare("DELETE FROM likes WHERE idlikes_usuarios = $id AND idlikes_imagenes = $idImagen");
        $stmt->execute();

        $db->query("UPDATE imagen SET likes = likes -1 WHERE idfoto = " . $idImagen . ";");
    } else {
        $stmt = $db->prepare("INSERT INTO fotografia.likes VALUES (:var1,:var2);");		
        $stmt->bindParam(':var1', $var1);
        $stmt->bindParam(':var2', $var2);

        $var1 = $_SESSION['usuarioID'];
        $var2 = $_REQUEST['id'];		
        $stmt->execute();

        //Sumar like a imagen
        $db->query("UPDATE imagen SET likes = likes +1 WHERE idfoto = " . $idImagen . ";");
    }
    
} elseif($accion == 'cargarLikes'){
    $idImagen = $_REQUEST['id'];
    $stmt = $db->query("SELECT likes FROM imagen WHERE idfoto = $idImagen");
    $contenedor = [];
    while ($row = $stmt->fetch()) {
        echo $row['likes'];
    }

}
