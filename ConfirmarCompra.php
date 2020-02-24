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
$tipo=$_POST['tipo'];

	$descripcion2='';
	$count=count($nombre);
	$suma=0;
	if($tipo=='credito')
{
	$cadena.=' <br />
       
          <div align="center">
          <h1>Ingrese Codigo de Barras(Compra credito)</h1>'; 
   $cadena.="<h3>Detalle de compra</h3>";
   $cadena.="<br>";
	$cadena.='<form id="conf" name="conf" method="post" action="javascript: confirmarCodigo(\'conf\')">
	<table style="table-layout:fixed; font-size:16px" class=" table- table-bordered" >
					<tr>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Cantidad</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Producto</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Precio</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center" >Sub-Total</th>
					</tr>';
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
			$cadena.="<tr>
								<td style='white-space: nowrap;'  align='center'>".$_SESSION["Datos"][$row["id_producto"]]."</td>
								<td style='white-space: nowrap; padding:3px 10px 3px 10px '' align='center'>". utf8_encode($row["descripcion"])."</td>
								<td style='white-space: nowrap;' align='center'>".$row["precio"]."</td>
								<td style='white-space: nowrap;' align='center'>".number_format($subtotal,2)."</td>
							</tr>
							<input type='hidden' name='descripcion[]' id='descripcion[]' value='".utf8_encode($row["descripcion"])."'/>
            <input type='hidden' name='totalUni[]' id='totalUni' value='".$row["precio"]."'/>
			<input type='hidden' name='cantidad[]' id='cantidad' value='".$_SESSION["Datos"][$row["id_producto"]]."'/>";
			$descripcion2=$descripcion2.=$cantidad[$i].' X '.$nombre[$i].', ';				
			$total_pedido=$total_pedido+$subtotal;
		}
	}
	$cadena.="</table>";
 
   $cadena.="<br>";
   $cadena.="<font size=\"6\"><strong>Total Gastado: Q.".number_format($total_pedido,2)."</strong></font>";
   
          $cadena.='<br />
          <br />
          <label>Codigo Barra
            <font color="black"><input type="password" name="Codigo_Barra" id="Codigo_Barra"/><font>
			<input type="hidden" name="tipo" id="tipo" value="credito"/>
          </label>
       <button  type="submit" id="conf_compra" class="btn btn-primary btn-md" title="Confirmar compra" ><span class="glyphicon glyphicon-ok">Confirmar</span></button>
		<br><br>
		<a href="index.php">MENU</a>
      </form>';
}else if($tipo=='efectivo')
{
	
	$cadena.=' <br />
       
          <div align="center">
          <h1>Ingrese Codigo de Barras(Compra efectivo)</h1>'; 
   $cadena.="<h3>Detalle de compra</h3>";
   $cadena.="<br>";
	$cadena.='<form id="conf" name="conf" method="post" action="javascript: confirmarCodigo(\'conf\')">
	<table style="table-layout:fixed; font-size:16px" class=" table- table-bordered" >
					<tr>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Cantidad</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Producto</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center">Precio</th>
						<th style="white-space: nowrap; padding:5px 10px 5px 10px" align="center" >Sub-Total</th>
					</tr>';
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
			$cadena.="<tr>
								<td style='white-space: nowrap;'  align='center'>".$_SESSION["Datos"][$row["id_producto"]]."</td>
								<td style='white-space: nowrap; padding:3px 10px 3px 10px '' align='center'>".utf8_encode($row["descripcion"])."</td>
								<td style='white-space: nowrap;' align='center'>".$row["precio"]."</td>
								<td style='white-space: nowrap;' align='center'>".number_format($subtotal,2)."</td>
							</tr>
							<input type='hidden' name='descripcion[]' id='descripcion[]' value='".utf8_encode($row["descripcion"])."'/>
            <input type='hidden' name='totalUni[]' id='totalUni' value='".$row["precio"]."'/>
			<input type='hidden' name='cantidad[]' id='cantidad' value='".$_SESSION["Datos"][$row["id_producto"]]."'/>";
			$descripcion2=$descripcion2.=$cantidad[$i].' X '.$nombre[$i].', ';				
			$total_pedido=$total_pedido+$subtotal;
		}
	}
	$cadena.="</table>";
 
   $cadena.="<br>";
   $cadena.="<font size=\"6\"><strong>Total Gastado: Q.".number_format($total_pedido,2)."</strong></font>";
   
          $cadena.='<br />
          <br />
          <label>Codigo Barra
            <font color="black"><input type="password" name="Codigo_Barra" id="Codigo_Barra"/><font>
				<input type="hidden" name="tipo" id="tipo" value="efectivo"/>
          </label>
       <button  type="submit" id="conf_compra" class="btn btn-primary btn-md" title="Confirmar compra" ><span class="glyphicon glyphicon-ok">Confirmar</span></button>
		<br><br>
		<a href="index.php">MENU</a>
      </form>';
}

$array=array('result'=>$cadena);
echo json_encode($array);
