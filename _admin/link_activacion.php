<?php require_once('../Connections/conexion.php'); ?>
<?php 
	$estado = 1;
	$codigo = $_GET['link'];
	
	$sql= "UPDATE t_usuarios SET estado = $estado WHERE activacion = '$codigo'";				

		$result=mysql_query($sql,$conexion);
		if($result==1){
			header('location:index.php');
			
		}
		else {
			echo "Error al  Guardar Registro...!";
			
		}	
	
	
?>