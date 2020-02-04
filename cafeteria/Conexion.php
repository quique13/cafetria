<?php
//$mysql_host = "172.29.10.100";
$mysql_host = "172.29.11.26";
$mysql_database = "cafeteria";
$mysql_user = "esaavedra";
//$mysql_password = "EsAAv20166";
$mysql_password = "EsAAv2016";
//Conexión
    $conexion = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die("Problemas al tratar de establecer la conexion");
//Seleccionar Base de Datos
	$bd_sel = mysql_select_db($mysql_database) or die("Problemas al  seleccionar la base de datos");
	mysql_query ("SET NAMES 'utf8'");
?>