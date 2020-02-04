<?php
/*
session_start();
if ($_SESSION['autentificado'] != "si" )
{
   // no se ha entrado, redirigir a la página de login
   header ("Location: index.php");
   exit;
}

//require_once("Conexion.php");

/**
**  Variables generales
**/
/*$id_pais = $_SESSION['idpais'];
$id_modulo= 1;
$id_opcion_modulo = 0;
$id_usuario=$_SESSION['id_usuario'];
*/
// si se ha entrado en sesión, seguir aquí el código normal.

$file=(isset($_GET[ 'f']) ? $_GET['f']:$_POST['f']);
$extencion=explode('.',$file);
$extencion=array_pop($extencion);
$nombre_archivo='consulta'.date('YmdHis').".".$extencion;
if (is_readable('arch/tmp/'.$file) && is_file('arch/tmp/'.$file)) {
	//$fh=fopen('./arch/tmp/'.$file,'r');
	//$outstream = fopen("php://output", 'w');
	$contents="";	
	if (strcmp($extencion,'zip')  == 0) {
		$nombre_archivo=substr($file,strpos($file,'_')+1);
		// http headers for ZIP downloads
		header("Pragma: public");
		header("Expires: 0");
		header('Set-Cookie: fileDownload=true; path=/'); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".$nombre_archivo."\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize('./arch/tmp/'.$file));
	} else {
		// http headers for XLS downloads
		/*header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT"); 
		header('Set-Cookie: fileDownload=true; path=/'); 
		header ("Cache-Control: no-cache, must-revalidate");  
		header ("Pragma: no-cache");  
		//header("Content-type: application/vnd.ms-excel;  charset=Windows-1252");
		header('Content-Transfer-Encoding: binary');
		header('Content-Type: application/octet-stream; charset=Windows-1252');
		header ("Content-Description: PHP/INTERBASE Generated Data");
		header ("Content-Disposition: attachment; filename=\"$nombre_archivo\"" );		*/
		header('Content-Description: File Transfer');
		header('Content-Type: text/plain;  charset=Windows-1252');
		header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"' );
		header('Content-Transfer-Encoding: binary');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' .filesize('./arch/tmp/'.$file));
	}
	flush();
	ob_clean();
    ob_flush();
	readfile('./arch/tmp/'.$file);
	/*while (!feof($fh)) {
		$contents = fread($fh, 8192);
		fwrite($outstream,$contents);
		
	}*/
	//fclose($fh);
	//fclose($outstream);
	flush();
    ob_flush();
	exit;
} else {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
	echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}
?>