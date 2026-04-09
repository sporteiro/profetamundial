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


mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 1 AND 6 AND CodUsu='".$_GET['verlode']."' ORDER BY CodPar";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM equipos_conf WHERE grupo='A' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);



mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_GET['verlode']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM equipos_conf WHERE grupo='B' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_B=mysql_query($consulta_tabla_B, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultaC="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_GET['verlode']."'";
$resultadoC=mysql_query($consultaC, $conexion);

$consulta_tabla_C="SELECT * FROM equipos_conf WHERE grupo='C' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_C=mysql_query($consulta_tabla_C, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultaD="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 19 AND 24 AND CodUsu='".$_GET['verlode']."'";
$resultadoD=mysql_query($consultaD, $conexion);

$consulta_tabla_D="SELECT * FROM equipos_conf WHERE grupo='D' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_D=mysql_query($consulta_tabla_D, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultacuartos="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 25 AND 28 AND CodUsu='".$_GET['verlode']."'";
$resultadocuartos=mysql_query($consultacuartos, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultasemis="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 29 AND 30 AND CodUsu='".$_GET['verlode']."'";
$resultadosemis=mysql_query($consultasemis, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultafinal="SELECT * FROM partidos_conf WHERE CodPar=31 AND CodUsu='".$_GET['verlode']."'";
$resultadofinal=mysql_query($consultafinal, $conexion);
$filasresultadofinal=mysql_fetch_assoc($resultadofinal);

mysql_select_db($database_conexion,$conexion);
$consultatercer="SELECT * FROM partidos_conf WHERE CodPar=32 AND CodUsu='".$_GET['verlode']."'";
$resultadotercer=mysql_query($consultatercer, $conexion);
$filasresultadotercer=mysql_fetch_assoc($resultadotercer);


mysql_select_db($database_conexion,$conexion);
$consultagoleador="SELECT * FROM partidos_conf WHERE CodPar=34 AND CodUsu='".$_GET['verlode']."'";
$resultadogoleador=mysql_query($consultagoleador, $conexion);
$filasresultadogoleador=mysql_fetch_assoc($resultadogoleador);
										
mysql_select_db($database_conexion,$conexion);
$consultacampeon="SELECT * FROM partidos_conf WHERE CodPar=33  AND CodUsu='".$_GET['verlode']."'";
$resultadocampeon=mysql_query($consultacampeon, $conexion);
$filasresultadocampeon=mysql_fetch_assoc($resultadocampeon);



/////////PUNTUACIONES

mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos_conf pp join partidos_conf ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<25 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysql_query($consulta_puntos_resultados, $conexion);
$filas_puntos_resultados = mysql_fetch_assoc($resultado_puntos_resultados);

mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados2="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos_conf pp join partidos_conf ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$_GET['verlode']."' AND pp.CodUsu='profetamundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 25 AND 31) AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysql_query($consulta_puntos_resultados2, $conexion);
$filas_puntos_resultados2 = mysql_fetch_assoc($resultado_puntos_resultados2);


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos_conf pp join partidos_conf ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado and pp.CodPar<25  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysql_query($consulta_puntos_exactos, $conexion);
$filas_puntos_exactos = mysql_fetch_assoc($resultado_puntos_exactos);



mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos2="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos_conf pp join partidos_conf ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='profetamundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 25 AND 31)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysql_query($consulta_puntos_exactos2, $conexion);
$filas_puntos_exactos2 = mysql_fetch_assoc($resultado_puntos_exactos2);


mysql_select_db($database_conexion,$conexion);
$consulta_cuartos="
(
SELECT local as cuartos FROM partidos_conf
WHERE CodUsu = '".$_GET['verlode']."'
AND
(local in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 25 AND 28)
OR local in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 25 AND 28)
)
AND CodPar BETWEEN 25 AND 28
)
UNION
(
SELECT visitante as cuartos FROM partidos_conf
WHERE CodUsu =  '".$_GET['verlode']."'
AND
( visitante in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 25 AND 28)
OR visitante in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 25 AND 28)
)
AND CodPar BETWEEN 25 AND 28
)
";
$resultado_cuartos=mysql_query($consulta_cuartos, $conexion);
$filas_cuartos= mysql_num_rows($resultado_cuartos);



mysql_select_db($database_conexion,$conexion);
$consulta_semis="(
SELECT local as cuartos FROM partidos_conf
WHERE CodUsu = '".$_GET['verlode']."'
AND
(local in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 29 AND 30)
OR local in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 29 AND 30)
)
AND CodPar BETWEEN 29 AND 30
)
UNION
(
SELECT visitante as cuartos FROM partidos_conf
WHERE CodUsu =  '".$_GET['verlode']."'
AND
( visitante in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 29 AND 30)
OR visitante in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar BETWEEN 29 AND 30)
)
AND CodPar BETWEEN 29 AND 30
)";
$resultado_semis=mysql_query($consulta_semis, $conexion);
$filas_semis= mysql_num_rows($resultado_semis);




mysql_select_db($database_conexion,$conexion);
$consulta_final="(
SELECT local as cuartos FROM partidos_conf
WHERE CodUsu = '".$_GET['verlode']."'
AND
(local in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar=31)
OR local in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar=31)
)
AND CodPar=31
)
UNION
(
SELECT visitante as cuartos FROM partidos_conf
WHERE CodUsu =  '".$_GET['verlode']."'
AND
( visitante in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar=31)
OR visitante in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar=31)
)
AND CodPar=31
)";
$resultado_final=mysql_query($consulta_final, $conexion);
$filas_final= mysql_num_rows($resultado_final);

/////////TERCER PUESTO PUNTUAR/////
mysql_select_db($database_conexion,$conexion);
$consulta_tercer="(

