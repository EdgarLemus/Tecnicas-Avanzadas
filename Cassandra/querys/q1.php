<?php
date_default_timezone_set('America/Bogota');
$fecha = strval(date("Y/m/d H:i:s"));

include_once 'conexion.php';

$usuario	=  htmlspecialchars($_GET["usuario"]);

$time_start = microtime(true);
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.users where usuarios_id = $usuario;");
$resultado    = $session->execute($statement);
$time_end = microtime(true); // Tiempo Final
$time = $time_end - $time_start;

foreach ($resultado as $key) {
   $user = $key['usuarios_id'];
   if($user == $usuario)
    {
        header("location:http://localhost/tecnicas%20avanzadas/registro.php?usuario=".$usuario."&fecha=".$fecha."");
    }else{
        header("location:http://localhost/tecnicas%20avanzadas/index.php?validacion=false");
    }
}
?>