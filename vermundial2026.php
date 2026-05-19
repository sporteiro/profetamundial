<?php
// ============================================================
// vermundial2026.php – Ver pronóstico de otro usuario (Mundial 2026)
// ============================================================
require_once('Connections/conexion.php');
require_once('codlog.php');
require_once __DIR__ . '/includes/mundial2026_seed.php';

$verlode = isset($_GET['verlode']) ? trim($_GET['verlode']) : '';
if (empty($verlode)) {
    header("Location: empezar.php");
    exit;
}
$verlodeEsc = mysqli_real_escape_string($conexion, $verlode);

// Datos del usuario a mostrar
$qUser = "SELECT * FROM usuarios WHERE usuario = '$verlodeEsc'";
$rsUser = mysqli_query($conexion, $qUser) or die(mysqli_error($conexion));
$rowUser = mysqli_fetch_assoc($rsUser);
if (!$rowUser) {
    die("Usuario no encontrado.");
}

// ============================================================
// FUNCIONES AUXILIARES PARA CÁLCULO DE PUNTOS (solo visual)
// ============================================================
function calcularPuntosUsuario($conexion, $usuario) {
    $uEsc = mysqli_real_escape_string($conexion, $usuario);
    $codUsuPlantilla = 'ProfetaMundial';

    $qResGrupos = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='$uEsc' AND pp.CodUsu='$codUsuPlantilla' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 1 AND 72 AND pp.glocal!=99";
    $rResGrupos = mysqli_query($conexion, $qResGrupos);
    $fResGrupos = mysqli_fetch_assoc($rResGrupos);

    $qExactGrupos = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='$uEsc' AND pp.CodUsu='$codUsuPlantilla' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 1 AND 72 AND pp.glocal=ps.glocal AND pp.gvisitante=ps.gvisitante AND pp.glocal!=99";
    $rExactGrupos = mysqli_query($conexion, $qExactGrupos);
    $fExactGrupos = mysqli_fetch_assoc($rExactGrupos);

    $qResKo = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='$uEsc' AND pp.CodUsu='$codUsuPlantilla' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 73 AND 104 AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal!=99";
    $rResKo = mysqli_query($conexion, $qResKo);
    $fResKo = mysqli_fetch_assoc($rResKo);

    $qExactKo = "SELECT COUNT(*) AS puntos FROM partidos_mundial2026 pp JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar WHERE ps.CodUsu='$uEsc' AND pp.CodUsu='$codUsuPlantilla' AND pp.resultado=ps.resultado AND pp.CodPar BETWEEN 73 AND 104 AND pp.local=ps.local AND pp.visitante=ps.visitante AND pp.glocal=ps.glocal AND pp.gvisitante=ps.gvisitante AND pp.glocal!=99";
    $rExactKo = mysqli_query($conexion, $qExactKo);
    $fExactKo = mysqli_fetch_assoc($rExactKo);

    $exactos = intval($fExactGrupos['puntos'] ?? 0) + intval($fExactKo['puntos'] ?? 0);
    $pExactos = $exactos * 5;
    $partidosGrupos = intval($fResGrupos['puntos'] ?? 0) - intval($fExactGrupos['puntos'] ?? 0);
    $partidosKo = intval($fResKo['puntos'] ?? 0) - intval($fExactKo['puntos'] ?? 0);
    $pPartidosKo = $partidosKo * 2;
    $puntosPartidos = $pExactos + $partidosGrupos + $pPartidosKo;

    // Función para verificar si una fase está completa (todos los partidos sin glocal=99 en ProfetaMundial)
    function faseCompleta($conexion, $inicio, $fin) {
        $q = "SELECT COUNT(*) AS total FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar BETWEEN $inicio AND $fin AND glocal=99";
        $r = mysqli_query($conexion, $q);
        if ($r) {
            $row = mysqli_fetch_assoc($r);
            return intval($row['total'] ?? 1) === 0;
        }
        return false;
    }

    // Extras: equipos en fases (dieciseisavos, octavos, cuartos, etc.)
    function equiposEnRango($conexion, $u, $inicio, $fin) {
        $uEsc = mysqli_real_escape_string($conexion, $u);
        $q = "SELECT local as equipo FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar BETWEEN $inicio AND $fin UNION SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar BETWEEN $inicio AND $fin";
        $r = mysqli_query($conexion, $q);
        $equipos = [];
        while ($row = mysqli_fetch_assoc($r)) {
            $nom = $row['equipo'];
            if (!empty($nom) && $nom != '3?' && strpos($nom, 'Ganador') === false && strpos($nom, 'Perdedor') === false) {
                $equipos[] = $nom;
            }
        }
        return array_unique($equipos);
    }
    
    $usr16 = equiposEnRango($conexion, $usuario, 73, 88);
    $real16 = faseCompleta($conexion, 1, 72) ? equiposEnRango($conexion, 'ProfetaMundial', 73, 88) : [];
    $pts16 = count(array_intersect($usr16, $real16));
    
    $usrOct = equiposEnRango($conexion, $usuario, 89, 96);
    $realOct = faseCompleta($conexion, 73, 88) ? equiposEnRango($conexion, 'ProfetaMundial', 89, 96) : [];
    $ptsOct = count(array_intersect($usrOct, $realOct));
    
    $usrCuartos = equiposEnRango($conexion, $usuario, 97, 100);
    $realCuartos = faseCompleta($conexion, 89, 96) ? equiposEnRango($conexion, 'ProfetaMundial', 97, 100) : [];
    $ptsCuartos = count(array_intersect($usrCuartos, $realCuartos));
    
    $usrSemis = equiposEnRango($conexion, $usuario, 101, 102);
    $realSemis = faseCompleta($conexion, 97, 100) ? equiposEnRango($conexion, 'ProfetaMundial', 101, 102) : [];
    $ptsSemis = count(array_intersect($usrSemis, $realSemis));
    
    // Final y tercer puesto dependen de que las semifinales estén completas
    $usrFinal = equiposEnRango($conexion, $usuario, 104, 104);
    $realFinal = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 104, 104) : [];
    $ptsFinal = count(array_intersect($usrFinal, $realFinal));
    
    $usrTercer = equiposEnRango($conexion, $usuario, 103, 103);
    $realTercer = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 103, 103) : [];
    $ptsTercer = count(array_intersect($usrTercer, $realTercer));
    
    $puntosFases = $pts16 + $ptsOct + $ptsCuartos + $ptsSemis + $ptsFinal + $ptsTercer;

    // Campeón, goleador, tercer puesto
    $qCampeonReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
    $rCampeonReal = mysqli_query($conexion, $qCampeonReal);
    $campeonReal = mysqli_fetch_assoc($rCampeonReal)['local'] ?? '';
    $qCampeonUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
    $rCampeonUsr = mysqli_query($conexion, $qCampeonUsr);
    $campeonUsr = mysqli_fetch_assoc($rCampeonUsr)['local'] ?? '';
    $puntosCampeon = ($campeonUsr == $campeonReal && !empty($campeonReal)) ? 15 : 0;

    $qTerceroReal = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
    $rTerceroReal = mysqli_query($conexion, $qTerceroReal);
    $terceroReal = mysqli_fetch_assoc($rTerceroReal)['visitante'] ?? '';
    $qTerceroUsr = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
    $rTerceroUsr = mysqli_query($conexion, $qTerceroUsr);
    $terceroUsr = mysqli_fetch_assoc($rTerceroUsr)['visitante'] ?? '';
    $puntosTercero = ($terceroUsr == $terceroReal && !empty($terceroReal)) ? 5 : 0;

    $qGoleadorReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=106";
    $rGoleadorReal = mysqli_query($conexion, $qGoleadorReal);
    $goleadorReal = mysqli_fetch_assoc($rGoleadorReal)['local'] ?? '';
    $qGoleadorUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=106";
    $rGoleadorUsr = mysqli_query($conexion, $qGoleadorUsr);
    $goleadorUsr = mysqli_fetch_assoc($rGoleadorUsr)['local'] ?? '';
    $puntosGoleador = ($goleadorUsr == $goleadorReal && !empty($goleadorReal)) ? 10 : 0;

    return $puntosPartidos + $puntosFases + $puntosCampeon + $puntosTercero + $puntosGoleador;
}

