<?php require('includes/config.php');

//Si ha iniciado sesión, redirija a la página de class
if ($user->is_logged_in()) {
	header('Location: paginausuarios.php');
	exit();
}

//Si el formulario ha sido enviado lo procesa
if (isset($_POST['submit'])) {

	if (!isset($_POST['username'])) $error[] = "Por favor rellene todos los campos.";
	if (!isset($_POST['email'])) $error[] = "Por favor rellene todos los campos.";
	if (!isset($_POST['password'])) $error[] = "Por favor rellene todos los campos.";

	$username = $_POST['username'];

	//Validación de nombre de usuario 
	if (!$user->isValidUsername($username)) {
		$error[] = 'Los nombres de usuario deben tener al menos 3 caracteres alfanuméricos.';
	} else {
		//Añade nombre a la base de datos si no esta cogido ya 
		$stmt = $db->prepare('SELECT username FROM usuarios WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!empty($row['username'])) {
			$error[] = 'El nombre de usuario proporcionado ya está en uso.';
		}
	}
	//Validaciones de contraseña
	if (strlen($_POST['password']) < 3) {
		$error[] = 'La contraseña es demasiado corta.';
	}

	if (strlen($_POST['passwordConfirm']) < 3) {
		$error[] = 'Confirmar contraseña es muy corta.';
	}

	if ($_POST['password'] != $_POST['passwordConfirm']) {
		$error[] = 'Las contraseñas no coinciden.';
	}

	//Validación de correo electrónico
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error[] = 'Por favor, introduce una dirección de correo electrónico válida.';
	} else {
		//Añade email a la base de datos si no esta cogido ya 
		$stmt = $db->prepare('SELECT email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!empty($row['email'])) {
			$error[] = 'El correo electrónico proporcionado ya está en uso.';
		}
	}
	//Si no se han creado errores continua
	if (!isset($error)) {

		//Codifica la contraseña
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//Crea el código de activación
		$activasion = md5(uniqid(rand(), true));

		try {

			//No realiza la action si cualquier parte de la operacion falla
			$db->beginTransaction();
			//Insertar en la base de datos con una declaración preparada
			$stmt = $db->prepare('INSERT INTO usuarios (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $username,
				':password' => $hashedpassword,
				':email' => $email,
				':active' => $activasion
			));
			$id = $db->lastInsertId('usuarioID');

			//Enviar correo electrónico
			$to = $_POST['email'];
			$subject = "Confirmación de registro";
			/*			$body = "<p>Gracias por registrarte.</p>
			<p>Para activar tu cuenta pulsa en el siguiente enlace: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Saludos</p>";*/
			$body = "<p>Gracias por registrarte.</p>
			<p>Para activar tu cuenta pulsa en el siguiente enlace: <a href='localhost/www/activate.php?x=$id&y=$activasion'>" . DIR . "activate.php?x=$id&y=$activasion</a></p>
			<p>Saludos</p>";


			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail_result = $mail->send();


			if (!$mail_result) {
				throw new Exception('No se ha podido enviar el e-mail: ' . $mail->ErrorInfo);
			}

			//FIXME Prueba resultado correo
			// echo 'mail_result = ' . print_r( $mail_result, true ) . PHP_EOL;
			// echo 'ErrorInfo = ' . $mail->ErrorInfo . PHP_EOL;
			// return;

			$db->commit();

			//Redirigir a la página de índice
			header('Location: index.php?action=joined');
			exit;


			//De lo contrario, capte la excepción y muestre el error. y no realiza la accion
		} catch (Exception $e) { // PDOException
			$db->rollBack();
			$error[] = $e->getMessage();
		}
	}
}

//Definir el título de la página
$title = 'Registro';

//Incluir plantilla de encabezado
require('layout/header.php');
?>


<!-- Contenido de página -->
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<form role="form" method="post" action="" autocomplete="off">
					<h2>Por favor regístrese</h2>
					<p>¿Ya eres usuario? <a href='login.php' class="text-success">Iniciar sesión</a></p>
					<hr>

					<?php
					//Verifique cualquier error
					if (isset($error)) {
						foreach ($error as $error) {
							echo '<p class="bg-danger">Se ha producido un error:<br/>' . $error . '</p>';
						}
					}

					//Si la acción se une, muestra el éxito
					if (isset($_GET['action']) && $_GET['action'] == 'joined') {
						echo "<h2 class='bg-success'>Registro exitoso, verifique su correo electrónico para activar su cuenta.</h2>";
					}
					?>
					<!--Campos para introducir datos-->
					<div class="form-group">
						<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Nombre de usuario" value="<?php if (isset($error)) {
																																																																		echo htmlspecialchars($_POST['username'], ENT_QUOTES);
																																																																	} ?>" tabindex="1">
					</div>
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Dirección de correo electrónico" value="<?php if (isset($error)) {
																																																																							echo htmlspecialchars($_POST['email'], ENT_QUOTES);
																																																																						} ?>" tabindex="2">
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar contraseña" tabindex="4">
							</div>
						</div>
					</div>
					<!--Boton form de registro-->
					<div class="row">
						<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Registro" class="btn btn-secondary btn-block btn-lg" tabindex="5"></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>