<?php
$host_server = "172.29.11.176";
//$host_server = "172.29.10.20";
$database_server = "oca_sac";
$user_server = "sa";
$password_server = "oca";
		//Conexión
	$conexionserver = mssql_connect($host_server, $user_server, $password_server) or die("Problemas al tratar de establecer la conexion server gt");
	$bd_sel_server = mssql_select_db($database_server,$conexionserver) or die("Problemas al  seleccionar la base de datos ".$database_server);
?>


