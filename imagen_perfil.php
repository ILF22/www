<?php
    require('includes/config.php');
	
	if (isset($_FILES["file"])){		
	    $file = $_FILES["file"];
	    $nombre = $file["name"];
	    $tipo = $file["type"];
	    $ruta_provisional = $file["tmp_name"];
	    $size = $file["size"];
	    $dimensiones = getimagesize($ruta_provisional);
	    $width = $dimensiones[0];
	    $height = $dimensiones[1];
	    $carpeta = "imagenes/";
		
		
		if ($tipo == 'image/jpg' || $tipo == 'image/jpeg' || $tipo == 'image/png' || $tipo == 'image/gif'){
	        if($size < 5000*3500){
				if($width < 5000 || $height < 3500){
					if($width > 60 || $height > 60){
						
						$sentencia = $db->prepare("UPDATE usuarios SET imagen = :nombre WHERE usuarioID = :usuarioID");
						
						$sentencia->bindParam(':usuarioID', $var1);
						$sentencia->bindParam(':nombre', $var2);
		
						$var1 = $_SESSION['usuarioID'];
						$var2 = $nombre;					

						if ($sentencia->execute()){
							$src = $carpeta.$nombre;
							move_uploaded_file($ruta_provisional, $src);
			
							header('Location: paginausuarios.php');exit;	
						}else{
							echo "<script>alert('Error al subir la imagen');location.href = 'paginausuarios.php'</script>";
						}
		
						//echo "<img src='$src'>";
					}else{
						echo "<script>alert('Error la anchura y la altura mínima permitida es 60px');location.href = 'paginausuarios.php'</script></script>";
					}
				}else{
					echo "<script>alert('Error la anchura y la altura maxima permitida es de 5000x3500px');location.href = 'paginausuarios.php'</script></script>";
				}
			}else{
				echo "<script>alert('Error, el tamaño máximo permitido es un 5MB');location.href = 'paginausuarios.php'</script></script>";
			}
	    }else{
			echo "<script>alert('Error, el archivo no es una imagen ni un video');location.href = 'paginausuarios.php'</script></script>";
		}
	}






?>