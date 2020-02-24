<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Refresh" content="5;URL=consultamenu.php">

<title>Untitled Document</title>
<head>
  <style type="text/css">
BODY {
 
  background-image: url(imagen.jpg);
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-position: bottom right;
  color: #FFFFFF; //color a las letras blanco
  
}

</style>
</head>
</head>

<body>

<?php

include("Conexion.php");



$query = "SELECT * FROM gastos ORDER BY ID DESC LIMIT 3";
$result = mysql_query($query) or die("Error en la instruccion SQL");


//echo $fecha1;
//echo $fecha2;


if ($row = mysql_fetch_array($result)){

echo "<br><br><br><br><br><strong><div align='center'>CONSULTA TOTAL</div></strong><br>";

echo "<center><table border = '1'>";
echo "<tr> ";
echo "<td><b>id</b></td> ";
echo "<td><b>Nombre</b></td> ";
echo "<td><b>Monto_Total</b></td> ";
echo "<td><b>Descripcion</b></td> ";
echo "<td><b>Fecha</b></td> ";
echo "<td><b>Hora</b></td> ";
echo "</tr> ";



do {
echo "<tr> ";
echo "<td>".$row["id"]."</td> ";
echo "<td>".$row["nombre"]."</td> ";
echo "<td>".$row["monto_total"]."</td> ";
echo "<td width='200px'>".$row["descripcion"]."</td> ";
echo "<td>".$row["fecha"]."</td> ";
echo "<td>".$row["hora"]."</td> ";

echo "</tr> ";

} while ($row = mysql_fetch_array($result));
echo "</table></center>";


} else {
echo "<br><br><br><br><br><strong><div align='center'>Aún no hay datos que mostrar</div></strong><br>";

}

?>

</body>
</html>
