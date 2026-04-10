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
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysqli_query($conexion, $query_limit_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);


$consulta="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 1 AND 6 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultado=mysqli_query($conexion, $consulta);

$consulta_tabla_A="SELECT * FROM equipos_mundial2022 WHERE grupo='A' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysqli_query($conexion, $consulta_tabla_A);



$consultaB="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoB=mysqli_query($conexion, $consultaB);

$consulta_tabla_B="SELECT * FROM equipos_mundial2022 WHERE grupo='B' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_B=mysqli_query($conexion, $consulta_tabla_B);


$consultaC="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoC=mysqli_query($conexion, $consultaC);

$consulta_tabla_C="SELECT * FROM equipos_mundial2022 WHERE grupo='C' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_C=mysqli_query($conexion, $consulta_tabla_C);

$consultaD="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 19 AND 24 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoD=mysqli_query($conexion, $consultaD);

$consulta_tabla_D="SELECT * FROM equipos_mundial2022 WHERE grupo='D' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_D=mysqli_query($conexion, $consulta_tabla_D);

$consultacuartos="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 25 AND 28 AND CodUsu='".$_GET['verlode']."'";
$resultadocuartos=mysqli_query($conexion, $consultacuartos);

$consultaE="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 25 AND 30 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoE=mysqli_query($conexion, $consultaE);

$consulta_tabla_E="SELECT * FROM equipos_mundial2022 WHERE grupo='E' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_E=mysqli_query($conexion, $consulta_tabla_E);

$consultaF="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 31 AND 36 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoF=mysqli_query($conexion, $consultaF);

$consulta_tabla_F="SELECT * FROM equipos_mundial2022 WHERE grupo='F' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_F=mysqli_query($conexion, $consulta_tabla_F);

$consultaG="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 37 AND 42 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoG=mysqli_query($conexion, $consultaG);

$consulta_tabla_G="SELECT * FROM equipos_mundial2022 WHERE grupo='G' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_G=mysqli_query($conexion, $consulta_tabla_G);

$consultaH="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 43 AND 48 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadoH=mysqli_query($conexion, $consultaH);

$consulta_tabla_H="SELECT * FROM equipos_mundial2022 WHERE grupo='H' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_H=mysqli_query($conexion, $consulta_tabla_H);

$consultaoctavos="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 49 AND 56 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadooctavos=mysqli_query($conexion, $consultaoctavos);

$consultacuartos="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 57 AND 60 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadocuartos=mysqli_query($conexion, $consultacuartos);

$consultasemis="SELECT * FROM partidos_mundial2022 WHERE CodPar BETWEEN 61 AND 62 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultadosemis=mysqli_query($conexion, $consultasemis);

$consultafinal="SELECT * FROM partidos_mundial2022 WHERE CodPar=63 AND CodUsu='".$_GET['verlode']."'";
$resultadofinal=mysqli_query($conexion, $consultafinal);
$filasresultadofinal=mysqli_fetch_assoc($resultadofinal);

$consultatercer="SELECT * FROM partidos_mundial2022 WHERE CodPar=64 AND CodUsu='".$_GET['verlode']."'";
$resultadotercer=mysqli_query($conexion, $consultatercer);
$filasresultadotercer=mysqli_fetch_assoc($resultadotercer);


$consultagoleador="SELECT * FROM partidos_mundial2022 WHERE CodPar=66 AND CodUsu='".$_GET['verlode']."'";
$resultadogoleador=mysqli_query($conexion, $consultagoleador);
$filasresultadogoleador=mysqli_fetch_assoc($resultadogoleador);
										
$consultacampeon="SELECT * FROM partidos_mundial2022 WHERE CodPar=65  AND CodUsu='".$_GET['verlode']."'";
$resultadocampeon=mysqli_query($conexion, $consultacampeon);
$filasresultadocampeon=mysqli_fetch_assoc($resultadocampeon);


///////////CONSULTAR PUNTUACIONES/////////////////////////7


$consulta_puntos_resultados="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysqli_query($conexion, $consulta_puntos_resultados);
$filas_puntos_resultados = mysqli_fetch_assoc($resultado_puntos_resultados);

$consulta_puntos_resultados2="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$_GET['verlode']."' AND pp.CodUsu='profetamundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64) AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysqli_query($conexion, $consulta_puntos_resultados2);
$filas_puntos_resultados2 = mysqli_fetch_assoc($resultado_puntos_resultados2);


$consulta_puntos_exactos="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<49  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysqli_query($conexion, $consulta_puntos_exactos);
$filas_puntos_exactos = mysqli_fetch_assoc($resultado_puntos_exactos);



$consulta_puntos_exactos2="SELECT count(*) as puntos FROM partidos_mundial2022 pp join partidos_mundial2022 ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 49 AND 64)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysqli_query($conexion, $consulta_puntos_exactos2);
$filas_puntos_exactos2 = mysqli_fetch_assoc($resultado_puntos_exactos2);

