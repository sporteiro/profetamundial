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

///////////CONSULTAR PUNTUACIONES/////////////////////////7


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados="SELECT COUNT(*) AS puntos FROM partidos_mundial2014 pp join partidos_mundial2014 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysql_query($consulta_puntos_resultados, $conexion);
$filas_puntos_resultados = mysql_fetch_assoc($resultado_puntos_resultados);

mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados2="SELECT COUNT(*) AS puntos FROM partidos_mundial2014 pp join partidos_mundial2014 ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$_SESSION['MM_Username']."' AND pp.CodUsu='profetamundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64) AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysql_query($consulta_puntos_resultados2, $conexion);
$filas_puntos_resultados2 = mysql_fetch_assoc($resultado_puntos_resultados2);


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos="SELECT COUNT(*) AS puntos FROM partidos_mundial2014 pp join partidos_mundial2014 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysql_query($consulta_puntos_exactos, $conexion);
$filas_puntos_exactos = mysql_fetch_assoc($resultado_puntos_exactos);



mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos2="SELECT COUNT(*) AS puntos FROM partidos_mundial2014 pp join partidos_mundial2014 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysql_query($consulta_puntos_exactos2, $conexion);
$filas_puntos_exactos2 = mysql_fetch_assoc($resultado_puntos_exactos2);

////OCTAVOS////////////////////////
////CAMBIO EL GLOCAL POR EL GVISITANTE PARA que se puntue al pasar pero no el resultado del partido
mysql_select_db($database_conexion,$conexion);
$consulta_octavos="
(
SELECT local as octavos FROM partidos_mundial2014
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
)
AND CodPar BETWEEN 49 AND 56
)
UNION
(
SELECT visitante as octavos FROM partidos_mundial2014
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
)
AND CodPar BETWEEN 49 AND 56
)
";
$resultado_octavos=mysql_query($consulta_octavos, $conexion);
$filas_octavos= mysql_num_rows($resultado_octavos);



////CUARTOS////////////////////////
mysql_select_db($database_conexion,$conexion);
$consulta_cuartos="
(
SELECT local as cuartos FROM partidos_mundial2014
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
)
AND CodPar BETWEEN 57 AND 60
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2014
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
)
AND CodPar BETWEEN 57 AND 60
)
";
$resultado_cuartos=mysql_query($consulta_cuartos, $conexion);
$filas_cuartos= mysql_num_rows($resultado_cuartos);


////SEMIS
mysql_select_db($database_conexion,$conexion);
$consulta_semis="(
SELECT local as cuartos FROM partidos_mundial2014
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
)
AND CodPar BETWEEN 61 AND 62
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2014
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
)
AND CodPar BETWEEN 61 AND 62
)";
$resultado_semis=mysql_query($consulta_semis, $conexion);
$filas_semis= mysql_num_rows($resultado_semis);


///FINAL

mysql_select_db($database_conexion,$conexion);
$consulta_final="(
SELECT local as cuartos FROM partidos_mundial2014
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
)
AND CodPar=63
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2014
WHERE CodUsu =  '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
)
AND CodPar=63
)";
$resultado_final=mysql_query($consulta_final, $conexion);
$filas_final= mysql_num_rows($resultado_final);

/////////TERCER PUESTO PUNTUAR/////
mysql_select_db($database_conexion,$conexion);
$consulta_tercer="(
SELECT local as cuartos FROM partidos_mundial2014
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
)
AND CodPar=64
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2014
WHERE CodUsu =  '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2014 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
)
AND CodPar=64
)";
$resultado_tercer=mysql_query($consulta_tercer, $conexion);
$filas_tercer= mysql_num_rows($resultado_tercer);

/////////GOLEADOR/////

mysql_select_db($database_conexion,$conexion);
$consulta_goleador="SELECT count(*) as puntos from partidos_mundial2014 where 
CodPar=66 and 
local like (select local from partidos_mundial2014 where CodPar=66 and CodUsu='profetamundial')
and visitante=(select visitante from partidos_mundial2014 where CodPar=66 and CodUsu='profetamundial')
AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_goleador=mysql_query($consulta_goleador, $conexion);
$filas_goleador= mysql_fetch_assoc($resultado_goleador);


mysql_select_db($database_conexion,$conexion);
$consulta_campeon="SELECT count(*) as puntos from partidos_mundial2014 where CodPar=65 and local=(select local from partidos_mundial2014 where CodPar=65 and CodUsu='profetamundial') AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_campeon=mysql_query($consulta_campeon, $conexion);
$filas_campeon= mysql_fetch_assoc($resultado_campeon);

mysql_select_db($database_conexion,$conexion);
$consulta_tercero="SELECT count(*) as puntos from partidos_mundial2014 where CodPar=65 and visitante=(select visitante from partidos_mundial2014 where CodPar=65 and CodUsu='ProfetaMundial') AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_tercero=mysql_query($consulta_tercero, $conexion);
$filas_tercero= mysql_fetch_assoc($resultado_tercero);


