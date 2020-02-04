<?php

session_start();
include("Conexion.php");

function verificar_login($user,$password,&$result)
    {
        $sql = "SELECT * FROM usuario_reporte WHERE usuario='$user' and password='$password'";
        $rec = mysql_query($sql);
        $count = 0;
        while($row = mysql_fetch_object($rec))
        {
            $count++;
            $result = $row;
        }
        if($count == 1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

if(!isset($_SESSION['userid']))
{
    if(isset($_POST['login']))
    {
        if(verificar_login($_POST['user'],$_POST['password'],$result) == 1)
        {
            $_SESSION['userid'] = $result->idusuario;
            
			header('location: indexconsulta.php'); 
			
			
        }
        else
        {
         	$descrip = "Su Usuario es Incorrecto, Intente Nuevamente.  ";
			//echo '<div class="error">Su usuario es incorrecto, intente nuevamente.</div>';
        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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


<table width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="top.png" width="900" height="150" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle">
      <form action="" method="post" class="login">
        <br />
        <br />
        <br />
        <br />
        <br />
        <div align="center">
        <h1>INGRESE SU USUARIO</h1>
        <br />
        <br />
        <div align="center">
        <div>
          <label>Username </label>
          <input name="user" type="text" />
        </div>
        <br />
        <div>
          <label>Password</label>
          <input name="password" type="password" />
        </div>
        <br />
        <br />
        <div>
          <input name="login" type="submit" value="login" />
        </div>
        <br />
        <br />
        <br />
        <?php echo "".$descrip;?>
      </form>
      <?php
} else {
    echo "Su usuario ingreso correctamente";
    echo '<a href="indexconsulta.php">Logout</a>';
}

?></td>
  </tr>
</table>
</body>

</center>

</html>
