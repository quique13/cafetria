<?php
include('Conexion.php');
session_start();
$oper=$_POST['oper'];
$total=$_POST['total'];
$precio=$_POST['precio'];
$id_cat=$_POST['cat'];
$cantSum=0;
if(isset($_SESSION['Datos']))
{
	$consulta_Principal=mysql_query("select id_producto, descripcion from productos
	where estado = '1'") or die("error en la consulta menu Principal");

	while($row_Principal=mysql_fetch_array($consulta_Principal))
	{
		$Data[$row_Principal['id_producto']]=0;
	}
	$id=$_POST['id'];
	if($oper=='mas')
	{
		$_SESSION["Datos"] [$id]=$_SESSION["Datos"] [$id]+1;
		$total=$total+$precio;

	}else if ($oper=='menos' && $_SESSION["Datos"] [$id]>0 )
	{
		$_SESSION["Datos"] [$id]=$_SESSION["Datos"] [$id]-1;
		$total=$total-$precio;
	}
	
}else
{
	$consulta_Principal=mysql_query("select id_producto, descripcion from productos
	where estado = '1'") or die("error en la consulta menu Principal");
	while($row_Principal=mysql_fetch_array($consulta_Principal))
	{
		$Data[$row_Principal['id_producto']]=0;
	}
	$_SESSION["Datos"] [$id]=$Data;
	
}

$total2[$total]=$total;
$count='0';

$consulta_menu=mysql_query("select cp.*, p.descripcion as producto,p.imagen_producto as imagen,p.precio from categoria_producto as cp
							inner join productos as p
							on
							cp.id_producto= p.id_producto
							where p.estado = '1'
							and cp.id_categoria='$id_cat'
 							order by p.descripcion") or die(mysql_error());
if($row_menu=mysql_num_rows($consulta_menu)>=1)
{
	$cadena='
	<table style="table-layout:fixed; font-size:14px" class=" table table- table-bordered " >
	<caption><center><font color="white"><h2><button type="button" class="btn btn-danger btn-md pull-left" title="Pago con efectivo" onClick="confirmarCompra(\'efectivo\')">PAGO EFECTIVO</button>TOTAL CONSUMIDO:Q.'.number_format($total,2).' <button type="button" class="btn btn-success btn-md pull-right" title="Pago con gafete" onClick="confirmarCompra(\'credito\')">PAGO CREDITO</button></h2> </font></center>
	</caption>
	<tr bgcolor="#666666" >';
}
while($row_menu=mysql_fetch_array($consulta_menu))
{
	if(strlen($row_menu['producto'])>=19 && strlen($row_menu['producto'])<30 )
	{
		$class='absoluto1';
	}else if (strlen($row_menu['producto'])<19 )
	{
		$class='absoluto';
	}else
	{
		$class='absoluto2';
	}
	if($row_menu['producto']=='Pan c/frijol y huevo' )
	{
		$class='absoluto2';
	}
	
	$count=$count+1;
	if($count=='7' || $count=='13' || $count=='19')
	{
		$cadena.='</tr><tr bgcolor="#666666" >';
	
	}
	$cadena.='<td width="110" height="140" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" ><center><img src="./rrhh/imagenes_cafe/'.$row_menu['imagen'].'" width="40" height="40" onClick="javascript:  Compra(\''.$row_menu['precio'].'\',\''.$row_menu['id_categoria'].'\',\''.$total.'\',\'mas\',\''.$row_menu['id_producto'].'\') ;" style= "cursor:pointer;" title="Agregar producto"><br>'.$row_menu['producto'].'<br>Q'.$row_menu['precio'].'</center><button  type="button" class=" btn btn-danger btn-xs pull-right '.$class.'" title="Eliminar producto" onClick="javascript:  Compra(\''.$row_menu['precio'].'\',\''.$row_menu['id_categoria'].'\',\''.$total.'\',\'menos\',\''.$row_menu['id_producto'].'\');"><span class="glyphicon glyphicon-trash"></span></button>';
	if(is_null($_SESSION["Datos"][$row_menu['id_producto']]))
	{
		$_SESSION["Datos"][$row_menu['id_producto']]=0;
	}
	$cadena.='<font color="black"><strong><input type="text" class="'.$class.'" style=" background : inherit; border:none; font-size:16px" name="cantidad" id="cantidad" value="'.json_encode($_SESSION["Datos"][$row_menu['id_producto']]).'" size="1" readonly/></strong></font>
	<input type="hidden" name="precio" id="precio" value="'.$row_menu['precio'].'" size="2"/>
	<input type="hidden" name="nombre" id="producto" value="'.$row_menu['producto'].'" size="2"/> </td>';
	}
	$cadena.='</tr></table>';

	$cadena1.='<table class=" table table- table-bordered" style="font-size:14px">';
	$consulta_cat=mysql_query("select * from categoria where estado = 1 order by id_categoria");
	while($row_cat=mysql_fetch_array($consulta_cat))
	{
		$cadena1.='<tr title="Elija categoria" bgcolor="#666666" style= "cursor:pointer; white-space: nowrap;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript: Compra(\''.$row_cat['precio'].'\',\''.$row_cat['id_categoria'].'\',\''.$total.'\') ;"
	">
	<td ><center><img src="./rrhh/imagenes_cafe/'.$row_cat['imagen_cat'].'" width="50" height="50"><br>'.$row_cat['descripcion'].'
	</center> </td></tr>
	';
	}

	$cadena1.='</table> <button type="button" class="btn btn-primary btn-sm pull-right" title="Ir a reportes" onclick="location.href = \'./indexconsulta.php?reporte=1\'">Reportes</button><br>';
	$cadena1.='<br> <button type="button" class="btn btn-danger btn-sm pull-center" title="Cerrar sesion" onclick="location.href = \'logout1.php\'" >Cerrar sesión</button>';

$array=array('result'=>$cadena,'result1'=>$cadena1);
echo json_encode($array);
?>