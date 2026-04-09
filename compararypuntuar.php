<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlogadmin.php'); ?>
<?php 

mysql_select_db($database_conexion, $conexion);
$consulta_reales="SELECT * FROM partidos WHERE CodUsu='ProfetaMundial' ORDER BY CodPar";
$resultado_reales=mysql_query($consulta_reales, $conexion);

		
mysql_select_db($database_conexion, $conexion);
$consulta_seblash="SELECT * FROM partidos WHERE CodUsu='seblash' ORDER BY CodPar";
$resultado_seblash=mysql_query($consulta_seblash, $conexion);

mysql_select_db($database_conexion, $conexion);
$consulta_handry="SELECT * FROM partidos WHERE CodUsu='handry' ORDER BY CodPar";
$resultado_handry=mysql_query($consulta_handry, $conexion);

mysql_select_db($database_conexion, $conexion);
$consulta_santiago="SELECT * FROM partidos WHERE CodUsu='santiago' ORDER BY CodPar";
$resultado_santiago=mysql_query($consulta_santiago, $conexion);

mysql_select_db($database_conexion, $conexion);
$consulta_felipescu="SELECT * FROM partidos WHERE CodUsu='felipescu' ORDER BY CodPar";
$resultado_felipescu=mysql_query($consulta_felipescu, $conexion);


mysql_select_db($database_conexion, $conexion);
$consulta_pablo="SELECT * FROM partidos WHERE CodUsu='pablo' ORDER BY CodPar";
$resultado_pablo=mysql_query($consulta_pablo, $conexion);


mysql_select_db($database_conexion, $conexion);
$consulta_marcelo="SELECT * FROM partidos WHERE CodUsu='marcelo' ORDER BY CodPar";
$resultado_marcelo=mysql_query($consulta_marcelo, $conexion);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Puntuar</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<meta name="robots" content="none" />
</head>
<body>

<div id="titulo"><img src="imagenes/profetamundial.png" width="310" height="103" alt="Profeta Mundial" /></div>
	<div class="contenedora" style="width: 9400px;">
		<strong><span class="letrasgrandes">PUNTUAR USUARIOS:</span></strong>
			<div style="clear: both;"></div>
  			<div class="tablaclasificacion" style="float: left; width: 3%;">
				Resultados reales:
   				<?php while($filas_reales=mysql_fetch_assoc($resultado_reales)) { ?>
				<p class="comentarios">	
				<?php echo $filas_reales['local'];?> <b> <?php echo $filas_reales['glocal'];?></b>
				<?php echo $filas_reales['visitante'];?> <b> <?php echo $filas_reales['gvisitante'];?></b>
				Resultado: <?php echo $filas_reales['resultado'];?>
				</p>	
				<?php } ?>
     				
  			</div>
			
			
  			<div class="tablaclasificacion" style="float: left; width:3%;">
					Seblash:
					<?php while($filas_seblash=mysql_fetch_assoc($resultado_seblash)) { ?>
				<p class="comentarios">	
				<?php echo $filas_seblash['local'];?> <b> <?php echo $filas_seblash['glocal'];?></b>
				<?php echo $filas_seblash['visitante'];?> <b> <?php echo $filas_seblash['gvisitante'];?></b>
				Resultado: <?php echo $filas_seblash['resultado'];?>
				</p>	
				<?php } ?>
  			</div>
			
			<div class="tablaclasificacion" style="float: left; width: 3%;">
					handry:
					<?php while($filas_handry=mysql_fetch_assoc($resultado_handry)) { ?>
				<p class="comentarios">	
				<?php echo $filas_handry['local'];?> <b> <?php echo $filas_handry['glocal'];?></b>
				<?php echo $filas_handry['visitante'];?> <b> <?php echo $filas_handry['gvisitante'];?></b>
				Resultado: <?php echo $filas_handry['resultado'];?>
				</p>	
				<?php } ?>
  			</div>

			<div class="tablaclasificacion" style="float: left; width: 3%;">
					santiago:
					<?php while($filas_santiago=mysql_fetch_assoc($resultado_santiago)) { ?>
				<p class="comentarios">	
				<?php echo $filas_santiago['local'];?> <b> <?php echo $filas_santiago['glocal'];?></b>
				<?php echo $filas_santiago['visitante'];?> <b> <?php echo $filas_santiago['gvisitante'];?></b>
				Resultado: <?php echo $filas_santiago['resultado'];?>
				</p>	
				<?php } ?>
  			</div>
			
			<div class="tablaclasificacion" style="float: left; width: 3%;">
					felipescu:
					<?php while($filas_felipescu=mysql_fetch_assoc($resultado_felipescu)) { ?>
				<p class="comentarios">	
				<?php echo $filas_felipescu['local'];?> <b> <?php echo $filas_felipescu['glocal'];?></b>
				<?php echo $filas_felipescu['visitante'];?> <b> <?php echo $filas_felipescu['gvisitante'];?></b>
				Resultado: <?php echo $filas_felipescu['resultado'];?>
				</p>	
				<?php } ?>
  			</div>
			
			<div class="tablaclasificacion" style="float: left; width: 3%;">
					pablo:
					<?php while($filas_pablo=mysql_fetch_assoc($resultado_pablo)) { ?>
				<p class="comentarios">	
				<?php echo $filas_pablo['local'];?> <b> <?php echo $filas_pablo['glocal'];?></b>
				<?php echo $filas_pablo['visitante'];?> <b> <?php echo $filas_pablo['gvisitante'];?></b>
				Resultado: <?php echo $filas_pablo['resultado'];?>
				</p>	
				<?php } ?>
  			</div>

			<div class="tablaclasificacion" style="float: left; width: 3%;">
					marcelo:
					<?php while($filas_marcelo=mysql_fetch_assoc($resultado_marcelo)) { ?>
				<p class="comentarios">	
				<?php echo $filas_marcelo['local'];?> <b> <?php echo $filas_marcelo['glocal'];?></b>
				<?php echo $filas_marcelo['visitante'];?> <b> <?php echo $filas_marcelo['gvisitante'];?></b>
				Resultado: <?php echo $filas_marcelo['resultado'];?>
				</p>	
				<?php } ?>
  			</div>

			<br /><br />
  			<div>	
			<div style="clear: both;"></div>
			<a href="empezar.php" class="botones">IR A MI CUENTA</a> <a href="<?php echo $logoutAction ?>"><span class="botones">Desconectarse</span></a>
<br /><br />
			</div>
	</div>
</body>
</html>
