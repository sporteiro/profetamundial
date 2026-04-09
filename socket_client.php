<?php
//Sebastian 2018 socket para ver los usuarios conectados
try	{
	if (isset ($_SESSION['MM_Username']))	{
		$user=$_SESSION['MM_Username'];
	}
	else	{
		$user='unknown';
	}
	$host    = "127.0.0.1";
	$port    = 25013;
	$message = $user;
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("No se pudo crear socket\n");
	$result = socket_connect($socket, $host, $port) or die("No se pudo conectar al servidor\n");  
	socket_write($socket, $message, strlen($message)) or die("No se pudieron enviar datos\n");
	$result = socket_read ($socket, 1024) or die("No se pudo leer respuesta del servidor\n");
	//echo $result;
	socket_close($socket);
	} 
	catch (Exception $e) {
	    echo 'No se pudo usar el socket: ',  $e->getMessage(), "\n";
}

?>
