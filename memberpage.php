<?php require('includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); exit(); }

//define page title
$title = 'Members Page';

//include header template
require('layout/header.php'); 
?>

<div class="container">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			
				<h2>Página solo para usuarios - Bienvenido <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></h2>
				<p><a href='logout.php'>Cerrar sesión</a></p>

				<div class="counter" data-count="150">0</div>
				<div class="counter" data-count="85">0</div>
				<div class="counter" data-count="2200">0</div>
				<hr>

		</div>
	</div>


</div>
<script scr="js/contador.js"></script>
<?php 
//include header template
require('layout/footer.php'); 
?>
