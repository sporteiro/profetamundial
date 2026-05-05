<?php
require_once('Connections/conexion.php');
require_once('codlog.php');

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

$today = date("YmdH");
$limite = '2026060923';
$fueraTiempo = ($limite <= $today) ? 1 : 0;
$esAdmin = (isset($_SESSION['MM_Username']) && strcasecmp($_SESSION['MM_Username'], 'ProfetaMundial') === 0);
$inputsDisabled = ($fueraTiempo == 1 && !$esAdmin);

$codParInicio = intval($CODPAR_INICIO);
$codParFin = $codParInicio + 5;
$grupo = $GRUPO_LETRA;
$uEsc = mysqli_real_escape_string($conexion, $_SESSION['MM_Username'] ?? '');

// Guardar partidos (si se envía el formulario)
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] === "grupo".$grupo)) {
    if (!$inputsDisabled || $esAdmin) {
        for ($n = $codParInicio; $n <= $codParFin; $n++) {
            $gl = isset($_POST['L'.$n]) ? intval($_POST['L'.$n]) : 0;
            $gv = isset($_POST['V'.$n]) ? intval($_POST['V'.$n]) : 0;
            if ($gl > $gv) $resultado = 1;
            else if ($gl < $gv) $resultado = 2;
            else $resultado = 0;
            $updateSQL = "UPDATE partidos_mundial2026 SET glocal='".$gl."', gvisitante='".$gv."', resultado='".$resultado."' WHERE CodUsu='".$uEsc."' AND CodPar='".$n."'";
            mysqli_query($conexion, $updateSQL) or die(mysqli_error($conexion));
        }

        // Recalcular tabla del grupo
        $qPartidos = "SELECT local, visitante, glocal, gvisitante FROM partidos_mundial2026 WHERE CodUsu='".$uEsc."' AND CodPar BETWEEN ".$codParInicio." AND ".$codParFin;
        $rsPartidos = mysqli_query($conexion, $qPartidos) or die(mysqli_error($conexion));
        $stats = [];
        while ($p = mysqli_fetch_assoc($rsPartidos)) {
            $loc = $p['local']; $vis = $p['visitante']; $gl = intval($p['glocal']); $gv = intval($p['gvisitante']);
            if (!isset($stats[$loc])) $stats[$loc] = ['p'=>0,'gf'=>0,'ga'=>0];
            if (!isset($stats[$vis])) $stats[$vis] = ['p'=>0,'gf'=>0,'ga'=>0];
            $stats[$loc]['gf'] += $gl; $stats[$loc]['ga'] += $gv;
            $stats[$vis]['gf'] += $gv; $stats[$vis]['ga'] += $gl;
            if ($gl > $gv) $stats[$loc]['p'] += 3;
            else if ($gl < $gv) $stats[$vis]['p'] += 3;
            else { $stats[$loc]['p'] += 1; $stats[$vis]['p'] += 1; }
        }
        foreach ($stats as $team => $s) {
            $dif = $s['gf'] - $s['ga'];
            $upd = "UPDATE equipos_mundial2026 SET puntos='".intval($s['p'])."', golfav='".intval($s['gf'])."', golcon='".intval($s['ga'])."', difgol='".intval($dif)."' WHERE CodUsu='".$uEsc."' AND grupo='".$grupo."' AND nombre='".mysqli_real_escape_string($conexion, $team)."'";
            mysqli_query($conexion, $upd) or die(mysqli_error($conexion));
        }
    }

    // Si es una petición AJAX, devolvemos SOLO el contenido interior del grupo (sin el div contenedor)
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // Re-ejecutamos las consultas para generar el HTML actualizado
        $q = "SELECT * FROM partidos_mundial2026 WHERE CodUsu='".$uEsc."' AND CodPar BETWEEN ".$codParInicio." AND ".$codParFin." ORDER BY CodPar";
        $resultado = mysqli_query($conexion, $q) or die(mysqli_error($conexion));
        $qTabla = "SELECT * FROM equipos_mundial2026 WHERE CodUsu='".$uEsc."' AND grupo='".$grupo."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
        $resultado_tabla = mysqli_query($conexion, $qTabla) or die(mysqli_error($conexion));
        ?>
        <!-- SOLO EL CONTENIDO INTERNO (sin el div contenedor) -->
        <div id="partidos_grupo_mundial2026_<?php echo $grupo; ?>">
            <form name="grupo<?php echo $grupo; ?>" id="grupo<?php echo $grupo; ?>" method="post" action="">
                <?php while ($fila = mysqli_fetch_assoc($resultado)) {
                    $codPartido = intval($fila['CodPar']);
                    $glocal = intval($fila['glocal']);
                    $gvisitante = intval($fila['gvisitante']);
                    $local = htmlspecialchars($fila['local'], ENT_QUOTES, 'UTF-8');
                    $visitante = htmlspecialchars($fila['visitante'], ENT_QUOTES, 'UTF-8');
                ?>
                    <div class="comentarios">
                        <?php
                        $fechaMostrar = '';
                        if (!empty($fila['fecha_partido'])) $fechaMostrar = $fila['fecha_partido'];
                        elseif (!empty($fila['fecha'])) {
                            $fx = $fila['fecha'];
                            if ($fx !== '2099-12-31' && $fx !== '0000-00-00') $fechaMostrar = $fx;
                        }
                        if ($fechaMostrar !== '') { ?>
                            <span class="letraschicas"><?php echo htmlspecialchars($fechaMostrar, ENT_QUOTES, 'UTF-8'); ?></span><br />
                        <?php } ?>
                        <img src="imagenes/banamerica/<?php echo rawurlencode($local); ?>.gif" width="20" height="10" alt="" />
                        <?php echo $local; ?>
                        <input type="number" min="0" max="99" name="L<?php echo $codPartido; ?>" value="<?php echo $glocal; ?>" class="botoneschicos" <?php echo $inputsDisabled ? 'disabled' : ''; ?> />
                        -
                        <input type="number" min="0" max="99" name="V<?php echo $codPartido; ?>" value="<?php echo $gvisitante; ?>" class="botoneschicos" <?php echo $inputsDisabled ? 'disabled' : ''; ?> />
                        <?php echo $visitante; ?>
                        <img src="imagenes/banamerica/<?php echo rawurlencode($visitante); ?>.gif" width="20" height="10" alt="" />
                    </div>
                <?php } ?>

                <div id="tabla_grupo_mundial2026_<?php echo $grupo; ?>">
                    <table class="tabla_grupo_mundial2026">
                        <tr class="comentarios">
                            <th>Grupo <?php echo $grupo; ?></th>
                            <th>Puntos</th>
                            <th>GF</th>
                            <th>GC</th>
                            <th>Dif gol</th>
                        </tr>
                        <?php while ($t = mysqli_fetch_assoc($resultado_tabla)) { ?>
                            <tr class="comentarios">
                                <td class="equipo-nombre">
                                    <img src="imagenes/banamerica/<?php echo rawurlencode($t['nombre']); ?>.gif" width="30" height="20" alt="" />
                                    <?php echo htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8'); ?>
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
                <?php if (!$inputsDisabled) { ?>
                    <input type="submit" class="botones" id="botonguardar_<?php echo $grupo; ?>" value="Guardar cambios" />
                <?php } ?>
                <input type="hidden" name="MM_update" value="<?php echo "grupo".$grupo; ?>" />
                <input type="hidden" name="grupo" value="<?php echo $grupo; ?>" />
            </form>
        </div>
        <?php
        exit; // No seguir con el resto del script
    }
}

