<?php require_once('Connections/conexion.php'); 
session_start();
mysql_select_db($database_conexion, $conexion);
mysql_query("UPDATE usuarios SET enlinea='si' WHERE usuario='".$_SESSION['MM_Username']."'") or die(mysql_error());
$query_enlinea= "SELECT * FROM usuarios WHERE enlinea='si' AND usuario !='".$_SESSION['MM_Username']."';";
$enlinea= mysql_query($query_enlinea, $conexion) or die(mysql_error());
$totalRows_enlinea= mysql_num_rows($enlinea);?>
<?php //require_once('socket_client.php');
//$result = preg_split('/-/', $result, null, PREG_SPLIT_NO_EMPTY);
$user=$_SESSION['MM_Username'];
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php if ($totalRows_enlinea>0)	{ ?>
Usuarios Conectados: 
<div class="comentarios" id="conectados" style="display:none;">
		<?php while ($row_enlinea = mysql_fetch_assoc($enlinea)) {?>
			<div> 
			<div class="puntoverde"> </div>  &nbsp;<?php echo $row_enlinea['usuario'];?>	
			</div>
		<?php } ?>
		<?php// foreach($result as $usuario_enlinea) {?>
			<!--<div> 
				<div class="puntoverde"> </div>  &nbsp;<?php echo $usuario_enlinea;?>		
			</div>-->
		<?php //} ?>
</div>
<?php }; ?>
<script type="text/javascript"> 
$(document).ready(function(){	
	$(document).ready(function () {
		$('#conectados').fadeIn(1000);
      }); 
});
$(window).unload(function() {
	desactivarUsuario();
});
function desactivarUsuario()	{	
	var user='<?php echo $user; ?>';
	$.ajax({
	    type: 'GET',
	    async: false,
	    url: 'connection_aborted.php?username='+user
	    });
}
</script> 
</body>
</html>
