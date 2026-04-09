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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "grupoH")) {
			for ($n=43;$n<49;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos_mundial2018 SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				//ACTUALIZAR LOS GRUPOS
				//meter todos los goles en variables
				$LP1=$_POST['L43'];
				$LP2=$_POST['L44'];
				$LP3=$_POST['L45'];
				$LP4=$_POST['L46'];
				$LP5=$_POST['L47'];
				$LP6=$_POST['L48'];
				
				$VP1=$_POST['V43'];
				$VP2=$_POST['V44'];
				$VP3=$_POST['V45'];
				$VP4=$_POST['V46'];
				$VP5=$_POST['V47'];
				$VP6=$_POST['V48'];
				//GOLES 1
				$AF=$LP2+$LP4+$VP5;
				$AC=$VP2+$VP4+$LP5;
				$AD=$AF-$AC;
				//GOLES 2
				$BF=$VP2+$VP3+$LP6;
				$BC=$LP2+$LP3+$VP6;
				$BD=$BF-$BC;
				//GOLES 3
				$CF=$LP1+$VP4+$VP6;
				$CC=$VP1+$LP4+$LP6;
				$CD=$CF-$CC;
				//GOLES 4
				$RF=$VP1+$LP3+$LP5;
				$RC=$LP1+$VP3+$VP5;
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
					
   $updateSQL2 = "UPDATE equipos_mundial2018 SET puntos='".$PLP2."'+'".$PLP4."'+'".$PVP5."', golfav='".$AF."', golcon='".$AC."', difgol='".$AD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=29";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
     $updateSQL2 = "UPDATE equipos_mundial2018 SET puntos='".$PVP2."'+'".$PVP3."'+'".$PLP6."', golfav='".$BF."', golcon='".$BC."', difgol='".$BD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=30";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_mundial2018 SET puntos='".$PLP1."'+'".$PVP4."'+'".$PVP6."', golfav='".$CF."', golcon='".$CC."', difgol='".$CD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=31";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
       $updateSQL2 = "UPDATE equipos_mundial2018 SET puntos='".$PVP1."'+'".$PLP3."'+'".$PLP5."', golfav='".$RF."', golcon='".$RC."', difgol='".$RD."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodEqu=32";
  mysql_select_db($database_conexion, $conexion);
  $Result2 = mysql_query($updateSQL2, $conexion) or die(mysql_error());
  
  
//METER EN CUARTOS AL PRIMERO Y AL SEGUNDO

       $actualizar_primero = "UPDATE partidos_mundial2018 SET local=(SELECT nombre FROM equipos_mundial2018 WHERE grupo='H' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 0,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=56";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());
  
         $actualizar_segundo = "UPDATE partidos_mundial2018 SET visitante=(SELECT nombre FROM equipos_mundial2018 WHERE grupo='H' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre LIMIT 1,1) WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=54";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());
  
//RECARGBR LA PAGINA

  $updateGoTo = "GH_mundial2018.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}
}
//MOSTRAR LA TABLA Y LOS PARTIDOS

mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM partidos_mundial2018 WHERE CodPar BETWEEN 43 AND 48 AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY CodPar";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM equipos_mundial2018 WHERE grupo='H' AND CodUsu='".$_SESSION['MM_Username']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);


////////////////////////////////////ALTERAR
 if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if (isset($_POST['primero']))	{

  $actualizar_primero = "UPDATE partidos_mundial2018 SET local='".$_POST['primero']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=56";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_primero = mysql_query($actualizar_primero, $conexion) or die(mysql_error());

  
  $actualizar_segundo = "UPDATE partidos_mundial2018 SET visitante='".$_POST['segundo']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=54";
  mysql_select_db($database_conexion, $conexion);
  $Result_actualizar_segundo = mysql_query($actualizar_segundo, $conexion) or die(mysql_error());


}
}
////////////////////////////////////ALTERAR
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function mostrar_GH() {
	//document.getElementById("flecha").className="visible";
	//$("#grupoH").submit();
	$("#boton_grupoH").show();
	}
</script>
<script src="jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	 $("#boton_grupoH").hide();
	$("#grupoH").submit(function(e) {
	  e.preventDefault();
	  var $form = $(this),
	    url = $form.attr( "action" );
	  var posting = $.post( url,$("#grupoH").serialize());
	  posting.done(function( data ) {
	    $('#boton_guardar_H').val('Guardado');
	     $('#tabla_grupoH_mundial2018').load(" #tabla_grupoH_mundial2018  > *");
	     actualizar_fase2_variasveces();
	     actualizar_fase2_variasveces_cel();
	     $("#boton_grupoH").hide();
	  });
	});
});
</script>
 <script>