if (isset($_POST['puntuar']))	{
mysql_select_db($database_conexion,$conexion);
mysql_query("UPDATE usuarios SET puntos='".$_POST['puntos']."' WHERE usuario='".$_POST['usuario']."'");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Mundial de Futbol Brasil 2014</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function resizeFase2()	{
	var w = window.innerWidth;
	var h = window.innerHeight;
	var divFase2 = document.getElementById('fase2');
	if (w<800)	{
		divFase2.src="fase2_mundial2014_cel.php";
	}
	else	{
		divFase2.src="fase2_mundial2014.php";
	}
}
window.onresize = function()	{
		resizeFase2();
	}
</script>
</head>

<body onload="resizeFase2()">
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
<p class="letrasmasgrandes">Mundial de Futbol Brasil 2014</p>
<?
//Puntuaciones:
$exactos=$filas_puntos_exactos['puntos']+$filas_puntos_exactos2['puntos'];
$pexactos=$exactos*5;

$partidoGrupos=$filas_puntos_resultados['puntos']-$filas_puntos_exactos['puntos'];

$partidos_olegunda=$filas_puntos_resultados2['puntos']-$filas_puntos_exactos2['puntos'];
$puntospartidos_olegunda=$partidos_olegunda*2;

$octavos=$filas_octavos;

$cuartos=$filas_cuartos;

$semis=$filas_semis;

$tercer=$filas_tercer;

$final=$filas_final;

$goleador=$filas_goleador['puntos'];
$pgoleador=$goleador*10;

$campeon=$filas_campeon['puntos'];
$pcampeon=$campeon*15;

$tercero=$filas_tercero['puntos'];
$ptercero=$tercero*5;

$total=$pexactos+$partidoGrupos+$puntospartidos_olegunda+$octavos+$cuartos+$semis+$tercer+$final+$pgoleador+$ptercero+$pcampeon;
?>
<div class="tablaclasificacion">
<div class="comentarios">
<p>Pronostico de <b><?php echo $_SESSION['MM_Username']?></b> </p>
<p>Resultado del partido: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoGrupos?>  (<?=$partidoGrupos?> puntos)</p>
<p>Resultado del partido en Segunda Fase: <i>(NO se cuentan los resultados exactos)</i> <?=$partidos_olegunda?>  (<?=$puntospartidos_olegunda?> puntos)</p>
<p>Resultados exactos Totales:  <?=$exactos?>  (<?=$pexactos?> puntos)</p>
<p><b>Extras:</b></p>
<p>Equipos que estan en octavos:  <?=$octavos?>  (<?=$octavos?> puntos)</p>
<p>Equipos que estan en cuartos:  <?=$cuartos?>  (<?=$cuartos?> puntos)</p>
<p>Equipos que estan en semifinales:  <?=$semis?>  (<?=$semis?> puntos)</p>
<p>Equipos que estan en el partido por el tercer y cuarto puesto:  <?=$tercer?>  (<?=$tercer?> puntos)</p>
<p>Equipos que estan en la final:  <?=$final?>  (<?=$final?> puntos)</p>
<p>Tercero:  <?=$tercero?>  (<?=$ptercero?> puntos)</p>
<p>Goleador:  <?=$goleador?>  (<?=$pgoleador?> puntos)</p>
<p>Campeon:  <?=$campeon?>  (<?=$pcampeon?> puntos)</p>
<hr />
<p style="font-size:24px;">Total: <b><?=$total?></b> puntos</p>

<?//TO DO (Por hacer, no toooodo, To Do)
 if	($_SESSION['MM_Username']=='ProfetaMundial')	{ ?>
<form action="#" method="post" name="fpuntuar">
	<input type="hidden" name="puntuar" />
	<input name="usuario" type="hidden" value="<?=$_SESSION['MM_Username']?>"/>
	<input type="hidden" name="puntos" value="<?=$total?>"/>
	<input type="submit" class="botones" value="Puntuar a Todos los usuarios(TO DO)"/>
</form>
<? }?>
</div>
</div>
<br />
<!-- inicio de area Izquierda -->
<br /><b>GRUPO A</b>
<br />
<iframe src="GA_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>

<br /><b>GRUPO B</b>
<br />
<iframe src="GB_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>

<br /><b>GRUPO C</b>
<br />
<iframe src="GC_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>GRUPO D</b>
<br />
<iframe src="GD_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>GRUPO E</b>
<br />
<iframe src="GE_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>GRUPO F</b>
<br />
<iframe src="GF_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>GRUPO G</b>
<br />
<iframe src="GG_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>GRUPO H</b>
<br />
<iframe src="GH_mundial2014.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
<br />

<br /><b>Segunda Fase</b>
<br />
<iframe src="fase2_mundial2014.php" id="fase2" frameborder="0" scrolling="no" width="100%" height="2000em;"></iframe>



<!-- fin de la Derecha -->
<div style="clear: both;">
<a href="imprimirmundial2014.php" class="botones" target="_blank">Imprimir</a>
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
