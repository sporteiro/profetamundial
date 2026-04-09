<?php

$mail='SEBLASH@GMAIL.COM';


$motivo = $_POST['motivo'];
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$ip = $_SERVER['REMOTE_ADDR'];
$origen = $_POST['origen'];

$message = "
<html><body>
<div style='background-image:url(http://www.profetamundial.com.ar/imagenes/fondo.jpg); background-repeat:repeat; text-align:center; background-color:#9C6;'>
<p><img src='http://www.profetamundial.com.ar/imagenes/profetamundial.png' alt='Profeta Mundial' width='310' height='103' /></p>
<div style='background-color: #336600; color: #ffffff; border: 2px solid #ffffff; width: 500px; margin: 0pt auto; padding: 10px;'>
<p>Hola Administrador</p>
<p><b>Motivo del mensaje:</b> ".$motivo."</p>
<p><b>Usuario que lo envio:</b> ".$usuario."</p>
<p><b>Nombre de usuario:</b> ".$nombre."</p>
<p><b>Direccion de correo electronico:</b> ".$email."</p>
<p><b>Mensaje:</b> ".$mensaje."</p>
<p><b>Direccion IP:</b>".$ip."</p>
</div>
<p><br /> Dise&ntilde;o y desarrollo del sitio: <a href='http://www.sebastianporteiro.com.ar/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com.ar/favicon.ico' alt='' /></p>
<p>&nbsp;</p>
</div>
</body>
</html>
";
$remitente = "MIME-Version: 1.0\r\n"; 
$remitente .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$remitente .= "From: $origen";
$_SESSION['MM_Username']=$usuario;
if (mail($mail,"PROFETAMUNDIAL.COM.AR",$message,$remitente))
Header ("Location:mensajenviado.php");


?> 
