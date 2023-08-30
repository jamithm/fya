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

mysql_select_db($database_conex, $conex);
$query_Consulta_6I = "SELECT (@row:=@row+1) AS fila, e.cedula, CONCAT(e.apellidos, ', ', e.nombres) AS estudiante, em.razon_social AS empresa FROM (SELECT @row:=0) r, t_estudiante AS e, t_empresas AS em, t_aescolares AS ae WHERE e.id_empresa = em.id AND e.id_ano = ae.id AND ae.estatus =1 AND e.id_grado =3 AND e.id_especialidad = 1 AND e.estatus = 'ACTIVO'";
$Consulta_6I = mysql_query($query_Consulta_6I, $conex) or die(mysql_error());
$row_Consulta_6I = mysql_fetch_assoc($Consulta_6I);
$totalRows_Consulta_6I = mysql_num_rows($Consulta_6I);
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
    <h1 align="center">Listado de Pasantias Estudiantes de 6to Año Industrial</h1>
    <?php if ($totalRows_Consulta_6I > 0) { // Show if recordset not empty ?>
      <table width="99%" border="1" align="center">
        <tr class="basetabla">
          <td width="5%" align="center"><strong>Nº</strong></td>
          <td width="10%" align="center"><strong>CEDULA</strong></td>
          <td width="40%" align="center"><strong>ESTUDIANTE</strong></td>
          <td width="45%" align="center"><strong>EMPRESA</strong></td>
        </tr>
    <?php do { ?>
      <tr class="brillo">
      	<td align="center"><?php echo $row_Consulta_6I['fila']; ?></td>
        <td align="center"><?php echo $row_Consulta_6I['cedula']; ?></td>
        <td><?php echo $row_Consulta_6I['estudiante']; ?></td>
        <td><?php echo $row_Consulta_6I['empresa']; ?></td>
      </tr>
      <?php } while ($row_Consulta_6I = mysql_fetch_assoc($Consulta_6I)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_Consulta_6I == 0) { // Show if recordset empty ?>
  <h2 align="center" style="color:#F00">No hay datos registrados hasta la fecha</h2>
  <?php } // Show if recordset empty ?>
<h3 align="center" style="color:#E00"><a href="listado_6.php">Volver atrás</a></h3>
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
mysql_free_result($Consulta_6I);
?>
