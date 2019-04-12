<?php
include_once 'conexion.php';

$usuario	=  (integer)htmlspecialchars($_GET["usuario"]);
$fecha	=  (string)htmlspecialchars($_GET["fecha"]);

echo $fecha;

$statement = new Cassandra\SimpleStatement("SELECT count(*) as cantidad FROM chatU.users_by_enter where ingreso_idusuario = $usuario;");
$resultadoIngreso    = $session->execute($statement);


foreach ($resultadoIngreso as $key) {
    $cantidad = $key['cantidad'] + 1;    
    echo $cantidad;
    }

    $statementInsert = new Cassandra\SimpleStatement("INSERT INTO chatU.users_by_enter (ingreso_idusuario,ingreso_id,ingreso_fecha) VALUES ($usuario,$cantidad,'$fecha');");
    $resultadoInsert   = $session->execute($statementInsert);
    header("location:http://localhost/tecnicas%20avanzadas/home.php?usuario=".$usuario."");   

?>