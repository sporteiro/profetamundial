<?php require_once('Connections/conexion.php'); ?>
<?php require_once('ingresar.php'); ?>
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

mysql_select_db($database_conexion, $conexion);
$query_todoslosusuarios = "SELECT * FROM usuarios ORDER BY puntos DESC";
$todoslosusuarios = mysql_query($query_todoslosusuarios, $conexion) or die(mysql_error());
$row_todoslosusuarios = mysql_fetch_assoc($todoslosusuarios);
$totalRows_todoslosusuarios = mysql_num_rows($todoslosusuarios);

mysql_select_db($database_conexion, $conexion);
$query_Recordcomentarios = "SELECT * FROM comentarios natural join usuarios ORDER BY id DESC";
$Recordcomentarios = mysql_query($query_Recordcomentarios, $conexion) or die(mysql_error());
$row_Recordcomentarios = mysql_fetch_assoc($Recordcomentarios);
$totalRows_Recordcomentarios = mysql_num_rows($Recordcomentarios);



mysql_select_db($database_conexion, $conexion);
$query_todooscar = "SELECT T.*, U.* FROM Torneos as T join usuarios as U on T.inscriptos=U.usuario WHERE CodTor='19' AND U.usuario!='ProfetaMundial' order by U.puntos DESC";
$todooscar= mysql_query($query_todooscar, $conexion) or die(mysql_error());
$row_todooscar = mysql_fetch_assoc($todooscar);
$totalRows_todooscar= mysql_num_rows($todooscar);

mysql_select_db($database_conexion, $conexion);
$query_hoy_usu= "SELECT * FROM partidos_mundial2022 WHERE CodPar in(select CodPar from partidos_mundial2022 where fecha=curdate()) and CodUsu !='ProfetaMundial' AND  local in (select local from partidos_mundial2022 where fecha=curdate() and CodUsu='ProfetaMundial') AND  visitante in (select visitante from partidos_mundial2022 where fecha=curdate() and CodUsu='ProfetaMundial') ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu ;";
$hoy_usu= mysql_query($query_hoy_usu, $conexion) or die(mysql_error());
$totalRows_hoy_usu= mysql_num_rows($hoy_usu);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Profeta Mundial</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="google-site-verification" content="hRIR39yFxU1aIDYFMDMkbvP_DPomgBSk44_TgwSy4o8" />
<meta name="Description" content="Profeta Mundial. Pronosticos deportivos para aficionados sin animo de lucro, con premios especiales otorgados por la comunidad" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function borrarcookie()	{
	document.getElementById('enc').value=0;
}
</script>
</head>

<body>
<!-- Cabecera -->
<?php if (isset($_COOKIE['pid']) && isset($_COOKIE['pis']))	{
	$pid=$_COOKIE['pid'];
	$pis=$_COOKIE['pis'];
	$enc=1;
}
else	{
	$pid='';
	$pis='';
	$enc=0;	
}
?>
<div class="cabecera">
	<div style="float:left;"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" />
    </div>
	<div class="loginiz">
	<br />
		<form id="formingreso" name="formingreso" method="post" action="<?php echo $loginFormAction; ?>">
			<span id="sprytextfield1">
			<label>
                	Usuario <input name="usuario" type="text" size="13" id="usuario" value="<?=$pid?>" />
  			</label>
  			<span class="textfieldRequiredMsg">Escrib&iacute; tu nombre de usuario</span>
             		</span>
 			<span id="sprytextfield2">
 			<label>
			Contrase&ntilde;a <input name="contrasena" type="password" size="13" id="contrasena" value="<?=$pis?>" onchange="borrarcookie()"/></label>
    			<span class="textfieldRequiredMsg">Escrib&iacute; tu contrase&ntilde;a</span>
            		</span>
			<div class="clear"></div>
			<div><input name="recordar" type="checkbox" />Recordar</div>
			<input name="enviar" type="submit" class="botoneschicos" id="enviar" value="Ingresar" />
			<div class="clear"></div>
  			<input type="hidden" value="<?=$enc?>" name="enc" id="enc"/>
	 <div><a href="contrasena.php">Me olvide la contrase&ntilde;a</a></div>
		</form>
	<div style="clear:both"></div>
	<div>Si todavia no tenes una cuenta <a href="registrarse.php">Registrate</a></div> 
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
	</div>
    <div style="clear:both;"></div>
