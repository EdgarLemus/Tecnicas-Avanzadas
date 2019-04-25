<?php
include_once 'conexion.php';

$idcomentario	=  htmlspecialchars($_GET["commentary"]);
$usuario	=  htmlspecialchars($_GET["usuario"]);

$sql = "SELECT * FROM comentarios WHERE idcomentario = $idcomentario";
$resulta = $conn->query($sql);

foreach($resulta as $datos)
{
   echo  $conLike = $datos['likes'] +1;
}

$sql = "UPDATE comentarios SET likes = $conLike WHERE idcomentario = $idcomentario";
$resulta = $conn->query($sql);

header("location:http://localhost/Bd2_NoSQL2019_1/MySQL/home.php?filtro_fecha=-1&login=".$usuario."");
?>
