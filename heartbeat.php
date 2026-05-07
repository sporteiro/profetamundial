<?php
require_once('Connections/conexion.php');
session_start();

if (isset($_SESSION['MM_Username'])) {
    $user = mysqli_real_escape_string($conexion, $_SESSION['MM_Username']);
    $q = "UPDATE usuarios SET ultima_actividad = NOW() WHERE usuario = '$user'";
    mysqli_query($conexion, $q);
    echo "ok";
} else {
    echo "no session";
}
?>