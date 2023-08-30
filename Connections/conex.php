<?php if (!isset($_SESSION)) {
  session_start();
}
?>

<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

/*$hostname_conex = "localhost";
$database_conex = "fya";
$username_conex = "root";
$password_conex = "";*/


$hostname_conex = "mysql.hostinger.es";
$database_conex = "u484172009_fya";
$username_conex = "u484172009_root";
$password_conex = "18305091";


$conex = mysql_pconnect($hostname_conex, $username_conex, $password_conex) or trigger_error(mysql_error(),E_USER_ERROR); 
?>

<?php 
	if (is_file("../includes/funciones.php")){
		include("../includes/funciones.php");
	} else {
		include ("includes/funciones.php");
	}
?>