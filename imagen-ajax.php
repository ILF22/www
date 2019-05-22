<?php
    require('includes/config.php'); 

    if (isset($_FILES["file"])){		
	    $file = $_FILES["file"];
	    $nombre = $file["name"];
	    $tipo = $file["type"];
	    $ruta_provisional = $file["tmp_name"];
	    $size = $file["size"];
	    $descripcion = $_POST["descripcion"];
	    $dimensiones = getimagesize($ruta_provisional);
	    $width = $dimensiones[0];
	    $height = $dimensiones[1];
	    $carpeta = "imagenes/";
	
	    //Validaciones con mensajes para la subida de imagenes por tamaño, tipo y formato.
	    if ($tipo == 'image/jpg' || $tipo == 'image/jpeg' || $tipo == 'image/png' || $tipo == 'image/gif'){
	        if($size < 5000*3500){
				if($width < 5000 || $height < 3500){
					if($width > 60 || $height > 60){
						
						//INSERT EN TABLA fotos idusuario, desc, nombre
						$sentencia = $db->prepare("INSERT INTO imagen (usuarioID, nombre,  descripcion) VALUES (:usuarioID, :nombre, lower(:descripcion))");
		
						$sentencia->bindParam(':usuarioID', $var1);
						$sentencia->bindParam(':nombre', $var2);
						//$sentencia->bindParam(':base64', $var3);
						$sentencia->bindParam(':descripcion', $var4);
		
						$var1 = $_SESSION['usuarioID'];
						$var2 = $nombre;		
						//$var3 = $foto_reconvertida;	
						$var4 = $descripcion;			

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
		// Validaciones para la subida de video
	    }else if($tipo == 'video/avi' || $tipo == 'video/mp4' || $tipo == 'video/3pgg' || $tipo == 'video/mpg' || $tipo == 'video/mpeg'){
			if($size < 7000000){
				//INSERT EN TABLA video idusuario, desc, nombre
				$sentencia = $db->prepare("INSERT INTO video (usuarioID, nombre,  descripcion) VALUES (:usuarioID, :nombre, lower(:descripcion))");

				$sentencia->bindParam(':usuarioID', $var1);
				$sentencia->bindParam(':nombre', $var2);
				$sentencia->bindParam(':descripcion', $var4);
		
				$var1 = $_SESSION['usuarioID'];
				$var2 = $nombre;			
				$var4 = $descripcion;			

				if ($sentencia->execute()){
					$src = $carpeta.$nombre;
					move_uploaded_file($ruta_provisional, $src);
			
					header('Location: paginausuarios.php');exit;	
				}else{
					echo "<script>alert('Error al subir el video');location.href = 'paginausuarios.php'</script>";
				}
			}else{
				echo "<script>alert('Error, el video es demasiado grande, debe reducir su tamaño');location.href = 'paginausuarios.php'</script></script>";

			}
		}else{
			echo "<script>alert('Error, el archivo no es una imagen ni un video');location.href = 'paginausuarios.php'</script></script>"; 
		}
	
	}
