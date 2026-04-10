<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$verlode = isset($_GET['verlode']) ? $_GET['verlode'] : '';
$verlodeEsc = mysqli_real_escape_string($conexion, $verlode);

$qUser = "SELECT * FROM usuarios WHERE usuario='".$verlodeEsc."'";
$rsUser = mysqli_query($conexion, $qUser) or die(mysqli_error($conexion));
$rowUser = mysqli_fetch_assoc($rsUser);

$q = "SELECT CodPar, local, visitante, glocal, gvisitante
      FROM partidos_mundial2026
      WHERE CodUsu='".$verlodeEsc."'
      ORDER BY CodPar";
$rs = mysqli_query($conexion, $q) or die(mysqli_error($conexion));
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ver Mundial 2026</title>
  <link href="estilo.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<div class="contenedora">
  <p class="letrasmasgrandes">Pronóstico Mundial 2026 - <?php echo htmlspecialchars($rowUser['usuario'] ?? $verlode, ENT_QUOTES); ?></p>
  <div class="tablaclasificacion">
    <table style="width:100%;">
      <tr class="comentarios">
        <td>CodPar</td>
        <td>Local</td>
        <td>GL</td>
        <td>GV</td>
        <td>Visitante</td>
      </tr>
      <?php while ($m = mysqli_fetch_assoc($rs)) { ?>
        <tr class="comentarios">
          <td><?php echo intval($m['CodPar']); ?></td>
          <td><?php echo htmlspecialchars($m['local'], ENT_QUOTES); ?></td>
          <td class="alignright"><?php echo intval($m['glocal']); ?></td>
          <td class="alignright"><?php echo intval($m['gvisitante']); ?></td>
          <td><?php echo htmlspecialchars($m['visitante'], ENT_QUOTES); ?></td>
        </tr>
      <?php } ?>
    </table>
  </div>

  <p><a href="empezar.php" class="botones">Volver</a></p>
</div>
</body>
</html>

