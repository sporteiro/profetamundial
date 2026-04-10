<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  global $conexion;
  $theValue = mysqli_real_escape_string($conexion, $theValue);

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

$query_comentarios = "SELECT * FROM comentarios ORDER BY id DESC";
$comentarios = mysqli_query($conexion, $query_comentarios) or die(mysqli_error($conexion));
$row_comentarios = mysqli_fetch_assoc($comentarios);
$totalRows_comentarios = mysqli_num_rows($comentarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Todos los comentarios</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<br />
<div id="contenedora" class="contenedora">
<div class="tablaclasificacion">
<?php do { ?>
      <div class="comentarios">
        <p class="letraschicas"><?php echo $row_comentarios['usuario']; ?>  Dice: <?php echo $row_comentarios['comentario']; ?></p>
</div>
      <br />
      <?php } while ($row_comentarios = mysqli_fetch_assoc($comentarios)); ?>
  <a href="empezar.php" class="botones">Volver a mi cuenta</a><br /> 
      <br />
</div>
</div>
</body>
</html>
<?php
mysqli_free_result($comentarios);
?>
