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
	move_uploaded_file($_FILES['imagen']['tmp_name'],"../images/slider/".$imagen);
	
	if(isset($imagen)&&($imagen!="")){
		$imgNew = $imagen;
	} else{
		$imgNew = $_POST['img2'];	
	}
	
  $updateSQL = sprintf("UPDATE t_slider SET imagen=%s, titulo=%s, subtitulo=%s, menu=%s, link=%s, orden=%s, estado=%s WHERE id=%s",
                       GetSQLValueString($imgNew, "text"),
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($_POST['subtitulo'], "text"),
                       GetSQLValueString($_POST['menu'], "text"),
                       GetSQLValueString($_POST['link'], "text"),
                       GetSQLValueString($_POST['orden'], "int"),
                       GetSQLValueString($_POST['estado'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($updateSQL, $conex) or die(mysql_error());

  $updateGoTo = "listado_publicidades.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varSlider_Editar_Publicidad = "0";
if (isset($_GET["id"])) {
  $varSlider_Editar_Publicidad = $_GET["id"];
}
mysql_select_db($database_conex, $conex);
$query_Editar_Publicidad = sprintf("SELECT * FROM t_slider WHERE t_slider.id = %s", GetSQLValueString($varSlider_Editar_Publicidad, "int"));
$Editar_Publicidad = mysql_query($query_Editar_Publicidad, $conex) or die(mysql_error());
$row_Editar_Publicidad = mysql_fetch_assoc($Editar_Publicidad);
$totalRows_Editar_Publicidad = mysql_num_rows($Editar_Publicidad);
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
                <h2>Editar Publicidad</h2>
              </div>
            </div>
            <a href="listado_publicidades.php" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
            <!-- /. ROW  -->
            <div class="row">
              <div class="col-lg-8 col-md-3 col-sm-6 col-xs-6">
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>" autocomplete="off">
                <div class="form-group">
                <label>Imagen</label>
                <input type="file" name="imagen" value="" class="form-control" ><br/>
          		<img src="../images/slider/<?php echo htmlentities($row_Editar_Publicidad['imagen'], ENT_COMPAT, 'iso-8859-1'); ?>" width="150" height="90">
                </div>
                 <div class="form-group">
                 <label>Titulo</label>
					<input type="text" name="titulo" value="<?php echo htmlentities($row_Editar_Publicidad['titulo'], ENT_COMPAT, 'iso-8859-1'); ?>"  placeholder="Ingrese Titulo para la Publicidad" class="form-control" required>
                </div>
                <div class="form-group">
                <label>SubTitulo</label>
                <input type="text" name="subtitulo" value="<?php echo htmlentities($row_Editar_Publicidad['subtitulo'], ENT_COMPAT, 'iso-8859-1'); ?>" placeholder="Ingrese Subtitulo para la Publicidad" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Menú</label>
                <input type="text" name="menu" value="<?php echo htmlentities($row_Editar_Publicidad['menu'], ENT_COMPAT, 'iso-8859-1'); ?>" placeholder="Ingrese Menú para la Publicidad" class="form-control" required>
                </div>
                 <div class="form-group">
                <label>Link</label>
                <input type="text" name="link" value="<?php echo htmlentities($row_Editar_Publicidad['link'], ENT_COMPAT, 'iso-8859-1'); ?>" placeholder="Ingrese Link para la Publicidad" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Orden</label>
                <input type="text" name="orden" value="<?php echo htmlentities($row_Editar_Publicidad['orden'], ENT_COMPAT, 'iso-8859-1'); ?>" placeholder="Ingrese Orden para la Publicidad" class="form-control" required>
                </div>
                <div class="form-group">
                <label>Estado</label>
                <select name="estado" required class="form-control" >
                	<option value="">SELECCIONE</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($row_Editar_Publicidad['estado'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Activo</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($row_Editar_Publicidad['estado'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Inactivo</option>
                </select>
                </div>
                <div class="form-group">
                 	<button type="submit" class="btn btn-success">
                    <span class="glyphicon glyphicon-floppy-save"></span>
                    Actualizar Datos</button>
                    <input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="id" value="<?php echo $row_Editar_Publicidad['id']; ?>">
                    <input type="hidden" name="img2" value="<?php echo htmlentities($row_Editar_Publicidad['imagen'], ENT_COMPAT, 'iso-8859-1'); ?>"/>
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
<?php
mysql_free_result($Editar_Publicidad);
?>
