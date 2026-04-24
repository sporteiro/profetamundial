<?php
$es_local = isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1');

// $es_local = false;

if ($es_local) {
    $host = 'mysql-server';
    $user = 'root';
    $pass = 'rootpassword123';
    $db   = 'profetamundial';
} else {
    require __DIR__.'/conexion_remota.php';
    if (is_object($pass) && $pass instanceof SensitiveParameterValue) {
        $pass = (new ReflectionProperty($pass, 'value'))->getValue($pass);
    }
}

try {
    $conexion = mysqli_connect($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    if ($es_local) die("Error DB local: " . $e->getMessage());
    else die("ERROR: DB connection error. Check credentials");
}

$database_conexion = $db;
if (file_exists(__DIR__.'/mysql_compat.php')) require __DIR__.'/mysql_compat.php';
?>