$(document).ready(function() {
	$("#alterar_GH").submit(function(e) {
	  e.preventDefault();
	  var $form = $(this),
	    url = $form.attr( "action" );
	  var posting = $.post( url,$("#alterar_GH").serialize());
	  posting.done(function( data ) {
	    $('#boton_guardar_H').val('Guardado');
	     $('#tabla_grupoH_mundial2018').load(" #tabla_grupoH_mundial2018  > *");
	     actualizar_fase2_variasveces();
	     actualizar_fase2_variasveces_cel();
	  });
	});
});
</script>
</head>
<body>
<?
$today = date("YmdH"); 
//el servidor tiene 1 horas menos que GMT 
$limite='2018061300';
if ($limite<=$today) {
	$fueraTiempo=1;
	}
else $fueraTiempo=0;

?>
<div>
	<div id="tablaypartidos_mundial2018">
		<div id="partidos_grupo_mundial2018">
<form name="grupoH" id="grupoH" method="post" action="#">
			<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
				<img src="imagenes/banamerica/<?php echo $filasresultado['local']; ?>.gif" width="20" height="10"/><?php echo $filasresultado['local']; ?>  <input type="number" min="0" max="99" name="L<?php echo $filasresultado['CodPar']; ?>" id="L<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" value="<?php echo $filasresultado['glocal']; ?>" class="botoneschicos" onChange="mostrar_GH()"/>  - <input type="number" min="0" max="99" name="V<?php echo $filasresultado['CodPar']; ?>" id="V<?php echo $filasresultado['CodPar']; ?>" size="1" maxlength="2" class="botoneschicos" value="<?php echo $filasresultado['gvisitante']; ?>" onChange="mostrar_GH()"/> <?php echo $filasresultado['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultado['visitante']; ?>.gif" width="20" height="10"/>
			</div>
		        <?php } ?>
		</div>
			<div id="tabla_grupoH_mundial2018" class="tabla_grupo_mundial2018">
			<table>
				<tr class="comentarios">
					<td>Grupo H</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php $e=array();
				$p=array();
				while ($filasresultado_tabla_H=mysql_fetch_assoc($resultado_tabla_A)) { ?>
				<tr class="comentarios">	
					<td><?php $n=$filasresultado_tabla_H['nombre'];echo '<img src="imagenes/banamerica/'.$n.'.gif" width="30" height="20"/>'.$n?></td>
					<td class="alignright"><?php $pu=$filasresultado_tabla_H['puntos'];echo $pu?></td>
					<td class="alignright"><?php echo $filasresultado_tabla_H['golfav']; ?></td>
					<td class="alignright"><?php echo $filasresultado_tabla_H['golcon']; ?></td>
					<td class="alignright"><?php echo $filasresultado_tabla_H['difgol']; ?></td>
					<?array_push($e,$n);
					  array_push($p,$pu);
					?>
				</tr>
			<?php } ?>
			</table>
			</div>
		<div class="clear"></div>

<?php if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial') )	{ ?>
		 <input type="submit" id="boton_grupoH" class="botones" value="Guardar cambios" />
<? } ?>
            <input type="hidden" name="MM_update" value="grupoH" />
</form>

<? 
if ((($p[0]==$p[1]) or ($p[1]==$p[2])) && ( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	 ) {
?>
<input type="button" class="botoneschicos" onclick="document.getElementById('alterar_GH_div').className='visible'" value="Alterar posiciones entre el primero y el segundo del grupo" title="Si no estas conforme con la clasificacion automatica de los 2 primeros del grupo, podes alterar quien es el primero y quien el segundo en pasar a Cuartos de Final. Tus cambios NO SE VERAN REFLEJADOS EN LA TABLA SUPERIOR, ademas, acordate de darle a la flecha de la Segunda Fase para actualizar quien juega los cuartos. Para mas informacion, leer las Reglas del Juego."/><br />
<div class="invisible" id="alterar_GH_div">
		<form name="alterar_GH" id="alterar_GH" method="post" action="GH_mundial2018.php">
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
</div>
</body>
</html>
