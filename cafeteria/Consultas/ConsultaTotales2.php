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


<body><center>

<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><img src="../usuario/top.png" width="900" height="150" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">

<?php

include("Conexion.php");

$fecha1 = $_POST['fecha1']; 
$fecha2 = $_POST['fecha2'];
 

	$query3 = "SELECT SUM(monto_total) as monto_total FROM gastos WHERE fecha>='$fecha1' AND fecha<='$fecha2'";
	$result3 = mysql_query($query3) or die("Error en la instruccion SQL");

if ($row3 = mysql_fetch_array($result3)){

do {
	
	echo "<br><br><br><br><strong><div align='center'>CONSULTAS TOTALES DE LOS COLABORADORES</div></strong><br>";  
	echo "<br><br>";
	echo "Total: ".$row3['monto_total'];

} while ($row3 = mysql_fetch_array($result3));



	  } else {
	
	}



$query2 = "SELECT * FROM usuario";
$result2 = mysql_query($query2) or die("Error en la instruccion SQL");

if ($row2 = mysql_fetch_array($result2)){

do {
 
 $codigo_usuario=$row2['codigo_usuario'];
 $nombre=$row2['nombre'];
 



	 	$query = "SELECT SUM(monto_total) as monto_total FROM gastos WHERE fecha>='$fecha1' AND fecha<='$fecha2' AND 		 	codigo_usuario='$codigo_usuario'";
		$result = mysql_query($query) or die("Error en la instruccion SQL");

echo "<table border = '1'>";
echo "<table widht=600px border=1px>";
		if ($row = mysql_fetch_array($result)){

			do {
             
			//echo  $codigo_usuario." ".$nombre." ".$row["monto_total"];
			echo "<tr><td width=200px>".$codigo_usuario."</td><td width=200px>".$nombre."</td><td width=200px>".$row["monto_total"]."</td></tr>";


				} while ($row = mysql_fetch_array($result));



	  } else {
		echo "<tr><td width=200px>".$codigo_usuario."</td><td width=200px>".$nombre."</td><td width=200px>0</td></tr>";
	}
	echo "</table>";
} while ($row2 = mysql_fetch_array($result2));
}
?>
      <form id="form1" name="form1" method="post" action="excelConsultaTotales.php?fecha1=<?php echo $fecha1; ?>&amp;fecha2=<?php echo $fecha2; ?>&amp;monto_total=<?php echo $monto_total; ?>&amp;codigo_usuario=<?php echo $codigo_usuario; ?>&amp;nombre=<?php echo $nombre;?>">
        <p><br />
            <br />
        </p>
        <div align="center">
        <input type="submit" name="button" id="button" value="Exportar Excel" />
        <?php   
echo "<br><br><br><br><br><br>";
echo '<center><a href="indexconsulta.php">IndexConsulta</a></center>';	?>
      </form></td>
  </tr>
</table>
</center>
</body>
</html>
