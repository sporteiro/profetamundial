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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Soluci&oacute;n de Problemas</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" width="310" height="103" alt="Profeta Mundial" /></div>
<div class="contenedora">
  <p><strong>TU MENSAJE FUE ENVIADO</strong></p>
  <div>
      <p>Esperamos poder solucionar tu problema lo mas rapido posible.</p>
      <p>La respuesta a tu mensaje va a ser enviada al email que nos proporcionaste</p>
<p>Por las dudas, no te olvides de revisar la casilla de spam de tu servidor de correo electr&oacute;nico.</p>
<p>&iexcl;Gracias por participar en Profeta Mundial!</p>
<p>&nbsp;</p>
      <p>
      <a href="empezar.php" class="botones">Volver a mi cuenta </a></p>
      <p>&nbsp;</p>

</div>
</div>
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico"/><br />
Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a></div>
</body>
</html>
<?php
mysql_free_result($recordusuarios);
?>
