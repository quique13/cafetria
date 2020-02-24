<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('Conexion.php');
 session_start();
	 if(!isset($_SESSION['Datos']))
{
	$consulta_Principal=mysqli_query($conexion,"select id_producto, descripcion from productos
	where estado = '1'") or die("error en la consulta menu Principal");

	while($row_Principal=mysqli_fetch_array($consulta_Principal))
	{
		$Data[$row_Principal['id_producto']];
	}
	
	$_SESSION["Datos"]=$Data;
}

	//$nombre=$_POST['producto'];
	//$cantidad=$_POST['cantidad'];
	//$precio=$_POST['precio'];
	$descripcion='';
	$descripcion2='';
	$count=count($nombre);
	$suma=0;
	$total_pedido=0;
	$descripcion="<form id='guardar' name='guardar' method='post'>
	<table width='300'  style='table-layout:fixed; font-size:12px' class=' table- table-bordered' >
					<tr>
						<th width='50' style='white-space: nowrap;' align='center'>Cant.</th>
						<th width='120' style='white-space: nowrap;' align='center'>Producto</th>
						<th width='65' style='white-space: nowrap;' align='center'>Precio</th>
						<th width='65' style='white-space: nowrap;' align='center' >Sub-Total</th>
					</tr>";
	$consulta=mysqli_query($conexion,"select * from productos as p
inner join categoria_producto as cp
on
p.id_producto=cp.id_producto
	where p.estado = '1'
	order by cp.id_categoria,p.descripcion") or die("error en la consulta menu Principal");
	while($row=mysqli_fetch_array($consulta))
	{
		if(trim($_SESSION["Datos"][$row["id_producto"]])>0)
		{
			
			//echo $nombre[$i].' - '.$cantidad[$i].' - '.$precio[$i].'<br>';
			$subtotal=($_SESSION["Datos"][$row["id_producto"]]*$row["precio"]);
			$descripcion.="<tr>
								<td   align='center'>".$_SESSION["Datos"][$row["id_producto"]]."</td>
								<td   align='center'>".utf8_encode($row["descripcion"])."</td>
								<td   align='center'>".$row["precio"]."</td>
								<td  align='center'>".number_format($subtotal,2)."</td>
							</tr>
							
							<input type='hidden' name='descripcion[]' id='descripcion[]' value='".utf8_encode($row["descripcion"])."'/>
            <input type='hidden' name='totalUni[]' id='totalUni' value='".$row["precio"]."'/>
			<input type='hidden' name='cantidad[]' id='cantidad' value='".$_SESSION["Datos"][$row["id_producto"]]."'/>";
			$descripcion2=$descripcion2.=$cantidad[$i].' X '.$nombre[$i].', ';				
			$total_pedido=$total_pedido+$subtotal;
		}
	}
	$descripcion.="</table>
	<h3>Total: Q.".number_format($total_pedido,2)."</h3> ";
   $cadena.='<h3>Detalle de Compra</h3>'; 
   $cadena.=$descripcion;
   $cadena.='
      </form></td>
    </td>
  </tr>
</table>
</body>
</html>';

$hoy=date("Y-m-d");

$query = "SELECT * FROM gastos_nuevos WHERE fecha between'$hoy 00:00:00' and '$hoy 23:59:59' ORDER BY id_gasto DESC LIMIT 5";
$result = mysqli_query($conexion,$query) or die("Error en consulta ultimos 5 gastos");


//echo $fecha1;
//echo $fecha2;


if ($row = mysqli_fetch_array($result))
{

	$cadena.='<h3>Ultimas 5 compras</h3>';
	
	$cadena.="<table width='300'  style='table-layout:fixed; font-size:12px' class=' table- table-bordered' >";
	$cadena.="<tr> ";
	$cadena.="<td><b>Nombre</b></td> ";
	$cadena.="<td><b>Monto_Total</b></td> ";
	$cadena.="<td><b>Descripcion</b></td> ";
	$cadena.="</tr> ";
	
	
	
	do {
			$cadena.= "<tr> ";
			$cadena.= "<td>".$row["nombre"]."</td> ";
			$cadena.= "<td>".$row["monto_total"]."</td> ";
			$cadena.= "<td width='200px'>".utf8_encode($row["descripcion"])."</td> ";
			
			$cadena.= "</tr> ";

		} 
	while ($row = mysqli_fetch_array($result));
$cadena.= "</table></center>";


} else {
 $cadena.='<h3>Aún no hay datos que mostrar</h3>';

}


$array=array('result'=>$cadena);
echo json_encode($array);