// Si no es AJAX o es la primera carga, mostrar el grupo normalmente (con su contenedor exterior)
$q = "SELECT * FROM partidos_mundial2026 WHERE CodUsu='".$uEsc."' AND CodPar BETWEEN ".$codParInicio." AND ".$codParFin." ORDER BY CodPar";
$resultado = mysqli_query($conexion, $q) or die(mysqli_error($conexion));
$qTabla = "SELECT * FROM equipos_mundial2026 WHERE CodUsu='".$uEsc."' AND grupo='".$grupo."' ORDER BY puntos DESC, difgol DESC, golfav DESC, nombre";
$resultado_tabla = mysqli_query($conexion, $qTabla) or die(mysqli_error($conexion));
?>
<div id="tablaypartidos_mundial2026_<?php echo $grupo; ?>">
    <div id="partidos_grupo_mundial2026_<?php echo $grupo; ?>">
        <form name="grupo<?php echo $grupo; ?>" id="grupo<?php echo $grupo; ?>" method="post" action="">
            <?php while ($fila = mysqli_fetch_assoc($resultado)) {
                $codPartido = intval($fila['CodPar']);
                $glocal = intval($fila['glocal']);
                $gvisitante = intval($fila['gvisitante']);
                $local = htmlspecialchars($fila['local'], ENT_QUOTES, 'UTF-8');
                $visitante = htmlspecialchars($fila['visitante'], ENT_QUOTES, 'UTF-8');
            ?>
                <div class="comentarios">
                    <?php
                    $fechaMostrar = '';
                    if (!empty($fila['fecha_partido'])) $fechaMostrar = $fila['fecha_partido'];
                    elseif (!empty($fila['fecha'])) {
                        $fx = $fila['fecha'];
                        if ($fx !== '2099-12-31' && $fx !== '0000-00-00') $fechaMostrar = $fx;
                    }
                    if ($fechaMostrar !== '') { ?>
                        <span class="letraschicas"><?php echo htmlspecialchars($fechaMostrar, ENT_QUOTES, 'UTF-8'); ?></span><br />
                    <?php } ?>
                    <img src="imagenes/banamerica/<?php echo rawurlencode($local); ?>.gif" width="20" height="10" alt="" />
                    <?php echo $local; ?>
                    <input type="number" min="0" max="99" name="L<?php echo $codPartido; ?>" value="<?php echo $glocal; ?>" class="botoneschicos" <?php echo $inputsDisabled ? 'disabled' : ''; ?> />
                    -
                    <input type="number" min="0" max="99" name="V<?php echo $codPartido; ?>" value="<?php echo $gvisitante; ?>" class="botoneschicos" <?php echo $inputsDisabled ? 'disabled' : ''; ?> />
                    <?php echo $visitante; ?>
                    <img src="imagenes/banamerica/<?php echo rawurlencode($visitante); ?>.gif" width="20" height="10" alt="" />
                </div>
            <?php } ?>

            <div id="tabla_grupo_mundial2026_<?php echo $grupo; ?>">
                <table class="tabla_grupo_mundial2026">
                    <tr class="comentarios">
                        <th>Grupo <?php echo $grupo; ?></th>
                        <th>Puntos</th>
                        <th>GF</th>
                        <th>GC</th>
                        <th>Dif gol</th>
                    </tr>
                    <?php while ($t = mysqli_fetch_assoc($resultado_tabla)) { ?>
                        <tr class="comentarios">
                            <td class="equipo-nombre">
                                <img src="imagenes/banamerica/<?php echo rawurlencode($t['nombre']); ?>.gif" width="30" height="20" alt="" />
                                <?php echo htmlspecialchars($t['nombre'], ENT_QUOTES, 'UTF-8'); ?>
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
            <?php if (!$inputsDisabled) { ?>
                <input type="submit" class="botones" id="botonguardar_<?php echo $grupo; ?>" value="Guardar cambios" />
            <?php } ?>
            <input type="hidden" name="MM_update" value="<?php echo "grupo".$grupo; ?>" />
            <input type="hidden" name="grupo" value="<?php echo $grupo; ?>" />
        </form>
    </div>
</div>

<script>
(function() {
    function whenJQueryReady() {
        if (typeof jQuery === 'undefined') {
            setTimeout(whenJQueryReady, 50);
            return;
        }
        jQuery(document).ready(function($) {
            var grupoLetra = '<?php echo $grupo; ?>';
            var formId = '#grupo' + grupoLetra;
            // El contenedor padre que envuelve todo el grupo (incluyendo el div exterior)
            var contenedorPadreId = '#tablaypartidos_mundial2026_' + grupoLetra;
            // El contenedor interno que se reemplazará (para evitar duplicación)
            var contenedorInternoId = '#partidos_grupo_mundial2026_' + grupoLetra;
            var btnGuardarId = '#botonguardar_' + grupoLetra;

            function enviarFormularioGrupo() {
                var $form = $(formId);
                // Construir URL con el parámetro ajax_grupo (usando pathname para evitar fragmentos)
                var url = window.location.pathname + '?ajax_grupo=' + grupoLetra;
                var formData = $form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'html',
                    success: function(htmlContenidoInterno) {
                        // Reemplazar solo el contenido interno (el div con id="partidos_grupo_mundial2026_...")
                        $(contenedorInternoId).replaceWith(htmlContenidoInterno);
                        // Actualizar la fase final (eliminatorias)
                        if (typeof window.actualizarFase2 === 'function') {
                            window.actualizarFase2();
                        }
                        // Feedback visual opcional
                        $(btnGuardarId).val('Guardado');
                        setTimeout(function() { $(btnGuardarId).val('Guardar cambios'); }, 1000);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al guardar:', error);
                        alert('Error al guardar los datos. Revisa la consola.');
                    }
                });
            }

            // Autoguardado: al cambiar un input, si el checkbox está marcado
            $(document).on('change', formId + ' input[type="number"]', function() {
                var $toggle = $('#autosaveToggle');
                if ($toggle.length && $toggle.is(':checked')) {
                    enviarFormularioGrupo();
                } else {
                    $(btnGuardarId).show();
                }
            });

            // Envío manual (botón Guardar cambios)
            $(document).on('submit', formId, function(e) {
                e.preventDefault();
                enviarFormularioGrupo();
            });
        });
    }
    whenJQueryReady();
})();
</script>