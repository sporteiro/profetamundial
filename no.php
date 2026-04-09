<?php require_once('Connections/conexion.php'); ?>
<?php
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=sha1($_POST['contrasena']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "empezar.php";
  $MM_redirectLoginFailed = "no.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT usuario, contrasena, activo FROM usuarios WHERE BINARY usuario=%s AND contrasena=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $filas=mysql_fetch_assoc($LoginRS);
  $activo=$filas['activo'];
  if ($activo=='no') {
	include_once('desactivada.php');
  }
  else if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
     $consulta=mysql_query("UPDATE usuarios SET enlinea='si' WHERE usuario='".$loginUsername."'");
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Profeta Mundial - Ingresar</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" /></div>
<div class="letrasgrandes">
<div class="contenedora_2018">
<p class="letrasgrandesnaranjas"><strong>El usuario o la contrase&ntilde;a introducidos son incorrectos</strong></p>
<div class="letrasgrandes">
<div style="text-align: right; margin-right:30%;">
<div>
<form id="formingreso" name="formingreso" method="POST" action="<?php echo $loginFormAction; ?>">
  <span id="sprytextfield1">
  <label><span class="letrasgrandes">Nombre de usuario</span>
    <input name="usuario" type="text" class="letrasgrandes" id="usuario" />
  </label>
  <span class="textfieldRequiredMsg">Escrib&iacute; tu nombre de usuario</span></span>
  <p><span id="sprytextfield2">
    <label><span class="letrasgrandes">Contrase&ntilde;a</span>
      <input name="contrasena" type="password" class="letrasgrandes" id="contrasena" />
    </label>
    <span class="textfieldRequiredMsg">Escrib&iacute; tu contrase&ntilde;a</span></span> 
    <br />	
    <label>
      <br />
      <input name="enviar" type="submit" class="botones" id="enviar" value="Ingres&aacute;" />
    </label>
  </p>
	<p>
		<a href="contrasena.php">Me olvide la contrase&ntilde;a</a>
	</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
 </div>
</form>
</div>

</div>
</div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
  </script>
  <div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />

</body>
</html>
