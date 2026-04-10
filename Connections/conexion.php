<?php

$host = 'mysql-server';
$user = 'root';
$pass = 'rootpassword123';
$db   = 'profetamundial';
$database_conexion = $db;

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error() . " (Código: " . mysqli_connect_errno() . ")");
}

?>