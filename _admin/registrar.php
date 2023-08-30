<?php 
require_once('../Connections/conex.php'); 

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$nivel = 0;
	$estado = 0;
	$activacion = CodigoActivacion(6);
  	$foto = "logo-original.png";
	
  	$insertSQL = sprintf("INSERT INTO t_usuarios (nombre, email, contrasena, nivel, estado, activacion, foto) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
					   GetSQLValueString($nivel, "int"),
					   GetSQLValueString($estado, "int"),
					   GetSQLValueString($activacion, "text"),
					   GetSQLValueString($foto, "text"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($insertSQL, $conex) or die(mysql_error());

  $insertGoTo = "registro_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  	$destino = $_POST['email'];
	$asunto  = "Link de Activación de Usuario";
	$mensaje = '<html lang="es">'
			.'<head>'
			.'<title>Link de Activación</title>'
			.'<meta=charset="utf-8"/>'
			.'</head>'
			.'<body>'
			.'Gracias por registrarse, para poder acceder a la administración<br/>'
			.'debe activar su cuenta debe hacer clic en el siguiente enlace:<br/>'
			.'<a href="http://fyacandidamaria.comlu.com/_admin/link_activacion.php?link='.$activacion.'">Activar Cuenta</a>';
	$mensaje.'</body>'
			.'</html>';
			
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	
	mail($destino, $asunto, $mensaje, $cabeceras);
  header(sprintf("Location: %s", $insertGoTo));
  
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administración</title>
    <link rel="shortcut icon" href="../images/logo-original.png" />
    <link href="../css/efecto.css" rel="stylesheet" type="text/css" />
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
        <div class="row text-center  ">
        </div>
         <div class="row">
               
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                                <form method="POST" action="<?php echo $editFormAction; ?>" role="form" name="form1" id="form1" autocomplete="off"><br/>
                                <center><img src="../images/logo-original.png" width="90" height="75">
                                <img src="../images/logo_nuevo.png" width="90" height="75"></center>
                        		<h3 align="center" class="color"><strong>Ingrese sus Datos</strong></h3><hr/>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                            <input name="nombre" type="text" class="form-control" placeholder="Ingrese su Nombre" required />
                                        </div>
                                         <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            <input name="email" type="email" class="form-control" placeholder="Ingrese su Email" required />
                                        </div>
                                      <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input name="contrasena" type="password" class="form-control" placeholder="Ingrese su Contraseña" required />
                                  	</div>
                                     <button type="submit" class="btn btn-success">Registrarme
                                     <span class="glyphicon glyphicon-user"></span>
                                     </button>
                                    <hr />
                                    <label class="color">Si ya estás registrado?</label><a href="index.php">Ir al Login</a>
                                    <input type="hidden" name="MM_insert" value="form1">
                  </form>    
      </div>
    </div>
   	<script language="javascript">
		document.form1.nombre.focus();
	</script>
     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
   
</body>
</html>
