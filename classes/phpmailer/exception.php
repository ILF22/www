<?php
/**
 * PHPMailer  excepciones
 * @package PHPMailer
 */

class PhpMailerException extends \Exception
{
    /**
     * Salida del mensaje de error
     * @return string
     */
    public function errorMessage()
    {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        echo $errorMsg;
    }
}
