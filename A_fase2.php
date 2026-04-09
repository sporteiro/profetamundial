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


mysql_select_db($database_conexion,$conexion);
$consulta_partido19="SELECT * FROM america_partidos WHERE CodPar=19 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido19=mysql_query($consulta_partido19, $conexion);
$america_equipos_partido19=mysql_fetch_assoc($resultado_partido19);

mysql_select_db($database_conexion,$conexion);
$consulta_partido20="SELECT * FROM america_partidos WHERE CodPar=20 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido20=mysql_query($consulta_partido20, $conexion);
$america_equipos_partido20=mysql_fetch_assoc($resultado_partido20);

mysql_select_db($database_conexion,$conexion);
$consulta_partido21="SELECT * FROM america_partidos WHERE CodPar=21 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido21=mysql_query($consulta_partido21, $conexion);
$america_equipos_partido21=mysql_fetch_assoc($resultado_partido21);

mysql_select_db($database_conexion,$conexion);
$consulta_partido22="SELECT * FROM america_partidos WHERE CodPar=22 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido22=mysql_query($consulta_partido22, $conexion);
$america_equipos_partido22=mysql_fetch_assoc($resultado_partido22);

mysql_select_db($database_conexion,$conexion);
$consulta_partido23="SELECT * FROM america_partidos WHERE CodPar=23 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido23=mysql_query($consulta_partido23, $conexion);
$america_equipos_partido23=mysql_fetch_assoc($resultado_partido23);

mysql_select_db($database_conexion,$conexion);
$consulta_partido24="SELECT * FROM america_partidos WHERE CodPar=24 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido24=mysql_query($consulta_partido24, $conexion);
$america_equipos_partido24=mysql_fetch_assoc($resultado_partido24);

mysql_select_db($database_conexion,$conexion);
$consulta_partido25="SELECT * FROM america_partidos WHERE CodPar=25 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido25=mysql_query($consulta_partido25, $conexion);
$america_equipos_partido25=mysql_fetch_assoc($resultado_partido25);

mysql_select_db($database_conexion,$conexion);
$consulta_partido26="SELECT * FROM america_partidos WHERE CodPar=26 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido26=mysql_query($consulta_partido26, $conexion);
$america_equipos_partido26=mysql_fetch_assoc($resultado_partido26);

mysql_select_db($database_conexion,$conexion);
$consulta_partido27="SELECT * FROM america_partidos WHERE CodPar=27 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido27=mysql_query($consulta_partido27, $conexion);
$america_equipos_partido27=mysql_fetch_assoc($resultado_partido27);

mysql_select_db($database_conexion,$conexion);
$consulta_partido28="SELECT * FROM america_partidos WHERE CodPar=28 AND CodUsu='".$_SESSION['MM_Username']."'";
$resultado_partido28=mysql_query($consulta_partido28, $conexion);
$america_equipos_partido28=mysql_fetch_assoc($resultado_partido28);

