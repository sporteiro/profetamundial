<?php
$hostname_conexion = getenv('MYSQL_HOST') ?: 'mysql-server';
$database_conexion = getenv('MYSQL_DATABASE') ?: 'profetamundial';
$username_conexion = getenv('MYSQL_USER') ?: 'root';
$password_conexion = getenv('MYSQL_PASSWORD') ?: 'rootpassword123';

$conexion = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion, $database_conexion);

if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

require_once __DIR__ . '/../../Connections/mysql_compat.php';

?>
