<?php
include_once 'conexion.php';

echo $usuario = $_GET['idusuario'];
echo $grupo = $_GET['idgrupo'];
echo $fecha = $_GET['fecha'];
echo $comentario = $_GET['mensaje'];

if($comentario != "")
{
    $sql = "INSERT INTO comentarios (usuarios_idusuario,grupos_idgrupo,dscomentario,likes,fecha) VALUES ($usuario,$grupo,'$comentario',0,'$fecha')";
    $conn->query($sql);   
}
$sql = "SELECT * FROM usuarios WHERE idusuario = '$usuario'";
    $resulta = $conn->query($sql);
    
    foreach($resulta as $datos)
    {
      $idusuario = $datos['loguinUsuario'];
    }

header("location:http://localhost/Bd2_NoSQL2019_1/MySQL/home.php?filtro_fecha=-1&login=".$idusuario."");
?>