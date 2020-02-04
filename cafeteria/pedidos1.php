
<?php

session_start();  
$user=$_SESSION['userid'];


$LIBS_DIR="./libs/";
include('Conexion.php');
include('Conexion_sac.php');
$hoy=date('Y-m-d H:i:s');
$hoyNo=strtotime($hoy);
$horaRest1=date('Y-m-d 08:00:00');
$horaRest2=date('Y-m-d 14:00:00');
$horaRest1=strtotime($horaRest1);
$horaRest2=strtotime($horaRest2);
$limite=date('Y-m-d 10:00:00');
$limiteNo=strtotime($limite);
$fecha_inicio=date('Y-m-d',strtotime('+1 day'));
$queryUser = "SELECT * FROM usuario_reporte WHERE usuario='$user'";
$Usuario_reporte = mysql_query($queryUser);


$cadena.='
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="./libs/jq/jquery-ui-1.10.3/themes/redmond2/jquery-ui.css" />
 		<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
		<script src="./libs/jq/jquery-1.10.2.js"></script>
		<script src="./libs/jq/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
		<script src="./libs/jq/funciones.js"></script>
		<title>Menús Cafeteria</title>


		<script type="text/javascript">
			$(function() {
			tablaPedidos1(\'tabla\');
			});
		</script>
  		<style type="text/css">
			BODY 
			{
				background:  	#CCCCCC;
				// Color Azul
				color: #FFFFFF;
				background-attachment: fixed;
				background-repeat: repeat;
				background-position: bottom right;
				color: #FFFFFF;
				//color a las letras blanco
				background-image: urlimagen.jpg);
				background-image: url(imagen.jpg);
			}
	
			input.absoluto {
				top: 29px;
				left: 0px;
				position: relative;
			}
			button.absoluto {
				top: 29px;
				left: 0px;
				position: relative;
			}
			input.absoluto1 {
				top: 13px;
				left: 0px;
				position: relative;
			}
			button.absoluto1 {
				top: 13px;
				left: 0px;
				position: relative;
			}
			input.absoluto2 {
				top: 10px;
				left: 0px;
				position: relative;
			}
			button.absoluto2 {
				top: 10px;
				left: 0px;
				position: relative;
			}
			.close {
				color: #FF0000; 
				opacity: 1;
			}
		</style> 
		<style>
			p.one {
    			border-style: solid;
    			border-color: #ffffff;
			}
		</style>
	</head>
	<body>
		<center>
			<div  class=" col-md-12; panel-heading" style="">
				<img src="top.png" width="900" height="125">
			</div>
';
if($hoyNo>=$horaRest1 && $hoyNo<=$horaRest2)
{
	$cadena.='
		</center>
	</body>
</html>
<div class="col-md-12 col-lg-12" >
	<div id="reportes" class="col-md-12 col-lg-12" >
			<center><table width="800" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:12px" >
				<caption><center><font color="white">MENÚS DE LA SEMANA <button type="button" class="btn btn-danger btn-sm pull-right" title="Cerrar sesion" onclick="location.href = \'logout1.php\'" >Cerrar sesión</button>
				';if($row = mysql_num_rows($Usuario_reporte)>=1){
				  	$cadena.=' <button type="button" class="btn btn-primary btn-sm pull-right" title="Regresar" onclick="location.href = \'indexconsulta.php\'" >Regresar</button>';
					}$cadena.='</font></center></caption>
				<tr bgcolor="#666666"> 
					<td width="100" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>FECHA</b></font></td>
					<td width="100" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>DÍA</b></font></td>
					<td width="300" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>MENÚ CARNE</b></font></td>
					<td width="300" height="25" style="white-space: nowrap;" align="center"><font color="white"><b>MENÚ POLLO</b></font></td>
				</tr>';
		
	$select="SELECT * FROM menu_semanal
	where fecha >= '$fecha_inicio'
	and(menu_1!='' or menu_2!='')
	order by fecha
	limit 5;";
	$result = mysql_query($select) or die('Error en la instruccion SQL1');
	
	while($row = mysql_fetch_array($result))
	{
		$fechaOrden=date('d-m-Y',strtotime($row['fecha']));
		$id_count=$id_count+1;
		$cadena.='<tr bgcolor="#333333"> 
				<td width="120" height="25"  align="center" style="white-space: normal;"><font color="white">'.$fechaOrden.'</font></td>
				<td width="80" height="25"  align="center" style="white-space: normal;"><font color="white">'.$row['dia'].'</font></td>
				<td width="350" height="25"    align="center" style="white-space: normal;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:  Seleccion1(\''.$row['fecha'].'\',\''.$row['dia'].'\',\''.$row['menu_1'].'\',\'1\',\''.$id_count.'\',\'guardar\') ;" style= "cursor:pointer;"><font color="white">'.$row['menu_1'].'</font></td>
				<td width="350" height="25"   align="center" style="white-space: normal;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:  Seleccion1(\''.$row['fecha'].'\',\''.$row['dia'].'\',\''.$row['menu_2'].'\',\'2\',\''.$id_count.'\',\'guardar\') ;" style= "cursor:pointer;"><font color="white">'.$row['menu_2'].'</font></td>
				</tr>
				<tr bgcolor="#680505">
				<td width="80" height="5" colspan="5"></td>
				</tr>';
	}
	$cadena.=' </table></center>
	';



	$cadena.='
</div>
<div id="seleccion" class="col-md-12 col-lg-12">

</div>

';
}
else
{
	$cadena.='<center><div><table width="710" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:12px" >
	<caption><center><h2><font color="white">Para seleccionar menús de almuerzo debe ingresar en horario de 8:00 a. m. a 11:00 a. m.</font></h2></center></caption></table></div></center>';
}
$cadena.='</body></html>';
echo $cadena;
$array=array('result'=>$cadena);
json_encode($array);
?>