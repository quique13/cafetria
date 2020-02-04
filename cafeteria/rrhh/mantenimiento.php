<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{

include('../Conexion.php');
include('../funcionesCafe.php');

$usuario=$_POST['usuario'];
$nombreA=$_POST['nombre_completo'];
$tipo=$_POST['tipo'];
$id= $_POST['baja_usuario'];
$nombre=$_POST['baja_nombre'];
$semana=$_POST['semana'];
$fecha=$_POST['fecha'];

$lunes1=trim($_POST['lunes1']);
$lunes2=trim($_POST['lunes2']);
$martes1=trim($_POST['martes1']);
$martes2=trim($_POST['martes2']);
$miercoles1=trim($_POST['miercoles1']);
$miercoles2=trim($_POST['miercoles2']);
$jueves1=trim($_POST['jueves1']);
$jueves2=trim($_POST['jueves2']);
$viernes1=trim($_POST['viernes1']);
$viernes2=trim($_POST['viernes2']);

$fechaL=date('Y-m-d',strtotime($_POST['fechaL']));
$fechaM=strtotime('+1 day',strtotime($_POST['fechaL']));
	$fechaM=date('Y-m-d',$fechaM);
	
	$fechaMi=strtotime('+2 day',strtotime($_POST['fechaL']));
	$fechaMi=date('Y-m-d',$fechaMi);
	
$fechaJ=strtotime('+3 day',strtotime($_POST['fechaL']));
	$fechaJ=date('Y-m-d',$fechaJ);
	
	$fechaV=strtotime('+4 day',strtotime($_POST['fechaL']));
	$fechaV=date('Y-m-d',$fechaV);


if($tipo=='agregar')
{
	$consult = "SELECT * FROM usuario
where codigo_usuario='$usuario'";
	$result = mysql_query($consult) or die(mysql_error());
	if ($row = mysql_fetch_array($result)>'1')
	{
		$cadena.= '

<div align="center">
        <h2>El codigo de usuario '.$usuario.' ya existe en la base de datos</h2>
           </div>';
	}else
	{
		$insert = "insert into usuario (codigo_usuario,nombre,estado)
	values('$usuario','$nombreA','a') ";	
		$result = mysql_query($insert) or die(mysql_error());
		$cadena.= '

<div align="center">
        <h2>El usuario '.$usuario.'('.$nombreA.') fue creado correctamente</h2>
           </div>';
	}
}else if($tipo=='confirmar')
{
	$cadena.=' <div id="dialog2" title="Eliminar">
 <form class="form-inline" method="post" action="">
  <p>¿Esta seguro que desea dar de baja al usuario: '.$nombre.'</p> 
	  <input type="hidden" class="form-control" id="nombre_baja" name="nombre_baja" value="'.$nombre.'" > 
	  <input type="hidden" class="form-control" id="id_baja" name="id_baja" value="'.$id.'" >
	  
	<p><center><button type="button" onClick="javascript:mantenimiento(\'eliminar\')" class="btn btn-success btn-sm" title="Dar de baja">Aceptar</button></center></p>
 
</form></div>';

  


}else if($tipo=='eliminar')
{
	


	$queryI="Update usuario set estado='c' Where codigo_usuario = '$id'";	
	if($resultI = mysql_query($queryI) or die('Error en la instruccion SQL'));
	{
		$cadena.='<div align="center"> <h2>El usuario '.$nombre.' ha sido dado de baja satisfactoriamente</h2>
           </div>';
	}

}
else if($tipo=='menu')
{
	
if($semana=='semana2')
{
	$fechaL=strtotime('+7 day',strtotime($_POST['fechaL']));
	$fechaL=date('Y-m-d',$fechaL);

$fechaM=strtotime('+8 day',strtotime($_POST['fechaL']));
	$fechaM=date('Y-m-d',$fechaM);
	
	$fechaMi=strtotime('+9 day',strtotime($_POST['fechaL']));
	$fechaMi=date('Y-m-d',$fechaMi);
	
$fechaJ=strtotime('+10 day',strtotime($_POST['fechaL']));
	$fechaJ=date('Y-m-d',$fechaJ);
	
	$fechaV=strtotime('+11 day',strtotime($_POST['fechaL']));
	$fechaV=date('Y-m-d',$fechaV);
}
if($semana=='semana3')
{
	$fechaL=strtotime('+14 day',strtotime($_POST['fechaL']));
	$fechaL=date('Y-m-d',$fechaL);


$fechaM=strtotime('+15 day',strtotime($_POST['fechaL']));
	$fechaM=date('Y-m-d',$fechaM);
	
	$fechaMi=strtotime('+16 day',strtotime($_POST['fechaL']));
	$fechaMi=date('Y-m-d',$fechaMi);
	
$fechaJ=strtotime('+17 day',strtotime($_POST['fechaL']));
	$fechaJ=date('Y-m-d',$fechaJ);
	
	$fechaV=strtotime('+18 day',strtotime($_POST['fechaL']));
	$fechaV=date('Y-m-d',$fechaV);
}

	$queryL="insert into menu_semanal (dia,menu_1,menu_2,fecha) values('lunes','".mysql_real_escape_string($lunes1)."','".mysql_real_escape_string($lunes2)."','$fechaL')
		ON DUPLICATE KEY UPDATE
		menu_1='".mysql_real_escape_string($lunes1)."',menu_2='".mysql_real_escape_string($lunes2)."'";	
	if($resultL = mysql_query($queryL) or die('Error en la instruccion SQL1'));
	{
		$cadena.='<div align="center"> <h2>El menú de lunes ha sido cargado exitosamente</h2>
           </div>';
	}
	$queryM="insert into menu_semanal (dia,menu_1,menu_2,fecha) values('martes','".mysql_real_escape_string($martes1)."','".mysql_real_escape_string($martes2)."','$fechaM')
	ON DUPLICATE KEY UPDATE
		menu_1='".mysql_real_escape_string($martes1)."',menu_2='".mysql_real_escape_string($martes2)."'";	
	if($resultM = mysql_query($queryM) or die('Error en la instruccion SQL2'));
	{
		$cadena.='<div align="center"> <h2>El menú de martes ha sido cargado exitosamente</h2>
           </div>';
	}
	$queryMi="insert into menu_semanal (dia,menu_1,menu_2,fecha) values('miercoles','".mysql_real_escape_string($miercoles1)."','".mysql_real_escape_string($miercoles2)."','$fechaMi')
	ON DUPLICATE KEY UPDATE
		menu_1='".mysql_real_escape_string($miercoles1)."',menu_2='".mysql_real_escape_string($miercoles2)."'";	
	if($resultMi = mysql_query($queryMi) or die('Error en la instruccion SQL3'));
	{
		$cadena.='<div align="center"> <h2>El menú de miércoles ha sido cargado exitosamente</h2>
           </div>';
	}
	$queryJ="insert into menu_semanal (dia,menu_1,menu_2,fecha) values('jueves','".mysql_real_escape_string($jueves1)."','".mysql_real_escape_string($jueves2)."','$fechaJ')
	ON DUPLICATE KEY UPDATE
		menu_1='".mysql_real_escape_string($jueves1)."',menu_2='".mysql_real_escape_string($jueves2)."'";	
	if($resultJ = mysql_query($queryJ) or die('Error en la instruccion SQL4'));
	{
		$cadena.='<div align="center"> <h2>El menú de jueves ha sido cargado exitosamente</h2>
           </div>';
	}
	$queryV="insert into menu_semanal (dia,menu_1,menu_2,fecha) values('viernes','".mysql_real_escape_string($viernes1)."','".mysql_real_escape_string($viernes2)."','$fechaV')
	ON DUPLICATE KEY UPDATE
		menu_1='".mysql_real_escape_string($viernes1)."',menu_2='".mysql_real_escape_string($viernes2)."'";	
	if($resultV = mysql_query($queryV) or die('Error en la instruccion SQL5'));
	{
		$cadena.='<div align="center"> <h2>El menú de viernes ha sido cargado exitosamente</h2>
           </div>';
	}
$cadena.='<META HTTP-EQUIV="REFRESH" CONTENT="3;URL=./indexconsulta.php">';
}
else if($tipo=='GetMenu')
{
	
	$diaHoy=date('Y-m-d',strtotime($fecha));
	$fechaEnviar=date('Y-m-d',strtotime($diaHoy));
	if($semana=='semana1')
	{
		$lunes=date('d/m/Y',strtotime($diaHoy));
		$martes=strtotime('+1 day',strtotime($diaHoy));
		$martes=date('d/m/Y',$martes);
	
		$miercoles=strtotime('+2 day',strtotime($diaHoy));
		$miercoles=date('d/m/Y',$miercoles);
	
		$jueves=strtotime('+3 day',strtotime($diaHoy));
		$jueves=date('d/m/Y',$jueves);
	
		$viernes=strtotime('+4 day',strtotime($diaHoy));
		$viernes=date('d/m/Y',$viernes);
		$menu='MENÚ DE LA SEMANA ACTUAL';
		$inicioSemana=$diaHoy;
		$finSemana=strtotime('+4 day',strtotime($diaHoy));
		$finSemana=date('Y-m-d',$finSemana);
		
		$selectL="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='lunes'";
	$resultL = mysql_query($selectL) or die('Error en la instruccion SQL1');
	
		while($rowL = mysql_fetch_array($resultL))
		{
			$fechaLP=strtotime($rowL['fecha']);
			$lunes1=$rowL['menu_1'];
			$lunes2=$rowL['menu_2'];
			
			$hoy=strtotime(date('Y-m-d'));
			$selectLP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaLP';";
			$resultLP = mysql_query($selectLP) or die('Error en la instruccion PEDIDOS lunes');
			$rowLP = mysql_num_rows($resultLP);
			if($rowLP>=1||$hoy>=$fechaLP )
			{
				$disabledL='disabled';
			}else
			{
				$disabledL='';
			}
		}
	
		$selectM="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='martes'";
	$resultM = mysql_query($selectM) or die('Error en la instruccion SQL1');
	
		while($rowM = mysql_fetch_array($resultM))
		{
			
			$martes1=$rowM['menu_1'];
			$martes2=$rowM['menu_2'];
			
			$fechaMP=$rowM['fecha'];
			$hoy=date('Y-m-d').'<br>';
			$selectMP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMP';";
			$resultMP = mysql_query($selectMP) or die('Error en la instruccion PEDIDOS martes');
			$rowMP = mysql_num_rows($resultMP);
			if($rowMP>=1||$hoy>=$fechaMP )
			{
				$disabledM='disabled';
			}else
			{
				$disabledM='';
			}
		}
	
		$selectMi="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='miercoles'";
	$resultMi = mysql_query($selectMi) or die('Error en la instruccion SQL1');
	
		while($rowMi = mysql_fetch_array($resultMi))
		{
			
			$miercoles1=$rowMi['menu_1'];
			$miercoles2=$rowMi['menu_2'];
			
			$fechaMiP=$rowMi['fecha'];
			$hoy=date('Y-m-d');
			$selectMiP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMiP';";
			$resultMiP = mysql_query($selectMiP) or die('Error en la instruccion PEDIDOS miercoles');
			$rowMiP = mysql_num_rows($resultMiP);
			if($rowMiP>=1||$hoy>=$fechaMiP )
			{
				$disabledMi='disabled';
			}else
			{
				$disabledMi='';
			}
		}
	
		$selectJ="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='jueves'";
	$resultJ = mysql_query($selectJ) or die('Error en la instruccion SQL1');
	
		while($rowJ = mysql_fetch_array($resultJ))
	{
		
		$jueves1=$rowJ['menu_1'];
		$jueves2=$rowJ['menu_2'];
		
		$fechaJP=$rowJ['fecha'];
		$hoy=date('Y-m-d');
		$selectJP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaJP';";
		$resultJP = mysql_query($selectJP) or die('Error en la instruccion PEDIDOS jueves');
		$rowJP = mysql_num_rows($resultJP);
		if($rowJP>=1||$hoy>=$fechaJP )
		{
			$disabledJ='disabled';
		}else
		{
			$cadena.=$disabledJ='';
		}
	}
	$selectV="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='viernes'";
	$resultV = mysql_query($selectV) or die('Error en la instruccion SQL1');
	
		while($rowV = mysql_fetch_array($resultV))
		{
			
			$viernes1=$rowV['menu_1'];
			$viernes2=$rowV['menu_2'];
			
			$fechaVP=$rowV['fecha'];
			$hoy=date('Y-m-d');
			$selectVP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaVP';";
			$resultVP = mysql_query($selectVP) or die('Error en la instruccion PEDIDOS viernes');
			$rowVP = mysql_num_rows($resultVP);
			if($rowVP>=1||$hoy>=$fechaVP )
			{
				$disabledV='disabled';
			}else
			{
				$disabledV='';
			}
		}
	
		
	}else if($semana=='semana2')
	{
		$lunes=strtotime('+7 day',strtotime($diaHoy));
		$lunes=date('d/m/Y',$lunes);
		$martes=strtotime('+8 day',strtotime($diaHoy));
		$martes=date('d/m/Y',$martes);
	
		$miercoles=strtotime('+9 day',strtotime($diaHoy));
		$miercoles=date('d/m/Y',$miercoles);
	
		$jueves=strtotime('+10 day',strtotime($diaHoy));
		$jueves=date('d/m/Y',$jueves);
	
		$viernes=strtotime('+11 day',strtotime($diaHoy));
		$viernes=date('d/m/Y',$viernes);
		$menu='MENÚ DE LA SIGUIENTE SEMANA';
		
		$inicioSemana=strtotime('+7 day',strtotime($diaHoy));
		$inicioSemana=date('Y-m-d',$inicioSemana);
		$finSemana=strtotime('+11 day',strtotime($diaHoy));
		$finSemana=date('Y-m-d',$finSemana);
		
		$selectL="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='lunes'";
	$resultL = mysql_query($selectL) or die('Error en la instruccion SQL1');
	
		while($rowL = mysql_fetch_array($resultL))
	{
		
		$idL=$rowL['id_menu_semanal'];
		$lunes1=$rowL['menu_1'];
		$lunes2=$rowL['menu_2'];
		
		$fechaLP=($rowL['fecha']);
		$hoy=(date('Y-m-d'));
		$selectLP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaLP';";
			$resultLP = mysql_query($selectLP) or die('Error en la instruccion PEDIDOS lunes');
			$rowLP = mysql_num_rows($resultLP);
			if($rowLP>=1||$hoy>=$fechaLP )
			{
				$disabledL='disabled';
			}else
			{
				$disabledL='';
			}
	}
	
		$selectM="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='martes'";
	$resultM = mysql_query($selectM) or die('Error en la instruccion SQL1');
	
		while($rowM = mysql_fetch_array($resultM))
	{
		$idM=$rowM['id_menu_semanal'];
		$martes1=$rowM['menu_1'];
		$martes2=$rowM['menu_2'];
		
		$fechaMP=$rowM['fecha'];
			$hoy=date('Y-m-d').'<br>';
			$selectMP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMP';";
			$resultMP = mysql_query($selectMP) or die('Error en la instruccion PEDIDOS martes');
			$rowMP = mysql_num_rows($resultMP);
			if($rowMP>=1||$hoy>=$fechaMP )
			{
				$disabledM='disabled';
			}else
			{
				$disabledM='';
			}
	}
	
		$selectMi="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='miercoles'";
	$resultMi = mysql_query($selectMi) or die('Error en la instruccion SQL1');
	
		while($rowMi = mysql_fetch_array($resultMi))
	{
		$idMi=$rowMi['id_menu_semanal'];
		$miercoles1=$rowMi['menu_1'];
		$miercoles2=$rowMi['menu_2'];
		
		$fechaMiP=$rowMi['fecha'];
			$hoy=date('Y-m-d');
			$selectMiP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMiP';";
			$resultMiP = mysql_query($selectMiP) or die('Error en la instruccion PEDIDOS miercoles');
			$rowMiP = mysql_num_rows($resultMiP);
			if($rowMiP>=1||$hoy>=$fechaMiP )
			{
				$disabledMi='disabled';
			}else
			{
				$disabledMi='';
			}
	}
	
		$selectJ="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='jueves'";
	$resultJ = mysql_query($selectJ) or die('Error en la instruccion SQL1');
	
		while($rowJ = mysql_fetch_array($resultJ))
	{
		$idJ=$rowJ['id_menu_semanal'];
		$jueves1=$rowJ['menu_1'];
		$jueves2=$rowJ['menu_2'];
		
		$fechaJP=$rowJ['fecha'];
		$hoy=date('Y-m-d');
		$selectJP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaJP';";
		$resultJP = mysql_query($selectJP) or die('Error en la instruccion PEDIDOS jueves');
		$rowJP = mysql_num_rows($resultJP);
		if($rowJP>=1||$hoy>=$fechaJP )
		{
			$disabledJ='disabled';
		}else
		{
			$disabledJ='';
		}
	}
	$selectV="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='viernes'";
	$resultV = mysql_query($selectV) or die('Error en la instruccion SQL1');
	
		while($rowV = mysql_fetch_array($resultV))
	{
		$idV=$rowV['id_menu_semanal'];
		$viernes1=$rowV['menu_1'];
		$viernes2=$rowV['menu_2'];
		
		$fechaVP=$rowV['fecha'];
		$hoy=date('Y-m-d');
		$selectVP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaVP';";
		$resultVP = mysql_query($selectVP) or die('Error en la instruccion PEDIDOS viernes');
		$rowVP = mysql_num_rows($resultVP);
		if($rowVP>=1||$hoy>=$fechaVP )
		{
			$disabledV='disabled';
		}else
		{
			$disabledV='';
		}
	}
	}else if($semana=='semana3')
	{
		$lunes=strtotime('+14 day',strtotime($diaHoy));
		$lunes=date('d/m/Y',$lunes);
		$martes=strtotime('+15 day',strtotime($diaHoy));
		$martes=date('d/m/Y',$martes);
	
		$miercoles=strtotime('+16 day',strtotime($diaHoy));
		$miercoles=date('d/m/Y',$miercoles);
	
		$jueves=strtotime('+17 day',strtotime($diaHoy));
		$jueves=date('d/m/Y',$jueves);
	
		$viernes=strtotime('+18 day',strtotime($diaHoy));
		$viernes=date('d/m/Y',$viernes);
		$menu='MENÚ DE LA SEMANA DESPUES DE LA SIGUIENTE';
		$inicioSemana=strtotime('+14 day',strtotime($diaHoy));
		$inicioSemana=date('Y-m-d',$inicioSemana);
		$finSemana=strtotime('+18 day',strtotime($diaHoy));
		$finSemana=date('Y-m-d',$finSemana);
		
		$selectL="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='lunes'";
	$resultL = mysql_query($selectL) or die('Error en la instruccion SQL1');
	
		while($rowL = mysql_fetch_array($resultL))
		{
			$fechaP=$rowL['id_menu_semanal'];
			$lunes1=$rowL['menu_1'];
			$lunes2=$rowL['menu_2'];
			
			$fechaLP=($rowL['fecha']);
		$hoy=(date('Y-m-d'));
		$selectLP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaLP';";
			$resultLP = mysql_query($selectLP) or die('Error en la instruccion PEDIDOS lunes');
			$rowLP = mysql_num_rows($resultLP);
			if($rowLP>=1||$hoy>=$fechaLP )
			{
				$disabledL='disabled';
			}else
			{
				$disabledL='';
			}
			
		}
	
		$selectM="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='martes'";
	$resultM = mysql_query($selectM) or die('Error en la instruccion SQL1');
	
		while($rowM = mysql_fetch_array($resultM))
		{
			$idM=$rowM['id_menu_semanal'];
			$martes1=$rowM['menu_1'];
			$martes2=$rowM['menu_2'];
			
			$fechaMP=$rowM['fecha'];
			$hoy=date('Y-m-d').'<br>';
			$selectMP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMP';";
			$resultMP = mysql_query($selectMP) or die('Error en la instruccion PEDIDOS martes');
			$rowMP = mysql_num_rows($resultMP);
			if($rowMP>=1||$hoy>=$fechaMP )
			{
				$disabledM='disabled';
			}else
			{
				$disabledM='';
			}
		}
	
		$selectMi="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='miercoles'";
	$resultMi = mysql_query($selectMi) or die('Error en la instruccion SQL1');
	
		while($rowMi = mysql_fetch_array($resultMi))
		{
			$idMi=$rowMi['id_menu_semanal'];
			$miercoles1=$rowMi['menu_1'];
			$miercoles2=$rowMi['menu_2'];
			
			$fechaMiP=$rowMi['fecha'];
			$hoy=date('Y-m-d');
			$selectMiP="SELECT * FROM cafeteria.pedidos
	where fecha_menu='$fechaMiP';";
			$resultMiP = mysql_query($selectMiP) or die('Error en la instruccion PEDIDOS miercoles');
			$rowMiP = mysql_num_rows($resultMiP);
			if($rowMiP>=1||$hoy>=$fechaMiP )
			{
				$disabledMi='disabled';
			}else
			{
				$disabledMi='';
			}
		}
	
		$selectJ="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='jueves'";
	$resultJ = mysql_query($selectJ) or die('Error en la instruccion SQL1');
	
		while($rowJ = mysql_fetch_array($resultJ))
		{
			$idJ=$rowJ['id_menu_semanal'];
			$jueves1=$rowJ['menu_1'];
			$jueves2=$rowJ['menu_2'];
			
			$fechaJP=$rowJ['fecha'];
			$hoy=date('Y-m-d');
			$selectJP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaJP';";
			$resultJP = mysql_query($selectJP) or die('Error en la instruccion PEDIDOS jueves');
			$rowJP = mysql_num_rows($resultJP);
			if($rowJP>=1||$hoy>=$fechaJP )
			{
				$disabledJ='disabled';
			}else
			{
				$cadena.=$disabledJ='';
			}
		}
	$selectV="select * from menu_semanal
where fecha between '$inicioSemana' and '$finSemana'
and dia='viernes'";
	$resultV = mysql_query($selectV) or die('Error en la instruccion SQL1');
	
		while($rowV = mysql_fetch_array($resultV))
		{
			$idV=$rowV['id_menu_semanal'];
			$viernes1=$rowV['menu_1'];
			$viernes2=$rowV['menu_2'];
			
			$fechaVP=$rowV['fecha'];
			$hoy=date('Y-m-d');
			$selectVP="SELECT * FROM cafeteria.pedidos
where fecha_menu='$fechaVP';";
			$resultVP = mysql_query($selectVP) or die('Error en la instruccion PEDIDOS viernes');
			$rowVP = mysql_num_rows($resultVP);
			if($rowVP>=1||$hoy>=$fechaVP )
			{
				$disabledV='disabled';
			}else
			{
				$disabledV='';
			}
		}
	}
	
	$cadena.='<center>
	<table width="900" border="1" bordercolor="#000000" style="table-layout:fixed; font-size:14px" >
	<caption><center><h2><font color="white">'.$menu.'</font></h2></center></caption>
		 <tr bgcolor="#666666"> 
   			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Día</b></font></td>
			<td width="350" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Menú Carne</b></font></td>
			<td width="350" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Menú Pollo</b></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Fecha</b></font></td>
 		</tr>
		<tr bgcolor="#333333"> 
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Lunes</b></font></td>
			<td width="350"  style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledL.' style="resize: none;" id="lunes1" name="lunes1" rows="3" cols="47" >'.$lunes1.'
</textarea></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledL.' style="resize: none;" id="lunes2" rows="3" cols="47" >'.$lunes2.'
</textarea></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center" ><font color="white"><b>'.$lunes.'</b></font></td>
			<input type="hidden" id="fechaL" value="'.$fechaEnviar.'" />
			<input type="hidden" id="semana" value="'.$semana.'" />
			</tr>
		<tr bgcolor="#333333">  
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Martes</b></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledM.' style="resize: none;" id="martes1" rows="3" cols="47" >'.$martes1.'
</textarea></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledM.' style="resize: none;" id="martes2" rows="3" cols="47" >'.$martes2.'
</textarea></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center" ><font color="white"><b>'.$martes.'</b></font></td>
			</tr>
		<tr bgcolor="#333333">
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Miércoles</b></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledMi.' style="resize: none;" id="miercoles1" rows="3" cols="47">'.$miercoles1.'
</textarea></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledMi.' style="resize: none;" id="miercoles2" rows="3" cols="47" >'.$miercoles2.'
</textarea></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center" ><font color="white"><b>'.$miercoles.'</b></font></td>
			</tr>
		<tr bgcolor="#333333">
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Jueves</b></font></td><td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledJ.' style="resize: none;" id="jueves1" rows="3" cols="47">'.$jueves1.'
</textarea></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledJ.' style="resize: none;" id="jueves2" rows="3" cols="47">'.$jueves2.'
</textarea></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center" ><font color="white"><b>'.$jueves.'</b></font></td>
			</tr>
		<tr bgcolor="#333333">
			<td width="80" height="50" style="white-space: nowrap;" align="center"><font color="white"><b>Viernes</b></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledV.' style="resize: none;" id="viernes1" rows="3" cols="47">'.$viernes1.'
</textarea></font></td>
			<td width="350" style="white-space: nowrap;" align="center"><font color="black"><textarea '.$disabledV.' style="resize: none;" id="viernes2" rows="3" cols="47">'.$viernes2.'
</textarea></font></td>
			<td width="120" height="50" style="white-space: nowrap;" align="center" ><font color="white"><b>'.$viernes.'</b></font></td>
			</tr></table>
 </div><br />
           <div align="center">
          <font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php?reporte=1\'" >Cancelar</button></font>
           <font color="black"><button name="consultar" id="conultar" onClick="javascript:mantenimiento(\'menu\')" type="button" class="btn btn-success btn-md">Enviar</button></font>
      </div> ';
}
$array=array('result'=>$cadena);
echo json_encode($array);
}
?>