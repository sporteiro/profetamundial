<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlogadmin.php'); ?>
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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["puntaje"]))) {
  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='seblash' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='seblsh' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='seblash';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='marcelo' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='marcelo' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='marcelo';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='pablo' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='pablo' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='pablo';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='handry' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='handry' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='handry';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='santiago' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='santiago' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='santiago';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateSQL = "UPDATE usuarios set puntos=(
(SELECT  count(*) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='felipescu' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19 and pp.glocal!=99)+
(SELECT (count(*)*4) FROM partidos pp join partidos ps  ON  pp.CodPar=ps.CodPar 
WHERE ps.CodUsu='felipescu' and pp.CodUsu='ProfetaMundial' and pp.resultado=ps.resultado and pp.CodPar<19  and pp.glocal=ps.glocal and pp.gvisitante=ps.gvisitante and pp.glocal!=99)
) WHERE usuario='felipescu';";
                

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

  $updateGoTo = "puntuar.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
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
<!-- inicio de area Izquierda -->
<br /><b>GRUPO A</b>
<br />
<iframe src="mGA.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>

<br /><b>GRUPO B</b>
<br />
<iframe src="mGB.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>

<br /><b>GRUPO C</b>
<br />
<iframe src="mGC.php" frameborder="0" scrolling="no" width="600px" height="370px"></iframe>
<br />
<br /><b>Segunda Fase</b>
<br />
<iframe src="mfase2.php" frameborder="0" scrolling="no" width="730px" height="760px"></iframe>



<!-- fin de la Derecha -->
<div style="clear: both;">

<form action="<?php echo $editFormAction; ?>" id="puntuar" name="puntuar" method="post">
	<input class="botones" type="submit" name="puntaje" value="Puntuar usuarios"/>
</form>

</div>
<br />
<hr />
  
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
	Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico" /><br />
</div>
<!-- Final --> 
</body>
</html>
