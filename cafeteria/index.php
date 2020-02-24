
<?php
ini_set("session.cookie_lifetime","10800");
ini_set("session.gc_maxlifetime","10800");
session_start();
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{
	include('Conexion.php');
	include("session.php");
	//$precio="precio_";
	$consulta_cat=mysqli_query($conexion,"select * from categoria where estado = 1 order by id_categoria");
	$LIBS_DIR="./libs/";
	?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/themes/redmond2/jquery-ui.css" />
			<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
			<script src="<?=$LIBS_DIR;?>jq/jquery-1.10.2.js"></script>
			<script src="<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
			<script src="<?=$LIBS_DIR;?>jq/funciones.js?<?=time();?>"></script>
			<title>Cafeteria</title>
			<script language="javascript">
				function abrirMenu(precio,cat){
					var parametros = {
						"cat" : cat,
						"precio" : precio,
					};
					$.ajax({
						type:"POST",
						data :parametros,
						dataType: "json",
						url:"MenuCat.php",
						beforeSend:function (){
						},
						success:function (response){
							$("#menu").html(response.result);
							$("#total").html(response.result1);
						},
						error:function() {
							$("#divAlert").html('<div class="alert alert-danger" id="alert"><strong><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></strong>Intente nuevamente</div>');
							$("#divAlert").show(500);
							setTimeout('$("#divAlert").hide(500)',2500);
						}
					});
				}
				$().ready(Compra('0','0','0','0'));
				$(function() {
					actualizar_sesion();
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
					background-image: url(imagen.jpg);
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
			</style> 
		</head>
	
		<body>
			<center>
				<div  class=" col-md-12; panel-heading" style="">
					<img src="top.png" width="900" height="125">
				</div>
				<div id="divAlert" class="col-md-12 " >
				</div>
				<div id="actualizar_session" style="display:none">
				</div>
				<div class='col-md-12 '>
					<div id="categorias" class="col-md-1 ">
					</div>
					<div id="menu" class="col-md-8 " >
					</div>
					<div  id="detalle" class='col-md-3 ' >
					</div>
				</div>
				<div id="confirmar" class="col-md-12 " >
				</div>
			</center>
			<div id="confirmar_registro" title="Confirmación de Registro">
			</div>
			<div id="campos_vacios" title="Campos Vacios">
			</div>
		</body>
	</html>
	<?php
}
?>