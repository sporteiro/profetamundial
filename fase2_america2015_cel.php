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
$c=$conexion;
$d=$database_conexion;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//ACTUALIZO LOS GOLES
if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "fase2")) {
			for ($n=19;$n<29;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE america2015_partidos SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				
//ELIJO QUIEN PASA LA ELIMINATORIA


				function ganadorPartido($numPar)	{
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
				function elegirTercero($locOvis)	{
					if ($_POST['elegir'.$locOvis.'']==$_POST['local'.$locOvis.'']) {	
						$terceroElegido=$_POST['visitante'.$locOvis.''];
					}
					else $terceroElegido=$_POST['local'.$locOvis.'']; 
					return $terceroElegido;
				}
				//	//Cuartos de finalistas
				//	$cuartista1= ganadorPartido(19);
				//	$cuartista2= ganadorPartido(20);
				//	$cuartista3= ganadorPartido(21);
				//	$cuartista4= ganadorPartido(22);
				//	$cuartista5= ganadorPartido(23);
				//	$cuartista6= ganadorPartido(24);
				//	$cuartista7= ganadorPartido(25);
				//	$cuartista8= ganadorPartido(26);
					
					//Semifinalistas
					$semifinalista1= ganadorPartido(19);
					$semifinalista2= ganadorPartido(20);
					$semifinalista3= ganadorPartido(21);
					$semifinalista4= ganadorPartido(22);		
						
					// FINALISTAS y TERCERISTAS
					$LP61=$_POST['L23'];
					$LP62=$_POST['L24'];
					$VP61=$_POST['V23'];
					$VP62=$_POST['V24'];
					if ($LP61<$VP61) {
						$finalista1=$_POST['visitante23'];
						$tercerista1=$_POST['local23'];
						}
					if ($LP61>$VP61) {
						$finalista1=$_POST['local23'];
						$tercerista1=$_POST['visitante23'];
						}
					if ($LP61==$VP61) {
						$finalista1=$_POST['elegir23'];
						$tercerista1=elegirTercero(23);
						}
					
					
					if ($LP62<$VP62) {
						$finalista2=$_POST['visitante24'];
						$tercerista2=$_POST['local24'];
						}
					if ($LP62>$VP62)  {
						$finalista2=$_POST['local24'];
						$tercerista2=$_POST['visitante24'];
						}
					if ($LP62==$VP62)  {
						$finalista2=$_POST['elegir24'];
						$tercerista2=elegirTercero(24);
						}
					
					//Campeon y tercero
					$campeon=ganadorPartido(25);
					$tercero=ganadorPartido(26);
					
					
			function actualizarPartidos($nomEqu, $numPar,$locOvis,$c,$d)		{
				$updateSQL="UPDATE america2015_partidos SET ".$locOvis."='".$nomEqu."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$numPar."'";
				mysql_select_db($d,$c);
				$Result = mysql_query($updateSQL, $c) or die(mysql_error());
			}
			//actualizarPartidos($cuartista1,21,'local',$c,$d);
			//actualizarPartidos($cuartista2,21,'visitante',$c,$d);
			//actualizarPartidos($cuartista3,19,'local',$c,$d);
//			actualizarPartidos($cuartista4,19,'visitante',$c,$d);
//			actualizarPartidos($cuartista5,22,'local',$c,$d);
//			actualizarPartidos($cuartista6,20,'local',$c,$d);
//			actualizarPartidos($cuartista7,22,'visitante',$c,$d);
//			actualizarPartidos($cuartista8,20,'visitante',$c,$d);
 			
			actualizarPartidos($semifinalista1,23,'local',$c,$d);
			actualizarPartidos($semifinalista2,23,'visitante',$c,$d);
			actualizarPartidos($semifinalista3,24,'local',$c,$d);
			actualizarPartidos($semifinalista4,24,'visitante',$c,$d);
  			
			actualizarPartidos($finalista1,25,'local',$c,$d);
			actualizarPartidos($finalista2,25,'visitante',$c,$d);
		
			actualizarPartidos($tercerista1,26,'local',$c,$d);
			actualizarPartidos($tercerista2,26,'visitante',$c,$d);
			
			actualizarPartidos($campeon,27,'local',$c,$d);
			actualizarPartidos($tercero,27,'visitante',$c,$d);
  				
			actualizarPartidos($_POST['jugador'],28,'local',$c,$d);
			actualizarPartidos($_POST['pais'],28,'visitante',$c,$d);
  	
  $updateGoTo = "fase2_america2015_cel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
function consultaEquipo($partido,$c,$d,$consulta)	{
	mysql_select_db($d,$c);
	$consulta_partido="SELECT * FROM america2015_partidos WHERE CodPar='".$partido."' AND CodUsu='".$_SESSION['MM_Username']."'";
	$resultado_partido=mysql_query($consulta_partido, $c);
	$america2015_equipos_partido=mysql_fetch_assoc($resultado_partido);
	switch ($consulta)	{
		case 'local':
			$resConsulta=$america2015_equipos_partido['local'];
			break;
		case 'visitante': 
			$resConsulta=$america2015_equipos_partido['visitante']; 
			break;
		case 'glocal':
			$resConsulta=$america2015_equipos_partido['glocal'];
			break;
		case 'gvisitante':
			$resConsulta=$america2015_equipos_partido['gvisitante'];
			break;
	}
	return $resConsulta;
}	



mysql_select_db($database_conexion,$conexion);
$consulta_america2015_equipos_ol="SELECT nombre FROM america2015_equipos";
$resultado_america2015_equipos_ol=mysql_query($consulta_america2015_equipos_ol, $conexion);
?>
<html>
<head>
<link href="estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>  

<div style="background-color:#063; background-image:url(imagenes/trans.png);">
	<div class="tablaresultados">
<? if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?>
    <span class="letrasgrandesnaranjas">&iexcl;IMPORTANTE!</span> Dale a esta flecha cada vez que hagas cambios en los grupos<br />
     <input type="button" value=" " class="botones" onClick="location.reload();" style=" background-image:url(imagenes/flechabajo.png); background-position:center; background-repeat:no-repeat; cursor:pointer;"/> <? } ?>
     <br /></div><br />   
	<div class="tablaresultados">

   	<!--sin tabla -->
	 <form name="fase2" method="post" action="<?php echo $editFormAction; ?>">
<!-- Octavos -->
	<?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><input type="submit" class="botones" value=" " style="background-image:url(imagenes/actualizar.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" /><? } ?>
    	

<!-- Cuartos -->
    	<p><b>Cuartos</b></p>
	<?php for ($n=19;$n<23;$n++) {?>
	<div>
        	<?=consultaEquipo($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/>

<?=consultaEquipo($n,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
		 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				19=>array("np"=>23,"lov"=>"local"),
				20=>array("np"=>23,"lov"=>"visitante"),
				21=>array("np"=>24,"lov"=>"local"),
				22=>array("np"=>24,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipo($n,$c,$d,'glocal')==consultaEquipo($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipo($n,$c,$d,'local');?>">
                            	<?=consultaEquipo($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipo($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
	<? } ?>


<!-- Semis -->
    	<p><b>Semifinales</b></p>
	<?php for ($n=23;$n<25;$n++) {?>
	<div>
        	<?=consultaEquipo($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/>

<?=consultaEquipo($n,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>
			 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				23=>array("np"=>25,"lov"=>"local"),
				24=>array("np"=>25,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipo($n,$c,$d,'glocal')==consultaEquipo($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipo($n,$c,$d,'local');?>">
                            	<?=consultaEquipo($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipo($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
	<? } ?>


<!-- Final -->
    	<p><b>Final</b></p>
	<div>
	<?php $n=25?>
        	<?=consultaEquipo($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/>

<?=consultaEquipo($n,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>

		 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				25=>array("np"=>27,"lov"=>"local"),
			);
		?>
		
            <?php if ((consultaEquipo($n,$c,$d,'glocal')==consultaEquipo($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipo($n,$c,$d,'local');?>">
                            	<?=consultaEquipo($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipo($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>

	</div>

<!-- Campeon -->
    	<p><b>Campeon</b></p>
	<div>
	<?php $n=27?>
        	<?=consultaEquipo($n,$c,$d,'local');?>
		<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'local');?>.gif" width="20" height="10" />
<!-- Tercer y cuarto puesto -->
    	<p><b>Tercer y cuarto puesto</b></p>
	<div>
	<?php $n=26?>
        	<?=consultaEquipo($n,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'local');?>" name="local<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'glocal');?>" name="L<?=$n?>" id="L<?=$n?>" class="botoneschicos"/>

<?=consultaEquipo($n,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo($n,$c,$d,'visitante');?>" name="visitante<?=$n?>"/> <input type="text" size="1" maxlength="2" value="<?=consultaEquipo($n,$c,$d,'gvisitante');?>" name="V<?=$n?>" id="V<?=$n?>" class="botoneschicos"/>

			 <!--si son iguales un select-->
		
		<?
			//Equivalencia entre numero de partido de octavos y lugar en cuartos
			$p=array(
				26=>array("np"=>27,"lov"=>"visitante"),
			);
		?>
		
            <?php if ((consultaEquipo($n,$c,$d,'glocal')==consultaEquipo($n,$c,$d,'gvisitante')))	{ ?>
				Ganador:
                	<select name="elegir<?=$n?>" class="botoneschicos">
                    		<option value="<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>" selected="selected">
								<?=consultaEquipo($p[$n]['np'],$c,$d,$p[$n]['lov']);?>
                            </option>
                            <option value="<?=consultaEquipo($n,$c,$d,'local');?>">
                            	<?=consultaEquipo($n,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo($n,$c,$d,'visitante');?>">
                            	<?=consultaEquipo($n,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } ?>
	</div>
<!-- Tercero -->
    	<p><b>Tercero</b></p>
	<div>
	<?php $n=27?>
        	<?=consultaEquipo($n,$c,$d,'visitante');?>
		<img src="imagenes/banamerica/<?=consultaEquipo($n,$c,$d,'visitante');?>.gif" width="20" height="10" />
<!-- Goleador-->
    	<p><b>Goleador</b></p>
	<div>
	<?php $n=28?>
        	Jugador:<input name="jugador" id="jugador" type="text" value="<?=consultaEquipo($n,$c,$d,'local');?>" class="botoneschicos"/>
	Seleccion:
	<select name="pais" id="pais" class="botoneschicos">
                    		<option value="<?=consultaEquipo($n,$c,$d,'visitante');?>" selected="selected"><?=consultaEquipo($n,$c,$d,'visitante');?>
                            </option>
                            
                            <?php while ($america2015_equipos_ol=mysql_fetch_assoc($resultado_america2015_equipos_ol)) { ?>
                            	<option value="<?php echo $america2015_equipos_ol['nombre'];?>"><?php echo $america2015_equipos_ol['nombre'];?></option>
							<?php } ?>
                            
                    </select>	

</div>
<?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><input type="submit" class="botones" value=" " style="background-image:url(imagenes/actualizar.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" /><? } ?>
<input type="hidden" name="MM_update" value="fase2" />
</form>
	<!-- Se termina la tabla -->
    <br />
    <div class="tablaclasificacion">
    	<div class="fixture">
   			 <span>&iexcl;IMPORTANTE!</span><span>Asegurate que todos los cambios realizados fueron guardados dandole al boton de actualizar hasta que refleje los resultados. Por ejemplo, si elegiste campeon al primero del grupo A, y despues cambiaste su grupo y ya no es el primero, vas a tener que actualizar 3 veces (para cambiar las semifinales, la final y el campeon)</span><br /><br />
   		 </div>
    </div>
    <br />
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
