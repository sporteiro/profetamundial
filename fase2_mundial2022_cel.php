<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$today = date("YmdH"); 
//el servidor tiene 5 horas menos que GMT 
$limite='2022111823';
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

  $theValue = mysqli_real_escape_string($conexion, $theValue);

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
$c=$conexion;
$d=$database_conexion;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//ACTUALIZO LOS GOLES
if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "fase2")) {
			for ($n=49;$n<65;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos_mundial2022 SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  
  $Result1 = mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
				}
				
//ELIJO QUIEN PASA LA ELIMINATORIA


				function ganadorPartidoCel($numPar)	{
					$golLoc=$_POST['L'.$numPar.''];
					$golVis=$_POST['V'.$numPar.''];
					if ($golLoc<$golVis) {
						$ganadorP=$_POST['visitante'.$numPar.''];			
					}
					if ($golLoc>$golVis) {
						$ganadorP=$_POST['local'.$numPar.''];	
					}
					if ($golLoc==$golVis) {	
						$ganadorP=$_POST['elegir'.$numPar.''];
					}
					return $ganadorP;
				}
				//funcion aparte para elegir al perdedor del partido semifinal
				function elegirTerceroCel($locOvis)	{
					if ($_POST['elegir'.$locOvis.'']==$_POST['local'.$locOvis.'']) {	
						$terceroElegido=$_POST['visitante'.$locOvis.''];
					}
					else $terceroElegido=$_POST['local'.$locOvis.'']; 
					return $terceroElegido;
				}
					//Cuartos de finalistas
					$cuartista1= ganadorPartidoCel(49);
					$cuartista2= ganadorPartidoCel(50);
					$cuartista3= ganadorPartidoCel(51);
					$cuartista4= ganadorPartidoCel(52);
					$cuartista5= ganadorPartidoCel(53);
					$cuartista6= ganadorPartidoCel(54);
					$cuartista7= ganadorPartidoCel(55);
					$cuartista8= ganadorPartidoCel(56);
					
					//Semifinalistas
					$semifinalista1= ganadorPartidoCel(57);
					$semifinalista2= ganadorPartidoCel(58);
					$semifinalista3= ganadorPartidoCel(59);
					$semifinalista4= ganadorPartidoCel(60);		
						
					// FINALISTAS y TERCERISTAS
					$LP61=$_POST['L61'];
					$LP62=$_POST['L62'];
					$VP61=$_POST['V61'];
					$VP62=$_POST['V62'];
					if ($LP61<$VP61) {
						$finalista1=$_POST['visitante61'];
						$tercerista1=$_POST['local61'];
						}
					if ($LP61>$VP61) {
						$finalista1=$_POST['local61'];
						$tercerista1=$_POST['visitante61'];
						}
					if ($LP61==$VP61) {
						$finalista1=$_POST['elegir61'];
						$tercerista1=elegirTerceroCel(61);
						}
					
					
					if ($LP62<$VP62) {
						$finalista2=$_POST['visitante62'];
						$tercerista2=$_POST['local62'];
						}
					if ($LP62>$VP62)  {
						$finalista2=$_POST['local62'];
						$tercerista2=$_POST['visitante62'];
						}
					if ($LP62==$VP62)  {
						$finalista2=$_POST['elegir62'];
						$tercerista2=elegirTerceroCel(62);
						}
					
					//Campeon y tercero
					$campeon=ganadorPartidoCel(63);
					$tercero=ganadorPartidoCel(64);
					
					
			function actualizarPartidosCel($nomEqu, $numPar,$locOvis,$c,$d)		{
				$updateSQL="UPDATE partidos_mundial2022 SET ".$locOvis."='".$nomEqu."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$numPar."'";
				$Result = mysqli_query($c, $updateSQL) or die(mysqli_error($conexion));
			}
			actualizarPartidosCel($cuartista1,57,'local',$c,$d);
			actualizarPartidosCel($cuartista2,57,'visitante',$c,$d);
			actualizarPartidosCel($cuartista3,59,'local',$c,$d);
			actualizarPartidosCel($cuartista4,59,'visitante',$c,$d);
			actualizarPartidosCel($cuartista5,58,'local',$c,$d);
			actualizarPartidosCel($cuartista6,58,'visitante',$c,$d);
			actualizarPartidosCel($cuartista7,60,'local',$c,$d);
			actualizarPartidosCel($cuartista8,60,'visitante',$c,$d);
 			
			actualizarPartidosCel($semifinalista1,61,'local',$c,$d);
			actualizarPartidosCel($semifinalista2,61,'visitante',$c,$d);
			actualizarPartidosCel($semifinalista3,62,'local',$c,$d);
			actualizarPartidosCel($semifinalista4,62,'visitante',$c,$d);
  			
			actualizarPartidosCel($finalista1,63,'local',$c,$d);
			actualizarPartidosCel($finalista2,63,'visitante',$c,$d);
		
			actualizarPartidosCel($tercerista1,64,'local',$c,$d);
			actualizarPartidosCel($tercerista2,64,'visitante',$c,$d);
			
			actualizarPartidosCel($campeon,65,'local',$c,$d);
			actualizarPartidosCel($tercero,65,'visitante',$c,$d);
  				
			actualizarPartidosCel($_POST['jugador'],66,'local',$c,$d);
			actualizarPartidosCel($_POST['pais'],66,'visitante',$c,$d);
  	
  $updateGoTo = "fase2_mundial2022_cel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
function consultaEquipoCel($partido,$c,$d,$consulta)	{
	$consulta_partido="SELECT * FROM partidos_mundial2022 WHERE CodPar='".$partido."' AND CodUsu='".$_SESSION['MM_Username']."'";
	$resultado_partido=mysqli_query($c, $consulta_partido);
	$equipos_partido=mysqli_fetch_assoc($resultado_partido);
	switch ($consulta)	{
		case 'local':
			$resConsulta=$equipos_partido['local'];
			break;
		case 'visitante': 
			$resConsulta=$equipos_partido['visitante']; 
			break;
		case 'glocal':
			$resConsulta=$equipos_partido['glocal'];
			break;
		case 'gvisitante':
			$resConsulta=$equipos_partido['gvisitante'];
			break;
	}
	return $resConsulta;
}	




$consulta_equipos_ol="SELECT nombre FROM equipos_mundial2022";
$resultado_equipos_ol=mysqli_query($conexion, $consulta_equipos_ol);
?>
<html>
<head>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="jquery.js" type="text/javascript"></script>
<script type="text/javascript">
function mostrar_fase2() {
	//document.getElementById("flecha").className="visible";
	//actualizar_fase2_variasveces_cel();
	$("#boton_fase2_cel").show();
	}
</script>
<script>
$(document).ready(function() {
	$("#boton_fase2_cel").hide();
	$("#fase2_cel").submit(function(e) {
		e.preventDefault();
		var $form = $(this),
		url = $form.attr( "action" );
		var n=0;
		console.log('enviando formulario' + n);	
		var posting = $.post( url,$("#fase2_cel").serialize());
		posting.done(function(data) {
			$('#tabla_fase2_cel').load(" #tabla_fase2_cel  > *");
		});
		
	});
});
function actualizar_fase2_variasveces_cel()	{
	var i = 8;
	var estados=['Comprobando','Goleador','Tercer puesto','Campeon','Final','Semifinales','Cuartos','Octavos','Resultados'];
		(function k(){
		actualizar_fase2_cel();
		$("#info_mundial").show();
		$("#info_mundial").html('Actualizando <br />'+estados[i]+'<br /> <img src="imagenes/cargando.gif" height="30px"/>');
		if( --i ) {
			setTimeout( k, 1000);
		}
		if (i<=0) {
			$("#info_mundial").html('Actualizado');
			$("#info_mundial").hide();
		}
	})()
}
function actualizar_fase2_cel()	{
	$("#fase2_cel").submit();
	$("#boton_fase2_cel").hide();
}
</script>
</head>
<body>  
<!--
<div style="background-color:#10598c;">
	<div>
<? if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?>
    <span class="letrasgrandesnaranjas">&iexcl;IMPORTANTE!</span> Dale a esta flecha cada vez que hagas cambios en los grupos<br />
     <input type="button" value=" " class="botones" onClick="location.reload();" style=" background-image:url(imagenes/flechabajo.png); background-position:center; background-repeat:no-repeat; cursor:pointer;"/> <? } ?>
     <br />
