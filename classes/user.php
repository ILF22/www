<?php
include('password.php');
class User extends Password{
	//Definicion Base de datos privada 
    private $_db;
	//Contructor
    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }
	//Deficion de hash privado
	private function get_user_hash($username){
		//Selecciona password, username, usuarioID, email de usuario cuando el usuario sea igual a usuario y activo sea yes
		try {
			$stmt = $this->_db->prepare('SELECT password, username, usuarioID, email FROM usuarios WHERE username = :username AND active="Yes" ');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	//Validamos el nombre entre los siguientes valores
	public function isValidUsername($username){
		if (strlen($username) < 3) return false;
		if (strlen($username) > 17) return false;
		if (!ctype_alnum($username)) return false;
		return true;
	}
	//Inicia sesion de el nombre usuario es valido
	public function login($username,$password){
		if (!$this->isValidUsername($username)) return false;
		if (strlen($password) < 3) return false;

		$row = $this->get_user_hash($username);

		if($this->password_verify($password,$row['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $row['username'];
		    $_SESSION['usuarioID'] = $row['usuarioID'];
			$_SESSION['email'] = $row['email'];
		    return true;
		}
	}
	//Cierra sesion
	public function logout(){
		session_destroy();
	}
	//Si se ha iniciado sesion 
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

}


?>
