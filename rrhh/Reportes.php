<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{

	include('../Conexion.php');
 
	$tipo=$_POST['tipo'];
	$usuario=$_POST['usuario'];
	$fecha_ini = date('Y-m-d',strtotime($_POST['fecha_ini'])); 
	$fecha_fin = date('Y-m-d',strtotime($_POST['fecha_fin']));

 
	if($tipo=='individual')
	{
		$count=0;
		$countE=0;
		$totalE=0;
		$total=0;
		$cantT=0;
		$uniT=0;
		$total1=0;
		$cantT1=0;
		$uniT1=0;
	
		$queryU = "SELECT * FROM usuario
where codigo_usuario='$usuario'";
		$resultU = mysqli_query($queryU) or die('Error en la instruccion SQL');


		if ($rowU = mysqli_fetch_array($resultU))
		{
			$query = "SELECT * FROM gastos_nuevos
			where codigo_usuario='$usuario'
			and tipo_compra='credito'
			and fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'";
			$result = mysqli_query($query) or die('Error en la instruccion SQL');

			if ($row = mysqli_fetch_array($result))
			{
				$h_data=time();
				$arch=$id_usuario.date('YmdHis').".xls";
				$log_file_name='./arch/tmp/'.$arch;
				$fh=fopen($log_file_name,"a+");

				$datos.= '<br><strong><div align="center"><font color="white"><h3>Usuario:'.$usuario.'<br> Nombre: '.$row['nombre'].'</h3></font></div>
				</strong><br>';

 				$datos.='
				<form id="form1" name="form1" method="post" action="excelconsulta5.php?usuario='.$usuario.'">
        			<div align="center">
        				<a class="btn btn-sm btn-success" style="padding: 1px 5px 1px 5px" href="./rrhh/exceldownload.php?f='.$arch.'">
							<span class="glyphicon glyphicon-save"></span>
							Exportar a Excel
						</a>
        				<font color="black">
							<button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php\'" >Regresar</button>
						</font>
					</div>
      			</form>
	  			<br>';
				$datos.='<center><table width="800" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >';
				$datos.= '<tr bgcolor="#333333"> ';
				$datos.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>No.Factura</b></font></td> ';
				$datos.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>Descripcion</b></font></td> ';
				$datos.= '<td width="50" style="white-space: nowrap;" align="center"><font color="white"><b>Cant.</b></font></td> ';
				$datos.= '<td width="90" style="white-space: nowrap;" align="center"><font color="white"><b>precio Uni.</b></font></td> ';
				$datos.= '<td width="90" style="white-space: nowrap;" align="center"><font color="white"><b>Total</b></font></td> ';
				$datos.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>Fecha</b></font></td> ';
				$datos.= '</tr> ';


			do 
			{
				$count=$count+1;
				$total=$total+$row['monto_total'];
				
				$cantT=$cantT+$row['cantidad'];
				$uniT=$uniT+$row['precio_unitario'];
				if($count%2==0)
				{
					$bgcolor='bgcolor="#B9E1DF"';
				}else
				{
					$bgcolor='bgcolor="#D0FCF9"';
				}
	
				$datos.= '<tr '.$bgcolor.' > ';
				$datos.= '<td align="center"><font color="black">'.$row['id_detalle_fact'].'</font></td> ';
				$datos.= '<td align="center"><font color="black">'.$row['descripcion'].'</font></td> ';
				$datos.= '<td align="center"><font color="black">'.$row['cantidad'].'</font></td> ';
				$datos.= '<td align="center"><font color="black">Q.'.number_format($row['precio_unitario'],2).'</font></td> ';
				$datos.= '<td align="center"><font color="black">Q.'.number_format($row['monto_total'],2).'</font></td> ';
				$datos.= '<td align="center"><font color="black">'.$row['fecha'].'</font></td> ';

				$datos.= '</tr> ';

			} 
			while ($row = mysqli_fetch_array($result));
			
			$datos.= '<tr bgcolor="#333333"> ';
			$datos.= '<td   align="right" ><font color="white"><b>Total:</b></font></td> ';
			$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
			$datos.= '<td   align="center" ><font color="white"><b>'.$cantT.'</b></font></td> ';
			$datos.= '<td   align="center" ><font color="white"><b>Q.'.number_format($uniT,2).'</b></font></td> ';
			$datos.= '<td  align="center"><font color="white"><b>Q.'.number_format($total,2).'</b></font></td> ';
			$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
			
			$queryG = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos where
			fecha between '$fecha_ini' and '$fecha_fin'
			and
			codigo_usuario='$usuario' GROUP BY codigo_usuario, nombre";
			$resultG = mysqli_query($queryG) ;
				
			$rowG = mysqli_fetch_array($resultG);
				
			if($rowG['monto_total']>'0')
			{
				$total=+$total+$rowG['monto_total'];
				$datos.= '<tr bgcolor="#333333"> ';
				$datos.= '<td   align="right" ><font color="white"><b>Total Base Anterior:</b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
				$datos.= '<td   align="center" ><font color="white"><b></b></font></td> ';
				$datos.= '<td   align="center" ><font color="white"><b></b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b>Q.'.$rowG['monto_total'].'</b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
				
				$datos.= '<tr bgcolor="#333333"> ';
				$datos.= '<td   align="right" ><font color="white"><b>Total General:</b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
				$datos.= '<td   align="center" ><font color="white"><b></b></font></td> ';
				$datos.= '<td   align="center" ><font color="white"><b></b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b>Q.'.number_format($total,2).'</b></font></td> ';
				$datos.= '<td  align="center"><font color="white"><b></b></font></td> ';
				$datos.= '</table></center>';
				$datos.= '<br><br>';
			}

		}else 
		{
			$datos.= '<br><br><br><br><br><strong><div align="center">'.$fecha_fin.$fecha_ini.'Aún no hay datos que mostrar</div></strong><br>
	<font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php\'" >Regresar</button></font>';
			$datos.= '<br><br>';

		}
	}else
	{
		$datos.= '<br><br><br><br><br><strong><div align="center">Usuario inexistente, por favor intente nuevamente</div></strong><br>
	<font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php\'" >Regresar</button></font>';
		$datos.= '<br><br>';	
	}
//============================EXCEL=====================================
	$query1 = "SELECT * FROM gastos_nuevos
	where codigo_usuario='$usuario'
	and tipo_compra='credito'
	and fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'";
	$result1 = mysqli_query($query1) or die('Error en la instruccion SQL');
	if ($row1 = mysqli_fetch_array($result1))
	{
		$datos1.= '<strong><div align="center"><h3>Usuario:'.$usuario.'<br> Nombre: '.$row1['nombre'].'</h3></div></strong>';
		
		$datos1.= '<center><table width="800" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px"  >';
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>No. factura</b></font></td> ';
		$datos1.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>Descripcion</b></font></td> ';
		$datos1.= '<td width="50" style="white-space: nowrap;" align="center"><font color="white"><b>Cant.</b></font></td> ';
		$datos1.= '<td width="90" style="white-space: nowrap;" align="center"><font color="white"><b>precio Uni.</b></font></td> ';
		$datos1.= '<td width="90" style="white-space: nowrap;" align="center"><font color="white"><b>Total</b></font></td> ';
		$datos1.= '<td width="160" style="white-space: nowrap;" align="center"><font color="white"><b>Fecha</b></font></td> ';
		$datos1.= '</tr> ';
			

		do 
		{
			$count=$count+1;
			$total1=$total1+$row1['monto_total'];
			$cantT1=$cantT1+$row1['cantidad'];
			$uniT1=$uniT1+$row1['precio_unitario'];
			
			if($count%2==0)
			{
				$bgcolor='bgcolor="#B9E1DF"';
			}else
			{
				$bgcolor='bgcolor="#D0FCF9"';
			}
	
				$datos1.= '<tr '.$bgcolor.' > ';
				$datos1.= '<td align="center">'.$row1['id_detalle_fact'].'</td> ';
				$datos1.= '<td align="center">'.utf8_decode($row1['descripcion']).'</td> ';
				$datos1.= '<td align="center">'.$row1['cantidad'].'</td> ';
				$datos1.= '<td align="center">'.$row1['precio_unitario'].'</td> ';
				$datos1.= '<td align="center">'.number_format($row1['monto_total'],2).'</td> ';
				$datos1.= '<td align="center">'.$row1['fecha'].'</td> ';
			
				$datos1.= '</tr> ';

		}
		while ($row1 = mysqli_fetch_array($result1));
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td   align="center" ><font color="white"><b>Total</b></font></td> ';
		$datos1.= '<td  align="center"><b></b></td> ';
		$datos1.= '<td   align="center" ><font color="white"><b>'.$cantT1.'</b></font></td> ';
		$datos1.= '<td   align="center" ><font color="white"><b>'.number_format($uniT1,2).'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="white"><b>'.number_format($total1,2).'</b></font></td> ';
		$datos1.= '<td  align="center"><b></b></td> ';
		$datos1.= '</table></center>';
		$datos1.= '<br><br>';
		$queryGe = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos where
		fecha between '$fecha_ini' and '$fecha_fin'
		and
		codigo_usuario='$usuario' GROUP BY codigo_usuario, nombre";
		$resultGe = mysqli_query($queryGe) or die('Error en la instruccion SQLGastos333');
			
		$rowGe = mysqli_fetch_array($resultGe);
		if($rowGe['monto_total']>'0')
		{
			$totale=+$totale+$rowGe['monto_total'];
			$datos1.= '<tr bgcolor="#333333"> ';
			$datos1.= '<td   align="right" ><font color="white"><b>Total Base Anterior:</b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b></b></font></td> ';
			$datos1.= '<td   align="center" ><font color="white"><b></b></font></td> ';
			$datos1.= '<td   align="center" ><font color="white"><b></b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b>Q.'.$rowGe['monto_total'].'</b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b></b></font></td> ';
			$datos1.= '<tr bgcolor="#333333"> ';
			$datos1.= '<td   align="right" ><font color="white"><b>Total General:</b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b></b></font></td> ';
			$datos1.= '<td   align="center" ><font color="white"><b></b></font></td> ';
			$datos1.= '<td   align="center" ><font color="white"><b></b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b>Q.'.number_format($totale,2).'</b></font></td> ';
			$datos1.= '<td  align="center"><font color="white"><b></b></font></td> ';
			$datos1.= '</table></center>';
			$datos1.= '<br><br>';
		}

		} else 
		{
			$datos1.= '<br><br><br><br><br><strong><div align="center">Aún no hay datos que mostrar</div></strong><br>';
			$datos1.= '<br><br>';
		}

	}else if($tipo=='ConsumoTotal')
	{
		$count=0;
		$total=0;
		$queryU = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos_nuevos where
		fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
		and tipo_compra='credito' and codigo_usuario!=000
		group by codigo_usuario, nombre";
		$resultU = mysqli_query($queryU) or die('Error en la instruccion SQL1');

		$h_data=time();
		$arch=$id_usuario.date('YmdHis').".xls";
		$log_file_name='./arch/tmp/'.$arch;
		$fh=fopen($log_file_name,"a+");
		$datos.= '<br><strong><div align="center"><font color="white"><h3>TOTAL POR USUARIO</h3></font></div>
		</strong><br>';

		$datos.='<form>
        
		<div align="center">
        <a class="btn btn-sm btn-success" style="padding: 1px 5px 1px 5px" href="./rrhh/exceldownload.php?f='.$arch.'">
			<span class="glyphicon glyphicon-save"></span>
			Exportar a Excel
		</a>
        <font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php\'" >Regresar</button></font>
		</div>
      </form>
	  <br>';

		if ($row = mysqli_fetch_array($resultU))
		{
			$datos.='<center><table width="800" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >';
			$datos.= '<tr bgcolor="#333333"> ';
			$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Codigo</b></font></td> ';
			$datos.= '<td width="400" style="white-space: nowrap;" align="center"><font color="white"><b>Nombre</b></font></td> ';
			$datos.= '<td width="300" style="white-space: nowrap;" align="center"><font color="white"><b>Total</b></font></td> ';
			$datos.= '</tr> ';
			do
			{
				$cod=$row['codigo_usuario'];
				$queryG = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos where
fecha between '$fecha_ini' and '$fecha_fin'
and
codigo_usuario='$cod' GROUP BY codigo_usuario, nombre";
				$resultG = mysqli_query($queryG) or die('Error en la instruccion SQLGastos');
				$rowG = mysqli_fetch_array($resultG);
		
				$totalInd=$rowG['monto_total']+number_format($row['monto_total'],2);
				$count=$count+1;
				$total=$total+$totalInd;
				if($count%2==0)
				{
					$bgcolor='bgcolor="#B9E1DF"';
				}else
				{
					$bgcolor='bgcolor="#D0FCF9"';
				}
	
				$datos.= '<tr '.$bgcolor.' > ';
				$datos.= '<td align="center"><font color="black">'.$row['codigo_usuario'].'</font></td> ';
				$datos.= '<td align="center"><font color="black">'.$row['nombre'].'</font></td> ';
				$datos.= '<td align="center"><font color="black">Q.'.number_format($totalInd,2).' </font></td> ';
				$datos.= '</tr> ';
			}while($row = mysqli_fetch_array($resultU));
			$datos.= '<tr bgcolor="#333333"> ';
			$datos.= '<td align="right" colspan="2"><font color="white"><b>TOTAL: </b></font></td> ';
			$datos.= '<td align="center" ><font color="white"><b>Q.'.number_format($total,2).'</b></font></td> ';
			$datos.= '</tr></table></center>';
			$datos.= '<br><br>';
		}
//============================EXCEL=====================================
	$datos1.= '<strong><div align="center"><h3>TOTAL POR USUARIO</h3></div>
		</strong>';
	$query1 = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos_nuevos where
fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
and tipo_compra='credito' and codigo_usuario!=000
group by codigo_usuario, nombre";
	$result1 = mysqli_query($query1) or die('Error en la instruccion SQL');


	if ($row1 = mysqli_fetch_array($result1))
	{
		$datos1.='<center><table width="800" style="table-layout:fixed; font-size:16px" class=" table- table-bordered" >';
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Codigo</b></font></td> ';
		$datos1.= '<td width="400" style="white-space: nowrap;" align="center"><font color="white"><b>Nombre</b></font></td> ';
		$datos1.= '<td width="300" style="white-space: nowrap;" align="center"><font color="white"><b>Total</b></font></td> ';
		$datos1.= '</tr> ';
		do
		{
			$cod=$row1['codigo_usuario'];
			$queryG1 = "select codigo_usuario, nombre, sum(monto_total) as monto_total from gastos where
fecha between '$fecha_ini' and '$fecha_fin'
and
codigo_usuario='$cod' GROUP BY codigo_usuario, nombre";

			$resultG1 = mysqli_query($queryG1) or die('Error en la instruccion SQLGastos');
			$rowG1 = mysqli_fetch_array($resultG1);
			$totalInd1=$rowG1['monto_total']+number_format($row1['monto_total'],2);
			$count1=$count1+1;
			$totalE=$totalE+$totalInd1;
		
			if($count%2==0)
			{
				$bgcolor='bgcolor="#B9E1DF"';
			}else
			{
				$bgcolor='bgcolor="#D0FCF9"';
			}
	
			$datos1.= '<tr '.$bgcolor.' > ';
			$datos1.= '<td align="center">'.$row1['codigo_usuario'].'</td> ';
			$datos1.= '<td align="center">'.utf8_decode($row1['nombre']).'</td> ';
			$datos1.= '<td align="center">'.number_format($row1['monto_total'],2).'</td> ';
			$datos1.= '</tr> ';
		}
		while($row1 = mysqli_fetch_array($result1));
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td align="right" colspan="2"><font color="white"><b>TOTAL: </b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>'.number_format($totalE,2).'</b></font></td> ';
		$datos1.= '</tr></table></center>';
		$datos1.= '<br><br>';
	}
}else if($tipo=='producto')
{
	$count=0;
	$total=0;
	$cant=0;
	$queryU = "select gn.descripcion, ifnull(gnC.cantidad,0) as cantidad_credito, ifnull(gnC.total,0) as total_credito, 
ifnull(gnE.cantidad,0) as cantidad_efectivo,ifnull(gnE.total,0) as total_efectivo,
 sum(gn.cantidad) as cantidad,sum(gn.monto_total) as total
from gastos_nuevos as gn
	left join 
    (
		select descripcion,tipo_compra, sum(cantidad) as cantidad,sum(monto_total) as total from gastos_nuevos
        where tipo_compra='credito' and
        fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
        group by descripcion
    )gnC 
    on gn.descripcion=gnC.descripcion
    left join 
    (
		select descripcion,tipo_compra, sum(cantidad) as cantidad,sum(monto_total) as total from gastos_nuevos
        where tipo_compra='efectivo' and
        fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
        group by descripcion
    )gnE 
    on gn.descripcion=gnE.descripcion
    
    where 
	fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
group by gn.descripcion,gnC.cantidad,gnC.total,gnE.cantidad,gnE.total;";
	$resultU = mysqli_query($queryU) or die('Error en la instruccion SQL1');

	$h_data=time();
	$arch=$id_usuario.date('YmdHis').".xls";
	$log_file_name='./arch/tmp/'.$arch;
	$fh=fopen($log_file_name,"a+");
	$datos.= '<br><strong><div align="center"><font color="white"><h3>CONTROL DE PRODUCTOS VENDIDOS</h3></font></div>
		</strong><br>';

	$datos.='<form>
        
		<div align="center">
        <a class="btn btn-sm btn-success" style="padding: 1px 5px 1px 5px" href="./rrhh/exceldownload.php?f='.$arch.'">
			<span class="glyphicon glyphicon-save"></span>
			Exportar a Excel
		</a>
        <font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php?reporte=1\'" >Regresar</button></font>
		</div>
      </form>
	  <br>';

	if ($row = mysqli_fetch_array($resultU))
	{
		$datos.='<center><table width="900" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:14px" >';
		$datos.= '<tr bgcolor="#333333"> ';
		$datos.= '<td width="50" style="white-space: nowrap;" align="center"><font color="white"><b>No.</b></font></td> ';
		$datos.= '<td width="350" style="white-space: nowrap;" align="center"><font color="white"><b>Producto</b></font></td> ';
		$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Cant. Credito</b></font></td> ';
		$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total credito</b></font></td> ';
		$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Cant. Efectivo</b></font></td> ';
		$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total efectivo</b></font></td> ';
		$datos.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total vendido</b></font></td> ';
		$datos.= '</tr> ';
		do
		{
			$count=$count+1;
			$total_credito+=$row['total_credito'];
			$total_efectivo+=$row['total_efectivo'];
			$total=$total+$row['total'];
			$cant_credito+=$row['cantidad_credito'];
			$cant_efectivo+=$row['cantidad_efectivo'];
			$cant=$cant+$row['cantidad'];
			if($count%2==0)
			{
				$bgcolor='bgcolor="#B9E1DF"';
			}else
			{
				$bgcolor='bgcolor="#D0FCF9"';
			}
	
			$datos.= '<tr '.$bgcolor.' > ';
			$datos.= '<td align="center"><font color="black">'.$count.'</font></td> ';
			$datos.= '<td align="center"><font color="black">'.$row['descripcion'].'</font></td> ';
			$datos.= '<td align="center"><font color="black">'.$row['cantidad_credito'].'</font></td> ';
			$datos.= '<td align="center"><font color="black">Q.'.number_format($row['total_credito'],2).'</font></td> ';
			$datos.= '<td align="center"><font color="black">'.$row['cantidad_efectivo'].'</font></td> ';
			$datos.= '<td align="center"><font color="black">Q.'.number_format($row['total_efectivo'],2).'</font></td> ';
			$datos.= '<td align="center"><font color="black">Q.'.number_format($row['total'],2).'</font></td> ';
			$datos.= '</tr> ';
		}while($row = mysqli_fetch_array($resultU));
		$datos.= '<tr bgcolor="#333333"> ';
		$datos.= '<td align="right" colspan="2"><font color="white"><b>TOTAL: </b></font></td> ';
		$datos.= '<td align="center" ><font color="white"><b>'.$cant_credito.'</b></font></td> ';
		$datos.= '<td align="center" ><font color="white"><b>Q.'.number_format($total_credito,2).'</b></font></td> ';
		$datos.= '<td align="center" ><font color="white"><b>'.$cant_efectivo.'</b></font></td> ';
		$datos.= '<td align="center" ><font color="white"><b>Q.'.number_format($total_efectivo,2).'</b></font></td> ';
		$datos.= '<td align="center" ><font color="white"><b>Q.'.number_format($total,2).'</b></font></td> ';
		$datos.= '</tr></table></center>';
		$datos.= '<br><br>';
	}
	$count1=0;
	$total1=0;
	$cant1=0;
	$queryU1 = "select gn.descripcion, ifnull(gnC.cantidad,0) as cantidad_credito, ifnull(gnC.total,0) as total_credito, 
ifnull(gnE.cantidad,0) as cantidad_efectivo,ifnull(gnE.total,0) as total_efectivo,
 sum(gn.cantidad) as cantidad,sum(gn.monto_total) as total
from gastos_nuevos as gn
	left join 
    (
		select descripcion,sum(cantidad) as cantidad,sum(monto_total) as total from gastos_nuevos
        where tipo_compra='credito' and
        fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
        group by descripcion
    )gnC 
    on gn.descripcion=gnC.descripcion
    left join 
    (
		select descripcion,sum(cantidad) as cantidad,sum(monto_total) as total from gastos_nuevos
        where tipo_compra='efectivo' and
        fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
        group by descripcion
    )gnE 
    on gn.descripcion=gnE.descripcion
    
    where 
	fecha between '$fecha_ini 00:00:00' and '$fecha_fin 23:59:59'
group by gn.descripcion,gnC.cantidad,gnC.total,gnE.cantidad,gnE.total;";
	$resultU1 = mysqli_query($queryU1) or die('Error en la instruccion SQL1');


	$datos1.= '<br><strong><div align="center"><font color="black"><h3>CONTROL DE PRODUCTOS VENDIDOS</h3></font></div>
		</strong>';

	if ($row1 = mysqli_fetch_array($resultU1))
	{
		$datos1.='<center><table width="900" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:14px" >';
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td width="50" style="white-space: nowrap;" align="center"><font color="white"><b>No.</b></font></td> ';
		$datos1.= '<td width="350" style="white-space: nowrap;" align="center"><font color="white"><b>Producto</b></font></td> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Cant. Credito</b></font></td> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total credito</b></font></td> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Cant. Efectivo</b></font></td> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total efectivo</b></font></td> ';
		$datos1.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Total vendido</b></font></td> ';
		$datos1.= '</tr> ';
		do
		{
			$count1=$count1+1;
			$total_credito1+=$row1['total_credito'];
			$total_efectivo1+=$row1['total_efectivo'];
			$total1=$total1+$row1['total'];
			$cant_credito1+=$row1['cantidad_credito'];
			$cant_efectivo1+=$row1['cantidad_efectivo'];
			$cant1=$cant1+$row1['cantidad'];
			if($count1%2==0)
			{
				$bgcolor1='bgcolor="#B9E1DF"';
			}else
			{
				$bgcolor1='bgcolor="#D0FCF9"';
			}
	
			$datos1.= '<tr '.$bgcolor1.' > ';
			$datos1.= '<td align="center"><font color="black">'.$count1.'</font></td> ';
			$datos1.= '<td align="center"><font color="black">'.utf8_decode($row1['descripcion']).'</font></td> ';
			$datos1.= '<td align="center"><font color="black">'.$row1['cantidad_credito'].'</font></td> ';
			$datos1.= '<td align="center"><font color="black">Q.'.number_format($row1['total_credito'],2).'</font></td> ';
			$datos1.= '<td align="center"><font color="black">'.$row1['cantidad_efectivo'].'</font></td> ';
			$datos1.= '<td align="center"><font color="black">Q.'.number_format($row1['total_efectivo'],2).'</font></td> ';
			$datos1.= '<td align="center"><font color="black">Q.'.number_format($row1['total'],2).'</font></td> ';
			$datos1.= '</tr> ';
		}while($row1 = mysqli_fetch_array($resultU1));
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td align="right" colspan="2"><font color="white"><b>TOTAL: </b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>'.$cant_credito1.'</b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>Q.'.number_format($total_credito1,2).'</b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>'.$cant_efectivo1.'</b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>Q.'.number_format($total_efectivo1,2).'</b></font></td> ';
		$datos1.= '<td align="center" ><font color="white"><b>Q.'.number_format($total1,2).'</b></font></td> ';
		$datos1.= '</tr></table></center>';
		$datos1.= '<br><br>';
	}

}else if($tipo=='tendencia')
{
	$count=0;
	$countM1=0;
	$countM2=0;
	$totalM1=0;
	$totalM2=0;
	$queryMS = "SELECT ms.dia,ms.fecha ,ms.menu_1,IFNULL(M1.menu1,0) as total_menu1,IFNULL(V1.vendido1,0) as vendido1,ms.menu_2,
IFNULL(M2.menu2,0)as total_menu2,IFNULL(V2.vendido1,0) as vendido2,IFNULL(sum(IFNULL(M1.menu1,0)+IFNULL(M2.menu2,0)),0) as total_pedido, 
IFNULL(sum(IFNULL(V1.vendido1,0)+IFNULL(V2.vendido1,0)),0) as total_vendido 
FROM menu_semanal as ms
	
left join
(
	select fecha_menu,count(no_menu) as menu1 
	FROM cafeteria.pedidos
	where no_menu=1
	group by no_menu,fecha_menu 
)as M1
	on ms.fecha=M1.fecha_menu
left join
( 
	select fecha_menu,count(no_menu) as menu2 FROM cafeteria.pedidos
	where no_menu=2
	group by no_menu,fecha_menu 
)as M2
	on ms.fecha=M2.fecha_menu
left join
(
	select cast(gn.fecha as date) as fecha_sin_hora,sum(cantidad) as vendido1 
	FROM gastos_nuevos as gn
	where descripcion='Almuerzo carne'
	group by fecha_sin_hora
)V1
on ms.fecha=V1.fecha_sin_hora
left join
(
	select cast(gn.fecha as date) as fecha_sin_hora,sum(cantidad) as vendido1 
	FROM gastos_nuevos as gn
	where descripcion='Almuerzo pollo'
	group by fecha_sin_hora
)V2
on ms.fecha=V2.fecha_sin_hora
where ms.fecha between '$fecha_ini' and '$fecha_fin'
and (ms.menu_1!='' or ms.menu_2!='')
group by ms.dia,ms.fecha ,ms.menu_1,vendido1,ms.menu_2,total_menu2,vendido2
order by fecha;";

	$resultMS = mysqli_query($queryMS) or die('Error en la instruccion SQL Menu semanal');
	
	

	$h_data=time();
	$arch=$id_usuario.date('YmdHis').".xls";
	$log_file_name='./arch/tmp/'.$arch;
	$fh=fopen($log_file_name,"a+");
	$datos.= '<br><strong><div align="center"><font color="white"><h3>TENDENCIA MENÚS POR DÍA</h3></font></div>
		</strong><br>';

	$datos.='<form>
        
		<div align="center">
        <a class="btn btn-sm btn-success" style="padding: 1px 5px 1px 5px" href="./rrhh/exceldownload.php?f='.$arch.'">
			<span class="glyphicon glyphicon-save"></span>
			Exportar a Excel
		</a>
        <font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'./indexconsulta.php?reporte=1\'" >Regresar</button></font>
		</div>
      </form>
	  <br>';
	$datos.='<center><table width=1100 border="1" bordercolor="#000000" style=" font-size:12px" >';
	$datos.= '<tr bgcolor="#333333"> ';
		$datos.= '<tr bgcolor="#333333"> ';
		$datos.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Día</b></font></td> ';
		$datos.= '<td width=80 style="white-space: normal;"  align="center"><font color="white"><b>Fecha</b></font></td> ';
		$datos.= '<td width=250 style="white-space: normal;"  align="center"><font color="White"><b>Menu Carne</b></font></td> ';
		$datos.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Solic.</b></font></td> ';
		$datos.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Vend.</b></font></td> ';
		$datos.= '<td width=250 style="white-space: normal;"  align="center"><font color="White"><b>Menu Pollo</b></font></td> ';
		$datos.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Solic.</b></font></td> ';
		$datos.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Vend.</b></font></td> ';
		$datos.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Total solic.</b></font></td> ';
		$datos.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Total vend.</b></font></td></tr> ';
	while($row = mysqli_fetch_array($resultMS))
	{
		
		
		$vendido_total+=$row['total_vendido'];
		$pedido_total+=$row['total_pedido'];
		$vendido1+=$row['vendido1'];
		$vendido2+=$row['vendido2'];
		$total_menu1+=$row['total_menu1'];
		$total_menu2+=$row['total_menu2'];
		//$total+=$row['total'];
		//$total=$total+$row['monto_total'];
		if($count%2==0)
		{
			
			$bgcolor='bgcolor="#B9E1DF"';
		}else
		{
			
			$bgcolor='bgcolor="#D0FCF9"';
		}
		
		$datos.= '<tr '.$bgcolor.'> ';
		
		$datos.= '<td style="white-space: normal;" align="center"><font color="black"><b>'.$row['dia'].'</b></font></td> ';
		$datos.= '<td style="white-space: normal;" align="center"><font color="black"><b>'.date('d-m-Y',strtotime($row['fecha'])).'</b></font></td> ';
		$datos.= '<td   align="center"><font color="black"><b>'.$row['menu_1'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="blue"><b>'.$row['total_menu1'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="red"><b>'.$row['vendido1'].'</b></font></td> ';
		$datos.= '<td   align="center"><font color="black"><b>'.$row['menu_2'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="blue"><b>'.$row['total_menu2'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="red"><b>'.$row['vendido2'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="blue"><b>'.$row['total_pedido'].'</b></font></td> ';
		$datos.= '<td  align="center"><font color="red"><b>'.$row['total_vendido'].'</b></font></td></tr> ';
		
	}

		$datos.= '<tr bgcolor="#333333"> ';
		$datos.= '<td colspan="3"  style="white-space: normal;"  align="right"><font color="White"><b>Total: </b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="white"><b>'.$total_menu1.'</b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="white"><b>'.$vendido1.'</b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="White"><b></b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$total_menu2.'</b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$vendido2.'</b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$pedido_total.'</b></font></td> ';
		$datos.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$vendido_total.'</b></font></td></tr> ';
	$datos.= '</table></center></br>';
	//==============================EXCEL==============================

	$count1=0;
	$countM11=0;
	$countM21=0;
	$totalM11=0;
	$totalM21=0;
	$queryMS1 = "SELECT ms.dia,ms.fecha ,ms.menu_1,IFNULL(M1.menu1,0) as total_menu1,IFNULL(V1.vendido1,0) as vendido1,ms.menu_2,
IFNULL(M2.menu2,0)as total_menu2,IFNULL(V2.vendido1,0) as vendido2,IFNULL(sum(IFNULL(M1.menu1,0)+IFNULL(M2.menu2,0)),0) as total_pedido, 
IFNULL(sum(IFNULL(V1.vendido1,0)+IFNULL(V2.vendido1,0)),0) as total_vendido 
FROM menu_semanal as ms
	
left join
(
	select fecha_menu,count(no_menu) as menu1 
	FROM cafeteria.pedidos
	where no_menu=1
	group by no_menu,fecha_menu 
)as M1
	on ms.fecha=M1.fecha_menu
left join
( 
	select fecha_menu,count(no_menu) as menu2 FROM cafeteria.pedidos
	where no_menu=2
	group by no_menu,fecha_menu 
)as M2
	on ms.fecha=M2.fecha_menu
left join
(
	select cast(gn.fecha as date) as fecha_sin_hora,sum(cantidad) as vendido1 
	FROM gastos_nuevos as gn
	where descripcion='Almuerzo 1'
	group by fecha_sin_hora
)V1
on ms.fecha=V1.fecha_sin_hora
left join
(
	select cast(gn.fecha as date) as fecha_sin_hora,sum(cantidad) as vendido1 
	FROM gastos_nuevos as gn
	where descripcion='Almuerzo 2'
	group by fecha_sin_hora
)V2
on ms.fecha=V2.fecha_sin_hora
where ms.fecha between '$fecha_ini' and '$fecha_fin'
group by ms.dia, ms.fecha,ms.menu_1,vendido1,ms.menu_2,total_menu2,vendido2
order by fecha;";
	$resultMS1 = mysqli_query($queryMS1) or die('Error en la instruccion SQL Menu semanal');
	
	

	
	$datos1.= '<br><strong><div align="center"><font color="black"><h3>TENDENCIA MENÚS POR DÍA</h3></font></div>
		</strong><br>';

	
	$datos1.='<center><table width=1100 border="1" bordercolor="#000000" style=" font-size:12px" >';
	$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Día</b></font></td> ';
		$datos1.= '<td width=80 style="white-space: normal;"  align="center"><font color="white"><b>Fecha</b></font></td> ';
		$datos1.= '<td width=250 style="white-space: normal;"  align="center"><font color="White"><b>Menu 1</b></font></td> ';
		$datos1.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Solic.</b></font></td> ';
		$datos1.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Vend.</b></font></td> ';
		$datos1.= '<td width=250 style="white-space: normal;"  align="center"><font color="White"><b>Menu 2</b></font></td> ';
		$datos1.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Solic.</b></font></td> ';
		$datos1.= '<td width=70 style="white-space: normal;"  align="center"><font color="White"><b>Vend.</b></font></td> ';
		$datos1.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Total solic.</b></font></td> ';
		$datos1.= '<td width=80 style="white-space: normal;"  align="center"><font color="White"><b>Total vend.</b></font></td></tr> ';
	while($row1 = mysqli_fetch_array($resultMS1))
	{
		
		
		$vendido_total1+=$row1['total_vendido'];
		$pedido_total1+=$row1['total_pedido'];
		$vendido11+=$row1['vendido1'];
		$vendido21+=$row1['vendido2'];
		$total_menu11+=$row1['total_menu1'];
		$total_menu21+=$row1['total_menu2'];
		//$total+=$row['total'];
		//$total=$total+$row['monto_total'];
		if($count1%2==0)
		{
			
			$bgcolor='bgcolor="#B9E1DF"';
		}else
		{
			
			$bgcolor='bgcolor="#D0FCF9"';
		}
		
		$datos1.= '<tr '.$bgcolor.'> ';
		
		$datos1.= '<td style="white-space: normal;" align="center"><font color="black"><b>'.$row1['dia'].'</b></font></td> ';
		$datos1.= '<td style="white-space: normal;" align="center"><font color="black"><b>'.date('d-m-Y',strtotime($row1['fecha'])).'</b></font></td> ';
		$datos1.= '<td   align="center"><font color="black"><b>'.$row1['menu_1'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="blue"><b>'.$row1['total_menu1'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="red"><b>'.$row1['vendido1'].'</b></font></td> ';
		$datos1.= '<td   align="center"><font color="black"><b>'.$row1['menu_2'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="blue"><b>'.$row1['total_menu2'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="red"><b>'.$row1['vendido2'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="blue"><b>'.$row1['total_pedido'].'</b></font></td> ';
		$datos1.= '<td  align="center"><font color="red"><b>'.$row1['total_vendido'].'</b></font></td></tr> ';
		
	}

		$datos1.= '<tr bgcolor="#333333"> ';
		$datos1.= '<td colspan="3"  style="white-space: normal;"  align="right"><font color="White"><b>Total: </b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="white"><b>'.$total_menu11.'</b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="white"><b>'.$vendido11.'</b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="White"><b></b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$total_menu21.'</b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$vendido21.'</b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$pedido_total1.'</b></font></td> ';
		$datos1.= '<td  style="white-space: normal;"  align="center"><font color="White"><b>'.$vendido_total1.'</b></font></td></tr> ';
	$datos1.= '</table></center></br>';



}


fwrite($fh,'<html >'.$datos1.'</html>');
fclose($fh);
$array=array('result'=>$datos);
echo json_encode($array);
}


?>