</div><br />   

-->
   	<!--sin tabla -->
	 <form name="fase2_cel"  id="fase2_cel" method="post" action="<?php echo $editFormAction; ?>">
<!-- Octavos -->
       <div id="tabla_fase2_cel" class="tabla_fase2_cel">
	<?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><!--<button class="botoneschicos" onclick="actualizar_fase2_variasveces_cel()">Guardar</button>--><? } ?>
    	<p><b>Octavos</b></p>
	<?php for ($n=49;$n<57;$n++) {?>
	<div class="comentarios">
        	<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/> -
<input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> 

			 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				49=>array("np"=>57,"lov"=>"local"),
				50=>array("np"=>57,"lov"=>"visitante"),
				51=>array("np"=>59,"lov"=>"local"),
				52=>array("np"=>59,"lov"=>"visitante"),
				53=>array("np"=>58,"lov"=>"local"),
				54=>array("np"=>58,"lov"=>"visitante"),
				55=>array("np"=>60,"lov"=>"local"),
				56=>array("np"=>60,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipoCel($n,$c,$d,'glocal')==consultaEquipoCel($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipoCel($n,$c,$d,'local');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
	<? } ?>


<!-- Cuartos -->
    	<p><b>Cuartos</b></p>
	<?php for ($n=57;$n<61;$n++) {?>
	<div class="comentarios">
        	<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/> - 
<input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'visitante');?>
		 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				57=>array("np"=>61,"lov"=>"local"),
				58=>array("np"=>61,"lov"=>"visitante"),
				59=>array("np"=>62,"lov"=>"local"),
				60=>array("np"=>62,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipoCel($n,$c,$d,'glocal')==consultaEquipoCel($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipoCel($n,$c,$d,'local');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
	<? } ?>


<!-- Semis -->
    	<p><b>Semifinales</b></p>
	<?php for ($n=61;$n<63;$n++) {?>
	<div class="comentarios">
        <img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" />	<?=consultaEquipoCel($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/> - <input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" />
<?=consultaEquipoCel($n,$c,$d,'visitante');?>
			 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				61=>array("np"=>63,"lov"=>"local"),
				62=>array("np"=>63,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipoCel($n,$c,$d,'glocal')==consultaEquipoCel($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipoCel($n,$c,$d,'local');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
	<? } ?>


<!-- Final -->
    	<p><b>Final</b></p>
	<div class="comentarios">
	<?php $n=63?>
        	 <img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/> - 
<input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
 <img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'visitante');?>

		 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				63=>array("np"=>65,"lov"=>"local"),
			);
		?>
		
            <?php if ((consultaEquipoCel($n,$c,$d,'glocal')==consultaEquipoCel($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipoCel($n,$c,$d,'local');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>

	</div>

<!-- Campeon -->
    	<p><b>Campeon</b></p>
	<div class="comentarios">
	<?php $n=65?>
        	<b><?=consultaEquipoCel($n,$c,$d,'local');?></b>
		<img src="imagenes/banamerica/<?=consultaEquipoCel($n,$c,$d,'local');?>.gif" width="20" height="10" />
	</div>
<!-- Tercer y cuarto puesto -->
    	<p><b>Tercer y cuarto puesto</b></p>
	<div class="comentarios">
	<?php $n=64?>
        	 <img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/> - 
<input type="hidden" value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="number" min="0" max="99" onchange="mostrar_fase2()" size="1" maxlength="2" value="<?=consultaEquipoCel($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
 <img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipoCel($n,$c,$d,'visitante');?>

			 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				64=>array("np"=>65,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipoCel($n,$c,$d,'glocal')==consultaEquipoCel($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipoCel($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipoCel($n,$c,$d,'local');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipoCel($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
<!-- Tercero -->
    	<p><b>Tercero</b></p>
	<div class="comentarios">
	<?php $n=65?>
        	<?=consultaEquipoCel($n,$c,$d,'visitante');?>
		<img src="imagenes/banamerica/<?=consultaEquipoCel($n,$c,$d,'visitante');?>.gif" width="20" height="10" />
	</div>
<!-- Goleador-->
    	<p><b>Goleador</b></p>
	<div class="comentarios">
	<?php $n=66?>
        	Jugador:<input name="jugador" id="jugador" type="text" value="<?=consultaEquipoCel($n,$c,$d,'local');?>" class="botoneschicos"/><br />
	Seleccion:
	<select name="pais" id="pais" class="botoneschicos">
                    		<option value="<?=consultaEquipoCel($n,$c,$d,'visitante');?>" selected="selected"><?=consultaEquipoCel($n,$c,$d,'visitante');?>
                            </option>
                            
                            <?php while ($equipos_ol=mysqli_fetch_assoc($resultado_equipos_ol)) { ?>
                            	<option value="<?php echo $equipos_ol['nombre'];?>"><?php echo $equipos_ol['nombre'];?></option>
							<?php } ?>
                            
                    </select>	

</div>
<?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><button id="boton_fase2_cel" class="botones" onclick="actualizar_fase2_variasveces_cel()">Guardar cambios</button><? } ?>
<input type="hidden" name="MM_update" value="fase2" />
</form>
	<!-- Se termina la tabla 
    <br />
    <div class="tablaclasificacion">
    	<div class="fixture">
   			 <span>&iexcl;IMPORTANTE!</span><span>Asegurate que todos los cambios realizados fueron guardados dandole al boton de actualizar hasta que refleje los resultados. Por ejemplo, si elegiste campeon al 1\BA del grupo A, y despues cambiaste su grupo y ya no es el primero, vas a tener que actualizar 3 veces (para cambiar las semifinales, la final y el campeon)</span><br /><br />
   		 </div>
    </div>
    <br />
</div>
<br /><br /><br /><br /><br /><br /><br /><br />-->
<br /><br />
</div>
</body>
</html>
