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
    <h1 align="center">Estudiante -> Carta de Postulación</h1>
    <form id="form1" name="form1" method="get" action="busqueda_estudiante4.php?$cedula=cedula" autocomplete="off">
      <table width="99%" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td width="50%" align="right"><strong>Ingrese su C&eacute;dula:</strong></td>
          <td width="50%" align="left"><label for="cedula"></label>
          <input name="cedula" type="text" id="cedula" size="32" placeholder="Ingrese su Cédula o Cédula Escolar" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="button" id="button" value="Busqueda" /></td>
        </tr>
        <tr>
          <td colspan="2"><h3 align="center" style="color:#F00"><strong>Nota: Si no posee C&eacute;dula de Identidad, busque en el listado su C&eacute;dula Escolar, <br />para realizar la busqueda de la Carta de Postulación</strong></h3></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
    </form>
  <!-- InstanceEndEditable --><!-- end .sidebar1 --></div>
  <div class="content"><!-- InstanceBeginEditable name="ParteDerecha" -->

  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
  <?php include("includes/pie.php"); ?>  	
  <!-- end .footer --></div>
  <!-- end .container --></div>
</body>

<!-- InstanceEnd --></html>
