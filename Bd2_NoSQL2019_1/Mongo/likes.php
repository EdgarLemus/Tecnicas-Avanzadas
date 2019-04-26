<?php

$idcomentario = htmlspecialchars($_GET["idcomentario"]);
$likes  = htmlspecialchars($_GET["likes"]);
$usuario = htmlspecialchars($_GET["usuario"]);
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(['idcomentario' => $idcomentario], ['$set' => ['likes' => $likes + 1]]);
$manager->executeBulkWrite('redes_sociales2.comentarios', $bulk);
header("location:home.php?login=$usuario");
