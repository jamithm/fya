<?php
	
	error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
	session_start();


	/*$hostname_conex = "localhost";
	$database_conex = "fya";
	$username_conex = "root";
	$password_conex = "";*/


	$hostname_conex = "mysql.hostinger.es";
	$database_conex = "u484172009_fya";
	$username_conex = "u484172009_root";
	$password_conex = "18305091";
	
	//creamos la conexion con los parmetros del servidor, usuario y pasword
  	$conexion = mysql_connect($hostname_conex,$username_conex,$password_conex);
  	//creamos la conexion a la base de datos
  	mysql_select_db ($database_conex, $conexion) OR die ("No se puede conectar");
	
?>
