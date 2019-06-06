<?php
//Incluir config
require_once('includes/config.php');

//Verifique si ya ha iniciado sesión muévase a la página de inicio
if( $user->is_logged_in() ){ header('Location: index.php'); exit(); }

//Forma de inicio de sesión de proceso si se envía
if(isset($_POST['submit'])){
	//Validaciones de los campos si estan vacios
	if (!isset($_POST['username'])) $error[] = "Por favor rellene todos los campos";
	if (!isset($_POST['password'])) $error[] = "Por favor rellene todos los campos";
	//Recoge el nombre validado 
	$username = $_POST['username'];
	if ( $user->isValidUsername($username)){
	//Recoge la contraseña y verifica si el campo esta relleno
		if (!isset($_POST['password'])){
			$error[] = 'Se debe introducir una contraseña';
		}
		$password = $_POST['password'];
		//Si el usuario y la contraseña son validos entra en la pagina usuarios
		if($user->login($username,$password)){
			$_SESSION['username'] = $username;
			header('Location: paginausuarios.php');
			exit;

		} else {
		//Mensaje de alerta
			$error[] = 'Nombre de usuario o contraseña incorrectos o su cuenta no ha sido activada.';
		}
	}else{
	//Mensaje de alerta
		$error[] = 'Los nombres de usuario deben ser alfanuméricos, y entre 3-16 caracteres de largo';
	}
	
}//Finalizar si envia

//Definir el título de la página
$title = 'Inicio Sesión';

//Incluir plantilla de encabezado
require('layout/header.php'); 
?>

	
<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Por favor Inicia sesión</h2>
				<p><a href='./' class ="text-success">Volver a Inicio</a></p>
				<hr>

				<?php
				//Verifique cualquier error
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}
				//Si se restaura la contraseña
				if(isset($_GET['action'])){

					//Verifica la acción
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Su cuenta ahora está activa, ahora puede iniciar sesión.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Revise el correo para crear la nueva contraseña.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>La contraseña ha cambiado, ahora puede iniciar sesión.</h2>";
							break;
					}

				}

				
				?>

				<div class="form-group">
				<!--Si el usuario existe-->
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Nombre de usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
				</div>
				
				<div class="row">
					<div class="col-xs-9 col-sm-9 col-md-9 ">
						 <a href='reset.php' class ="text-success">¿Olvidaste tu contraseña? </a>
					</div>
				</div>
				
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<input type="submit" name="submit" value="Iniciar sesión" class="btn btn-light btn-block btn-lg" tabindex="5">
				</div>
				</div>
			</form>
		</div>
	</div>
</div>


<?php 
//Incluir plantilla de encabezado
require('layout/footer.php'); 
?>
