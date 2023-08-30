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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['contrasena'];
  $MM_fldUserAuthorization = "nivel";
  $MM_redirectLoginSuccess = "principal_admin.php";
  $MM_redirectLoginFailed = "error_conectar.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conex, $conex);
  
  $LoginRS__query=sprintf("SELECT * FROM t_usuarios WHERE email=%s AND contrasena=%s AND estado = 1",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conex) or die(mysql_error());
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_idUsuario'] = $row_LoginRS["id"];	   
	$_SESSION['MM_Nivel'] = $row_LoginRS["nivel"];   
	
	/*DESCOMENTAR SOLO SI SE USA EL CHECK DE RECORDAR CONTRASEÑA, HABRÁ QUE USAR LA FUNCIÓN generar_cookie()
	if ((isset($_POST["CAMPORECUERDA"])) && ($_POST["CAMPORECUERDA"]=="1"))
	generar_cookie($_SESSION['NOMBREWEB_UserId']);
	*/	 

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administraci&oacute;n</title>
    <link href="../css/efecto.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="../images/logo-original.png" />
	<!-- BOOTSTRAP STYLES-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="../assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
	
</head>
<body>
    <div class="alert alert-danger" align="center"><strong>CÁNDIDA MARÍA DE JESÚS FE Y ALEGRÍA</strong></div>
    <div class="container">
         <div class="row">
                 </div>
                 <div class="panel-body">
                 <form name="form1" id="form1" action="<?php echo $loginFormAction; ?>" method="post" autocomplete="off"><br/>
                 <center><img src="../images/logo-original.png" width="90" height="75">
                 <img src="../images/logo_nuevo.png" width="90" height="75"></center>
                 <h3 align="center" class="color"><strong>Ingrese sus Datos </strong></h3><hr/>
                 <div class="form-group input-group">
                 <span class="input-group-addon">@</span>
                 <input name="email" id="email" type="email" class="form-control" placeholder="Ingrese su Email" required/>
                 </div>
                 <div class="form-group input-group">
                 <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                 <input name="contrasena" id="contrasena" type="password" class="form-control"  placeholder="Ingrese su Contraseña" required />
                </div>
                <button type="submit" name="acceder" id="acceder" class="btn btn-success">
                <span class="glyphicon glyphicon-ok"></span>
                Acceder
                </button>
                <a href="recuperar_contrasena.php" >¿Olvido su Contraseña? </a> 
                <hr />
<label class="color">¿No estás registrado?</label> <a href="registrar.php">Registrate Aqu&iacute;</a>
                 </form>   
        </div>
    </div>
	<script language="javascript">
		document.form1.email.focus();
	</script>

     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
