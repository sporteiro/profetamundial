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

$colname_RecordgrupoA = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoA = $_GET['otrousuario'];
  
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoA = sprintf("SELECT * FROM partidos WHERE grupo='a' AND usuario = %s", GetSQLValueString($colname_RecordgrupoA, "text"));
$RecordgrupoA = mysql_query($query_RecordgrupoA, $conexion) or die(mysql_error());
$row_RecordgrupoA = mysql_fetch_assoc($RecordgrupoA);
$totalRows_RecordgrupoA = mysql_num_rows($RecordgrupoA);

$colname_RecordgrupoB = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoB = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoB = sprintf("SELECT * FROM partidos WHERE grupo='b' AND usuario = %s", GetSQLValueString($colname_RecordgrupoB, "text"));
$RecordgrupoB = mysql_query($query_RecordgrupoB, $conexion) or die(mysql_error());
$row_RecordgrupoB = mysql_fetch_assoc($RecordgrupoB);
$totalRows_RecordgrupoB = mysql_num_rows($RecordgrupoB);

$colname_RecordgrupoC = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoC = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoC = sprintf("SELECT * FROM partidos WHERE grupo='c' AND usuario = %s", GetSQLValueString($colname_RecordgrupoC, "text"));
$RecordgrupoC = mysql_query($query_RecordgrupoC, $conexion) or die(mysql_error());
$row_RecordgrupoC = mysql_fetch_assoc($RecordgrupoC);
$totalRows_RecordgrupoC = mysql_num_rows($RecordgrupoC);

$colname_RecordgrupoD = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoD = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoD = sprintf("SELECT * FROM partidos WHERE grupo='d' AND usuario = %s", GetSQLValueString($colname_RecordgrupoD, "text"));
$RecordgrupoD = mysql_query($query_RecordgrupoD, $conexion) or die(mysql_error());
$row_RecordgrupoD = mysql_fetch_assoc($RecordgrupoD);
$totalRows_RecordgrupoD = mysql_num_rows($RecordgrupoD);

$colname_RecordgrupoE = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoE = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoE = sprintf("SELECT * FROM partidos WHERE grupo='e' AND usuario = %s", GetSQLValueString($colname_RecordgrupoE, "text"));
$RecordgrupoE = mysql_query($query_RecordgrupoE, $conexion) or die(mysql_error());
$row_RecordgrupoE = mysql_fetch_assoc($RecordgrupoE);
$totalRows_RecordgrupoE = mysql_num_rows($RecordgrupoE);

$colname_RecordgrupoF = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoF = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoF = sprintf("SELECT * FROM partidos WHERE grupo='f' AND usuario = %s", GetSQLValueString($colname_RecordgrupoF, "text"));
$RecordgrupoF = mysql_query($query_RecordgrupoF, $conexion) or die(mysql_error());
$row_RecordgrupoF = mysql_fetch_assoc($RecordgrupoF);
$totalRows_RecordgrupoF = mysql_num_rows($RecordgrupoF);

$colname_RecordgrupoG = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoG = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoG = sprintf("SELECT * FROM partidos WHERE grupo='g' AND usuario = %s", GetSQLValueString($colname_RecordgrupoG, "text"));
$RecordgrupoG = mysql_query($query_RecordgrupoG, $conexion) or die(mysql_error());
$row_RecordgrupoG = mysql_fetch_assoc($RecordgrupoG);
$totalRows_RecordgrupoG = mysql_num_rows($RecordgrupoG);

$colname_RecordgrupoH = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordgrupoH = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordgrupoH = sprintf("SELECT * FROM partidos WHERE grupo='h' AND usuario = %s", GetSQLValueString($colname_RecordgrupoH, "text"));
$RecordgrupoH = mysql_query($query_RecordgrupoH, $conexion) or die(mysql_error());
$row_RecordgrupoH = mysql_fetch_assoc($RecordgrupoH);
$totalRows_RecordgrupoH = mysql_num_rows($RecordgrupoH);

