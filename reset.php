<?php require('includes/config.php');

//Si ha iniciado sesión, redirija a la página de class
if ($user->is_logged_in()) {
	header('Location: paginausuarios.php');
	exit();
}

//Si el formulario ha sido enviado, lo procesa
if (isset($_POST['submit'])) {

	//Asegúrese de que todos los POSTS estén declarados
	if (!isset($_POST['email'])) $error[] = "Por favor rellene todos los campos";


	//Validación de correo electrónico
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Por favor, introduce una dirección de correo electrónico válida';
	} else {
		$stmt = $db->prepare('SELECT email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (empty($row['email'])) {
			$error[] = 'El correo electrónico proporcionado no es reconocido.';
		}
	}

	//Si no se han creado errores continua
	if (!isset($error)) {

		//Crea el código de activación
		$stmt = $db->prepare('SELECT password, email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$token = hash_hmac('SHA256', $user->generate_entropy(8), $row['password']); //Codificacion y clave los datos aleatorios
		$storedToken = hash('SHA256', ($token)); //Codifica la clave almacenada en la base de datos, el valor normal se envía al usuario

		try {
			//Si es necesario restaurar la contraseña se mandara el enlace para restaurarla
			$stmt = $db->prepare("UPDATE usuarios SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $storedToken
			));

			//Enviar correo electrónico
			$to = $row['email'];
			$subject = "Restablecimiento de contraseña";
			$body = "<p>Alguien solicitó que se restablezca la contraseña.</p>
			<p>Si esto fue un error, simplemente ignore este correo electrónico y no pasará nada.</p>
			<p>Para restablecer su contraseña, visite la siguiente dirección: <a href='" . DIR . "/resetPassword.php?key=$token&action=reset'>" . DIR . "resetPassword.php?key=$token&action=reset</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//Redirigir a la página de índice.
			header('Location: login.php?action=reset');
			exit;

			//De lo contrario, capte la excepción y muestre el error.
		} catch (PDOException $e) {
			$error[] = $e->getMessage();
		}
	}
}

//Definir el título de la página
$title = 'Restablecer cuenta';

//Incluir plantilla de encabezado
require('layout/header.php');
?>

<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Restablecer la contraseña</h2>
				<p><a href='login.php' class="text-success">Volver a Iniciar Sesión</a></p>
				<hr>

				<?php
				//Verifique cualquier error
				if (isset($error)) {
					foreach ($error as $error) {
						echo '<p class="bg-danger">' . $error . '</p>';
					}
				}

				if (isset($_GET['action'])) {

					//Verifica la acción
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Su cuenta ahora está activa, ahora puede iniciar sesión.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Introduzca la nueva contraseña.</h2>";
							break;
					}
				}
				?>

				<div class="form-group">
					<!--Campo para email para restaurar contraseña-->
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="" tabindex="1">
				</div>
				<hr>
				<div class="row">
					<!--Boton form que manda email para link de restauracion-->
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Enviar enlace" class="btn btn-light btn-block btn-lg" tabindex="2"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>