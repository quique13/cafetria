
<?php
session_name('monitor');
session_start();  
$nombre=$_SESSION['nombre'];
$usuario=$_SESSION['id_usuario'];

$LIBS_DIR="./libs/";
include('Conexion.php');

$fechaSel=date('d-m-Y',strtotime($_POST['fecha']));
$diaSel=$_POST['dia'];
$menuSel=$_POST['menu'];
$no_menuSel=$_POST['no_menu'];
$id=$_POST['id_count'];
$tipo=$_POST['tipo'];
$fecha_menu=$_POST['fecha_menu'];
$id_usuario=$_POST['id_usuario'];


 if($tipo=='guardar' && ($usuario!=0 && $usuario!=''))
{
	$hoy=date('Y-m-d H:i:s');
	$fecha=date('Y-m-d',strtotime($_POST['fecha']));
	$dia=$_POST['dia'];
	$menu=$_POST['menu'];
	$no_menu=$_POST['no_menu'];
	
	$insert="insert into pedidos (id_usuario,nombre_usuario,dia,no_menu,descrip_menu,fecha_menu,fecha_pedido) values('". htmlentities(mysqli_real_escape_string($usuario))."','".utf8_encode(mysqli_real_escape_string($nombre))."','".mysqli_real_escape_string($dia)."','".$no_menu."','".mysqli_real_escape_string($menu)."','$fecha','$hoy')
		ON DUPLICATE KEY UPDATE
		descrip_menu='".mysqli_real_escape_string($menu)."',no_menu='".$no_menu."',fecha_pedido='".$hoy."'";	
	$resultL = mysqli_query($insert) or die(mysqli_error ());
	
}
else if($tipo=='tabla')
{
	$fecha_inicio=date('Y-m-d',strtotime('+1 day'));
	$cadena.='<center><table width="700" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:10px" >
				<caption><center><font color="white">MENÚS SELECCIONADOS </font></center></caption>
				<tr bgcolor="#666666"> 
					<td width="150" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>FECHA</b></font></td>
					<td width="150" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>DÍA</b></font></td>
					<td width="400" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>MENÚ </b></font></td>
					
				</tr>';
		
	$selectPT="SELECT * FROM cafeteria.pedidos
where id_usuario='$usuario'
and fecha_menu >='$fecha_inicio'
order by fecha_menu 
limit 5;";
	$resultPT = mysqli_query($selectPT) or die('Error en la instruccion SQL1');
	
	while($rowPT = mysqli_fetch_array($resultPT))
	{
		$fechaOrden=date('d-m-Y',strtotime($rowPT['fecha_menu']));
		$cadena.='<tr bgcolor="#333333"> 
				<td width="120" height="25"  align="center" style="white-space: normal;"><font color="white">'.$fechaOrden.'</font></td>
				<td width="80" height="25"  align="center" style="white-space: normal;"><font color="white">'.$rowPT['dia'].'</font></td>
				<td width="350" height="25"    align="center" style="white-space: normal;><font color="white">'.$rowPT['descrip_menu'].'</font></td>
				<td><button type="submit" id="eliminar" class="close" title="Eliminar día" 
			onClick="eliminar('."'".'eliminar'."'".',\''.$rowPT['id_usuario'].'\',\''.date('Y-m-d',strtotime($fechaOrden)).'\');">
 <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></font></td>
				</tr>
				<tr bgcolor="#680505">
				<td width="80" height="5" colspan="5"></td>
				</tr>';
	}
	$cadena.=' </table></center>';
	
}else if($tipo=='eliminar')
{
	$delete=("delete from pedidos
where id_usuario='$id_usuario' and fecha_menu='$fecha_menu'"); 
$queryD=mysqli_query($delete) or die(mysqli_error());
	$row=mysqli_fetch_array($delete);
}
$array=array('result'=>$cadena);
echo json_encode($array);
?>
