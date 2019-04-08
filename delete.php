<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require('includes/config.php');

$id = $_SESSION['usuarioID'];
$email = $_SESSION['email'];
$userLogin = $_SESSION['username'];
$username = $_POST['username'];
$pass = $_POST['password'];

if($user->login($username,$pass)){
	//echo "OK BORRADO";
	//Borra en cascada, primero se borra la imagen subida por el usuario a borrar y despues borra el usuario
	$sentencia = $db->prepare( "DELETE FROM imagen WHERE usuarioID = $id " );
	if ($sentencia->execute()){
		$sentencia = $db->prepare( "DELETE FROM usuarios WHERE usuarioID = $id " );
		if ($sentencia->execute()){
			$_SESSION['loggedin'] = false;
			$_SESSION['username'] = "";
			$_SESSION['usuarioID'] = "";
			$_SESSION['email'] = "";
			//Enviar email de aviso
			$to = $email;
			$subject = "Confirmación de eliminación de cuenta";
			$body = "Su cuenta ha sido eliminado con éxito.";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			if($mail->send()){
				echo "<script>alert('Usuario eliminado');</script>";
				header('Location: index.php?action=deleted');
			}else{
				echo "<script>alert('Usuario eliminado, error al enviar el correo');</script>";
				echo SITEEMAIL . ',' . $to . ',' . $subject; // . ',' . SITEEMAIL . ',' . SITEEMAIL . ',';
				//header('Location: index.php');
			}		
		}else{
			echo "<script>alert('Error al borrar las imagenes del usuario');location.href = 'paginausuarios.php'</script>";
		}
	}else{
		echo "<script>alert('Error al borrar el usuario');location.href = 'paginausuarios.php'</script>";
	}	
} else {
	//echo "ERROR NO BORRADO";
	header('Location: deleteusuario.php');
}




	
?>