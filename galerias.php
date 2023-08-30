<?php require_once('Connections/conex.php'); ?>
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

$maxRows_Datos_Galerias = 3;
$pageNum_Datos_Galerias = 0;
if (isset($_GET['pageNum_Datos_Galerias'])) {
  $pageNum_Datos_Galerias = $_GET['pageNum_Datos_Galerias'];
}
$startRow_Datos_Galerias = $pageNum_Datos_Galerias * $maxRows_Datos_Galerias;

mysql_select_db($database_conex, $conex);
$query_Datos_Galerias = "SELECT id, titulo, DATE_FORMAT(fecha_alta, '%d-%m-%Y') AS fecha_alta, descripcion FROM t_galerias ORDER BY fecha_alta, id DESC";
$query_limit_Datos_Galerias = sprintf("%s LIMIT %d, %d", $query_Datos_Galerias, $startRow_Datos_Galerias, $maxRows_Datos_Galerias);
$Datos_Galerias = mysql_query($query_limit_Datos_Galerias, $conex) or die(mysql_error());
$row_Datos_Galerias = mysql_fetch_assoc($Datos_Galerias);

if (isset($_GET['totalRows_Datos_Galerias'])) {
  $totalRows_Datos_Galerias = $_GET['totalRows_Datos_Galerias'];
} else {
  $all_Datos_Galerias = mysql_query($query_Datos_Galerias);
  $totalRows_Datos_Galerias = mysql_num_rows($all_Datos_Galerias);
}
$totalPages_Datos_Galerias = ceil($totalRows_Datos_Galerias/$maxRows_Datos_Galerias)-1;

$queryString_Datos_Galerias = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Datos_Galerias") == false && 
        stristr($param, "totalRows_Datos_Galerias") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Datos_Galerias = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Datos_Galerias = sprintf("&totalRows_Datos_Galerias=%d%s", $totalRows_Datos_Galerias, $queryString_Datos_Galerias);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/plantillabase.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>FE Y ALEGR&Iacute;A</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="encabezado" -->
<link href="css/estiloprincipal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/logo-original.png" />
<?php include("includes/google.php"); ?>
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Share:400,700&amp;subset=latin-ext,latin' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Dosis:400,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />
<!-- InstanceEndEditable -->
</head>

<body>

<div class="container">
  <div class="header"><!-- InstanceBeginEditable name="ParteSuperior" -->
  <?php include("includes/cabecera.php"); ?>
  <div class="clearfloat"></div>
  <?php include("includes/menu.php"); ?>
  <!-- end .header -->
  <!-- InstanceEndEditable --></div>
  <div class="sidebar1"><!-- InstanceBeginEditable name="ContenidoIzq" -->
    <h1 align="center">Galer&iacute;a de Fotos</h1>
     <?php if ($totalRows_Datos_Galerias > 0) { // Show if recordset not empty ?>
     <?php do { 	 
	 ?>
            
     <?php 
        $id = $row_Datos_Galerias['id'];
     	$subconsulta = "select archivo from t_fotos where id_galeria = " .$id ." and estado = 'visible' order by rand() limit 1";
        $result=mysql_query($subconsulta,$conex);
        if($row=mysql_fetch_array($result))
        { 
     	   $foto = $row['archivo'];
		}
        ?>
    <div id="principal">    	
            <div>
            	<h2><?php echo $row_Datos_Galerias['titulo']; ?></h2>
                <div><?php echo $row_Datos_Galerias['fecha_alta']; ?></div>
                <img src="fotos/<?php echo $row['archivo']; ?>" alt="Vista Previa" />
                <p><?php echo $row_Datos_Galerias['descripcion']; ?></p>
                <a href="galeria_fotos.php?id=<?php echo $row_Datos_Galerias['id']; ?>">Ver Galería</a>
            </div>
      </div>    
            
       
      <?php } while ($row_Datos_Galerias = mysql_fetch_assoc($Datos_Galerias)); ?>
      <?php } // Show if recordset not empty ?>
      <?php if ($totalRows_Datos_Galerias == 0) { // Show if recordset empty ?>
      <h2 align="center" style="color:#F00"><strong>No Hay Galería de Fotos</strong></h2>
      <?php } // Show if recordset empty ?>
      <table border="0" align="center">
        <tr>
          <td><?php if ($pageNum_Datos_Galerias > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Datos_Galerias=%d%s", $currentPage, 0, $queryString_Datos_Galerias); ?>"><img src="First.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_Datos_Galerias > 0) { // Show if not first page ?>
              <a href="<?php printf("%s?pageNum_Datos_Galerias=%d%s", $currentPage, max(0, $pageNum_Datos_Galerias - 1), $queryString_Datos_Galerias); ?>"><img src="Previous.gif" /></a>
              <?php } // Show if not first page ?></td>
          <td><?php if ($pageNum_Datos_Galerias < $totalPages_Datos_Galerias) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Datos_Galerias=%d%s", $currentPage, min($totalPages_Datos_Galerias, $pageNum_Datos_Galerias + 1), $queryString_Datos_Galerias); ?>"><img src="Next.gif" /></a>
              <?php } // Show if not last page ?></td>
          <td><?php if ($pageNum_Datos_Galerias < $totalPages_Datos_Galerias) { // Show if not last page ?>
              <a href="<?php printf("%s?pageNum_Datos_Galerias=%d%s", $currentPage, $totalPages_Datos_Galerias, $queryString_Datos_Galerias); ?>"><img src="Last.gif" /></a>
              <?php } // Show if not last page ?></td>
        </tr>
      </table>
  <!-- InstanceEndEditable --><!-- end .sidebar1 --></div>
  <div class="content"><!-- InstanceBeginEditable name="ParteDerecha" -->

  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
  <?php include("includes/pie.php"); ?>  	
  <!-- end .footer --></div>
  <!-- end .container --></div>
</body>

<!-- InstanceEnd --></html>
<?php
mysql_free_result($Datos_Galerias);
?>
