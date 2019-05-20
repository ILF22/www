<?php require('includes/config.php');

//Si ha iniciado sesión, redirija a la página de class
 //header('Location: index.php'); exit(); 

//Si el formulario ha sido enviado lo procesa
if(isset($_POST['submit'])){

    if (!isset($_POST['username'])) $error[] = "Por favor rellene todos los campos.";
    //if (!isset($_POST['email'])) $error[] = "Por favor rellene todos los campos.";
    if (!isset($_POST['password'])) $error[] = "Por favor rellene todos los campos.";

	$username = $_POST['username'];

	//Validación de nombre de usuario 
	if(!$user->isValidUsername($username)){
		$error[] = 'Los nombres de usuario deben tener al menos 3 caracteres alfanuméricos.';
	} else {
		$stmt = $db->prepare('SELECT username FROM usuarios WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'El nombre de usuario proporcionado ya está en uso.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'La contraseña es demasiado corta.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirmar contraseña es muy corta.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Las contraseñas no coinciden.';
	}

	//Validación de correo electrónico
	$nombreU = $_SESSION['username'];
	$stmt = $db->prepare(" SELECT email FROM usuarios WHERE username = :nombreUsu ");
	$stmt->execute(array(
				':nombreUsu' => $nombreU
			));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$email = $row['email'];
	echo '<script type="text/javascript">alert("hola");</script>';
	//$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Por favor, introduce una dirección de correo electrónico válida.';
	} else {
		$stmt = $db->prepare('SELECT email FROM usuarios WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		/*if(!empty($row['email'])){
			$error[] = 'El correo electrónico proporcionado ya está en uso.';
		}*/

	}


	//Si no se han creado errores continua
	if(!isset($error)){

		//Codifica la contresañe
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//Crea el código de activación
		$activasion = md5(uniqid(rand(),true));

		try {

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
			$subject = "Confirmación de borrado";
			$body = "<p>Gracias por registrarte.</p>
			<p>Para borrar tu cuenta pulsa en el siguiente enlace: <a href='".DIR."delete.php?x=$id'>".DIR."delete.php?x=$id</a></p>
			<p>Saludos</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//Redirigir a la página de índice
			header('Location: index.php?action=joined');
			exit;

		//De lo contrario, capte la excepción y muestre el error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//Definir el título de la página
$title = 'Eliminar cuenta';

//Incluir plantilla de encabezado
require('layout/header.php');
?>


    <!-- Estilos personalizados para esta plantilla -->
    <link href="styles/the-big-picture.css" rel="stylesheet">

	
	    <!-- Contenido de página -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
			<form action="#" autocomplete="off" id="myForm">
				<h2>Eliminar cuenta</h2>
				<!-- Estable el nombre de la sesion iniciada -->
				<p class ="text-danger">¿Estas seguro de que quieres eliminar la cuenta <?php echo  $_SESSION['username'] ?> <a href='paginausuarios.php'  class ="text-success">Vuelve a tu perfil</a></p>
				<hr>

				<?php
				//Verifique cualquier error
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//Si la acción se une, muestra el éxito
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Eliminación exitosa, mire su correo electrónico para borrar su cuenta.</h2>";
				}
				?>
				<!--Diseño de la pagina-->
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Nombre de usuario" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
						</div>
					</div>
				</div>
				<!--<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg"  value=" $email" tabindex="2" style="display:none">
				</div>-->
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Contraseña" tabindex="3">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirmar contraseña" tabindex="4" style="display:none">
						</div>
					</div>
				</div>
				<div class="row">
					<input style="display:none" id="btnaceptar" type="submit" name="submit" value="Eliminar">
					<div class="col-xs-6 col-md-6"><input id="aceptar" name="submit" value="Eliminar" class="btn btn-secondary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
          </div>
        </div>
      </div>
    </section>
<script>
window.onload = function() {
    document.getElementById('aceptar').onclick = function() {
		var username = document.getElementById("username").value;
		var password = document.getElementById("password").value;
		
		if(username == null || username == '' || username.length == 0){
			location.href = 'paginausuarios.php';
		}else if(password == null || password == '' || password.length == 0){
			location.href = 'www/paginausuarios.php';
		}else{
			//document.getElementById('myForm').type = 'submit';
			document.getElementById('btnaceptar').style.display = "block";
			document.getElementById("myForm").method = "post";
			document.getElementById("myForm").action = "delete.php";
			document.getElementById("btnaceptar").click();
			document.getElementById('btnaceptar').style.display = "none";			
		}
    };
};
</script>
<?php
//Incluir plantilla de encabezado
require('layout/footer.php');
?>