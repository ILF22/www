<?php
include('phpmailer.php');
class Mail extends PhpMailer
{
    // Establecer variables predeterminadas para todos los objetos nuevos
     public $From     = 'irene.proyectosbd@gmail.com';
     public $FromName = SITETITLE;//'Irene León'; 
     public $Host     = 'smtp.gmail.com';
     public $Mailer   = 'smtp';
     public $SMTPAuth = true;
     public $Username = 'irene.proyectosbd@gmail.com';
     public $Password = 'Bitcode@2018';
     public $SMTPSecure = 'tls';
    // public $WordWrap = 75;
    // public $CharSet = 'UTF-8';
	
	// Establecer variables predeterminadas para todos los objetos nuevos
	//public $From     = 'enviosirene@losnaranjosdam.online';
    //public $FromName = 'Irene León'; 
    //public $Host     = 'mail.losnaranjosdam.online';
    //public $Mailer   = 'smtp';
    //public $SMTPAuth = true;
   // public $Username = 'enviosirene@losnaranjosdam.online';
   // public $Password = 'irene18';
	//public $SMTPDebug = 4;
	public $Port = 25;
    //public $SMTPSecure = 'tls';
    public $WordWrap = 75;
    public $CharSet = 'UTF-8';
	//Sujeto
    public function subject($subject){
        $this->Subject = $subject;
    }
	//cuerpo del mensaje
    public function body($body){
        $this->Body = $body;
    }
	//Enviado del mensaje
    public function send(){
        $this->AltBody = strip_tags(stripslashes($this->Body))."\n\n";
        $this->AltBody = str_replace("&nbsp;", "\n\n", $this->AltBody);
        return parent::send();
    }
}
