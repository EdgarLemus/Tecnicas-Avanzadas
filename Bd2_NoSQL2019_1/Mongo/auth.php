<?php
try {
    if( isset( $_GET["login"] ) ){
        $login = htmlspecialchars($_GET["login"]);
    } else {
        echo "<H3>Falta el argumento login</H3>";
        exit(0);
    }
    $manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

	// Se verifica que el usuario exista 
	$filter = ['$and' => [
		['dsusuario' => $login]
	]];
	$options = [];
	$var = false;
	$query = new MongoDB\Driver\Query($filter,$options);
	$result = $manager->executeQuery('redes_sociales2.usuarios',$query);
	 foreach($result as $document){
			//  echo "".$document->dsusuario; 
			 if($document->dsusuario == $login){
				 $var = true;
			 }
	 }
	if($var){
		header('Location: home.php');
	}else{
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