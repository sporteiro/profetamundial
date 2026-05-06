<?php require_once('Connections/conexion.php'); ?>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Restituir contrase&ntilde;a</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" width="310" height="103" alt="Profeta Mundial" /></div>
<div class="contenedora">
  <p><strong>Restituir Contrase&ntilde;a</strong></p>
  <div>
    <form id="formcontacto" name="formcontacto" method="post" action="enviarmensaje.php">
  
      <p>Nombre de usuario:
<input name="usuario" type="text" id="usuario" value="" />
	<input name="motivo" type="hidden" id="motivo" value="Se olvido la contrase&ntilde;a" />
      </p>
      <p>
        Nombre real: 
<input name="nombre" type="text" id="nombre" value="" />
      </p>
      <p>
      E-mail:
<input name="email" type="text" id="email" value="" />
      <input name="origen" type="hidden" id="origen" value="ProfetaMundial" />
      </p>
      <p>Comentario:</p>
      <p><span id="sprytextarea1">
        <label>
          <textarea name="mensaje" cols="40" rows="5" class="letrasgrandes" id="mensaje"></textarea>
        </label><br />
      <span class="textareaRequiredMsg">El mensaje esta vac&iacute;o</span></span></p>
      <p>
        <label>
          <input name="enviar" type="submit" class="botones" id="enviar" value="Enviar el mensaje" />
        </label>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>  <p><a href="empezar.php" class="botones">VOLVER</a></p>&nbsp;</p>
    </form>
</div>
</div>
<div id="final" class="final">
Dise&ntilde;o y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/><br />
Alojado en: <a href="http://www.000webhost.com/">000webhost.com</a></div>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
//-->
</script>
</body>
</html>
