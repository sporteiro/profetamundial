<?php require_once('Connections/conexion.php'); ?>
<?php
$editFormAction='';
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="yaexiste.php";
  $loginUsername = $_POST['usuario'];
  $LoginRS__query = sprintf("SELECT usuario FROM usuarios WHERE usuario=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conexion, $conexion);
  $LoginRS=mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}
/*require_once('recaptchalib.php');
$privatekey = "6LfdcFYUAAAAALRvVzEnzUccaJkyu7rjtoprB8Hh";
$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
*/

	$recaptcha = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LfdcFYUAAAAALRvVzEnzUccaJkyu7rjtoprB8Hh',
		'response' => $recaptcha
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
if (!$captcha_success->success) {
//if (!$resp->is_valid) {
      $error_captcha = $resp->error; }
else{
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formregistrarse")) {
  $insertSQL = sprintf("INSERT INTO usuarios (usuario, contrasena, nombre, email, puntos, ip,activo) VALUES (%s, %s, %s, %s, '0', %s,'no')",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString(sha1($_POST['contrasena']), "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_SERVER['REMOTE_ADDR'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formregistrarse")) {
$mail='SEBLASH@GMAIL.COM';
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$ip = $_SERVER['REMOTE_ADDR'];
$origen = $_POST['origen'];

$message = "
usuario:".$usuario."
nombre:".$nombre."
email:".$email."
ip:".$ip."
";
$remitente = "MIME-Version: 1.0\r\n"; 
$remitente .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$remitente .= "From: $origen";
if (mail($mail,"PROFETAMUNDIAL.com",$message,$remitente)) 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formregistrarse")) {
$mail2=''.$_POST['email'].'';
$usuario2 = $_POST['usuario'];
$nombre2 = $_POST['nombre'];
$email2 = $_POST['email'];
$ip2 = $_SERVER['REMOTE_ADDR'];
$origen2 = $_POST['origen'];

$message2 = "
<html><body>
<div style='background-image:url(http://www.profetamundial.com/imagenes/fondo.jpg); background-repeat:repeat; text-align:center; background-color:#9C6;'>
<p><img src='http://www.profetamundial.com/imagenes/profetamundial.png' alt='Profeta Mundial' width='310' height='103' /></p>
<div style='background-color: #336600; color: #ffffff; border: 2px solid #ffffff; width: 500px; margin: 0pt auto; padding: 10px;'>
<p>Bienvenido ".$nombre2."</p>
<p> Gracias por registrarte en Profeta Mundial</p>
<br />
<p>Tus datos de acceso son:</p>
usuario: ".$usuario2."<br />
contrasena: ".$_POST['contrasena']."<br />
email: ".$email2."<br />
La ip desde donde te registraste: ".$ip2."<br />
<p>Para ingresar, es necesario que actives tu cuenta</p>
<br />
<p><a href='http://profetamundial.com/activarcuenta.php?codigo=".$usuario2."profeta".$ip2."'>ACTIVAR CUENTA AHORA</a></p><br />
<p>Gracias por tu registro, que te diviertas pronosticando!</p>
<br />
<br />
</div>
<p><br /> Dise&ntilde;o y desarrollo del sitio: <a href='http://www.sebastianporteiro.com/'>Sebastian Porteiro</a> <img src='http://www.sebastianporteiro.com/favicon.ico' alt='' /></p>
<p>&nbsp;</p>
</div>
</body>
</html>
";
$remitente2 = "MIME-Version: 1.0\r\n"; 
$remitente2 .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$remitente2 .= "From: $origen2";
if (mail($mail2,"PROFETAMUNDIAL.com",$message2,$remitente2)) 
					   					   

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}
}
?>
<?php
// *** Validate request to login to this site.
/*if (!isset($_SESSION)) {
  session_start();
}
*/
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=sha1($_POST['contrasena']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "regexito.php";
  $MM_redirectLoginFailed = "nocaptcha.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT usuario, contrasena FROM usuarios WHERE usuario=%s AND contrasena=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>-
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Profeta Mundial - Nuevo usuario</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
 <script type="text/javascript">
/*var RecaptchaOptions = {
   theme :'Clean',
   lan :'es',
   tabindex : 9
};*/
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
<!-- inicio de la cabecera -->
<div class="cabecera" style="position:relative;">
	<div style="width: 300px; float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
    </div>
    <div style="clear:both;"></div>
</div>
<!-- Fin de la cabecera-->

<div class="contenedora_2018">
	<h2>
    <strong>Registrarse como nuevo usuario</strong>
    </h2>
	<p>
	<br />
	</p>
	<div style="text-align: right; margin-right:30%;">
  <form id="formregistrarse" name="formregistrarse" method="POST" action="<?php echo $editFormAction; ?>">
  	 <input name="origen" type="hidden" id="origen" value="ProfetaMundial" />
	<span id="sprytextfield1">
 		 <label>Eleg&iacute; un nombre de usuario
 	   	<input name="usuario" type="text" class="letrasgrandes" id="usuario" />
 	 	</label>
  			<span class="textfieldRequiredMsg">Campo obligatorio
        	</span>
        	<span class="textfieldMinCharsMsg">Numero de caracteres insuficiente
        	</span>
        	<span class="textfieldMaxCharsMsg">Demasiados caracteres
       		</span>
	</span>
 	<p>
  	<span id="sprytextfield2">
  	<label>Eleg&iacute; una contrase&ntilde;a
    	<input name="contrasena" type="password" class="letrasgrandes" id="contrasena" />
  	</label>
  		<span class="textfieldRequiredMsg">Campo obligatorio
        </span>
        <span class="textfieldMinCharsMsg">Numero de caracteres insuficiente
        </span>
        <span class="textfieldMaxCharsMsg">Demasiados caracteres
        </span>
	</span>
 	</p>
  	<p>
    <span id="spryconfirm1">
    	<label>Repet&iacute; la contrase&ntilde;a
      	<input name="contrasena2" type="password" class="letrasgrandes" id="contrasena2" />
    	</label>
  		<span class="confirmRequiredMsg">Campo obligatorio
        </span>
        <span class="confirmInvalidMsg">Las contrase&ntilde;as no coinciden
        </span>
	</span>
    </p>
  	<p>
  	<span id="sprytextfield3">
   	 <label>Pon&eacute; tu nombre
   	 <input name="nombre" type="text" class="letrasgrandes" id="nombre" />
 	 </label>
  		<span class="textfieldRequiredMsg">Campo obligatorio
        </span>
        <span class="textfieldMinCharsMsg">Numero de caracteres insuficiente
        </span>
        <span class="textfieldMaxCharsMsg">Demasiados caracteres
        </span>
        </span>
	</p>
  	<p>
    <span id="sprytextfield4">
  	<label>Correo electr&oacute;nico
    	<input name="email" type="text" class="letrasgrandes" id="email" />
  	</label>
  		<span class="textfieldRequiredMsg">Campo obligatorio
        </span>
        <span class="textfieldInvalidFormatMsg">Tiene que ser un correo electr&oacute;nico
        </span>
	</span>
    </p>
 
  	<div id="cachaca" class="cachaca">
<div class="g-recaptcha" data-sitekey="6LfdcFYUAAAAACTMMh-3MOPFBM6WaKEJ0NI7Khcu"></div>
 	<!-- <script>
var RecaptchaOptions = {
   theme : 'white',
   lang : 'es',
   tabindex : 4
};
</script>-->
<?php 
/*require_once('recaptchalib.php');
$publickey = "6LfdcFYUAAAAACTMMh-3MOPFBM6WaKEJ0NI7Khcu"; // you got this from the signup page
echo recaptcha_get_html($publickey);*/
?>
		</div>
<div class="clear"></div>
  <p>
    <label>
      <input name="enviar" type="submit" class="botones" id="enviar" value="Registrarse" />
    </label>
    &nbsp; <a href="index.php">Ya soy un usuario registrado</a>
  </p>
  <p>
  	 
    <input type="hidden" name="MM_insert" value="formregistrarse" />
  </p>
  <p>&nbsp;</p>
</form>
</div>

	
</div>

<!-- Final -->    
<div style="clear:both;"></div>  
<div id="final" class="final">
	<p>
  	<a href="reglas.php" class="botoneschicos">Reglas del juego</a>  |
  	<a href="contacto.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
  	<a href="terminos.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
    </p>
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />

</div>
<!-- Final --> 
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4, maxChars:18});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:6, maxChars:18});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:4, maxChars:30});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "contrasena");
//-->
</script>
</body>
</html>
