<?php require('includes/config.php');

//Cerrar sesión
$user->logout(); 

//Registrado, vuleve a la pagina de indice.
header('Location: index.php');
exit;
?>