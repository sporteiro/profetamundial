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
if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoG")) {
			for ($n=37;$n<43;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos_mundial2014 SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				//ACTUALIZAR LOS GRUPOS
				//meter todos los goles en variables
				$LP1=$_POST['L37'];
				$LP2=$_POST['L38'];
				$LP3=$_POST['L39'];
				$LP4=$_POST['L40'];
				$LP5=$_POST['L41'];
				$LP6=$_POST['L42'];
				
				$VP1=$_POST['V37'];
				$VP2=$_POST['V38'];
				$VP3=$_POST['V39'];
				$VP4=$_POST['V40'];
				$VP5=$_POST['V41'];
				$VP6=$_POST['V42'];
				//GOLES 1
				$AF=$LP1+$LP3+$VP5;
				$AC=$VP1+$VP3+$LP5;
				$AD=$AF-$AC;
				//GOLES 2
				$BF=$VP1+$VP4+$LP6;
				$BC=$LP1+$LP4+$VP6;
				$BD=$BF-$BC;
				//GOLES 3
				$CF=$LP2+$VP3+$VP6;
				$CC=$VP2+$LP3+$LP6;
				$CD=$CF-$CC;
				//GOLES 4
				$RF=$VP2+$LP4+$LP5;
				$RC=$LP2+$VP4+$VP5;
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
					
   $updateSQL2 = "UPDATE equipos_mundial2014 SET puntos='".$PLP1."'+'".$PLP3."'+'".$PVP5."', golfav='".$AF."', golcon='".$AC."', difgol='".$AD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=25";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos_mundial2014 SET puntos='".$PVP1."'+'".$PVP4."'+'".$PLP6."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=26";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_mundial2014 SET puntos='".$PLP2."'+'".$PVP3."'+'".$PVP6."', golfav='".$CF."', golcon='".$CC."', difgol='".$CD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=27";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_mundial2014 SET puntos='".$PVP2."'+'".$PLP4."'+'".$PLP5."', golfav='".$RF."', golcon='".$RC."', difgol='".$RD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=28";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  
//METER EN CUARTOS AL PRIMERO Y AL SEGUNDO

       $actualizar_primero = "UPDATE partidos_mundial2014 SET local=(SELECT nombre FROM equipos_mundial2014 WHERE grupo='G' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=55";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos_mundial2014 SET visitante=(SELECT nombre FROM equipos_mundial2014 WHERE grupo='G' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=56";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());
  
//RECARGBR LA PAGINA

  $updateGoTo = "GG_mundial2014.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}
}
//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM partidos_mundial2014 WHERE CodPar BETWEEN 37 AND 42 AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY CodPar";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM equipos_mundial2014 WHERE grupo='G' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);


////////////////////////////////////ALTERAR
 if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if (isset($_POST['primero']))	{

  $actualizar_primero = "UPDATE partidos_mundial2014 SET local='".$_POST['primero']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=55";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());

  
  $actualizar_segundo = "UPDATE partidos_mundial2014 SET visitante='".$_POST['segundo']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=56";
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
<?
$today = date("YmdH"); 
//el servidor tiene 5 horas menos que GMT 
$limite='2014061018';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;
?>
<div style="background-color:#063; 	background-image:url(imagenes/trans.png);">
<div class="tablaclasificacion">



<form name="grupoG" method="post" action="<?php echo $editFormAction; ?>">


			<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<img src="imagenes/banamerica/<?php echo $filasresultado['local']; ?>.gif" width="20" height="10"/><?php echo $filasresultado['local']; ?>  <input type="text" name="L<?php echo $filasresultado['CodPar']; ?>" id="L<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" value="<?php echo $filasresultado['glocal']; ?>" class="botoneschicos" onChange="mostrar()"/>  - <input type="text" name="V<?php echo $filasresultado['CodPar']; ?>" id="V<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" class="botoneschicos" value="<?php echo $filasresultado['gvisitante']; ?>" onChange="mostrar()"/> <?php echo $filasresultado['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultado['visitante']; ?>.gif" width="20" height="10"/>
			</div>
			<?php } ?>

<? if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial') )	{ ?>
            <span class="invisible" id="flecha">
            <input type="submit" class="botones" value=" " style="background-image:url(imagenes/flechabajo.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" />
            </span>           
<? } ?>
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo G</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php $e=array();
				$p=array();
				while ($filasresultado_tabla_A=mysql_fetch_assoc($resultado_tabla_A)) { ?>
				<tr>	
					<td><?php $n=$filasresultado_tabla_A['nombre'];echo $n ?></td>
					<td><?php $pu=$filasresultado_tabla_A['puntos'];echo $pu?></td>
					<td><?php echo $filasresultado_tabla_A['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_A['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_A['difgol']; ?></td>
					<?array_push($e,$n);
					  array_push($p,$pu);
					?>
				</tr>
			<?php } ?>
			</table>
            <input type="hidden" name="MM_update" value="grupoG" />
</form>

<? 
if (($p[0]==$p[1]) or ($p[1]==$p[2]) && ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	 ) {
?>
<input type="button" class="botoneschicos" onclick="document.getElementById('alterar').className='visible'" value="Alterar posiciones entre el primero y el segundo del grupo" title="Si no estas conforme con la clasificacion automatica de los 2 primeros del grupo, podes alterar quien es el primero y quien el segundo en pasar a Cuartos de Final. Tus cambios NO SE VERAN REFLEJADOS EN LA TABLA SUPERIOR, ademas, acordate de darle a la flecha de la Segunda Fase para actualizar quien juega los cuartos. Para mas informacion, leer las Reglas del Juego."/><br />
<div class="invisible" id="alterar">
		<form name="alterar" method="post" action="GG_mundial2014.php">
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
<? } ?>

</div>
<br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
