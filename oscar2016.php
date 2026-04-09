<?php require_once('Connections/conexion.php'); ?>
<?php
$z=0;
$today = date("YmdH"); 
$limite='2016022618';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;
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
if ((isset($_POST['1'])) && $fueraTiempo==0){
	
  $insertSQL = "INSERT INTO usuprenom2016 (CodUsu, CodPre, CodNom) VALUES
  ('".$_POST['usuarioimput']."', 6, '".$_POST['1']."'),
  ('".$_POST['usuarioimput']."', 7, '".$_POST['2']."'),
  ('".$_POST['usuarioimput']."', 8, '".$_POST['3']."'),
  ('".$_POST['usuarioimput']."', 9, '".$_POST['4']."'),
  ('".$_POST['usuarioimput']."', 10, '".$_POST['5']."'),
  ('".$_POST['usuarioimput']."', 11, '".$_POST['6']."'),
  ('".$_POST['usuarioimput']."', 12, '".$_POST['7']."'),
  ('".$_POST['usuarioimput']."', 13, '".$_POST['8']."'),
  ('".$_POST['usuarioimput']."', 14, '".$_POST['9']."'),
  ('".$_POST['usuarioimput']."', 15, '".$_POST['10']."'),
  ('".$_POST['usuarioimput']."', 16, '".$_POST['11']."'),
  ('".$_POST['usuarioimput']."', 17, '".$_POST['12']."'),
  ('".$_POST['usuarioimput']."', 18, '".$_POST['13']."'),
  ('".$_POST['usuarioimput']."', 19, '".$_POST['14']."'),
  ('".$_POST['usuarioimput']."', 20, '".$_POST['15']."'),
  ('".$_POST['usuarioimput']."', 21, '".$_POST['16']."'),
  ('".$_POST['usuarioimput']."', 22, '".$_POST['17']."'),
  ('".$_POST['usuarioimput']."', 23, '".$_POST['18']."'),
  ('".$_POST['usuarioimput']."', 24, '".$_POST['19']."'),
  ('".$_POST['usuarioimput']."', 25, '".$_POST['20']."'),
  ('".$_POST['usuarioimput']."', 26, '".$_POST['21']."'),
  ('".$_POST['usuarioimput']."', 27, '".$_POST['22']."'),
  ('".$_POST['usuarioimput']."', 28, '".$_POST['23']."'),
  ('".$_POST['usuarioimput']."', 29, '".$_POST['24']."') 
  ";
  
    mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
if (isset($_POST['1'])) {
  $insertSQL = "INSERT INTO Torneos (CodTor, nombreT,inscriptos,descripcion) VALUES
  ('12','oscar2016', '".$_POST['usuarioimput']."','Oscar 2016')";
  
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "verelegidos2016.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_premiosynominados= "SELECT nombreR, nombreN, aka FROM Nominados2016, Premios, PreNom2016 WHERE Nominados2016.CodNom LIKE PreNom2016.CodNom AND Premios.CodPre LIKE PreNom2016.CodPre ORDER BY PreNom2016.CodPre ASC, nombreN ASC;";
$premiosynominados= mysql_query($query_premiosynominados, $conexion) or die(mysql_error());
$row_premiosynominados= mysql_fetch_assoc($premiosynominados);
$totalRows_premiosynominados= mysql_num_rows($premiosynominados);

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
$query_usutor= "SELECT * FROM Torneos WHERE inscriptos='".$_SESSION['MM_Username']."' AND CodTor='12';";
$usutor= mysql_query($query_usutor, $conexion) or die(mysql_error());
$row_usutor= mysql_fetch_assoc($usutor);
$totalRows_usutor= mysql_num_rows($usutor);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="google" value="notranslate" />
<title>Oscar 2016</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
</head><? if ($_SESSION['MM_Username']=='ProfetaMundial')	{
echo "Hoy es: ".$today."<br />";
echo "El tiempo se termina en ".$limite."<br />";
echo "el valor de fueratiempo es ".$fueraTiempo."<br />"; }?>
<body>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
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

<?php if (!$row_usutor['nombreT']) { ?>
<div id="premiosynominados" style="width:100%; margin:0 auto; margin-top:5%; margin-bottom:5%;" class="tablaclasificacion">
<form method="post" action="oscar2016.php" name="formularioscar">
<input type="hidden" value="<?php echo $row_recordusuarios['usuario']; ?>" name="usuarioimput" />
<?php
$ult_tipo = false;
while ($row_premiosynominados= mysql_fetch_assoc($premiosynominados))
{
  if ($ult_tipo != $row_premiosynominados["nombreR"])	{  ?>
  
    <p class="tablaresultados">
    <b> <input type="hidden" value="<?php echo $row_premiosynominados['nombreR']; ?>" name="A<?php echo $row_premiosynominados['nombreR']; ?>" id="A<?php echo $row_premiosynominados['nombreR']; ?>" />
      <?php  echo $row_premiosynominados["nombreR"]; ?>
    </b>
    </p> 
    <p class="comentarios">
     <?php $z++;
  }
  else	{ ?>
	<label>
	 <input type="radio" name="<?php echo $z?>" value="<?php echo $row_premiosynominados['nombreN'];?>" id="<?php echo $row_premiosynominados['nombreN'];?>" />
	 <b><?php echo $row_premiosynominados["nombreN"];?></b>&nbsp;<span class="letraschicas"><i><?php  echo $row_premiosynominados["aka"]; ?></i> <a href="http://www.imdb.com/find?s=all&q=<?php echo $row_premiosynominados['nombreN'];?>" target="_blank">+info IMDb</a></span><br /></label>
  <?php 
  }
  $ult_tipo = $row_premiosynominados["nombreR"];
} ?>
   
    </p>
 

<br />
<?if ($fueraTiempo==0)	{	?>
<input type="submit" value="Guardar cambios" class="botones"/>
<? } ?>
</form>
</div>
<? } 
else { ?>
<br />
<a href="verelegidos2016.php" class="botoneschicos"> Ver mi pronostico para los Oscar 2016</a>
<div style="clear:both;"></div>
<br />
<?php } ?>
</div>
<br />
<!-- Final -->    
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
</body>
</html>
<?php
mysql_free_result($recordusuarios);
?>
