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
$maxRows_recordusuarios = 25;
$pageNum_recordusuarios = 0;
if (isset($_GET['pageNum_recordusuarios'])) {
  $pageNum_recordusuarios = $_GET['pageNum_recordusuarios'];
}
$startRow_recordusuarios = $pageNum_recordusuarios * $maxRows_recordusuarios;

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
mysql_select_db($database_conexion, $conexion);
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysql_query($query_limit_recordusuarios, $conexion) or die(mysql_error());
$row_recordusuarios = mysql_fetch_assoc($recordusuarios);


mysql_select_db($database_conexion,$conexion);
$consulta="SELECT * FROM partidos WHERE CodPar BETWEEN 1 AND 6 AND CodUsu='".$_GET['verlode']."'";
$resultado=mysql_query($consulta, $conexion);

$consulta_tabla_A="SELECT * FROM equipos WHERE grupo='A' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla_A=mysql_query($consulta_tabla_A, $conexion);



mysql_select_db($database_conexion,$conexion);
$consultaB="SELECT * FROM partidos WHERE CodPar BETWEEN 7 AND 12 AND CodUsu='".$_GET['verlode']."'";
$resultadoB=mysql_query($consultaB, $conexion);

$consulta_tabla_B="SELECT * FROM equipos WHERE grupo='B' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_B=mysql_query($consulta_tabla_B, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultaC="SELECT * FROM partidos WHERE CodPar BETWEEN 13 AND 18 AND CodUsu='".$_GET['verlode']."'";
$resultadoC=mysql_query($consultaC, $conexion);

