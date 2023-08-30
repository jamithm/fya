<?php 
	require('../Connections/conexion.php');
	require('../Connections/conex.php');
	if (count($_POST)!=0){
  		$email = $_POST['email'];
  		$mensaje="";
    
	  	$sql="SELECT * FROM t_usuarios WHERE email = '" .$email. "'";
	  
	  	$result=mysql_query($sql,$conexion);
	  	if($row=mysql_fetch_array($result)){
		  	$password = NuevaContrasena(8);
			
			$consulta = "UPDATE t_usuarios SET contrasena = '$password' WHERE email = '$email'";
			$resultado=mysql_query($consulta,$conexion);
			if($resultado==1){		
				
				$destino = $email;
				$asunto = "Cambio de Contraseña";
				
$cuerpo = 'Se ha recibido la confirmación de cambio de contraseña en nuestro sistema con los siguientes datos:
Nombre: '. $row["nombre"] .'
Nueva Contraseña:  '. $password.'
Email: '.$email.'

Se recomienda que cambie esta contraseña, cuando ingrese a la administración.
				
No responda a este correo, ya que es enviado automáticamente por el sistema.
				
CándidaMaria de Jesús Fe y Alegría.
				
				
Gracias!';
						
				if(mail($destino, $asunto, $cuerpo)){
					header('location:recuperar_ok.php');
				}
				else{ 
					header('location:recuperar_error.php');
				}
			}
			/*else {
				echo "Error al Actualizar Contraseña";
			}*/		
		}
	  	else
	  	{
			header('location:recuperar_error_email.php');
	  	}
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administraci&oacute;n</title>
    <link href="../css/efecto.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="../images/logo-original.png" />
	<!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
</head>
<body>
    <div class="alert alert-danger" align="center"><strong>CÁNDIDA MARÍA DE JESÚS FE Y ALEGRÍA</strong></div>
    <div class="container">
         <div class="row">
                 </div>
                 <div class="panel-body">
                 <form name="form1" id="form1" action="" method="post" autocomplete="off"><br/>
                 <center><img src="../images/logo-original.png" width="90" height="75">
                 <img src="../images/logo_nuevo.png" width="90" height="75"></center>
                 <h3 align="center" class="color"><strong>Recuperar Contraseña</strong></h3><hr/>
                 <div class="form-group input-group">
                 <span class="input-group-addon">@</span>
                 <input name="email" id="email" type="email" class="form-control" placeholder="Ingrese su Email" required/>
                 </div>
                 <button type="submit" name="acceder" id="acceder" class="btn btn-success">
                <span class="glyphicon glyphicon-ok"></span>
                Recuperar Contraseña
                </button>
                <hr />
<label class="color">¿Si esta registrado?</label> 
<a href="index.php">Ir al Login</a>
                 </form>   
        </div>
    </div>
	<script language="javascript">
		document.form1.email.focus();
	</script>

     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>