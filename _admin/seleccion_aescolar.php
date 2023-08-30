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
$query_Consulta_Aescolar = "SELECT * FROM t_aescolares WHERE estatus = 1";
$Consulta_Aescolar = mysql_query($query_Consulta_Aescolar, $conex) or die(mysql_error());
$row_Consulta_Aescolar = mysql_fetch_assoc($Consulta_Aescolar);
$totalRows_Consulta_Aescolar = mysql_num_rows($Consulta_Aescolar);


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
                <h2>Seleccione Año Escolar</h2>
              </div>
            </div>
            <a href="principal_admin.php" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atrás</a>
    		<br />
            <br />
            <div class="row">
                 <div class="row">
                                <div class="col-lg-8">
                                <form role="form" method="get" action="consulta_estudiantes.php?$aescolar=aescolar" name="form1" id="form1" autocomplete="off">
                                <div class="form-group">
                                <label>Año Escolar</label>
                                <select name="aescolar" class="form-control" id="aescolar" required="required">
        						<option value="">Seleccione</option>
         						 <?php
									do {  
								 ?>
          							<option value="<?php echo $row_Consulta_Aescolar['id']?>"><?php echo $row_Consulta_Aescolar['denominacion']?></option>
          						<?php
								$_SESSION['aescolar']=$row_Consulta_Aescolar['id'];
								} while ($row_Consulta_Aescolar = mysql_fetch_assoc($Consulta_Aescolar));
  								$rows = mysql_num_rows($Consulta_Aescolar);
  								if($rows > 0) {
      								mysql_data_seek($Consulta_Aescolar, 0);
	 								$row_Consulta_Aescolar = mysql_fetch_assoc($Consulta_Aescolar);
  								}
								?>
                                </select>
                                </div>
                                <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-search"></span>
                                Busqueda</button>
                                </div>
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
mysql_free_result($Consulta_Periodos);
?>