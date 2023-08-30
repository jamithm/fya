<?php 
	$destino  = "mercadojamith@gmail.com";
	$nombre   = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$correo   = $_POST['correo'];
	$asunto   = $_POST['asunto']; 
	$mensaje  = $_POST['mensaje'];

	$contenido = "Nombre: " . $nombre . 
	"\nCorreo: " . $correo . 
	"\nTelefono: " . $telefono . 
	"\nAsunto: " . $asunto . 
	"\nMensaje: " . $mensaje;
	
	if(mail($destino, $asunto, $contenido))
		echo '<script language = "javascript">
		alert("Enviado Correctamente\nPronto se le dara respuesta...!");
		window.location="contactos.php";
		</script>';
	else 
		echo '<script language = "javascript">
		alert("Fallo de envio...!");
		window.location="contactos.php";
		</script>';
	
?>