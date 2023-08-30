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

$maxRows_Consulta_Estudiantes = 1000;
$pageNum_Consulta_Estudiantes = 0;
if (isset($_GET['pageNum_Consulta_Estudiantes'])) {
  $pageNum_Consulta_Estudiantes = $_GET['pageNum_Consulta_Estudiantes'];
}
$startRow_Consulta_Estudiantes = $pageNum_Consulta_Estudiantes * $maxRows_Consulta_Estudiantes;

$varAescolar_Consulta_Estudiantes = "-1";
if (isset($_GET["aescolar"])) {
  $varAescolar_Consulta_Estudiantes = $_GET["aescolar"];
}
mysql_select_db($database_conex, $conex);
$query_Consulta_Estudiantes = sprintf("SELECT e.id, e.cedula, CONCAT(e.apellidos, ', ', e.nombres) AS estudiante, g.denominacion AS grado, es.denominacion AS especialidad, em.razon_social, e.fecha_inicio, e.fecha_culminacion FROM t_estudiante AS e, t_grados AS g, t_especialidades AS es, t_empresas AS em, t_aescolares AS ae WHERE e.id_ano = ae.id AND e.id_grado = g.id AND e.id_especialidad =es.id AND e.id_empresa = em.id AND e.id_ano = %s ORDER BY grado, especialidad ASC", GetSQLValueString($varAescolar_Consulta_Estudiantes, "int"));
$query_limit_Consulta_Estudiantes = sprintf("%s LIMIT %d, %d", $query_Consulta_Estudiantes, $startRow_Consulta_Estudiantes, $maxRows_Consulta_Estudiantes);
$Consulta_Estudiantes = mysql_query($query_limit_Consulta_Estudiantes, $conex) or die(mysql_error());
$row_Consulta_Estudiantes = mysql_fetch_assoc($Consulta_Estudiantes);

if (isset($_GET['totalRows_Consulta_Estudiantes'])) {
  $totalRows_Consulta_Estudiantes = $_GET['totalRows_Consulta_Estudiantes'];
} else {
  $all_Consulta_Estudiantes = mysql_query($query_Consulta_Estudiantes);
  $totalRows_Consulta_Estudiantes = mysql_num_rows($all_Consulta_Estudiantes);
}
$totalPages_Consulta_Estudiantes = ceil($totalRows_Consulta_Estudiantes/$maxRows_Consulta_Estudiantes)-1;

$queryString_Consulta_Estudiantes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Consulta_Estudiantes") == false && 
        stristr($param, "totalRows_Consulta_Estudiantes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Consulta_Estudiantes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Consulta_Estudiantes = sprintf("&totalRows_Consulta_Estudiantes=%d%s", $totalRows_Consulta_Estudiantes, $queryString_Consulta_Estudiantes);
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
                <h2>Listado de Estudiantes</h2>
              </div>
            </div>
            <a href="anadir_estudiante.php" class="btn btn-outline btn-success">
            <span class="glyphicon glyphicon-new-window"></span>
            Añadir Estudiante</a>
   			<br />
            <br />
            <div class="panel panel-primary">
            <div class="panel-heading">
			Estudiantes
           </div>
           <div class="panel-body">
           	<div class="table-condensed">
            	  <?php if ($totalRows_Consulta_Estudiantes > 0) { // Show if recordset not empty ?>
  <table class="table table-striped table-bordered table-hover" id="dataTables-example">
   <thead>
    <tr>
      <th>CÉDULA</th>
      <th>ESTUDIANTE</th>
      <th>GRADO</th>
      <th>ESPECIALIDAD</th>
      <th>OPCIONES</th>
    </tr>
    </thead>
    <tbody>
    <?php do { ?>
      <tr>
        <td><i class="fa fa-user fa-2x"></i>  <?php echo $row_Consulta_Estudiantes['cedula']; ?></td>
        <td><?php echo $row_Consulta_Estudiantes['estudiante']; ?></td>
        <td><?php echo $row_Consulta_Estudiantes['grado']; ?></td>
        <td><?php echo $row_Consulta_Estudiantes['especialidad']; ?></td>
        <td><a class="btn btn-sm btn-primary" href="editar_estudiante.php?id=<?php echo $row_Consulta_Estudiantes['id']; ?>">
        <span class="glyphicon glyphicon-edit"></span>
        Editar</a> 
        <a class="btn btn-sm btn-danger" href="eliminar_estudiante.php?id=<?php echo $row_Consulta_Estudiantes['id']; ?>" onclick="javascript:return confirmacion();">
        <span class="glyphicon glyphicon-remove"></span>
        Eiminar</a></td>
      </tr>
      <?php } while ($row_Consulta_Estudiantes = mysql_fetch_assoc($Consulta_Estudiantes)); ?>
      </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_Consulta_Estudiantes == 0) { // Show if recordset empty ?>
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
mysql_free_result($Consulta_Estudiantes);
?>
