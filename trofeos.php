<?php require_once('Connections/conexion.php'); 
$query_enlinea= "SELECT * FROM usuarios WHERE trofeos!='' ORDER BY credito DESC;";
$enlinea= mysqli_query($conexion, $query_enlinea) or die(mysqli_error($conexion));
$totalRows_enlinea= mysqli_num_rows($enlinea);?>
<div>
		<?php while ($row_enlinea = mysqli_fetch_assoc($enlinea)) {?>			
			<img src="imagenes/avatares/<?php echo $row_enlinea['avatar'];?>" height="32" width="32" alt=""/> <b><?php echo $row_enlinea['usuario'];?></b> :		
			<div class="comentarios"> 
				<?php echo $row_enlinea['trofeos'];?>		
			</div>
		<?php } ?>
</div>

