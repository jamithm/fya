<?php require_once('../Connections/conex.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
		$imagen = $_FILES['imagen']['name'];
		move_uploaded_file($_FILES['imagen']['tmp_name'],"../fotos/".$imagen);
		
		if(isset($imagen)&&($imagen!="")){
			$imgNew = $imagen;
		} else{
			$imgNew = $_POST['img2'];	
		}
	
  $updateSQL = sprintf("UPDATE t_usuarios SET nombre=%s, email=%s, contrasena=%s, foto=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
					   GetSQLValueString($imgNew, "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($updateSQL, $conex) or die(mysql_error());

  $updateGoTo = "usuario_modificado_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varUsuario_DatosUsuario = "0";
if (isset($_SESSION["MM_idUsuario"])) {
  $varUsuario_DatosUsuario = $_SESSION["MM_idUsuario"];
}
mysql_select_db($database_conex, $conex);
$query_DatosUsuario = sprintf("SELECT * FROM t_usuarios WHERE t_usuarios.id=%s", GetSQLValueString($varUsuario_DatosUsuario, "int"));
$DatosUsuario = mysql_query($query_DatosUsuario, $conex) or die(mysql_error());
$row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysql_num_rows($DatosUsuario);
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/Admininstracion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Administraci�n</title>
    <!-- InstanceEndEditable -->
    <link rel="shortcut icon" href="../images/logo-original.png" />
	<!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="../assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
   
   <!-- InstanceBeginEditable name="head" -->
   <!-- InstanceEndEditable -->
</head>
<body>
    <div id="wrapper">
           <?php include("../includes/adm-toolbar.php"); ?>
      <!-- /. NAV TOP  -->
           <?php include("../includes/adm-menu.php"); ?>      
        <!-- /. NAV SIDE  --><!-- InstanceBeginEditable name="Contenido" -->
        <div id="page-wrapper" >
          <div id="page-inner">
            <div class="row">
              <div class="col-md-8">
                <h2>Modificar Datos del Perfil</h2>
              </div>
            </div>
             <a href="principal_admin.php" class="btn btn-outline btn-info">
             <span class="glyphicon glyphicon-arrow-left"></span>
             Volver atr�s</a>
    		<br />
            <br />
            
            <div class="row">
            <div class="col-lg-8 col-md-3 col-sm-6 col-xs-6">
			<form role="form" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data" autocomplete="off">
                 <div class="form-group">
                                <label>Nombre</label>
                                <input name="nombre" class="form-control" id="nombre" placeholder="Ingrese su Nombre" type="text" required="required" value="<?php echo htmlentities($row_DatosUsuario['nombre'], ENT_COMPAT, 'iso-8859-1'); ?>"  />
                                </div>
                                <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" id="email" placeholder="Ingrese su Email" type="email" required="required" value="<?php echo htmlentities($row_DatosUsuario['email'], ENT_COMPAT, 'iso-8859-1'); ?>" />
                                </div>
                                <div class="form-group">
                                <label>Contrase�a</label>
                                <input name="contrasena" class="form-control" id="contrasena" placeholder="Ingrese su Contrase?a" type="password" required="required" value="<?php echo htmlentities($row_DatosUsuario['contrasena'], ENT_COMPAT, 'iso-8859-1'); ?>" />
                                </div>
                                  <div class="form-group">
                                <label>Foto</label>
                                <input name="imagen" class="form-control" id="imagen" type="file" />
                                <img src="../fotos/<?php echo htmlentities($row_DatosUsuario['foto'], ENT_COMPAT, 'iso-8859-1'); ?>" width="120" height="120">
                                </div>
                                  <button type="submit" class="btn btn-success">
                                  <span class="glyphicon glyphicon-floppy-save"></span>
                                  Actualizar Datos</button>
                                        <input name="MM_update" type="hidden" value="form1" />
                                        <input type="hidden" name="id" value="<?php echo $row_DatosUsuario['id']; ?>">
                                        <input type="hidden" name="img2" value="<?php echo htmlentities($row_DatosUsuario['foto'], ENT_COMPAT, 'iso-8859-1'); ?>"/>
                                  </form>
                                </div>
                 
                 </div>
                 
            </div>
          </div>
          <!-- /. PAGE INNER  -->
        </div>
        <!-- InstanceEndEditable --><!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
 
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($DatosUsuario);
?>
