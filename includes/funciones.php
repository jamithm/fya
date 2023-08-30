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

function ObtenerNombreUsuario($identificador)
{
	global $database_conex, $conex;
	mysql_select_db($database_conex, $conex);
	$query_ConsultaFuncion = sprintf("SELECT t_usuarios.nombre FROM t_usuarios WHERE t_usuarios.id=%s", $identificador);
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion, $conex) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	return $row_ConsultaFuncion['nombre'];
	mysql_free_result($ConsultaFuncion);
}

function ObtenerNombreEstudiante($id)
{
	global $database_conex, $conex;
	mysql_select_db($database_conex, $conex);
	$query_ConsultaFuncion1 = sprintf("SELECT concat(t_estudiantes.apellidos, ' ', t_estudiantes.nombres) as estudiante FROM t_estudiantes WHERE t_estudiantes.id=%s", $id);
	$ConsultaFuncion1 = mysql_query($query_ConsultaFuncion1, $conex) or die(mysql_error());
	$row_ConsultaFuncion1 = mysql_fetch_assoc($ConsultaFuncion1);
	$totalRows_ConsultaFuncion1 = mysql_num_rows($ConsultaFuncion1);
	return $row_ConsultaFuncion1['estudiante'];
	mysql_free_result($ConsultaFuncion1);
}

function NuevaContrasena($long){
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$passw = "";
	
	$lng_cadena = strlen($cadena);
	$longitud = $long;
	
	for($x=1;$x<=$longitud;$x++){
		$aleatorio = mt_rand(0,$lng_cadena-1);
		$passw .= substr($cadena,$aleatorio,1);
	}
	return $passw;
}

function CodigoActivacion($long){
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$codigo = "";
	
	$lng_cadena = strlen($cadena);
	$longitud = $long;
	
	for($x=1;$x<=$longitud;$x++){
		$aleatorio = mt_rand(0,$lng_cadena-1);
		$codigo .= substr($cadena,$aleatorio,1);
	}
	return $codigo;
}

?>


