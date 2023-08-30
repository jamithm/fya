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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Datos_Aescolar = 10;
$pageNum_Datos_Aescolar = 0;
if (isset($_GET['pageNum_Datos_Aescolar'])) {
  $pageNum_Datos_Aescolar = $_GET['pageNum_Datos_Aescolar'];
}
$startRow_Datos_Aescolar = $pageNum_Datos_Aescolar * $maxRows_Datos_Aescolar;

mysql_select_db($database_conex, $conex);
$query_Datos_Aescolar = "SELECT * FROM t_aescolares";
$query_limit_Datos_Aescolar = sprintf("%s LIMIT %d, %d", $query_Datos_Aescolar, $startRow_Datos_Aescolar, $maxRows_Datos_Aescolar);
$Datos_Aescolar = mysql_query($query_limit_Datos_Aescolar, $conex) or die(mysql_error());
$row_Datos_Aescolar = mysql_fetch_assoc($Datos_Aescolar);

if (isset($_GET['totalRows_Datos_Aescolar'])) {
  $totalRows_Datos_Aescolar = $_GET['totalRows_Datos_Aescolar'];
} else {
  $all_Datos_Aescolar = mysql_query($query_Datos_Aescolar);
  $totalRows_Datos_Aescolar = mysql_num_rows($all_Datos_Aescolar);
}
$totalPages_Datos_Aescolar = ceil($totalRows_Datos_Aescolar/$maxRows_Datos_Aescolar)-1;

$queryString_Datos_Aescolar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Datos_Aescolar") == false && 
        stristr($param, "totalRows_Datos_Aescolar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Datos_Aescolar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Datos_Aescolar = sprintf("&totalRows_Datos_Aescolar=%d%s", $totalRows_Datos_Aescolar, $queryString_Datos_Aescolar);
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/Admininstracion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Administración</title>
    <script>
	function confirmacion(){
		confirmar=confirm('Seguro que desea eliminar el registro?');
		return confirmar;	
	}
	</script>
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
                <h2>Listado de Años Escolares</h2>
              </div>
            </div>
            <a href="anadir_aescolar.php" class="btn btn-outline btn-success">
            <span class="glyphicon glyphicon-new-window"></span>
            Añadir Año Escolar</a>
   			<br />
            <br />
            <div class="panel panel-primary">
            	<div class="panel-heading">
				Años Escolares Registrados
            </div>
           <div class="panel-body">
           	<div class="table-condensed">
            	  <?php if ($totalRows_Datos_Aescolar > 0) { // Show if recordset not empty ?>
  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
  	<thead>
    <tr class="active">
      <td>AÑO ESCOLAR</td>
      <td align="center">ESTATUS</td>
      <td align="center">OPCIONES</td>
    </tr>
    </thead>
    <?php do { ?>
     <tbody>
      <tr>
        <td><?php echo $row_Datos_Aescolar['denominacion']; ?></td>
        <td align="center">
          <?php 
	if ($row_Datos_Aescolar['estatus']==1) 
		echo '<span class="label label-success">'."Activo".'</span>';
	else 
		echo '<span class="label label-danger">'."Inactivo".'</span>'; ?>
        </td>
        <td align="center">
        <a class="btn btn-sm btn-primary" href="editar_aescolar.php?id=<?php echo $row_Datos_Aescolar['id']; ?>">
        <span class="glyphicon glyphicon-edit"></span>
        Editar
        </a> 
        <a class="btn btn-sm btn-danger" href="eliminar_aescolar.php?id=<?php echo $row_Datos_Aescolar['id']; ?>" onclick="javascript:return confirmacion();">
        <span class="glyphicon glyphicon-remove"></span>
        Eiminar
        </a>
        </td>
      </tr>
      </tbody>
      <?php } while ($row_Datos_Aescolar = mysql_fetch_assoc($Datos_Aescolar)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_Datos_Aescolar == 0) { // Show if recordset empty ?>
  <h3 align="center" style="color:#F00"><strong>No hay registros</strong></h3>
  <?php } // Show if recordset empty ?>
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
mysql_free_result($Datos_Aescolar);
?>