////OCTAVOS////////////////////////

////CAMBIO EL GLOCAL POR EL GVISITANTE PARA que se puntue al pasar pero no el resultado del partido
$consulta_octavos="
(
SELECT local as octavos FROM partidos_mundial2022
WHERE CodUsu ='".$_GET['verlode']."'
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
WHERE CodUsu = '".$_GET['verlode']."'
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
WHERE CodUsu ='".$_GET['verlode']."'
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
WHERE CodUsu = '".$_GET['verlode']."'
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
WHERE CodUsu = '".$_GET['verlode']."'
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
WHERE CodUsu = '".$_GET['verlode']."'
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
WHERE CodUsu ='".$_GET['verlode']."'
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
WHERE CodUsu =  '".$_GET['verlode']."'
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
WHERE CodUsu = '".$_GET['verlode']."'
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
WHERE CodUsu =  '".$_GET['verlode']."'
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
AND CodUsu='".$_GET['verlode']."'";
$resultado_goleador=mysqli_query($conexion, $consulta_goleador);
$filas_goleador= mysqli_fetch_assoc($resultado_goleador);


$consulta_campeon="SELECT count(*) as puntos from partidos_mundial2022 where CodPar=65 and local=(select local from partidos_mundial2022 where CodPar=65 and CodUsu='profetamundial') AND CodUsu='".$_GET['verlode']."'";
$resultado_campeon=mysqli_query($conexion, $consulta_campeon);
$filas_campeon= mysqli_fetch_assoc($resultado_campeon);

$consulta_tercero="SELECT count(*) as puntos from partidos_mundial2022 where CodPar=65 and visitante=(select visitante from partidos_mundial2022 where CodPar=65 and CodUsu='ProfetaMundial') AND CodUsu='".$_GET['verlode']."'";
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Copa Mundial FIFA Qatar 2022</title>
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
<p class="letrasmasgrandes">Copa Mundial FIFA Rusia 2022</p>
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
?><div class="tablaclasificacion">
<div class="comentarios">
<p>Pronostico de <b><?=$_GET['verlode']?></b> </p>
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
<? if	($_SESSION['MM_Username']=='ProfetaMundial')	{ ?>
<form action="#" method="post" name="fpuntuar">
	<input type="hidden" name="puntuar" />
	<input name="usuario" type="hidden" value="<?=$_GET['verlode']?>"/>
	<input type="hidden" name="puntos" value="<?=$total?>"/>
	<input type="submit" class="botones" value="Puntuar"/>
</form>
<? }?>
</div>
</div>
<br />




<!-- inicio de area Izquierda -->
	<div class="contenedora_2018">
<br /><b>GRUPO A</b>
<br />
	<?php while ($filasresultado=mysqli_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<?php echo $filasresultado['local']; ?>  <b><?php echo $filasresultado['glocal']; ?></b>  - <b><?php echo $filasresultado['gvisitante']; ?></b> <?php echo $filasresultado['visitante']; ?> 
			</div>
			<?php } ?>
            <br />
<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo A</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_A=mysqli_fetch_assoc($resultado_tabla_A)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_A['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_A['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_A['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_A['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_A['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO B</b>
<br />
<?php while ($filasresultadoB=mysqli_fetch_assoc($resultadoB)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoB['local']; ?> <b><?php echo $filasresultadoB['glocal']; ?></b> - <b><?php echo $filasresultadoB['gvisitante']; ?></b> <?php echo $filasresultadoB['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo B</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_B=mysqli_fetch_assoc($resultado_tabla_B)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_B['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_B['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_B['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_B['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_B['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />

<br /><b>GRUPO C</b>
<br />
<?php while ($filasresultadoC=mysqli_fetch_assoc($resultadoC)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoC['local']; ?> <b><?php echo $filasresultadoC['glocal']; ?></b> - <b><?php echo $filasresultadoC['gvisitante']; ?></b> <?php echo $filasresultadoC['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo C</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_C=mysqli_fetch_assoc($resultado_tabla_C)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_C['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_C['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_C['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_C['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_C['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO D</b>
<br />
<?php while ($filasresultadoD=mysqli_fetch_assoc($resultadoD)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoD['local']; ?> <b><?php echo $filasresultadoD['glocal']; ?></b> - <b><?php echo $filasresultadoD['gvisitante']; ?></b> <?php echo $filasresultadoD['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo D</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_D=mysqli_fetch_assoc($resultado_tabla_D)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_D['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_D['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_D['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_D['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_D['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO E</b>
<br />
<?php while ($filasresultadoE=mysqli_fetch_assoc($resultadoE)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoE['local']; ?> <b><?php echo $filasresultadoE['glocal']; ?></b> - <b><?php echo $filasresultadoE['gvisitante']; ?></b> <?php echo $filasresultadoE['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo E</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_E=mysqli_fetch_assoc($resultado_tabla_E)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_E['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_E['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_E['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_E['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_E['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO F</b>
<br />
<?php while ($filasresultadoF=mysqli_fetch_assoc($resultadoF)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoF['local']; ?> <b><?php echo $filasresultadoF['glocal']; ?></b> - <b><?php echo $filasresultadoF['gvisitante']; ?></b> <?php echo $filasresultadoF['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo F</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_F=mysqli_fetch_assoc($resultado_tabla_F)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_F['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_F['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_F['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_F['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_F['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO G</b>
<br />
<?php while ($filasresultadoG=mysqli_fetch_assoc($resultadoG)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoG['local']; ?> <b><?php echo $filasresultadoG['glocal']; ?></b> - <b><?php echo $filasresultadoG['gvisitante']; ?></b> <?php echo $filasresultadoG['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo G</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_G=mysqli_fetch_assoc($resultado_tabla_G)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_G['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_G['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_G['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_G['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_G['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO H</b>
<br />
<?php while ($filasresultadoH=mysqli_fetch_assoc($resultadoH)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoH['local']; ?> <b><?php echo $filasresultadoH['glocal']; ?></b> - <b><?php echo $filasresultadoH['gvisitante']; ?></b> <?php echo $filasresultadoH['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table  class="tablaclasificacion2018">
				<tr class="comentarios">
					<td>Grupo H</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_H=mysqli_fetch_assoc($resultado_tabla_H)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_H['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_H['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_H['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_H['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_H['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>Segunda Fase</b>
<br />
    
<p><b>Octavos</b></p>
<?php while ($filasresultadooctavos=mysqli_fetch_assoc($resultadooctavos)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadooctavos['local']; ?> <b><?php echo $filasresultadooctavos['glocal']; ?></b>  -  <b><?php echo $filasresultadooctavos['gvisitante']; ?></b>  <?php echo $filasresultadooctavos['visitante']; ?>  
			</div>
<?php } ?>


<p><b>Cuartos</b></p>
<?php while ($filasresultadocuartos=mysqli_fetch_assoc($resultadocuartos)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadocuartos['local']; ?> <b><?php echo $filasresultadocuartos['glocal']; ?></b>  -  <b><?php echo $filasresultadocuartos['gvisitante']; ?></b>  <?php echo $filasresultadocuartos['visitante']; ?>  
			</div>
<?php } ?>


<p><b>Semifinales</b></p>
<?php while ($filasresultadosemis=mysqli_fetch_assoc($resultadosemis)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadosemis['local']; ?> <b><?php echo $filasresultadosemis['glocal']; ?></b>  -  <b><?php echo $filasresultadosemis['gvisitante']; ?></b>  <?php echo $filasresultadosemis['visitante']; ?>  
			</div>
<?php } ?>


	<p><b>TERCER Y CUARTO PUESTO</b></p>
	<div class="comentarios" style="text-align:center; font-size:14px; padding:6px;">
<img src="imagenes/banamerica/<?php echo $filasresultadotercer['local']; ?>.gif" width="20" height="10" /> <?php echo $filasresultadotercer['local']; ?> <b><?php echo $filasresultadotercer['glocal']; ?></b> - <b><?php echo $filasresultadotercer['gvisitante']; ?></b> <?php echo $filasresultadotercer['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadotercer['visitante']; ?>.gif" width="20" height="10" />
	</div>
            
	<p><b>FINAL</b></p>
	<div class="comentarios" style="text-align:center; font-size:14px; padding:6px;">
<img src="imagenes/banamerica/<?php echo $filasresultadofinal['local']; ?>.gif" width="20" height="10" /> <?php echo $filasresultadofinal['local']; ?> <b><?php echo $filasresultadofinal['glocal']; ?></b> - <b><?php echo $filasresultadofinal['gvisitante']; ?></b> <?php echo $filasresultadofinal['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadofinal['visitante']; ?>.gif" width="20" height="10" />
	</div>
 
    <br />
    <div class="comentarios">
	<p><b>Campeon: </b><?php echo $filasresultadocampeon['local']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadocampeon['local']; ?>.gif" width="20" height="10" /></p>
	<p><b>Tercero: </b><?php echo $filasresultadocampeon['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadocampeon['visitante']; ?>.gif" width="20" height="10" /></p>

	<p><b>Goleador </b>: <?php echo $filasresultadogoleador['local']; ?>  (<?php echo $filasresultadogoleador['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultadogoleador['visitante']; ?>.gif" width="20" height="10" />)  </p>
			
		</div>
		
		<br />


<!-- fin de la Derecha -->
<div style="clear: both;"></div>

</div>
<br /><br />
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
