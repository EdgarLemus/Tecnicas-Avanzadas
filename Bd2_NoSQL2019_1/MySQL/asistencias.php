<?php

include_once 'conexion.php';

$idevento	=  htmlspecialchars($_GET["evento"]);
$usuario	=  htmlspecialchars($_GET["usuario"]);

$sql = "SELECT * FROM eventos WHERE idevento = $idevento";
$resulta = $conn->query($sql);

foreach($resulta as $datos)
{
   echo  $conAsistencia = $datos['asistencias'] +1;
}

$sql = "UPDATE eventos SET asistencias = $conAsistencia WHERE idevento = $idevento";
$resulta = $conn->query($sql);

$sql = "SELECT * FROM usuarios WHERE loguinUsuario = '$usuario'";
$resulta = $conn->query($sql);

foreach($resulta as $datos)
{
  $idusuario = $datos['idusuario'];
}


$sql = "INSERT INTO usuarios_has_eventos(usuarios_idusuario,eventos_idevento) VALUES ($idusuario,$idevento);";
$conn->query($sql);

header("location:http://localhost/Bd2_NoSQL2019_1/MySQL/home.php?filtro_fecha=-1&login=".$usuario."");


?>