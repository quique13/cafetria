<?php
$mysqli_host = "172.29.10.100";
$mysqli_database = "cafeteria";
$mysqli_user = "smilian";
$mysqli_password = "smilian2013";
//Conexión
    $conexion = mysqli_connect($mysqli_host, $mysqli_user, $mysqli_password) or die("Problemas al tratar de establecer la conexion");
//Seleccionar Base de Datos
	$bd_sel = mysqli_select_db($mysqli_database) or die("Problemas al  seleccionar la base de datos");
?>