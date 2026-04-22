<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
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
$maxRows_recordusuarios = 40;
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


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<25 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysql_query($consulta_puntos_resultados, $conexion);
$filas_puntos_resultados = mysql_fetch_assoc($resultado_puntos_resultados);

mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados2="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$_SESSION['MM_Username']."' AND pp.CodUsu='ProfetaMundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 26 AND 31) AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysql_query($consulta_puntos_resultados2, $conexion);
$filas_puntos_resultados2 = mysql_fetch_assoc($resultado_puntos_resultados2);


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<25  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysql_query($consulta_puntos_exactos, $conexion);
$filas_puntos_exactos = mysql_fetch_assoc($resultado_puntos_exactos);



mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos2="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 26 AND 31)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysql_query($consulta_puntos_exactos2, $conexion);
$filas_puntos_exactos2 = mysql_fetch_assoc($resultado_puntos_exactos2);

mysql_select_db($database_conexion,$conexion);
$consulta_cuartos="
(
SELECT local as cuartos FROM partidos
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 25 AND 28)
OR local in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 25 AND 28)
)
AND CodPar BETWEEN 25 AND 28
)
UNION
(
SELECT visitante as cuartos FROM partidos
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 25 AND 28)
OR visitante in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 25 AND 28)
)
AND CodPar BETWEEN 25 AND 28
)
";
$resultado_cuartos=mysql_query($consulta_cuartos, $conexion);
$filas_cuartos= mysql_num_rows($resultado_cuartos);



mysql_select_db($database_conexion,$conexion);
$consulta_semis="(
SELECT local as cuartos FROM partidos
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 29 AND 30)
OR local in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 29 AND 30)
)
AND CodPar BETWEEN 29 AND 30
)
UNION
(
SELECT visitante as cuartos FROM partidos
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 29 AND 30)
OR visitante in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar BETWEEN 29 AND 30)
)
AND CodPar BETWEEN 29 AND 30
)";
$resultado_semis=mysql_query($consulta_semis, $conexion);
$filas_semis= mysql_num_rows($resultado_semis);




mysql_select_db($database_conexion,$conexion);
$consulta_final="(
SELECT local as cuartos FROM partidos
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar=31)
OR local in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar=31)
)
AND CodPar=31
)
UNION
(
SELECT visitante as cuartos FROM partidos
WHERE CodUsu =  '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos where CodUsu='ProfetaMundial' AND CodPar=31)
OR visitante in 
(select local from partidos where CodUsu='ProfetaMundial' AND CodPar=31)
)
AND CodPar=31
)";
$resultado_final=mysql_query($consulta_final, $conexion);
$filas_final= mysql_num_rows($resultado_final);


mysql_select_db($database_conexion,$conexion);
$consulta_goleador="SELECT count(*) as puntos from partidos where 
CodPar=34 and 
local like (select local from partidos where CodPar=34 and CodUsu='ProfetaMundial')
and visitante=(select visitante from partidos where CodPar=34 and CodUsu='ProfetaMundial')
AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_goleador=mysql_query($consulta_goleador, $conexion);
$filas_goleador= mysql_fetch_assoc($resultado_goleador);


mysql_select_db($database_conexion,$conexion);
$consulta_campeon="SELECT count(*) as puntos from partidos where CodPar=33 and local=(select local from partidos where CodPar=33 and CodUsu='ProfetaMundial') AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_campeon=mysql_query($consulta_campeon, $conexion);
$filas_campeon= mysql_fetch_assoc($resultado_campeon);


if (isset($_POST['puntuar']))	{
mysql_select_db($database_conexion,$conexion);
mysql_query("UPDATE usuarios SET puntos='".$_POST['puntos']."' WHERE usuario='".$_POST['usuario']."'");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Euro 2012 Polonia-Ucrania</title>
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
  <a href="modificar.php">Mi cuenta</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>
<!-- Fin de la cabecera-->

<br />
<div id="contenedora" class="contenedora">
<p class="letrasmasgrandes">Euro 2012 Polonia-Ucrania</p>
<?
//Puntuaciones:
$exactos=$filas_puntos_exactos['puntos']+$filas_puntos_exactos2['puntos'];
$pexactos=$exactos*5;

$partidoGrupos=$filas_puntos_resultados['puntos']-$filas_puntos_exactos['puntos'];

$partidoSegunda=$filas_puntos_resultados2['puntos']-$filas_puntos_exactos2['puntos'];
$puntospartidoSegunda=$partidoSegunda*2;

$cuartos=$filas_cuartos;

$semis=$filas_semis;

$final=$filas_final;

$goleador=$filas_goleador['puntos'];
$pgoleador=$goleador*10;

$campeon=$filas_campeon['puntos'];
$pcampeon=$campeon*15;

$total=$pexactos+$partidoGrupos+$puntospartidoSegunda+$cuartos+$semis+$final+$pgoleador+$pcampeon;
?>
<div class="tablaclasificacion">
<div class="comentarios">
<p>Pronostico de <b><?php echo $_SESSION['MM_Username']?></b> </p>
<p>Resultado del partido: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoGrupos?>  (<?=$partidoGrupos?> puntos)</p>
<p>Resultado del partido en Segunda Fase: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoSegunda?>  (<?=$puntospartidoSegunda?> puntos)</p>
<p>Resultados exactos Totales:  <?=$exactos?>  (<?=$pexactos?> puntos)</p>
<p><b>Extras:</b></p>
<p>Equipos que estan en cuartos:  <?=$cuartos?>  (<?=$cuartos?> puntos)</p>
<p>Equipos que estan en semifinales:  <?=$semis?>  (<?=$semis?> puntos)</p>
<p>Equipos que estan en la final:  <?=$final?>  (<?=$final?> puntos)</p>
<p>Goleador:  <?=$goleador?>  (<?=$pgoleador?> puntos)</p>
<p>Campeon:  <?=$campeon?>  (<?=$pcampeon?> puntos)</p>
<hr />
<p style="font-size:24px;">Total: <b><?=$total?></b> puntos</p>
<? if	($_SESSION['MM_Username']=='profetamundial')	{ ?>
<form action="#" method="post" name="fpuntuar">
	<input type="hidden" name="puntuar" />
	<input name="usuario" type="hidden" value="<?=$_SESSION['MM_Username']?>"/>
	<input type="hidden" name="puntos" value="<?=$total?>"/>
	<input type="submit" class="botones" value="Puntuar"/>
</form>
<? }?>
</div>
</div>
<br />
<!-- inicio de area Izquierda -->
<br /><b>GRUPO A</b>
<br />
<iframe src="GA.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>

<br /><b>GRUPO B</b>
<br />
<iframe src="GB.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>

<br /><b>GRUPO C</b>
<br />
<iframe src="GC.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>
<br />


<br /><b>GRUPO D</b>
<br />
<iframe src="GD.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>
<br />

<br /><b>Segunda Fase</b>
<br />
<iframe src="fase2.php" frameborder="0" scrolling="no" width="730px" height="760px"></iframe>



<!-- fin de la Derecha -->
<div style="clear: both;">
<a href="imprimiramerica.php" class="botones" target="_blank">Imprimir</a>
</div>
<br />
<hr />
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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
</div>
<!-- Final --> 
</body>
</html>
