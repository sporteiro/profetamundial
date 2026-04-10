<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $conexion;
  $theValue = mysqli_real_escape_string($conexion, $theValue);

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
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysqli_query($conexion, $query_limit_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);

///////////CONSULTAR PUNTUACIONES/////////////////////////7


$consulta_puntos_resultados="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysqli_query($conexion, $consulta_puntos_resultados);
$filas_puntos_resultados = mysqli_fetch_assoc($resultado_puntos_resultados);

$consulta_puntos_resultados2="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$_SESSION['MM_Username']."' AND pp.CodUsu='profetamundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64) AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysqli_query($conexion, $consulta_puntos_resultados2);
$filas_puntos_resultados2 = mysqli_fetch_assoc($resultado_puntos_resultados2);


$consulta_puntos_exactos="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysqli_query($conexion, $consulta_puntos_exactos);
$filas_puntos_exactos = mysqli_fetch_assoc($resultado_puntos_exactos);



$consulta_puntos_exactos2="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_SESSION['MM_Username']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysqli_query($conexion, $consulta_puntos_exactos2);
$filas_puntos_exactos2 = mysqli_fetch_assoc($resultado_puntos_exactos2);

////OCTAVOS////////////////////////
////CAMBIO EL GLOCAL POR EL GVISITANTE PARA que se puntue al pasar pero no el resultado del partido
$consulta_octavos="
(
SELECT local as octavos FROM partidos_mundial2022
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
)
AND CodPar BETWEEN 49 AND 56
)
UNION
(
SELECT visitante as octavos FROM partidos_mundial2022
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 49 AND 56) AND gvisitante!=99)
)
AND CodPar BETWEEN 49 AND 56
)
";
$resultado_octavos=mysqli_query($conexion, $consulta_octavos);
$filas_octavos= mysqli_num_rows($resultado_octavos);



////CUARTOS////////////////////////
$consulta_cuartos="
(
SELECT local as cuartos FROM partidos_mundial2022
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
)
AND CodPar BETWEEN 57 AND 60
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2022
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 57 AND 60) AND gvisitante!=99)
)
AND CodPar BETWEEN 57 AND 60
)
";
$resultado_cuartos=mysqli_query($conexion, $consulta_cuartos);
$filas_cuartos= mysqli_num_rows($resultado_cuartos);


////SEMIS
$consulta_semis="(
SELECT local as cuartos FROM partidos_mundial2022
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
)
AND CodPar BETWEEN 61 AND 62
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2022
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND (CodPar BETWEEN 61 AND 62) AND gvisitante!=99)
)
AND CodPar BETWEEN 61 AND 62
)";
$resultado_semis=mysqli_query($conexion, $consulta_semis);
$filas_semis= mysqli_num_rows($resultado_semis);


///FINAL

$consulta_final="(
SELECT local as cuartos FROM partidos_mundial2022
WHERE CodUsu ='".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
)
AND CodPar=63
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2022
WHERE CodUsu =  '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=63 AND gvisitante!=99)
)
AND CodPar=63
)";
$resultado_final=mysqli_query($conexion, $consulta_final);
$filas_final= mysqli_num_rows($resultado_final);

