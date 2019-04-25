<?php if (!extension_loaded("cassandra")) die("Error: la extensión de cassandra es requerida."); ?>
<?php
/*
	Creado por Sergio Alvarez
	Version 1.0 - 2019/03/30
	Tecnicas avanzadas de base de datos - UDEM
	
	Notas: 
	* En Archivo donde no hay que contabilizar los tiempos
*/

/*Se recuperan los argumentos*/
$tiempo				= htmlspecialchars($_GET["tiempo"]);
$usuario_id			= htmlspecialchars($_GET["usuario_id"]);
$usuario_login		= htmlspecialchars($_GET["usuario_login"]);
$usuario_nombre		= htmlspecialchars($_GET["usuario_nombre"]);
$categoria_id		= htmlspecialchars($_GET["categoria_id"]);
$categoria_nombre	= htmlspecialchars($_GET["categoria_nombre"]);
$dspublicacion		= htmlspecialchars($_GET["dspublicacion"]);

date_default_timezone_set('America/Bogota');
$fecha = strval(date("Y/m/d H:i:s"));
					
/*Validación de argumentos - */
/*
echo 'tiempo='. 	$tiempo .'</br>';
echo 'usuario_id='. 		$usuario_id .'</br>';
echo 'usuario_login='. 		$usuario_login .'</br>';
echo 'usuario_nombre='. 	$usuario_nombre.'</br>';
echo 'categoria_id='. 	$categoria_id.'</br>';
echo 'categoria_nombre='. 	$categoria_nombre.'</br>';
echo 'dspublicacion='. 	$dspublicacion.'</br>';
*/


// Si es cassandra
//$tiempo = $tiempo*1000;


/* ==--> Aqui ustede debe hacer la conexion a la base de datos*/

// Documentación en https://datastax.github.io/php-driver/features
$cluster   = Cassandra::cluster()
               ->withContactPoints('127.0.0.1')
               ->build();
// Seleccionar la base de datos
$session   = $cluster->connect("system");


// Documentación en https://datastax.github.io/php-driver/features/#executing-queries
// Documentación en https://datastax.github.io/php-driver/features/simple_statements/
/* ==--> Se arma el Batch para insertar en tablas. Note que hay dos ejemplos de insert*/
$statement = new Cassandra\SimpleStatement("INSERT INTO redes_sociales.usuario (usuarios_id,dsusuario,loguin_usuario,registro) VALUES ($usuario_id,$usuario_nombre,$usuario_login,$fecha)");
$resultadoInsert    = $session->execute($statement);
/*
$batch = new Cassandra\BatchStatement(Cassandra::BATCH_UNLOGGED);
	// Ejemplo de tabla Qn con las columnas x,y,z,w. Y se usan las variables $v_x, $v_y, $v_z, $v_w. Note que las columnas x, w son tipo texto
	$batch -> add(
		"INSERT INTO Qn(x,y,z,w) VALUES ('${v_x}', ${v_y}, ${v_z}, '${v_w}')"
	);
	// Ejemplo de tabla Qm con las columnas a,b,x. Y se usan las variables $v_a, $v_b, $v_z, $v_x. Note que la columna a es tipo texto
	$batch -> add(
		"INSERT INTO Qm(a,b,x) VALUES ('${v_a}', ${v_b}, ${v_x})"
	);
$session->execute($batch);
*/

/* ==--> Se arma el Batch para actualizar en tablas*/
/*
$batchCounter = new Cassandra\BatchStatement(Cassandra::BATCH_COUNTER);
	// Ejemplo de actualizar la tabla Qt se incrementa la columna contador
	$batchCounter -> add(
		"UPDATE Qt SET contador = contador + 1 WHERE x='${v_x}' AND y = ${v_y}"
	);
$session->execute($batchCounter);
*/

/* ==--> Cerrar Conexion*/
/*$session->close();*/

/*retornar el texto con resultado*/
echo "OK";
?>