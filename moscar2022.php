<?php require_once('Connections/conexion.php'); ?>
<?php
$z=0;
$insertSQL=0;
$today = date("YmdH"); 
$limite='2022032600';
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
if ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial')	) {
if ((isset($_POST["MM_insert"])) && (isset($_POST["1"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['1']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=6;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["2"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['2']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=7;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["3"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['3']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=8;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["4"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['4']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=9;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["5"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['5']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=10;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["6"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['6']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=11;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["7"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['7']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=12;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["8"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['8']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=13;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["9"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['9']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=14;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["10"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['10']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=15;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["11"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['11']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=16;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["12"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['12']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=17;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["13"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['13']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=18;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["14"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['14']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=19;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["15"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['15']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=20;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());}
  if ((isset($_POST["MM_insert"])) && (isset($_POST["16"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['16']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=21;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["17"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['17']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=22;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["18"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['18']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=23;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["19"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['19']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=24;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  //2022 eliminamos la categoria 25
  /*if ((isset($_POST["MM_insert"])) && (isset($_POST["20"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['20']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=25;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }*/ 
  if ((isset($_POST["MM_insert"])) && (isset($_POST["20"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['20']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=26;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["21"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['21']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=27;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["22"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['22']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=28;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["23"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['23']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=29;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
}
if ($Result1 = mysql_query($insertSQL, $conexion)) {
  $insertGoTo = "verelegidos2022.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}
mysql_select_db($database_conexion, $conexion);
$query_premiosynominados= "SELECT nombreR, nombreN, aka FROM Nominados2022, Premios, PreNom2022 WHERE Nominados2022.CodNom LIKE PreNom2022.CodNom AND Premios.CodPre LIKE PreNom2022.CodPre ORDER BY PreNom2022.CodPre ASC, nombreN ASC;";
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
$query_usuprenom2022= "SELECT CodUsu, CodNom, nombreR FROM usuprenom2022, Premios WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND usuprenom2022.CodPre LIKE Premios.CodPre;";
$usuprenom2022= mysql_query($query_usuprenom2022, $conexion) or die(mysql_error());
$row_usuprenom2022= mysql_fetch_assoc($usuprenom2022);
$totalRows_usuprenom2022= mysql_num_rows($usuprenom2022);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Oscar 2022</title>
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
</head>

<body>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="profetamundial" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?><br />
  <a href="empezar.php">MI CUENTA</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<!-- Fin de la cabecera-->
<br />

<div id="contenedora" class="contenedora">
<br />
<b>Modificar mi pronostico</b>
<div id="premiosynominados" style="width:100%; margin:0 auto; margin-top:5%; margin-bottom:5%;" class="tablaclasificacion">
<form name="formularioscar" action="moscar2022.php" method="post">
<input type="hidden" value="<?php echo $row_recordusuarios['usuario']; ?>" name="usuarioimput" />
<?php
$ult_tipo = false;
while ($row_premiosynominados= mysql_fetch_assoc($premiosynominados))
{
  if ($ult_tipo != $row_premiosynominados["nombreR"])	{  ?>
  
    <p class="tablaresultados oscar">
    <b> <input type="hidden" value="<?php echo $row_premiosynominados["nombreR"];?>" name="A<?php echo $row_premiosynominados["nombreR"]; ?>" id="A<?php echo $row_premiosynominados["nombreR"]; ?>" />
      <?php  echo $row_premiosynominados["nombreR"]; ?>
    </b>
    </p> 
    <p class="comentarios">
     <?php $z++;
  }
  else	{ ?>
	<div class="cada_nominado">
  	<label>
	 <input type="radio" name="<?php echo $z?>" value="<?php echo $row_premiosynominados['nombreN'];?>" id="<?php echo $row_premiosynominados['nombreN'];?>"/>
	 <b><?php echo $row_premiosynominados['nombreN'];?></b> &nbsp;<span class="letraschicas enlace_imdb"><?php  echo $row_premiosynominados['aka']; ?> <a href="http://www.imdb.com/find?s=all&q=<?php echo $row_premiosynominados['nombreN'];?>" target="_blank">+info IMDb</a></span><br /></label>
<div class="clear"></div>
</div>
  <?php 
  }
  $ult_tipo = $row_premiosynominados["nombreR"];
} 
?>
    </p>
	<?if ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial')	)	{	?>
	<p>
	<input type="hidden" name="MM_insert" value="formularioscar"/>
	 <input type="submit" value="Guardar Cambios" class="botones"/> 
	</p>
	<? } ?>
    <a href="verelegidos2022.php" class="botoneschicos">Ver mi pronostico</a>
    
</form>

<br />
</div>

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
?>
