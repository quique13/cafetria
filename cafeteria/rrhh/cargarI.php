<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<center>
<br/>
<br/>
<br/>
<form action="subir.php" method="POST" enctype="multipart/form-data">
	<label for="imagen">Producto:</label>
	<? 
	include ('Conexion.php');
	$consult = "SELECT id_producto,descripcion FROM cafeteria.productos
where estado ='1'";
$result = mysql_query($consult) or die(mysql_error());
    ?><select  name="id_producto[]">
  <? while ($row = mysql_fetch_array($result))
  {
	 ?><option value="<? echo $row['id_producto']?>"><? echo $row['descripcion']?></option> 
  <? } ?>
</select>
	<label for="imagen">Imagen:</label>
	<input type="file" name="imagen" id="imagen" />
	<input type="submit" name="subir" value="Subir"/>
</form>
</center>
</body>
</html>
