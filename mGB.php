<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlogadmin.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoB")) {
			for ($n=7;$n<13;$n++) {
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
				$LP7=$_POST['L7'];
				$LP8=$_POST['L8'];
				$LP9=$_POST['L9'];
				$LP10=$_POST['L10'];
				$LP11=$_POST['L11'];
				$LP12=$_POST['L12'];
				
				$VP7=$_POST['V7'];
				$VP8=$_POST['V8'];
				$VP9=$_POST['V9'];
				$VP10=$_POST['V10'];
				$VP11=$_POST['V11'];
				$VP12=$_POST['V12'];
				//GOLES BRA
				$BF=$LP7+$LP9+$LP12;
				$BC=$VP7+$VP9+$VP12;
				$BD=$BF-$BC;
				//GOLES VEN
				$VF=$VP7+$LP10+$VP11;
				$VC=$LP7+$VP10+$LP11;
				$VD=$VF-$VC;
				//GOLES PAR
				$PF=$LP8+$VP9+$LP11;
				$PC=$VP8+$LP9+$VP11;
				$PD=$PF-$PC;
				//GOLES ECU
				$EF=$VP8+$VP10+$VP12;
				$EC=$LP8+$LP10+$LP12;
				$ED=$EF-$EC;
				
				//PUNTOS PARTIDO 7
				if ($LP7>$VP7) {
					$PLP7=3;
					$PVP7=0;
					}
				if ($LP7==$VP7) {
					$PLP7=1;
					$PVP7=1;
					}
				if ($LP7<$VP7) {
					$PLP7=0;
					$PVP7=3;
					}
				//PUNTOS PARTIDO 8
				if ($LP8>$VP8) {
					$PLP8=3;
					$PVP8=0;
					}
				if ($LP8==$VP8) {
					$PLP8=1;
					$PVP8=1;
					}
				if ($LP8<$VP8) {
					$PLP8=0;
					$PVP8=3;
					}
					
				//PUNTOS PARTIDO 9
				if ($LP9>$VP9) {
					$PLP9=3;
					$PVP9=0;
					}
				if ($LP9==$VP9) {
					$PLP9=1;
					$PVP9=1;
					}
				if ($LP9<$VP9) {
					$PLP9=0;
					$PVP9=3;
					}
				//PUNTOS PARTIDO 10
				if ($LP10>$VP10) {
					$PLP10=3;
					$PVP10=0;
					}
				if ($LP10==$VP10) {
					$PLP10=1;
					$PVP10=1;
					}
				if ($LP10<$VP10) {
					$PLP10=0;
					$PVP10=3;
					}
				//PUNTOS PARTIDO 11
				if ($LP11>$VP11) {
					$PLP11=3;
					$PVP11=0;
					}
				if ($LP11==$VP11) {
					$PLP11=1;
					$PVP11=1;
					}
				if ($LP11<$VP11) {
					$PLP11=0;
					$PVP11=3;
					}
				//PUNTOS PARTIDO 12
				if ($LP12>$VP12) {
					$PLP12=3;
					$PVP12=0;
					}
				if ($LP12==$VP12) {
					$PLP12=1;
					$PVP12=1;
					}
				if ($LP12<$VP12) {
					$PLP12=0;
					$PVP12=3;
					}
					
   $updateSQL2 = "UPDATE equipos SET puntos='".$PLP7."'+'".$PLP9."'+'".$PLP12."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=8";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos SET puntos='".$PVP7."'+'".$PLP10."'+'".$PVP11."', golfav='".$VF."', golcon='".$VC."', difgol='".$VD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=5";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PLP8."'+'".$PVP9."'+'".$PLP11."', golfav='".$PF."', golcon='".$PC."', difgol='".$PD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=6";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos SET puntos='".$PVP8."'+'".$PVP10."'+'".$PVP12."', golfav='".$EF."', golcon='".$EC."', difgol='".$ED."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=7";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  //PASAR LOS 2 MEJORES DEL GRUPO
  
         $actualizar_primero = "UPDATE partidos SET local=(SELECT nombre FROM equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=21";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos SET visitante=(SELECT nombre FROM equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=22";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());

  
//CALCULAR LOS 2 MEJORES TERCEROS

$consulta_terceroA="SELECT * FROM equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroA=mysql_query($consulta_terceroA, $conexion);
$filas_terceroA=mysql_fetch_assoc($resultado_terceroA);

$consulta_terceroB="SELECT * FROM equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroB=mysql_query($consulta_terceroB, $conexion);
$filas_terceroB=mysql_fetch_assoc($resultado_terceroB);

$consulta_terceroC="SELECT * FROM equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroC=mysql_query($consulta_terceroC, $conexion);
$filas_terceroC=mysql_fetch_assoc($resultado_terceroC);


         $mejor_tercero = "UPDATE partidos SET visitante=(SELECT nombre FROM equipos WHERE nombre in('".$filas_terceroA['nombre']."','".$filas_terceroB['nombre']."','".$filas_terceroC['nombre']."') AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=19";
  mysql_select_db($database_conexion, $conexion);
  $Result_mejor_tercero = mysql_query($mejor_tercero, $conexion) or die(mysql_error());
  
           $segundo_mejor_tercero = "UPDATE partidos SET visitante=(SELECT nombre FROM equipos WHERE nombre in('".$filas_terceroA['nombre']."','".$filas_terceroB['nombre']."','".$filas_terceroC['nombre']."') AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=21";
  mysql_select_db($database_conexion, $conexion);
  $Result_segundo_mejor_tercero = mysql_query($segundo_mejor_tercero, $conexion) or die(mysql_error());



//RECARGAR LA PAGINA


  $updateGoTo = "mGB.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM partidos WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
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
		<img src="imagenes/banamerica/<?php echo $filasresultadoB['local']; ?>.gif" width="20" height="10"/>	<?php echo $filasresultadoB['local']; ?> <input type="text" name="L<?php echo $filasresultadoB['CodPar']; ?>" id="L<?php echo $filasresultadoB['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoB['glocal']; ?>" class="botoneschicos" onChange="mostrar()"/>  - <input type="text" name="V<?php echo $filasresultadoB['CodPar']; ?>" id="V<?php echo $filasresultadoB['CodPar']; ?>" size="2" maxlength="2"  value="<?php echo $filasresultadoB['gvisitante']; ?>" class="botoneschicos" onChange="mostrar()"/> <?php echo $filasresultadoB['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadoB['visitante']; ?>.gif" width="20" height="10"/>
			</div>
			<?php } ?>
       <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span> 
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
