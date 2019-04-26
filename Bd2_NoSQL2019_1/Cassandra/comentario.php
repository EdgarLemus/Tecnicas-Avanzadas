<?php
include_once 'conexion.php';

echo $usuario = $_GET['idusuario'];
echo $grupo = $_GET['idgrupo'];
echo $fecha = $_GET['fecha'];
echo $comentario = $_GET['mensaje'];
echo $timeStamp = strtotime($fecha);
echo "loguin";
$statement = new Cassandra\SimpleStatement("SELECT count(*) as cuenta FROM chatU.comentarios;");
$resultado    = $session->execute($statement);
    
    foreach($resultado as $datos)
    {
      $cuenta = $datos['cuenta'] + 1;
    }
if($comentario != "")
{
    $statement = new Cassandra\SimpleStatement("INSERT INTO chatU.comentarios (idcomentario,usuarios_idusuario,grupos_idgrupo,dscomentario,likes,fecha) VALUES ($cuenta,$usuario,$grupo,'$comentario',0,'$timeStamp');");
    $session->execute($statement);
}
    $statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios;");
    $resultado    = $session->execute($statement);
        
        foreach($resultado as $datos)
        {
         if($usuario == $datos['idusuario']){
          $idusuario = $datos['loguinusuario'];
         }
        }

header("location:http://localhost/Bd2_NoSQL2019_1/Cassandra/home.php?filtro_fecha=-1&login=".$idusuario."");
?>