/////////TERCER PUESTO PUNTUAR/////
$consulta_tercer="(
SELECT local as cuartos FROM partidos_mundial2022
WHERE CodUsu = '".$_SESSION['MM_Username']."'
AND
(local in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
OR local in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
)
AND CodPar=64
)
UNION
(
SELECT visitante as cuartos FROM partidos_mundial2022
WHERE CodUsu =  '".$_SESSION['MM_Username']."'
AND
( visitante in 
(select visitante from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
OR visitante in 
(select local from partidos_mundial2022 where CodUsu='profetamundial' AND CodPar=64 AND gvisitante!=99)
)
AND CodPar=64
)";
$resultado_tercer=mysqli_query($conexion, $consulta_tercer);
$filas_tercer= mysqli_num_rows($resultado_tercer);

/////////GOLEADOR/////

$consulta_goleador="SELECT count(*) as puntos from partidos_mundial2022 where 
CodPar=66 and 
local like (select local from partidos_mundial2022 where CodPar=66 and CodUsu='profetamundial')
and visitante=(select visitante from partidos_mundial2022 where CodPar=66 and CodUsu='profetamundial')
AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_goleador=mysqli_query($conexion, $consulta_goleador);
$filas_goleador= mysqli_fetch_assoc($resultado_goleador);


$consulta_campeon="SELECT count(*) as puntos from partidos_mundial2022 where CodPar=65 and local=(select local from partidos_mundial2022 where CodPar=65 and CodUsu='profetamundial') AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_campeon=mysqli_query($conexion, $consulta_campeon);
$filas_campeon= mysqli_fetch_assoc($resultado_campeon);

$consulta_tercero="SELECT count(*) as puntos from partidos_mundial2022 where CodPar=65 and visitante=(select visitante from partidos_mundial2022 where CodPar=65 and CodUsu='ProfetaMundial') AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_tercero=mysqli_query($conexion, $consulta_tercero);
$filas_tercero= mysqli_fetch_assoc($resultado_tercero);


if (isset($_POST['puntuar']))	{
mysqli_query($conexion, "UPDATE usuarios SET puntos='".$_POST['puntos']."' WHERE usuario='".$_POST['usuario']."'");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mundial de Futbol Qatar 2022</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="jquery.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function resizeFase2()	{
	var w = window.innerWidth;
	var h = window.innerHeight;
	var divFase2 = document.getElementById('fase2');
	if (w<800)	{
		//divFase2.src="fase2_mundial2022_cel.php";
		$('#fase2_mundial2022_cel').show();
		$('#fase2_mundial2022').hide();
	}
	else	{
		$('#fase2_mundial2022_cel').hide();
		$('#fase2_mundial2022').show();
		//divFase2.src="fase2_mundial2022.php";
	}
}
window.onresize = function()	{
		resizeFase2();
	}


window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        $('#boton_subir').show();
    } else {
        $('#boton_subir').hide();
    }
}

function subir() {
     $('html, body').animate({scrollTop : 0},800);
     return false;
}
</script>
</head>

<body onload="resizeFase2()">
<div id="info_mundial"></div>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="width: 300px; float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?><br />
  <a href="modificar.php">Mi cuenta</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div>
    <div style="clear:both;"></div>
<div id="anchor_grupos">
<a href="#grupoa">Grupo A</a> <a href="#grupob">Grupo B</a> <a href="#grupoc">Grupo C</a> <a href="#grupod">Grupo D</a> <a href="#grupoe">Grupo E</a> <a href="#grupof">Grupo F</a> <a href="#grupog">Grupo G</a> <a href="#grupoh">Grupo H</a> <a href="#anchor_fase2">Fase 2</a>
</div>
</div>
<!-- Fin de la cabecera-->

<button onclick="subir()" id="boton_subir" title="Subir">&#8679;</button>
<br />
<div id="contenedora" class="contenedora">
<p class="letrasmasgrandes">Mundial de Futbol Qatar 2022</p>
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
<div id="grupoa" class="titulo_grupos">GRUPO A</div>
<?php require_once('GA_mundial2022.php');?>
<!--<iframe src="GA_mundial2022.php" frameborder="0" scrolling="no" width="100%" height="100%"></iframe>-->
<div id="grupob" class="titulo_grupos">GRUPO B</div>
<?php require_once('GB_mundial2022.php');?>
<!--<iframe src="GB_mundial2022.php" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>-->
<div id="grupoc" class="titulo_grupos">GRUPO C</div>
<?php require_once('GC_mundial2022.php');?>
<div id="grupod" class="titulo_grupos">GRUPO D</div>
<?php require_once('GD_mundial2022.php');?>
<div id="grupoe" class="titulo_grupos">GRUPO E</div>
<?php require_once('GE_mundial2022.php');?>
<div id="grupof" class="titulo_grupos">GRUPO F</div>
<?php require_once('GF_mundial2022.php');?>
<div id="grupog" class="titulo_grupos">GRUPO G</div>
<?php require_once('GG_mundial2022.php');?>
<div id="grupoh" class="titulo_grupos">GRUPO H</div>
<?php require_once('GH_mundial2022.php');?>
<div id="anchor_fase2">
<div id="grupoh" class="titulo_grupos">Segunda Fase</div>
<div id="fase2_mundial2022">
<?php require_once('fase2_mundial2022.php');?>
</div>
<div id="fase2_mundial2022_cel">
<?php require_once('fase2_mundial2022_cel.php');?>
</div>
</div>
<!--
<iframe src="fase2_mundial2022.php" id="fase2" frameborder="0" scrolling="no" width="100%" height="2000em;"></iframe>
-->



<!-- fin de la Derecha -->
<div style="clear: both;"></div>

</div>
<br />
<div>
<a href="imprimirmundial2022.php" class="botoneschicos" target="_blank">Imprimir</a>
<div style="clear: both;"></div>
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
