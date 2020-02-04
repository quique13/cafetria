<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{

include('../Conexion.php');
 
$tipo=$_POST['tipo'];

if($tipo=='producto')
{
	$cadena.='
        <div align="center">
        <h1>VENTAS POR PRODUCTO</h1>
	    <form id="form1" name="form1" method="post" action="">
          <div align="center">
          	<label>Fecha inicial:
             <font color="black"><input type="text" name="fecha_ini" id="fecha1" required/></font>
          	</label>
          	<label>Fecha final:
             <font color="black"><input type="text" name="fecha_fin" id="fecha2" required/></font>
          	</label>
          </div><br />
          <div align="center">
          	<font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
           <font color="black"><button name="consultar" id="conultar" onClick="javascript:Reportes(\'producto\')" type="button" class="btn btn-success btn-md">Consultar</button></font>
          </div>
        </form>';
}else if($tipo=='tendencia')
{
	$cadena.='
        <div align="center">
        <h1>TENDENCIA DE MENÚS POR DIA</h1>
	    <form id="form1" name="form1" method="post" action="">
          <div align="center">
          	<label>Fecha inicial:
             <font color="black"><input type="text" name="fecha_ini" id="fecha1" required/></font>
          	</label>
          	<label>Fecha final:
             <font color="black"><input type="text" name="fecha_fin" id="fecha2" required/></font>
          	</label>
          </div><br />
          <div align="center">
          	<font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
           <font color="black"><button name="consultar" id="conultar" onClick="javascript:Reportes(\'tendencia\')" type="button" class="btn btn-success btn-md">Consultar</button></font>
          </div>
        </form>';
}
else if($tipo=='ConsumoTotal')
{
	$cadena.='
      <div align="center" >
	<h1>CONSULTA TOTAL POR USUARIO</h1>
	<div align="center" >
	<form id="form1" name="form1">
    <div align="center">
    <label>Fecha inicial:
    <font color="black"><input type="text" name="fecha1" id="fecha1" required/></font>
    </label>
    <label>Fecha final:
    <font color="black"><input type="text" name="fecha2" id="fecha2" required/></font>
    </label>
    </div><br />
    <div align="center">
    <font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
     <font color="black"><button name="consultar" id="conultar" type="button" onClick="javascript:Reportes(\'ConsumoTotal\')" class="btn btn-success btn-md">Consultar</button></font>
          
		  </div><br></div>
        </form>
    </div>
';
}else if($tipo=='individual')
{
$cadena.='<div align="center" >
	<h1>CONSULTA INDIVIDUAL</h1>
	<div align="center" >
	<form id="form1" name="form1">
    <div align="center">
    <label>Codigo Usuario:
    <font color="black"><input type="text" name="usuario" id="usuario" required/ ></font>
    </label>
    <label>Fecha inicial:
    <font color="black"><input type="text" name="fecha1" id="fecha1" required/></font>
    </label>
    <label>Fecha final:
    <font color="black"><input type="text" name="fecha2" id="fecha2" required/></font>
    </label>
    </div><br />
    <div align="center">
    <font color="black"><button type="button" class="btn btn-danger btn-md" onclick="location.href = \'./indexconsulta.php\'" >Salir</button></font>
     <font color="black"><button name="consultar" id="conultar" type="button" onClick="javascript:Reportes(\'individual\')" class="btn btn-success btn-md">Consultar</button></font>
          
		  </div><br></div>
        </form>
    </div>';
}

$cadena.='<script>
jQuery(function($){

$.datepicker.regional["es"] = {

closeText: "Cerrar",

prevText: "Anterior",

nextText: "Siguiente",

currentText: "Hoy",

monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],

monthNamesShort: ["Ene","Feb","Mar","Abr", "May","Jun","Jul","Ago","Sep", "Oct","Nov","Dic"],

dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],

dayNamesShort: ["Dom","Lun","Mar","Mié","Juv","Vie","Sáb"],

dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sá"],

weekHeader: "Sm",

dateFormat: "dd-mm-yy",

firstDay: 1,

numberOfMonths: 1,

isRTL: false,

showMonthAfterYear: false,

yearSuffix: ""};

$.datepicker.setDefaults($.datepicker.regional["es"]);

});
$(function() {
$( "#fecha1" ).datepicker();
$( "#fecha2" ).datepicker();
});


</script>';

$array=array('result'=>$cadena);
echo json_encode($array);
}

?>