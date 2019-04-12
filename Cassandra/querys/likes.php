<?php
include_once 'conexion.php';

$idcomentario	=  str_replace("'","",$_GET["commentary"]);
$usuario	=  htmlspecialchars($_GET["usuario"]);

$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.likes_by_idcomentario WHERE likes_idcomentario = $idcomentario;");
$resultado    = $session->execute($statement);

$statement = new Cassandra\SimpleStatement("SELECT count(*) as cantidad FROM chatU.likes_by_idcomentario WHERE likes_idcomentario = $idcomentario;");
$resultadoContador    = $session->execute($statement);

$statement = new Cassandra\SimpleStatement("SELECT count(*) as cantidad FROM chatU.likes_by_idcomentario;");
$resultadoTotal    = $session->execute($statement);

foreach ($resultadoContador as $key) {
    
    $totalRegistro = $key['cantidad'];
    
}

foreach ($resultadoContador as $key) {
    if($key['cantidad'] == 0)
    {
        $statement = new Cassandra\SimpleStatement("INSERT INTO chatU.likes_by_idcomentario (likes_idcomentario,likes_id,like) VALUES ($idcomentario,$resultadoTotal,0)");
        $resultadoInsert    = $session->execute($statement);
    }else{
        foreach ($resultado as $key) {
            $likes = intval($key['like']) + 1;
            $idlike = intval($key['likes_id']);
            $statementUpdate = new Cassandra\SimpleStatement("UPDATE chatU.likes_by_idcomentario SET like = $likes WHERE likes_idcomentario = $idcomentario and likes_id = $idlike;");
            $resultadoUpdate    = $session->execute($statementUpdate);
            header("location:http://localhost/tecnicas%20avanzadas/home.php?usuario=".$usuario."");
        }
    }
}
?>
