<?php
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
	$hostname_conexion = "localhost";
	$database_conexion = "profeta";
	$username_conexion = "profeta";
	$password_conexion = "profeta";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);

?>