mysql_select_db($database_conexion,$conexion);
$consulta_america_equipos="SELECT nombre FROM america_equipos";
$resultado_america_equipos=mysql_query($consulta_america_equipos, $conexion);
?>
<html>
<head>
<link href="estilo.css" rel="stylesheet" type="text/css" />
</head>
<body>  
<div style="background-color:#063; background-image:url(imagenes/trans.png);">
	<br />
	<div class="tablaresultados">
    
    <table>
    <br />
    <form name="fase2" method="post" action="<?php echo $editFormAction; ?>">
    	<tr>
        	<td class="comentarios"><?php echo $america_equipos_partido19['local'];?><input type="hidden" value="<?php echo $america_equipos_partido19['local'];?>" name="local19"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido19['glocal'];?>" name="L<?php echo $america_equipos_partido19['CodPar'];?>" id="L<?php echo $america_equipos_partido19['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td>
            </td><td></td><td></td>
        </tr>
        
        
        <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($america_equipos_partido19['glocal'])==($america_equipos_partido19['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir19" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido23['local'];?>" selected="selected">
								<?php echo $america_equipos_partido23['local'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido19['local'];?>">
                            	<?php echo $america_equipos_partido19['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido19['visitante'];?>">
                            	<?php echo $america_equipos_partido19['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
                     
          	<?php echo $america_equipos_partido23['local'];?>
           
        	<?php } ?> 
            <input type="hidden" value="<?php echo $america_equipos_partido23['local'];?>" name="local23"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido23['glocal'];?>" name="L<?php echo $america_equipos_partido23['CodPar'];?>" id="L<?php echo $america_equipos_partido23['CodPar'];?>" class="botoneschicos"/>
            </td>    
         	<td></td><td></td>
        </tr>
        
        
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido19['visitante'];?><input type="hidden" value="<?php echo $america_equipos_partido19['visitante'];?>" name="visitante19"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido19['gvisitante'];?>" name="V<?php echo $america_equipos_partido19['CodPar'];?>" id="V<?php echo $america_equipos_partido19['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td>
        </tr>
        
        
        
         <tr>
        	<td></td><td></td><td class="comentarios">
          <?php if (($america_equipos_partido23['glocal'])==($america_equipos_partido23['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir23" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido25['local'];?>" selected="selected">
								<?php echo $america_equipos_partido25['local'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido23['local'];?>">
                            	<?php echo $america_equipos_partido23['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido23['visitante'];?>">
                            	<?php echo $america_equipos_partido23['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
 					<?php echo $america_equipos_partido25['local'];?>
            <?php } ?>
                    <input type="hidden" value="<?php echo $america_equipos_partido25['local'];?>" name="local25"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido25['glocal'];?>" name="L<?php echo $america_equipos_partido25['CodPar'];?>" id="L<?php echo $america_equipos_partido25['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
        </tr>
        
        
        
        
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido20['local'];?><input type="hidden" value="<?php echo $america_equipos_partido20['local'];?>" name="local20"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido20['glocal'];?>" name="L<?php echo $america_equipos_partido20['CodPar'];?>" id="L<?php echo $america_equipos_partido20['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td>
        </tr>
        
        
        
            <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($america_equipos_partido20['glocal'])==($america_equipos_partido20['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir20" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido23['visitante'];?>" selected="selected">
								<?php echo $america_equipos_partido23['visitante'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido20['local'];?>">
                            	<?php echo $america_equipos_partido20['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido20['visitante'];?>">
                            	<?php echo $america_equipos_partido20['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
        
			<?php echo $america_equipos_partido23['visitante'];?>
            
            <?php } ?>
            <input type="hidden" value="<?php echo $america_equipos_partido23['visitante'];?>" name="visitante23"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido23['gvisitante'];?>" name="V<?php echo $america_equipos_partido23['CodPar'];?>" id="V<?php echo $america_equipos_partido23['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
            <td></td>
        </tr>
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido20['visitante'];?><input type="hidden" value="<?php echo $america_equipos_partido20['visitante'];?>" name="visitante20"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido20['gvisitante'];?>" name="V<?php echo $america_equipos_partido20['CodPar'];?>" id="V<?php echo $america_equipos_partido20['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td>
        </tr>
        
        
        
        <tr>
        	<td></td>
            <td>|||||||||||||</td>
            <td>|||||||||||||</td>
            <td class="comentarios">¡
            <?php if (($america_equipos_partido25['glocal'])==($america_equipos_partido25['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir27" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido27['local'];?>" selected="selected">
								<?php echo $america_equipos_partido27['local'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido25['local'];?>">
                            	<?php echo $america_equipos_partido25['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido25['visitante'];?>">
                            	<?php echo $america_equipos_partido25['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
            	<img src="imagenes/banamerica/<?php echo $america_equipos_partido27['local']; ?>.gif" width="20" height="10"/> <?php echo $america_equipos_partido27['local'];?> 
            <?php } ?>
            Campeon!
            </td>
        </tr>
        
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido21['local'];?><input type="hidden" value="<?php echo $america_equipos_partido21['local'];?>" name="local21"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido21['glocal'];?>" name="L<?php echo $america_equipos_partido21['CodPar'];?>" id="L<?php echo $america_equipos_partido21['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td><td></td>
        </tr>
        
        
          <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($america_equipos_partido21['glocal'])==($america_equipos_partido21['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir21" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido24['local'];?>" selected="selected">
								<?php echo $america_equipos_partido24['local'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido21['local'];?>">
                            	<?php echo $america_equipos_partido21['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido21['visitante'];?>">
                            	<?php echo $america_equipos_partido21['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
					<?php echo $america_equipos_partido24['local'];?>
            <?php } ?>        	
            <input type="hidden" value="<?php echo $america_equipos_partido24['local'];?>" name="local24"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido24['glocal'];?>" name="L<?php echo $america_equipos_partido24['CodPar'];?>" id="L<?php echo $america_equipos_partido24['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td>
        </tr>
        
        
        
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido21['visitante'];?><input type="hidden" value="<?php echo $america_equipos_partido21['visitante'];?>" name="visitante21"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido21['gvisitante'];?>" name="V<?php echo $america_equipos_partido21['CodPar'];?>" id="V<?php echo $america_equipos_partido21['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td><td></td>
        </tr>
        
        
        
        
        
        
        <tr>
        	<td></td><td></td><td class="comentarios">
			  <?php if (($america_equipos_partido24['glocal'])==($america_equipos_partido24['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir24" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido25['visitante'];?>" selected="selected">
								<?php echo $america_equipos_partido25['visitante'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido24['local'];?>">
                            	<?php echo $america_equipos_partido24['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido24['visitante'];?>">
                            	<?php echo $america_equipos_partido24['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
					<?php echo $america_equipos_partido25['visitante'];?>
             <?php } ?>
             
         <input type="hidden" value="<?php echo $america_equipos_partido25['visitante'];?>" name="visitante25"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido25['gvisitante'];?>" name="V<?php echo $america_equipos_partido25['CodPar'];?>" id="V<?php echo $america_equipos_partido25['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td>
        </tr>
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido22['local'];?><input type="hidden" value="<?php echo $america_equipos_partido22['local'];?>" name="local22"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido22['glocal'];?>" name="L<?php echo $america_equipos_partido22['CodPar'];?>" id="L<?php echo $america_equipos_partido22['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td><td></td>
        </tr>
        
        
        
             <tr>
       		<td></td>  
              <td class="comentarios">  
            <!--si son iguales un select-->
            <?php if (($america_equipos_partido22['glocal'])==($america_equipos_partido22['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir22" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido24['visitante'];?>" selected="selected">
								<?php echo $america_equipos_partido24['visitante'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido22['local'];?>">
                            	<?php echo $america_equipos_partido22['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido22['visitante'];?>">
                            	<?php echo $america_equipos_partido22['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
        			<?php echo $america_equipos_partido24['visitante'];?>
            <?php } ?>
                    <input type="hidden" value="<?php echo $america_equipos_partido24['visitante'];?>" name="visitante24"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido24['gvisitante'];?>" name="V<?php echo $america_equipos_partido24['CodPar'];?>" id="V<?php echo $america_equipos_partido24['CodPar'];?>" class="botoneschicos"/></td>
            <td></td><td></td>
        </tr>
        
        
        
        
        
        
        
        
        <tr>
        	<td class="comentarios"><?php echo $america_equipos_partido22['visitante'];?><input type="hidden" value="<?php echo $america_equipos_partido22['visitante'];?>" name="visitante22"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido22['gvisitante'];?>" name="V<?php echo $america_equipos_partido22['CodPar'];?>" id="V<?php echo $america_equipos_partido22['CodPar'];?>" class="botoneschicos"/>
            </td>
            <td></td><td></td><td></td>
        </tr>
        
        <tr style="height:30px;">
        	<td></td><td></td><td></td><td></td>
        </tr>
        
        
        <tr>
        	<td class="letraschicascomentarios">Tercer y cuarto puesto </td>            
            <td class="comentarios">
                <?php if (($america_equipos_partido23['glocal'])==($america_equipos_partido23['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegirterceroA" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido26['local'];?>" selected="selected">
								<?php echo $america_equipos_partido26['local'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido23['local'];?>">
                            	<?php echo $america_equipos_partido23['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido23['visitante'];?>">
                            	<?php echo $america_equipos_partido23['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
            		<?php echo $america_equipos_partido26['local'];?>
            <?php } ?>
            
            <input type="hidden" value="<?php echo $america_equipos_partido26['local'];?>" name="local26"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido26['glocal'];?>" name="L<?php echo $america_equipos_partido26['CodPar'];?>" id="L<?php echo $america_equipos_partido26['CodPar'];?>" class="botoneschicos"/></td>
            
            
            <td class="comentarios">
			   <?php if (($america_equipos_partido24['glocal'])==($america_equipos_partido24['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegirterceroB" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido26['visitante'];?>" selected="selected">
								<?php echo $america_equipos_partido26['visitante'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido24['local'];?>">
                            	<?php echo $america_equipos_partido24['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido24['visitante'];?>">
                            	<?php echo $america_equipos_partido24['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
			<?php echo $america_equipos_partido26['visitante'];?>
            <?php } ?>
            
            <input type="hidden" value="<?php echo $america_equipos_partido26['visitante'];?>" name="visitante26"/> <input type="text" readonly="readonly" size="1" maxlength="2" value="<?php echo $america_equipos_partido26['gvisitante'];?>" name="V<?php echo $america_equipos_partido26['CodPar'];?>" id="V<?php echo $america_equipos_partido26['CodPar'];?>" class="botoneschicos"/></td>
         
            <td class="comentarios">Tercero: 
			 <?php if (($america_equipos_partido26['glocal'])==($america_equipos_partido26['gvisitante']))	{ ?>
                	<select readonly="readonly" name="elegir26" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido27['visitante'];?>" selected="selected">
								<?php echo $america_equipos_partido27['visitante'];?>
                            </option>
                            <option value="<?php echo $america_equipos_partido26['local'];?>">
                            	<?php echo $america_equipos_partido26['local'];?>
                            </option>
                             <option value="<?php echo $america_equipos_partido26['visitante'];?>">
                            	<?php echo $america_equipos_partido26['visitante'];?>	
                            </option>
                    </select>
                
			<?php } else {  ?>
			
			<?php echo $america_equipos_partido27['visitante'];?></td>
            
            <?php } ?>
        </tr>
        
        <tr>
        	  <td class="letraschicascomentarios">Goleador</td>
              <td class="comentarios"> Jugador:<input name="jugador" id="jugador" type="text" value="<?php echo $america_equipos_partido28['local'];?>" class="botoneschicos"/>
              </td>
              <td class="comentarios">Seleccion: 
              		<select readonly="readonly" name="pais" id="pais" class="botoneschicos">
                    		<option value="<?php echo $america_equipos_partido28['visitante'];?>" selected="selected"><?php echo $america_equipos_partido28['visitante'];?>
                            </option>
                            
                            <?php while ($america_equipos_america_equipos=mysql_fetch_assoc($resultado_america_equipos)) { ?>
                            	<option value="<?php echo $america_equipos_america_equipos['nombre'];?>"><?php echo $america_equipos_america_equipos['nombre'];?></option>
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
   			<p><br /></p><p><br /></p>	<p><br /></p><p><br /></p>	<p></p><p></p>	<p></p><p></p><br /><br />
   		 </div>
    </div>
    <br />
</div>
<br /><br /><br /><br /><br /><br /><br /><br />
</div>
</body>
</html>
