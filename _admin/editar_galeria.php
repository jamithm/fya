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
  $updateSQL = sprintf("UPDATE t_galerias SET titulo=%s, descripcion=%s WHERE id=%s",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($updateSQL, $conex) or die(mysql_error());

  $updateGoTo = "listado_galerias_fotos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varGaleria_Editar_Galeria = "0";
if (isset($_GET["id"])) {
  $varGaleria_Editar_Galeria = $_GET["id"];
}
mysql_select_db($database_conex, $conex);
$query_Editar_Galeria = sprintf("SELECT * FROM t_galerias WHERE t_galerias.id = %s", GetSQLValueString($varGaleria_Editar_Galeria, "int"));
$Editar_Galeria = mysql_query($query_Editar_Galeria, $conex) or die(mysql_error());
$row_Editar_Galeria = mysql_fetch_assoc($Editar_Galeria);
$totalRows_Editar_Galeria = mysql_num_rows($Editar_Galeria);
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
                <h2>Editar Galería de Fotos</h2>
              </div>
            </div>
            <a href="listado_galerias_fotos.php" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
            <!-- /. ROW  -->
            <div class="row">
              <div class="col-lg-8 col-md-3 col-sm-6 col-xs-6">
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>" autocomplete="off">
                <div class="form-group">
                	 <label>Titulo de la Galería</label>
                     <input name="titulo" class="form-control" id="titulo" placeholder="Ingrese Titulo de la Galería de Fotos" type="text" required="required" value="<?php echo htmlentities($row_Editar_Galeria['titulo'], ENT_COMPAT, 'iso-8859-1'); ?>" />
                </div>
                 <div class="form-group">
                     <label>Descripción de la Galería</label>
                     <textarea name="descripcion" cols="500" rows="5" class="form-control" id="descripcion" required="required" placeholder="Ingrese Descripción de la Galería de Fotos"><?php echo htmlentities($row_Editar_Galeria['descripcion'], ENT_COMPAT, 'iso-8859-1'); ?></textarea>
                </div>
                <div class="form-group">
                 <button type="submit" class="btn btn-success">
                 <span class="glyphicon glyphicon-floppy-save"></span>
                 Actualizar Datos</button>
               	 <input type="hidden" name="MM_update" value="form1">
                 <input type="hidden" name="id" value="<?php echo $row_Editar_Galeria['id']; ?>">
                </div>
                </form>
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
