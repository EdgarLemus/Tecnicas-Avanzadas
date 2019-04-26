<?php if (!extension_loaded("cassandra")) die("Error: la extensión de cassandra es requerida."); ?>
<?php
$cluster   = Cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
$session   = $cluster->connect("system");
?>

