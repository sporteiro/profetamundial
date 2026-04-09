<?php require_once('Connections/conexion.php'); 
mysql_select_db($database_conexion, $conexion);
$query_enlinea= "SELECT * FROM usuarios WHERE trofeos!='' ORDER BY credito DESC;";
$enlinea= mysql_query($query_enlinea, $conexion) or die(mysql_error());
$totalRows_enlinea= mysql_num_rows($enlinea);?>
<div>
		<?php while ($row_enlinea = mysql_fetch_assoc($enlinea)) {?>			
			<img src="imagenes/avatares/<?php echo $row_enlinea['avatar'];?>" height="32" width="32" alt=""/> <b><?php echo $row_enlinea['usuario'];?></b> :		
			<div class="comentarios"> 
				<?php echo $row_enlinea['trofeos'];?>		
			</div>
		<?php } ?>
</div>

