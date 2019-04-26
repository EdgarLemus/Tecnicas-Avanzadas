<?php

include_once 'conexion.php';

$usuario	=  htmlspecialchars($_GET["login"]);
$codigo	=  htmlspecialchars($_GET["codigo"]);

date_default_timezone_set('America/Bogota');
//$fecha = strval(date("Y/m/d H:i:s"));

$date = date_create();
$fecha = date_format($date, 'Y-m-d H:i:s');



if($codigo == "2")
{
$statement = new Cassandra\SimpleStatement("UPDATE chatU.usuarios SET fechaIngreso = '$fecha' WHERE loguinUsuario = '$usuario';");
    $session->execute($statement);
header("location:http://localhost/Bd2_NoSQL2019_1/Cassandra/index.php");
}else{
    header("location:http://localhost/Bd2_NoSQL2019_1/Cassandra/home.php?filtro_fecha=-1&login=".$usuario."");
}

?>