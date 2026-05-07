<?php
require_once('Connections/conexion.php');
session_start();

$tiempo_limite = 2; // minutos
$user_actual = $_SESSION['MM_Username'] ?? '';

$q = "SELECT usuario FROM usuarios 
    WHERE enlinea = 'si' 
    AND ultima_actividad > DATE_SUB(NOW(), INTERVAL 2 MINUTE)
    AND usuario != '".$user_actual."'
    ORDER BY usuario";
$r = mysqli_query($conexion, $q);
$conectados = [];
while ($row = mysqli_fetch_assoc($r)) {
    $conectados[] = $row['usuario'];
}

// Devolver en formato JSON (para AJAX)
header('Content-Type: application/json');
echo json_encode($conectados);
?>