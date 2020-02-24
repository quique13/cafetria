<?php
//$mysqli_host = "172.29.10.100";
$mysqli_host = "localhost";
$mysqli_database = "cafeteria";
$mysqli_user = "root";
//$mysqli_password = "EsAAv20166";
$mysqli_password = "";
//Conexión
//$mysqli = new mysqli(mysqli_host, $mysqli_user, $mysqli_password, $mysqli_database);
$conexion = mysqli_connect($mysqli_host, $mysqli_user, $mysqli_password,$mysqli_database) or die("Problemas al tratar de establecer la conexion");
	
?>