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

mysql_select_db($database_conex, $conex);
$query_Consulta_Empresas = "SELECT COUNT(*) FROM t_empresas";
$Consulta_Empresas = mysql_query($query_Consulta_Empresas, $conex) or die(mysql_error());
$row_Consulta_Empresas = mysql_fetch_assoc($Consulta_Empresas);
$totalRows_Consulta_Empresas = mysql_num_rows($Consulta_Empresas);

mysql_select_db($database_conex, $conex);
$query_Consulta_Estudintes = "SELECT COUNT(*) FROM t_estudiante WHERE t_estudiante.estatus = 'ACTIVO'";
$Consulta_Estudintes = mysql_query($query_Consulta_Estudintes, $conex) or die(mysql_error());
$row_Consulta_Estudintes = mysql_fetch_assoc($Consulta_Estudintes);
$totalRows_Consulta_Estudintes = mysql_num_rows($Consulta_Estudintes);

mysql_select_db($database_conex, $conex);
$query_Consulta_Usuarios = "SELECT COUNT(*) FROM t_usuarios";
$Consulta_Usuarios = mysql_query($query_Consulta_Usuarios, $conex) or die(mysql_error());
$row_Consulta_Usuarios = mysql_fetch_assoc($Consulta_Usuarios);
$totalRows_Consulta_Usuarios = mysql_num_rows($Consulta_Usuarios);
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
                <h2>Bienvenido a la Administración de la Página</h2>
              </div>
            </div>
            <!-- /. ROW  -->
            <hr />
            <div class="row">
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box"> <span class="icon-box bg-color-red set-icon"> <i class="fa fa-group"></i> </span>
                  <div class="text-box" >
                    <p class="main-text"><?php echo $row_Consulta_Estudintes['COUNT(*)']; ?></p>
                    <p class="text-muted">Estudiantes</p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box"> <span class="icon-box bg-color-green set-icon"> <i class="fa fa-hospital-o"></i> </span>
                  <div class="text-box" >
                    <p class="main-text"><?php echo $row_Consulta_Empresas['COUNT(*)']-1; ?></p>
                      <p class="text-muted">Empresas</p>
                </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box"> <span class="icon-box bg-color-brown set-icon"> <i class="fa fa-user"></i> </span>
                  <div class="text-box" >
                    <p class="main-text"><?php echo $row_Consulta_Usuarios['COUNT(*)']; ?></p>
                    <p class="text-muted">Usuarios</p>
                  </div>
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
mysql_free_result($Consulta_Empresas);

mysql_free_result($Consulta_Estudintes);

mysql_free_result($Consulta_Usuarios);
?>
