<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ES">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ConsultaTotales</title>

<!-calendario -->
<link rel="stylesheet" type="text/css" media="all" href="calendar-green.css" title="win2k-cold-1" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

<!-- librería principal del calendario -->
<script type="text/javascript" src="calendar.js"></script>

<!-- librería para cargar el lenguaje deseado -->
<script type="text/javascript" src="lang/calendar-es.js"></script>

<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript" src="calendar-setup.js"></script>

 <script>
jQuery(function($){

$.datepicker.regional['es'] = {

closeText: 'Cerrar',

prevText: 'Anterior',

nextText: 'Siguiente',

currentText: 'Hoy',

monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],

monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],

dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],

dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],

dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],

weekHeader: 'Sm',

dateFormat: 'dd/mm/yy',

firstDay: 1,

numberOfMonths: 1,

isRTL: false,

showMonthAfterYear: false,

yearSuffix: ''};

$.datepicker.setDefaults($.datepicker.regional['es']);

});
$(function() {
$( "#fecha1" ).datepicker();
$( "#fecha2" ).datepicker();
});


</script>

  <style type="text/css">
BODY {

  background: #0066CC; 

  background-image:url(imagen.jpg);
  background-attachment: fixed;
  background-repeat: repeat;
 

  color: #FFFFFF; //color a las letras blanco
 

}

</style>
 </head>

<center>

<body>

<label><br />
</label>
<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../usuario/top.png" width="900" height="150" /></td>
  </tr>
  <tr>
    <td><label><br />
        <br />
        <br />
    </label>
      <div align="center">
        <h1>Consultar La Tabla Total por Usuarios</h1>
        <form id="form1" name="form1" method="post" action="ConsultaTotales2.php">
          <br />
          <br />
          <div align="center">
          <label>Primera Fecha
            <input type="text" name="fecha1" id="fecha1" />
          </label>
          <br />
          <br />
          <div align="center">
          <label>Segunda Fecha
            <input type="text" name="fecha2" id="fecha2" />
          </label>
          <label><br />
            <br />
          <input type="submit" name="confirmar" id="confirmar" value="Aceptar" />
          </label>
        </form>
        <!-- script que define y configura el calendario-->
      </div></td>
  </tr>
</table>
<label><br />
</label>
<script type="text/javascript">
Calendar.setup({
inputField : "fecha1", // id del campo de texto
inputField : "fecha2", // id del campo de texto
ifFormat : "%d/%m/%Y", // formato de la fecha que se escriba en el campo de texto
});
</script>
</body>
</center>
</html>
