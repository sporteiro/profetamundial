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


//MOSTRAR LA TABLA Y LOS america_partidos

mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM america_partidos WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM america_equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_B=mysql_query($consulta_tabla_B, $conexion);
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
<form name="grupoB" method="post" action="<?php echo $editFormAction; ?>">
			<?php while ($filasresultadoB=mysql_fetch_assoc($resultadoB)) { ?>
			<div class="comentarios">
		<img src="imagenes/banamerica/<?php echo $filasresultadoB['local']; ?>.gif" width="20" height="10"/>	<?php echo $filasresultadoB['local']; ?> <input type="text" name="L<?php echo $filasresultadoB['CodPar']; ?>" id="L<?php echo $filasresultadoB['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoB['glocal']; ?>" class="botoneschicos"  readonly="readonly"/>  - <input type="text" name="V<?php echo $filasresultadoB['CodPar']; ?>" id="V<?php echo $filasresultadoB['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoB['gvisitante']; ?>" class="botoneschicos"  readonly="readonly"/> <?php echo $filasresultadoB['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadoB['visitante']; ?>.gif" width="20" height="10"/>
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
               <input type="hidden" name="MM_update" value="grupoB" />
</form>
</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
