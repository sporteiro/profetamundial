<?php
$user = isset($_GET['username']) ? $_GET['username'] : '';
require_once('Connections/conexion.php'); 
mysqli_query($conexion, "UPDATE usuarios SET enlinea='no' WHERE usuario='".mysqli_real_escape_string($conexion, $user)."'") or die(mysqli_error($conexion));

//print_r(scandir(session_save_path()));
//Sebastian 2018 detectar que usuario se desconecta
/*
//Sebastian 2018 socket para ver los usuarios conectados
try	{
	//Sebastian 2018 detectar que usuario se desconecta
	function check_abort() {
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
		if (connection_aborted())	{
			socket_write($socket, 'ooooooo', strlen($message)) or die("No se pudieron enviar datos\n");
			socket_close($socket);
		}
		else	{
			socket_write($socket, 'aa', strlen($message)) or die("No se pudieron enviar datos\n");
			register_shutdown_function("check_abort");
			$result = socket_read ($socket, 1024) or die("No se pudo leer respuesta del servidor\n");
			//echo $result;

			socket_close($socket);
		}
	} 
	while(True)	{
		check_abort();
		sleep(5);
	}
}
catch (Exception $e) {
	   echo 'No se pudo usar el socket: ',  $e->getMessage(), "\n";
}
*/
?>
