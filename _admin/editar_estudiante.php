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
  $updateSQL = sprintf("UPDATE t_estudiante SET cedula=%s, apellidos=%s, nombres=%s, id_ano=%s, id_grado=%s, id_especialidad=%s, id_empresa=%s, fecha_inicio=%s, fecha_culminacion=%s, estatus=%s WHERE id=%s",
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['apellidos'], "text"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['id_ano'], "int"),
                       GetSQLValueString($_POST['id_grado'], "int"),
                       GetSQLValueString($_POST['id_especialidad'], "int"),
                       GetSQLValueString($_POST['id_empresa'], "int"),
                       GetSQLValueString($_POST['fecha_inicio'], "date"),
                       GetSQLValueString($_POST['fecha_culminacion'], "date"),
                       GetSQLValueString($_POST['estatus'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($updateSQL, $conex) or die(mysql_error());

  $updateGoTo = "consulta_estudiantes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE t_estudiante SET cedula=%s, apellidos=%s, nombres=%s, id_ano=%s, id_grado=%s, id_especialidad=%s, id_empresa=%s, fecha_inicio=%s, fecha_culminacion=%s, estatus=%s WHERE id=%s",
                       GetSQLValueString($_POST['cedula'], "int"),
                       GetSQLValueString($_POST['apellidos'], "text"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['id_ano'], "int"),
                       GetSQLValueString($_POST['id_grado'], "int"),
                       GetSQLValueString($_POST['id_especialidad'], "int"),
                       GetSQLValueString($_POST['id_empresa'], "int"),
                       GetSQLValueString($_POST['fecha_inicio'], "date"),
                       GetSQLValueString($_POST['fecha_culminacion'], "date"),
                       GetSQLValueString($_POST['estatus'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($updateSQL, $conex) or die(mysql_error());

  $updateGoTo = "consulta_estudiantes.php?aescolar=".$_SESSION['aescolar']."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conex, $conex);
$query_Consulta_Aescolares = "SELECT * FROM t_aescolares WHERE t_aescolares.estatus = 1";
$Consulta_Aescolares = mysql_query($query_Consulta_Aescolares, $conex) or die(mysql_error());
$row_Consulta_Aescolares = mysql_fetch_assoc($Consulta_Aescolares);
$totalRows_Consulta_Aescolares = mysql_num_rows($Consulta_Aescolares);

mysql_select_db($database_conex, $conex);
$query_Consulta_Grados = "SELECT * FROM t_grados ORDER BY t_grados.denominacion ASC";
$Consulta_Grados = mysql_query($query_Consulta_Grados, $conex) or die(mysql_error());
$row_Consulta_Grados = mysql_fetch_assoc($Consulta_Grados);
$totalRows_Consulta_Grados = mysql_num_rows($Consulta_Grados);

mysql_select_db($database_conex, $conex);
$query_Consulta_Especialidades = "SELECT * FROM t_especialidades ORDER BY t_especialidades.denominacion ASC";
$Consulta_Especialidades = mysql_query($query_Consulta_Especialidades, $conex) or die(mysql_error());
$row_Consulta_Especialidades = mysql_fetch_assoc($Consulta_Especialidades);
$totalRows_Consulta_Especialidades = mysql_num_rows($Consulta_Especialidades);

mysql_select_db($database_conex, $conex);
$query_Consulta_Empresas = "SELECT * FROM t_empresas ORDER BY t_empresas.razon_social ASC";
$Consulta_Empresas = mysql_query($query_Consulta_Empresas, $conex) or die(mysql_error());
$row_Consulta_Empresas = mysql_fetch_assoc($Consulta_Empresas);
$totalRows_Consulta_Empresas = mysql_num_rows($Consulta_Empresas);

$varEstudiante_Consulta_Estudiante = "0";
if (isset($_GET["id"])) {
  $varEstudiante_Consulta_Estudiante = $_GET["id"];
}
mysql_select_db($database_conex, $conex);
$query_Consulta_Estudiante = sprintf("SELECT * FROM t_estudiante WHERE t_estudiante.id = %s", GetSQLValueString($varEstudiante_Consulta_Estudiante, "int"));
$Consulta_Estudiante = mysql_query($query_Consulta_Estudiante, $conex) or die(mysql_error());
$row_Consulta_Estudiante = mysql_fetch_assoc($Consulta_Estudiante);
$totalRows_Consulta_Estudiante = mysql_num_rows($Consulta_Estudiante);
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/Admininstracion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Administraci&oacute;n</title>
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
                <h2>Editar Datos del Estudiante</h2>
              </div>
            </div>
            <a href="consulta_estudiantes.php?aescolar=<?php echo $_SESSION['aescolar']?>" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
             <div class="col-lg-8 col-md-3 col-sm-6 col-xs-6">
            <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            	<div class="form-group">
                  <label>Cédula</label>
                  <input type="text" class="form-control" name="cedula" value="<?php echo htmlentities($row_Consulta_Estudiante['cedula'], ENT_COMPAT, 'iso-8859-1'); ?>" required placeholder="Ingrese la Cédula del Estudiante">
                  </div>
                <div class="form-group">
                  <label>Apellidos</label>
                  <input class="form-control" type="text" name="apellidos" value="<?php echo htmlentities($row_Consulta_Estudiante['apellidos'], ENT_COMPAT, 'iso-8859-1'); ?>" required placeholder="Ingrese los Apellidos del Estudiante">
                </div>
                <div class="form-group">
                  <label>Nombres</label>
                  <input class="form-control" type="text" name="nombres" value="<?php echo htmlentities($row_Consulta_Estudiante['nombres'], ENT_COMPAT, 'iso-8859-1'); ?>" required placeholder="Ingrese los Nombres del Estudiante"></td>
                </div>
                <div class="form-group">
                  <label>Año Escolar</label>
                  <select name="id_ano" class="form-control" required>
                  <option value="">SELECCIONE</option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Consulta_Aescolares['id']?>" <?php if (!(strcmp($row_Consulta_Aescolares['id'], htmlentities($row_Consulta_Estudiante['id_ano'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_Consulta_Aescolares['denominacion']?></option>
                    <?php
} while ($row_Consulta_Aescolares = mysql_fetch_assoc($Consulta_Aescolares));
?>
                  </select>
                  </div>
                <div class="form-group">
                  <label>Grado</label>
                  <select name="id_grado" required class="form-control">
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Consulta_Grados['id']?>" <?php if (!(strcmp($row_Consulta_Grados['id'], htmlentities($row_Consulta_Estudiante['id_grado'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_Consulta_Grados['denominacion']?></option>
                    <?php
} while ($row_Consulta_Grados = mysql_fetch_assoc($Consulta_Grados));
?>
                  </select>
                  </div>
                <div class="form-group">
                  <label>Especialidad</label>
                  <select name="id_especialidad" required class="form-control">
                  <option value="">SELECCIONE</option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Consulta_Especialidades['id']?>" <?php if (!(strcmp($row_Consulta_Especialidades['id'], htmlentities($row_Consulta_Estudiante['id_especialidad'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_Consulta_Especialidades['denominacion']?></option>
                    <?php
} while ($row_Consulta_Especialidades = mysql_fetch_assoc($Consulta_Especialidades));
?>
                  </select>
                  </div>
                <div class="form-group">
                  <label>Empresa</label>
                  <select name="id_empresa" required class="form-control">
                  <option value="">SELECCIONE</option>
                    <?php 
do {  
?>
                    <option value="<?php echo $row_Consulta_Empresas['id']?>" <?php if (!(strcmp($row_Consulta_Empresas['id'], htmlentities($row_Consulta_Estudiante['id_empresa'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_Consulta_Empresas['razon_social']?></option>
                    <?php
} while ($row_Consulta_Empresas = mysql_fetch_assoc($Consulta_Empresas));
?>
                  </select>
                  </div>
                <div class="form-group">
                  <label>Fecha de Inicio</label>
                  <input class="form-control" type="date" name="fecha_inicio" value="<?php echo htmlentities($row_Consulta_Estudiante['fecha_inicio'], ENT_COMPAT, 'iso-8859-1'); ?>" required>
                </div>
                <div class="form-group">
                  <label>Fecha de Culminación</label>
                  <input class="form-control" type="date" name="fecha_culminacion" value="<?php echo htmlentities($row_Consulta_Estudiante['fecha_culminacion'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32">
              </div>
                <div class="form-group">
                  <label>Estatus</label>
                  <select name="estatus" class="form-control" required>
                  <option value="ACTIVO" <?php if (!(strcmp("ACTIVO", htmlentities($row_Consulta_Estudiante['estatus'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>ACTIVO</option>
                  <option value="INACTIVO" <?php if (!(strcmp("INACTIVO", htmlentities($row_Consulta_Estudiante['estatus'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>INACTIVO</option>
                </select>
                  </div>
                  <div class="form-group">
                  	<button type="submit" class="btn btn-success"> 
                    <span class="glyphicon glyphicon-floppy-save"></span>
                    Actualizar Datos
                    </button>
              		<input type="hidden" name="MM_update" value="form1">
              		<input type="hidden" name="id" value="<?php echo $row_Consulta_Estudiante['id']; ?>">
              	   </div>
            </form>
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
mysql_free_result($Consulta_Aescolares);

mysql_free_result($Consulta_Grados);

mysql_free_result($Consulta_Especialidades);

mysql_free_result($Consulta_Empresas);

mysql_free_result($Consulta_Estudiante);
?>
