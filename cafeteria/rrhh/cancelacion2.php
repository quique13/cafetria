<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Untitled Document</title>

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

<body>
<?
	include("Conexion.php");
	
	$ingreso = $_POST['ingreso'];
	
	$query = "SELECT * FROM usuario WHERE nombre LIKE '%$ingreso%' AND estado='a'";
	$result = mysqli_query($query) or die("Error en la instruccion SQL");

if ($row = mysqli_fetch_array($result)){

echo "<br><strong><div align='center'>VERIFICACI&Oacute;N</div></strong><br>";

echo "<center><table border = '1'>";
echo "<tr> ";
echo "<td><b>No</b></td> ";
echo "<td><b>Codigo</b></td> ";
echo "<td><b>Nombre Completo</b></td> ";
echo "</tr> ";


do {
echo "<tr> ";
echo "<td>".$row["id"]."</td> ";
echo "<td>".$row["codigo_usuario"]."</td> ";
echo "<td>".$row["nombre"]."</td>";
echo "<td>".'<a href="cancelacion3.php?id='.$row["id"].'&codigo_usuario='.$row["codigo_usuario"].'">'.Cancelar."</a></td> ";
echo "</tr> ";

} while ($row = mysqli_fetch_array($result));

echo "</table></center>";
echo "<br><br>";
echo '<center><a href="cancelacion2.php">Atr&aacute;s</a></center>';
echo "<br>";
echo '<center><a href="indexconsulta.php">Index</a></center>';

} else {
echo "<br><br><br><br><br><strong><div align='center'>Aún no hay datos que mostrar</div></strong><br>";
echo "<br><br>";
echo '<center><a href="cancelacion2.php">Atr&aacute;s</a></center>';
echo "<br>";
echo '<center><a href="indexconsulta.php">Index</a></center>';
}
?>
</body>
</html>
