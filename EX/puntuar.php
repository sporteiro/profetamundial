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
$MM_authorizedUsers = "administrador";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "administrador.php";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "formpuntaje")) {
  $updateSQL = sprintf("UPDATE usuarios SET credito=%s, puntos=%s WHERE usuario=%s",
                       GetSQLValueString($_POST['credito'], "int"),
		       GetSQLValueString($_POST['puntos'], "int"),
                       GetSQLValueString($_POST['ocultousuario'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "puntuar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_todoslosusuarios = "SELECT * FROM usuarios ORDER BY usuario DESC";
$todoslosusuarios = mysql_query($query_todoslosusuarios, $conexion) or die(mysql_error());
$row_todoslosusuarios = mysql_fetch_assoc($todoslosusuarios);
$totalRows_todoslosusuarios = mysql_num_rows($todoslosusuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="robots" content="noindex, nofollow, noarchive" />
<title>Puntuar</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<div id="titulo"><img src="imagenes/profetamundial.png" width="310" height="103" alt="Profeta Mundial" /></div>
<div class="contenedora">
<strong><span class="letrasgrandes">PUNTUAR USUARIOS:</span></strong>
<p>
<a href="mamerica.php" class="botoneschicos" target="_blank">Poner resultado</a>  <a href="compararypuntuar.php" class="botoneschicos" target="_blank">Comparar</a>
</p>
  <div class="tablaclasificacion">
   
     <?php do { ?>
      <div class="tablaresultados">  
	  <form action="<?php echo $editFormAction; ?>" id="formpuntaje" name="formpuntaje" method="POST">	
		<b><?php echo $row_todoslosusuarios['nombre']; ?></b><br />
		<div class="comentarios"> <br />
		 <a href="veramerica.php?verlode=<?php echo $row_todoslosusuarios['usuario']; ?>" target="_blank" class="botoneschicos">Pronostico America</a>
      
          <input name="ocultousuario" type="hidden" id="ocultousuario" value="<?php echo $row_todoslosusuarios['usuario']; ?>" />
	  <p style=" float:right;">
          <input name="credito" type="text" class="botoneschicos" id="credito" value="<?php echo $row_todoslosusuarios['credito']; ?>" size="3" maxlength="3" /> &phi; de credito
	   <br />
	  Nombre de usuario: <b><?php echo $row_todoslosusuarios['usuario']; ?></b><br />
	  Email:  <b><?php echo $row_todoslosusuarios['email']; ?></b>
	  </p>
      	<p>   
	Puntos: <input name="puntos" type="text" class="botoneschicos" id="puntos" value="<?php echo $row_todoslosusuarios['puntos']; ?>" size="3" maxlength="3" />
	</p>
        
<input name="Actualizar" type="submit" class="botones" id="Actualizar" value=" "  style="background-image:url(imagenes/actualizar.png); background-repeat:no-repeat; background-position:center; cursor:pointer; " />

      <input type="hidden" name="MM_update" value="formpuntaje" />
		<br />  
	</div>  
   </form>
 </div>
      <br />

       <?php } while ($row_todoslosusuarios = mysql_fetch_assoc($todoslosusuarios)); ?>
    
     
  </div><br /><br />
  <div>
<a href="empezar.php" class="botones">IR A MI CUENTA</a> <a href="<?php echo $logoutAction ?>"><span class="botones">Desconectarse</span></a></div>
<br />
<br />
</div>
<br /><br />

</body>
</html>
<?php
mysql_free_result($todoslosusuarios);
?>
