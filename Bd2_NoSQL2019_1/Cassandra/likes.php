<?php
include_once 'conexion.php';

$idcomentario	=  htmlspecialchars($_GET["commentary"]);
$usuario	=  htmlspecialchars($_GET["usuario"]);
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.comentarios where idcomentario = $idcomentario;");
$resulta    = $session->execute($statement);

foreach($resulta as $datos)
{
   echo  $conLike = $datos['likes'] +1;
}


$statement = new Cassandra\SimpleStatement("UPDATE chatU.comentarios SET likes = $conLike WHERE idcomentario = $idcomentario;");
$session->execute($statement);

//$sql = "UPDATE comentarios SET likes = $conLike WHERE idcomentario = $idcomentario";
//$resulta = $conn->query($sql);

header("location:http://localhost/Bd2_NoSQL2019_1/Cassandra/home.php?filtro_fecha=-1&login=".$usuario."");
?>
