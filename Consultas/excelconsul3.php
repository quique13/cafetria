<?
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
    header ("Cache-Control: no-cache, must-revalidate");  
    header ("Pragma: no-cache");  
    header("Content-type: application/vnd.ms-excel");
    header ("Content-Disposition: attachment; filename=\"prueba.csv\"" );
	

include("Conexion.php");

$fecha1 = $_GET['fecha1']; 
$fecha2 = $_GET['fecha2']; 

$query = "SELECT * FROM gastos WHERE fecha>='$fecha1' AND fecha<='$fecha2'";
$result = mysqli_query($query) or die("Error en la instruccion SQL");

if ($row = mysqli_fetch_array($result)){



echo "id,Codigo_Usuario,Nombre,Monto_Total,Descripcion,Fecha,Hora\n";

do {
echo $row["id"].",".$row["codigo_usuario"].",".$row["nombre"].",".$row["monto_total"].',"'.$row["descripcion"].'",'.$row["fecha"].",".$row["hora"]."\n";

} while ($row = mysqli_fetch_array($result));

} else {
echo"Sin datos";
}
   /*echo "uno;dos;tres;cuatro;cinco;seis;\n";
    echo "siete;ocho;nueve;diez;once;4;\n";
    echo "doce;trece;catorce;quince;46;ah;\n";*/
 ?>