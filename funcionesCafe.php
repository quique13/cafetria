<?php
//Devuelve un array con las fechas que son lunes entre la fecha dada y cantidad de dias
function fecha($diaHoy)
{
	if($diaHoy==1)
	{
		$fechaDia = date('Y-m-d') ;
	}else if($diaHoy==2)
	{
		$fechaDia = date('Y-m-d', strtotime('-1 day')) ;
	}else if($diaHoy==3)
	{
		$fechaDia = date('Y-m-d', strtotime('-2 day')) ;
	}else if($diaHoy==4)
	{
		$fechaDia = date('Y-m-d', strtotime('-3 day')) ;
	}else if($diaHoy==5)
	{
		$fechaDia = date('Y-m-d', strtotime('-4 day')) ;
	}else if($diaHoy==6)
	{
		$fechaDia = date('Y-m-d', strtotime('-5 day')) ;
	}else if($diaHoy==7)
	{
		$fechaDia = date('Y-m-d', strtotime('-6 day')) ;
	}
	return $fechaDia;
}
?>