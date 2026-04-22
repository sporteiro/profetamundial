<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
// Parámetros esperados desde wrappers GA_mundial2026.php ... GL_mundial2026.php:
// - $GRUPO_LETRA (A..L)
// - $CODPAR_INICIO (1,7,13,...,67)
if (!isset($GRUPO_LETRA) || !isset($CODPAR_INICIO)) {
  die('Grupo no configurado');
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
    case "text":  return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    case "long":
    case "int":   return ($theValue != "") ? intval($theValue) : "NULL";
    case "double":return ($theValue != "") ? doubleval($theValue) : "NULL";
    case "date":  return ($theValue != "") ? "'" . $theValue . "'" : "NULL";
    case "defined": return ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
  }
  return "NULL";
}
}

$codParInicio = intval($CODPAR_INICIO);
$codParFin = $codParInicio + 5;
$grupo = $GRUPO_LETRA;
$uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');

// Guardar partidos del grupo (6 partidos)
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] === "grupo".$grupo)) {
  for ($n = $codParInicio; $n <= $codParFin; $n++) {
    $gl = isset($_POST['L'.$n]) ? intval($_POST['L'.$n]) : 0;
    $gv = isset($_POST['V'.$n]) ? intval($_POST['V'.$n]) : 0;

    if ($gl > $gv) { $resultado = 1; }
    else if ($gl < $gv) { $resultado = 2; }
    else { $resultado = 0; }

    $updateSQL = "UPDATE partidos_mundial2026
                  SET glocal='".$gl."', gvisitante='".$gv."', resultado='".$resultado."'
                  WHERE CodUsu='".$uEsc."' AND CodPar='".$n."'";
    mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
  }

  // Recalcular tabla del grupo desde los 6 partidos guardados
  $qPartidos = "SELECT local, visitante, glocal, gvisitante
                FROM partidos_mundial2026
                WHERE CodUsu='".$uEsc."'
                  AND CodPar BETWEEN ".$codParInicio." AND ".$codParFin;
  $rsPartidos = mysqli_query($conexion, $qPartidos) or die(mysqli_error($conexion));

  $stats = []; // team => [p,gf,ga]
  while ($p = mysqli_fetch_assoc($rsPartidos)) {
    $loc = $p['local'];
    $vis = $p['visitante'];
    $gl  = intval($p['glocal']);
    $gv  = intval($p['gvisitante']);

    if (!isset($stats[$loc])) $stats[$loc] = ['p'=>0,'gf'=>0,'ga'=>0];
    if (!isset($stats[$vis])) $stats[$vis] = ['p'=>0,'gf'=>0,'ga'=>0];

    $stats[$loc]['gf'] += $gl; $stats[$loc]['ga'] += $gv;
    $stats[$vis]['gf'] += $gv; $stats[$vis]['ga'] += $gl;

    if ($gl > $gv) { $stats[$loc]['p'] += 3; }
    else if ($gl < $gv) { $stats[$vis]['p'] += 3; }
    else { $stats[$loc]['p'] += 1; $stats[$vis]['p'] += 1; }
  }

  foreach ($stats as $team => $s) {
    $dif = $s['gf'] - $s['ga'];
    $upd = "UPDATE equipos_mundial2026
            SET puntos='".intval($s['p'])."',
                golfav='".intval($s['gf'])."',
                golcon='".intval($s['ga'])."',
                difgol='".intval($dif)."'
            WHERE CodUsu='".$uEsc."'
              AND grupo='".$grupo."'
              AND nombre='".mysqli_real_escape_string($conexion, $team)."'";
    mysqli_query($conexion, $upd) or die(mysqli_error($conexion));
  }
}

// Mostrar partidos y tabla
$q = "SELECT * FROM partidos_mundial2026
      WHERE CodUsu='".$uEsc."'
        AND CodPar BETWEEN ".$codParInicio." AND ".$codParFin."
      ORDER BY CodPar";
$resultado = mysqli_query($conexion, $q) or die(mysqli_error($conexion));

$qTabla = "SELECT * FROM equipos_mundial2026
           WHERE CodUsu='".$uEsc."'
             AND grupo='".$grupo."'
           ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla = mysqli_query($conexion, $qTabla) or die(mysqli_error($conexion));
?>
<div>
  <div id="tablaypartidos_mundial2026_<?php echo $grupo; ?>">
    <div id="partidos_grupo_mundial2026_<?php echo $grupo; ?>">
      <form name="grupo<?php echo $grupo; ?>" id="grupo<?php echo $grupo; ?>" method="post" action="#">
        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
          <div class="comentarios">
            <?php
            $fechaMostrar = '';
            if (!empty($fila['fecha_partido'])) {
              $fechaMostrar = $fila['fecha_partido'];
            } elseif (!empty($fila['fecha'])) {
              $fx = $fila['fecha'];
              if ($fx !== '2099-12-31' && $fx !== '0000-00-00') {
                $fechaMostrar = $fx;
              }
            }
            if ($fechaMostrar !== '') { ?>
              <span class="letraschicas"><?php echo htmlspecialchars($fechaMostrar, ENT_QUOTES, 'UTF-8'); ?></span><br />
            <?php } ?>
            <?php $local = $fila['local'] ?? ''; ?>
            <img src="imagenes/banamerica/<?php echo rawurlencode($local); ?>.gif" width="20" height="10" alt="" />
            <?php echo htmlspecialchars($local, ENT_QUOTES, 'UTF-8'); ?>
            <input type="number" min="0" max="99" name="L<?php echo intval($fila['CodPar']); ?>" value="<?php echo intval($fila['glocal']); ?>" class="botoneschicos"/>
            -
            <input type="number" min="0" max="99" name="V<?php echo intval($fila['CodPar']); ?>" value="<?php echo intval($fila['gvisitante']); ?>" class="botoneschicos"/>
            <?php $visitante = $fila['visitante'] ?? ''; ?>
            <?php echo htmlspecialchars($visitante, ENT_QUOTES, 'UTF-8'); ?>
            <img src="imagenes/banamerica/<?php echo rawurlencode($visitante); ?>.gif" width="20" height="10" alt="" />
          </div>
        <?php } ?>

        <div class="tabla_grupo_mundial2026 tabla_grupo_mundial2022" id="tabla_grupo_mundial2026_<?php echo $grupo; ?>">
          <table>
            <tr class="comentarios">
              <td>Grupo <?php echo $grupo; ?></td>
              <td>Puntos</td>
              <td>GF</td>
              <td>GC</td>
              <td>Dif gol</td>
            </tr>
            <?php while ($t = mysqli_fetch_assoc($resultado_tabla)) { ?>
              <tr class="comentarios">
                <td class="equipo-nombre">
                  <?php $nombreEquipo = $t['nombre'] ?? ''; ?>
                  <img src="imagenes/banamerica/<?php echo rawurlencode($nombreEquipo); ?>.gif" width="30" height="20" alt="" />
                  <?php echo htmlspecialchars($nombreEquipo, ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td class="alignright"><?php echo $t['puntos']; ?></td>
                <td class="alignright"><?php echo $t['golfav']; ?></td>
                <td class="alignright"><?php echo $t['golcon']; ?></td>
                <td class="alignright"><?php echo $t['difgol']; ?></td>
              </tr>
            <?php } ?>
          </table>
        </div>

        <div class="clear"></div>
        <input type="submit" class="botones" value="Guardar cambios" />
        <input type="hidden" name="MM_update" value="<?php echo "grupo".$grupo; ?>" />
      </form>
    </div>
  </div>
</div>

