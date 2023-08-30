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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO t_estudiante (cedula, apellidos, nombres, id_ano, id_grado, id_especialidad, id_empresa, fecha_inicio, fecha_culminacion, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cedula'], "long"),
                       GetSQLValueString($_POST['apellidos'], "text"),
                       GetSQLValueString($_POST['nombres'], "text"),
                       GetSQLValueString($_POST['id_ano'], "int"),
                       GetSQLValueString($_POST['id_grado'], "int"),
                       GetSQLValueString($_POST['id_especialidad'], "int"),
                       GetSQLValueString($_POST['id_empresa'], "int"),
                       GetSQLValueString($_POST['fecha_inicio'], "date"),
                       GetSQLValueString($_POST['fecha_culminacion'], "date"),
					   GetSQLValueString($_POST['estatus'], "text"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($insertSQL, $conex) or die(mysql_error());

  $insertGoTo = "consulta_estudiantes.php?aescolar=".$_SESSION["aescolar"]."";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conex, $conex);
$query_Aescolares = "SELECT * FROM t_aescolares WHERE t_aescolares.estatus = 1";
$Aescolares = mysql_query($query_Aescolares, $conex) or die(mysql_error());
$row_Aescolares = mysql_fetch_assoc($Aescolares);
$totalRows_Aescolares = mysql_num_rows($Aescolares);

mysql_select_db($database_conex, $conex);
$query_Grados = "SELECT * FROM t_grados";
$Grados = mysql_query($query_Grados, $conex) or die(mysql_error());
$row_Grados = mysql_fetch_assoc($Grados);
$totalRows_Grados = mysql_num_rows($Grados);

mysql_select_db($database_conex, $conex);
$query_Especialidades = "SELECT * FROM t_especialidades";
$Especialidades = mysql_query($query_Especialidades, $conex) or die(mysql_error());
$row_Especialidades = mysql_fetch_assoc($Especialidades);
$totalRows_Especialidades = mysql_num_rows($Especialidades);

mysql_select_db($database_conex, $conex);
$query_Empresas = "SELECT * FROM t_empresas ORDER BY razon_social ASC";
$Empresas = mysql_query($query_Empresas, $conex) or die(mysql_error());
$row_Empresas = mysql_fetch_assoc($Empresas);
$totalRows_Empresas = mysql_num_rows($Empresas);
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
                <h2>Añadir Datos del Estudiante</h2>
              </div>
            </div>
            <a href="consulta_estudiantes.php?aescolar=<?php echo $_SESSION['aescolar']?>" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
            <div class="row">
                 <div class="row">
                                <div class="col-lg-8">
                                <form role="form" action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1"  autocomplete="off">
             					<div class="form-group">
                                <label>Cédula</label>
                                <input name="cedula" class="form-control" id="cedula" placeholder="Ingrese la Cédula del Estudiante" type="text" required="required" style="width:250px"  />
                                </div>
                                <div class="form-group">
                                <label>Apellidos</label>
                                <input name="apellidos" class="form-control" id="apellidos" placeholder="Ingrese los Apellidos del Estudiante" type="text" required />
                                </div>
                                <div class="form-group">
                                <label>Nombres</label>
                                <input name="nombres" class="form-control" id="nombres" placeholder="Ingrese los Nombres del Estudiante" type="text" required />
								</div>
                                <div class="form-group">
                                <label>Año Escolar</label>
                                    <select name="id_ano" class="form-control" required>
                                    <option value="">SELECCIONE</option>
                                     <?php 
                            			do {  
                           			?>
                                      <option value="<?php echo $row_Aescolares['id']?>" ><?php echo $row_Aescolares['denominacion']?></option>
                                    <?php
                            		} while ($row_Aescolares = mysql_fetch_assoc($Aescolares));
                           			 ?>
                                    </select>
								</div>
                                <div class="form-group">
                                <label>Grado</label>
                                <select name="id_grado" class="form-control" required>
                                 <option value="">SELECCIONE</option>
                                 <?php 
								do {  
								?>
                                 <option value="<?php echo $row_Grados['id']?>" ><?php echo $row_Grados['denominacion']?></option>
                                 <?php
								} while ($row_Grados = mysql_fetch_assoc($Grados));
								?>
                                </select>
                                </div>
                                <div class="form-group">
                                <label>Especialidad</label>
                                <select name="id_especialidad" class="form-control" required>
                                    <option value="">SELECCIONE</option>
                                  <?php 
									do {  
									?>
                                  <option value="<?php echo $row_Especialidades['id']?>" ><?php echo $row_Especialidades['denominacion']?></option>
                                  <?php
								} while ($row_Especialidades = mysql_fetch_assoc($Especialidades));
								?>
                                </select>
                                </div>
                                <div class="form-group">
                                <label>Empresa</label>
                                <select name="id_empresa" class="form-control" required>
                                <option value="">SELECCIONE</option>
                              <?php 
								do {  
								?>
                              <option value="<?php echo $row_Empresas['id']?>" ><?php echo $row_Empresas['razon_social']?></option>
                              <?php
								} while ($row_Empresas = mysql_fetch_assoc($Empresas));
								?>
                            	</select>
                                </div>
                                <div class="form-group">
                                <label>Fecha de Inicio</label>
                                <input class="form-control" type="date" name="fecha_inicio" style="width:250px"required>
                                </div>
                                <div class="form-group">
                                <label>Fecha de Culminación</label>
                                <input class="form-control" type="date" name="fecha_culminacion" style="width:250px"required>
                                </div>
                                <div class="form-group">
                                <label>Estatus</label>
          						<select name="estatus" id="estatus" required class="form-control" style="width:255px" >
            					<option value="ACTIVO" selected>ACTIVO</option>
            					<option value="INACTIVO">INACTIVO</option>
          						</select>
                                </div>
                                <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                                Guardar Datos</button>
                                <input name="MM_insert" type="hidden" value="form1" />
                                </div>
                              </form>
                       </div>
              </div>
            </div>
          </div>
          <!-- /. PAGE INNER  -->
        </div>
        <script language="javascript">
		document.form1.cedula.focus();
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
<?php
mysql_free_result($Aescolares);

mysql_free_result($Grados);

mysql_free_result($Especialidades);

mysql_free_result($Empresas);
?>