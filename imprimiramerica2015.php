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
$consulta="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 1 AND 6 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM america2015_equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);



mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM america2015_equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_B=mysql_query($consulta_tabla_B, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultaC="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoC=mysql_query($consultaC, $conexion);

$consulta_tabla_C="SELECT * FROM america2015_equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_C=mysql_query($consulta_tabla_C, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultaD="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 19 AND 24 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoD=mysql_query($consultaD, $conexion);

$consulta_tabla_D="SELECT * FROM america2015_equipos WHERE grupo='D' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_D=mysql_query($consulta_tabla_D, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultacuartos="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 25 AND 28 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadocuartos=mysql_query($consultacuartos, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultasemis="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 29 AND 30 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadosemis=mysql_query($consultasemis, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultafinal="SELECT * FROM america2015_partidos WHERE CodPar=31 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadofinal=mysql_query($consultafinal, $conexion);
$filasresultadofinal=mysql_fetch_assoc($resultadofinal);

mysql_select_db($database_conexion,$conexion);
$consultatercer="SELECT * FROM america2015_partidos WHERE CodPar=32 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadotercer=mysql_query($consultatercer, $conexion);
$filasresultadotercer=mysql_fetch_assoc($resultadotercer);


mysql_select_db($database_conexion,$conexion);
$consultagoleador="SELECT * FROM america2015_partidos WHERE CodPar=34 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadogoleador=mysql_query($consultagoleador, $conexion);
$filasresultadogoleador=mysql_fetch_assoc($resultadogoleador);
										
mysql_select_db($database_conexion,$conexion);
$consultacampeon="SELECT * FROM america2015_partidos WHERE CodPar=33  AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadocampeon=mysql_query($consultacampeon, $conexion);
$filasresultadocampeon=mysql_fetch_assoc($resultadocampeon);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Euro 2012 Polonia-Ucrania</title>
<link href="estiloblanco.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<br />
<div id="contenedora" class="contenedora">
<p class="letrasmasgrandes">Euro 2012 Polonia-Ucrania</p>
<p>Pronostico de <b><?php echo $_SESSION['MM_Username']?></b> <span class="letraschicas">El <?php echo date('d-m-Y') .'a las'. date('h:i:s');?></span> </p>
<!-- inicio de area Izquierda -->
		
<form action="europa.php">
	<input type="submit" value="Volver" onclick="index.php"/>
	<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
</form>
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
<br /><b>GRUPO C</b>
<br />

	<?php while ($filasresultadoC=mysql_fetch_assoc($resultadoC)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadoC['local']; ?> <b><?php echo $filasresultadoC['glocal']; ?></b>  -  <b><?php echo $filasresultadoC['gvisitante']; ?></b>  <?php echo $filasresultadoC['visitante']; ?>  
			</div>
			<?php } ?>
       
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo C</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_C=mysql_fetch_assoc($resultado_tabla_C)) { ?>
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
<br />
<br /><b>GRUPO D</b>
<br />

	<?php while ($filasresultadoD=mysql_fetch_assoc($resultadoD)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadoD['local']; ?> <b><?php echo $filasresultadoD['glocal']; ?></b>  -  <b><?php echo $filasresultadoD['gvisitante']; ?></b>  <?php echo $filasresultadoD['visitante']; ?>  
			</div>
			<?php } ?>
       
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo D</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_D=mysql_fetch_assoc($resultado_tabla_D)) { ?>
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
<br /><b>Segunda Fase</b>
<br />
<p><b>Cuartos de Final</b></p>
<?php while ($filasresultadocuartos=mysql_fetch_assoc($resultadocuartos)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadocuartos['local']; ?> <b><?php echo $filasresultadocuartos['glocal']; ?></b>  -  <b><?php echo $filasresultadocuartos['gvisitante']; ?></b>  <?php echo $filasresultadocuartos['visitante']; ?>  
			</div>
			<?php } ?>
    
<p><b>Semifinales</b></p>
<?php while ($filasresultadosemis=mysql_fetch_assoc($resultadosemis)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadosemis['local']; ?> <b><?php echo $filasresultadosemis['glocal']; ?></b>  -  <b><?php echo $filasresultadosemis['gvisitante']; ?></b>  <?php echo $filasresultadosemis['visitante']; ?>  
			</div>
			<?php } ?>
            
    <p><b>FINAL</b></p>
<?php echo $filasresultadofinal['local']; ?> <b><?php echo $filasresultadofinal['glocal']; ?></b> -  <b><?php echo $filasresultadofinal['gvisitante']; ?></b> <?php echo $filasresultadofinal['visitante']; ?>


	<p><b>Campeon: </b><?php echo $filasresultadocampeon['local']; ?> </p>

			<div class="comentarios">
		
			</div>


	<p><b>Goleador </b>: <?php echo $filasresultadogoleador['local']; ?>  (<?php echo $filasresultadogoleador['visitante']; ?>)  </p>
			
		
		
		<br />
<form action="europa.php">
	<input type="submit" value="Volver" onclick="index.php"/>
	<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">
</form>

<!-- fin de la Derecha -->
<div style="clear: both;"></div>
</div>
<!-- Inicio de banners -->
</body>
</html>
