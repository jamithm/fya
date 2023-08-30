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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $fecha = date('Y-m-d');
  $insertSQL = sprintf("INSERT INTO t_galerias (titulo, fecha_alta, descripcion) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['titulo'], "text"),
                       GetSQLValueString($fecha, "date"),
					   GetSQLValueString($_POST['descripcion'], "text"));

  mysql_select_db($database_conex, $conex);
  $Result1 = mysql_query($insertSQL, $conex) or die(mysql_error());

  $insertGoTo = "listado_galerias_fotos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$varAdministrar = "0";
if (isset($_GET['id'])) {
  $varAdministrar = $_GET['id'];
}
mysql_select_db($database_conex, $conex);
$query_Administrar = sprintf("SELECT * FROM t_galerias WHERE t_galerias.id = %s", GetSQLValueString($varAdministrar, "int"));
$varAdministrar = mysql_query($query_Administrar, $conex) or die(mysql_error());
$row_varAdministrar = mysql_fetch_assoc($varAdministrar);
$totalRows_varAdministrar = mysql_num_rows($varAdministrar);
?>
<!DOCTYPE HTML>
<html><!-- InstanceBegin template="/Templates/Admininstracion.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Administraci�n</title>
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
                <h2>Administrar Fotos</h2>
                <h2>Seleccione las Fotos que desea subir a la Galer�a</h2>
              </div>
            </div>
            <a href="listado_galerias_fotos.php" class="btn btn-outline btn-info">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Volver atr�s</a>
    		<br />
            <br />
            <div class="row">
                 <div class="row">
                                <div class="col-lg-8">
                         <form role="form" action="administrar_fotos_upload.php" method="post" enctype="multipart/form-data" name="form1" id="form1" autocomplete="off">
                         	<input type="hidden" name="id" id="id" value="<?php echo $row_varAdministrar['id']; ?>">
             			<div id="inputs_file">
                                <div class="form-group">                 
                                <input name="titulo[]" class="form-control" placeholder="Ingrese Titulo de la Galer�a de Fotos" type="hidden" required="required" value="foto" />
                                </div>
                                 <div class="form-group">
                                <input name="archivo[]" class="form-control" type="file" required="required"  />
                                </div>
                       	</div>
                        	<div class="form-group">
                             <button type="button" id="otra_foto" class="btn btn-primary"> 
                             <span class="glyphicon glyphicon-plus">
                             </span>  Agregar una Nueva Foto
                             </button>
                             </div>
                             <div class="form-group">
                             <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved">
                             </span>   Publicar Todas las Fotos
                             </button>
                             <input name="MM_insert" type="hidden" value="form1" />
                             </div>
                             
				  <script type="text/javascript">
                    var boton = document.getElementById('otra_foto');
                    boton.onclick = function(){
                        var div_cont = document.createElement('div');
                        var input1 = document.createElement('input');	
                            input1.type='hidden';
                            input1.name='titulo[]';
							input1.value='foto';
							input1.className ='form-control';
							
                        var input2 = document.createElement('input');
                            input2.type='file';
                            input2.name='archivo[]';
							input2.className='form-control';
							
                        var div = document.getElementById('inputs_file');
                            div_cont.appendChild(input1);
                            div_cont.appendChild(input2);
                            div.appendChild(div_cont);	
  					}
					                
                </script>                
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
