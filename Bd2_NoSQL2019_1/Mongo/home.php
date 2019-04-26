<?PHP
/*Se recuperan los argumentos*/
// Usuario que se logeo
if( isset( $_GET["login"] ) ){
	$login = htmlspecialchars($_GET["login"]);
} else {
	echo "<H3>Falta el argumento login</H3>";
	exit(0);
}
try {
	$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	// Se verifica que el usuario exista 
	$filter = ['$and' => [
		['dsusuario' => $login]
	]];
	$options = [];
	$var = false;
	$usuario = [];
	$query = new MongoDB\Driver\Query($filter,$options);
	$result = $manager->executeQuery('redes_sociales2.usuarios',$query);
	 foreach($result as $document){
			//  echo "".$document->dsusuario; 
			 if($document->dsusuario == $login){
				 $var = true;
				 $usuario = $document;
			 }
	 }
  
	if(!$var){
		header('Location: index.php');
	}
} catch (MongoDB\Driver\Exception\Exception $e) {
    $filename = basename(__FILE__);
    echo "El script $filename tine un error.\n"; 
    echo "Falla al ejecutar:\n";    
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";     
	exit(0);	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- <title>Hello </title> -->
		<h1> Hola <?php echo $usuario->dsusuario?></h1>
    </head>
</head>

<body>
        <div class="container">
			  <h6> Ultima conexion: <?php echo $usuario->fechaIngreso ?></h6>
			  <div><a href="http://localhost/tecnicas-avanzadas/Bd2_NoSQL2019_1/Mongo/registroFecha.php?login=<?php echo $usuario->dsusuario?>&codigo=2">Cerrar Sesion</a></div>

        </div> 
</body>

</html>

