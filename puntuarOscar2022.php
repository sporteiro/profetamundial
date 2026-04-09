<?php require_once('Connections/conexion.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
$z=0;
$insertSQL=0;
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
  if ((isset($_POST["MM_insert"])) && (isset($_POST["20"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['20']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=25;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["21"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['21']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=26;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["22"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['22']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=27;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["23"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['23']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=28;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }
  if ((isset($_POST["MM_insert"])) && (isset($_POST["24"])) && ($_POST["MM_insert"] == "formularioscar")) {
  $insertSQL = "UPDATE usuprenom2022 SET CodNom='".$_POST['24']."' WHERE CodUsu LIKE '".$_SESSION['MM_Username']."' AND CodPre=29;";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  }

/*
  if (isset($_POST["puntuar"])) {
 $insertSQL = "UPDATE usuarios set puntos=(SELECT  count(*) FROM usuprenom2022 uu join usuprenom2022 uc ON uu.CodPre=uc.CodPre 
WHERE uu.CodUsu='seblash' and uc.CodUsu='ProfetaMundial' and uu.CodNom=uc.CodNom)  WHERE usuario='seblash';";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}  

  if (isset($_POST["puntuar"])) {
 $insertSQL = "UPDATE usuarios set puntos=(SELECT  count(*) FROM usuprenom2022 uu join usuprenom2022 uc ON uu.CodPre=uc.CodPre 
WHERE uu.CodUsu='santiago' and uc.CodUsu='ProfetaMundial' and uu.CodNom=uc.CodNom)  WHERE usuario='santiago';";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

  if (isset($_POST["puntuar"])) {
 $insertSQL = "UPDATE usuarios set puntos=(SELECT  count(*) FROM usuprenom2022 uu join usuprenom2022 uc ON uu.CodPre=uc.CodPre 
WHERE uu.CodUsu='felipescu' and uc.CodUsu='ProfetaMundial' and uu.CodNom=uc.CodNom)  WHERE usuario='felipescu';";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

*/






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



//Nueva funcion 2022 para ver los puntajes de cada usuario Y para puntuar a todos los participantes


mysql_select_db($database_conexion, $conexion);
$query_otrousuario_oscar = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='18' AND usuario !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_oscar = mysql_query($query_otrousuario_oscar, $conexion) or die(mysql_error());
$row_otrousuario_oscar = mysql_fetch_assoc($otrousuario_oscar);
$totalRows_otrousuario_oscar= mysql_num_rows($otrousuario_oscar);

//$usuario = 'Felipescu';

$array_usuarios_puntos = array();

do { 
	
	$usuario = $row_otrousuario_oscar['inscriptos'];

	mysql_select_db($database_conexion, $conexion);-
	$query_puntos_usuario = sprintf("SELECT  count(*) FROM usuprenom2022 uu join usuprenom2022 uc ON uu.CodPre=uc.CodPre 
	WHERE uu.CodUsu=%s and uc.CodUsu='ProfetaMundial' and uu.CodNom=uc.CodNom", GetSQLValueString($usuario, "text"));
	$puntos_usuario = mysql_query($query_puntos_usuario, $conexion) or die(mysql_error());
	$row_query_puntos_usuario = mysql_fetch_assoc($puntos_usuario);
	$totalRows_puntos_usuario = mysql_num_rows($puntos_usuario);
	
	$array_usuarios_puntos[$usuario] = $row_query_puntos_usuario['count(*)'];
	
} while ($row_otrousuario_oscar = mysql_fetch_assoc($otrousuario_oscar));


//PUNTUAR BASANDOSE EN TODOS LOS PARTICIPANTES DE UN TORNEO, RECICLAR FUNCION PARA OTROS TORNEOS!
if (isset($_POST["puntuar"])) {
	mysql_select_db($database_conexion, $conexion);
	$query_otrousuario_oscar_puntuar = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='18' AND usuario !='ProfetaMundial' ORDER BY U.puntos DESC";
	$otrousuario_oscar_puntuar = mysql_query($query_otrousuario_oscar_puntuar, $conexion) or die(mysql_error());
	$row_otrousuario_oscar_puntuar = mysql_fetch_assoc($otrousuario_oscar_puntuar);

	do { 
	
		$usuario = $row_otrousuario_oscar_puntuar['inscriptos'];
		$insertSQL = "UPDATE usuarios set puntos=(SELECT  count(*) FROM usuprenom2022 uu join usuprenom2022 uc ON uu.CodPre=uc.CodPre 
		WHERE uu.CodUsu='".$usuario."' and uc.CodUsu='ProfetaMundial' and uu.CodNom=uc.CodNom)  WHERE usuario='".$usuario."';";
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

		if ($Result1 = mysql_query($insertSQL, $conexion)) {
		$insertGoTo = "puntuarOscar2022.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				$insertGoTo .= $_SERVER['QUERY_STRING'];
			}
			header(sprintf("Location: %s", $insertGoTo));
		}
		
	} while ($row_otrousuario_oscar_puntuar = mysql_fetch_assoc($otrousuario_oscar_puntuar));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Oscar 2011</title>
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
<br />
<div class="comentarios">
<?php 
foreach($array_usuarios_puntos as $key=>$value)
	{
		echo "<p>".$key." : ".$value." puntos</p>";
	}
?>
</div>
<b>Modificar mi pronostico</b>

<div id="premiosynominados" style="width:80%; margin:0 auto; margin-top:5%; margin-bottom:5%;" class="tablaclasificacion">
<form name="formularioscar" action="puntuarOscar2022.php" method="post">
<input type="hidden" value="<?php echo $row_recordusuarios['usuario']; ?>" name="usuarioimput" />
<?php
$ult_tipo = false;
while ($row_premiosynominados= mysql_fetch_assoc($premiosynominados))
{
  if ($ult_tipo != $row_premiosynominados["nombreR"])	{  ?>
  
    <p class="tablaresultados">
    <b> <input type="hidden" value="<?php echo $row_premiosynominados["nombreR"]; ?>" name="A<?php echo $row_premiosynominados["nombreR"]; ?>" id="A<?php echo $row_premiosynominados["nombreR"]; ?>" />
      <?php  echo $row_premiosynominados["nombreR"]; ?>
    </b>
    </p> 
    <p class="comentarios">
     <?php $z++;
  }
  else	{ ?>
  
	 <input type="radio" name="<?php echo $z?>" value="<?php echo $row_premiosynominados["nombreN"];?>" id="<?php echo $row_premiosynominados["nombreN"];?>" />
	 <b><?php echo $row_premiosynominados["nombreN"];?></b> &nbsp;<span class="letraschicas"><?php  echo $row_premiosynominados["aka"]; ?> <a href="http://www.imdb.com/find?s=all&q=<?php echo $row_premiosynominados["nombreN"];?>" target="_blank">+info IMDb</a></span><br />
  <?php 
  }
  $ult_tipo = $row_premiosynominados["nombreR"];
} ?>
   
    </p>
	<p>
	<input type="hidden" name="MM_insert" value="formularioscar"/>
	 <input type="submit" value="Guardar Cambios" class="botones"/>
	</p>
    
    
</form>
<form action="puntuarOscar2022.php" method="post">
	<input type="hidden" name="puntuar" value="puntuar"/>
	<input type="submit" value="Puntuar" class="botones"/>
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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
</div>
<!-- Final --> 
</body>
</html>
<?php
mysql_free_result($recordusuarios);
?>
