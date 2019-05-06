<?php
//Define la encriptacion de la contraseña 
if (!defined('PASSWORD_BCRYPT')) {
        define('PASSWORD_BCRYPT', 1);
        define('PASSWORD_DEFAULT', PASSWORD_BCRYPT);
}

class Password {
	//Contructor
    public function __construct() {}


    /**
     * Codifica la contraseña usando el algoritmo especificado
     *
     * @param string $password La contraseña para codificado
     * @param int    $algo     El algoritmo a usar (Definido por PASSWORD_ * constantes)
     * @param array  $options Las opciones para el algoritmo
     * @return string|false La contraseña codificada, o falsa en el error.
     */
    function password_hash($password, $algo, array $options = array()) {
        if (!function_exists('crypt')) {
            trigger_error("Se debe cargar la criptacion para que password-hash funcione", E_USER_WARNING);
            return null;
        }
        if (!is_string($password)) {
            trigger_error("password_hash():La contraseña debe ser una cadena", E_USER_WARNING);
            return null;
        }
        if (!is_int($algo)) {
            trigger_error("password_hash() espera que el parámetro 2 sea largo, " . gettype($algo) . " given", E_USER_WARNING);
            return null;
        }
        switch ($algo) {
            case PASSWORD_BCRYPT :
                // Hay que tener en cuenta que esta es una constante C, pero no está expuesta a PHP, por lo que no la definimos aquí..
                $cost = 10;
                if (isset($options['cost'])) {
                    $cost = $options['cost'];
                    if ($cost < 4 || $cost > 31) {
                        trigger_error(sprintf("password_hash(): El parametro especificado no es valido: %d", $cost), E_USER_WARNING);
                        return null;
                    }
                }
                // La longuitud de la contraseña para generarse
                $raw_salt_len = 16;
                // La longitud requerida en la serialización final
                $required_salt_len = 22;
                $hash_format = sprintf("$2y$%02d$", $cost);
                break;
            default :
                trigger_error(sprintf("password_hash(): Algoritmo codificado de contraseña desconocida: %s", $algo), E_USER_WARNING);
                return null;
        }
        if (isset($options['salt'])) {
            switch (gettype($options['salt'])) {
                case 'NULL' :
                case 'boolean' :
                case 'integer' :
                case 'double' :
                case 'string' :
                    $salt = (string)$options['salt'];
                    break;
                case 'object' :
                    if (method_exists($options['salt'], '__tostring')) {
                        $salt = (string)$options['salt'];
                        break;
                    }
                case 'array' :
                case 'resource' :
                default :
                    trigger_error('password_hash(): Parámetro de longuitud sin cadena', E_USER_WARNING);
                    return null;
            }
            if (strlen($salt) < $required_salt_len) {
                trigger_error(sprintf("password_hash(): Si la longuitud es muy corta: %d expecting %d", strlen($salt), $required_salt_len), E_USER_WARNING);
                return null;
            } elseif (0 == preg_match('#^[a-zA-Z0-9./]+$#D', $salt)) {
                $salt = str_replace('+', '.', base64_encode($salt));
            }
        } else {
            $salt = str_replace('+', '.', base64_encode($this->generate_entropy($required_salt_len)));
        }
        $salt = substr($salt, 0, $required_salt_len);

        $hash = $hash_format . $salt;

        $ret = crypt($password, $hash);

        if (!is_string($ret) || strlen($ret) <= 13) {
            return false;
        }

        return $ret;
    }


    /**
     * Se proporciono la longuitud utilizando el metodo mas seguro disponilbe, recurriendo a otros metodos, dependiendo del soporte es demasiado corto.
     *
     * @param int $bytes
     *
     * @return string Devuelve bytes sin procesar
     */
    function generate_entropy($bytes){
        $buffer = '';
        $buffer_valid = false;
        if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
            $buffer = mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }
        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($bytes);
            if ($buffer) {
                $buffer_valid = true;
            }
        }
        if (!$buffer_valid && is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $read = strlen($buffer);
            while ($read < $bytes) {
                $buffer .= fread($f, $bytes - $read);
                $read = strlen($buffer);
            }
            fclose($f);
            if ($read >= $bytes) {
                $buffer_valid = true;
            }
        }
        if (!$buffer_valid || strlen($buffer) < $bytes) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $bytes; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }
        return $buffer;
    }

    /**
     *  Obtenga información sobre  la codificacion de la contraseña. Devuelve una matriz de la información
	 *	 que se utilizó para generar la codificacion de contraseña.
     *
     * array(
     *    'algo' => 1,
     *    'algoName' => 'bcrypt',
     *    'options' => array(
     *        'cost' => 10,
     *    ),
     * )
     *
     * @param string $hash La codificacion de contraseña para extraer información
     *
     * @return array La matriz de información sobre la codificacion
     */
    function password_get_info($hash) {
        $return = array('algo' => 0, 'algoName' => 'unknown', 'options' => array(), );
        if (substr($hash, 0, 4) == '$2y$' && strlen($hash) == 60) {
            $return['algo'] = PASSWORD_BCRYPT;
            $return['algoName'] = 'bcrypt';
            list($cost) = sscanf($hash, "$2y$%d$");
            $return['options']['cost'] = $cost;
        }
        return $return;
    }

    /**
     * Determine si la contraseña de codificación debe actualizarse de acuerdo con las opciones
     *
     * Si la respuesta es verdadera, después de validar la contraseña usando password_verify, repítela.
     *
     * @param string $hash    La codificaciones para probar
     * @param int    $algo   El algoritmo utilizado para nuevas codificaciones de contraseñas
     * @param array  $options El conjunto de opciones paso a password_hash
     *
     * @return boolean Verdadero si es necesario volver a generar la contraseña.
     */
    function password_needs_rehash($hash, $algo, array $options = array()) {
        $info = password_get_info($hash);
        if ($info['algo'] != $algo) {
            return true;
        }
        switch ($algo) {
            case PASSWORD_BCRYPT :
                $cost = isset($options['cost']) ? $options['cost'] : 10;
                if ($cost != $info['options']['cost']) {
                    return true;
                }
                break;
        }
        return false;
    }

    /**
     * Verificar una contraseña contra una codificación usando un enfoque resistente al tiempo
     *
     * @param string $password La contraseña para verificar
     * @param string $hash     La codificacion para verificar contra
     *
     * @return boolean Si la contraseña coincide con la codificacion
     */
    public function password_verify($password, $hash) {
        if (!function_exists('crypt')) {
            trigger_error("La criptacion se debe cargar para que password_verify funcione", E_USER_WARNING);
            return false;
        }
        $ret = crypt($password, $hash);
        if (!is_string($ret) || strlen($ret) != strlen($hash) || strlen($ret) <= 13) {
            return false;
        }

        $status = 0;
        for ($i = 0; $i < strlen($ret); $i++) {
            $status |= (ord($ret[$i]) ^ ord($hash[$i]));
        }

        return $status === 0;
    }

}