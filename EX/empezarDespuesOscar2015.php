<?php require_once('Connections/conexion.php'); ?>
<?php
$colname_Recordtodoslosusuarios=0;
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formAmerica2015")) {
$insertSQLamerica = "INSERT INTO america2015_partidos(`CodUsu`, `CodPar`, `local`, `visitante`, `glocal`, `gvisitante`, `resultado`) VALUES 
('".$_SESSION['MM_Username']."', 1, 'Chile', 'Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 2, 'Mexico', 'Bolivia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 3, 'Ecuador', 'Bolivia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 4, 'Chile', 'Mexico', 0, 0, 0),
('".$_SESSION['MM_Username']."', 5, 'Mexico', 'Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 6, 'Chile', 'Bolivia', 0, 0, 0),



('".$_SESSION['MM_Username']."', 7, 'Uruguay', 'Jamaica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 8, 'Argentina', 'Paraguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 9, 'Paraguay','Jamaica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 10,'Argentina','Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 11,'Uruguay','Paraguay', 0, 0, 0),	
('".$_SESSION['MM_Username']."', 12,'Argentina','Jamaica', 0, 0, 0),


('".$_SESSION['MM_Username']."', 13,'Colombia','Venezuela', 0, 0, 0),
('".$_SESSION['MM_Username']."', 14,'Brasil','Peru', 0, 0, 0),
('".$_SESSION['MM_Username']."', 15,'Brasil','Colombia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 16,'Peru','Venezuela', 0, 0, 0),
('".$_SESSION['MM_Username']."', 17,'Colombia','Peru', 0, 0, 0),
('".$_SESSION['MM_Username']."', 18,'Brasil','Venezuela', 0, 0, 0),

/*
('".$_SESSION['MM_Username']."', 19,'Uruguay','Costa Rica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 20,'Inglaterra','Italia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 21,'Uruguay','Inglaterra', 0, 0, 0),
('".$_SESSION['MM_Username']."', 22,'Italia','Costa Rica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 23,'Italia','Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 24,'Costa Rica','Inglaterra', 0, 0, 0),
('".$_SESSION['MM_Username']."', 25,'Suiza','Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 26,'Francia','Honduras', 0, 0, 0),
('".$_SESSION['MM_Username']."', 27,'Suiza','Francia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 28,'Honduras','Ecuador', 0, 0, 0),
('".$_SESSION['MM_Username']."', 29,'Honduras','Suiza', 0, 0, 0),
('".$_SESSION['MM_Username']."', 30,'Ecuador','Francia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 31,'Argentina','Bosnia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 32,'Iran','Nigeria', 0, 0, 0),
('".$_SESSION['MM_Username']."', 33,'Argentina','Iran', 0, 0, 0),
('".$_SESSION['MM_Username']."', 34,'Nigeria','Bosnia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 35,'Nigeria','Argentina', 0, 0, 0),
('".$_SESSION['MM_Username']."', 36,'Bosnia','Iran', 0, 0, 0),
('".$_SESSION['MM_Username']."', 37,'Alemania','Portugal', 0, 0, 0),
('".$_SESSION['MM_Username']."', 38,'Ghana','USA', 0, 0, 0),
('".$_SESSION['MM_Username']."', 39,'Alemania','Ghana', 0, 0, 0),
('".$_SESSION['MM_Username']."', 40,'USA','Portugal', 0, 0, 0),
('".$_SESSION['MM_Username']."', 41,'USA','Alemania', 0, 0, 0),
('".$_SESSION['MM_Username']."', 42,'Portugal','Ghana', 0, 0, 0),
('".$_SESSION['MM_Username']."', 43,'Belgica','Argelia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 44,'Rusia','Corea del Sur', 0, 0, 0),
('".$_SESSION['MM_Username']."', 45,'Belgica','Rusia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 46,'Corea del Sur','Argelia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 47,'Corea del Sur','Belgica', 0, 0, 0),
('".$_SESSION['MM_Username']."', 48,'Argelia','Rusia', 0, 0, 0),
*/

('".$_SESSION['MM_Username']."', 49,'Primero Grupo A','Mejor Tercero', 0, 0, 0),
('".$_SESSION['MM_Username']."', 50,'Segundo Grupo A','Segundo Grupo C', 0, 0, 0),
('".$_SESSION['MM_Username']."', 51,'Primero Grupo B','Mejor Tercero 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 52,'Primero Grupo C','Segundo Grupo B', 0, 0, 0),

('".$_SESSION['MM_Username']."', 53,'Primero Grupo E','Segundo Grupo F', 0, 0, 0),
('".$_SESSION['MM_Username']."', 54,'Primero Grupo F','Segundo Grupo E', 0, 0, 0),
('".$_SESSION['MM_Username']."', 55,'Primero Grupo G','Segundo Grupo H', 0, 0, 0),
('".$_SESSION['MM_Username']."', 56,'Primero Grupo H','Segundo Grupo G', 0, 0, 0),
('".$_SESSION['MM_Username']."', 57,'Ganador_1A_2B','Ganador_1C_2D', 0, 0, 0),
('".$_SESSION['MM_Username']."', 58,'Ganador_1E_2F','Ganador_1G_2H', 0, 0, 0),
('".$_SESSION['MM_Username']."', 59,'Ganador_1B_2A','Ganador_1D_2C', 0, 0, 0),
('".$_SESSION['MM_Username']."', 60,'Ganador_1F_2E','Ganador_1H_2G', 0, 0, 0),
('".$_SESSION['MM_Username']."', 61,'Semifinalista 1','Semifinalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 62,'Semifinalista 3','Semifinalista 4', 0, 0, 0),
('".$_SESSION['MM_Username']."', 63,'Finalista 1','Finalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 64,'Tercer puesto 1','Tercer puesto 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 65,'Campeon','Tercero', 0, 0, 0),
('".$_SESSION['MM_Username']."', 66,'Goleador','Pais', 0, 0, 0);";

  mysql_select_db($database_conexion, $conexion);
  $Resultamerica = mysql_query($insertSQLamerica, $conexion) or die(mysql_error());
  
$insertSQLamerica2 = "INSERT INTO `america2015_equipos` (`CodUsu`, `CodEqu`, `nombre`, `grupo`, `puntos`, `golfav`, `golcon`, `difgol`) VALUES
('".$_SESSION['MM_Username']."', 1, 'Chile', 'A', 3, 199, 198, 1),
('".$_SESSION['MM_Username']."', 2, 'Ecuador', 'A', 2, 198, 199, -1),
('".$_SESSION['MM_Username']."', 3, 'Mexico', 'A', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 4, 'Bolivia', 'A', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 5, 'Uruguay', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 6, 'Jamaica', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 7, 'Argentina', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 8, 'Paraguay', 'B', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 9, 'Colombia', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 10, 'Venezuela', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 11, 'Brasil', 'C', 3, 297, 297, 0),
('".$_SESSION['MM_Username']."', 12, 'Peru', 'C', 3, 297, 297, 0);";

  mysql_select_db($database_conexion, $conexion);
  $Resultamerica2 = mysql_query($insertSQLamerica2, $conexion) or die(mysql_error());
  
  $insertSQLamerica2 = "INSERT INTO Torneos VALUES
(8,'america2015','".$_SESSION['MM_Username']."', 'America 2015')";
  mysql_select_db($database_conexion, $conexion);
  $Resultamerica2 = mysql_query($insertSQLamerica2, $conexion) or die(mysql_error());


  $insertGoTo = "america2015.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formcomentar")) {
  $insertSQL = sprintf("INSERT INTO comentarios (comentario, usuario) VALUES (%s, %s)",
                       GetSQLValueString($_POST['comentario'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "empezar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_recordusuarios = 25;
$pageNum_recordusuarios = 0;
if (isset($_GET['pageNum_recordusuarios'])) {
  $pageNum_recordusuarios = $_GET['pageNum_recordusuarios'];
}
$startRow_recordusuarios = $pageNum_recordusuarios * $maxRows_recordusuarios;

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysql_query($query_limit_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);

if (isset($_GET['totalRows_recordusuarios'])) {
  $totalRows_recordusuarios = $_GET['totalRows_recordusuarios'];
} else {
  $all_recordusuarios = mysql_query($query_recordusuarios);
  $totalRows_recordusuarios = mysql_num_rows($all_recordusuarios);
}
$totalPages_recordusuarios = ceil($totalRows_recordusuarios/$maxRows_recordusuarios)-1;


mysql_select_db($database_conexion, $conexion);
$query_Recordtodoslosusuarios = sprintf("SELECT * FROM usuarios ORDER BY puntos DESC", GetSQLValueString($colname_Recordtodoslosusuarios, "text"));
$Recordtodoslosusuarios = mysql_query($query_Recordtodoslosusuarios, $conexion) or die(mysql_error());
$row_Recordtodoslosusuarios = mysql_fetch_assoc($Recordtodoslosusuarios);
$totalRows_Recordtodoslosusuarios = mysql_num_rows($Recordtodoslosusuarios);

$maxRows_recormentarios = 64;
$pageNum_recormentarios = 0;
if (isset($_GET['pageNum_recormentarios'])) {
  $pageNum_recormentarios = $_GET['pageNum_recormentarios'];
}
$startRow_recormentarios = $pageNum_recormentarios * $maxRows_recormentarios;

mysql_select_db($database_conexion, $conexion);
$query_recormentarios = "SELECT * FROM comentarios join usuarios on comentarios.usuario=usuarios.usuario ORDER BY id DESC";
$query_limit_recormentarios = sprintf("%s LIMIT %d, %d", $query_recormentarios, $startRow_recormentarios, $maxRows_recormentarios);
$recormentarios = mysql_query($query_limit_recormentarios, $conexion) or die(mysql_error());
$row_recormentarios = mysql_fetch_assoc($recormentarios);

if (isset($_GET['totalRows_recormentarios'])) {
  $totalRows_recormentarios = $_GET['totalRows_recormentarios'];
} else {
  $all_recormentarios = mysql_query($query_recormentarios);
  $totalRows_recormentarios = mysql_num_rows($all_recormentarios);
}
$totalPages_recormentarios = ceil($totalRows_recormentarios/$maxRows_recormentarios)-1;


mysql_select_db($database_conexion, $conexion);
$query_usutor= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='9';";
$usutor= mysql_query($query_usutor, $conexion) or die(mysql_error());
$row_usutor= mysql_fetch_assoc($usutor);
$totalRows_usutor= mysql_num_rows($usutor);

mysql_select_db($database_conexion, $conexion);
$query_usutor4= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='9';";
$usutor4= mysql_query($query_usutor4, $conexion) or die(mysql_error());
$row_usutor4= mysql_fetch_assoc($usutor4);
$totalRows_usutor4= mysql_num_rows($usutor4);

mysql_select_db($database_conexion, $conexion);
$query_usutor10= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='10';";
$usutor10= mysql_query($query_usutor10, $conexion) or die(mysql_error());
$row_usutor10= mysql_fetch_assoc($usutor10);
$totalRows_usutor10= mysql_num_rows($usutor10);

mysql_select_db($database_conexion, $conexion);
$query_otrousuario_mundial = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='8' AND inscriptos !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_mundial = mysql_query($query_otrousuario_mundial, $conexion) or die(mysql_error());
$row_otrousuario_mundial = mysql_fetch_assoc($otrousuario_mundial);
$totalRows_otrousuario_mundial = mysql_num_rows($otrousuario_mundial);



mysql_select_db($database_conexion, $conexion);
$query_otrousuario_oscar = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='10' AND inscriptos NOT LIKE '".$_SESSION['MM_Username']."' AND usuario !='profetamundial' ORDER BY U.puntos DESC";
$otrousuario_oscar = mysql_query($query_otrousuario_oscar, $conexion) or die(mysql_error());
$row_otrousuario_oscar = mysql_fetch_assoc($otrousuario_oscar);
$totalRows_otrousuario_oscar= mysql_num_rows($otrousuario_oscar);


mysql_select_db($database_conexion, $conexion);
$query_enlinea= "SELECT * FROM usuarios WHERE enlinea='si' AND usuario !='".$_SESSION['MM_Username']."' AND usuario !='ProfetaMundial';";
$enlinea= mysql_query($query_enlinea, $conexion) or die(mysql_error());
$totalRows_enlinea= mysql_num_rows($enlinea);


mysql_select_db($database_conexion, $conexion);
$query_hoy_usu= "SELECT * FROM america2015_partidos WHERE CodPar in(select CodPar from america2015_partidos where fecha=curdate()) and CodUsu !='ProfetaMundial' AND  local in (select local from america2015_partidos where fecha=curdate() and CodUsu='ProfetaMundial') AND  visitante in (select visitante from america2015_partidos where fecha=curdate() and CodUsu='ProfetaMundial') ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu;";
$hoy_usu= mysql_query($query_hoy_usu, $conexion) or die(mysql_error());
$totalRows_hoy_usu= mysql_num_rows($hoy_usu);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Bienvenido <?php echo $row_recordusuarios['usuario']; ?></title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
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

<script type="text/javascript">
window.onload = setupRefresh;
function setupRefresh()	{
	recargar();
	setInterval("recargar();",30000);
	}
function recargar()	{
	$('#divajax').load("chat.php");
	$('#divajax').fadeIn(300);

    }
</script>


</head>
<body>
<?
$today = date("YmdH"); 
//el servidor tiene 5 horas menos que GMT 
$limite='2015022018';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;
if ($_SESSION['MM_Username']=='ProfetaMundial')	{
	echo "La hora del servidor es: ".$today;
}
?>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
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
<div id="contenedora" class="contenedora">
<!-- inicio de area Izquierda -->
<br />
	<div class="tablaIzquierda">
    	<b>Mis pronosticos:</b>
    	<div class="comentarios" style="text-align:center;">
    		
           	<p>
	<strong>�Quien ganara la Copa America 2015?</strong>
        	</p>
  			<?php if (!$row_usutor4['nombreT']) { ?>
            	<form id="formamerica" name="formamerica" method="post" action="<?php echo $editFormAction; ?>">
                	<input type="submit" class="botoneschicosrojos" value="�Pronosticar ahora!" />
                    <input type="hidden" name="MM_insert" value="formamerica" />
                </form>
			<? } 
			else { ?>
			<a href="america2015.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
   
   		 	<br />
    		
            </div>
    		           <hr /> 
		
			<div class="comentarios" style="text-align:center;">
                    	<?php echo $row_otrousuario_oscar['descripcion'];?>&nbsp;(participantes: &nbsp;<?php echo $totalRows_otrousuario_oscar?>)
     		   <?php do { ?>
                	<p>
    			   		<a class="botoneschicos" href="verelegidosde2015.php?usuario=<?php echo $row_otrousuario_oscar['inscriptos'];?>"> <?php echo $row_otrousuario_oscar['inscriptos'];?>  <b><?php echo $row_otrousuario_oscar['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_oscar = mysql_fetch_assoc($otrousuario_oscar)); ?>
     			
     		   </div>
    	      <hr /> 
		<div class="comentarios">
			<div id="divajax" style="display:none;"></div>
		</div>
		<br /><br />
		<div class="comentarios" style="text-align:center;">		
		<?php 
		$con='a';	
		$d=0;
		if ($totalRows_hoy_usu>0) {?>
		<p><strong>Pronosticos para los partidos de hoy:</strong></p>
		<?while ($row_usu = mysql_fetch_assoc($hoy_usu)) {
			if ($con!=$row_usu['CodPar'])	{
				if ($d>0) echo "</div>";
				echo "<div style='float:left; padding-left:2%; padding-top:1%;text-align:left;'>";
				echo "<img src='imagenes/banamerica/".$row_usu['local'].".gif'/> ".$row_usu['local'].'-'.$row_usu['visitante']." <img src='imagenes/banamerica/".$row_usu['visitante'].".gif'/><hr />";		
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";
				$con=$row_usu['CodPar'];
				$d=$d+1;
			}
			else	{
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";				
			}
		 }	
		echo "</div>";	
		}
		?>
		<div style="clear:both;"></div>
		</div>
		</div>
		
    
<!-- Fin de area Izquierda-->

<!-- Inicio de la derecha-->
 <div class="tablaDerecha">
	<div style="padding-bottom:1%x; padding-top:1%; padding-left: 1%; padding-right: 1%;">
   	<p>
    <strong>Tabla de comentarios:</strong>
    </p>
		<div class="desplazamiento" id="desplazamiento">
    
	
	<?php do { ?>
			<div class="comentarios">
        		<p class="letraschicas">
        		<strong> <img src="imagenes/avatares/<?php echo $row_recormentarios['avatar'];?>" height="32" width="32" alt=""/> <? echo $row_recormentarios['usuario']; ?>  dijo:</strong> <?php echo $row_recormentarios['comentario']; ?></p>
			</div>
            <br />
      <?php } while ($row_recormentarios = mysql_fetch_assoc($recormentarios)); ?>
    
    
		</div>
  		<form id="formcomentar" name="formcomentar" method="POST" action="<?php echo $editFormAction; ?>">
 		<input name="usuario" type="hidden" id="usuario" value="<?php echo $row_recordusuarios['usuario']; ?>" />
 		<p>
        <a href="comentarios.php" target="_blank"> <span class="botoneschicos">Ver todos los comentarios</span></a>
        </p>    
		<span id="sprytextarea1">
			<label>
			<textarea name="comentario" cols="4" rows="4" class="letraschicascomentarios" id="comentario"></textarea><br />
    		<span id="countsprytextarea1">&nbsp;</span><span class="letraschicas"> Letras por escribir
            </span>
    		</label>
   			 <span class="textareaRequiredMsg"> &iexcl;Escrib&iacute; algo!</span>
             <span class="textareaMinCharsMsg">&iexcl;Escrib&iacute; algo mas!</span>
             <span class="textareaMaxCharsMsg">Demasiados caracteres</span>
		</span>
		<p>
      	<label>
        <input name="comentar" type="submit" class="botoneschicos" id="comentar" value="Comentar" />
      	</label>
  		</p>
    	<input type="hidden" name="MM_insert" value="formcomentar" />
  	</form>
	<br />
	<div><hr />
    			<b>Trofeos Obtenidos por todos los usuarios:</b>
			<div class="comentarios">
			<?php include_once('trofeos.php') ?>		
			</div>
		</div>
	</div>
	<br /><br />
	<br />
</div>

<!-- fin de la Derecha -->
<div style="clear: both;"></div>

<!-- Inicio de banners -->
<p>
<strong>Informaci&oacute;n adicional:</strong>
</p>
<div id="FIFA" class="FIFA">
<!--banner bet365-->
  <object 
classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
id="d73fdc83e68849a09cca9a0218324191" 
width="140" 
height="400">
<param name="movie" value="http://imstore.bet365affiliates.com/365_049673-418-165-2-149-3-31684.aspx">
<param name="quality" value="high">
<param name="wmode" value="transparent">
<param name="allowScriptAccess" value="always">
<param name="allowNetworking" value="external">
<embed 
src="http://imstore.bet365affiliates.com/365_049673-418-165-2-149-3-31684.aspx" 
quality="high" 
allowScriptAccess="always" 
allowNetworking="external"  
swLiveConnect="false" 
width="140" 
height="400" 
name="d73fdc83e68849a09cca9a0218324191" 
type="application/x-shockwave-flash" 
pluginspage="https://www.macromedia.com/go/getflashplayer" 
wmode="transparent">
</embed>
</object>
<!--FIN BANNER BET 365-->
<object  width='300' height='400' id='flashLatestNews' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'>
<param name='movie' value='http://www.fifa.com/flash/widgets/newsreader/app.swf?lang='es'/>
<param name='bgcolor' value='#ffffff'/>
<param name='quality' value='high'/>
<param name='wmode' value='transparent'/>
<param name='flashvars' value='lang=es'>
<embed width='300' height='400' flashvars='lang=es' wmode='transparent' quality='high' bgcolor='#ffffff' name='flashLatestNews' id='flashLatestNews' src=http://www.fifa.com/flash/widgets/newsreader/app.swf?lang='es type='application/x-shockwave-flash'/>
</object>
<object  width='300' height='400' id='flashWorldCup' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'>
<param name='movie' value='http://www.fifa.com/flash/widgets/fwcqualifiers/main.swf?team=uru&lang=s'/>
<param name='bgcolor' value='#ffffff'/>
<param name='quality' value='high'/>
<param name='wmode' value='transparent'/>
<param name='flashvars' value='lang=s&team=uru'>
<embed width='300' height='400' flashvars='lang=s&amp;team=uru' wmode='transparent' quality='high' bgcolor='#ffffff' name='flashWorldCup' id='flashWorldCup' src=http://www.fifa.com/flash/widgets/fwcqualifiers/main.swf?team=uru&lang=s type='application/x-shockwave-flash'/>
</object>
</div>
  <p>&nbsp;</p>
<!-- Fin de banners -->  
  
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
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {minChars:2, maxChars:200, counterId:"countsprytextarea1", counterType:"chars_remaining"});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($recordusuarios);
mysql_free_result($Recordtodoslosusuarios);
mysql_free_result($recormentarios);
?>
