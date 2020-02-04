<?php
session_start();
$user=$_SESSION['userid'];
echo $user.'<br>';
echo date("Y-m-d H:i:s").'<br>';
?>