
<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{
	include('Conexion.php');
	$nombre_cat=$_POST['nombre_cat'];
	$tipo_cat=$_POST['tipo_cat'];
	$usuarioP=$_SESSION['userid'];
	$LIBS_DIR="./libs/";
	$reporte=$_GET['reporte']!=''?$_GET['reporte']:0;
	?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/themes/redmond2/jquery-ui.css" />
			<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
			<script src="<?=$LIBS_DIR;?>jq/jquery-1.10.2.js"></script>
			<script src="<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
			<script src="<?=$LIBS_DIR;?>jq/funciones.js"></script>
			<title>Reporteria/Mantenimiento</title>

			<script language="javascript">

				$( function() {
					$( "#resultados_dialog" ).dialog({
				
						width: 300,
						height: "auto",
						modal: true,
						autoOpen: false,
						buttons: {
							Salir: function() {
								$( "#resultados_dialog" ).dialog( "close" );
        					}
      					}
    		 		});
		 	 	});
 				$( function() {
    				$( "#Dialog_CatMenu" ).dialog({
						width:400,
						height: "auto",
						modal: true,
						autoOpen: false,
		  				buttons: {
    	    				Salir: function() {
        	 			 	$( "#Dialog_CatMenu" ).dialog( "close" );
        					}
      					}
    		 		});
				});
			</script>

			<style type="text/css">
                BODY {
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
    
                .ui-dialog-titlebar {
                    background-color: #333333;
                    background-image: none;
                    color: #999;
                }
                .ui-widget-content {
                    background-color: #666666;
                    background-image: none;
                    color: #000;
                }
                .ui-dialog-buttonset .ui-button{
                    background: #333333;
                    color: #999;
                }
    
                .ui-datepicker {
                    background: #555;
                    border: 1px solid #555;
                    color: #EEE;
                }
                input.absoluto {
                    top: 29px;
                    left: 0px;
                    position: relative;
                }
                button.absoluto {
                    top: 0px;
                    left: 185px;
                    right:0px;
                    position: relative;
    
                }
    
                button.absoluto1 {
                    top: 0px;
                    left: 308px;
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
    
            <div id="divAlert" class="col-md-12 " ></div>
     
            <div class='col-md-12 '  >
                <div id="categorias" class="col-md-2 " >
                    <div id="resultados_dialog" style="display:none" title="Confirmación de baja"></div> 
                    <div id="Dialog_CatMenu" style="display:none" title="Agregar nueva categoria"></div> 
                    <?php
    
                    $selectPermisos = "SELECT * FROM usuario_reporte
                    where usuario='$usuarioP'";
                    $resultPer = mysql_query($selectPermisos) or die('Error en la instruccion SQL');
    
    
                    if ($rowPer = mysql_fetch_array($resultPer))
                    {
                        $permiso=$rowPer['tipo_usuario'];
                        if($permiso=='interno')
                        {
                            echo '<table style="table-layout:fixed; font-size:12px" class=" table table- table-bordered" >
                <caption><center><font color="white"><h3>Reporteria<h3></font><center></caption>
                <tr bgcolor="#666666" title="Reporte detalle de compra individual"  style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" 		onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'individual\')"
        ">
                <td ><center>CONSUMO INDIVIDUAL</center> </td></tr>
                <tr title="Reporte total consumido por usuarios" bgcolor="#666666" style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'ConsumoTotal\')"
        ">
                <td ><center>CONSUMO TOTAL POR USUARIOS
                </center> </td>
                </tr>
                <tr title="Reporte por producto vendido" bgcolor="#666666" style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'producto\')"
        ">
                <td ><center>VENTAS POR PRODUCTO
                </center> </td>
                </tr>
                <tr title="Tendencia de pedidos por día" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'tendencia\')"
        ">
                <td ><center>TENDENCIA POR DIA
                </center> </td>
                </tr>
                <tr title="Solicitar menú" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="location.href = \'pedidos1.php\'"
        ">
                <td ><center>SOLICITAR MENÚ
                </center> </td>
                </tr>';
                        echo'</table>';
    
                        echo '
                <table style="table-layout:fixed; font-size:12px" class=" table table- table-bordered" >
                <caption><center><font color="white"><h3>Mantenimiento<h3></font><center></caption>
                <tr title="Agregar nuevo colaborador" bgcolor="#666666" style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'Agregar\')"
        ">
                <td ><center>AGREGAR COLABORADOR</center> </td></tr>
                 <tr title="Dar de baja a colaborador" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'Eliminar\')"
        ">
                <td ><center>BAJA DE COLABORADOR
                </center> </td>
                </tr>
                 <tr title="Subir menús de la semana" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'Menu\')"
        ">
                <td ><center>MENÚ DE LA SEMANA
                </center> </td>
                </tr>
                <tr title="Agregar/editar categorias" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'EditCat\')"
        ">
                <td ><center>CATEGORIAS
                </center> </td>
                </tr>
                <tr title="Agregar/editar productos" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'EditProd\')"
        ">
                <td ><center>PRODUCTOS
                </center> </td>
                </tr>
				<tr title="Modificar horarios para realizar pedidos" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'EditHorario\')"
        ">
                <td ><center>HORARIO PEDIDOS
                </center> </td>
                </tr>';
                    echo'</table>
                <br>
                <font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'logout.php\'" >Cerrar Sesion</button></font>';
                    }else if($permiso=='externo_admin' || $permiso=='externo_personal')
                    {
                        if($reporte!=0 && $permiso=='externo_admin')
                        {
                            echo '
                    <table style="table-layout:fixed; font-size:12px" class=" table table- table-bordered" >
                    <caption><center><font color="white"><h3>Reporteria<h3></font><center></caption>
                    </tr>
                    <tr title="Reporte por producto vendido" bgcolor="#666666" style= "cursor:pointer; " onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'producto\')"
        ">
                    <td ><center>VENTAS POR PRODUCTO
                    </center> </td>
                    </tr>
                    <tr title="Tendencia de pedidos por día" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetReportes(\'tendencia\')"
        ">
                    <td ><center>TENDENCIA POR DIA
                    </center> </td>
                    </tr>';
                            echo'</table>';
                
                            echo '
                    <table style="table-layout:fixed; font-size:12px" class=" table table- table-bordered" >
                    <caption><center><font color="white"><h3>Mantenimiento<h3></font><center></caption>
                    <tr title="Subir menús de la semana" bgcolor="#666666" style= "cursor:pointer;" onMouseOver="this.style.background=\'#088A29\';" onMouseOut="this.style.background=\'\';" onClick="javascript:GetMantenimiento(\'Menu\')"
        ">
                    <td ><center>MENÚ DE LA SEMANA
                    </center> </td>
                    </tr>';
                            echo'</table>
                    <br>
                    <font color="black"><button type="button" class="btn btn-primary btn-xs" onclick="location.href = \'index.php\'" >Regresar</button></font>
                    <br><br>
                    <font color="black"><button type="button" class="btn btn-danger btn-xs" onclick="location.href = \'logout1.php\'" >Cerrar Sesion</button></font>
                    ';
                    
                        }else
                        {
                            header("Location: index.php");
                        }
                    }		
                }else
                    header("Location: pedidos1.php");
                ?>
                    </div>
                    <div id="Getreportes" class="col-md-10 col-lg-10" >
                    </div>
                </div>
                <div id="reportes" class="col-md-12 col-lg-12" >
                </div>
                <div id="confirmar" class="col-md-12 " >
                </div>
            </center>
			<div id="confirmar_registro" title="Confirmación de Registro"></div>
			<div id="campos_vacios" title="Campos Vacios"></div>
		</body>
	</html>
	<?
	}
?>