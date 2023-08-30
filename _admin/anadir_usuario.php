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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="error_acceso.php";
  $loginUsername = $_POST['email'];
  $LoginRS__query = sprintf("SELECT email FROM t_usuarios WHERE email=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conex, $conex);
  $LoginRS=mysql_query($LoginRS__query, $conex) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$imagen = $_FILES['imagen']['name'];
	move_uploaded_file($_FILES['imagen']['tmp_name'],"../fotos/".$imagen);
	
  $insertSQL = sprintf("INSERT INTO t_usuarios (nombre, email, contrasena, nivel, estado, foto) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['nivel'], "int"),
					   GetSQLValueString($_POST['estado'], "int"),
					   GetSQLValueString($imagen, "text"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($insertSQL, $conex) or die(mysql_error());

  $insertGoTo = "listado_usuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/Admininstracion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Administración</title>
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
              <div class="col-md-12">
                <h2>Añadir Usuario</h2>
              </div>
            </div>
            <a href="listado_usuarios.php" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
            <div class="row">
                 <div class="row">
                                <div class="col-lg-8">
                                <form role="form" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" enctype="multipart/form-data" autocomplete="off">
             					<div class="form-group">
                                <label>Nombre</label>
                                <input name="nombre" class="form-control" id="nombre" placeholder="Ingrese su Nombre" type="text" required="required" />
                                </div>
                                <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" id="email" placeholder="Ingrese su Email" type="email" required="required" />
                                </div>
                                <div class="form-group">
                                <label>Contraseña</label>
                                <input name="contrasena" class="form-control" id="contrasena" placeholder="Ingrese su Contraseña" type="password" required="required" />
                                </div>
                                <div class="form-group">
                                <label>Nivel de Usuario</label>
                                <select name="nivel" class="form-control" id="nivel">
                                   <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Invitado</option>
                                   <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Web-Master</option>
                                   <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>Coordinador - Director(a)</option>
                                   <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>Secretaria - Administrador</option>
                                   <option value="4" <?php if (!(strcmp(4, ""))) {echo "SELECTED";} ?>>Docentes</option>
                                   <option value="5" <?php if (!(strcmp(5, ""))) {echo "SELECTED";} ?>>Personal CECAL</option>
                                 </select>
                                  </div>
                                        <div class="form-group">
                                          <label>Estado</label>
                                            <select name="estado" class="form-control" id="estado">
                                                <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
                                                <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Inactivo</option>
                                            </select>
                                        </div>
                                  <div class="form-group">
                                <label>Foto</label>
                                <input name="imagen" class="form-control" id="imagen" type="file" required="required" />
                                </div>
                                  <button type="submit" class="btn btn-success">
                                  <span class="glyphicon glyphicon-floppy-disk"></span>
                                  Guardar Datos</button>
                                  <input name="MM_insert" type="hidden" value="form1" />
                                  </form>
                                </div>
              </div>
            </div>
          </div>
          <!-- /. PAGE INNER  -->
        </div>
        <script language="javascript">
		document.form1.nombre.focus();
		</script>
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