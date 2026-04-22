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

$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$query_limit_recordusuarios = sprintf("%s LIMIT %d, %d", $query_recordusuarios, $startRow_recordusuarios, $maxRows_recordusuarios);
$recordusuarios = mysql_query($query_limit_recordusuarios, $conexion);
$row_recordusuarios = $recordusuarios ? mysql_fetch_assoc($recordusuarios) : array('usuario' => '');

////////////////////////////////////////////////////////////////////////////////////////////////////
$puntusuario=array('seblash','pablo','marcelo');

/////////PUNTUACIONES
$puntos_por_usuario = array();
foreach ($puntusuario as $U)	{

$consulta_puntos_resultados="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$U."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<24 and pp.glocal!=99; ";
$resultado_puntos_resultados=mysql_query($consulta_puntos_resultados, $conexion);
$filas_puntos_resultados = mysql_fetch_assoc($resultado_puntos_resultados);

$consulta_puntos_resultados2="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE (ps.CodUsu='".$U."' AND pp.CodUsu='ProfetaMundial') AND pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 25 AND 31) AND pp.glocal!=99; ";
$resultado_puntos_resultados2=mysql_query($consulta_puntos_resultados2, $conexion);
$filas_puntos_resultados2 = mysql_fetch_assoc($resultado_puntos_resultados2);


$consulta_puntos_exactos="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$U."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<24  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99; ";
$resultado_puntos_exactos=mysql_query($consulta_puntos_exactos, $conexion);
$filas_puntos_exactos = mysql_fetch_assoc($resultado_puntos_exactos);



$consulta_puntos_exactos2="SELECT COUNT(*) AS puntos FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar WHERE ps.CodUsu='".$U."' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado AND (pp.CodPar BETWEEN 25 AND 31)  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante AND pp.local=ps.local AND pp.visitante=ps.visitante and pp.glocal!=99; ";
$resultado_puntos_exactos2=mysql_query($consulta_puntos_exactos2, $conexion);
$filas_puntos_exactos2 = mysql_fetch_assoc($resultado_puntos_exactos2);

$puntos_por_usuario[$U] = array(
  'fr' => $filas_puntos_resultados,
  'fr2' => $filas_puntos_resultados2,
  'fe' => $filas_puntos_exactos,
  'fe2' => $filas_puntos_exactos2,
);

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Euro 2012 Polonia-Ucrania</title>
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
<p class="letrasmasgrandes">Euro 2012 Polonia-Ucrania</p>
<? foreach ($puntusuario as $U)	{ 
$pu = $puntos_por_usuario[$U];
//Puntuaciones:
$exactos=intval($pu['fe']['puntos'] ?? 0)+intval($pu['fe2']['puntos'] ?? 0);
$pexactos=$exactos*5;

$partidoGrupos=intval($pu['fr']['puntos'] ?? 0)-intval($pu['fe']['puntos'] ?? 0);

$partidoSegunda=intval($pu['fr2']['puntos'] ?? 0)-intval($pu['fe2']['puntos'] ?? 0);
$puntospartidoSegunda=$partidoSegunda*2;

$total=$pexactos+$partidoGrupos+$puntospartidoSegunda;
?>
<div class="tablaclasificacion">
<div class="comentarios">


<p>Pronostico de <b><?php echo $U?></b> </p>
<p>Puntaje provisional fase de grupos:</p>
<p>Resultado del partido: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoGrupos?>  (<?=$partidoGrupos?> puntos)</p>
<p>Resultado del partido en Segunda Fase: <i>(NO se cuentan los resultados exactos)</i> <?=$partidoSegunda?>  (<?=$puntospartidoSegunda?> puntos)</p>
<p>Resultados exactos Totales:  <?=$exactos?>  (<?=$pexactos?> puntos)</p>
<hr />
<p>Total sin extras: <b><?=$total?></b> puntos</p>
<? if	($_SESSION['MM_Username']=='profetamundial')	{ ?>
	<input type="hidden" value="puntuar" />
	<input type="hidden" value="<?=$total?>"/>
	<input class="botones" value="Puntuar"/>
<? }?>
<? } ?>
</div>
</div>
<br />



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
