<?php

include_once 'conexion.php';

$idevento	=  htmlspecialchars($_GET["evento"]);
$usuario	=  htmlspecialchars($_GET["usuario"]);


$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.eventos where idevento = $idevento;");
$resulta    = $session->execute($statement);

foreach($resulta as $datos)
{
   echo  $conAsistencia = $datos['asistencias'] +1;
}

$statement = new Cassandra\SimpleStatement("UPDATE chatU.eventos SET asistencias = $conAsistencia WHERE idevento = $idevento;");
$session->execute($statement);

$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios WHERE loguinUsuario = '$usuario';");
$resultado    = $session->execute($statement);

foreach($resultado as $datos)
{
  $idusuario = $datos['idusuario'];
}

$statement = new Cassandra\SimpleStatement("INSERT INTO chatU.usuarios_has_eventos(usuarios_idusuario,eventos_idevento) VALUES ($idusuario,$idevento);");
$session->execute($statement);


header("location:http://localhost/Bd2_NoSQL2019_1/Cassandra/home.php?filtro_fecha=-1&login=".$usuario."");


?>