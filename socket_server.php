<?php
$host = "127.0.0.1";
$port = 25013;
$user_list=array();
set_time_limit(0);
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
    echo socket_strerror(socket_last_error($socket));
    exit;
} 
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
while(true) {
  $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
  $input = socket_read($spawn, 1024) or die("Could not read input\n");
  if (!$input){
    $input = "unknown";
  }
  else	{
	if ($input!='unknown')	{
	  	array_push($user_list,$input);
		$user_list = array_unique($user_list);
	}
  }
  $error=socket_last_error();
  echo "Error: \n";
  print_r($error);
  echo $input.PHP_EOL;
 // $output = $input . "\n";

  if ($user_list=='')	{
	array_push($user_list,'Nadie conectado');
 }
  foreach ($user_list as $output)	{
	$output=$output.'-';
  	socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
  }
  socket_close($spawn);
  sleep(2);
/*if ($input=='unknown')	{
	foreach ($user_list as $user)	{
		require_once('Connections/conexion.php'); 
		mysql_select_db($database_conexion, $conexion);
		mysql_query("UPDATE usuarios SET enlinea='no' WHERE usuario!='".$user."'") or die(mysql_error());
		sleep(2);
		echo "Desconectando $user en BD\n";
	}
	$user_list=array();
	//mysql_query("UPDATE usuarios SET enlinea='si' WHERE usuario='".$input."'") or die(mysql_error());
	//echo "Actualizado en DB\n";
}*/
echo "Socket on\n";
$error=socket_last_error();
echo "Error:\n";
print_r($error);
print_r($user_list);
}
?>
