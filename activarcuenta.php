<?php require_once('Connections/conexion.php'); ?>
<?php 
if (isset($_GET['codigo'])) {
	$todo = $_GET['codigo'];
	$explotar = explode("profeta", $todo);
	$usuario = $explotar['0'];
	$ip = $explotar['1'];
		try {
			mysql_select_db($database_conexion);
			$consulta=mysql_query("SELECT * FROM usuarios WHERE usuario='".$usuario."' and ip='".$ip."';") or die(mysql_error());
			$filas=mysql_fetch_assoc($consulta);
			$numerofilas=mysql_num_rows($consulta);
			if ($numerofilas>0) {
				mysql_query("update usuarios set activo='si' where usuario='".$usuario."' and ip='".$ip."';") or die(mysql_error());
				echo "cuenta activada";
				session_start();
				$_SESSION['MM_Username']=$usuario;
				$_SESSION['MM_UserGroup']='';
				header('Location: empezar.php');
				}
				else {
				header('Location: index.php');
				$r="error";			
						
			}
		}
		catch(Exeption $r) {	
			echo "error";	
		}
	}
else {
	echo "No se pudo activar nada";	
}
?>


