<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{


include('../Conexion.php');
include('../Conexion_sac.php');
include('../funcionesCafe.php');
 
$tipo=$_POST['tipo'];
$id= $_POST['baja_usuario'];
$nombre=$_POST['baja_nombre'];

if($tipo=='Agregar')
{
	$cadena.='<div align="center">
        <h1>AGREGAR NUEVO USUARIO</h1>
        <form id="form1" name="form1" method="post" action="">
          <div align="center">
          <label>Codigo de usuario:
             <font color="black"><input type="text" name="usuario" id="id_user" required/></font>
          </label>
          <label>Nombre completo:
             <font color="black"><input type="text" name="nombre" id="nombre_completo" required/></font>
          </label>
          
          </div>
           <div align="center">
           <br><font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
		   <font color="black"><button name="agregar1" id="agregar1" onClick="javascript:mantenimiento(\'agregar\')" type="button" class="btn btn-success btn-md">Agregar</button></font>      
          </div>
        </form>
        
      </div>
      
      <div align="center" id="resultado"></div>
       <div align="center" id="divAlert"></div>';
}else if($tipo=='Eliminar')
{
	$cadena.='
      <div align="center">
        <h1>DAR BAJA USUARIO</h1>
        <form id="form1" name="form1" method="post" action="">
          <div align="center">
          <label>USUARIO</label>
             <select  id="baja_usuario" name="baja_usuario" style="background-color:666666">
             <option value ="0" > Seleccione un usuario</option>';
			 
			 $consult = "SELECT * FROM usuario
where estado ='a'
order by nombre";
$result = mysql_query($consult) or die(mysql_error());
			 
			 while ($row = mysql_fetch_array($result))
  			{
				$cadena.='<option  value="'.$row['codigo_usuario'].'" >'.$row['nombre'].'('.$row['codigo_usuario'].')</option>';}
	 		$cadena.='</select>
         
          </div><br />
           <div align="center">
          <font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
           <font color="black"><button name="consultar" id="conultar" onClick="javascript:Confirmar(\'confirmar\')" type="button" class="btn btn-success btn-md">Baja</button></font>
          </div>
        </form>
        <!-- script que define y configura el calendario-->
      </div></td>
  </tr>
</table>
';
}else if($tipo=='Menu')
{
	//Semana 1(actual)
	$diaSemana1=date('N');
	$lunesF=fecha($diaSemana1);
	$lunes=date('d/m/Y',strtotime($lunesF));
	$viernes=strtotime('+4 day',strtotime($lunesF));
	$viernes=date('d/m/Y',$viernes);
	//semana 2
	$lunes2=strtotime('+7 day',strtotime($lunesF));
	$lunes2=date('d/m/Y',$lunes2);
	$viernes2=strtotime('+11 day',strtotime($lunesF));
	$viernes2=date('d/m/Y',$viernes2);
	//semana 3
	$lunes3=strtotime('+14 day',strtotime($lunesF));
	$lunes3=date('d/m/Y',$lunes3);
	$viernes3=strtotime('+18 day',strtotime($lunesF));
	$viernes3=date('d/m/Y',$viernes3);
	$cadena.='<center>
	<table width="500" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >
	<caption><center><h2><font color="white">MENÚ DE LA SEMANA</font></h2></center></caption>
		
		<tr bgcolor="#333333" title="Semana Actual"  style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:mantenimiento1(\'GetMenu\',\''.$lunesF.'\',\'semana1\')"> 
		
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Semana actual (Del '.$lunes.' al '.$viernes.')</b></font></td></tr>
			<tr bgcolor="#666666">
			<td width="80" height="5"></td>
			</tr>
		<tr bgcolor="#333333"  title="Siguiente Semana"  style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:mantenimiento1(\'GetMenu\',\''.$lunesF.'\',\'semana2\')">  
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Semana siguiente (Del '.$lunes2.' al '.$viernes2.')</b></font></td></tr>
			<tr bgcolor="#666666">
			<td width="80" height="5"></td>
			</tr>
		<tr bgcolor="#333333" title="Semana Despues De La Siguiente"  style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:mantenimiento1(\'GetMenu\',\''.$lunesF.'\',\'semana3\')">
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Semana despues de la siguiente (Del '.$lunes3.' al '.$viernes3.')</b></font></td>
			</tr> ';
}else if($tipo=='EditCat')
{
	$cadena.= '<br><strong><div align="center"><font color="white"><h3>CATEGORIAS DEL MENÚ </h3></font></div>
		</strong><br>';
		
	$query = "SELECT * FROM cafeteria.categoria
where estado= '1';";
	
	$result = mysql_query($query) or die('Error en la instruccion SQL');

	if ($row = mysql_fetch_array($result))
		{
			$cadena.='<button  type="button" class=" btn btn-primary btn-sm pull-center absoluto" title="Agregar nueva categoria" onClick="javascript: Mant_Menu(\'PrevNueva\')"><span class="glyphicon glyphicon-plus"></span></button>
			<center><table width="400" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >';
			$cadena.= '<tr bgcolor="#333333"> ';
			$cadena.= '<td width="60" style="white-space: nowrap;" align="center"><font color="white"><b>Id_Cat</b></font></td> ';
			$cadena.= '<td width="150" style="white-space: nowrap;" align="center"><font color="white"><b>Nombre</b></font></td> ';
			$cadena.= '<td width="90" style="white-space: nowrap;" align="center"><font color="white"><b>Imagen</b></font></td> ';
			$cadena.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Acciones</b></font></td> ';
			$cadena.= '</tr> ';


			do 
			{
				$count=$count+1;
				if($count%2==0)
				{
					$bgcolor='bgcolor="#B9E1DF"';
				}else
				{
					$bgcolor='bgcolor="#D0FCF9"';
				}
	
				$cadena.= '<tr '.$bgcolor.' > ';
				$cadena.= '<td align="center"><font color="black">'.$row['id_categoria'].'</font></td> ';
				$cadena.= '<td align="center"><font color="black">'.$row['descripcion'].'</font></td> ';
				$cadena.= '<td ><center><img src="./rrhh/imagenes_cafe/'.$row['imagen_cat'].'" width="50" height="50"><br>'.$row_cat['descripcion'].'
	</center> </td> ';
				$cadena.= '<td align="center"><center><button type="button" onClick=" Mant_Menu(\'PrevEditar\',\''.$row['id_categoria'].'\')" class="btn btn-success btn-sm" title="Editar Categoria"><span class="glyphicon glyphicon-edit"></span></button>&nbsp; <button type="button" onClick="javascript: Mant_Menu(\'PrevEliminar\',\''.$row['id_categoria'].'\')" class="btn btn-danger btn-sm" title="Eliminar Categoria"><span class="glyphicon glyphicon-trash"></span></button></center></td> ';

				$cadena.= '</tr> ';

			} 
			while ($row = mysql_fetch_array($result));
			$cadena.= '</table></center>';
		}
}else if($tipo=='EditProd')
{
	$cadena.= '<br><strong><div align="center"><font color="white"><h3>CATEGORIAS DEL MENÚ </h3></font></div>
		</strong><br>';
		
	$query = "SELECT prod.id_producto,cat.descripcion as categoria,prod.descripcion as producto,prod.imagen_producto,prod.precio FROM cafeteria.categoria_producto as cp
inner join categoria as cat
on cp.id_categoria=cat.id_categoria
inner join productos as prod
on cp.id_producto=prod.id_producto
where prod.estado='1'
order by cat.id_categoria,prod.descripcion;";
	
	$result = mysql_query($query) or die('Error en la instruccion SQL');

	if ($row = mysql_fetch_array($result))
		{
			$cadena.='<button  type="button" class=" btn btn-primary btn-sm pull-center absoluto1" title="Agregar nueva categoria" onClick="javascript: Mant_Menu(\'PrevNuevaPro\')"><span class="glyphicon glyphicon-plus"></span></button>
			<center><table width="650" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >';
			$cadena.= '<tr bgcolor="#333333"> ';
			$cadena.= '<td width="30" style="white-space: nowrap;" align="center"><font color="white"><b>No.</b></font></td> ';
			$cadena.= '<td width="130" style="white-space: nowrap;" align="center"><font color="white"><b>Categoria</b></font></td> ';
			$cadena.= '<td width="190" style="white-space: nowrap;" align="center"><font color="white"><b>Producto</b></font></td> ';
			$cadena.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Precio</b></font></td> ';
			$cadena.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Imagen</b></font></td> ';
			$cadena.= '<td width="100" style="white-space: nowrap;" align="center"><font color="white"><b>Acciones</b></font></td> ';
			$cadena.= '</tr> ';


			do 
			{
				$count=$count+1;
				if($count%2==0)
				{
					$bgcolor='bgcolor="#B9E1DF"';
				}else
				{
					$bgcolor='bgcolor="#D0FCF9"';
				}
	
				$cadena.= '<tr '.$bgcolor.' > ';
				$cadena.= '<td align="center"><font color="black">'.$count.'</font></td> ';
				$cadena.= '<td align="center"><font color="black">'.$row['categoria'].'</font></td> ';
				$cadena.= '<td align="center"><font color="black">'.$row['producto'].'</font></td> ';
				$cadena.= '<td align="center"><font color="black">'.$row['precio'].'</font></td> ';
				$cadena.= '<td ><center><img src="./rrhh/imagenes_cafe/'.$row['imagen_producto'].'" width="50" height="50"><br>'.$row_cat['descripcion'].'
	</center> </td> ';
	
				$cadena.= '<td align="center"><center><button type="button" onClick=" Mant_Menu(\'PrevEditarPro\',\''.$row['id_producto'].'\')" class="btn btn-success btn-sm" title="Editar Categoria"><span class="glyphicon glyphicon-edit"></span></button>&nbsp; <button type="button" onClick="javascript: Mant_Menu(\'PrevEliminarPro\',\''.$row['id_producto'].'\')" class="btn btn-danger btn-sm" title="Eliminar Categoria"><span class="glyphicon glyphicon-trash"></span></button></center></td> ';

				$cadena.= '</tr> ';

			} 
			while ($row = mysql_fetch_array($result));
			$cadena.= '</table></center>';
		}
}else if($tipo=='EditHorario')
{
	$arrayCargos=array();
$queryCargos=mssql_query("
SELECT id_cargo,descripcion FROM cargos WHERE suspendido=0
UNION
SELECT 0,'Todos' ");
while($rowCargos=mssql_fetch_array($queryCargos))
{
	$arrayCargos[$rowCargos['id_cargo']]=$rowCargos['descripcion'];
}
$queryUsuario=mssql_query("SELECT * FROM usuarios WHERE suspendido=0");
while($rowUsuario=mssql_fetch_array($queryUsuario))
{
	$arrayUsuario[$rowUsuario['id_usuario']]=$rowUsuario['nombre_completo'];
}
/*$uid=date('Ymshis').microtime();
$uid=str_replace(" ","_",$uid);
$log_file_name="archivo".$uid.".txt";
$fh=fopen($log_file_name,"a+");
fwrite($fh,mssql_get_last_message()."\n");*/
$queryPorCargo=mysql_query("SELECT * FROM horario_permiso_pedidos WHERE estado=1");

//<i class="icon icon-plus" onclick="getFormMantAccesoPortafolio(\'\')"> Nuevo</i>
$contador=1;
$icono_nuevo='<a href="javascript:;" class="btn btn-success btn-md" onclick="getFormMantAccesoPortafolio('.$rowPorCargo['id_permiso'].',\'cargo\')">
								<i style="margin-top:-5px" class="glyphicon glyphicon-plus">Nuevo</i></a>';
$cadena='
		<br><strong><div align="center"><font color="white"><h3>HORARIOS SOLICITUD DE PEDIDOS  </h3></font></div>
		</strong>
			<table width="800" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:16px" >
				<thead>
					<tr >
						<th colspan="5" width="100" class="normal" style="vertical-align:middle; text-align:right;">'.$icono_nuevo.'</th>
						
					</tr>
					<tr bgcolor="#333333">
						<th width="100" class="normal" style="vertical-align:middle; text-align:center;">No.</th>
						<th width="200" class="normal" style="vertical-align:middle; text-align:center;">Cargo</th>
						<th width="200" class="normal" style="vertical-align:middle; text-align:center;">Dias</th>
						<th width="200" class="normal" style="vertical-align:middle; text-align:center;">Horario</th>
						<th width="100" class="normal" style="vertical-align:middle; text-align:center;">Opciones</th>
					</tr>
				<thead>
				<tbody>';
				$contador=0;
				while($rowPorCargo=mysql_fetch_array($queryPorCargo))
				{
					$countTR+=+1;
				if($countTR%2==0)
				{
					$bgcolor='bgcolor="#B9E1DF"';
				}else
				{
					$bgcolor='bgcolor="#D0FCF9"';
				}
					$icono_editar='<a href="javascript:;" class="btn btn-primary btn-md" onclick="getFormMantAccesoPortafolio('.$rowPorCargo['id_permiso'].',\'cargo\')">
								<i style="margin-top:-5px" class="glyphicon glyphicon-edit"></i>
					</a>';
					$icono_eliminar='<a href="javascript:;" class="btn btn-danger btn-md" onclick="getFormMantAccesoPortafolio('.$rowPorCargo['id_permiso'].',\'cargo\')">
								<i style="margin-top:-5px" class="glyphicon glyphicon-trash"></i>
					</a>';
					$contador++;
					$cadena.='
					<tr '.$bgcolor.' style=" background:'.$color_encabezado.'; color:#000">
						<td class="normal" style="vertical-align:middle; text-align:center;">'.$contador.'</td>
						<td class="normal" style="vertical-align:middle; text-align:center;">'.$arrayCargos[$rowPorCargo['id_cargo']].'</td>
						<td class="normal" style="vertical-align:middle; text-align:center;">'.str_replace(',',', ',$rowPorCargo['dias']).'</td>
						<td class="normal" style="vertical-align:middle; text-align:center;">'.$rowPorCargo['hora_ini'].' - '.$rowPorCargo['hora_fin'].'</td>
						<td class="normal" style="vertical-align:middle; text-align:center;">'.$icono_editar.' '.$icono_eliminar.'</td>';
		
			$cadena.='			
					</tr>';
				}
$cadena.='</tbody>
		</table>
	</center>		
</div>
</div>';
}

$array=array('result'=>$cadena);
echo json_encode($array);
}