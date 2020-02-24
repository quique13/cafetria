<?
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
    header ("Cache-Control: no-cache, must-revalidate");  
    header ("Pragma: no-cache");  
    header("Content-type: application/vnd.ms-excel");
    header ("Content-Disposition: attachment; filename=\"ConsultaTotales2.csv\"" );
	

include("Conexion.php");

$fecha1 = $_GET['fecha1']; 
$fecha2 = $_GET['fecha2'];
$monto_total = $_GET['monto_total'];
$codigo_usuario = $_GET['codigo_usuario'];
$nombre = $_GET['nombre']; 

	$query3 = "SELECT SUM(monto_total) as monto_total FROM gastos WHERE fecha>='$fecha1' AND fecha<='$fecha2'";
		$result3 = mysqli_query($query3) or die("Error en la instruccion SQL");

if ($row3 = mysqli_fetch_array($result3)){

do {

	$totaldetotal = $row3['monto_total'];
	echo "Total: ".$totaldetotal."\n";
    echo "Codigo_Usuario,Nombre,Monto_Total\n";
	
	

} while ($row3 = mysqli_fetch_array($result3));


} 



$query2 = "SELECT * FROM usuario";
$result2 = mysqli_query($query2) or die("Error en la instruccion SQL");

if ($row2 = mysqli_fetch_array($result2)){

do {
 
 $codigo_usuario=$row2['codigo_usuario'];
 $nombre=$row2['nombre'];
 



	 	$query = "SELECT SUM(monto_total) as monto_total FROM gastos WHERE fecha>='$fecha1' AND fecha<='$fecha2' AND 		   	codigo_usuario='$codigo_usuario'";
		$result = mysqli_query($query) or die("Error en la instruccion SQL");

		

		if ($row = mysqli_fetch_array($result)){
		
		

			do {
             
			echo $row2["codigo_usuario"].",".$row2["nombre"].",".$row["monto_total"]."\n";

             

				} while ($row = mysqli_fetch_array($result));



	  } else {
		echo "Sin datos";
}


} while ($row2 = mysqli_fetch_array($result2));
}
 ?>