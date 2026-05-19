<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$uActual = $_SESSION['MM_Username'] ?? '';
if (strcasecmp($uActual, 'ProfetaMundial') !== 0) {
  header("Location: index.php");
  exit;
}

$resultadoProceso = null;
$detalles = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['MM_update'] ?? '') === 'puntuar2026') {
  $qUsuarios = "SELECT U.usuario
                FROM Torneos T
                JOIN usuarios U ON U.usuario=T.inscriptos
                WHERE T.CodTor='20'
                  AND U.usuario<>'ProfetaMundial'
                ORDER BY U.usuario";
  $rsUsuarios = mysqli_query($conexion, $qUsuarios) or die(mysqli_error($conexion));

  $totalUsuarios = 0;
  $actualizados = 0;

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

  while ($u = mysqli_fetch_assoc($rsUsuarios)) {
    $usuario = $u['usuario'];
    $uEsc = mysqli_real_escape_string($conexion, $usuario);

    // --- Partidos (igual que antes) ---
    $qResGrupos = "SELECT COUNT(*) AS puntos
                   FROM partidos_mundial2026 pp
                   JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
                   WHERE ps.CodUsu='".$uEsc."'
                     AND pp.CodUsu='ProfetaMundial'
                     AND pp.resultado=ps.resultado
                     AND pp.CodPar BETWEEN 1 AND 72
                     AND pp.glocal!=99";
    $rResGrupos = mysqli_query($conexion, $qResGrupos) or die(mysqli_error($conexion));
    $fResGrupos = mysqli_fetch_assoc($rResGrupos);

    $qExactGrupos = "SELECT COUNT(*) AS puntos
                     FROM partidos_mundial2026 pp
                     JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
                     WHERE ps.CodUsu='".$uEsc."'
                       AND pp.CodUsu='ProfetaMundial'
                       AND pp.resultado=ps.resultado
                       AND pp.CodPar BETWEEN 1 AND 72
                       AND pp.glocal=ps.glocal
                       AND pp.gvisitante=ps.gvisitante
                       AND pp.glocal!=99";
    $rExactGrupos = mysqli_query($conexion, $qExactGrupos) or die(mysqli_error($conexion));
    $fExactGrupos = mysqli_fetch_assoc($rExactGrupos);

    $qResKo = "SELECT COUNT(*) AS puntos
               FROM partidos_mundial2026 pp
               JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
               WHERE ps.CodUsu='".$uEsc."'
                 AND pp.CodUsu='ProfetaMundial'
                 AND pp.resultado=ps.resultado
                 AND pp.CodPar BETWEEN 73 AND 104
                 AND pp.local=ps.local
                 AND pp.visitante=ps.visitante
                 AND pp.glocal!=99";
    $rResKo = mysqli_query($conexion, $qResKo) or die(mysqli_error($conexion));
    $fResKo = mysqli_fetch_assoc($rResKo);

    $qExactKo = "SELECT COUNT(*) AS puntos
                 FROM partidos_mundial2026 pp
                 JOIN partidos_mundial2026 ps ON pp.CodPar=ps.CodPar
                 WHERE ps.CodUsu='".$uEsc."'
                   AND pp.CodUsu='ProfetaMundial'
                   AND pp.resultado=ps.resultado
                   AND pp.CodPar BETWEEN 73 AND 104
                   AND pp.local=ps.local
                   AND pp.visitante=ps.visitante
                   AND pp.glocal=ps.glocal
                   AND pp.gvisitante=ps.gvisitante
                   AND pp.glocal!=99";
    $rExactKo = mysqli_query($conexion, $qExactKo) or die(mysqli_error($conexion));
    $fExactKo = mysqli_fetch_assoc($rExactKo);

    $exactos = intval($fExactGrupos['puntos'] ?? 0) + intval($fExactKo['puntos'] ?? 0);
    $pExactos = $exactos * 5;
    $partidosGrupos = intval($fResGrupos['puntos'] ?? 0) - intval($fExactGrupos['puntos'] ?? 0);
    $partidosKo = intval($fResKo['puntos'] ?? 0) - intval($fExactKo['puntos'] ?? 0);
    $pPartidosKo = $partidosKo * 2;
    $puntosPartidos = $pExactos + $partidosGrupos + $pPartidosKo;

    // --- Extras: equipos en cada fase (con condiciones de fase completa) ---
    function equiposEnRango($conexion, $usuario, $inicio, $fin) {
      $u = mysqli_real_escape_string($conexion, $usuario);
      $q = "SELECT local as equipo FROM partidos_mundial2026 WHERE CodUsu='$u' AND CodPar BETWEEN $inicio AND $fin
            UNION
            SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$u' AND CodPar BETWEEN $inicio AND $fin";
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

    $usrFinal = equiposEnRango($conexion, $usuario, 104, 104);
    $realFinal = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 104, 104) : [];
    $ptsFinal = count(array_intersect($usrFinal, $realFinal));

    $usrTercer = equiposEnRango($conexion, $usuario, 103, 103);
    $realTercer = faseCompleta($conexion, 101, 102) ? equiposEnRango($conexion, 'ProfetaMundial', 103, 103) : [];
    $ptsTercer = count(array_intersect($usrTercer, $realTercer));

    $puntosFases = $pts16 + $ptsOct + $ptsCuartos + $ptsSemis + $ptsFinal + $ptsTercer;

    // --- Extras: campeón, goleador, tercer puesto (partidos 105 y 106) ---
    $qCampeonReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
    $rCampeonReal = mysqli_query($conexion, $qCampeonReal);
    $campeonReal = mysqli_fetch_assoc($rCampeonReal)['local'] ?? '';

    $qTerceroReal = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=105";
    $rTerceroReal = mysqli_query($conexion, $qTerceroReal);
    $terceroReal = mysqli_fetch_assoc($rTerceroReal)['visitante'] ?? '';

    $qGoleadorReal = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='ProfetaMundial' AND CodPar=106";
    $rGoleadorReal = mysqli_query($conexion, $qGoleadorReal);
    $goleadorReal = mysqli_fetch_assoc($rGoleadorReal)['local'] ?? '';

    $qCampeonUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
    $rCampeonUsr = mysqli_query($conexion, $qCampeonUsr);
    $campeonUsr = mysqli_fetch_assoc($rCampeonUsr)['local'] ?? '';

    $qTerceroUsr = "SELECT visitante FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=105";
    $rTerceroUsr = mysqli_query($conexion, $qTerceroUsr);
    $terceroUsr = mysqli_fetch_assoc($rTerceroUsr)['visitante'] ?? '';

    $qGoleadorUsr = "SELECT local FROM partidos_mundial2026 WHERE CodUsu='$uEsc' AND CodPar=106";
    $rGoleadorUsr = mysqli_query($conexion, $qGoleadorUsr);
    $goleadorUsr = mysqli_fetch_assoc($rGoleadorUsr)['local'] ?? '';

    $puntosCampeon = ($campeonUsr == $campeonReal && !empty($campeonReal)) ? 15 : 0;
    $puntosTercero = ($terceroUsr == $terceroReal && !empty($terceroReal)) ? 5 : 0;
    $puntosGoleador = ($goleadorUsr == $goleadorReal && !empty($goleadorReal)) ? 10 : 0;

    $total = $puntosPartidos + $puntosFases + $puntosCampeon + $puntosTercero + $puntosGoleador;

    // Actualizar en BD
    $qUpd = "UPDATE usuarios SET puntos='".intval($total)."' WHERE usuario='".$uEsc."'";
    mysqli_query($conexion, $qUpd) or die(mysqli_error($conexion));

    $totalUsuarios++;
    $actualizados++;
    $detalles[] = [
      'usuario' => $usuario,
      'puntos' => $total,
      'partidos' => $puntosPartidos,
      'fases' => $puntosFases,
      'campeon' => $puntosCampeon,
      'tercero' => $puntosTercero,
      'goleador' => $puntosGoleador
    ];
  }

  $resultadoProceso = [
    'totalUsuarios' => $totalUsuarios,
    'actualizados' => $actualizados,
  ];
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Puntuar Mundial 2026</title>
  <link href="estilo.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<div class="cabecera">
  <div style="width: 300px; float:left;" class="nada">
    <a href="empezar.php"><img src="imagenes/profetamundial.png" class="nada" width="171" height="57" alt="Profeta Mundial" /></a>
  </div>
  <div class="loginiz">
    <p>USUARIO: <?php echo htmlspecialchars($uActual, ENT_QUOTES, 'UTF-8'); ?></p>
    <a href="<?php echo $logoutAction; ?>" class="botoneschicos">Desconectarse</a>
  </div>
  <div style="clear:both;"></div>
</div>

<br />
<div class="contenedora">
  <p class="letrasmasgrandes">Puntuar Mundial 2026</p>

  <div class="tablaclasificacion">
    <div class="comentarios" style="text-align:left;">
      <p>Este proceso recalcula y guarda puntos para todos los inscriptos al torneo Mundial 2026 (CodTor 20), comparando contra <b>ProfetaMundial</b>.</p>
      <form method="post" action="#">
        <input type="hidden" name="MM_update" value="puntuar2026" />
        <input type="submit" class="botones" value="Puntuar a todos los usuarios (Mundial 2026)" />
      </form>
    </div>
  </div>

  <?php if ($resultadoProceso !== null) { ?>
    <div class="tablaclasificacion">
      <div class="comentarios" style="text-align:left;">
        <p><b>Proceso finalizado.</b></p>
        <p>Usuarios evaluados: <?php echo intval($resultadoProceso['totalUsuarios']); ?></p>
        <p>Usuarios actualizados: <?php echo intval($resultadoProceso['actualizados']); ?></p>
      </div>
    </div>

    <div class="tablaclasificacion">
      <div class="comentarios" style="text-align:left;">
        <p><b>Detalle:</b></p>
        <table style="width:100%; border-collapse:collapse;">
          <tr style="background:#ccc; color:#000;">
            <th>Usuario</th><th>Total</th><th>Partidos</th><th>Fases</th><th>Campeón</th><th>3er puesto</th><th>Goleador</th>
          </tr>
          <?php foreach ($detalles as $d) { ?>
            <tr style="background:#eee; color:#000;">
              <td><?php echo htmlspecialchars($d['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo intval($d['puntos']); ?></td>
              <td><?php echo intval($d['partidos']); ?></td>
              <td><?php echo intval($d['fases']); ?></td>
              <td><?php echo intval($d['campeon']); ?></td>
              <td><?php echo intval($d['tercero']); ?></td>
              <td><?php echo intval($d['goleador']); ?></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  <?php } ?>

  <br />
  <a href="mundial2026.php" class="botoneschicos">Volver a Mundial 2026</a>
  <a href="index.php" class="botoneschicos">Ir al ranking</a>
</div>
</body>
</html>