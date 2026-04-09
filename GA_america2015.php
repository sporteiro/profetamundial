<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$today = date("YmdH"); 
//el servidor tiene 5 horas menos que GMT 
$limite='2015061018';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;


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
if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoA")) {
			for ($n=0;$n<7;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE america2015_partidos SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				//ACTUALIZAR LOS GRUPOS
				//meter todos los goles en variables
				$LP1=$_POST['L1'];
				$LP2=$_POST['L2'];
				$LP3=$_POST['L3'];
				$LP4=$_POST['L4'];
				$LP5=$_POST['L5'];
				$LP6=$_POST['L6'];
				
				$VP1=$_POST['V1'];
				$VP2=$_POST['V2'];
				$VP3=$_POST['V3'];
				$VP4=$_POST['V4'];
				$VP5=$_POST['V5'];
				$VP6=$_POST['V6'];
				//GOLES CHI
				$AF=$LP1+$LP4+$LP6;
				$AC=$VP1+$VP4+$VP6;
				$AD=$AF-$AC;
				//GOLES ECU
				$BF=$VP1+$LP3+$VP5;
				$BC=$LP1+$VP3+$LP5;
				$BD=$BF-$BC;
				//GOLES MEX
				$CF=$LP2+$VP4+$LP5;
				$CC=$VP2+$LP4+$VP5;
				$CD=$CF-$CC;
				//GOLES BOL
				$RF=$VP2+$VP3+$VP6;
				$RC=$LP2+$LP3+$LP6;
				$RD=$RF-$RC;
				
				//PUNTOS PARTIDO 1
				if ($LP1>$VP1) {
					$PLP1=3;
					$PVP1=0;
					}
				if ($LP1==$VP1) {
					$PLP1=1;
					$PVP1=1;
					}
				if ($LP1<$VP1) {
					$PLP1=0;
					$PVP1=3;
					}
				//PUNTOS PARTIDO 2
				if ($LP2>$VP2) {
					$PLP2=3;
					$PVP2=0;
					}
				if ($LP2==$VP2) {
					$PLP2=1;
					$PVP2=1;
					}
				if ($LP2<$VP2) {
					$PLP2=0;
					$PVP2=3;
					}
					
				//PUNTOS PARTIDO 3
				if ($LP3>$VP3) {
					$PLP3=3;
					$PVP3=0;
					}
				if ($LP3==$VP3) {
					$PLP3=1;
					$PVP3=1;
					}
				if ($LP3<$VP3) {
					$PLP3=0;
					$PVP3=3;
					}
				//PUNTOS PARTIDO 4
				if ($LP4>$VP4) {
					$PLP4=3;
					$PVP4=0;
					}
				if ($LP4==$VP4) {
					$PLP4=1;
					$PVP4=1;
					}
				if ($LP4<$VP4) {
					$PLP4=0;
					$PVP4=3;
					}
				//PUNTOS PARTIDO 5
				if ($LP5>$VP5) {
					$PLP5=3;
					$PVP5=0;
					}
				if ($LP5==$VP5) {
					$PLP5=1;
					$PVP5=1;
					}
				if ($LP5<$VP5) {
					$PLP5=0;
					$PVP5=3;
					}
				//PUNTOS PARTIDO 6
				if ($LP6>$VP6) {
					$PLP6=3;
					$PVP6=0;
					}
				if ($LP6==$VP6) {
					$PLP6=1;
					$PVP6=1;
					}
				if ($LP6<$VP6) {
					$PLP6=0;
					$PVP6=3;
					}
					
   $updateSQL2 = "UPDATE america2015_equipos SET puntos='".$PLP1."'+'".$PLP4."'+'".$PLP6."', golfav='".$AF."', golcon='".$AC."', difgol='".$AD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=1";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE america2015_equipos SET puntos='".$PVP1."'+'".$PLP3."'+'".$PVP5."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=2";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE america2015_equipos SET puntos='".$PLP2."'+'".$PVP4."'+'".$PLP5."', golfav='".$CF."', golcon='".$CC."', difgol='".$CD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=3";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE america2015_equipos SET puntos='".$PVP2."'+'".$PVP3."'+'".$PVP6."', golfav='".$RF."', golcon='".$RC."', difgol='".$RD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=4";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  
//METER EN CUARTOS AL PRIMERO Y AL SEGUNDO

       $actualizar_primero = "UPDATE america2015_partidos SET local=(SELECT nombre FROM america2015_equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=19";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE america2015_partidos SET local=(SELECT nombre FROM america2015_equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=20";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());
  
//CALCULAR LOS 2 MEJORES TERCEROS

//CALCULAR LOS 2 MEJORES TERCEROS

$consulta_terceroA="SELECT * FROM america2015_equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroA=mysql_query($consulta_terceroA, $conexion);
$filas_terceroA=mysql_fetch_assoc($resultado_terceroA);

$consulta_terceroB="SELECT * FROM america2015_equipos WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroB=mysql_query($consulta_terceroB, $conexion);
$filas_terceroB=mysql_fetch_assoc($resultado_terceroB);

$consulta_terceroC="SELECT * FROM america2015_equipos WHERE grupo='C' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 2,1";
$resultado_terceroC=mysql_query($consulta_terceroC, $conexion);
$filas_terceroC=mysql_fetch_assoc($resultado_terceroC);


	$consulta_mejor_tercero="SELECT nombre FROM america2015_equipos WHERE nombre in('".$filas_terceroA['nombre']."','".$filas_terceroB['nombre']."','".$filas_terceroC['nombre']."') AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1;";
	$resultado_mejor_tercero=mysql_query($consulta_mejor_tercero, $conexion);
	$f_mejor_tercero=mysql_fetch_assoc($resultado_mejor_tercero);

	$consulta_mejor_tercero2="SELECT nombre FROM america2015_equipos WHERE nombre in('".$filas_terceroA['nombre']."','".$filas_terceroB['nombre']."','".$filas_terceroC['nombre']."') AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1;";
	$resultado_mejor_tercero2=mysql_query($consulta_mejor_tercero2, $conexion);
	$f_mejor_tercero2=mysql_fetch_assoc($resultado_mejor_tercero2);

echo $f_mejor_tercero['nombre'];
	if (($f_mejor_tercero['nombre']==$filas_terceroA['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroB['nombre']) )	
		{
		$al191va=$filas_terceroB['nombre'];
		$al21va=$filas_terceroA['nombre'];		
		}
	if (($f_mejor_tercero['nombre']==$filas_terceroA['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroC['nombre']) )	
		{
		$al191va=$filas_terceroC['nombre'];
		$al21va=$filas_terceroA['nombre'];
		}
	if (($f_mejor_tercero['nombre']==$filas_terceroB['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroC['nombre']) )	
		{
		$al191va=$filas_terceroB['nombre'];
		$al21va=$filas_terceroC['nombre'];
		}
	if (($f_mejor_tercero['nombre']==$filas_terceroB['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroA['nombre']) )	
		{
		$al191va=$filas_terceroB['nombre'];
		$al21va=$filas_terceroA['nombre'];
		}
	
	if (($f_mejor_tercero['nombre']==$filas_terceroC['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroA['nombre']) )	
		{
		$al191va=$filas_terceroC['nombre'];
		$al21va=$filas_terceroA['nombre'];
		}
	
	if (($f_mejor_tercero['nombre']==$filas_terceroC['nombre']) && ($f_mejor_tercero2['nombre']==$filas_terceroB['nombre']) )	
		{
		$al191va=$filas_terceroB['nombre'];
		$al21va=$filas_terceroC['nombre'];
		}


         $mejor_tercero_poner = "UPDATE america2015_partidos SET visitante='".$al191va."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=19";
  mysql_select_db($database_conexion, $conexion);
  $Result_mejor_tercero_poner = mysql_query($mejor_tercero_poner, $conexion) or die(mysql_error());
  
           $segundo_mejor_tercero_poner = "UPDATE america2015_partidos SET visitante='".$al21va."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=21";
  mysql_select_db($database_conexion, $conexion);
  $Result_segundo_mejor_tercero_poner = mysql_query($segundo_mejor_tercero_poner, $conexion) or die(mysql_error());
//RECARGAR LA PAGINA

  $updateGoTo = "GA_america2015.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM america2015_partidos WHERE CodPar BETWEEN 1 AND 6 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM america2015_equipos WHERE grupo='A' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
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
<form name="grupoA" method="post" action="<?php echo $editFormAction; ?>">
			<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<img src="imagenes/banamerica/<?php echo $filasresultado['local']; ?>.gif" width="20" height="10"/><?php echo $filasresultado['local']; ?>  <input type="text" name="L<?php echo $filasresultado['CodPar']; ?>" id="L<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" value="<?php echo $filasresultado['glocal']; ?>" class="botoneschicos" onChange="mostrar()"/>  - <input type="text" name="V<?php echo $filasresultado['CodPar']; ?>" id="V<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" class="botoneschicos" value="<?php echo $filasresultado['gvisitante']; ?>" onChange="mostrar()"/> <?php echo $filasresultado['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultado['visitante']; ?>.gif" width="20" height="10"/>
			</div>
			<?php } ?>

<?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?>
            <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span>           
<? } ?>
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
            <input type="hidden" name="MM_update" value="grupoA" />
</form>
</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
