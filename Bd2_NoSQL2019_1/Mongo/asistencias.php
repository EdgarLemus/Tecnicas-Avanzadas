<?php
$idevento = htmlspecialchars($_GET["idevento"]);
$asistencias  = htmlspecialchars($_GET["asistencias"]);
$usuario = htmlspecialchars($_GET["usuario"]);
$idusuario = htmlspecialchars($_GET["idusuario"]);
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
//  Aumentar contador
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(['idevento' => $idevento], ['$set' => ['asistencias' => $asistencias + 1]]);
$manager->executeBulkWrite('redes_sociales2.eventos', $bulk);

//  Guardar registro en usuario has events
$bulk2 =  new MongoDB\Driver\BulkWrite;
$obj = ['usuarios_idusuario'=>$idusuario,'eventos_idevento'=>$idevento];
$bulk2->insert($obj);
$manager->executeBulkWrite('redes_sociales2.usuarios_has_eventos',$bulk2);
header("location:home.php?login=$usuario");

?>