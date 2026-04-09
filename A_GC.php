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

//MOSTRAR LOS america_partidos Y LA TABLA

mysql_select_db($database_conexion,$conexion);
$consultaC="SELECT * FROM america_partidos WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoC=mysql_query($consultaC, $conexion);

$consulta_tabla_C="SELECT * FROM america_equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_C=mysql_query($consulta_tabla_C, $conexion);
?>
<html>
<head>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function mostrar () {
	document.getElementById("flecha").className="visible";
	}
</script>
</head>
<body>
<div style="background-color:#063; 	background-image:url(imagenes/trans.png);">
<div class="tablaclasificacion">
<form name="grupoC" method="post" action="<?php echo $editFormAction; ?>">
			<?php while ($filasresultadoC=mysql_fetch_assoc($resultadoC)) { ?>
			<div class="comentarios">
			<img src="imagenes/banamerica/<?php echo $filasresultadoC['local']; ?>.gif" width="20" height="10"/>  <?php echo $filasresultadoC['local']; ?> <input type="text" name="L<?php echo $filasresultadoC['CodPar']; ?>" id="L<?php echo $filasresultadoC['CodPar']; ?>" size="2" max-size="2" maxlength="2"  value="<?php echo $filasresultadoC['glocal']; ?>" class="botoneschicos"  readonly="readonly"/>  - <input type="text"  readonly="readonly" name="V<?php echo $filasresultadoC['CodPar']; ?>" id="V<?php echo $filasresultadoC['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoC['gvisitante']; ?>" class="botoneschicos" onChange="mostrar()"/> <?php echo $filasresultadoC['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadoC['visitante']; ?>.gif" width="20" height="10" />
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
               
</form>
</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
