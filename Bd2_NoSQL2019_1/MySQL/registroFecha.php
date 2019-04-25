<?php

include_once 'conexion.php';

$usuario	=  htmlspecialchars($_GET["login"]);
$codigo	=  htmlspecialchars($_GET["codigo"]);

date_default_timezone_set('America/Bogota');
$fecha = strval(date("Y/m/d H:i:s"));

if($codigo == "2")
{
$sql = "UPDATE usuarios SET fechaIngreso = '$fecha' WHERE loguinUsuario = '$usuario'";
$conn->query($sql);
header("location:http://localhost/Bd2_NoSQL2019_1/MySQL/index.php");
}else{
    header("location:http://localhost/Bd2_NoSQL2019_1/MySQL/home.php?filtro_fecha=-1&login=".$usuario."");
}

?>