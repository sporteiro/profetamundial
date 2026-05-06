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
$colname_otrousuario = "-1";
if (isset($_GET['verlode'])) {
  $colname_otrousuario = $_GET['verlode'];
}
mysql_select_db($database_conexion, $conexion);
$query_otrousuario ="SELECT CodUsu, CodNom, nombreR FROM usuprenom, Premios, preosc WHERE CodUsu LIKE '".$_GET['verlode']."' AND usuprenom.CodPre LIKE Premios.CodPre AND usuprenom.CodPre LIKE preosc.premio AND usuprenom.CodNom LIKE preosc.ganador;";
$otrousuario = mysql_query($query_otrousuario, $conexion) or die(mysql_error());
$row_otrousuario = mysql_fetch_assoc($otrousuario);
$totalRows_otrousuario = mysql_num_rows($otrousuario);

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
<title>Pronostico de: <?php echo $row_otrousuario['CodUsu']; ?></title>
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
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="width: 300px; float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?><br />
  <a href="empezar.php">MI CUENTA</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>
<!-- Fin de la cabecera-->

<br />
<div id="contenedora" class="contenedora">
<!-- inicio de area Izquierda -->
<br />
<b>Pronostico de <?php echo $row_otrousuario['CodUsu']; ?> para los oscar 2010</b><br />
<b>Total aciertos: <?php echo $totalRows_otrousuario ?></b>

<br />
<div id="premiosynominados" style="width:80%; margin:0 auto; margin-top:5%; margin-bottom:5%;" class="tablaclasificacion">
<br />
<?php do { ?> 
	<p>
	<b><?php echo $row_otrousuario['nombreR'];?></b>:&nbsp;<?php echo $row_otrousuario['CodNom'];?>&nbsp;<span class="letraschicas"><a href="http://www.imdb.com/find?s=all&q=<?php echo $row_otrousuario['CodNom'];?>" target="_blank">+info IMDb</a></span><br />
    </p>
<?php } while ($row_otrousuario= mysql_fetch_assoc($otrousuario))?>
	</div>
<!-- Fin del pronostico-->


<!-- Fin de area Izquierda-->


<!-- fin de la Derecha -->
<div style="clear: both;"></div>

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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />
</div>
<!-- Final --> 
</body>
</html>
<?php
mysql_free_result($recordusuarios);
mysql_free_result($otrousuario);
?>