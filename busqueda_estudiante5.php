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

$varCedula_Consulta_Estudiante = "0";
if (isset($_GET["cedula"])) {
  $varCedula_Consulta_Estudiante = $_GET["cedula"];
}
mysql_select_db($database_conex, $conex);
$query_Consulta_Estudiante = sprintf("SELECT e.id, e.cedula, CONCAT(e.apellidos, ', ', e.nombres) AS estudiante, g.denominacion AS grado, es.denominacion AS especialidad, em.razon_social, e.fecha_inicio, e.fecha_culminacion  FROM t_estudiante AS e, t_grados AS g, t_especialidades AS es, t_empresas AS em, t_aescolares AS ae WHERE e.id_ano = ae.id AND e.id_grado = g.id AND e.id_especialidad =es.id AND e.id_empresa = em.id AND ae.estatus = 1 AND e.id_grado = 2 AND e.estatus = 'ACTIVO' AND e.cedula = %s", GetSQLValueString($varCedula_Consulta_Estudiante, "long"));
$Consulta_Estudiante = mysql_query($query_Consulta_Estudiante, $conex) or die(mysql_error());
$row_Consulta_Estudiante = mysql_fetch_assoc($Consulta_Estudiante);
$totalRows_Consulta_Estudiante = mysql_num_rows($Consulta_Estudiante);
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
    <h1 align="center">Datos del Estudiante</h1>
    <?php if ($totalRows_Consulta_Estudiante > 0) { // Show if recordset not empty ?>
  <table width="98%" border="1" align="center" cellpadding="2" cellspacing="2">
    <tr align="center" class="basetabla">
      <td><strong>C&Eacute;DULA</strong></td>
      <td><strong>ESTUDIANTE</strong></td>
      <td><strong>GRADO</strong></td>
      <td><strong>ESPECIALIDAD</strong></td>
      <td><strong>EMPRESA</strong></td>
      </tr>
    <tr class="brillo">
      <td><?php echo $row_Consulta_Estudiante['cedula']; ?></td>
      <td><?php echo $row_Consulta_Estudiante['estudiante']; ?></td>
      <td><?php echo $row_Consulta_Estudiante['grado']; ?></td>
      <td><?php echo $row_Consulta_Estudiante['especialidad']; ?></td>
      <td><?php echo $row_Consulta_Estudiante['razon_social']; ?></td>
      </tr>
  </table>
      
      <p align="center" style="color:#F00"><strong>Nota: Si posse Empresa (**SIN ASIGNAR**); No imprima la Carta de Postulación <br/>Dirijase a la Coordinación de Pasantías, para solventar su problema.</strong></p>
      
      
      <h3 align="center"><a target="_new" href="reporte_carta_postulacion5.php?id=<?php echo $row_Consulta_Estudiante['id']; ?>"><strong>Carta de Postulación</strong></a><strong> -  <a href="estudiantes_cartas5.php">Volver a  Estudiante</a></strong><a href="estudiantes_cartas4.php"></a></h3>
      <?php } // Show if recordset not empty ?>
<h2 style="color:#F00"><strong>
<?php if ($totalRows_Consulta_Estudiante == 0) { // Show if recordset empty ?>
  No se encontrar&oacute;n datos en la Consulta. <a href="estudiantes_cartas5.php">Volver a Estudiante</a>
  <?php } // Show if recordset empty ?>
</strong></h2>

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
mysql_free_result($Consulta_Estudiante);
?>
