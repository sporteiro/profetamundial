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
//ACTUALIZAR LOS PARTIDOS
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoD")) {
			for ($n=19;$n<25;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				//ACTUALIZAR LOS GRUPOS
				//meter todos los goles en variables
				$LP19=$_POST['L19'];
				$LP20=$_POST['L20'];
				$LP21=$_POST['L21'];
				$LP22=$_POST['L22'];
				$LP23=$_POST['L23'];
				$LP24=$_POST['L24'];
				
				$VP19=$_POST['V19'];
				$VP20=$_POST['V20'];
				$VP21=$_POST['V21'];
				$VP22=$_POST['V22'];
				$VP23=$_POST['V23'];
				$VP24=$_POST['V24'];
				//GOLES 1
				$AF=$LP19+$VP21+$VP23;
				$AC=$VP19+$LP21+$LP23;
				$AD=$AF-$AC;
				//GOLES GRE
				$BF=$VP19+$VP22+$LP24;
				$BC=$LP19+$LP22+$VP24;
				$BD=$BF-$BC;
				//GOLES RUS
				$CF=$LP20+$LP21+$VP24;
				$CC=$VP20+$VP21+$LP24;
				$CD=$CF-$CC;
				//GOLES CRC
				$RF=$VP20+$LP23+$LP22;
				$RC=$LP20+$VP23+$VP22;
				$RD=$RF-$RC;
				
				//PUNTOS PARTIDO 1
				if ($LP19>$VP19) {
					$PLP19=3;
					$PVP19=0;
					}
				if ($LP19==$VP19) {
					$PLP19=1;
					$PVP19=1;
					}
				if ($LP19<$VP19) {
					$PLP19=0;
					$PVP19=3;
					}
				//PUNTOS PARTIDO 2
				if ($LP20>$VP20) {
					$PLP20=3;
					$PVP20=0;
					}
				if ($LP20==$VP20) {
					$PLP20=1;
					$PVP20=1;
					}
				if ($LP20<$VP20) {
					$PLP20=0;
					$PVP20=3;
					}
					
				//PUNTOS PARTIDO 3
				if ($LP21>$VP21) {
					$PLP21=3;
					$PVP21=0;
					}
				if ($LP21==$VP21) {
					$PLP21=1;
					$PVP21=1;
					}
				if ($LP21<$VP21) {
					$PLP21=0;
					$PVP21=3;
					}
				//PUNTOS PARTIDO 4
				if ($LP22>$VP22) {
					$PLP22=3;
					$PVP22=0;
					}
				if ($LP22==$VP22) {
					$PLP22=1;
					$PVP22=1;
					}
				if ($LP22<$VP22) {
					$PLP22=0;
					$PVP22=3;
					}
				//PUNTOS PARTIDO 5
				if ($LP23>$VP23) {
					$PLP23=3;
					$PVP23=0;
					}
				if ($LP23==$VP23) {
					$PLP23=1;
					$PVP23=1;
					}
				if ($LP23<$VP23) {
					$PLP23=0;
					$PVP23=3;
					}
				//PUNTOS PARTIDO 6
				if ($LP24>$VP24) {
					$PLP24=3;
					$PVP24=0;
					}
				if ($LP24==$VP24) {
					$PLP24=1;
					$PVP24=1;
					}
				if ($LP24<$VP24) {
					$PLP24=0;
					$PVP24=3;
					}
					
   $updateSQL2 = "UPDATE equipos SET puntos='".$PLP19."'+'".$PVP21."'+'".$PVP23."', golfav='".$AF."', golcon='".$AC."', difgol='".$AD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=15";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos SET puntos='".$PVP19."'+'".$PVP22."'+'".$PLP24."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=16";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PLP20."'+'".$PLP21."'+'".$PVP24."', golfav='".$CF."', golcon='".$CC."', difgol='".$CD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=13";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PVP20."'+'".$PLP22."'+'".$PLP23."', golfav='".$RF."', golcon='".$RC."', difgol='".$RD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=14";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  
//METER EN CUARTOS AL PRIMERO Y AL SEGUNDO

       $actualizar_primero = "UPDATE partidos SET local=(SELECT nombre FROM equipos WHERE grupo='D' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=28";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos SET visitante=(SELECT nombre FROM equipos WHERE grupo='D' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=26";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());
  
//RECARGAR LA PAGINA

  $updateGoTo = "GD.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM partidos WHERE CodPar BETWEEN 19 AND 24 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM equipos WHERE grupo='D' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);

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
<form name="grupoD" method="post" action="<?php echo $editFormAction; ?>">
			<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<img src="imagenes/banamerica/<?php echo $filasresultado['local']; ?>.gif" width="20" height="10"/><?php echo $filasresultado['local']; ?>  <input type="text" name="L<?php echo $filasresultado['CodPar']; ?>" id="L<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" value="<?php echo $filasresultado['glocal']; ?>" class="botoneschicos" onChange="mostrar()"/>  - <input type="text" name="V<?php echo $filasresultado['CodPar']; ?>" id="V<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" class="botoneschicos" value="<?php echo $filasresultado['gvisitante']; ?>" onChange="mostrar()"/> <?php echo $filasresultado['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultado['visitante']; ?>.gif" width="20" height="10"/>
			</div>
			<?php } ?>
            <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span>           
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo D</td>
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
            <input type="hidden" name="MM_update" value="grupoD" />
</form>
</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
