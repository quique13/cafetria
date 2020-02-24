<?php
session_start();  
  
if(!$_SESSION['userid'])  
{  
  
    header("Location: indexlogin.php");//redirect to login page to secure the welcome page without login access.  
}  else
{

include('../Conexion.php');
include('../funcionesCafe.php');


$tipo=$_POST['tipo'];
$nombre_cat=$_POST['nombre_cat'];
$nombre_pro=$_POST['nombre_pro'];
$precio_pro=$_POST['precio_pro'];
$id_cat=$_POST['id_cat'];

if($tipo=='PrevNueva')
{
	$tipo='Nueva';
	$cadena.='<div title="Agregar">
 	<form class="form-inline" method="POST" enctype="multipart/form-data" id="NuevaImagen"  >
 
   	<p>Nombre Categoria:<br> <input type="text"  id="nombre_cat" name="nombre_cat"> </p>
	<p>Imagen: <input type="file"  id="imagen_cat" name="imagen_cat" > </p>
	<input type="hidden" id="tipo" name="tipo" value="'.$tipo.'">
	<p><center><button type="button" onClick="javascript:SubirImagen()" class="btn btn-primary btn-sm" title="Agregar nueva categoria">agregar</button></center></p>
 
</form></div>';
}else if($tipo=='PrevNuevaPro')
{
	$tipo='NuevaPro';
	$cadena.='<div title="Agregar">
 	<form class="form-inline" method="POST" enctype="multipart/form-data" id="NuevaImagen"  >
 
   	 <p>Categoria<br> <select class="form-control md-2"  id="id_cat" name="id_cat" >
							 ';
 

 $SelectOr=("select * from categoria
 where estado='1'"); 
 $query=mysqli_query($SelectOr) or die(mysqli_error());
	$cadena.='<option value ="0"> Seleccione una opción</option>';
	while($row=mysqli_fetch_array($query))
 {
 $cadena.= '<option  value="'.$row['id_categoria'].'">'.$row['descripcion'].'</option>'; 
 }
$cadena.='</select>
							</p>
	<p>Nombre Producto:<br> <input type="text"  id="nombre_pro" name="nombre_pro"> </p>
	<p>precio:<br> <input type="number"  min="0"  id="precio_pro" name="precio_pro"> </p>
	<p>Imagen: <input type="file"  id="imagen_cat" name="imagen_cat" > </p>
	<p><input type="hidden"   id="tipo" name="tipo"value="'.$tipo.'"> </p>
	<p><center><button type="button" onClick="javascript:SubirImagen()" class="btn btn-primary btn-sm" title="Agregar nueva categoria">agregar</button></center></p>
 
</form></div>';
}
else if($tipo=='Nueva')
{
	if($_FILES["imagen_cat"]["name"]=="")
	{
		$cadena.="Agregue una imagen a la categoria";
	}
	else
	{
		if ($_FILES["imagen_cat"]["error"] > 0){
		$cadena.= "ha ocurrido un error";
		} else 
		{
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamano del archivo no exceda los 100kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 100000;
	
			if (in_array($_FILES['imagen_cat']['type'], $permitidos) && $_FILES['imagen_cat']['size'] <= $limite_kb * 1024)
			{
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				$ruta = "../rrhh/imagenes_cafe/" . $_FILES['imagen_cat']['name'];
				//comprobamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta))
				{
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = @move_uploaded_file($_FILES["imagen_cat"]["tmp_name"], $ruta);
					if ($resultado)
					{
						$nombre = $_FILES['imagen_cat']['name'];
						$insert = "insert into categoria (descripcion,imagen_cat,estado)
		values('$nombre_cat','$nombre','1') ";	
						$result = mysqli_query($insert) or die(mysqli_error());
						$cadena.= "Proceso satisfactorio";
					} else 
					{
						$cadena.= "ocurrio un error al mover el archivo.";
					}
				} else 
				{
					$cadena.= $_FILES['imagen_cat']['name'] . ", este archivo existe, por favor cambie el nombre de la imagen";
				}
			} else 
			{
				$cadena.= "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
		}
	
	}
}else if($tipo=='NuevaPro')
{
	if($_FILES["imagen_cat"]["name"]=="")
	{
		$cadena.="Agregue una imagen a la categoria";
	}
	else
	{
		if ($_FILES["imagen_cat"]["error"] > 0){
		$cadena.= "ha ocurrido un error";
		} else 
		{
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamano del archivo no exceda los 100kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 100000;
	
			if (in_array($_FILES['imagen_cat']['type'], $permitidos) && $_FILES['imagen_cat']['size'] <= $limite_kb * 1024)
			{
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				$ruta = "../rrhh/imagenes_cafe/" . $_FILES['imagen_cat']['name'];
				//comprobamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta))
				{
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = @move_uploaded_file($_FILES["imagen_cat"]["tmp_name"], $ruta);
					if ($resultado)
					{
						$nombre = $_FILES['imagen_cat']['name'];
						$insert = "insert into productos (descripcion,precio,imagen_producto,estado)
		values('$nombre_pro','$precio_pro','$nombre','1') ";	
						if($result = mysqli_query($insert) or die(mysqli_error()))
						{
							$select = "SELECT * FROM productos
							where estado='1'
							order by id_producto desc
							limit 1; ";	
							
							$resultse = mysqli_query($select) or die(mysqli_error());
							$row=mysqli_fetch_array($resultse);
							$id_prod=$row['id_producto'];
							
							$insert1 = "insert into categoria_producto (id_categoria,id_producto)
		values('$id_cat','$id_prod') ";
							$result = mysqli_query($insert1) or die(mysqli_error());
						};
						$cadena.= "Categoría modificado de mane satisfactoria";
					} else 
					{
						$cadena.= "ocurrio un error al mover el archivo.";
					}
				} else 
				{
					$cadena.= $_FILES['imagen_cat']['name'] . ", este archivo existe, por favor cambie el nombre de la imagen";
				}
			} else 
			{
				$cadena.= "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
		}
	
	}
}
else if($tipo=='PrevEliminar')
{
	$id_cat=$_POST['id'];
	$select="select * from categoria
	where id_categoria='$id_cat'
	and estado='1'";
	$result = mysqli_query($select) or die(mysqli_error());
	$row=mysqli_fetch_array($result);
	
	$cadena.='<div title="Eliminar">
 	<form class="form-inline">
 
   	<p>¿Esta seguro que desea eliminar <strong>'.$row['descripcion'].'</strong> de las categorias?</p>
	<input type="hidden" id="di_cat" name="id_cat" value="'.$id_cat.'">
	<input type="hidden" id="tipo_cat" name="tipo_cat" value="Eliminar">
	<p><center><button type="button" class="btn btn-danger btn-sm" title="Eliminar categoria" onClick="javascript:Mant_Menu(\'Eliminar\',\''.$id_cat.'\')">Eliminar</button></center></p>
 
</form></div>';
}
else if($tipo=='PrevEliminarPro')
{
	$id_prod=$_POST['id'];
	$select="select * from productos
	where id_producto='$id_prod'
	and estado='1'";
	$result = mysqli_query($select) or die(mysqli_error());
	$row=mysqli_fetch_array($result);
	
	$cadena.='<div title="Eliminar">
 	<form class="form-inline">
 
   	<p>¿Esta seguro que desea eliminar <strong>'.$row['descripcion'].'</strong> de los productos?</p>
	<input type="hidden" id="di_prod" name="id_prod" value="'.$id_prod.'">
	<p><center><button type="button" class="btn btn-danger btn-sm" title="Eliminar producto" onClick="javascript:Mant_Menu(\'EliminarPro\',\''.$id_prod.'\')">Eliminar</button></center></p>
 
</form></div>';
}
else if($tipo=='PrevEditar')
{
	$id_cat=$_POST['id'];
	$select="select * from categoria
	where id_categoria='$id_cat'
	and estado='1'";
	$result = mysqli_query($select) or die(mysqli_error());
	$row=mysqli_fetch_array($result);
	
$tipo='Editar';
	$cadena.='<div title="Editar">
 	<form class="form-inline" method="POST" enctype="multipart/form-data" id="NuevaImagen"  >
 
   	<p>Nombre Categoria:<br> <input type="text"  id="nombre_cat" name="nombre_cat" value="'.$row['descripcion'].'"> </p>
	<p>Imagen: <input type="file"  id="imagen_cat" name="imagen_cat" > </p>
	<input type="hidden" id="tipo" name="tipo" value="'.$tipo.'">
	<input type="hidden" id="id_cat" name="id_cat" value="'.$id_cat.'">
	<p><center><button type="button" onClick="javascript:SubirImagen()" class="btn btn-primary btn-sm" title="Agregar nueva categoria">agregar</button></center></p>
 
</form></div>';
}
else if($tipo=='PrevEditarPro')
{
	$id_prod=$_POST['id'];
	$select="SELECT prod.id_producto,cat.descripcion as categoria,prod.descripcion as producto,prod.imagen_producto,prod.precio FROM cafeteria.categoria_producto as cp
inner join categoria as cat
on cp.id_categoria=cat.id_categoria
inner join productos as prod
on cp.id_producto=prod.id_producto
where prod.estado='1'
and prod.id_producto='$id_prod'
order by cat.id_categoria,prod.descripcion;";
	$result = mysqli_query($select) or die(mysqli_error());
	$row=mysqli_fetch_array($result);
	
$tipo='Editar';
	$cadena.='<div title="Editar">
 	<form class="form-inline" method="POST" enctype="multipart/form-data" id="NuevaImagen"  >
 
   	<p>Nombre Categoria:<br> <input type="text"  id="nombre_cat" name="nombre_cat" value="'.$row['descripcion'].'"> </p>
	<p>Imagen: <input type="file"  id="imagen_cat" name="imagen_cat" > </p>
	<input type="hidden" id="tipo" name="tipo" value="'.$tipo.'">
	<input type="hidden" id="id_cat" name="id_cat" value="'.$id_cat.'">
	<p><center><button type="button" onClick="javascript:SubirImagen()" class="btn btn-primary btn-sm" title="Agregar nueva categoria">agregar</button></center></p>
 
</form></div>';
}
else if($tipo=='Editar')
{
	if($_FILES["imagen_cat"]["name"]=="")
	{
		$update = "update categoria set descripcion='$nombre_cat'
		where id_categoria='$id_cat' ";	
		$result = mysqli_query($update) or die(mysqli_error());
		$cadena.="Categoria editada de manera satisfactoria";
	}
	else
	{
		if ($_FILES["imagen_cat"]["error"] > 0){
		$cadena.= "ha ocurrido un error";
		} else 
		{
			//ahora vamos a verificar si el tipo de archivo es un tipo de imagen permitido.
			//y que el tamano del archivo no exceda los 100kb
			$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
			$limite_kb = 100000;
	
			if (in_array($_FILES['imagen_cat']['type'], $permitidos) && $_FILES['imagen_cat']['size'] <= $limite_kb * 1024)
			{
				//esta es la ruta donde copiaremos la imagen
				//recuerden que deben crear un directorio con este mismo nombre
				//en el mismo lugar donde se encuentra el archivo subir.php
				$ruta = "../rrhh/imagenes_cafe/" . $_FILES['imagen_cat']['name'];
				//comprobamos si este archivo existe para no volverlo a copiar.
				//pero si quieren pueden obviar esto si no es necesario.
				//o pueden darle otro nombre para que no sobreescriba el actual.
				if (!file_exists($ruta))
				{
					//aqui movemos el archivo desde la ruta temporal a nuestra ruta
					//usamos la variable $resultado para almacenar el resultado del proceso de mover el archivo
					//almacenara true o false
					$resultado = @move_uploaded_file($_FILES["imagen_cat"]["tmp_name"], $ruta);
					if ($resultado)
					{
						$nombre = $_FILES['imagen_cat']['name'];
						$update = "update categoria set descripcion='$nombre_cat',imagen_cat='$nombre' 
						where id_categoria='$id_cat'";	
						$result = mysqli_query($update) or die(mysqli_error());
						$cadena.= "Categoría modificado de manera satisfactoria";
					} else 
					{
						$cadena.= "ocurrio un error al mover el archivo.";
					}
				} else 
				{
					$cadena.= $_FILES['imagen_cat']['name'] . ", este archivo existe";
				}
			} else 
			{
				$cadena.= "archivo no permitido, es tipo de archivo prohibido o excede el tamano de $limite_kb Kilobytes";
			}
		}
	
	}
}
else if($tipo=='Eliminar')
{
	$id_cat=$_POST['id'];
	$update="update categoria SET estado='0'
	where id_categoria='$id_cat'";
	if($result = mysqli_query($update) or die(mysqli_error()));
	
	{
		$cadena.='<div title="Eliminar">
 	<form class="form-inline">
 
   	<p>Categoria ha sido eliminada...</p>
	
 
</form></div>';
	}
	
	
}
else if($tipo=='EliminarPro')
{
	$id_prod=$_POST['id'];
	$update="update productos SET estado='0'
	where id_producto='$id_prod'";
	if($result = mysqli_query($update) or die(mysqli_error()));
	
	{
		$cadena.='<div title="Eliminar">
 	<form class="form-inline">
 
   	<p>Producto ha sido eliminado...</p>
	
 
</form></div>';
	}
	
	
}
$array=array('result'=>$cadena);
echo json_encode($array);
}
?>