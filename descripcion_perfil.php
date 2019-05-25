<?php
    require('includes/config.php');
	
	$descripcion = $_POST["descripcion"];
	
	$sentencia = $db->prepare("UPDATE usuarios SET descripcion = :descripcion WHERE usuarioID = :usuarioID");
						
	$sentencia->bindParam(':usuarioID', $var1);
	$sentencia->bindParam(':descripcion', $var2);
		
	$var1 = $_SESSION['usuarioID'];
	$var2 = $descripcion;					

	if ($sentencia->execute()){
		header('Location: paginausuarios.php');exit;	
	}else{
			echo "<script>alert('Error al subir la imagen');location.href = 'paginausuarios.php'</script>";
	}
	
	
?>