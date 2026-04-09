<?php require_once('Connections/conexion.php'); ?>
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

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysql_query($query_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysql_num_rows($recordusuarios);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Reglas del juego</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" /></div>
<div class="contenedora_2020">
<div style="padding:10px;">
  <p><strong>Reglas de los Oscar 2020:</strong></p>
  <p class="letraschicas">Usted, <?php echo $row_recordusuarios['nombre']; ?>, usuario de nombre <?php echo $row_recordusuarios['usuario']; ?>, al ingresar como usuario en Profeta Mundial  (profetamundial.com.ar), admite haber le&iacute;do, entendido y aceptado sin ning&uacute;n  tipo de excepci&oacute;n, las siguientes Reglas del Juego (en adelante, Reglas), as&iacute;  como sus posibles futuras modificaciones en el mismo momento en que ellas se  produjeren, y se declara responsable en caso de cualquier problema que surgiese  debido a cualquier tipo de malentendido relacionado con las Reglas mencionadas.  </p>
  <p class="letraschicas"><strong>GANADOR DEL JUEGO:</strong></p>
  <p class="letraschicas">El/la ganador/a o los/las ganadores/as del juego ser&aacute;n  aquellos usuarios que consigan mas puntos al termino de la entrega de los Oscar 2020. Para determinar los puntos de un usuario, se utilizaran  los criterios de puntuaci&oacute;n que se detallan en el Sistema de puntuaci&oacute;n.  </p>
  <p class="letraschicas"><strong>SISTEMA DE PUNTUACION:</strong></p>
  <p class="letraschicas">Cada usuario recibira 1(un) punto por cada coincidencia entre el ganador del premio en la categoria seleccionada en Profeta Mundial y el premio Oscar correspondiente. <br />En caso de que la maxima puntuacion pertenezca a mas de un usuario, todos los usuarios con la maxima puntuaci&oacute;n ser&aacute;n conciderados ganadores y el premio se repartir&aacute; entre ellos.</p>
<p class="letraschicas">&nbsp;</p>
<p class="letraschicas">&nbsp;</p>
  <p class="letraschicas"><strong>Fecha limite de participaci&oacute;n:</strong></p>
  <p class="letraschicas">El Sabado 08 de Febrero de 2020 a las 00:00 horas (WET)  finalizara el plazo de admisi&oacute;n y/o modificaci&oacute;n para el juego. A partir de ese  momento, los usuarios ya registrados podr&aacute;n acceder a su cuenta, pero ya no  podr&aacute;n realizar modificaciones en la misma.</p>
<p class="letraschicas">&nbsp;</p>
  <p class="letraschicas">&nbsp;</p>
<p><a href="empezar.php" class="botones">VOLVER</a></p></div>
  <p class="letraschicas">&nbsp;</p>
</div>
<br />
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />
</body>
</html>