$colname_RecordOctavosEquipos = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordOctavosEquipos = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordOctavosEquipos = sprintf("SELECT * FROM octavos WHERE usuario = %s", GetSQLValueString($colname_RecordOctavosEquipos, "text"));
$RecordOctavosEquipos = mysql_query($query_RecordOctavosEquipos, $conexion) or die(mysql_error());
$row_RecordOctavosEquipos = mysql_fetch_assoc($RecordOctavosEquipos);
$totalRows_RecordOctavosEquipos = mysql_num_rows($RecordOctavosEquipos);

$colname_RecordoctavosResultados = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_RecordoctavosResultados = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_RecordoctavosResultados = sprintf("SELECT * FROM partidosegunda WHERE usuario = %s", GetSQLValueString($colname_RecordoctavosResultados, "text"));
$RecordoctavosResultados = mysql_query($query_RecordoctavosResultados, $conexion) or die(mysql_error());
$row_RecordoctavosResultados = mysql_fetch_assoc($RecordoctavosResultados);
$totalRows_RecordoctavosResultados = mysql_num_rows($RecordoctavosResultados);

$colname_recordusuarios = "-1";
if (isset($_GET['otrousuario'])) {
  $colname_recordusuarios = $_GET['otrousuario'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysql_query($query_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);
$totalRows_recordusuarios = mysql_num_rows($recordusuarios);

$colname_usuarioconectado = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuarioconectado = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_usuarioconectado = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usuarioconectado, "text"));
$usuarioconectado = mysql_query($query_usuarioconectado, $conexion) or die(mysql_error());
$row_usuarioconectado = mysql_fetch_assoc($usuarioconectado);
$totalRows_usuarioconectado = mysql_num_rows($usuarioconectado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pronostico de: <?php echo $row_recordusuarios['usuario']; ?></title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script type="text/javascript">
<!--
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
</head>

<body>
<div class="usuarioconectado" id="usuarioconectado"> 
  <img src="imagenes/profetamundial.png" width="171" height="57" alt="Profeta Mundial" />
  <p>Pronostico de <strong><?php echo $row_recordusuarios['usuario']; ?></strong><br />
 </p>
 
  <br />
<a href="index.php" class="botones">Volver</a>
<br />
<br />
<br />
<br /></div>

<p>&nbsp;</p>
<div id="contenedora" class="contenedora">
<br />
<div id="partidos">
<p><strong><?php echo $row_recordusuarios['usuario']; ?> pronostico esto:</strong></p>
<p><strong>Grupo A:</strong></p>

<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Sudafrica </td>
    <td width="134"><?php echo $row_RecordgrupoA['a1']; ?></td>
    <td width="191">Mexico</td>
    <td width="14"><?php echo $row_RecordgrupoA['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Uruguay</td>
    <td><?php echo $row_RecordgrupoA['a3']; ?></td>
    <td>Francia </td>
    <td><?php echo $row_RecordgrupoA['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Sudafrica</td>
    <td><?php echo $row_RecordgrupoA['a5']; ?></td>
    <td>Uruguay</td>
    <td><?php echo $row_RecordgrupoA['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Francia</td>
    <td><?php echo $row_RecordgrupoA['a7']; ?></td>
    <td>Mexico </td>
    <td><?php echo $row_RecordgrupoA['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Mexico</td>
    <td><?php echo $row_RecordgrupoA['a9']; ?></td>
    <td>Uruguay </td>
    <td><?php echo $row_RecordgrupoA['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Francia </td>
    <td><?php echo $row_RecordgrupoA['a11']; ?></td>
    <td>Sudafrica </td>
    <td><?php echo $row_RecordgrupoA['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo B:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Argentina </td>
    <td width="134"><?php echo $row_RecordgrupoB['a1']; ?></td>
    <td width="191">Nigeria</td>
    <td width="14"><?php echo $row_RecordgrupoB['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Corea del Sur</td>
    <td><?php echo $row_RecordgrupoB['a3']; ?></td>
    <td>Grecia </td>
    <td><?php echo $row_RecordgrupoB['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Argentina</td>
    <td><?php echo $row_RecordgrupoB['a5']; ?></td>
    <td>Corea del Sur</td>
    <td><?php echo $row_RecordgrupoB['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Grecia</td>
    <td><?php echo $row_RecordgrupoB['a7']; ?></td>
    <td>Nigeria </td>
    <td><?php echo $row_RecordgrupoB['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nigeria</td>
    <td><?php echo $row_RecordgrupoB['a9']; ?></td>
    <td>Corea del Sur </td>
    <td><?php echo $row_RecordgrupoB['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Grecia </td>
    <td><?php echo $row_RecordgrupoB['a11']; ?></td>
    <td>Argentina </td>
    <td><?php echo $row_RecordgrupoB['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo C:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Inglaterra </td>
    <td width="134"><?php echo $row_RecordgrupoC['a1']; ?></td>
    <td width="191">Estados Unidos</td>
    <td width="14"><?php echo $row_RecordgrupoC['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Argelia</td>
    <td><?php echo $row_RecordgrupoC['a3']; ?></td>
    <td>Eslovenia </td>
    <td><?php echo $row_RecordgrupoC['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Inglaterra</td>
    <td><?php echo $row_RecordgrupoC['a5']; ?></td>
    <td>Argelia</td>
    <td><?php echo $row_RecordgrupoC['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Eslovenia</td>
    <td><?php echo $row_RecordgrupoC['a7']; ?></td>
    <td>Estados Unidos </td>
    <td><?php echo $row_RecordgrupoC['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Estados Unidos</td>
    <td><?php echo $row_RecordgrupoC['a9']; ?></td>
    <td>Argelia </td>
    <td><?php echo $row_RecordgrupoC['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Eslovenia </td>
    <td><?php echo $row_RecordgrupoC['a11']; ?></td>
    <td>Inglaterra </td>
    <td><?php echo $row_RecordgrupoC['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo D:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Alemania </td>
    <td width="134"><?php echo $row_RecordgrupoD['a1']; ?></td>
    <td width="191">Australia</td>
    <td width="14"><?php echo $row_RecordgrupoD['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Serbia</td>
    <td><?php echo $row_RecordgrupoD['a3']; ?></td>
    <td>Ghana </td>
    <td><?php echo $row_RecordgrupoD['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alemania</td>
    <td><?php echo $row_RecordgrupoD['a5']; ?></td>
    <td>Serbia</td>
    <td><?php echo $row_RecordgrupoD['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Ghana</td>
    <td><?php echo $row_RecordgrupoD['a7']; ?></td>
    <td>Australia </td>
    <td><?php echo $row_RecordgrupoD['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Australia</td>
    <td><?php echo $row_RecordgrupoD['a9']; ?></td>
    <td>Serbia </td>
    <td><?php echo $row_RecordgrupoD['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Ghana </td>
    <td><?php echo $row_RecordgrupoD['a11']; ?></td>
    <td>Alemania </td>
    <td><?php echo $row_RecordgrupoD['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo E:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Holanda </td>
    <td width="134"><?php echo $row_RecordgrupoE['a1']; ?></td>
    <td width="191">Dinamarca</td>
    <td width="14"><?php echo $row_RecordgrupoE['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Japon</td>
    <td><?php echo $row_RecordgrupoE['a3']; ?></td>
    <td>Camerun </td>
    <td><?php echo $row_RecordgrupoE['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Holanda</td>
    <td><?php echo $row_RecordgrupoE['a5']; ?></td>
    <td>Japon</td>
    <td><?php echo $row_RecordgrupoE['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Camerun</td>
    <td><?php echo $row_RecordgrupoE['a7']; ?></td>
    <td>Dinamarca </td>
    <td><?php echo $row_RecordgrupoE['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dinamarca</td>
    <td><?php echo $row_RecordgrupoE['a9']; ?></td>
    <td>Japon </td>
    <td><?php echo $row_RecordgrupoE['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Camerun </td>
    <td><?php echo $row_RecordgrupoE['a11']; ?></td>
    <td>Holanda </td>
    <td><?php echo $row_RecordgrupoE['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo F:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Italia </td>
    <td width="134"><?php echo $row_RecordgrupoF['a1']; ?></td>
    <td width="191">Paraguay</td>
    <td width="14"><?php echo $row_RecordgrupoF['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Nueva Zelanda</td>
    <td><?php echo $row_RecordgrupoF['a3']; ?></td>
    <td>Eslovaquia </td>
    <td><?php echo $row_RecordgrupoF['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Italia</td>
    <td><?php echo $row_RecordgrupoF['a5']; ?></td>
    <td>Nueva Zelanda</td>
    <td><?php echo $row_RecordgrupoF['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Eslovaquia</td>
    <td><?php echo $row_RecordgrupoF['a7']; ?></td>
    <td>Paraguay </td>
    <td><?php echo $row_RecordgrupoF['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Paraguay</td>
    <td><?php echo $row_RecordgrupoF['a9']; ?></td>
    <td>Nueva Zelanda </td>
    <td><?php echo $row_RecordgrupoF['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Eslovaquia </td>
    <td><?php echo $row_RecordgrupoF['a11']; ?></td>
    <td>Italia </td>
    <td><?php echo $row_RecordgrupoF['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo G:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Brasil</td>
    <td width="134"><?php echo $row_RecordgrupoG['a1']; ?></td>
    <td width="191">Corea del Norte</td>
    <td width="14"><?php echo $row_RecordgrupoG['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Costa de Marfil</td>
    <td><?php echo $row_RecordgrupoG['a3']; ?></td>
    <td>Portugal </td>
    <td><?php echo $row_RecordgrupoG['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Brasil</td>
    <td><?php echo $row_RecordgrupoG['a5']; ?></td>
    <td>Costa de Marfil</td>
    <td><?php echo $row_RecordgrupoG['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Portugal</td>
    <td><?php echo $row_RecordgrupoG['a7']; ?></td>
    <td>Corea del Norte </td>
    <td><?php echo $row_RecordgrupoG['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Corea del Norte</td>
    <td><?php echo $row_RecordgrupoG['a9']; ?></td>
    <td>Costa de Marfil </td>
    <td><?php echo $row_RecordgrupoG['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Portugal </td>
    <td><?php echo $row_RecordgrupoG['a11']; ?></td>
    <td>Brasil</td>
    <td><?php echo $row_RecordgrupoG['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Grupo H:</strong></p>
<table width="500" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion" style="margin:0 auto;">
  <tr>
    <td width="126">Espa&ntilde;a</td>
    <td width="134"><?php echo $row_RecordgrupoH['a1']; ?></td>
    <td width="191">Suiza</td>
    <td width="14"><?php echo $row_RecordgrupoH['a2']; ?></td>
    <td width="17">&nbsp;</td>
  </tr>
  <tr>
    <td>Honduras</td>
    <td><?php echo $row_RecordgrupoH['a3']; ?></td>
    <td>Chile </td>
    <td><?php echo $row_RecordgrupoH['a4']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Espa&ntilde;a</td>
    <td><?php echo $row_RecordgrupoH['a5']; ?></td>
    <td>Honduras</td>
    <td><?php echo $row_RecordgrupoH['a6']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Chile</td>
    <td><?php echo $row_RecordgrupoH['a7']; ?></td>
    <td>Suiza </td>
    <td><?php echo $row_RecordgrupoH['a8']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Suiza</td>
    <td><?php echo $row_RecordgrupoH['a9']; ?></td>
    <td>Honduras </td>
    <td><?php echo $row_RecordgrupoH['a10']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Chile </td>
    <td><?php echo $row_RecordgrupoH['a11']; ?></td>
    <td>Espa&ntilde;a</td>
    <td><?php echo $row_RecordgrupoH['a12']; ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p><strong>Segunda Ronda:</strong></p>
<table width="600" height="auto" border="0" cellpadding="0" cellspacing="0" class="tablaresultados" style="background-image:url(imagenes/banderas/<?php echo $row_RecordOctavosEquipos['campeon']; ?>.png); background-repeat:no-repeat; background-position:center;">
  <tr>
    <td width="132" class="fixture"><?php echo $row_RecordOctavosEquipos['1A']; ?> <?php echo $row_RecordoctavosResultados['1A']; ?></td>
    <td width="115" class="lineavertical">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="15">&nbsp;</td>
    <td width="15" class="lineaderecha">&nbsp;</td>
    <td width="25" class="fixture"><?php echo $row_RecordOctavosEquipos['1B']; ?> <?php echo $row_RecordoctavosResultados['1B']; ?></td>
  </tr>
  <tr>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W49']; ?> <?php echo $row_RecordoctavosResultados['W49']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="4"><img src="imagenes/copa.gif" width="42" height="100" alt="Copa del Mundo" /></td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W52']; ?> <?php echo $row_RecordoctavosResultados['W52']; ?></td>
    <td class="lineavertical">&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2B']; ?> <?php echo $row_RecordoctavosResultados['2B']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2A']; ?> <?php echo $row_RecordoctavosResultados['2A']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W58']; ?> <?php echo $row_RecordoctavosResultados['W58']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W59']; ?> <?php echo $row_RecordoctavosResultados['W59']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1C']; ?> <?php echo $row_RecordoctavosResultados['1C']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1D']; ?> <?php echo $row_RecordoctavosResultados['1D']; ?></td>
  </tr>
  <tr>
    <td height="18" class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W50']; ?> <?php echo $row_RecordoctavosResultados['W50']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
   <td class="fixture">Campeon: <?php echo $row_RecordOctavosEquipos['campeon']; ?> </td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W51']; ?> <?php echo $row_RecordoctavosResultados['W51']; ?></td>
    <td class="lineavertical">&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2D']; ?> <?php echo $row_RecordoctavosResultados['2D']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="linea2lados">&nbsp;</td>
     <td class="lineariba"> </td>
    <td class="linea2lados">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2C']; ?> <?php echo $row_RecordoctavosResultados['2C']; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W61']; ?> <?php echo $row_RecordoctavosResultados['W61']; ?></td>
    <td class="linea2lados">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W62']; ?> <?php echo $row_RecordoctavosResultados['W62']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1E']; ?> <?php echo $row_RecordoctavosResultados['1E']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1F']; ?> <?php echo $row_RecordoctavosResultados['1F']; ?></td>
  </tr>
  <tr>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W53']; ?> <?php echo $row_RecordoctavosResultados['W53']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['L1']; ?> <?php echo $row_RecordoctavosResultados['L1']; ?></td>
    <td class="linea2lados">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['L2']; ?> <?php echo $row_RecordoctavosResultados['L2']; ?></td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W55']; ?> <?php echo $row_RecordoctavosResultados['W55']; ?></td>
    <td class="lineavertical">&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2F']; ?> <?php echo $row_RecordoctavosResultados['2F']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td class="linea2lados">&nbsp;</td>
    <td class="fixture">Tercero:  <?php echo $row_RecordOctavosEquipos['tercero']; ?></td>
    <td class="linea2lados">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2E']; ?> <?php echo $row_RecordoctavosResultados['2E']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W57']; ?> <?php echo $row_RecordoctavosResultados['W57']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W60']; ?> <?php echo $row_RecordoctavosResultados['W60']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1G']; ?> <?php echo $row_RecordoctavosResultados['1G']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['1H']; ?> <?php echo $row_RecordoctavosResultados['1H']; ?></td>
  </tr>
  <tr>
    <td height="18" class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W54']; ?> <?php echo $row_RecordoctavosResultados['W54']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="2" class="fixture">Goleador:<br /> <?php echo $row_RecordOctavosEquipos['goleador']; ?> (<?php echo $row_RecordOctavosEquipos['paisgoleador']; ?>)</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['W56']; ?> <?php echo $row_RecordoctavosResultados['W56']; ?></td>
    <td class="lineavertical">&nbsp;</td>
  </tr>
  <tr>
    <td height="18" class="fixture"><?php echo $row_RecordOctavosEquipos['2H']; ?> <?php echo $row_RecordoctavosResultados['2H']; ?></td>
    <td class="lineavertical">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="lineaderecha">&nbsp;</td>
    <td class="fixture"><?php echo $row_RecordOctavosEquipos['2G']; ?> <?php echo $row_RecordoctavosResultados['2G']; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><br />
</p>
</div>
</div>
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio:<a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />
Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a></div>
</body>
</html>
<?php
mysql_free_result($RecordgrupoA);

mysql_free_result($recordusuarios);

mysql_free_result($usuarioconectado);

mysql_free_result($RecordOctavosEquipos);
?>
