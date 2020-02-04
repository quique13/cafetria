function grabarUser()
{
	
	id_user=$("#id_user").val()
	nombre_completo=$("#nombre_completo").val()	
	{	
		data={id_user:id_user,nombre_completo:nombre_completo};
		jQuery.ajax({
			type:"POST",
		  	data :data,
		  	dataType: "json",
		  	url:"mantenimiento.php",
			
			success:function (response){
				$("#reportes").html(response.result)			
			},
			error:function (){
				$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong> Eror inesperado, intente nuevamente </div>');
				$("#divAlert").show(500);
				setTimeout('$("#divAlert").hide(500)',2500);
			}
		});
	}
}
function confirmarCompra(tipo)
{
	var parametros = {
		"tipo" : tipo,	  
	};
	$.ajax({
		url: "ConfirmarCompra.php",
		type: "post",
		dataType: "json",
		data: parametros,
		
		success:function (response){
			$("#confirmar").html(response.result);
			$("#categorias").html('');
			$("#detalle").html('');
			$("#menu").html('');
			document.getElementById("Codigo_Barra").focus();
		},
		error:function (){	
			$("#confirmar").html('Error, Intente nuevamente');
		}
	});
}
function detalleCompra()
{
	$.ajax({
		url: "DetalleCompra.php",
		type: "post",
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,		
		
		success:function (response){
			$("#detalle").html(response.result);				
		},
		error:function (){	
			$("#detalle").html('Sin datos aún');
		}
	});
}
function confirmarCodigo(form)
{
	var formData = new FormData(document.getElementById(form));
	$("#conf_compra").attr("disabled", true);
	$.ajax({
		url: "ConfirmarCodigo.php",
		type: "post",
		dataType: "json",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		
		success:function (response){
			
			if(response.error=='0')
			{
				$("#divAlert").html('<div class="alert alert-success" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Pago se Realizo con Exito</div>');
				$("#divAlert").show(500);
				setTimeout('location.href="index.php"',3500,'$("#divAlert").hide(500)',2500);
				$("#confirmar").html('');
			}else if (response.error=='1')
			{	
				$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Usuario invalido, por favor intentar de nuevo o comunicarse con Recursos Humanos</div>');
				$("#divAlert").show(500);
				setTimeout('$("#divAlert").hide(500)',2500);
				document.getElementById("Codigo_Barra").focus();			
			}
			$('#conf_compra').attr("disabled", false);
		},
		error:function (){	
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>¡¡¡ERROR!!!</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
			$('#conf_compra').attr("disabled", false);
		}
	});
}
function Compra(precio,cat,total,oper,id){
	var parametros = {
		"precio" : precio,
		"cat": cat,
		"total": total,
		"oper": oper,
		"id":id,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"MenuCat.php",
		beforeSend:function (){
		},
		success:function (response){
			detalleCompra('confirmar');
			$("#menu").html(response.result);
			$("#categorias").html(response.result1);
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}	
	});
}
function Seleccion(fecha,dia,menu,no_menu,id_count,tipo){
	var parametros = {
		"fecha" : fecha,
		"dia": dia,
		"menu": menu,
		"no_menu": no_menu,
		"id_count":id_count,
		"tipo":tipo,	  
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"pedidosPro.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#seleccion").html(response.result);
			tablaPedidos('tabla');
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function tablaPedidos(tipo){
	var parametros = {
		"tipo":tipo,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"pedidosPro.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#seleccion").html(response.result);
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function Seleccion1(fecha,dia,menu,no_menu,id_count,tipo){
	var parametros = {
		"fecha" : fecha,
		"dia": dia,
		"menu": menu,
		"no_menu": no_menu,
		"id_count":id_count,
		"tipo":tipo,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"pedidosPro1.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#seleccion").html(response.result);
			tablaPedidos1('tabla');
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function tablaPedidos1(tipo){
	var parametros = {
		"tipo":tipo,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"pedidosPro1.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#seleccion").html(response.result);
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function mensaje(msg,pagina)
{
	$(function() {
		$("#mensaje").html(msg);
		$( "#mensaje" ).dialog({
			modal: true,
			position: 'top',
			width: 350,
			buttons: {
				"Aceptar": function() {
					$( this ).dialog( "close" );
				  	if(pagina!==undefined)
				  	{
				  		window.location=pagina;
				  	}
				}
			}
		});
	});
}
function campos_vacios(msg)
{
	$(function() {
		$("#campos_vacios").html(msg);
		$( "#campos_vacios" ).dialog({
			position: 'top',
			modal: true,
			width: 350,
			closeOnEscape: false,
			buttons: {
				"Aceptar": function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
}
function enviar_reg(formulario)
{
	$("#confirmar_registro").html('¿Desea Enviar los datos?');
	$(function() {
		$( "#confirmar_registro" ).dialog({		
			resizable: false,
		  	position: 'top',
		  	width: 350,
		  	modal: true,
		  	buttons: {
				"Aceptar": function() {
			  		$( this ).dialog( "close" );
			  		formulario.submit();
				},
				"Cancelar": function() {
			  		$( this ).dialog( "close" );
				}
			}
		});
	});
}
function GetReportes(tipo){
	var parametros = {
		"tipo":tipo,
			  
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"./rrhh/GetReportes.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#Getreportes").html(response.result);
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function Reportes(tipo){
	fecha_ini=$("#fecha1").val();
	fecha_fin=$("#fecha2").val();
	usuario=$("#usuario").val();
		
	data={fecha_ini:fecha_ini,fecha_fin:fecha_fin,tipo:tipo,usuario:usuario};
	$.ajax({
		type:"POST",
		data :data,
		dataType: "json",
		url:"./rrhh/Reportes.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#reportes").html(response.result);
			$("#categorias").html("");
			$("#Getreportes").html("");
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function GetMantenimiento(tipo){
	var parametros = {
		"tipo":tipo,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"./rrhh/GetMantenimiento.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#Getreportes").html(response.result);
			$("#reportes").html("");
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function mantenimiento(tipo)
{
	if(tipo=='agregar')
	{
		nombre_completo=$("#nombre_completo").val();
		usuario=$("#id_user").val();
		data={nombre_completo:nombre_completo,tipo:tipo,usuario:usuario};
	}else if(tipo=='eliminar')
	{
		baja_usuario=$("#id_baja").val();
		baja_nombre=$("#nombre_baja").val();
		data={baja_usuario:baja_usuario,baja_nombre:baja_nombre,tipo:tipo};
	}else if(tipo=='menu')
	{
		lunes1=$("#lunes1").val();
		lunes2=$("#lunes2").val();
		martes1=$("#martes1").val();
		martes2=$("#martes2").val();
		miercoles1=$("#miercoles1").val();
		miercoles2=$("#miercoles2").val();
		jueves1=$("#jueves1").val();
		jueves2=$("#jueves2").val();
		viernes1=$("#viernes1").val();
		viernes2=$("#viernes2").val();
		fechaL=$("#fechaL").val();
		semana=$("#semana").val();
		
		
		data={lunes1:lunes1,lunes2:lunes2,martes1:martes1,martes2:martes2,miercoles1:miercoles1,miercoles2:miercoles2,jueves1:jueves1,
		jueves2:jueves2,viernes1:viernes1,viernes2:viernes2,fechaL:fechaL,semana:semana,tipo:tipo};
	}
	$.ajax({
		type:"POST",
		data :data,
		dataType: "json",
		url:"./rrhh/mantenimiento.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#reportes").html(response.result);
			$("#Getreportes").html("");
			if(tipo=='eliminar')
			{
				$( "#resultados_dialog" ).dialog( "close" );
			}
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
  	});
}
function mantenimiento1(tipo,fecha,semana)
{
	var parametros = 
	{
		"tipo":tipo,
		"fecha":fecha,
		"semana":semana,
	};
	$.ajax({
		type:"POST",
		data :parametros,
		dataType: "json",
		url:"./rrhh/mantenimiento.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#reportes").html(response.result);
			$("#categorias").html("");
			$("#Getreportes").html("");
		},
		error:function() {
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}
	});
}
function Confirmar(tipo)
{
	baja_usuario=$("#baja_usuario option:selected").val();
	baja_nombre=$("#baja_usuario option:selected").text();
	data={baja_usuario:baja_usuario,baja_nombre:baja_nombre,tipo:tipo};		
		
	$.ajax({
		url: './rrhh/mantenimiento.php',
		type: "post",
		dataType: "json",
		data: data,
		success:  function (response)
		{   
			$("#resultados_dialog").html(response.result);
			$( "#resultados_dialog" ).dialog( "open" );
		},
		error: function ()
		{
			alert('ERROR INESPERADO');
		}
	});
}
function GuardarSeleccion(tipo)
{
	fecha=$("#fecha").val();
	dia=$("#dia").val();
	menu=$("#menu").val();
	no_menu=$("#no_menu").val();
	data={fecha:fecha,dia:dia,menu:menu,no_menu:no_menu,tipo:tipo};
	$.ajax
	({
	 	type:"POST",
		data :data,
		dataType: "json",
		url:"pedidosPro.php",
		beforeSend:function ()
		{
		},
		success:function (response)
		{
			$("#seleccion").html('');
			$("#seleccion1").html('<div class="alert alert-success" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Menú enviado</div>');
			$("#seleccion1").show(500);
			setTimeout('$("#seleccion1").hide(500)',500);
		},
		error:function() 
		{
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);
		}		 
	});
}
function Mant_Menu(tipo,id)
{	
	if(tipo=='nueva')
	{
		data={tipo:tipo};
	}else 
	{	
		data={tipo:tipo,id:id};
	}
	$.ajax
	({
		type:"POST",
		data :data,
		dataType: "json",
		url:"./rrhh/Mant_Menu.php",
		beforeSend:function (){
		},
		success:function (response){
			$("#Dialog_CatMenu").html(response.result);
		 	$( "#Dialog_CatMenu" ).dialog( "open" );
			$("#reportes").html('');
		},
		error:function() 
		{
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
				setTimeout('$("#divAlert").hide(500)',2500);
		}
  	});
}
function SubirImagen()
{
	var formData = new FormData(document.getElementById('NuevaImagen'));
	
	$.ajax({
		url: "./rrhh/Mant_Menu.php",
		type: "post",
		dataType: "json",
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend:function (){
		},
		success:function (response){
			$("#Dialog_CatMenu").html(response.result);
		 	$( "#Dialog_CatMenu" ).dialog( "open" );
			$("#reportes").html('');
		},
		error:function (){	
			$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
			$("#divAlert").show(500);
			setTimeout('$("#divAlert").hide(500)',2500);	
		}
	});
}
function eliminar1(tipo,id_usuario,fecha_menu)
{
	var parametros = 
	{
		"id_usuario":id_usuario,
        "tipo": tipo,
		"fecha_menu" : fecha_menu
	};
	$.ajax({
		url: 'pedidosPro1.php',
		type: "post",
		dataType: "json",
		data: parametros,
		success:  function (response)
		{   
			tablaPedidos1('tabla');
		},
		error: function ()
		{
			alert('ERROR INESPERADO');
		}
	});
}
function eliminar(tipo,id_usuario,fecha_menu)
{
	var parametros = 
	{
		"id_usuario":id_usuario,
        "tipo": tipo,
		"fecha_menu" : fecha_menu
	};
	$.ajax({
		url: 'pedidosPro.php',
		type: "post",
		dataType: "json",
		data: parametros,
		success:  function (response)
		{   
			tablaPedidos('tabla');
		},
		error: function ()
		{
			alert('ERROR INESPERADO');
		}
	});
}
function actualizar_sesion()
{
	if(typeof(refresh_session)!="undefined")
	{
		clearInterval( refresh_session );
		refresh_session = window.setInterval(function() {
				  $('#actualizar_session').load('./actualizar_sesion.php');
			   }, (60000));
	}
	else
	{
		refresh_session = window.setInterval(function() {
				  $('#actualizar_session').load('./actualizar_sesion.php');
			   }, (60000));
	}

}
