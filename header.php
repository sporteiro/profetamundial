<?php
// =====================================================
// header.php – Cabecera moderna unificada (enlaces de texto)
// =====================================================
if (!isset($_SESSION)) {
    session_start();
}

global $conexion;
if (!isset($conexion) || !$conexion) {
    require_once('Connections/conexion.php');
}

$usuario_data = null;
if (isset($_SESSION['MM_Username'])) {
    $u = mysqli_real_escape_string($conexion, $_SESSION['MM_Username']);
    $q = "SELECT usuario, credito, avatar FROM usuarios WHERE usuario = '$u'";
    $r = mysqli_query($conexion, $q);
    if ($r && mysqli_num_rows($r) > 0) {
        $usuario_data = mysqli_fetch_assoc($r);
    }
}

$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilo.css" rel="stylesheet" type="text/css">
    <script src="jquery.js" type="text/javascript"></script>
</head>
<body>

<div class="modern-header">
    <div class="logo">
        <a href="empezar.php"><img src="imagenes/profetamundial.png" alt="Profeta Mundial"></a>
    </div>
    <div class="user-info">
        <?php if ($usuario_data): ?>
            USUARIO: <strong><?php echo htmlspecialchars($usuario_data['usuario']); ?></strong> | Crédito: <?php echo $usuario_data['credito']; ?>&phi;<br>
            <a href="modificar.php" class="header-link">Mi cuenta</a> | 
            <a href="<?php echo $logoutAction; ?>" class="header-link">Desconectarse</a>
        <?php else: ?>
            <a href="index.php" class="header-link">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</div>

<div class="main-container"></div>