$puntosTotales = calcularPuntosUsuario($conexion, $verlode);

// ============================================================
// OBTENER DATOS DE PARTIDOS Y EQUIPOS DEL USUARIO
// ============================================================
// Grupos (partidos 1-72) - solo columnas existentes: CodPar, local, visitante, glocal, gvisitante, fecha
$qPartidos = "SELECT CodPar, local, visitante, glocal, gvisitante, fecha FROM partidos_mundial2026 WHERE CodUsu='$verlodeEsc' ORDER BY CodPar";
$rsPartidos = mysqli_query($conexion, $qPartidos) or die(mysqli_error($conexion));
$partidos = [];
while ($p = mysqli_fetch_assoc($rsPartidos)) {
    $partidos[intval($p['CodPar'])] = $p;
}

// Equipos por grupo
$qEquipos = "SELECT grupo, nombre, puntos, golfav, golcon, difgol FROM equipos_mundial2026 WHERE CodUsu='$verlodeEsc' ORDER BY grupo, puntos DESC, difgol DESC, golfav DESC";
$rsEquipos = mysqli_query($conexion, $qEquipos) or die(mysqli_error($conexion));
$equiposPorGrupo = [];
while ($e = mysqli_fetch_assoc($rsEquipos)) {
    $g = $e['grupo'];
    if (!isset($equiposPorGrupo[$g])) $equiposPorGrupo[$g] = [];
    $equiposPorGrupo[$g][] = $e;
}

