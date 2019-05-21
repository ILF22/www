<?php
require('includes/config.php');

$accion = $_REQUEST['accion'];
if ($accion == 'eliminarcomentarioV') {
    $idComentarioV = $_REQUEST['idComentarioV'];

    $stmt = $db->prepare("DELETE FROM comentariosv WHERE idcomentarios = $idComentarioV");
    $stmt->execute();
} else if ($accion == 'cargarComentariosV') {
    $idVideo = $_REQUEST['idVideo'];
 
    $_html = '';
    if ($stmt1 = $db->query("SELECT * from comentariosv WHERE idvideo = $idVideo")) {
        while ($row2 = $stmt1->fetch()) {
            $_html .= '<li><div class="commentText" style="display: flex; 
            position: relative; 
            align-items: end;"><p class="nombre" style="margin-top:6px;">';
            $resultado4 = $db->query(
                "SELECT username from usuarios WHERE usuarioID = " . $row2['idUsuario']
            );
            while ($row3 = $resultado4->fetch()) {
                $_html .= $row3['username'];
            }

            $_html .= ": " . $row2['comentario'] . "</p>";

            if ($_SESSION['usuarioID'] == $row2['idUsuario']) {
                $_html .= "<p id='" . $idVideo . "' style='display:none'></p>
                <button id='" . $row2['idcomentarios'] . "' type='buttom' 
                class='comment-ico btn btn-light eliminarComentarioV'><img style='height: 39px; margin-bottom: 10px;' src='img/app/remove.png'></button>";
            }

            $_html .= '</div>
            </li>';
        }
    }
    echo $_html;
}
