<?php

$mail='SEBLASH@GMAIL.COM';


$motivo = $_POST['motivo'];
$usuario =$_POST['usuario'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$ip = $_SERVER['REMOTE_ADDR'];
$origen = $_POST['origen'];

$message = "
<html><body>
<div style='background-image:url(http://www.profetamundial.com/imagenes/fondo.jpg); background-repeat:repeat; text-align:center; background-color:#9C6;'>
<p><img src='http://www.profetamundial.com/imagenes/profetamundial.png' alt='Profeta Mundial' width='310' height='103' /></p>
<div style='background-color: #336600; color: #ffffff; border: 2px solid #ffffff; width: 500px; margin: 0pt auto; padding: 10px;'>
<p>Hola Administrador</p>
<p><b>Motivo del mensaje:</b> ".$motivo."</p>
<p><b>Usuario que lo envio:</b> ".$usuario."</p>
<p><b>Direccion de correo electronico:</b> ".$email."</p>
<p><b>Mensaje:</b> ".$mensaje."</p>
<p><b>Direccion IP:</b>".$ip."</p>
</div>
<p><br /> Dise&ntilde;o y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico' alt='' /></p>
<p>&nbsp;</p>
</div>
</body>
</html>
";
$remitente = "MIME-Version: 1.0\r\n"; 
$remitente .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$remitente .= "From: $origen <equipo@profetamundial.com>";
$_SESSION['MM_Username']=$usuario;
if (mail($mail,"PROFETAMUNDIAL.com",$message,$remitente));
if ($motivo=='contrasena')	{

require_once('Connections/conexion.php');

$aleatorio=substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',105)),6,6);
echo $aleatorio;

   mysql_select_db($database_conexion, $conexion);
$LoginRS__query="SELECT usuario, email FROM usuarios WHERE (usuario='".mysql_real_escape_string($usuario)."' AND email='".mysql_real_escape_string($email)."') AND activo='si'"; 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $filas=mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser>0)	{
		$update="UPDATE usuarios set contrasena='".sha1($aleatorio)."' WHERE usuario='".mysql_real_escape_string($usuario)."' AND email='".mysql_real_escape_string($email)."' ";
		 $uptadesi = mysql_query($update, $conexion) or die(mysql_error());

$message = "
<div style='background-color: #9c6; text-align:center'><p><a href='http://www.profetamundial.com'><img src='http://www.profetamundial.com/imagenes/profetamundial.png'  width='' height='57' alt='Profeta Mundial'></a></p>
<div style='background-color:#360; color:#FFF; border: 2px solid #FFF; width:500px; margin:0 auto; padding:10px;'>
Hola ".$usuario."<br />
Hemos recibido un pedido de nueva contraseña.<br />
Si se trata de un error, contacta con el equipo de desarrollo.<br /><br />
Tu nueva contraseña es:<br />
".$aleatorio."<br /><br />
Por favor, cambiala en cuanto entres de nuevo en Profeta Mundial<br />
<p>No olvides que las contrase&ntilde;as son sensibles de Mayusculas y minusculas</p>
<p><strong>IMPORTANTE</strong>:</p>
<p>No respondas a este correo. Hacelo desde tu cuenta de usuario o a esta direccion: <a href='mailto:equipo@profetamundial.com'>equipo@profetamundial.com</a></p>
</div>
<p><br />
Diseño y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico'/></p>
<p><br />
</p>
</div>
";
$mail=$email;
if (mail($mail,"PROFETAMUNDIAL.com",$message,$remitente))
Header ("Location:mensajenviado.php");
	}
	else	{
	$mail='SEBLASH@GMAIL.COM';
	if (mail($mail,"PROFETAMUNDIAL.com",$message,$remitente))
	Header ("Location:usuarionoexiste.php");	
	break;
	}
}
Header ("Location:mensajenviado.php");
?> 