$consulta_tabla_C="SELECT * FROM equipos WHERE grupo='C' AND CodUsu='".$_GET['verlode']."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre DESC";
$resultado_tabla_C=mysql_query($consulta_tabla_C, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultacuartos="SELECT * FROM partidos WHERE CodPar BETWEEN 19 AND 22 AND CodUsu='".$_GET['verlode']."'";
$resultadocuartos=mysql_query($consultacuartos, $conexion);


mysql_select_db($database_conexion,$conexion);
$consultasemis="SELECT * FROM partidos WHERE CodPar BETWEEN 23 AND 24 AND CodUsu='".$_GET['verlode']."'";
$resultadosemis=mysql_query($consultasemis, $conexion);

mysql_select_db($database_conexion,$conexion);
$consultafinal="SELECT * FROM partidos WHERE CodPar=25 AND CodUsu='".$_GET['verlode']."'";
$resultadofinal=mysql_query($consultafinal, $conexion);
$filasresultadofinal=mysql_fetch_assoc($resultadofinal);

mysql_select_db($database_conexion,$conexion);
$consultatercer="SELECT * FROM partidos WHERE CodPar=26 AND CodUsu='".$_GET['verlode']."'";
$resultadotercer=mysql_query($consultatercer, $conexion);
$filasresultadotercer=mysql_fetch_assoc($resultadotercer);


mysql_select_db($database_conexion,$conexion);
$consultagoleador="SELECT * FROM partidos WHERE CodPar=28 AND CodUsu='".$_GET['verlode']."'";
$resultadogoleador=mysql_query($consultagoleador, $conexion);
$filasresultadogoleador=mysql_fetch_assoc($resultadogoleador);
										
mysql_select_db($database_conexion,$conexion);
$consultacampeon="SELECT * FROM partidos WHERE CodPar=27  AND CodUsu='".$_GET['verlode']."'";
$resultadocampeon=mysql_query($consultacampeon, $conexion);
$filasresultadocampeon=mysql_fetch_assoc($resultadocampeon);




mysql_select_db($database_conexion,$conexion);
$consulta_puntos_resultados="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysql_query($consulta_puntos_resultados, $conexion);
$filas_puntos_resultados = mysql_fetch_assoc($resultado_puntos_resultados);



mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos="SELECT pp.*, ps.*, count(*) as 'puntos' FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$_GET['verlode']."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysql_query($consulta_puntos_exactos, $conexion);
$filas_puntos_exactos = mysql_fetch_assoc($resultado_puntos_exactos);


mysql_select_db($database_conexion,$conexion);
$consulta_puntos_exactos2="SELECT * FROM usuarios WHERE usuario='".$_GET['verlode']."'";
$resultado_puntos_exactos2=mysql_query($consulta_puntos_exactos2, $conexion);
$filas_puntos_exactos2 = mysql_fetch_assoc($resultado_puntos_exactos2);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Copa America Argentina 2011</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!-- inicio de la cabecera -->
<div class="cabecera">
	<div style="width: 300px; float:left;" class="nada"><a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
    </div>
   	<div class="loginiz">
		<p>USUARIO: <?php echo $row_recordusuarios['usuario']; ?><br />
  <a href="empezar.php">MI CUENTA</a>
  		</p>   
		<a href="<?php echo $logoutAction ?>" class="botoneschicos">Desconectarse</a>
    </div><br />
    <div style="clear:both;"></div>
</div>
<!-- Fin de la cabecera-->
<br />
<div id="contenedora" class="contenedora">
<p class="letrasmasgrandes">Copa America Argentina 2011</p>

<div class="tablaclasificacion">
<div class="comentarios">
<p>Pronostico de <b><?php echo $_GET['verlode']?></b> </p>
<p>Puntaje provisional fase de grupos:</p>
<p>Resultado del partido: <i>(NO se cuentan los resultados exactos)</i> <?php echo $filas_puntos_resultados['puntos']-$filas_puntos_exactos['puntos'];?>  (<?php echo $filas_puntos_resultados['puntos']-$filas_puntos_exactos['puntos'];?> puntos)</p>
<p>Resultado exacto:  <?php echo $filas_puntos_exactos['puntos'];?>  (<?php echo $filas_puntos_exactos['puntos']*5;?> puntos)</p>
<p>Puntaje provisional Segunda Fase: <b><?php echo ($filas_puntos_exactos2['puntos'])-($filas_puntos_resultados['puntos']+$filas_puntos_exactos['puntos']*4);?></b> puntos</p>
<hr />
<p>Total: <b><?php echo $filas_puntos_exactos2['puntos'];?></b> puntos</p>	
</div>
</div>
<br />


<!-- inicio de area Izquierda -->
<div class="tablaclasificacion">
<br /><b>GRUPO A</b>
<br />
	<?php while ($filasresultado=mysql_fetch_assoc($resultado)) { ?>
			<div class="comentarios">
			<?php echo $filasresultado['local']; ?>  <b><?php echo $filasresultado['glocal']; ?></b>  - <b><?php echo $filasresultado['gvisitante']; ?></b> <?php echo $filasresultado['visitante']; ?> 
			</div>
			<?php } ?>
            <br />
<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo A</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_A=mysql_fetch_assoc($resultado_tabla_A)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_A['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_A['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_A['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_A['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_A['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO B</b>
<br />
<?php while ($filasresultadoB=mysql_fetch_assoc($resultadoB)) { ?>
			<div class="comentarios">
			<?php echo $filasresultadoB['local']; ?> <b><?php echo $filasresultadoB['glocal']; ?></b> - <b><?php echo $filasresultadoB['gvisitante']; ?></b> <?php echo $filasresultadoB['visitante']; ?> 
			</div>
			<?php } ?>
     
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo B</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_B=mysql_fetch_assoc($resultado_tabla_B)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_B['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_B['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_B['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_B['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_B['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>
<hr />
<br /><b>GRUPO C</b>
<br />

	<?php while ($filasresultadoC=mysql_fetch_assoc($resultadoC)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadoC['local']; ?> <b><?php echo $filasresultadoC['glocal']; ?></b>  -  <b><?php echo $filasresultadoC['gvisitante']; ?>  </b><?php echo $filasresultadoC['visitante']; ?>  
			</div>
			<?php } ?>
       
			<br />
			<table border="1" class="tablaclasificacion">
				<tr class="comentarios">
					<td>Grupo C</td>
					<td>Puntos</td>
					<td>GF</td>
					<td>GC</td>
					<td>Dif gol</td>
				</tr>
			<?php while ($filasresultado_tabla_C=mysql_fetch_assoc($resultado_tabla_C)) { ?>
				<tr>
					<td><?php echo $filasresultado_tabla_C['nombre']; ?></td>
					<td><?php echo $filasresultado_tabla_C['puntos']; ?></td>
					<td><?php echo $filasresultado_tabla_C['golfav']; ?></td>
					<td><?php echo $filasresultado_tabla_C['golcon']; ?></td>
					<td><?php echo $filasresultado_tabla_C['difgol']; ?></td>
				</tr>
			<?php } ?>
			</table>

<hr />
<br />
<br /><b>Segunda Fase</b>
<br />
<p><b>Cuartos de Final</b></p>
<?php while ($filasresultadocuartos=mysql_fetch_assoc($resultadocuartos)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadocuartos['local']; ?> <b><?php echo $filasresultadocuartos['glocal']; ?></b>  -  <b><?php echo $filasresultadocuartos['gvisitante']; ?></b> <?php echo $filasresultadocuartos['visitante']; ?>  
			</div>
			<?php } ?>
    
<p><b>Semifinales</b></p>
<?php while ($filasresultadosemis=mysql_fetch_assoc($resultadosemis)) { ?>
			<div class="comentarios">
		<?php echo $filasresultadosemis['local']; ?> <b><?php echo $filasresultadosemis['glocal']; ?></b>  -  <b><?php echo $filasresultadosemis['gvisitante']; ?></b>  <?php echo $filasresultadosemis['visitante']; ?>  
			</div>
			<?php } ?>
            
    <p><b>FINAL</b></p>
    <div class="comentarios" style="text-align:center; font-size:14px; padding:6px;">
<img src="imagenes/banamerica/<?php echo $filasresultadofinal['local']; ?>.gif" width="20" height="10" /> <?php echo $filasresultadofinal['local']; ?> <b><?php echo $filasresultadofinal['glocal']; ?></b> - <b><?php echo $filasresultadofinal['gvisitante']; ?></b> <?php echo $filasresultadofinal['visitante']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadofinal['visitante']; ?>.gif" width="20" height="10" />
	
	</div>
    
    <p><b>Tercer y cuarto puesto</b></p>
    <div class="comentarios" style="text-align:center; font-size:14px; padding:6px;">
<?php echo $filasresultadotercer['local']; ?> <b><?php echo $filasresultadotercer['glocal']; ?></b> - <b><?php echo $filasresultadotercer['gvisitante']; ?></b> <?php echo $filasresultadotercer['visitante']; ?>
	</div>
    <br />
    <div class="comentarios">
	<p><b>Campeon: </b><?php echo $filasresultadocampeon['local']; ?>  <img src="imagenes/banamerica/<?php echo $filasresultadocampeon['local']; ?>.gif" width="20" height="10" /></p>

   <p><b>Tercero: </b><?php echo $filasresultadocampeon['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultadocampeon['visitante']; ?>.gif" width="20" height="10" /></p>
		

	<p><b>Goleador </b>: <?php echo $filasresultadogoleador['local']; ?>  (<?php echo $filasresultadogoleador['visitante']; ?> <img src="imagenes/banamerica/<?php echo $filasresultadogoleador['visitante']; ?>.gif" width="20" height="10" />)  </p>
			
		</div>
		
		<br />


<!-- fin de la Derecha -->
<div style="clear: both;"></div>

</div>
<br /><br />
</div>
<br />
<!-- Final -->    
<div style="clear:both;"></div>  
<div id="final" class="final">
	<p>
  	<a href="reglas.php" class="botoneschicos">Reglas del juego</a>  |
  	<a href="contacto.php" class="botoneschicos">Soluci&oacute;n de Problemas</a>  |
  	<a href="terminos.php" class="botoneschicos">T&eacute;rminos y condiciones de uso</a>
    </p>
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com.ar/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com.ar/favicon.ico" /><br />
	Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a>    
</div>
<!-- Final --> 
</body>
</html>
