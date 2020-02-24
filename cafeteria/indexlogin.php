<?php
// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include( 'Conexion.php' );
include( 'session.php' );
//include( 'Conexion_sac.php' );
//$precio = 'precio_';
$consulta_cat = mysqli_query( $conexion,'select * from categoria where estado = 1 order by id_categoria' );
$LIBS_DIR = './libs/';
$descrip="";

?>  
<html>
<head>
<meta http-equiv = 'Content-Type' content = 'text/html; charset=utf-8' />
<link rel = 'stylesheet' href = "<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/themes/redmond2/jquery-ui.css" />
<link rel = 'stylesheet' href = './bootstrap/css/bootstrap.min.css'>
<script src = "<?=$LIBS_DIR;?>jq/jquery-1.10.2.js"></script>
<script src = "<?=$LIBS_DIR;?>jq/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
<script src = "<?=$LIBS_DIR;?>jq/funciones.js"></script>
<title>Login</title>

<?php

function encrypt_password( $pass ) {
    $val = 0;

    for ( $i = 0; $i< strlen( $pass );
    $i++ ) {
        $val += ord( substr( $pass, $i, 1 ) );
    }
    return $val;
}

function verificar_login( $user, $password, &$result,$conexion ) {
    $encpassword = encrypt_password( $password );
    $sql = "SELECT * FROM usuario_reporte WHERE usuario='$user' and password='$password'";
    $rec = mysqli_query($conexion, $sql );
    $count = 0;
    while( $row = mysqli_fetch_array($rec ) ) {
        $count++;
        $result = $row;
    }
    if ( $count == 1 ) {
        return 1;
    } else {
        return 0;
    }
}

if ( !isset( $_SESSION['userid'] ) ) {
    if ( isset( $_POST['login'] ) ) {
        if ( verificar_login( $_POST['user'], $_POST['password'], $result,$conexion ) == 1 ) {
            session_start();

            $_SESSION['userid'] = $_POST['user'];

            header( 'location: indexconsulta.php' );

        } else {
            $descrip = 'Su Usuario es Incorrecto, Intente Nuevamente.  ';
            //echo '<div class="error">Su usuario es incorrecto, intente nuevamente.</div>';
        }
    }
    ?>

    <style type = 'text/css'>
    BODY {
        background: #0066CC;

        background-image:url( imagen.jpg );
        background-attachment: fixed;
        background-repeat: repeat;

        color: #FFFFFF;
        //color a las letras blanco

    }

    </style>
    </head>

    <center>

    <body>

    <table width = '900' border = '0' cellspacing = '0' cellpadding = '0'>
    <tr>
    <td><img src = 'top.png' width = '900' height = '150' /></td>
    </tr>
    <tr>
    <td align = 'center' valign = 'middle'>
    <form action = '' method = 'post' class = 'login'>
    <br />
    <br />
    <br />
    <div align = 'center'>
    <h1>INGRESE SU USUARIO</h1>
    <br />
    <br />
    </div>
    <div align = 'center'>
    <div>
    <label>Username </label>
    <font color = 'black'><input name = 'user' type = 'text' /></font>
    </div>
    <br />
    <div>
    <label>Password</label>
    <font color = 'black'><input name = 'password' type = 'password' /></font>
    </div>
    <br />
    <div>
    <font color = 'black'><button type = 'submit' class = 'btn btn-primary btn-md' value = 'login' name = 'login' >Ingresar</button></font>
    </div>
    </div>
    <br />
    <br />
    <br />
    <?php echo ''.$descrip;
    ?>
    </form>
    <?php
} else {
    header ( 'Location: indexconsulta.php' );
}

?></td>
</tr>
</table>
</body>
</center>
</html>