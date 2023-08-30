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

$maxRows_DatosGaleria = 12;
$pageNum_DatosGaleria = 0;
if (isset($_GET['pageNum_DatosGaleria'])) {
  $pageNum_DatosGaleria = $_GET['pageNum_DatosGaleria'];
}
$startRow_DatosGaleria = $pageNum_DatosGaleria * $maxRows_DatosGaleria;

mysql_select_db($database_conex, $conex);
$query_DatosGaleria = "SELECT g.titulo, f.id, f.nombre, f.archivo FROM t_fotos AS f, t_galerias AS g WHERE f.id_galeria = g.id AND f.id_galeria = ".$_GET['id']." ORDER BY f.id DESC";
$query_limit_DatosGaleria = sprintf("%s LIMIT %d, %d", $query_DatosGaleria, $startRow_DatosGaleria, $maxRows_DatosGaleria);
$DatosGaleria = mysql_query($query_limit_DatosGaleria, $conex) or die(mysql_error());
$row_DatosGaleria = mysql_fetch_assoc($DatosGaleria);

if (isset($_GET['totalRows_DatosGaleria'])) {
  $totalRows_DatosGaleria = $_GET['totalRows_DatosGaleria'];
} else {
  $all_DatosGaleria = mysql_query($query_DatosGaleria);
  $totalRows_DatosGaleria = mysql_num_rows($all_DatosGaleria);
}
$totalPages_DatosGaleria = ceil($totalRows_DatosGaleria/$maxRows_DatosGaleria)-1;

$queryString_DatosGaleria = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_DatosGaleria") == false && 
        stristr($param, "totalRows_DatosGaleria") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_DatosGaleria = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_DatosGaleria = sprintf("&totalRows_DatosGaleria=%d%s", $totalRows_DatosGaleria, $queryString_DatosGaleria);
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
<!-- Add jQuery library -->
<link href="css/estiloprincipal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/logo-original.png" />
<?php include("includes/google.php"); ?>
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Share:400,700&amp;subset=latin-ext,latin' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Dosis:400,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css' />
	<!-- Add jQuery library -->
	<script type="text/javascript" src="lib/jquery-1.10.2.min.js"></script>
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
	<script type="text/javascript" src="js/fancybox.js"></script>
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
    <h1 align="center"><?php echo $row_DatosGaleria['titulo']; ?></h1>
    <p align="center"><a href="galerias.php">Volver a las Galerias</a></p>
    <div class="resultadogaleria">
      <?php if ($totalRows_DatosGaleria > 0) { // Show if recordset not empty ?>
        <?php do { ?>
          <div class="galeria">         	
          <a  class="fancybox-buttons" data-fancybox-group="button" href="fotos/<?php echo $row_DatosGaleria['archivo']; ?>"  title="<?php echo $row_DatosGaleria['archivo']; ?>"><img src="fotos/<?php echo $row_DatosGaleria['archivo']; ?>" width="190" height="180" /></a></div>
          <?php } while ($row_DatosGaleria = mysql_fetch_assoc($DatosGaleria)); ?>
        <?php } // Show if recordset not empty ?>
<?php if ($totalRows_DatosGaleria == 0) { // Show if recordset empty ?>
          <h3 align="center"><strong>No Hay Galeria de Fotos</strong></h3>
        <?php } // Show if recordset empty ?>
        
          </div>
          
          
          
          
    <table border="0" align="center">
      <tr>
        <td><strong>
          <?php if ($pageNum_DatosGaleria > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_DatosGaleria=%d%s", $currentPage, 0, $queryString_DatosGaleria); ?>">Primero</a>
            <?php } // Show if not first page ?>
        </strong></td>
        <td><strong>
          <?php if ($pageNum_DatosGaleria > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_DatosGaleria=%d%s", $currentPage, max(0, $pageNum_DatosGaleria - 1), $queryString_DatosGaleria); ?>">Anterior</a>
            <?php } // Show if not first page ?>
        </strong></td>
        <td><strong>
          <?php if ($pageNum_DatosGaleria < $totalPages_DatosGaleria) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_DatosGaleria=%d%s", $currentPage, min($totalPages_DatosGaleria, $pageNum_DatosGaleria + 1), $queryString_DatosGaleria); ?>">Siguiente</a>
            <?php } // Show if not last page ?>
        </strong></td>
        <td><strong>
          <?php if ($pageNum_DatosGaleria < $totalPages_DatosGaleria) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_DatosGaleria=%d%s", $currentPage, $totalPages_DatosGaleria, $queryString_DatosGaleria); ?>">Ultimo</a>
            <?php } // Show if not last page ?>
        </strong></td>
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
mysql_free_result($DatosGaleria);
?>
