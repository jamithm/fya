<?php require_once('Connections/conex.php'); ?>
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
    <h1 align="center">Cont&aacute;ctemos</h1>
   	 <form id="form1" name="form1" method="post" action="mail.php" autocomplete="off">
      <table width="60%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td width="20%" align="right" valign="top"><strong>Nombre:</strong></td>
          <td width="80%" valign="top"><label for="nombre"></label>
            <input name="nombre" type="text" id="nombre" size="30" required placeholder="Ingrese su Nombre" />
          </td>
          <td width="80%" rowspan="6" valign="top">
          	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31402.411139485404!2d-72.33814742601726!3d10.317747100456998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e8a12b74995d86f%3A0x3f771757cbb68db9!2sVilla+del+Rosario+4047%2C+Zulia!5e0!3m2!1ses-419!2sve!4v1474157181824" width="350" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><strong>Tel&eacute;fono:</strong></td>
          <td valign="top"><label for="telefono"></label>
            <input name="telefono" type="text" id="telefono" size="30" required  placeholder="Ingrese su Teléfono" />
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><strong>E-mail:</strong></td>
          <td valign="top"><label for="correo"></label>
            <input name="correo" type="email" id="correo" size="30" required  placeholder="Ingrese su E-mail" />
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><strong>Asunto:</strong></td>
          <td valign="top"><label for="asunto"></label>
            <input name="asunto" type="text" id="asunto" size="30" required  placeholder="Ingrese su Asunto" />
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><strong>Mensaje:</strong></td>
          <td valign="top"><label for="mensaje"></label>
            <textarea name="mensaje" cols="31" rows="5" id="mensaje" required  placeholder="Ingrese su Mensaje" ></textarea>
          </td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top"><input type="submit" name="button" id="button" value="Enviar"  />
            <input type="button" name="button2" id="button2" value="Cancelar" onclick="location.href='index.php'" />
          </td>
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
