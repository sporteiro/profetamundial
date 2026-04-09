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
//ACTUALIZO LOS GOLES
if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "fase2")) {
			for ($n=25;$n<33;$n++) {
				$GL=$_POST['L'.$n.''];
				$GV=$_POST['V'.$n.''];
			
				if ($GL>$GV)  { $resultadoP1=1;}
				if ($GL<$GV)  { $resultadoP1=2;}
				if ($GL==$GV) { $resultadoP1=0;}
  
  $updateSQL = "UPDATE partidos_conf SET glocal='".$GL."', gvisitante='".$GV."', resultado='".$resultadoP1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar='".$n."'";
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
				}
				
//ELIJO QUIEN PASA LA ELIMINATORIA
					$LP25=$_POST['L25'];
					$LP26=$_POST['L26'];
					$LP27=$_POST['L27'];
					$LP28=$_POST['L28'];
					$LP29=$_POST['L29'];
					$LP30=$_POST['L30'];
					$LP31=$_POST['L31'];
					$LP32=$_POST['L32'];
					
					$VP25=$_POST['V25'];
					$VP26=$_POST['V26'];
					$VP27=$_POST['V27'];
					$VP28=$_POST['V28'];
					$VP29=$_POST['V29'];
					$VP30=$_POST['V30'];
					$VP31=$_POST['V31'];
					$VP32=$_POST['V32'];
					//Semifinalistas
					if ($LP25<$VP25) {
						$semifinalista1=$_POST['visitante25'];
						}
					if ($LP25>$VP25){
						$semifinalista1=$_POST['local25'];
						}
					if ($LP25==$VP25){	
						$semifinalista1=$_POST['elegir25'];
					}
					
						
					if ($LP26<$VP26) {
						$semifinalista2=$_POST['visitante26'];
						}
					if ($LP26>$VP26) {
						$semifinalista2=$_POST['local26'];
						}
					if ($LP26==$VP26) {	
						$semifinalista2=$_POST['elegir26'];
					}
					
					
					if ($LP27<$VP27) {
						$semifinalista3=$_POST['visitante27'];
						}
					if ($LP27>$VP27) {
						$semifinalista3=$_POST['local27'];
						}
					if ($LP27==$VP27) {
						$semifinalista3=$_POST['elegir27'];
					}
						
						
						
					if ($LP28<$VP28) {
						$semifinalista4=$_POST['visitante28'];
						}
					if ($LP28>$VP28) {
						$semifinalista4=$_POST['local28'];
						}
					if ($LP28==$VP28) {
						$semifinalista4=$_POST['elegir28'];
						}
						
						
					// FINALISTAS y TERCERISTAS
					if ($LP29<$VP29) {
						$finalista1=$_POST['visitante29'];
						$tercerista1=$_POST['local29'];
						}
					if ($LP29>$VP29) {
						$finalista1=$_POST['local29'];
						$tercerista1=$_POST['visitante29'];
						}
					if ($LP29==$VP29) {
						$finalista1=$_POST['elegir29'];
						$tercerista1=$_POST['elegirterceroA'];
						}
					
					
					if ($LP30<$VP30) {
						$finalista2=$_POST['visitante30'];
						$tercerista2=$_POST['local30'];
						}
					if ($LP30>$VP30)  {
						$finalista2=$_POST['local30'];
						$tercerista2=$_POST['visitante30'];
						}
					if ($LP30==$VP30)  {
						$finalista2=$_POST['elegir30'];
						$tercerista2=$_POST['elegirterceroB'];
						}
					
					
					if ($LP31<$VP31) {
						$campeon=$_POST['visitante31'];
						}
					if ($LP31>$VP31) {
						$campeon=$_POST['local31'];
						}
					if ($LP31==$VP31) {
						$campeon=$_POST['elegir33'];
						}
						
					if ($LP32<$VP32) {
						$tercero=$_POST['visitante32'];
						}
					if ($LP32>$VP32) {
						$tercero=$_POST['local32'];
						}
					if ($LP32==$VP32) {
						$tercero=$_POST['elegir32'];
						}
						
					
						
$updateSQL23 = "UPDATE partidos_conf SET local='".$semifinalista1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=29";
  mysql_select_db($database_conexion, $conexion);
  $Result23 = mysql_query($updateSQL23, $conexion) or die(mysql_error());
 
$updateSQL23v="UPDATE partidos_conf SET visitante='".$semifinalista2."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=29";
  mysql_select_db($database_conexion, $conexion);
  $Result23v = mysql_query($updateSQL23v, $conexion) or die(mysql_error());
  
$updateSQL24 = "UPDATE partidos_conf SET local='".$semifinalista3."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=30";
  mysql_select_db($database_conexion, $conexion);
  $Result24 = mysql_query($updateSQL24, $conexion) or die(mysql_error());
 
$updateSQL24v="UPDATE partidos_conf SET visitante='".$semifinalista4."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=30";
  mysql_select_db($database_conexion, $conexion);
  $Result24v = mysql_query($updateSQL24v, $conexion) or die(mysql_error());
  
 
 $updateSQL25 = "UPDATE partidos_conf SET local='".$finalista1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=31";
  mysql_select_db($database_conexion, $conexion);
  $Result25 = mysql_query($updateSQL25, $conexion) or die(mysql_error());
 
$updateSQL25v="UPDATE partidos_conf SET visitante='".$finalista2."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=31";
  mysql_select_db($database_conexion, $conexion);
  $Result25v = mysql_query($updateSQL25v, $conexion) or die(mysql_error());
  
 $updateSQL26 = "UPDATE partidos_conf SET local='".$tercerista1."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=32";
  mysql_select_db($database_conexion, $conexion);
  $Result26 = mysql_query($updateSQL26, $conexion) or die(mysql_error());
 
$updateSQL26v="UPDATE partidos_conf SET visitante='".$tercerista2."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=32";
  mysql_select_db($database_conexion, $conexion);
  $Result26v = mysql_query($updateSQL26v, $conexion) or die(mysql_error());
  
  
 $updateSQL27 = "UPDATE partidos_conf SET local='".$campeon."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=33";
  mysql_select_db($database_conexion, $conexion);
  $Result27 = mysql_query($updateSQL27, $conexion) or die(mysql_error());
 
$updateSQL27v="UPDATE partidos_conf SET visitante='".$tercero."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=33";
  mysql_select_db($database_conexion, $conexion);
  $Result27v = mysql_query($updateSQL27v, $conexion) or die(mysql_error());
  

$updateSQL28 = "UPDATE partidos_conf SET local='".$_POST['jugador']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=34";
  mysql_select_db($database_conexion, $conexion);
  $Result28 = mysql_query($updateSQL28, $conexion) or die(mysql_error());
 
$updateSQL28v="UPDATE partidos_conf SET visitante='".$_POST['pais']."' WHERE CodUsu='".$_SESSION['MM_Username']."' AND CodPar=34";
  mysql_select_db($database_conexion, $conexion);
  $Result28v = mysql_query($updateSQL28v, $conexion) or die(mysql_error());
  
  	
  $updateGoTo = "fase2_conf.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
mysql_select_db($database_conexion,$conexion);
$consulta_partido19="SELECT * FROM partidos_conf WHERE CodPar=25 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido19=mysql_query($consulta_partido19, $conexion);
$equipos_conf_partido19=mysql_fetch_assoc($resultado_partido19);

mysql_select_db($database_conexion,$conexion);
$consulta_partido20="SELECT * FROM partidos_conf WHERE CodPar=26 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido20=mysql_query($consulta_partido20, $conexion);
$equipos_conf_partido20=mysql_fetch_assoc($resultado_partido20);

mysql_select_db($database_conexion,$conexion);
$consulta_partido21="SELECT * FROM partidos_conf WHERE CodPar=27 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido21=mysql_query($consulta_partido21, $conexion);
$equipos_conf_partido21=mysql_fetch_assoc($resultado_partido21);

mysql_select_db($database_conexion,$conexion);
$consulta_partido22="SELECT * FROM partidos_conf WHERE CodPar=28 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido22=mysql_query($consulta_partido22, $conexion);
$equipos_conf_partido22=mysql_fetch_assoc($resultado_partido22);

mysql_select_db($database_conexion,$conexion);
$consulta_partido23="SELECT * FROM partidos_conf WHERE CodPar=29 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido23=mysql_query($consulta_partido23, $conexion);
$equipos_conf_partido23=mysql_fetch_assoc($resultado_partido23);

mysql_select_db($database_conexion,$conexion);
$consulta_partido24="SELECT * FROM partidos_conf WHERE CodPar=30 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido24=mysql_query($consulta_partido24, $conexion);
$equipos_conf_partido24=mysql_fetch_assoc($resultado_partido24);

mysql_select_db($database_conexion,$conexion);
$consulta_partido25="SELECT * FROM partidos_conf WHERE CodPar=31 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido25=mysql_query($consulta_partido25, $conexion);
$equipos_conf_partido25=mysql_fetch_assoc($resultado_partido25);

mysql_select_db($database_conexion,$conexion);
$consulta_partido26="SELECT * FROM partidos_conf WHERE CodPar=32 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido26=mysql_query($consulta_partido26, $conexion);
$equipos_conf_partido26=mysql_fetch_assoc($resultado_partido26);

mysql_select_db($database_conexion,$conexion);
$consulta_partido27="SELECT * FROM partidos_conf WHERE CodPar=33 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido27=mysql_query($consulta_partido27, $conexion);
$equipos_conf_partido27=mysql_fetch_assoc($resultado_partido27);

mysql_select_db($database_conexion,$conexion);
$consulta_partido28="SELECT * FROM partidos_conf WHERE CodPar=34 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido28=mysql_query($consulta_partido28, $conexion);
$equipos_conf_partido28=mysql_fetch_assoc($resultado_partido28);

mysql_select_db($database_conexion,$conexion);
$consulta_equipos_conf="SELECT distinct(nombre) FROM equipos_conf WHERE CodEqu BETWEEN 1 AND 8";
$resultado_equipos_conf=mysql_query($consulta_equipos_conf, $conexion);
?>
<html>
<head>
<link href="estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>  

<div style="background-color:#063; background-image:url(imagenes/trans.png);">
	<div class="tablaresultados">
<?  if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?>
    <span class="letrasgrandesnaranjas">¡IMPORTANTE!</span> Dale a esta flecha cada vez que hagas cambios en los grupos<br />
     <input type="button" value=" " class="botones" onClick="location.reload();" style=" background-image:url(imagenes/flechabajo.png); background-position:center; background-repeat:no-repeat; cursor:pointer;"/> <? } ?>
     <br /></div><br />   
	<div class="tablaresultados">

    <table>
    <br />

    <form name="fase2" method="post" action="<?php echo $editFormAction; ?>">

    	<tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido19['local'];?><input type="hidden" value="<?php echo $equipos_conf_partido19['local'];?>" name="local25"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido19['glocal'];?>" name="L<?php echo $equipos_conf_partido19['CodPar'];?>" id="L<?php echo $equipos_conf_partido19['CodPar'];?>" class="botoneschicos"/>
            </td>-->
            	<td>
            </td><td></td><td></td>
        </tr>
        
        
        <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($equipos_conf_partido19['glocal'])==($equipos_conf_partido19['gvisitante']))	{ ?>
                	<select name="elegir25" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido23['local'];?>" selected="selected">
								<?php echo $equipos_conf_partido23['local'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido19['local'];?>">
                            	<?php echo $equipos_conf_partido19['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido19['visitante'];?>">
                            	<?php echo $equipos_conf_partido19['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<?php echo $equipos_conf_partido23['local'];?>
           
        	<?php } ?> 
            <input type="hidden" value="<?php echo $equipos_conf_partido23['local'];?>" name="local29"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido23['glocal'];?>" name="L<?php echo $equipos_conf_partido23['CodPar'];?>" id="L<?php echo $equipos_conf_partido23['CodPar'];?>" class="botoneschicos"/>
            </td>    
         	<td></td><td></td>
        </tr>
        
        
        
        
        <tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido19['visitante'];?><input type="hidden" value="<?php echo $equipos_conf_partido19['visitante'];?>" name="visitante25"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido19['gvisitante'];?>" name="V<?php echo $equipos_conf_partido19['CodPar'];?>" id="V<?php echo $equipos_conf_partido19['CodPar'];?>" class="botoneschicos"/>
            </td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
        
         <tr>
        	<td></td><td></td><td class="comentarios">
          <?php if (($equipos_conf_partido23['glocal'])==($equipos_conf_partido23['gvisitante']))	{ ?>
                	<select name="elegir29" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido25['local'];?>" selected="selected">
								<?php echo $equipos_conf_partido25['local'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido23['local'];?>">
                            	<?php echo $equipos_conf_partido23['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido23['visitante'];?>">
                            	<?php echo $equipos_conf_partido23['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
 					<?php echo $equipos_conf_partido25['local'];?>
            <?php } ?>
                    <input type="hidden" value="<?php echo $equipos_conf_partido25['local'];?>" name="local31"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido25['glocal'];?>" name="L<?php echo $equipos_conf_partido25['CodPar'];?>" id="L<?php echo $equipos_conf_partido25['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
        </tr>
        
        
        
        
        
        
        <tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido20['local'];?><input type="hidden" value="<?php echo $equipos_conf_partido20['local'];?>" name="local26"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido20['glocal'];?>" name="L<?php echo $equipos_conf_partido20['CodPar'];?>" id="L<?php echo $equipos_conf_partido20['CodPar'];?>" class="botoneschicos"/>
            </td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
        
            <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($equipos_conf_partido20['glocal'])==($equipos_conf_partido20['gvisitante']))	{ ?>
                	<select name="elegir26" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido23['visitante'];?>" selected="selected">
								<?php echo $equipos_conf_partido23['visitante'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido20['local'];?>">
                            	<?php echo $equipos_conf_partido20['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido20['visitante'];?>">
                            	<?php echo $equipos_conf_partido20['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
        
			<?php echo $equipos_conf_partido23['visitante'];?>
            
            <?php } ?>
            <input type="hidden" value="<?php echo $equipos_conf_partido23['visitante'];?>" name="visitante29"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido23['gvisitante'];?>" name="V<?php echo $equipos_conf_partido23['CodPar'];?>" id="V<?php echo $equipos_conf_partido23['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
            <td></td>
        </tr>
        
        
        <tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido20['visitante'];?><input type="hidden" value="<?php echo $equipos_conf_partido20['visitante'];?>" name="visitante26"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido20['gvisitante'];?>" name="V<?php echo $equipos_conf_partido20['CodPar'];?>" id="V<?php echo $equipos_conf_partido20['CodPar'];?>" class="botoneschicos"/>
            </td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
        
        <tr>
        	<td></td>
            <td><span class="letrasgrandesnaranjas"><!--Actualizar los resultados --></span></td> 
            <td> <?  if	(($fueraTiempo==0) or ($_SESSION['MM_Username']=='ProfetaMundial'))	{ ?><input type="submit" class="botones" value=" " style="background-image:url(imagenes/actualizar.png); background-repeat:no-repeat; background-position:center; cursor:pointer;" /><? } ?><span class="letraschicas"></span></td>
            <td class="comentarios">¡
            <?php if (($equipos_conf_partido25['glocal'])==($equipos_conf_partido25['gvisitante']))	{ ?>
                	<select name="elegir33" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido27['local'];?>" selected="selected">
								<?php echo $equipos_conf_partido27['local'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido25['local'];?>">
                            	<?php echo $equipos_conf_partido25['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido25['visitante'];?>">
                            	<?php echo $equipos_conf_partido25['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
            	<img src="imagenes/banamerica/<?php echo $equipos_conf_partido27['local']; ?>.gif" width="20" height="10"/> <?php echo $equipos_conf_partido27['local'];?> 
            <?php } ?>
            Campeon!
            </td>
        </tr>
        
        
        
        <tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido21['local'];?><input type="hidden" value="<?php echo $equipos_conf_partido21['local'];?>" name="local27"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido21['glocal'];?>" name="L<?php echo $equipos_conf_partido21['CodPar'];?>" id="L<?php echo $equipos_conf_partido21['CodPar'];?>" class="botoneschicos"/></td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
          <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($equipos_conf_partido21['glocal'])==($equipos_conf_partido21['gvisitante']))	{ ?>
                	<select name="elegir27" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido24['local'];?>" selected="selected">
								<?php echo $equipos_conf_partido24['local'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido21['local'];?>">
                            	<?php echo $equipos_conf_partido21['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido21['visitante'];?>">
                            	<?php echo $equipos_conf_partido21['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
					<?php echo $equipos_conf_partido24['local'];?>
            <?php } ?>        	
            <input type="hidden" value="<?php echo $equipos_conf_partido24['local'];?>" name="local30"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido24['glocal'];?>" name="L<?php echo $equipos_conf_partido24['CodPar'];?>" id="L<?php echo $equipos_conf_partido24['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td>
        </tr>
        
        
        
        
        
        <tr>
        	<!--<td class="comentarios"><?php echo $equipos_conf_partido21['visitante'];?><input type="hidden" value="<?php echo $equipos_conf_partido21['visitante'];?>" name="visitante27"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido21['gvisitante'];?>" name="V<?php echo $equipos_conf_partido21['CodPar'];?>" id="V<?php echo $equipos_conf_partido21['CodPar'];?>" class="botoneschicos"/></td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
        
        
        
        
        <tr>
        	<td></td><td></td><td class="comentarios">
			  <?php if (($equipos_conf_partido24['glocal'])==($equipos_conf_partido24['gvisitante']))	{ ?>
                	<select name="elegir30" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido25['visitante'];?>" selected="selected">
								<?php echo $equipos_conf_partido25['visitante'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido24['local'];?>">
                            	<?php echo $equipos_conf_partido24['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido24['visitante'];?>">
                            	<?php echo $equipos_conf_partido24['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
					<?php echo $equipos_conf_partido25['visitante'];?>
             <?php } ?>
             
         <input type="hidden" value="<?php echo $equipos_conf_partido25['visitante'];?>" name="visitante31"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido25['gvisitante'];?>" name="V<?php echo $equipos_conf_partido25['CodPar'];?>" id="V<?php echo $equipos_conf_partido25['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
        </tr>
        
        <tr>
         	<!--<td class="comentarios"><?php echo $equipos_conf_partido22['local'];?><input type="hidden" value="<?php echo $equipos_conf_partido22['local'];?>" name="local28"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido22['glocal'];?>" name="L<?php echo $equipos_conf_partido22['CodPar'];?>" id="L<?php echo $equipos_conf_partido22['CodPar'];?>" class="botoneschicos"/></td>-->
            <td></td><td></td><td></td>
        </tr>
        
        
        
             <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($equipos_conf_partido22['glocal'])==($equipos_conf_partido22['gvisitante']))	{ ?>
                	<select name="elegir28" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido24['visitante'];?>" selected="selected">
								<?php echo $equipos_conf_partido24['visitante'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido22['local'];?>">
                            	<?php echo $equipos_conf_partido22['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido22['visitante'];?>">
                            	<?php echo $equipos_conf_partido22['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
        			<?php echo $equipos_conf_partido24['visitante'];?>
            <?php } ?>
                    <input type="hidden" value="<?php echo $equipos_conf_partido24['visitante'];?>" name="visitante30"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido24['gvisitante'];?>" name="V<?php echo $equipos_conf_partido24['CodPar'];?>" id="V<?php echo $equipos_conf_partido24['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td>
        </tr>
        
        
        
        
        
        
        
        
        <tr>
        <!--	<td class="comentarios"><?php echo $equipos_conf_partido22['visitante'];?><input type="hidden" value="<?php echo $equipos_conf_partido22['visitante'];?>" name="visitante28"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido22['gvisitante'];?>" name="V<?php echo $equipos_conf_partido22['CodPar'];?>" id="V<?php echo $equipos_conf_partido22['CodPar'];?>" class="botoneschicos"/>
            </td>-->
            <td></td><td></td><td></td>
        </tr>
        
        <tr style="height:30px;">
        	<td></td><td></td><td></td><td></td>
        </tr>
        
        
        <tr>
        	<td class="letraschicascomentarios">Tercer y cuarto puesto </td>            
            <td class="comentarios">
                <?php if (($equipos_conf_partido23['glocal'])==($equipos_conf_partido23['gvisitante']))	{ ?>
                	<select name="elegirterceroA" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido26['local'];?>" selected="selected">
								<?php echo $equipos_conf_partido26['local'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido23['local'];?>">
                            	<?php echo $equipos_conf_partido23['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido23['visitante'];?>">
                            	<?php echo $equipos_conf_partido23['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
            		<?php echo $equipos_conf_partido26['local'];?>
            <?php } ?>
            
            <input type="hidden" value="<?php echo $equipos_conf_partido26['local'];?>" name="local32"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido26['glocal'];?>" name="L<?php echo $equipos_conf_partido26['CodPar'];?>" id="L<?php echo $equipos_conf_partido26['CodPar'];?>" class="botoneschicos"/></td>
            
            
            <td class="comentarios">
			   <?php if (($equipos_conf_partido24['glocal'])==($equipos_conf_partido24['gvisitante']))	{ ?>
                	<select name="elegirterceroB" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido26['visitante'];?>" selected="selected">
								<?php echo $equipos_conf_partido26['visitante'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido24['local'];?>">
                            	<?php echo $equipos_conf_partido24['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido24['visitante'];?>">
                            	<?php echo $equipos_conf_partido24['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
			<?php echo $equipos_conf_partido26['visitante'];?>
            <?php } ?>
            
            <input type="hidden" value="<?php echo $equipos_conf_partido26['visitante'];?>" name="visitante32"/> <input type="text" size="1" maxlength="2" value="<?php echo $equipos_conf_partido26['gvisitante'];?>" name="V<?php echo $equipos_conf_partido26['CodPar'];?>" id="V<?php echo $equipos_conf_partido26['CodPar'];?>" class="botoneschicos"/></td>
         
            <td class="comentarios">Tercero: 
			 <?php if (($equipos_conf_partido26['glocal'])==($equipos_conf_partido26['gvisitante']))	{ ?>
                	<select name="elegir32" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido27['visitante'];?>" selected="selected">
								<?php echo $equipos_conf_partido27['visitante'];?>
                            </option>
                            <option value="<?php echo $equipos_conf_partido26['local'];?>">
                            	<?php echo $equipos_conf_partido26['local'];?>
                            </option>
                             <option value="<?php echo $equipos_conf_partido26['visitante'];?>">
                            	<?php echo $equipos_conf_partido26['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
			
			<?php echo $equipos_conf_partido27['visitante'];?></td>
            
            <?php } ?>
        </tr>
        
        <tr>
        	  <td class="letraschicascomentarios">Goleador</td>
              <td class="comentarios"> Jugador:<input name="jugador" id="jugador" type="text" value="<?php echo $equipos_conf_partido28['local'];?>" class="botoneschicos"/>
              </td>
              <td class="comentarios">Seleccion: 
              		<select name="pais" id="pais" class="botoneschicos">
                    		<option value="<?php echo $equipos_conf_partido28['visitante'];?>" selected="selected"><?php echo $equipos_conf_partido28['visitante'];?>
                            </option>
                            
                            <?php while ($equipos_conf_equipos_conf=mysql_fetch_assoc($resultado_equipos_conf)) { ?>
                            	<option value="<?php echo $equipos_conf_equipos_conf['nombre'];?>"><?php echo $equipos_conf_equipos_conf['nombre'];?></option>
							<?php } ?>
                            
                    </select>
              
              </td>
              <td></td>
        </tr> 
          <input type="hidden" name="MM_update" value="fase2" />
         
       </form>
    </table>
    <br />
    <div class="tablaclasificacion">
    	<div class="comentarios">
   			 <span class="letrasgrandesnaranjas">¡IMPORTANTE!</span><span class="letraschicas">Asegurate que todos los cambios realizados fueron guardados dandole al boton de actualizar hasta que refleje los resultados.
             Por ejemplo, si elegiste campeon al 1º del grupo A, y despues cambiaste su grupo y ya no es el primero, 
             vas a tener que actualizar 3 veces (para cambiar las semifinales, la final y el campeon)</span><br /><br />
   		 </div>
    </div>
    <br />
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
