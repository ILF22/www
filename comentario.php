<?php
require('includes/config.php');

$accion = $_REQUEST['accion'];
if ($accion == 'eliminarcomentario') {
    $idComentario = $_REQUEST['idComentario'];

    $stmt = $db->prepare("DELETE FROM comentarios WHERE idcomentarios = $idComentario");
    $stmt->execute();
} else if ($accion == 'cargarComentarios') {
    $idFoto = $_REQUEST['idFoto'];
    $_html = '';
    if ($stmt1 = $db->query("SELECT * FROM comentarios WHERE idfoto = $idFoto")) {
        while ($row2 = $stmt1->fetch()) {
            $_html .= '<li><div class="commentText" style="display: flex;
            position: relative;
            align-items: end;"><p class="nombre" style="margin-top:6px;">';
            $resultado2 = $db->query(
                "SELECT username from usuarios WHERE usuarioID = " . $row2['idUsuario']
            );
            while ($row3 = $resultado2->fetch()) {
                $_html .= $row3['username'];
            }
            $_html .= ": " . $row2['comentario'] . '</p>';

            if ($_SESSION['usuarioID'] == $row2['idUsuario']) {
                $_html .= "<p id='" . $idFoto . "' style='display:none'></p>
                <button id='" . $row2['idcomentarios'] . "' type='buttom' 
                class='comment-ico btn btn-light eliminarComentario'><br><img style='height: 39px; margin-bottom: 10px;' src='img/app/remove.png'></button>";
            }

            $_html .= '</div>
            </li>';
        }
    }

    echo $_html;
}
