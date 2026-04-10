<?php require_once('Connections/conexion.php'); ?>
<?php require_once('codlog.php'); ?>
<?php
$user = $_SESSION['MM_Username'];
$q = "SELECT CodPar, local, visitante, glocal, gvisitante
      FROM partidos_mundial2026
      WHERE CodUsu='".mysqli_real_escape_string($conexion, $user)."'
      ORDER BY CodPar";
$rs = mysqli_query($conexion, $q) or die(mysqli_error($conexion));
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Imprimir Mundial 2026</title>
  <link href="estilo.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="favicon.ico"/>
</head>
<body>
<div class="contenedora">
  <p class="letrasmasgrandes">Pronóstico Mundial 2026 - <?php echo htmlspecialchars($user, ENT_QUOTES); ?></p>
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
</div>
</body>
</html>

