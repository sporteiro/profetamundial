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
$query_todoamerica = "SELECT T.*, U.* FROM Torneos as T join usuarios as U on T.inscriptos=U.usuario WHERE CodTor='5' AND U.usuario!='ProfetaMundial' order by U.puntos DESC";
$todoamerica = mysql_query($query_todoamerica, $conexion) or die(mysql_error());
$row_todoamerica = mysql_fetch_assoc($todoamerica);
$totalRows_todoamerica= mysql_num_rows($todoamerica);

mysql_select_db($database_conexion, $conexion);
$query_hoy_usu= "SELECT * FROM partidos_ol WHERE CodPar in(select CodPar from partidos_ol where fecha=curdate()) and CodUsu !='ProfetaMundial' AND  local in (select local from partidos_ol where fecha=curdate() and CodUsu='ProfetaMundial') AND  visitante in (select visitante from partidos_ol where fecha=curdate() and CodUsu='ProfetaMundial') ORDER BY CodPar, resultado,Glocal,Gvisitante,CodUsu ;";
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
<!-- Fin cabecera -->	
<div id="android_logo">
	<img src="../imagenes/profetamundial.png" width="50%" alt="Profeta Mundial" />
</div>
<div>

</div>
<div id="contenedora" class="contenedora">
<form id="formingreso" name="formingreso" method="post" action="<?php echo $loginFormAction; ?>">
			<span id="sprytextfield1">
			<label>
                	Usuario <br /><input name="usuario" type="text" size="13" id="usuario" value="<?=$pid?>" /><br />
  			</label>
  			<span class="textfieldRequiredMsg">Escrib&iacute; tu nombre de usuario</span>
             		</span><br />
 			<span id="sprytextfield2">
 			<label>
			Contrase&ntilde;a <br /><input name="contrasena" type="password" size="13" id="contrasena" value="<?=$pis?>" onchange="borrarcookie()"/><br />
    			<span class="textfieldRequiredMsg">Escrib&iacute; tu contrase&ntilde;a</span>
            		</span><br />
			<input name="enviar" type="submit" class="botones" id="enviar" value="Ingresá" />
			</label>
		</form>

</div>
<!-- Fin derecha -->
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
