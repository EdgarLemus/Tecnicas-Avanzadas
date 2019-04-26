<?php
if (isset($_GET["login"])) {
    $login = htmlspecialchars($_GET["login"]);
} else {
    echo "<H3>Falta el argumento login</H3>";
    exit(0);
}
try {
    // date_default_timezone_set('America/Bogota');
    // $fecha = strval(date("Y/m/d H:i:s"));
    date_default_timezone_set('America/Bogota');
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk ->update(	['dsusuario' => $login],['$set' =>['fechaIngreso'=> date("Y-m-d H:i:s")]]);
    $manager->executeBulkWrite('redes_sociales2.usuarios',$bulk);

} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n";
    echo "Falla al ejecutar:\n";
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";
    exit(0);
}
