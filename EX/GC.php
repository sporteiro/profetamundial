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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoC")) {
			for ($n=13;$n<19;$n++) {
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
				$LP13=$_POST['L13'];
				$LP14=$_POST['L14'];
				$LP15=$_POST['L15'];
				$LP16=$_POST['L16'];
				$LP17=$_POST['L17'];
				$LP18=$_POST['L18'];
				
				$VP13=$_POST['V13'];
				$VP14=$_POST['V14'];
				$VP15=$_POST['V15'];
				$VP16=$_POST['V16'];
				$VP17=$_POST['V17'];
				$VP18=$_POST['V18'];
				//GOLES URU
				$UF=$LP13+$LP16+$VP17;
				$UC=$VP13+$VP16+$LP17;
				$UD=$UF-$UC;
				//GOLES PER
				$PF=$VP13+$LP15+$LP18;
				$PC=$LP13+$VP15+$VP18;
				$PD=$PF-$PC;
				//GOLES CHI
				$CF=$LP14+$VP16+$VP18;
				$CC=$VP14+$LP16+$LP18;
				$CD=$CF-$CC;
				//GOLES MEX
				$MF=$VP14+$VP15+$LP17;
				$MC=$LP14+$LP15+$VP17;
				$MD=$MF-$MC;
				
				//PUNTOS PARTIDO 13
				if ($LP13>$VP13) {
					$PLP13=3;
					$PVP13=0;
					}
				if ($LP13==$VP13) {
					$PLP13=1;
					$PVP13=1;
					}
				if ($LP13<$VP13) {
					$PLP13=0;
					$PVP13=3;
					}
				//PUNTOS PARTIDO 14
				if ($LP14>$VP14) {
					$PLP14=3;
					$PVP14=0;
					}
				if ($LP14==$VP14) {
					$PLP14=1;
					$PVP14=1;
					}
				if ($LP14<$VP14) {
					$PLP14=0;
					$PVP14=3;
					}
					
				//PUNTOS PARTIDO 15
				if ($LP15>$VP15) {
					$PLP15=3;
					$PVP15=0;
					}
				if ($LP15==$VP15) {
					$PLP15=1;
					$PVP15=1;
					}
				if ($LP15<$VP15) {
					$PLP15=0;
					$PVP15=3;
					}
				//PUNTOS PARTIDO 16
				if ($LP16>$VP16) {
					$PLP16=3;
					$PVP16=0;
					}
				if ($LP16==$VP16) {
					$PLP16=1;
					$PVP16=1;
					}
				if ($LP16<$VP16) {
					$PLP16=0;
					$PVP16=3;
					}
				//PUNTOS PARTIDO 17
				if ($LP17>$VP17) {
					$PLP17=3;
					$PVP17=0;
					}
				if ($LP17==$VP17) {
					$PLP17=1;
					$PVP17=1;
					}
				if ($LP17<$VP17) {
					$PLP17=0;
					$PVP17=3;
					}
				//PUNTOS PARTIDO 18
				if ($LP18>$VP18) {
					$PLP18=3;
					$PVP18=0;
					}
				if ($LP18==$VP18) {
					$PLP18=1;
					$PVP18=1;
					}
				if ($LP18<$VP18) {
					$PLP18=0;
					$PVP18=3;
					}
					
   $updateSQL2 = "UPDATE equipos SET puntos='".$PLP13."'+'".$PLP16."'+'".$PVP17."', golfav='".$UF."', golcon='".$UC."', difgol='".$UD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=9";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos SET puntos='".$PVP13."'+'".$PLP15."'+'".$PLP18."', golfav='".$PF."', golcon='".$PC."', difgol='".$PD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=10";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PLP14."'+'".$PVP16."'+'".$PVP18."', golfav='".$CF."', golcon='".$CC."', difgol='".$CD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=11";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PVP14."'+'".$PVP15."'+'".$PLP17."', golfav='".$MF."', golcon='".$MC."', difgol='".$MD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=12";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
//ELEGIR LOS 2 MEJORES DEL GRUPO
  
  
         $actualizar_primero = "UPDATE partidos SET local=(SELECT nombre FROM equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=26";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos SET visitante=(SELECT nombre FROM equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=28";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());
  

//RECARGAR LA PAGINA

  $updateGoTo = "GC.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//MOSTRAR LOS PARTIDOS Y LA TABLA

mysql_select_db($database_conexion,$conexion);
$consultaC="SELECT * FROM partidos WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoC=mysql_query($consultaC, $conexion);

$consulta_tabla_C="SELECT * FROM equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
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
			<img src="imagenes/banamerica/<?php echo $filasresultadoC['local']; ?>.gif" width="20" height="10"/>  <?php echo $filasresultadoC['local']; ?> <input type="text" name="L<?php echo $filasresultadoC['CodPar']; ?>" id="L<?php echo $filasresultadoC['CodPar']; ?>" size="2" max-size="2" maxlength="2"  value="<?php echo $filasresultadoC['glocal']; ?>" class="botoneschicos" onChange="mostrar()"/>  - <input type="text" name="V<?php echo $filasresultadoC['CodPar']; ?>" id="V<?php echo $filasresultadoC['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoC['gvisitante']; ?>" class="botoneschicos" onChange="mostrar()"/> <?php echo $filasresultadoC['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadoC['visitante']; ?>.gif" width="20" height="10"/>
			</div>


			<?php } ?>
           <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span> 
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
               <input type="hidden" name="MM_update" value="grupoC" />
</form>
</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
