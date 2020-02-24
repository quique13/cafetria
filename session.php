<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(isset($_SESSION['Datos']))
{
	 session_start();
$consulta_Principal=mysqli_query($conexion, "select id_producto, descripcion from productos
where estado = '1'") or die("error en la consulta menu Principal");

while($row_Principal=mysqli_fetch_array($consulta_Principal))
{
	$Data[$row_Principal['id_producto']]=0;
}
$Data[$row_Principal['id_producto']]=0;
 $_SESSION["Datos"]   =   $Data;
}

?>