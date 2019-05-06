<?php
ob_start();
session_start();

//Establecer zona horaria
date_default_timezone_set('Europe/London');

//Credenciales de la base de datos
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','fotografia');

//Credenciales de la base de datos servidor
//define('DBHOST','hl192.dinaserver.com');
//define('DBUSER','ireneilf');
//define('DBPASS','01031995ILF');
//define('DBNAME','webfotografia');

//Dirección de la aplicación
//define( 'DIR', 'https://www.losnaranjosdam.online/2dam/irene/www/loginregister-master/' );
define( 'DIR', 'http://localhost:8080/' );
define('SITEEMAIL','irene.proyectosbd@gmail.com');

try {

	//Crear conexión PDO
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Sugerido para comentar sobre sitios web de producción
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//Mostrar error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//Incluir la clase de usuario, pasar la conexión a la base de datos
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