</div>
<!-- Fin cabecera -->
<br />
<br />
<div id="contenedora" class="contenedora">
<!-- Izquierda -->
<br />
 <div class="tablaIzquierda">
		
         <br />
          
        	
           <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center;">
   		 <p><strong>¡Disponible el pronostico para el Mundial Qatar 2022!</strong></p>
  		<span><a href="noingrese.php" class="botoneschicos" target="_blank">Entr&aacute; para participar</a></span>
  		<p></p>
   		 <br />
         	</div>

          </div>
 	 <br />
         <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center;">
   		 <p><strong>Prob&aacute; nuestra app para mas comodidad</strong></p>
  		<span><a href="profetamundial.apk" class="botoneschicos" target="_blank"><!--Entr&aacute; para participar-->Descargar aplicación para Android</a></span>
  		<p></p>
   		 <br />
         	</div>

          </div>
         

<br />
<?if ($totalRows_hoy_usu>0)	{?>
<p><strong>Pronosticos para los partidos de hoy:</strong></p>
		<div class="comentarios" style="text-align:center;">		
		<?php 
		$con='a';	
		$d=0;
		if ($totalRows_hoy_usu>0) {
		while ($row_usu = mysql_fetch_assoc($hoy_usu)) {
			if ($con!=$row_usu['CodPar'])	{
				if ($d>0) echo "</div>";
				echo "<div style='float:left; padding-left:26px; padding-top:5px;text-align:left;'>";
				echo "<img src='imagenes/banamerica/".$row_usu['local'].".gif'/> ".$row_usu['local'].'-'.$row_usu['visitante']." <img src='imagenes/banamerica/".$row_usu['visitante'].".gif'/><hr />";		
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";
				$con=$row_usu['CodPar'];
				$d=$d+1;
			}
			else	{
				echo "<b>".$row_usu['CodUsu']."</b>: ".$row_usu['glocal']."-".$row_usu['gvisitante']."<br />";				
			}
		 }	
		echo "</div>";	
		}
		?>
		<div style="clear:both;"></div>
		</div>
<? } ?>
</div>
<!-- fin Izquierda -->

<!-- derecha -->
<div class="tablaDerecha">
<strong>Ultimo comentario:</strong><br />
		<br />
		

  <div class="comentarios" style="padding-bottom:5px; padding-top:5px; padding-left: 30px; padding-right: 30px;">
 <span class="letraschicas"><img src="imagenes/avatares/<?php echo $row_Recordcomentarios['avatar'];?>" height="16" width="16" alt=""/> <strong><?php echo $row_Recordcomentarios['usuario']; ?> dijo:</strong></span>
<?php echo $row_Recordcomentarios['comentario']; ?>
</div>
<br />
          <br />
<strong>Participantes Mundial Qatar 2022</strong>
     <?php do { ?>
  <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center; vertical-align:text-bottom;">
   			<img src="imagenes/avatares/<?php echo $row_todooscar['avatar'];?>" height="32" width="32" alt="" class="comentarios_avatar"/> 
			<span class="comentarios_usuario"> <?php echo $row_todooscar['inscriptos']; ?> </span> 
			<div class="puntos">
				<span class="puntos_numero"><?php echo $row_todooscar['puntos']; ?></span><br />
				<span class="puntos_texto">PUNTOS</span>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
         	</div>
  </div>
	  <?php } while ($row_todooscar = mysql_fetch_assoc($todooscar)); ?>
          <br />


</div>
<!-- Fin derecha -->
<div style="clear:both;">
<br />
<br /><br /><br /><br />
		</div>
	</div>
</div> 
<br />
<!-- Final -->
<div id="final" class="final">
	<p>
  	<a href="noingrese.php" class="botoneschicos">Reglas del juego</a>  |
  	<a href="noingrese.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
  	<a href="noingrese.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
  </p>
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />
</div>
<!-- Final -->
</body>
</html>