// Fase final (partidos 73-106)
$qKo = "SELECT CodPar, local, visitante, glocal, gvisitante FROM partidos_mundial2026 WHERE CodUsu='$verlodeEsc' AND CodPar BETWEEN 73 AND 106 ORDER BY CodPar";
$rsKo = mysqli_query($conexion, $qKo) or die(mysqli_error($conexion));
$koMatches = [];
while ($m = mysqli_fetch_assoc($rsKo)) {
    $koMatches[intval($m['CodPar'])] = $m;
}

// Función para mostrar equipo con bandera (evita mostrar bandera si es texto genérico)
function equipoConBandera($nombre) {
    if (empty($nombre)) return '';
    if (strpos($nombre, 'Ganador') !== false || strpos($nombre, 'Perdedor') !== false || strpos($nombre, 'Semifinalista') !== false || strpos($nombre, '3?') !== false || strpos($nombre, '3º') !== false) {
        return htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
    }
    $bandera = '<img src="imagenes/banamerica/' . rawurlencode($nombre) . '.gif" width="20" height="10" alt="" style="margin-right:3px; vertical-align:middle;">';
    return $bandera . ' ' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
}

// Función para mostrar un partido de grupo
function mostrarPartidoGrupo($par) {
    echo '<div class="partido-grupo">';
    if (!empty($par['fecha']) && $par['fecha'] != '2099-12-31' && $par['fecha'] != '0000-00-00') {
        echo '<span class="fecha-partido">' . htmlspecialchars($par['fecha'], ENT_QUOTES) . '</span><br>';
    }
    echo equipoConBandera($par['local']) . ' <b>' . intval($par['glocal']) . '</b> - <b>' . intval($par['gvisitante']) . '</b> ' . equipoConBandera($par['visitante']);
    echo '</div>';
}

