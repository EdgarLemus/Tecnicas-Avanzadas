<?php
    
    $login = htmlspecialchars($_GET["login"]);
    $usuario = htmlspecialchars($_GET["usuario"]);
    $grupo = htmlspecialchars($_GET["grupo"]);
    $comentario = htmlspecialchars($_GET["comentario"]);

try {
    // date_default_timezone_set('America/Bogota');
    // $fecha = strval(date("Y/m/d H:i:s"));
    date_default_timezone_set('America/Bogota');
    $idComentario = (string)rand();
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite;
    $obj = ['usuarios_idusuario'=>$usuario,'grupos_idgrupo'=>$grupo,'dscomentario'=>$comentario,'fecha'=> date("Y-m-d H:i:s"),'likes'=>0,'idcomentario'=>$idComentario];
    $bulk->insert($obj);
    $manager->executeBulkWrite('redes_sociales2.comentarios',$bulk);
    header("location:home.php?login=$login");

} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n";
    echo "Falla al ejecutar:\n";
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";
    exit(0);
}
