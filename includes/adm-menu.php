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
	mysql_select_db($database_conex, $conex);
	$query_Consulta_Foto = sprintf("select foto from t_usuarios where id = %s", GetSQLValueString($_SESSION['MM_idUsuario'], "int"));
	$Consulta_Foto = mysql_query($query_Consulta_Foto, $conex) or die(mysql_error());
	$row_Consulta_Foto = mysql_fetch_assoc($Consulta_Foto);
	$totalRows_Consulta_Foto = mysql_num_rows($Consulta_Foto);
	 	$_SESSION['MM_Foto'] = $row_Consulta_Foto['foto'];
?>

<nav class="navbar-default navbar-side" role="navigation">
<div class="sidebar-collapse">
    <ul class="nav" id="main-menu">
        <li class="text-center">
        	<img src="../fotos/<?php echo $_SESSION['MM_Foto'];?>" class="user-image img-responsive"/>        
        </li>
        <div class="row" align="center">
        	<div class="col-lg-12"> 
            <?php
			if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username']!="")){
			?>
				<h4 style="color:#FFF"><?php echo ObtenerNombreUsuario($_SESSION['MM_idUsuario']); ?></h4>
			<?php
			}
			?>
              	
           </div>
       </div> 
        <li>
            <a class="active-menu"  href="principal_admin.php"><i class="fa fa-dashboard fa-1.5x"></i> INICIO</a>
        </li>
       	<?php   
        if ($_SESSION["MM_Nivel"] == 1 || $_SESSION["MM_Nivel"] == 2 || $_SESSION["MM_Nivel"] == 3){
		echo'
        <li>
            <a href="listado_aescolares.php"><i class="fa fa-edit fa-1x"></i>A&Nacute;OS ESCOLARES</a>
        </li>';
		} else {
			echo '<li>
            <a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>A&Nacute;OS ESCOLARES</a>
        	</li>';
		}
		?>
        <?php   
        if ($_SESSION["MM_Nivel"] == 1 || $_SESSION["MM_Nivel"] == 2 || $_SESSION["MM_Nivel"] == 3){
		echo'
        <li>
        	<a href="listado_empresas.php"><i class="fa fa-edit fa-1x"></i>EMPRESAS</a>
       	</li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>EMPRESAS</a>
		</li>';
		}
		?>
		<?php   
        if ($_SESSION["MM_Nivel"]==1 || $_SESSION["MM_Nivel"]==2 || $_SESSION["MM_Nivel"]==3 || $_SESSION["MM_Nivel"]==4){
		echo'
        <li>
        	<a href="seleccion_aescolar.php"><i class="fa fa-edit fa-1x"></i>ESTUDIANTES</a>
        </li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>ESTUDIANTES</a>
		</li>';
		}
		?>
        <?php   
        if ($_SESSION["MM_Nivel"]==1 || $_SESSION["MM_Nivel"]==2 || $_SESSION["MM_Nivel"]==3 || $_SESSION["MM_Nivel"]==4 || $_SESSION["MM_Nivel"]==5){
		echo'
        <li>
        	<a href="listado_publicidades.php"><i class="fa fa-edit fa-1x"></i>PUBLICIDADES</a>
        </li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>PUBLICIDADES</a>
		</li>';
		}
		?>
        <?php
        if ($_SESSION["MM_Nivel"]==1 || $_SESSION["MM_Nivel"]==2 || $_SESSION["MM_Nivel"]==3 || $_SESSION["MM_Nivel"]==4 || $_SESSION["MM_Nivel"]==5){
		echo'
        <li>
        	<a href="listado_galerias_fotos.php"><i class="fa fa-edit fa-1x"></i>GALER&Iacute;AS</a>
        </li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>GALER&Iacute;AS</a>
		</li>';
		}
		?>
		<?php
        if ($_SESSION["MM_Nivel"]==1){
		echo'
        <li>
        	<a href="listado_usuarios.php"><i class="fa fa-edit fa-1x"></i>USUARIOS</a>
        </li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>USUARIOS</a>
		</li>';
		}
		?>
 		<?php
        if ($_SESSION["MM_Nivel"]==1 || $_SESSION["MM_Nivel"]==3){
		echo'
        <li>
        	<a href="listado_firmantes.php"><i class="fa fa-edit fa-1x"></i>FIRMANTES</a>
        </li>';
		} else {
			echo '<li> 
			<a href="#" onclick="mensaje();"><i class="fa fa-edit fa-1x"></i>FIRMANTES</a>
		</li>';
		}
		?>
    </ul>       
</div>
</nav>

<script language = "javascript" type="text/javascript">
 function mensaje()
{
	alert("NO TIENE ACCESO A ESTE M&Oacute;DULO\n\nCONSULTE CON EL ADMINISTRADOR DEL SISTEMA...!"); 
}

</script>