// Función para mostrar tabla de posiciones de un grupo
function mostrarTablaGrupo($equipos) {
    echo '<table class="tabla-grupo-ver">';
    echo '<tr><th>Equipo</th><th>Pts</th><th>GF</th><th>GC</th><th>Dif</th></tr>';
    foreach ($equipos as $eq) {
        echo '<tr>';
        echo '<td class="equipo-nombre">' . equipoConBandera($eq['nombre']) . '</td>';
        echo '<td class="alignright">' . intval($eq['puntos']) . '</td>';
        echo '<td class="alignright">' . intval($eq['golfav']) . '</td>';
        echo '<td class="alignright">' . intval($eq['golcon']) . '</td>';
        echo '<td class="alignright">' . intval($eq['difgol']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

// Función para mostrar partido de fase final
function mostrarPartidoKo($n, $title, $matches) {
    $m = $matches[$n] ?? ['local' => '', 'visitante' => '', 'glocal' => 0, 'gvisitante' => 0];
    echo '<div class="partido-ko">';
    echo '<strong>' . htmlspecialchars($title, ENT_QUOTES) . '</strong><br>';
    echo equipoConBandera($m['local']) . ' <b>' . intval($m['glocal']) . '</b> - <b>' . intval($m['gvisitante']) . '</b> ' . equipoConBandera($m['visitante']);
    echo '</div>';
}
?>
<?php require_once('header.php'); ?>
<div class="main-container" style="margin-top: 100px;">
    <div class="modern-card" style="text-align: center;">
        <h2>Pronóstico de <strong><?php echo htmlspecialchars($rowUser['usuario'], ENT_QUOTES); ?></strong></h2>
        <p style="font-size: 1.2rem;">Puntuación total: <strong><?php echo $puntosTotales; ?></strong> puntos</p>
    </div>

    <!-- GRUPOS (A-L) -->
    <?php
    $grupos = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
    $codInicio = 1;
    foreach ($grupos as $g) {
        $codFin = $codInicio + 5;
        $partidosGrupo = array_filter($partidos, function($k) use ($codInicio, $codFin) {
            return $k >= $codInicio && $k <= $codFin;
        }, ARRAY_FILTER_USE_KEY);
        ksort($partidosGrupo);

        echo '<div class="modern-card grupo-card">';
        echo '<h3>Grupo ' . $g . '</h3>';
        echo '<div class="grupo-contenido">';
        echo '<div class="grupo-partidos">';
        foreach ($partidosGrupo as $par) {
            mostrarPartidoGrupo($par);
        }
        echo '</div>';
        echo '<div class="grupo-tabla">';
        if (isset($equiposPorGrupo[$g])) {
            mostrarTablaGrupo($equiposPorGrupo[$g]);
        } else {
            echo '<p>No hay datos.</p>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $codInicio += 6;
    }
    ?>

    <!-- FASE FINAL -->
    <div class="modern-card">
        <h3>Fase Final</h3>
        <div class="fase-final">
            <div class="ronda">
                <h4>Dieciseisavos de final</h4>
                <?php
                for ($i = 73; $i <= 88; $i++) {
                    mostrarPartidoKo($i, "$i", $koMatches);
                }
                ?>
            </div>
            <div class="ronda">
                <h4>Octavos de final</h4>
                <?php
                for ($i = 89; $i <= 96; $i++) {
                    mostrarPartidoKo($i, "$i", $koMatches);
                }
                ?>
            </div>
            <div class="ronda">
                <h4>Cuartos de final</h4>
                <?php
                for ($i = 97; $i <= 100; $i++) {
                    mostrarPartidoKo($i, "$i", $koMatches);
                }
                ?>
            </div>
            <div class="ronda">
                <h4>Semifinales</h4>
                <?php
                for ($i = 101; $i <= 102; $i++) {
                    mostrarPartidoKo($i, "$i", $koMatches);
                }
                ?>
            </div>
            <div class="ronda">
                <h4>Tercer puesto</h4>
                <?php
                mostrarPartidoKo(103, "103", $koMatches);
                ?>
            </div>
            <div class="ronda">
                <h4>Final</h4>
                <?php
                mostrarPartidoKo(104, "104", $koMatches);
                ?>
            </div>
            <div class="ronda extras">
                <h4>Extras</h4>
                <div class="partido-ko">
                    <strong>Campeón:</strong> <?php echo equipoConBandera($koMatches[105]['local'] ?? ''); ?><br>
                    <strong>Tercero:</strong> <?php echo equipoConBandera($koMatches[105]['visitante'] ?? ''); ?><br>
                    <strong>Goleador:</strong> <?php echo htmlspecialchars($koMatches[106]['local'] ?? '', ENT_QUOTES); ?> (<?php echo equipoConBandera($koMatches[106]['visitante'] ?? ''); ?>)
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; margin: 20px 0;">
        <a href="empezar.php" class="btn-small">Volver</a>
    </div>
</div>
<?php require_once('footer.php'); ?>