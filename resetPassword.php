<?php require('includes/config.php');

//Si ha iniciado sesión, redirija a la página de class
if ($user->is_logged_in()) {
	header('Location: paginausuarios.php');
	exit();
}

$resetToken = hash('SHA256', ($_GET['key']));

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM usuarios WHERE resetToken = :token');
$stmt->execute(array(':token' => $resetToken));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//Si no hay token de db se cae la pagina
if (empty($row['resetToken'])) {
	$stop = 'El token no es válido, utiliza el enlace proporcionado en el correo electrónico de restablecimiento.';
} elseif ($row['resetComplete'] == 'Yes') {
	$stop = '¡Tu contraseña ya ha sido cambiada!';
}

//Si el formulario ha sido enviado la procesa
if (isset($_POST['submit'])) {

	if (!isset($_POST['password']) || !isset($_POST['passwordConfirm']))
		$error[] = 'Ambos campos de contraseña son obligatorios para ser ingresados';

	//Validacion de contraseña
	if (strlen($_POST['password']) < 3) {
		$error[] = 'La contraseña es demasiado corta.';
	}

	if (strlen($_POST['passwordConfirm']) < 3) {
		$error[] = 'Confirmar contraseña es muy corta.';
	}
	//Validacion de coincidencia de contraseñas
	if ($_POST['password'] != $_POST['passwordConfirm']) {
		$error[] = 'Las contraseñas no coinciden.';
	}

	//Si no se han creado errores, continua
	if (!isset($error)) {

		//Codifica la contraseña
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {
			//Actualiza la contraseña, si se active el link enviado pasa a estado activo y cambiamos la contraseña
			$stmt = $db->prepare("UPDATE usuarios SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));

			//Redirigir a la página de índice
			header('Location: login.php?action=resetAccount');
			exit;

			//De lo contrario, capte la excepción y muestre el error.
		} catch (PDOException $e) {
			$error[] = $e->getMessage();
		}
	}
}

//Definir el título de la página
$title = 'Restablecer contraseña';

//Incluir plantilla de encabezado
require('layout/header.php');
?>

<div class="container">

	<div class="row">

		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">


			<?php if (isset($stop)) {
				//
				echo "<p class='bg-danger'>$stop</p>";
			} else { ?>
				<!-- Boton de cambio de contraseña-->
				<form role="form" method="post" action="" autocomplete="off">
					<h2>Cambio de Contraseña.</h2>
					<p><a href='./' class ="text-success">Volver a Inicio</a></p>
					<hr>

					<?php
					//Verificar si hay algún error
					if (isset($error)) {
						foreach ($error as $error) {
							echo '<p class="bg-danger">' . $error . '</p>';
						}
					}

					//Revisa la acción
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Su cuenta ahora está activa, ahora puede iniciar sesión.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Introduce la nueva contraseña.</h2>";
							break;
					}
					?>
					<!--Cuadros para introducir la nueva contraseña-->
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="1">
							</div>
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirma Contraseña" tabindex="1">
							</div>

					<hr>
					<!--Boton que va a la form-->
					<div class="row">
						<div class="col-xs-6 col-md-6">
							<input type="submit" name="submit" value="Cambiar" class="btn btn-light btn-block btn-lg" tabindex="3">
						</div>
					</div>
				</form>

			<?php } ?>
		</div>
	</div>
</div>

<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>