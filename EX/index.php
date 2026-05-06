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
$query_todoamerica = "SELECT T.*, U.* FROM Torneos as T join usuarios as U on T.inscriptos=U.usuario WHERE CodTor='4' AND U.usuario!='ProfetaMundial' order by U.puntos DESC";
$todoamerica = mysql_query($query_todoamerica, $conexion) or die(mysql_error());
$row_todoamerica = mysql_fetch_assoc($todoamerica);
$totalRows_todoamerica= mysql_num_rows($todoamerica);

mysql_select_db($database_conexion, $conexion);
$query_hoy_usu= "SELECT * FROM partidos WHERE CodPar in(select CodPar from partidos where fecha=curdate()) and CodUsu !='ProfetaMundial' ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu ;";
$hoy_usu= mysql_query($query_hoy_usu, $conexion) or die(mysql_error());
$totalRows_hoy_usu= mysql_num_rows($hoy_usu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Profeta Mundial</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<meta name="google-site-verification" content="85oXqojpQN-8tJcfZpxuUtssRmHYa11bcj-JvPyQfqM" />
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
	<div style="width: 300px; float:left;"><img src="imagenes/profetamundial.png" width="171" height="57" alt="Profeta Mundial" />
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
			Contrase&ntilde;a <input name="contrasena" type="password" size="13" id="contrasena" value="<?=$pis?>" onchange="borrarcookie()"/>
    			<span class="textfieldRequiredMsg">Escrib&iacute; tu contrase&ntilde;a</span>
            		</span>
			<input name="enviar" type="submit" class="botoneschicos" id="enviar" value="Ingres�" />
			</label>
  			<input type="hidden" value="<?=$enc?>" name="enc" id="enc"/>
	<p style="text-align:right;"><input name="recordar" type="checkbox" />Recordar</p>
		</form>
	<p style="text-align:right;">Si todavia no tenes una cuenta <a href="registrarse.php">Registr�te</a>. <a href="contrasena.php">Me olvide la contrase&ntilde;a</a>
	</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
	</div>
    <br />
    <div style="clear:both;"></div>
</div>
<!-- Fin cabecera -->
<br />
<br />
<div id="contenedora" class="contenedora">
<!-- Izquierda -->
<br />
 <div class="tablaclasificacion" style="width:410px; float:left; margin-left:20px; text-align:center; ">
		
         <br />
          
        	
         
         <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center;">
   		 <p><strong>�Pronostique la Eurocopa 2012 de Polonia y Ucrania!</strong></p>
  		<span><a href="noingrese.php" class="botoneschicos" target="_blank">Plazo finalizado</a></span>
  		<p></p>
   		 <br />
         	</div>
          </div>
          <br />
<br />
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
</div>

<!-- fin Izquierda -->

<!-- derecha -->
<div class="tablaclasificacion" style="width:410px; float: right; margin-right :20px; text-align:center; ">
<strong>Ultimo comentario:</strong><br />
		<br />
		

  <div class="comentarios" style="padding-bottom:5px; padding-top:5px; padding-left: 30px; padding-right: 30px;">
 <span class="letraschicas"><img src="imagenes/avatares/<?php echo $row_Recordcomentarios['avatar'];?>" height="16" width="16" alt=""/> <strong><?php echo $row_Recordcomentarios['usuario']; ?> dijo:</strong></span>
<?php echo $row_Recordcomentarios['comentario']; ?>
</div>
<br />
          <br />
<strong>Participantes Euro 2012</strong>
     <?php do { ?>
  <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center; vertical-align:text-bottom;">
   		 <img src="imagenes/avatares/<?php echo $row_todoamerica['avatar'];?>" height="32" width="32" alt=""/> <?php echo $row_todoamerica['inscriptos']; ?>  (<b><?php echo $row_todoamerica['puntos']; ?></b> puntos)
         	</div>
  </div>
	  <?php } while ($row_todoamerica = mysql_fetch_assoc($todoamerica)); ?>
          <br />
</div>
<!-- Fin derecha -->
<div style="clear:both;">
<br /><object 
classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
id="a316c31ab8da4dc196b24fc9ed928166" 
width="760" 
height="120">
<param name="movie" value="http://imstore.bet365affiliates.com/365_051969-421-123-2-149-3-31684.aspx">
<param name="quality" value="high">
<param name="wmode" value="transparent">
<param name="allowScriptAccess" value="always">
<param name="allowNetworking" value="external">
<embed 
src="http://imstore.bet365affiliates.com/365_051969-421-123-2-149-3-31684.aspx" 
quality="high" 
allowScriptAccess="always" 
allowNetworking="external"  
swLiveConnect="false" 
width="760" 
height="120" 
name="a316c31ab8da4dc196b24fc9ed928166" 
type="application/x-shockwave-flash" 
pluginspage="https://www.macromedia.com/go/getflashplayer" 
wmode="transparent">
</embed>
</object>
<br /><br />
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
