<?php
require('includes/config.php');

//Recoger valores de la url
$usuarioID = trim($_GET['x']);
$active = trim($_GET['y']);

//Si id es el número y el token activo no está vacío, continúa
if(is_numeric($usuarioID) && !empty($active)){

	//El registro de los class de actualización establece la columna activa en Sí, donde el ID de miembro y el valor activo coinciden con los que se proporcionan en la matriz
	$stmt = $db->prepare("UPDATE usuarios SET active = 'Yes' WHERE usuarioID = :usuarioID AND active = :active");
	$stmt->execute(array(
		':usuarioID' => $usuarioID,
		':active' => $active
	));

	//Si la fila se actualizó redirigir al usuario
	if($stmt->rowCount() == 1){
		//Redirigir a la página de inicio de sesión
		header('Location: login.php?action=active');
		exit;

	} else {
		echo "Su cuenta no pudo ser activada."; 
	}
	
}
?>