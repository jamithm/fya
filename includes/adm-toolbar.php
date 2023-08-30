<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../_admin/index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php 
    require_once('../Connections/conex.php');
?>


<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        	<span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
		</button>
    	<a class="navbar-brand" href="principal_admin.php">FE Y ALEGR&Iacute;A</a> 
	</div>
	<div style="color: white;
		padding: 15px 50px 5px 50px;
		float: right;
		font-size: 14px;">
		Fecha: <?php echo date('d-m-Y') ?>
		<?php
		if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username']!=""))
		{
		?>
		<a href="usuario_editar.php" class="btn btn-danger">
        <span class="glyphicon glyphicon-user"></span>
        Modificar Perfil</a> 
		<a href="<?php echo $logoutAction ?>" class="btn btn-danger">
        <span class="glyphicon glyphicon-off"></span>
        Cerrar Sesi&oacute;n</a>
		</div>
		<?php 
		}
		?>
</nav>