<?php
require_once('Connections/conexion.php');

// Traer todos los usuarios con trofeos
$query = "SELECT usuario, trofeos, avatar, puntos 
          FROM usuarios 
          WHERE trofeos != '' AND trofeos IS NOT NULL";
$result = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

$usuarios = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Contar cuántas etiquetas <img hay en trofeos
    $cantidad = substr_count($row['trofeos'], '<img');
    $usuarios[] = [
        'usuario' => $row['usuario'],
        'trofeos' => $row['trofeos'],
        'avatar'  => $row['avatar'],
        'puntos'  => $row['puntos'],
        'cantidad' => $cantidad
    ];
}

// Ordenar por cantidad descendente, luego por puntos descendente
usort($usuarios, function($a, $b) {
    if ($a['cantidad'] != $b['cantidad']) {
        return $b['cantidad'] - $a['cantidad'];
    }
    return $b['puntos'] - $a['puntos'];
});
?>
<div class="trofeos-modern">
    <?php foreach ($usuarios as $u): ?>
        <div class="trofeo-item">
            <div class="trofeo-usuario">
                <img src="imagenes/avatares/<?php echo htmlspecialchars($u['avatar']); ?>" width="32" height="32" class="trofeo-avatar" alt="avatar">
                <strong><?php echo htmlspecialchars($u['usuario']); ?></strong>
            </div>
            <div class="trofeo-lista">
                <?php echo $u['trofeos']; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>