<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Untitled Document</title>
<head>
  <style type="text/css">
BODY {
 
   background: #0066CC; 

  background-image:url(imagen.jpg);
  background-attachment: fixed;
  background-repeat: repeat;
 

  color: #FFFFFF; //color a las letras blanco
  
}

</style>
</head>

<center>

<body>

<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><img src="../usuario/top.png" width="900" height="150" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><?php

include("Conexion.php");



$query = "SELECT * FROM gastos ORDER BY codigo_usuario ASC ";
$result = mysql_query($query) or die("Error en la instruccion SQL");


//echo $fecha1;
//echo $fecha2;


if ($row = mysql_fetch_array($result)){

echo "<br><br><br><br><br><strong><div align='center'>CONSULTA TOTAL</div></strong><br>";

echo "<center><table border = '1'>";
echo "<tr> ";
echo "<td><b>id</b></td> ";
echo "<td><b>Codigo_Usuario</b></td> ";
echo "<td><b>Nombre</b></td> ";
echo "<td><b>Monto_Total</b></td> ";
echo "<td><b>Descripcion</b></td> ";
echo "<td><b>Fecha</b></td> ";
echo "<td><b>Hora</b></td> ";
echo "</tr> ";


do {
echo "<tr> ";
echo "<td>".$row["id"]."</td> ";
echo "<td>".$row["codigo_usuario"]."</td> ";
echo "<td>".$row["nombre"]."</td> ";
echo "<td>".$row["monto_total"]."</td> ";
echo "<td width='200px'>".$row["descripcion"]."</td> ";
echo "<td>".$row["fecha"]."</td> ";
echo "<td>".$row["hora"]."</td> ";

echo "</tr> ";

} while ($row = mysql_fetch_array($result));
echo "</table></center>";
echo "<br><br>";
echo '<center><a href="indexconsulta.php">IndexConsulta</a></center>';

} else {
echo "<br><br><br><br><br><strong><div align='center'>Aún no hay datos que mostrar</div></strong><br>";
echo "<br><br>";
echo '<center><a href="indexconsulta.php">IndexConsulta</a></center>';
}

?>
      <form id="form1" name="form1" method="post" action="excelconsulta.php">
        <br />
        <br />
        <div align="center">
        <input type="submit" name="button" id="button" value="Exportar Excel" />
        </div>
        <br />
      </form></td>
  </tr>
</table>
</body>
</center>
</html>
