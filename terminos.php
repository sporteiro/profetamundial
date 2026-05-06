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

  global $conexion;
  $theValue = mysqli_real_escape_string($conexion, $theValue);

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
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysqli_num_rows($recordusuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>T&eacute;rminos generales de uso</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" /></div>
<div class="contenedora_2018">
<div style="padding:10px;">
  <p><strong>T&eacute;rminos generales de uso: </strong></p>
  <p class="letraschicas">Al usar y/o ingresar a este sitio de Internet, usted acepta y se  sujeta expresamente a los presentes t&eacute;rminos y condiciones. Si usted no   esta de acuerdo con cualquiera de los T&eacute;rminos de Servicio, por favor no   utilice el Sitio de Internet Profeta Mundial.</p>
  <p class="letraschicas">Profetamundial.com, ProfetaMundial.com, (en adelante Profeta Mundial) podr&aacute;, a su sola discreci&oacute;n, modificar o   enmendar estos T&eacute;rminos de Servicio y pol&iacute;ticas en cualquier momento, y   usted acepta expresamente que quedar&aacute; sujeto a dichas modificaciones o   enmiendas. Nada de lo establecido en el presente Contrato deber&aacute; ser   considerado como un otorgamiento de derechos o beneficios a terceros.<br />
  </p>
  <p class="letraschicas">El Sitio de Internet Profeta Mundial puede contener enlaces a sitios de   Internet de terceras personas  que no son propiedad de ni son   controlados por Profeta Mundial. Profeta Mundial no tiene control alguno sobre, y   no asume responsabilidad alguna por el contenido, pol&iacute;ticas de   privacidad o pr&aacute;cticas de ning&uacute;n sitio de Internet propiedad de o bajo   el control de terceros. En adici&oacute;n, Profeta Mundial no censurar&aacute; y no podr&aacute;   censurar o editar el contenido de ning&uacute;n sitio propiedad de o controlado   por un tercero. Al utilizar y/o visitar el Sitio de Internet, usted   libera expresamente a Profeta Mundial de toda y cualquier responsabilidad   que derivada del uso que usted haga de un sitio de Internet de un   tercero.</p>
  <p class="letraschicas">El contenido del sitio de Internet Profeta Mundial, son propiedad de   Profeta Mundial. El Contenido del Sitio de Internet es prove&iacute;do para su   informaci&oacute;n y uso personal solamente y el mismo no podr&aacute; ser descargado,   copiado, reproducido, distribuido, transferido, transmitido, expuesto,   vendido, licenciado o explotado de cualquier otra forma para cualquier   prop&oacute;sito sin el consentimiento previo y por escrito de los   correspondientes due&ntilde;os. Profeta Mundial se reserva todos los derechos que   no se encuentran expresamente otorgados en y para el Sitio de Internet y   el Contenido.</p>
  <p class="letraschicas">Las cuentas de usuario y toda la informacion contenida en ellas, son propiedad exclusiva de Profeta Mundial, que a su sola discreci&oacute;n, y sin previo aviso, es libre de modificar, cancelar, bloquear o eliminar completa o parcialmente la informacion introducida en estas, sin por ello tener que dar ningun tipo de explicaci&oacute;n o informaci&oacute;n adicional a la/las personas que introdujeron dichos datos. Profeta Mundial se reserva tambi&eacute;n el derecho de admision, readmision, expulsion, bloqueo de usuarios y cualquier derecho relacionado con el uso del sitio profetamundial.com</p>
  <p class="letraschicas">Usted entiende que al utilizar el Sitio de Internet Profeta Mundial,   usted estar&aacute; expuesto a Contribuciones de Usuarios de una gran variedad   de fuentes y que Profeta Mundial no es responsable por la exactitud,   utilidad, seguridad o derechos de propiedad intelectual relacionados con   dichas Contribuciones de Usuarios. Usted adicionalmente entiende y   acepta que puede ser expuesto a Contribuciones de Usuarios que pueden   ser imprecisas, ofensivas, indecentes u objetables y usted se obliga a   renunciar y por medio del presente renuncia a cualquier derecho o   defensa legal, ya sea en dinero o de cualquier otra forma que tenga o   pueda tener en contra de Profeta Mundial al respecto y se obliga a   indemnizar y mantener a Profeta Mundial, sus Propietarios/ Operadores,   afiliados y/o licenciantes, libres de cualquier da&ntilde;o o reclamaci&oacute;n de   conformidad con las leyes correspondientes en todos los asuntos   relacionados con el uso del Sitio de Internet.</p>
  <p class="letraschicas">Usted declara la plena aceptacion por su parte a entregar datos personales a Profeta Mundial de manera completamente voluntaria. Profeta Mundial no se hace responsable del uso de estos datos  por causas ajenas a su control ni de ningun otro tipo.</p>
  <p class="letraschicas">Usted declara y reconoce que es una persona f&iacute;sica mayor de 18 a&ntilde;os   o un menor emancipado o que posee autorizaci&oacute;n por parte de sus padres o   tutores y que es totalmente capaz y competente para obligarse bajo los   presentes t&eacute;rminos, condiciones, obligaciones, afirmaciones,   declaraciones y garant&iacute;as de conformidad con lo establecido en los   presentes T&eacute;rminos del Servicio y para sujetarse y cumplir con los   mismos.</p>
  <p>&nbsp;</p>
  <p><a href="empezar.php" class="botones">VOLVER</a></p>
</div>
</div>
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />
</body>
</html>
