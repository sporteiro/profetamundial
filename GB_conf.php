<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?
$today = date("Ymd"); 
$limite='20130612';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;

?>
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
if	($_SESSION['MM_Username']!='profetamundial')	{ 

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoB")) {
			for ($n=7;$n<13;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos_conf SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
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
				//GOLES MEX
				$BF=$LP7+$LP9+$VP11;
				$BC=$VP7+$VP9+$LP11;
				$BD=$BF-$BC;
				//GOLES COR
				$VF=$VP7+$VP10+$LP12;
				$VC=$LP7+$LP10+$VP12;
				$VD=$VF-$VC;
				//GOLES GAB
				$PF=$LP8+$VP9+$VP12;
				$PC=$VP8+$LP9+$LP12;
				$PD=$PF-$PC;
				//GOLES SUI
				$EF=$VP8+$LP10+$LP11;
				$EC=$LP8+$VP10+$VP11;
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
					
   $updateSQL2 = "UPDATE equipos_conf SET puntos='".$PLP7."'+'".$PLP9."'+'".$PVP11."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=5";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos_conf SET puntos='".$PVP7."'+'".$PVP10."'+'".$PLP12."', golfav='".$VF."', golcon='".$VC."', difgol='".$VD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=6";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_conf SET puntos='".$PLP8."'+'".$PVP9."'+'".$PVP12."', golfav='".$PF."', golcon='".$PC."', difgol='".$PD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=7";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_conf SET puntos='".$PVP8."'+'".$PLP10."'+'".$PLP11."', golfav='".$EF."', golcon='".$EC."', difgol='".$ED."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=8";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  //PASAR LOS 2 MEJORES DEL GRUPO
  
         $actualizar_primero = "UPDATE partidos_conf SET local=(SELECT nombre FROM equipos_conf WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=30";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos_conf SET visitante=(SELECT nombre FROM equipos_conf WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=29";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());


//RECARGAR LA PAGINA


  $updateGoTo = "GB_conf.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}
}
//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM partidos_conf WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM equipos_conf WHERE grupo='B' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_B=mysql_query($consulta_tabla_B, $conexion);

////////////////////////////////////ALTERAR
  if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if (isset($_POST['primero']))	{

  $actualizar_primero = "UPDATE partidos_conf SET local='".$_POST['primero']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=27";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());

  
  $actualizar_segundo = "UPDATE partidos_conf SET visitante='".$_POST['segundo']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=25";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());

}
}
////////////////////////////////////ALTERAR
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
<? if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?>
       <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span> 
<? } ?>
		<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo B</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php $e=array();
				$p=array();
				while ($filasresultado_tabla_B=mysql_fetch_assoc($resultado_tabla_B)) { ?>
				<tr>
					<td><?php $n=$filasresultado_tabla_B['nombre'];echo $n ?></td>
					<td><?php $pu=$filasresultado_tabla_B['puntos'];echo $pu?></td>
					<td><?php echo $filasresultado_tabla_B['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_B['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_B['difgol']; ?></td>
				</tr>
					<?array_push($e,$n);
					  array_push($p,$pu);
					?>
			<?php } ?>
			</table>
               <input type="hidden" name="MM_update" value="grupoB" />
</form>

<? 
if (($p[0]==$p[1]) or ($p[1]==$p[2]) && ($_SESSION['MM_Username']=='ProfetaMundial')	 ) {
?>
<input type="button" class="botoneschicos" onclick="document.getElementById('alterar').className='visible'" value="Alterar posiciones entre el primero y el segundo del grupo" title="Si no estas conforme con la clasificacion automatica de los 2 primeros del grupo, podes alterar quien es el primero y quien el segundo en pasar a Cuartos de Final. Tus cambios NO SE VERAN REFLEJADOS EN LA TABLA SUPERIOR, ademas, acordate de darle a la flecha de la Segunda Fase para actualizar quien juega los cuartos. Para mas informacion, leer las Reglas del Juego."/><br />
<div class="invisible" id="alterar">
		<form name="alterar" method="post" action="GB_conf.php">
			1&ordm; <select name="primero" class="botoneschicos">
			<option selected="selected"><?=$e[0]?></option>
			<?foreach ($e as $eq) { ?>
				<?if ($eq!=$e[0]){?>
				<option><?=$eq?></option>
				<?}?>			
			<?  } ;?>
			</select>
			2&ordm; <select name="segundo" class="botoneschicos">
			<option selected="selected"><?=$e[1]?></option>
			<?foreach ($e as $eq) { ?>
				<?if ($eq!=$e[1]){?>
				<option><?=$eq?></option>
				<?}?>			
			<?  } ;?>
			</select>
			<input type="submit" value="Alterar" class="botoneschicos"/>
		</form>
</div>
<?  } ?>

</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
