<?php require_once('Connections/conexion.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  mysql_select_db($database_conexion, $conexion);
  mysql_query("UPDATE usuarios SET enlinea='no' WHERE usuario='".$_SESSION['MM_Username']."'")or die(mysql_error());
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET contrasena=%s, nombre=%s, email=%s, ip=%s WHERE usuario=%s",
                       GetSQLValueString(sha1($_POST['contrasena']), "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['ocultoip'], "text"),
                       GetSQLValueString($_POST['ocultusuario'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


//SUBIR IMAGEN
	if ($_FILES['imagen']['name']!='')	{
		echo $_FILES['imagen']['name'];
		$rutaimagenes='imagenes/avatares/';
		$tipo_imagen=$_FILES["imagen"]["type"];
		if ((($tipo_imagen == "image/jpeg")or($tipo_imagen == "image/png")or($tipo_imagen == "image/gif")) && ($_FILES["imagen"]["size"] < 250000))  {
		move_uploaded_file($_FILES["imagen"]["tmp_name"],
 		$rutaimagenes.$_FILES["imagen"]["name"]);
		$updateSQL = sprintf("UPDATE usuarios SET avatar=%s WHERE usuario=%s",
		GetSQLValueString($_FILES['imagen']['name'], "text"),
		GetSQLValueString($_POST['ocultusuario'], "text"));
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
		}
		else if (($tipo_imagen != "image/jpeg")or($tipo_imagen != "image/png")or($tipo_imagen != "image/gif") or ($_FILES["imagen"]["size"] > 250000))  {
			header('Location: modificar.php?error=1');		
			break;
		}
	}
//
  $updateGoTo = "empezar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysql_query($query_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysql_num_rows($recordusuarios);

mysql_select_db($database_conexion, $conexion);
$query_usutorneo = "SELECT * FROM Torneos WHERE inscriptos = '".$_SESSION['MM_Username']."'";
$usutorneo = mysql_query($query_usutorneo, $conexion) or die(mysql_error());
$row_usutorneo = mysql_fetch_assoc($usutorneo);
$totalRows_usutorneo = mysql_num_rows($usutorneo);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Modificar mis datos</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script src="sha1.js" type="text/javascript"></script>
<script type="text/javascript">
function encriptar()	{
	var antigua=document.getElementById('contrasenantigua').value;
	ant=calcSHA1(antigua);
	document.getElementById('contrasenantigua').value=ant;
}
</script>
</head>

<body>
<?php
function getIP() {
if (isset($_SERVER)) {
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
return $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
return $_SERVER['REMOTE_ADDR'];
}
} else {
if (isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])) {
return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
} else {
return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
}
}
}
?>

<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?> Credito: <?php echo $row_recordusuarios['credito']; ?>&phi;<br />
  <a href="modificar.php">Mi cuenta</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>

<!-- Fin de la cabecera-->
<br />
<div class="contenedora">
<br /><br />
<!-- DERECHA -->
	 <div class="tablaIzquierda">
  		<p>
        <strong>Modificar tus datos de usuario</strong>
	<img src="imagenes/avatares/<?php echo $row_recordusuarios['avatar']; ?>" width="64" height="64" style="float:left;"/> 
        </p>
		<div style="text-align: right; margin-right:30%;">
      	<form id="form1" name="form1" method="post" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
     	 <p>Tu nombre de usuario es: <strong><?php echo $row_recordusuarios['usuario']; ?></strong>
        <input name="ocultusuario" type="hidden" id="ocultusuario" value="<?php echo $row_recordusuarios['usuario']; ?>" />
      	</p>
     	<p>Tu nombre es: 
        <span id="sprytextfield3">
      	<label>
        	<input name="nombre" type="text" class="letrasgrandes" id="nombre" value="<?php echo $row_recordusuarios['nombre']; ?>" />
      		</label><br />
      		<span class="textfieldRequiredMsg">Se necesita un valor.
            </span>
            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.
            </span>
            <span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.
            </span>
         </span>
       </p>
       <p>Contrase&ntilde;a antigua: 
        <input name="antigua" type="hidden" id="antigua" value="<?php echo $row_recordusuarios['contrasena']; ?>" />
        <span id="spryconfirm1">
        <label>
          <input name="contrasenantigua" type="password" class="letrasgrandes" id="contrasenantigua" onchange="encriptar()"/>
        </label><br />
        <span class="confirmRequiredMsg">Campo obligatorio</span><span class="confirmInvalidMsg">Esa no era tu contrase&ntilde;a</span></span>
        </p>
    	<p> Contrase&ntilde;a Nueva: <span id="sprytextfield1">
    <label>
      <input name="contrasena" type="password" class="letrasgrandes" id="contrasena" />
    </label><br />
   			 <span class="textfieldRequiredMsg">Campo obligatorio</span>
            <span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres</span><span class="textfieldMaxCharsMsg">Demasiados caracteres.
    		</span>
        </span>
    	</p>
    	<p>Tu correo electr&oacute;nico: <span id="sprytextfield2">
      <label>
        <input name="email" type="text" class="letrasgrandes" id="email" value="<?php echo $row_recordusuarios['email']; ?>" />
      </label><br />
      <span class="textfieldRequiredMsg">Campo obligatorio</span><span class="textfieldInvalidFormatMsg">Tiene que ser un correo electr&oacute;nico</span></span>
      	</p>
	<p>
	Avatar: <br />
	<?if (isset($_GET['error']) && ($_GET['error']==1)) {
		echo "<span class='letrasgrandesnaranjas'>Hubo un problema al subir tu imagen. Aseguráte de que cumple los siguientes requisitos:</span><br />";
	}?>
	<span class="letraschicas">Pod&eacute;s subir cualquier imagen jpg, png o gif que ocupe <b>250Kb</b> como maximo</span>
	<input type="file" name="imagen" class="botoneschicos" id="imagen"/>
	</p>
		<p>
  <label>
    <input name="ocultoip" type="hidden" id="ocultoip" value="primera ip <?php echo $row_recordusuarios['ip']; ?>, segunda ip, <?php echo getIP(); ?>" />
    <input name="modificar" type="submit" class="botones" id="modificar" value="Modificar" />
  </label>
		</p>
<input type="hidden" name="MM_update" value="form1" />
    </form>
    </div>
  </div>
 <!-- FIN DERECHA -->
  <!-- IZQUIERDA -->
     <div class="tablaDerecha">
		<div style="padding-bottom:1%; padding-top:1%; padding-left: 1%; padding-right: 1%;">
			<p><b>&iexcl;Gracias por participar en Profeta Mundial!</b>
        	</p>
			<p>Tu credito es: <br />
			<b><?php echo $row_recordusuarios['credito']; ?> &phi;</b>
            </p>
      		<p><b>Mis pronosticos</b></p>
            <?php do { ?>
            <p>
    		<a href="<?php echo $row_usutorneo['nombreT']; ?>.php" class="botoneschicos"><?php echo $row_usutorneo['descripcion']; ?></a>
        	</p>
            <?php } while ($row_usutorneo = mysql_fetch_assoc($usutorneo)); ?>
      		<p>&nbsp;</p>
		<p><b>Mis Trofeos</b></p>
			<b><?php echo $row_recordusuarios['trofeos']; ?></b>
		</div>
</div>
 <!--  FIN IZQUIERDA -->
 <br /><br />
 <div style="clear:both;"></div>
 <br /><br />
</div>
<!-- Final -->    
<br />
<div style="clear:both;"></div>  
<div id="final" class="final">
	<p>
  	<a href="reglas.php" class="botoneschicos">Reglas del juego</a>  |
  	<a href="contacto.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
  	<a href="terminos.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
    </p>
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
</div>
<!-- Final --> 
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:6, maxChars:18});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "antigua");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:4, maxChars:30});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($recordusuarios);
?>
