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
					//Cuartos de finalistas
					$cuartista1= ganadorPartido(49);
					$cuartista2= ganadorPartido(50);
					$cuartista3= ganadorPartido(51);
					$cuartista4= ganadorPartido(52);
					$cuartista5= ganadorPartido(53);
					$cuartista6= ganadorPartido(54);
					$cuartista7= ganadorPartido(55);
					$cuartista8= ganadorPartido(56);
					
					//Semifinalistas
					$semifinalista1= ganadorPartido(57);
					$semifinalista2= ganadorPartido(58);
					$semifinalista3= ganadorPartido(59);
					$semifinalista4= ganadorPartido(60);		
						
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
						$tercerista1=elegirTercero(61);
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
						$tercerista2=elegirTercero(62);
						}
					
					//Campeon y tercero
					$campeon=ganadorPartido(63);
					$tercero=ganadorPartido(64);
					
					
			function actualizarPartidos($nomEqu, $numPar,$locOvis,$c,$d)		{
				$updateSQL="UPDATE partidos_mundial2022 SET ".$locOvis."='".$nomEqu."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$numPar."'";
				$Result = mysqli_query($c, $updateSQL) or die(mysqli_error($conexion));
			}
			actualizarPartidos($cuartista1,57,'local',$c,$d);
			actualizarPartidos($cuartista2,57,'visitante',$c,$d);
			actualizarPartidos($cuartista3,59,'local',$c,$d);
			actualizarPartidos($cuartista4,59,'visitante',$c,$d);
			actualizarPartidos($cuartista5,58,'local',$c,$d);
			actualizarPartidos($cuartista6,58,'visitante',$c,$d);
			actualizarPartidos($cuartista7,60,'local',$c,$d);
			actualizarPartidos($cuartista8,60,'visitante',$c,$d);
 			
			actualizarPartidos($semifinalista1,61,'local',$c,$d);
			actualizarPartidos($semifinalista2,61,'visitante',$c,$d);
			actualizarPartidos($semifinalista3,62,'local',$c,$d);
			actualizarPartidos($semifinalista4,62,'visitante',$c,$d);
  			
			actualizarPartidos($finalista1,63,'local',$c,$d);
			actualizarPartidos($finalista2,63,'visitante',$c,$d);
		
			actualizarPartidos($tercerista1,64,'local',$c,$d);
			actualizarPartidos($tercerista2,64,'visitante',$c,$d);
			
			actualizarPartidos($campeon,65,'local',$c,$d);
			actualizarPartidos($tercero,65,'visitante',$c,$d);
  				
			actualizarPartidos($_POST['jugador'],66,'local',$c,$d);
			actualizarPartidos($_POST['pais'],66,'visitante',$c,$d);
  	
 /* $updateGoTo = "fase2_mundial2022.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo)); 
*/
}
}
function consultaEquipo($partido,$c,$d,$consulta)	{
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilo.css" rel="stylesheet" type="text/css" />
<script src="jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$("#fase2").submit(function(e) {
		e.preventDefault();
		var $form = $(this),
		url = $form.attr( "action" );
		var n=0;
		console.log('enviando formulario' + n);	
		var posting = $.post( url,$("#fase2").serialize());
		posting.done(function(data) {
			//$('#boton_guardar_B').val('Guardado');
			$('#tabla_fase2').load(" #tabla_fase2  > *");
		});
	});
});
function actualizar_fase2_variasveces()	{
	var i = 8;
	var estados=['Comprobando','Goleador','Tercer puesto','Campeon','Final','Semifinales','Cuartos','Octavos','Resultados'];
		(function k(){
		actualizar_fase2();
		$("#info_mundial").show();
		$("#info_mundial").html('Actualizando <br />'+estados[i]+'<br /> <img src="imagenes/cargando.gif" height="30px"/>');
		if( --i ) {
			setTimeout( k, 1000 );
		}
		if (i<=0) {
			$("#info_mundial").html('Actualizado');
			$("#info_mundial").hide();
		}
	})()
}
function actualizar_fase2()	{
	$("#fase2").submit();

	/*alert('enviando formulario');
	alert('enviando formulario');
	var $form = $("#fase2"),
	url = $form.attr( "action" );
	var posting = $.post( url,$("#fase2").serialize());
		posting.done(function( data ) {
			$('#tabla_fase2').load(" #tabla_fase2  > *");
			$('#tabla_fase2_cel').load(" #tabla_fase2_cel  > *");
		});
		setTimeout(actualizar_fase2_variasveces,5000)*/
	/*var $form = $("#fase2");
	$form.submit(function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		//alert('enviando formulario');
		console.log('enviar formylario');
		var url = "fase2_mundial2022.php";
		$.ajax({
			type: "POST",
			url: url,
			data: $("#fase2").serialize(),
			success: function(data)
			{
			$('#tabla_fase2').load(" #tabla_fase2  > *");
			}
		});
		e.preventDefault();
		e.stopImmediatePropagation();
	});*/
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
     <br /></div><br /> -->  
	<div style="background-color:#10598c;">
    <form name="fase2" id="fase2" method="post" action="#">
    <table class="tabla_fase2" id="tabla_fase2">
    <br />


<!-- Primera fila 1A y 1B-->
    	<tr>
       <td class="fixture"> <img src="imagenes/banamerica/<?=consultaEquipo(49,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(49,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(49,$c,$d,'local');?>" name="local49"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(49,$c,$d,'glocal');?>" name="L49" id="L49" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(51,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(51,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(51,$c,$d,'local');?>" name="local51"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(51,$c,$d,'glocal');?>" name="L51" id="L51" class="botoneschicos"/>
            </td>
        </tr>
        
        <!-- Segunda fila W49 W51 -->
        <tr>
       		<td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(49,$c,$d,'glocal')==consultaEquipo(49,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir49" class="botoneschicos">
                    		<option value="<?=consultaEquipo(57,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(57,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(49,$c,$d,'local');?>">
                            	<?=consultaEquipo(49,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(49,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(49,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(57,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(57,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(57,$c,$d,'local');?>" name="local57"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(57,$c,$d,'glocal');?>" name="L57" id="L57" class="botoneschicos"/>
            </td>    
         	<td></td><td></td><td></td><td></td>
		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(51,$c,$d,'glocal')==consultaEquipo(51,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir51" class="botoneschicos">
                    		<option value="<?=consultaEquipo(59,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(59,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(51,$c,$d,'local');?>">
                            	<?=consultaEquipo(51,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(51,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(51,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(59,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(59,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(59,$c,$d,'local');?>" name="local59"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(59,$c,$d,'glocal');?>" name="L59" id="L59" class="botoneschicos"/>
            </td> 
		<td></td>
        </tr>
        
        
        
        <!--tercera fila 2B 2A-->
        <tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(49,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(49,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(49,$c,$d,'visitante');?>" name="visitante49"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(49,$c,$d,'gvisitante');?>" name="V49" id="V49" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(51,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(51,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(51,$c,$d,'visitante');?>" name="visitante51"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(51,$c,$d,'gvisitante');?>" name="V51" id="V51" class="botoneschicos"/>
            </td>
        </tr>
        
        
        <!-- cuarta fila W57 W59 -->
        <tr>
       		<td></td><td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(57,$c,$d,'glocal')==consultaEquipo(57,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir57" class="botoneschicos">
                    		<option value="<?=consultaEquipo(61,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(61,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(57,$c,$d,'local');?>">
                            	<?=consultaEquipo(57,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(57,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(57,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(61,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(61,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(61,$c,$d,'local');?>" name="local61"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(61,$c,$d,'glocal');?>" name="L61" id="L61" class="botoneschicos"/>
            </td>    
         	<td></td><td></td>

		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(59,$c,$d,'glocal')==consultaEquipo(59,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir59" class="botoneschicos">
                    		<option value="<?=consultaEquipo(62,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(62,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(59,$c,$d,'local');?>">
                            	<?=consultaEquipo(59,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(59,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(59,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(62,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(62,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(62,$c,$d,'local');?>" name="local62"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(62,$c,$d,'glocal');?>" name="L62" id="L62" class="botoneschicos"/>
            </td> <td></td><td></td> 
        </tr>
        <!-- Quinta fila 1C y 1D-->
	<tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(50,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(50,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(50,$c,$d,'local');?>" name="local50"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(50,$c,$d,'glocal');?>" name="L50" id="L50" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(52,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(52,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(52,$c,$d,'local');?>" name="local52"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(52,$c,$d,'glocal');?>" name="L52" id="L52" class="botoneschicos"/>
            </td>
        </tr>

        
        
        <!-- Sexta fila W50 W52 -->
	<tr>
       		<td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(50,$c,$d,'glocal')==consultaEquipo(50,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir50" class="botoneschicos">
                    		<option value="<?=consultaEquipo(57,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(57,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(50,$c,$d,'local');?>">
                            	<?=consultaEquipo(50,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(50,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(50,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(57,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(57,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(57,$c,$d,'visitante');?>" name="visitante57"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(57,$c,$d,'gvisitante');?>" name="V57" id="V57" class="botoneschicos"/>
            </td>    
         	<td></td><td></td><td></td><td></td>
		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(52,$c,$d,'glocal')==consultaEquipo(52,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir52" class="botoneschicos">
                    		<option value="<?=consultaEquipo(59,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(59,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(52,$c,$d,'local');?>">
                            	<?=consultaEquipo(52,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(52,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(52,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(59,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(59,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(59,$c,$d,'visitante');?>" name="visitante59"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(59,$c,$d,'gvisitante');?>" name="V59" id="V59" class="botoneschicos"/>
            </td> <td></td>
        </tr>
         <!-- Septima fila 2D 2C y GUARDAR ojo! --> 
        
                <tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(50,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(50,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(50,$c,$d,'visitante');?>" name="visitante50"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(50,$c,$d,'gvisitante');?>" name="V50" id="V50" class="botoneschicos"/>
            </td>
            <td></td><td></td>
		<td><span> </span></td> 
            <td> <?if	( ($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><button class="botones" onclick="actualizar_fase2_variasveces()">Guardar</button><? } ?><span class="letraschicas"></span></td>	
		<td></td><td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(52,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(52,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(52,$c,$d,'visitante');?>" name="visitante52"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(52,$c,$d,'gvisitante');?>" name="V52" id="V52" class="botoneschicos"/>
            </td>
        </tr>
        
        <!-- Octava Fila FINAL-->
        
        <tr>
        	<td></td><td></td><td></td>
            
            <td class="fixture">
		<!--si son iguales un select-->
            <?php if ((consultaEquipo(61,$c,$d,'glocal')==consultaEquipo(61,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir61" class="botoneschicos">
                    		<option value="<?=consultaEquipo(63,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(63,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(61,$c,$d,'local');?>">
                            	<?=consultaEquipo(61,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(61,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(61,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(63,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(63,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(63,$c,$d,'local');?>" name="local63"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(63,$c,$d,'glocal');?>" name="L63" id="L63" class="botoneschicos"/>
            </td>    
             <td class="fixture">
		<!--si son iguales un select-->
            <?php if ((consultaEquipo(62,$c,$d,'glocal')==consultaEquipo(62,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir62" class="botoneschicos">
                    		<option value="<?=consultaEquipo(63,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(63,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(62,$c,$d,'local');?>">
                            	<?=consultaEquipo(62,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(62,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(62,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(63,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(63,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(63,$c,$d,'visitante');?>" name="visitante63"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(63,$c,$d,'gvisitante');?>" name="V63" id="V63" class="botoneschicos"/>
            </td>
		<td></td><td></td><td></td>
        </tr>
        
        <!-- Novena fila, 1E 1F  y  En esta se incluye al campeon-->
        <tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(53,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(53,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(53,$c,$d,'local');?>" name="local53"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(53,$c,$d,'glocal');?>" name="L53" id="L53" class="botoneschicos"/>
            </td>
            <td></td><td></td>
	    <td colspan="2" class="fixture">Campeon:
		<!--si son iguales un select-->
            <?php if ((consultaEquipo(63,$c,$d,'glocal')==consultaEquipo(63,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir63" class="botoneschicos">
                    		<option value="<?=consultaEquipo(65,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(65,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(63,$c,$d,'local');?>">
                            	<?=consultaEquipo(63,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(63,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(63,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<?=consultaEquipo(65,$c,$d,'local');?>
           <img src="imagenes/banamerica/<?=consultaEquipo(65,$c,$d,'local');?>.gif" width="20" height="10" />
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(65,$c,$d,'local');?>" name="local65"/> 
            </td>  
		<td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(55,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(55,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(55,$c,$d,'local');?>" name="local55"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(55,$c,$d,'glocal');?>" name="L55" id="L55" class="botoneschicos"/>
            </td>
        </tr>

        
        <!-- Decima fila W53 W55-->
          <tr>
       		<td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(53,$c,$d,'glocal')==consultaEquipo(53,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir53" class="botoneschicos">
                    		<option value="<?=consultaEquipo(58,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(58,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(53,$c,$d,'local');?>">
                            	<?=consultaEquipo(53,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(53,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(53,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(58,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(58,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(58,$c,$d,'local');?>" name="local58"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(58,$c,$d,'glocal');?>" name="L58" id="L58" class="botoneschicos"/>
            </td>    
         	<td></td><td></td><td></td><td></td>
		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(55,$c,$d,'glocal')==consultaEquipo(55,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir55" class="botoneschicos">
                    		<option value="<?=consultaEquipo(60,$c,$d,'local');?>" selected="selected">
								<?=consultaEquipo(60,$c,$d,'local');?>
                            </option>
                            <option value="<?=consultaEquipo(55,$c,$d,'local');?>">
                            	<?=consultaEquipo(55,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(55,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(55,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(60,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(60,$c,$d,'local');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(60,$c,$d,'local');?>" name="local60"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(60,$c,$d,'glocal');?>" name="L60" id="L60" class="botoneschicos"/>
            </td><td></td>
        </tr>
        
        <!-- Undecima fila 2F 2E-->
                <tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(53,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(53,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(53,$c,$d,'visitante');?>" name="visitante53"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(53,$c,$d,'gvisitante');?>" name="V53" id="V53" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(55,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(55,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(55,$c,$d,'visitante');?>" name="visitante55"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(55,$c,$d,'gvisitante');?>" name="V55" id="V55" class="botoneschicos"/>
            </td>
        </tr>
        
        
        <!-- Duodecima fila W58 W60-->
         <tr>
       		<td></td><td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(58,$c,$d,'glocal')==consultaEquipo(58,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir58" class="botoneschicos">
                    		<option value="<?=consultaEquipo(61,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(61,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(58,$c,$d,'local');?>">
                            	<?=consultaEquipo(58,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(58,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(58,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(61,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(61,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(61,$c,$d,'visitante');?>" name="visitante61"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(61,$c,$d,'gvisitante');?>" name="V61" id="V61" class="botoneschicos"/>
            </td>    
         	<td></td><td></td>

		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(60,$c,$d,'glocal')==consultaEquipo(60,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir60" class="botoneschicos">
                    		<option value="<?=consultaEquipo(62,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(62,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(60,$c,$d,'local');?>">

                            	<?=consultaEquipo(60,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(60,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(60,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(62,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(62,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(62,$c,$d,'visitante');?>" name="visitante62"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(62,$c,$d,'gvisitante');?>" name="V62" id="V62" class="botoneschicos"/>
            </td> 
		<td></td><td></td>
        </tr>
        
        
        <!-- Decimotercer fila  1G 1H-->
	<tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(54,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(54,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(54,$c,$d,'local');?>" name="local54"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(54,$c,$d,'glocal');?>" name="L54" id="L54" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(56,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(56,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(56,$c,$d,'local');?>" name="local56"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(56,$c,$d,'glocal');?>" name="L56" id="L56" class="botoneschicos"/>
            </td>
        </tr>
        <!-- Decimocuarta linea W54 W56-->
        <tr>
       		<td></td>  
              <td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(54,$c,$d,'glocal')==consultaEquipo(54,$c,$d,'gvisitante')))	{ ?>
                	<select name="elegir54" class="botoneschicos">
                    		<option value="<?=consultaEquipo(58,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(58,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(54,$c,$d,'local');?>">
                            	<?=consultaEquipo(54,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(54,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(54,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(58,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(58,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(58,$c,$d,'visitante');?>" name="visitante58"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(58,$c,$d,'gvisitante');?>" name="V58" id="V58" class="botoneschicos"/>
            </td>    
         	<td></td><td></td><td></td><td></td>
		<td class="fixture">  
            <!--si son iguales un select-->
            <?php if ((consultaEquipo(56,$c,$d,'glocal')==consultaEquipo(56,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir56" class="botoneschicos">
                    		<option value="<?=consultaEquipo(60,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(60,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(56,$c,$d,'local');?>">
                            	<?=consultaEquipo(56,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(56,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(56,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(60,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(60,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(60,$c,$d,'visitante');?>" name="visitante60"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(60,$c,$d,'gvisitante');?>" name="V60" id="V60" class="botoneschicos"/>
            </td> 
		<td></td>
        </tr>
        
        <!-- Decimoquinta fila, 2H 2G  ultima del fixture-->
        
         <tr>
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(54,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(54,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(54,$c,$d,'visitante');?>" name="visitante54"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(54,$c,$d,'gvisitante');?>" name="V54" id="V54" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td><td></td><td></td><td></td>
		<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(56,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(56,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(56,$c,$d,'visitante');?>" name="visitante56"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(56,$c,$d,'gvisitante');?>" name="V56" id="V56" class="botoneschicos"/>
            </td>
        </tr>

        <!-- Decimosexta fila, solo espaciado-->

        <tr style="height:1em;">
        	<td colspan="8"></td>
        </tr>
        <!-- Decimoseptima fila, tercer y cuarto puesto-->
        <tr>
        	<td>3º y 4º </td>            
        	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(64,$c,$d,'local');?>.gif" width="20" height="10" /><?=consultaEquipo(64,$c,$d,'local');?><input type="hidden" value="<?=consultaEquipo(64,$c,$d,'local');?>" name="local64"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(64,$c,$d,'glocal');?>" name="L64" id="L64" class="botoneschicos"/>
            </td>
	<td class="fixture"><img src="imagenes/banamerica/<?=consultaEquipo(64,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(64,$c,$d,'visitante');?><input type="hidden" value="<?=consultaEquipo(64,$c,$d,'visitante');?>" name="visitante64"/> <input type="number" min="0" max="99" size="1" maxlength="2" value="<?=consultaEquipo(64,$c,$d,'gvisitante');?>" name="V64" id="V64" class="botoneschicos"/>
            </td>    
         
            <td class="fixture">Tercero: 
			 <!--si son iguales un select-->
            <?php if ((consultaEquipo(64,$c,$d,'glocal')==consultaEquipo(64,$c,$d,'gvisitante')))	{ ?>

                	<select name="elegir64" class="botoneschicos">
                    		<option value="<?=consultaEquipo(65,$c,$d,'visitante');?>" selected="selected">
								<?=consultaEquipo(65,$c,$d,'visitante');?>
                            </option>
                            <option value="<?=consultaEquipo(64,$c,$d,'local');?>">
                            	<?=consultaEquipo(64,$c,$d,'local');?>
                            </option>
                             <option value="<?=consultaEquipo(64,$c,$d,'visitante');?>">
                            	<?=consultaEquipo(64,$c,$d,'visitante');?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<img src="imagenes/banamerica/<?=consultaEquipo(65,$c,$d,'visitante');?>.gif" width="20" height="10" /><?=consultaEquipo(65,$c,$d,'visitante');?>
           
        	<?php } ?> 
            <input type="hidden" value="<?=consultaEquipo(65,$c,$d,'visitante');?>" name="visitante65"/> 
            </td> <td></td><td></td><td></td><td></td> 
        </tr>
        <!-- Decimoctava fila, goleador-->
        <tr>
        	  <td class="letraschicasfixture">Goleador</td>
              <td class="fixture"> Jugador:<input name="jugador" id="jugador" type="text" value="<?=consultaEquipo(66,$c,$d,'local');?>" class="botoneschicos"/>
              </td>
              <td class="fixture">Seleccion: 
              		<select name="pais" id="pais" class="botoneschicos">
                    		<option value="<?=consultaEquipo(66,$c,$d,'visitante');?>" selected="selected"><?=consultaEquipo(66,$c,$d,'visitante');?>
                            </option>
                            
                            <?php while ($equipos_ol=mysqli_fetch_assoc($resultado_equipos_ol)) { ?>
                            	<option value="<?php echo $equipos_ol['nombre'];?>"><?php echo $equipos_ol['nombre'];?></option>
							<?php } ?>
                            
                    </select>
              
              </td>
              <td></td><td></td><td></td><td></td><td></td>
        </tr> 
	<!-- Se termina la tabla -->
          <input type="hidden" name="MM_update" value="fase2" />
       </form>
    </table>
	<!-- Se termina la tabla -->
    <br />
    <!--<div class="tablaclasificacion">
    	 <div class="fixture">
   			<span>&iexcl;IMPORTANTE!</span><span>Asegurate que todos los cambios realizados fueron guardados dandole al boton de actualizar hasta que refleje los resultados. Por ejemplo, si elegiste campeon al 1\BA del grupo A, y despues cambiaste su grupo y ya no es el primero, vas a tener que actualizar 3 veces (para cambiar las semifinales, la final y el campeon)</span><br /><br />
   		 </div>
    </div>-->
    <br />
</div>
<br />
</div>
</body>
</html>
