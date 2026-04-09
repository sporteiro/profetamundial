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
<link rel="shortcut icon" href="favicon.ico"/><script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" /></div>
<div class="contenedora_2018">
  <p><strong>Restituir Contrase&ntilde;a</strong></p>
  <div>
    <form id="formcontacto" name="formcontacto" method="post" action="enviarmensaje.php">
  
      <p>
	<span id="sprytextfield1">
	<label>Nombre de usuario
 	   	<input name="usuario" type="text" class="letrasgrandes" id="usuario" />
 	 </label>
  			<span class="textfieldRequiredMsg">Campo obligatorio</span>
	</span>
      </p>
      <p>
    <span id="sprytextfield4">
  	<label>Email
    	<input name="email" type="text" class="letrasgrandes" id="email" />
  	</label>
  		<span class="textfieldRequiredMsg">Campo obligatorio
        </span>
        <span class="textfieldInvalidFormatMsg">Tiene que ser un correo electr&oacute;nico
        </span>
	</span>
      <input name="motivo" type="hidden" id="motivo" value="contrasena"/>
      <input name="origen" type="hidden" id="origen" value="Equipo" />
      </p>
      <p>Comentario:<span class="letraschicas"> (Opcional, por si tenes algun otro problema)</span></p>
      <p><span>
        <label>
          <textarea name="mensaje" cols="40" rows="5" class="letrasgrandes" id="mensaje"></textarea>
        </label><br />
      </p>
      <p>
        <label>
          <input name="enviar" type="submit" class="botones" id="enviar" value="Solicitar nueva contrase&ntilde;a" />
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
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:1, maxChars:38});
//-->
</script>
</body>
</html>