SELECT local as cuartos FROM partidos_conf
WHERE CodUsu = '".$_GET['verlode']."'
AND
(local in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar=32)
OR local in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar=32)
)
AND CodPar=32
)
UNION
(
SELECT visitante as cuartos FROM partidos_conf
WHERE CodUsu =  '".$_GET['verlode']."'
AND
( visitante in 
(select visitante from partidos_conf where CodUsu='profetamundial' AND CodPar=32)
OR visitante in 
(select local from partidos_conf where CodUsu='profetamundial' AND CodPar=32)
)
AND CodPar=32
)";
$resultado_tercer=mysql_query($consulta_tercer, $conexion);
$filas_tercer= mysql_num_rows($resultado_tercer);

/////////TERCER PUESTO PUNTUAR/////


mysql_select_db($database_conexion,$conexion);
$consulta_goleador="SELECT count(*) as puntos from partidos_conf where 
CodPar=34 and 
local like (select local from partidos_conf where CodPar=34 and CodUsu='profetamundial')
and visitante=(select visitante from partidos_conf where CodPar=34 and CodUsu='profetamundial')
AND CodUsu='".$_GET['verlode']."'";
$resultado_goleador=mysql_query($consulta_goleador, $conexion);
$filas_goleador= mysql_fetch_assoc($resultado_goleador);


mysql_select_db($database_conexion,$conexion);
$consulta_campeon="SELECT count(*) as puntos from partidos_conf where CodPar=33 and local=(select local from partidos_conf where CodPar=33 and CodUsu='profetamundial') AND CodUsu='".$_GET['verlode']."'";
$resultado_campeon=mysql_query($consulta_campeon, $conexion);
$filas_campeon= mysql_fetch_assoc($resultado_campeon);


mysql_select_db($database_conexion,$conexion);
$consulta_tercero="SELECT count(*) as puntos from partidos_conf where CodPar=33 and visitante=(select visitante from partidos_conf where CodPar=33 and CodUsu='profetamundial') AND CodUsu='".$_GET['verlode']."'";
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Copa Confederaciones Brasil 2013</title>
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
<p class="letrasmasgrandes">Copa Confederaciones Brasil 2013</p>
<?
//Puntuaciones:
$exactos=$filas_puntos_exactos['puntos']+$filas_puntos_exactos2['puntos'];
$pexactos=$exactos*5;

$partidoGrupos=$filas_puntos_resultados['puntos']-$filas_puntos_exactos['puntos'];

$partidoSegunda=$filas_puntos_resultados2['puntos']-$filas_puntos_exactos2['puntos'];
$puntospartidoSegunda=$partidoSegunda*2;

$cuartos=$filas_cuartos;
//$cuartos=0;//Comentar cuando empiezen los cuartos

$semis=$filas_semis;

$tercer=$filas_tercer;

$final=$filas_final;

$goleador=$filas_goleador['puntos'];
$pgoleador=$goleador*10;

$campeon=$filas_campeon['puntos'];
$pcampeon=$campeon*15;

$tercero=$filas_tercero['puntos'];
$ptercero=$tercero*5;

$total=$pexactos+$partidoGrupos+$puntospartidoSegunda+$semis+$tercer+$final+$pgoleador+$pcampeon+$ptercero;
?>
<div class="tablaclasificacion">
<div class="comentarios">
<p>Pronostico de <b><?php echo $_GET['verlode']?></b> </p>
<p>Resultado del partido: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoGrupos?>  (<?=$partidoGrupos?> puntos)</p>
<p>Resultado del partido en Segunda Fase: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoSegunda?>  (<?=$puntospartidoSegunda?> puntos)</p>
<p>Resultados exactos Totales:  <?=$exactos?>  (<?=$pexactos?> puntos)</p>
<p><b>Extras:</b></p>
<p>Equipos que estan en semifinales:  <?=$semis?>  (<?=$semis?> puntos)</p>
<p>Equipos que estan en el partido por el tercer y cuarto puesto:  <?=$tercer?>  (<?=$tercer?> puntos)</p>
<p>Equipos que estan en la final:  <?=$final?>  (<?=$final?> puntos)</p>
<p>Tercero:  <?=$tercero?>  (<?=$ptercero?> puntos)</p>
<p>Goleador:  <?=$goleador?>  (<?=$pgoleador?> puntos)</p>
<p>Campeon:  <?=$campeon?>  (<?=$pcampeon?> puntos)</p>
<hr />
<p style="font-size:24px;">Total: <b><?=$total?></b> puntos</p>
<? if	($_SESSION['MM_Username']=='profetamundial')	{ ?>
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
<div class="tablaclasificacion">
<br /><b>GRUPO A</b>
<br />
	<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<?php echo $filasresultado['local']; ?>  <b><?php echo $filasresultado['glocal']; ?></b>  - <b><?php echo $filasresultado['gvisitante']; ?></b> <?php echo $filasresultado['visitante']; ?> 
			</div>
			<?php } ?>
            <br />
<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo A</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_A=mysql_fetch_assoc($resultado_tabla_A)) { ?>
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
<?php while ($filasresultadoB=mysql_fetch_assoc($resultadoB)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoB['local']; ?> <b><?php echo $filasresultadoB['glocal']; ?></b> - <b><?php echo $filasresultadoB['gvisitante']; ?></b> <?php echo $filasresultadoB['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo B</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_B=mysql_fetch_assoc($resultado_tabla_B)) { ?>
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

<br /><b>Segunda Fase</b>
<br />
    
<p><b>Semifinales</b></p>
<?php while ($filasresultadosemis=mysql_fetch_assoc($resultadosemis)) { ?>
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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
</div>
<!-- Final --> 
</body>
</html>
