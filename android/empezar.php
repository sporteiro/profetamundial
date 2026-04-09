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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formamerica")) {
  $insertSQLamerica = "INSERT INTO partidos_ol(`CodUsu`, `CodPar`, `local`, `visitante`, `glocal`, `gvisitante`, `resultado`) VALUES 

('".$_SESSION['MM_Username']."', 1, 'EUA', 'Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 2, 'UK', 'Senegal', 0, 0, 0),
('".$_SESSION['MM_Username']."', 3, 'Senegal', 'Uruguay', 0, 0, 0),
('".$_SESSION['MM_Username']."', 4, 'UK', 'EUA', 0, 0, 0),
('".$_SESSION['MM_Username']."', 5, 'Senegal', 'EUA', 0, 0, 0),
('".$_SESSION['MM_Username']."', 6, 'UK', 'Uruguay', 0, 0, 0),


('".$_SESSION['MM_Username']."', 7, 'Mexico', 'Corea', 0, 0, 0),
('".$_SESSION['MM_Username']."', 8, 'Gabon', 'Suiza', 0, 0, 0),
('".$_SESSION['MM_Username']."', 9, 'Mexico','Gabon', 0, 0, 0),
('".$_SESSION['MM_Username']."', 10,'Corea','Suiza', 0, 0, 0),
('".$_SESSION['MM_Username']."', 11,'Mexico','Suiza', 0, 0, 0),	
('".$_SESSION['MM_Username']."', 12,'Corea','Gabon', 0, 0, 0),



('".$_SESSION['MM_Username']."', 13,'Bielorrusia','Nueva Zelanda', 0, 0, 0),
('".$_SESSION['MM_Username']."', 14,'Brasil','Egipto', 0, 0, 0),
('".$_SESSION['MM_Username']."', 15,'Brasil','Bielorrusia', 0, 0, 0),
('".$_SESSION['MM_Username']."', 16,'Egipto','Nueva Zelanda', 0, 0, 0),
('".$_SESSION['MM_Username']."', 17,'Brasil','Nueva Zelanda', 0, 0, 0),
('".$_SESSION['MM_Username']."', 18,'Egipto','Bielorrusia', 0, 0, 0),


('".$_SESSION['MM_Username']."', 19,'España','Japon', 0, 0, 0),
('".$_SESSION['MM_Username']."', 20,'Honduras','Marruecos', 0, 0, 0),
('".$_SESSION['MM_Username']."', 21,'España','Honduras', 0, 0, 0),
('".$_SESSION['MM_Username']."', 22,'Japon','Marruecos', 0, 0, 0),
('".$_SESSION['MM_Username']."', 23,'Japon','Honduras', 0, 0, 0),
('".$_SESSION['MM_Username']."', 24,'España','Marruecos', 0, 0, 0),

('".$_SESSION['MM_Username']."', 25,'Primero Grupo A','Segundo Grupo B', 0, 0, 0),
('".$_SESSION['MM_Username']."', 26,'Primero Grupo C','Segundo Grupo D', 0, 0, 0),
('".$_SESSION['MM_Username']."', 27,'Primero Grupo B','Segundo Grupo A', 0, 0, 0),
('".$_SESSION['MM_Username']."', 28,'Primero Grupo D','Segundo Grupo C', 0, 0, 0),

('".$_SESSION['MM_Username']."', 29,'Semifinalista 1','Semifinalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 30,'Semifinalista 3','Semifinalista 4', 0, 0, 0),

('".$_SESSION['MM_Username']."', 31,'Finalista 1','Finalista 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 32,'Tercer puesto 1','Tercer puesto 2', 0, 0, 0),
('".$_SESSION['MM_Username']."', 33,'Campeon','Tercero', 0, 0, 0),
('".$_SESSION['MM_Username']."', 34,'Goleador','Pais', 0, 0, 0);";

  mysql_select_db($database_conexion, $conexion);
  $Resultamerica = mysql_query($insertSQLamerica, $conexion) or die(mysql_error());
  
$insertSQLamerica2 = "INSERT INTO equipos_ol VALUES
('".$_SESSION['MM_Username']."', 1, 'EUA', 'A', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 2, 'Uruguay', 'A', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 3, 'UK', 'A', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 4, 'Senegal', 'A', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 5, 'Mexico', 'B', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 6, 'Corea', 'B', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 7, 'Gabon', 'B', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 8, 'Suiza', 'B', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 9, 'Bielorrusia', 'C', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 10, 'Nueva Zelanda', 'C', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 11, 'Brasil', 'C', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 12, 'Egipto', 'C', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 13, 'España', 'D', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 14, 'Japon', 'D', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 15, 'Honduras', 'D', '0', '0', '0', '0'),
('".$_SESSION['MM_Username']."', 16, 'Marruecos', 'D', '0', '0', '0', '0')";

  mysql_select_db($database_conexion, $conexion);
  $Resultamerica2 = mysql_query($insertSQLamerica2, $conexion) or die(mysql_error());
  
  $insertSQLamerica2 = "INSERT INTO Torneos VALUES
(5,'olimpiada','".$_SESSION['MM_Username']."', 'Olimpiada')";
  mysql_select_db($database_conexion, $conexion);
  $Resultamerica2 = mysql_query($insertSQLamerica2, $conexion) or die(mysql_error());


  $insertGoTo = "olimpiada.php";
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
$query_usutor= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='1';";
$usutor= mysql_query($query_usutor, $conexion) or die(mysql_error());
$row_usutor= mysql_fetch_assoc($usutor);
$totalRows_usutor= mysql_num_rows($usutor);

mysql_select_db($database_conexion, $conexion);
$query_usutor4= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='5';";
$usutor4= mysql_query($query_usutor4, $conexion) or die(mysql_error());
$row_usutor4= mysql_fetch_assoc($usutor4);
$totalRows_usutor4= mysql_num_rows($usutor4);

mysql_select_db($database_conexion, $conexion);
$query_otrousuario_europa = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='5' AND inscriptos NOT LIKE '".$_SESSION['MM_Username']."' AND usuario !='ProfetaMundial' ORDER BY U.puntos DESC";
$otrousuario_europa = mysql_query($query_otrousuario_europa, $conexion) or die(mysql_error());
$row_otrousuario_europa = mysql_fetch_assoc($otrousuario_europa);
$totalRows_otrousuario_europa = mysql_num_rows($otrousuario_europa);



mysql_select_db($database_conexion, $conexion);
$query_otrousuario_oscar = "SELECT T.*, U.* FROM Torneos as T JOIN usuarios as U ON T.inscriptos=U.usuario WHERE CodTor='1' AND inscriptos NOT LIKE '".$_SESSION['MM_Username']."' AND usuario !='profetamundial' ORDER BY U.puntos DESC";
$otrousuario_oscar = mysql_query($query_otrousuario_oscar, $conexion) or die(mysql_error());
$row_otrousuario_oscar = mysql_fetch_assoc($otrousuario_oscar);
$totalRows_otrousuario_oscar= mysql_num_rows($otrousuario_oscar);


mysql_select_db($database_conexion, $conexion);
$query_enlinea= "SELECT * FROM usuarios WHERE enlinea='si' AND usuario !='".$_SESSION['MM_Username']."' AND usuario !='ProfetaMundial';";
$enlinea= mysql_query($query_enlinea, $conexion) or die(mysql_error());
$totalRows_enlinea= mysql_num_rows($enlinea);


mysql_select_db($database_conexion, $conexion);
$query_hoy_usu= "SELECT * FROM partidos_ol WHERE CodPar in(select CodPar from partidos_ol where fecha=curdate()) and CodUsu !='ProfetaMundial' AND  local in (select local from partidos_ol where fecha=curdate() and CodUsu='ProfetaMundial') AND  visitante in (select visitante from partidos_ol where fecha=curdate() and CodUsu='ProfetaMundial') ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu ;";
$hoy_usu= mysql_query($query_hoy_usu, $conexion) or die(mysql_error());
$totalRows_hoy_usu= mysql_num_rows($hoy_usu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="width: 300px; float:left;" class="nada"><a href="empezar.php"><img src="../imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
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
	<div class="tablaclasificacion" style="width:410px; float:left; margin-left:20px; text-align:center; ">
    	<b>Mis pronosticos:</b>
    	<div class="comentarios" style="text-align:center;">
    		
           <p>
		<strong>¿Quien ganara la medalla de Oro en Futbol Masculino?</strong>
        	</p>
  			<?php if (!$row_usutor4['nombreT']) { ?>
            	<form action="#" method="post">
			<input type="hidden" name="MM_insert" value="formamerica"/>
                	<input type="submit" class="botoneschicosrojos" value="¡Pronosticar Futbol Masculino en London 2012!" />
	                   
                </form>
			<? } 
			else { ?>
			<a href="olimpiada.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
   
   		 	<br />
  			<br />
    		<!--<strong>Oscar 2012</strong>
        	</p>
  			<?php if (!$row_usutor['nombreT']) { ?>
            		<input type="button" class="botoneschicosrojos" value="Ya no se admiten participaciones" />
			<? } 
			else { ?>
			<a href="verelegidos.php" class="botoneschicos"> Ver o modificar mi pronostico</a>
			<?php } ?>
   
   		 	<br />
  			<br />-->
            <br />
     
            </div>
    		           <hr /> 
                	    <div class="comentarios" style="text-align:center;">
                    	<?php echo $row_otrousuario_europa['descripcion'];?>&nbsp;(otros participantes: &nbsp;<?php echo $totalRows_otrousuario_europa?>)
     		   <?php do { ?>
                	<p>
    			   		<a class="botoneschicos" href="verolimpiada.php?verlode=<?php echo $row_otrousuario_europa['inscriptos'];?>"> <?php echo $row_otrousuario_europa['inscriptos'];?>  (<b><?php echo $row_otrousuario_europa['puntos'];?></b> puntos)</a>
					</p>
      		  <?php } while ($row_otrousuario_europa = mysql_fetch_assoc($otrousuario_europa)); ?>
     			
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
				echo "<div style='float:left; padding-left:26px; padding-top:5px;text-align:left;'>";
				echo "<img src='../imagenes/banamerica/".$row_usu['local'].".gif'/> ".$row_usu['local'].'-'.$row_usu['visitante']." <img src='../imagenes/banamerica/".$row_usu['visitante'].".gif'/><hr />";		
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
<div class="tablaclasificacion" style="width:410px; float: right; margin-right :20px; text-align:center; ">
	<div style="padding-bottom:5px; padding-top:5px; padding-left: 10px; padding-right: 10px;">
   	<p>
    <strong>Tabla de comentarios:</strong>
    </p>
		<div class="desplazamiento" id="desplazamiento">
    
	
	<?php do { ?>
			<div class="comentarios">
        		<p class="letraschicas">
        		<strong> <img src="../imagenes/avatares/<?php echo $row_recormentarios['avatar'];?>" height="32" width="32" alt=""/> <? echo $row_recormentarios['usuario']; ?>  dijo:</strong> <?php echo $row_recormentarios['comentario']; ?></p>
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
			<textarea name="comentario" cols="40" rows="3" class="letraschicascomentarios" id="comentario"></textarea><br />
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
  <img style="visibility:hidden;width:0px;height:0px;" border=0 width=0 height=0 src="http://counters.gigya.com/wildfire/IMP/CXNID=2000002.0NXC/bT*xJmx*PTEyNzM2NjY4MDg2NzEmcHQ9MTI3MzY2NjgxNjk2OCZwPTExMjQxMjEmZD1sYXRlc3RuZXdzX2VzJmc9MiZvPTBhOGU2/YjQ*Njk2NDQ*NzZiZjZjNTNlNGE2MGZlYTI2Jm9mPTA=.gif" /><object classid=clsid:d27cdb6e-ae6d-11cf-96b8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0 width="300" ALIGN="top"  height="400" id="WFHost"> <param name = "FlashVars" value = "Partner=1124121&theme=New Classic&widgetW=300&widgetH=400&widgetX=0&widgetY=0&stickyType=&WFBtnX=0&WFBtnY=0&defaultPreviewURL=http://www.fifa.com/flash/widgets/newsreader/images/image_es.png&useFacebookMystuff=false&buttonURL=http://www.fifa.com/flash/widgets/newsreader/images/button.png&URL=http://www.fifa.com/flash/widgets/newsreader/app.swf?lang=es" /><param name="wmode" value="transparent"/><param name="allowScriptAccess" value="always" /><param name = "movie" value = http://cdn.gigya.com/wildfire/swf/WildfireHost3.swf /> <embed name = "WFHost" id = "WFHost" ALIGN="top" width = "300" height = "400" src = http://cdn.gigya.com/wildfire/swf/WildfireHost3.swf 	flashvars="Partner=1124121&theme=New Classic&widgetW=300&widgetH=400&widgetX=0&widgetY=0&stickyType=&WFBtnX=0&WFBtnY=0&defaultPreviewURL=http://www.fifa.com/flash/widgets/newsreader/images/image_es.png&useFacebookMystuff=false&buttonURL=http://www.fifa.com/flash/widgets/newsreader/images/button.png&URL=http://www.fifa.com/flash/widgets/newsreader/app.swf?lang=es" AllowScriptAccess="always" quality="high" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object> 
<img style="visibility:hidden;width:0px;height:0px;" border=0 width=0 height=0 src="http://counters.gigya.com/wildfire/IMP/CXNID=2000002.11NXC/bT*xJmx*PTEyNzMzNTQ3OTkyNDcmcHQ9MTI3MzM1NDgwMTg4OCZwPTExMjQxMjEmZD1md2NfcyZnPTImb2Y9MA==.gif" /><object  classid=clsid:d27cdb6e-ae6d-11cf-96b8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0 width="300" height="400" align="top" id="WFHost"> <param name = "FlashVars" value = "Partner=1124121&theme=New Classic&widgetW=300&widgetH=400&widgetX=0&widgetY=0&stickyType=&WFBtnX=0&WFBtnY=0&defaultPreviewURL=http://www.fifa.com/flash/widgets/worldcup/images/image_s.png&useFacebookMystuff=false&buttonURL=http://www.fifa.com/flash/widgets/worldcup/images/button.png&URL=http://www.fifa.com/flash/widgets/worldcup/main.swf%3Fteam%3Darg%26lang%3Ds" /><param name="wmode" value="transparent"/><param name="allowScriptAccess" value="always" /><param name = "movie" value = http://cdn.gigya.com/wildfire/swf/WildfireHost3.swf /> <embed name = "WFHost" id = "WFHost" width = "300" height = "400" src = http://cdn.gigya.com/wildfire/swf/WildfireHost3.swf 	flashvars="Partner=1124121&theme=New Classic&widgetW=300&widgetH=400&widgetX=0&widgetY=0&stickyType=&WFBtnX=0&WFBtnY=0&defaultPreviewURL=http://www.fifa.com/flash/widgets/worldcup/images/image_s.png&useFacebookMystuff=false&buttonURL=http://www.fifa.com/flash/widgets/worldcup/images/button.png&URL=http://www.fifa.com/flash/widgets/worldcup/main.swf%3Fteam%3Darg%26lang%3Ds" AllowScriptAccess="always" quality="high" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object> 
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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
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
