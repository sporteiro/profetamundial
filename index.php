<?php require_once('Connections/conexion.php'); ?>
<?php require_once __DIR__ . '/includes/mundial2026_seed.php'; ?>
<?php require_once('ingresar.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  // Usamos la conexión mysqli definida en conexion.php
  global $conexion;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  if (function_exists("mysqli_real_escape_string") && $conexion) {
    $theValue = mysqli_real_escape_string($conexion, $theValue);
  } else {
    $theValue = addslashes($theValue);
  }

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

// Ya seleccionamos la base de datos en conexion.php (mysqli_connect incluye el nombre de la DB)
$query_todoslosusuarios = "SELECT * FROM usuarios ORDER BY puntos DESC";
$todoslosusuarios = mysqli_query($conexion, $query_todoslosusuarios) or die(mysqli_error($conexion));
$row_todoslosusuarios = mysqli_fetch_assoc($todoslosusuarios);
$totalRows_todoslosusuarios = mysqli_num_rows($todoslosusuarios);

$query_Recordcomentarios = "SELECT * FROM comentarios natural join usuarios ORDER BY id DESC";
$Recordcomentarios = mysqli_query($conexion, $query_Recordcomentarios) or die(mysqli_error($conexion));
$row_Recordcomentarios = mysqli_fetch_assoc($Recordcomentarios);
$totalRows_Recordcomentarios = mysqli_num_rows($Recordcomentarios);


$query_todomundial2026 = "SELECT T.*, U.* FROM Torneos as T join usuarios as U on T.inscriptos=U.usuario WHERE CodTor='20' AND U.usuario!='ProfetaMundial' order by U.puntos DESC";
$todomundial2026= mysqli_query($conexion, $query_todomundial2026) or die(mysqli_error($conexion));
$row_todomundial2026 = mysqli_fetch_assoc($todomundial2026);
$totalRows_todomundial2026= mysqli_num_rows($todomundial2026);

if (mundial2026_partidos_tiene_columna_fecha($conexion)) {
  $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE CodPar IN (SELECT CodPar FROM partidos_mundial2026 WHERE fecha_partido = CURDATE()) AND CodUsu != 'ProfetaMundial' AND local IN (SELECT local FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') AND visitante IN (SELECT visitante FROM partidos_mundial2026 WHERE fecha_partido = CURDATE() AND CodUsu = 'ProfetaMundial') ORDER BY CodPar, resultado, glocal, gvisitante, CodUsu";
} else {
  $query_hoy_usu = "SELECT * FROM partidos_mundial2026 WHERE 1 = 0";
}
$hoy_usu = mysqli_query($conexion, $query_hoy_usu) or die(mysqli_error($conexion));
$totalRows_hoy_usu= mysqli_num_rows($hoy_usu);
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
   		 <p><strong>¡Disponible el pron&oacute;stico para el Mundial 2026!</strong></p>
  		<span><a href="noingrese.php" class="botoneschicos" target="_blank">Participar en el Mundial 2026</a></span>
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
<?php if ($totalRows_hoy_usu > 0) { ?>
<p><strong>Pronosticos para los partidos de hoy:</strong></p>
		<div class="comentarios" style="text-align:center;">		
		<?php 
		$con='a';	
		$d=0;
		if ($totalRows_hoy_usu>0) {
		while ($row_usu = mysqli_fetch_assoc($hoy_usu)) {
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
<?php } ?>
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
<strong>Participantes Mundial 2026</strong>
     <?php if ($totalRows_todomundial2026 > 0) { do { ?>
  <div class="tablaresultados">
        	<div class="comentarios" style="text-align:center; vertical-align:text-bottom;">
   			<img src="imagenes/avatares/<?php echo $row_todomundial2026['avatar'];?>" height="32" width="32" alt="" class="comentarios_avatar"/> 
			<span class="comentarios_usuario"> <?php echo $row_todomundial2026['inscriptos']; ?> </span> 
			<div class="puntos">
				<span class="puntos_numero"><?php echo $row_todomundial2026['puntos']; ?></span><br />
				<span class="puntos_texto">PUNTOS</span>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
         	</div>
  </div>
	  <?php } while ($row_todomundial2026 = mysqli_fetch_assoc($todomundial2026)); } ?>
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
