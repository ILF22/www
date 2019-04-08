<?php
    require('includes/config.php'); 
    

    $id=$_REQUEST['id'];
    
    $stmt = $db->query("SELECT visitas FROM usuarios WHERE usuarioID = $id" );
    $visitas = '';
    while ($row = $stmt->fetch()) {
        $visitas = $row['visitas'];
    }
    echo $visitas;
?>