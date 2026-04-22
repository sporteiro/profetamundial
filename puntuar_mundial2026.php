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

  while ($u = mysqli_fetch_assoc($rsUsuarios)) {
    $usuario = $u['usuario'];
    $uEsc = mysqli_real_escape_string($conexion, $usuario);

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
    $total = $pExactos + $partidosGrupos + $pPartidosKo;

    $qUpd = "UPDATE usuarios
             SET puntos='".intval($total)."'
             WHERE usuario='".$uEsc."'";
    mysqli_query($conexion, $qUpd) or die(mysqli_error($conexion));

    $totalUsuarios++;
    $actualizados++;
    $detalles[] = [
      'usuario' => $usuario,
      'puntos' => $total,
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
        <?php foreach ($detalles as $d) { ?>
          <div><?php echo htmlspecialchars($d['usuario'], ENT_QUOTES, 'UTF-8'); ?>: <?php echo intval($d['puntos']); ?> puntos</div>
        <?php } ?>
      </div>
    </div>
  <?php } ?>

  <br />
  <a href="mundial2026.php" class="botoneschicos">Volver a Mundial 2026</a>
  <a href="index.php" class="botoneschicos">Ir al ranking</a>
</div>
</body>
</html>
