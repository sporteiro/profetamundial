<?php require_once('Connections/conexion.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  $isValid = False; 
  if (!empty($UserName)) { 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) $isValid = true; 
    if (in_array($UserGroup, $arrGroups)) $isValid = true; 
    if (($strUsers == "") && true) $isValid = true; 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  global $conexion;
  $theValue = mysqli_real_escape_string($conexion, $theValue);
  switch ($theType) {
    case "text": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;    
    case "long": case "int": $theValue = ($theValue != "") ? intval($theValue) : "NULL"; break;
    case "double": $theValue = ($theValue != "") ? doubleval($theValue) : "NULL"; break;
    case "date": $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL"; break;
    case "defined": $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue; break;
  }
  return $theValue;
}
}

$colname_recordusuarios = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_recordusuarios = $_SESSION['MM_Username'];
}
$query_recordusuarios = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_recordusuarios, "text"));
$recordusuarios = mysqli_query($conexion, $query_recordusuarios) or die(mysqli_error($conexion));
$row_recordusuarios = mysqli_fetch_assoc($recordusuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Reglas del juego – Mundial 2026</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico"/>
</head>

<body>
<div id="titulo"><img src="imagenes/profetamundial.png" alt="Profeta Mundial" /></div>
<div class="contenedora_2018">
<div style="padding:10px;">
  <p><strong>Reglas del Juego – Copa Mundial de la FIFA 2026</strong></p>
  <p class="letraschicas">Usted, <?php echo htmlspecialchars($row_recordusuarios['nombre'], ENT_QUOTES, 'UTF-8'); ?>, usuario de nombre <?php echo htmlspecialchars($row_recordusuarios['usuario'], ENT_QUOTES, 'UTF-8'); ?>, al ingresar como usuario en Profeta Mundial (profetamundial.com), admite haber leído, entendido y aceptado sin excepción las siguientes Reglas del Juego, así como sus posibles futuras modificaciones.</p>
  
  <p class="letraschicas"><strong>GANADOR DEL JUEGO</strong></p>
  <p class="letraschicas">El/la ganador/a o los ganadores/as serán aquellos usuarios que consigan más puntos al término de la Copa Mundial de la FIFA 2026 (<strong>formato 48 selecciones, 12 grupos de 4 equipos, dieciseisavos, octavos, cuartos, semifinales, tercer puesto y final</strong>). Los puntos se asignan según los criterios del <strong>Sistema de Puntuación</strong>.</p>
  
  <p class="letraschicas"><strong>SISTEMA DE PUNTUACIÓN</strong></p>
  <p class="letraschicas"><strong>Resultado exacto:</strong> número de goles de local y visitante (asociados a los equipos). Ejemplo: "Argentina 3 México 0".<br />
  <strong>Resultado del partido:</strong> victoria local, victoria visitante o empate (solo en la primera ronda; en eliminatorias directas, si el partido termina empatado tras 90' + prórroga, se considera empate y se aplica el selector "Si empatan, elegí").<br />
  <strong>¡IMPORTANTE!</strong> En los partidos eliminatorios, la tanda de penales NO se tiene en cuenta para el resultado del partido ni para el resultado exacto. Solo cuenta el marcador final después de la prórroga.</p>
  
  <p class="letrasgrandes">FASE DE GRUPOS</p>
  <p class="letraschicas">Se compone de 12 grupos (A a L) de 4 selecciones cada uno. Se juegan 6 partidos por grupo.</p>
  <table width="500" border="0" cellspacing="3" cellpadding="0" class="tablaclasificacion">
    <tr>
      <td><strong>Tipo de acierto</strong></td>
      <td><strong>Puntos</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado exacto (goles de cada equipo)</td>
      <td class="letraschicas">5</td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado del partido (local, visitante, empate)</td>
      <td class="letraschicas">1</td>
    </tr>
  </table>
  <p class="letraschicas">Ejemplo: Real: Argentina 3 México 0. Usuario pronostica Argentina 1 México 0 → 1 punto (acertó victoria local). Si pronostica Argentina 3 México 0 → 5 puntos. No se suman puntos extra por resultado del partido ya que está incluido.</p>
  
  <p class="letrasgrandes">FASE ELIMINATORIA (desde dieciseisavos hasta la final)</p>
  <p class="letraschicas">La fase final comienza con los 32avos de final (partidos 73 a 88), luego octavos (89-96), cuartos (97-100), semifinales (101-102), partido por el tercer puesto (103) y final (104). El sistema actualiza automáticamente los enfrentamientos cuando se modifican los grupos, respetando los goles que hayas ingresado.</p>
  <table width="500" border="0" cellspacing="3" cellpadding="0" class="tablaclasificacion">
    <tr>
      <td><strong>Tipo de acierto</strong></td>
      <td><strong>Puntos</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado exacto (goles de cada equipo)</td>
      <td class="letraschicas">5</td>
    </tr>
    <tr>
      <td class="letraschicas">Resultado del partido (local, visitante, empate)</td>
      <td class="letraschicas">2</td>
    </tr>
  </table>
  <p class="letraschicas">Ejemplo: Real: Uruguay 3 Nigeria 0. Usuario pronostica Uruguay 1 Nigeria 0 → 2 puntos (acertó victoria local). Si además eligió como clasificado a Uruguay (en caso de empate), suma los puntos correspondientes.</p>
  
  <p class="letrasgrandes">DETERMINACIÓN DE POSICIONES EN GRUPOS (para el juego)</p>
  <p class="letraschicas">Para calcular los puestos de cada grupo, el sistema aplica el siguiente orden de criterios (similar al oficial, pero sin fair play ni sorteo real):</p>
  <ol class="letraschicas">
    <li>Mayor número de puntos</li>
    <li>Diferencia de goles (goles a favor – goles en contra)</li>
    <li>Mayor número de goles a favor</li>
    <li><strong>Resultado del partido directo entre los equipos empatados</strong> (si solo hay dos)</li>
    <li><strong>Orden alfabético (de menor a mayor según nombre del país)</strong> – en caso de persistir el empate (esto sustituye al sorteo o fair play real)</li>
  </ol>
  <p class="letraschicas">En empates de tres o más equipos, se comparan los puntos obtenidos en los partidos entre ellos; si aún persiste, se aplica diferencia de goles y goles a favor en esos partidos; finalmente, orden alfabético.</p>
  
  <p class="letrasgrandes">EXTRAS</p>
  <p class="letraschicas">Puntos adicionales que se suman al total independientemente de los aciertos por partido.</p>
  <table width="630" border="0" cellpadding="0" cellspacing="3" class="tablaclasificacion">
    <tr>
      <td width="495"><strong>Tipo de acierto</strong></td>
      <td width="61"><strong>Puntos</strong></td>
    </tr>
    <tr>
      <td class="letraschicas">Equipo campeón</td>
      <td class="letraschicas">15</td>
    </tr>
    <tr>
      <td class="letraschicas">Goleador (apellido del jugador, o uno de ellos en caso de empate)</td>
      <td class="letraschicas">10</td>
    </tr>
    <tr>
      <td class="letraschicas">Por cada equipo que clasifica a una fase (dieciseisavos, octavos, cuartos, semifinales, tercer puesto, final) COINCIDIENDO con tu pronóstico</td>
      <td class="letraschicas">1</td>
    </tr>
    <tr>
      <td class="letraschicas">Acertar el tercer puesto (ganador del partido 103)</td>
      <td class="letraschicas">5</td>
    </tr>
  </table>
  <p class="letraschicas">Los puntos por equipos en fases se otorgan automáticamente según los equipos que hayas pronosticado en cada cruce (no es necesario seleccionarlos manualmente más allá de los partidos).</p>
  
  <p class="letraschicas"><strong>ACTUALIZACIÓN EN CASCADA</strong></p>
  <p class="letraschicas">Cada vez que modifiques un resultado de fase de grupos, el sistema actualizará automáticamente los enfrentamientos de la fase final para reflejar los nuevos clasificados, manteniendo tus pronósticos de goles donde sea posible. Si el cambio afecta a qué equipo avanza, se recalcularán los cruces posteriores.</p>
  
  <p class="letraschicas"><strong>FECHA LÍMITE DE PARTICIPACIÓN</strong></p>
  <p class="letraschicas">El 9 de junio de 2026 a las 23:00 horas (CET) finalizará el plazo para registrarse y/o modificar pronósticos. Después de esa fecha solo se podrá consultar la cuenta, sin editar resultados.</p>
  
  <p><a href="empezar.php" class="botones">VOLVER</a></p>
</div>
</div>
<div id="final" class="final">
Diseño y desarrollo del sitio: <a href="http://www.sebastianporteiro.com/">Sebastian Porteiro</a> <img src="http://www.sebastianporteiro.com/favicon.ico"/>
</div>
</body>
</html>
<?php
mysqli_free_result($recordusuarios);
?>