<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<meta http-equiv="Refresh" content="10;URL=indexconsulta.php">

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
<?php

include("Conexion.php");

$id= $_GET['id'];
$codigo_usuario= $_GET['codigo_usuario'];


$query="Update usuario set estado='c' Where id = '".$_GET['id']."' And codigo_usuario = '".$_GET['codigo_usuario']."'";

mysqli_query($query);

?>

<h1><div align="center">Registro Borrado</div></h1>
<div align="center"><a href="cancelacion2.php">Atr&aacute;s</a></div>
<br/>
<div align="center"><a href="indexconsulta.php">Index</a></div>

</body>
</html>
