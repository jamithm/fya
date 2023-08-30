<?php 
	include('../Connections/conexion.php');
	$fkgaleria = $_POST['id'];
	$estado    = 'Visible';
	$posicion = 9;

	foreach($_POST['titulo'] as $indice=>$titulo){
		$nombre_tmp = md5(mktime().$_FILES['archivo']['tmp_name'][$indice]);
		$nombre_file = $nombre_tmp.'.jpg';	
	
		$sql = "INSERT INTO t_fotos(nombre, archivo, posicion, estado, id_galeria) VALUE('$titulo', '$nombre_file', $posicion, '$estado', $fkgaleria)";
		
		$query = mysql_query($sql,$conexion);
		
		$original = $_FILES['archivo']['tmp_name'][$indice];
		$destino = "../fotos/".$nombre_file;
		move_uploaded_file($original, $destino);
		
	}
	
	header("Location: listado_galerias_fotos.php");

?>