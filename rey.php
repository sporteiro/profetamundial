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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "reymod")) {
  $updateSQL = sprintf("UPDATE UsuRey SET RMA=%s, BCN=%s, LRMA=%s, LBCN=%s, CIRMA=%s, CIBCN=%s, CVRMA=%s, CVBCN=%s WHERE CodUsu=%s",
                       GetSQLValueString($_POST['realmadridmod'], "int"),
                       GetSQLValueString($_POST['barcelonamod'], "int"),
					   
					   GetSQLValueString($_POST['Lrealmadridmod'], "int"),
					   GetSQLValueString($_POST['Lbarcelonamod'], "int"),
					   
					   GetSQLValueString($_POST['CIrealmadridmod'], "int"),
					   GetSQLValueString($_POST['CIbarcelonamod'], "int"),
					   GetSQLValueString($_POST['CVrealmadridmod'], "int"),
                       GetSQLValueString($_POST['CVbarcelonamod'], "int"),
                       GetSQLValueString($_POST['usuariomod'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "rey.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "rey")) {
  $insertSQL =  sprintf("INSERT INTO Torneos (CodTor, nombreT, descripcion, inscriptos) VALUES (2, 'rey', 'Clasicos', %s)",
                       GetSQLValueString($_POST['usuario'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "rey")) {
  $insertSQL =  sprintf("INSERT INTO UsuRey (CodUsu, RMA, BCN, LRMA, LBCN, CIRMA, CIBCN, CVRMA, CVBCN) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['realmadrid'], "int"),
					   GetSQLValueString($_POST['barcelona'], "int"),
					   
					   GetSQLValueString($_POST['Lrealmadrid'], "int"),
					   GetSQLValueString($_POST['Lbarcelona'], "int"),
					   
					   GetSQLValueString($_POST['CIrealmadrid'], "int"),
					   GetSQLValueString($_POST['CIbarcelona'], "int"),
					   GetSQLValueString($_POST['CVrealmadrid'], "int"),
                       GetSQLValueString($_POST['CVbarcelona'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "rey.php";
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
$query_recormentarios = "SELECT * FROM comentarios ORDER BY id DESC";
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
$query_torrey= "SELECT * FROM Torneos WHERE inscriptos LIKE '".$_SESSION['MM_Username']."' AND CodTor='2';";
$torrey= mysql_query($query_torrey, $conexion) or die(mysql_error());
$row_torrey= mysql_fetch_assoc($torrey);
$totalRows_torrey= mysql_num_rows($torrey);

mysql_select_db($database_conexion, $conexion);
$query_usurey= "SELECT * FROM UsuRey WHERE CodUsu LIKE '".$_SESSION['MM_Username']."';";
$usurey= mysql_query($query_usurey, $conexion) or die(mysql_error());
$row_usurey= mysql_fetch_assoc($usurey);
$totalRows_usurey= mysql_num_rows($usurey);

mysql_select_db($database_conexion, $conexion);
$query_todorey= "SELECT * FROM UsuRey WHERE CodUsu NOT LIKE '".$_SESSION['MM_Username']."';";
$todorey= mysql_query($query_todorey, $conexion) or die(mysql_error());
$row_todorey= mysql_fetch_assoc($todorey);
$totalRows_todorey= mysql_num_rows($todorey);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Clasicos espa�oles</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
<?php if (!$row_torrey['nombreT']) { ?>
	<div class="tablaclasificacion" style="width:410px; float:left; margin-left:20px; text-align:center; ">
    	<b>Pronosticar:</b><br />
   		 <div class="comentarios" style="text-align:center;">
   
    <input name="usuario" value="<?php echo $row_recordusuarios['usuario']; ?>" type="hidden" />
    <br />
      <b>Campeonato:</b>
          <p class="comentarios" style="text-align:center;">
      <input type="text" name="Lrealmadrid" size="2" maxlength="3"/> Real Madrid-Barcelona <input type="text" name="Lbarcelona" size="2" maxlength="3"/>
     </p>
     
         <b>Copa del Rey:</b>
          <p class="comentarios" style="text-align:center;">
  <input type="text" name="barcelona" size="2" maxlength="3"/>Barcelona-Real Madrid<input type="text" name="realmadrid" size="2" maxlength="3"/>
  		</p>
     
        <b>Champions League</b>
          <p class="comentarios" style="text-align:center;">Ida<br />
      <input type="text" name="CIrealmadrid" size="2" maxlength="3"/>Real Madrid-Barcelona<input type="text" name="CIbarcelona" size="2" maxlength="3"/>
      <br />Vuelta<br />
      <input type="text" name="CVbarcelona" size="2" maxlength="3"/>Barcelona-Real Madrid<input type="text" name="CVrealmadrid" size="2" maxlength="3"/>
     </p>
     
  <br />
  <input type="submit" class="botoneschicosrojos" value="Plazo Finalizado" />
    </div>
		</div>
        
    <? } else  { ?>
    <div class="tablaclasificacion" style="width:410px; float:left; margin-left:20px; text-align:center; ">
    	<span class="letrasgrandes"><b>Mi Pronostico actual:</b></span>
        <br />
        <div class="tablaresultados" style="text-align:center;">
        
        	<div class="comentarios" style="text-align:center;">
            <br />
            
    
   	 	<input name="usuariomod" value="<?php echo $row_usurey['CodUsu']; ?>" type="hidden" />
        
           <b>Campeonato:</b>
          <p class="comentarios" style="text-align:center;">
   <input type="text" name="Lrealmadridmod" size="2" maxlength="3" value="<?php echo $row_usurey['LRMA']; ?>"/> Real Madrid-Barcelona <input type="text" name="Lbarcelonamod" size="2" maxlength="3" value="<?php echo $row_usurey['LBCN']; ?>" />
     	</p>
        
        
        <b>Copa Del Rey:</b>
        <p class="comentarios" style="text-align:center;">
  		<input type="text" name="barcelonamod" size="2" maxlength="3" value="<?php echo $row_usurey['BCN']; ?>" />Barcelona-Real Madrid<input type="text" name="realmadridmod" size="2" maxlength="3" value="<?php echo $row_usurey['RMA']; ?>" />
        </p>
     
        <b>Champions League:</b>
     	 <p class="comentarios" style="text-align:center;">Ida<br />
      <input type="text" name="CIrealmadridmod" size="2" maxlength="3" value="<?php echo $row_usurey['CIRMA']; ?>"/>Real Madrid-Barcelona<input type="text" name="CIbarcelonamod" size="2" maxlength="3" value="<?php echo $row_usurey['CIBCN']; ?>"/>
     	 <br />Vuelta<br />
      <input type="text" name="CVbarcelonamod" size="2" maxlength="3" value="<?php echo $row_usurey['CVBCN']; ?>"/>Barcelona-Real Madrid<input type="text" name="CVrealmadridmod" size="2" maxlength="3" value="<?php echo $row_usurey['CVRMA']; ?>"/>
    	 </p>
        
 		 <br /><br />
  		<input type="submit" class="botoneschicos" value="Plazo Finalizado" />
  		
    </form>
    		</div>
    	</div>
	</div>
     <?php }?>
<!-- Fin de area Izquierda-->

<!-- Inicio de la derecha-->
<div class="tablaclasificacion" style="width:410px; float: right; margin-right :20px; text-align:center; "><b>Pronostico de otros usuarios:</b>
	<div class="tablaresultados">
    	
        	
           
           <?php do { ?>
           <div class="comentarios" style="text-align:center;">
           <p>
           <b><?php echo $row_todorey['CodUsu'];?>:</b>
           </p>
           <p><b>Campeonato:</b><br />
           Real Madrid &nbsp;<?php echo $row_todorey['LRMA'];?>-Barcelona &nbsp;<?php echo $row_todorey['LBCN'];?>
           </p>
           <p>
           <b>Copa del Rey:</b><br />
           Barcelona &nbsp;<?php echo $row_todorey['BCN'];?>-Real Madrid &nbsp;<?php echo $row_todorey['RMA'];?>
           </p>
           <p>
          <b>Champions League:</b><br />Ida<br />
           Real Madrid &nbsp;<?php echo $row_todorey['CIRMA'];?>-Barcelona &nbsp;<?php echo $row_todorey['CIBCN'];?>
           <br />Vuelta<br />
           Barcelona &nbsp;<?php echo $row_todorey['CVBCN'];?>-Real Madrid &nbsp;<?php echo $row_todorey['CVRMA'];?>
           </p>
            </div><br />
           <?php } while ($row_todorey = mysql_fetch_assoc($todorey)); ?>
      
   </div>
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
<br />
<!-- Final -->    
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
mysql_free_result($Recordtodoslosusuarios);
mysql_free_result($recormentarios);
?>