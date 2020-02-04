<?php
include('Conexion.php');


$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['totalUni'];

$Cod=$_POST['Codigo_Barra'];
$tipo=$_POST['tipo'];
if($tipo=='efectivo' && ($Cod=='' || $Cod==0))
{
	$Cod='000';
} else {
	if (strlen($Cod) > 3) {
		#substr($Cod,0,7)
		if (((int)substr($Cod,0,-3)) > 0) {
			$Cod_temp=((int)substr($Cod,0,-3)).substr($Cod,-3);
		} else {
			$Cod_temp=substr($Cod,-3);
		}
		$Cod=$Cod_temp;
	}
	
}
## print $Cod;
if($tipo=='credito')
{
	$tipo_compra='credito';
}else
	$tipo_compra='efectivo';

$consulta=mysql_query("SELECT * FROM usuario WHERE codigo_usuario='$Cod' AND estado = 'a'") or die("error en la consulta Codigo Principal");

if ($row=mysql_fetch_array($consulta))
{
	$consulta2=mysql_query("SELECT id_detalle_fact FROM cafeteria.gastos_nuevos
order by id_gasto desc
limit 1; ");
	$row2=mysql_fetch_array($consulta2);
	$id_detalle=$row2['id_detalle_fact']+1;
	$nombre = $row['nombre'];
	$fecha = date("Y-m-d H:i:s");
	$count=count($descripcion);
	
	for($i=0;$i<$count;$i++)
	{
		if(trim($cantidad[$i])>0)
		{
			$monto=$cantidad[$i]*$precio[$i];
			$monto=number_format($monto,2);
			$consulta=mysql_query("insert into gastos_nuevos (
			codigo_usuario,id_detalle_fact,nombre,cantidad,precio_unitario,monto_total,descripcion,fecha,tipo_compra) 
			values ('$Cod','$id_detalle','$nombre','$cantidad[$i]','$precio[$i]','$monto','$descripcion[$i]','$fecha','$tipo_compra')") or die("Error en insert gastos");
		}
	}
	$cadena.='<meta http-equiv="Refresh" content="3;URL=index.php">';

//echo date("r");


 $cadena =0;  
   

}
else
{

//echo "Usuario no Registrado, Intentar de Nuevo o por favor comunicarse con Recursos Humanos ";
 $cadena = 1; 

}

mysql_close();



$array=array('error'=>$cadena);
echo json_encode($array);
?>