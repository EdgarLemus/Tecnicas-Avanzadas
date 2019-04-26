<?PHP
/*Se recuperan los argumentos*/
// Usuario que se logeo
if (isset($_GET["login"])) {
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
	$query = new MongoDB\Driver\Query($filter, $options);
	$result = $manager->executeQuery('redes_sociales2.usuarios', $query);
	foreach ($result as $document) {
		//  echo "".$document->dsusuario; 
		if ($document->dsusuario == $login) {
			$var = true;
			$usuario = $document;
		}
	};
	// Se obtiene el grupo principal del usuario para traer la lista de eventos
	$varMain = 0;
	$varOthers = array('test');
	$filterMain = ['$and' => [['usuarios_idusuarios' => $usuario->idusuario], ['principal' => 'Y']]];
	$queryMain = new MongoDB\Driver\Query($filterMain, $options);
	$resultMain = $manager->executeQuery('redes_sociales2.grupos_has_usuarios', $queryMain);

	foreach ($resultMain as $documentMain) {
		if ($documentMain->principal == 'Y') {
			$varMain = $documentMain->grupos_idgrupo;
		} else {
			array_push($varOthers, $documentMain->grupos_idgrupo);
		}
	}

	if (!$var) {
		header('Location: index.php');
	}
	if ($_POST) {
		$mensaje = $_POST['mensaje'];
		header("location:comentario.php?usuario=$usuario->idusuario&grupo=$varMain&comentario=$mensaje&login=$login");
		// header("location:comentario.php?idgrupo=$grupoPrincipal&mensaje=$mensaje&idusuario=$idusuario&fecha=$fecha");
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
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<p>Hello <?php echo $usuario->dsusuario ?></p>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="javascript/javaScript.js"> </script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<!-- <title>Hello </title> -->
	</head>
</head>

<body>
	<div class="container">
		<h6> Ultima conexion: <?php echo $usuario->fechaIngreso ?></h6>
		<div><a href="http://localhost/tecnicas-avanzadas/Bd2_NoSQL2019_1/Mongo/registroFecha.php?login=<?php echo $usuario->idusuario ?>&codigo=2">Cerrar Sesion</a></div>
		<div class="panel panel-default">
			<div class="panel-heading"> Eventos Sociales <a href="#openModal"><img src="https://img.icons8.com/ios/30/000000/calendar.png"></a></div>
			<div class="panel-body" id="Layer1" align-content justify-center style="overflow: scroll">
				<?php
				$filterEvents = ['$and' => [['grupos_idgrupo' => $varMain]]];
				$queryEvents = new MongoDB\Driver\Query($filterEvents, $options);
				$resultEvents = $manager->executeQuery('redes_sociales2.grupos_has_eventos', $queryEvents);
				foreach ($resultEvents as $documentEvent) {
					?>
					<div align-left> <?php

										$filterDetailEvent = ['$and' => [['idevento' => $documentEvent->eventos_idevento]]];
										$queryDetailEvent = new MongoDB\Driver\Query($filterDetailEvent, $options);
										$resultDetailEvent = $manager->executeQuery('redes_sociales2.eventos', $queryDetailEvent);
										foreach ($resultDetailEvent as $documentDetailEvent) {
											?>
							<a href="http://localhost/tecnicas-avanzadas/Bd2_NoSQL2019_1/Mongo/asistencias.php?idevento=<?php echo $documentEvent->eventos_idevento; ?>&usuario=<?php echo $login ?>&idusuario=<?php echo $usuario->idusuario ?>&asistencias=<?php echo $documentDetailEvent->asistencias ?>"><img src="https://img.icons8.com/metro/15/000000/calendar.png"></a>
							<?php echo $documentEvent->eventos_idevento ?> Asistencia (<?php echo $documentDetailEvent->asistencias ?>) <?php echo $documentDetailEvent->dsevento ?>
						<?php } ?>

					<?php } ?></div>
			</div>
		</div>
	</div>
	<br>
	<div>
		<div class="panel panel-default">
			<div class="panel-heading"> Comentarios <a><img src="https://img.icons8.com/wired/30/000000/multi-edit.png"></a></div>
			<div class="panel-body" id='Layer1' align-center style="overflow:auto">
				<?php
				$filterComments = ['$and' => [['usuarios_idusuario' => $usuario->idusuario]]];
				$queryComments  = new MongoDB\Driver\Query($filterComments, $options);
				$resultComments = $manager->executeQuery('redes_sociales2.comentarios', $queryComments);
				foreach ($resultComments as $documentComments) {
					?>
					<div align-left>
						<a href="http://localhost/tecnicas-avanzadas/Bd2_NoSQL2019_1/Mongo/likes.php?idcomentario=<?php echo $documentComments->idcomentario; ?>&usuario=<?php echo $usuario->dsusuario ?>&likes=<?php echo $documentComments->likes ?>"><img src="https://img.icons8.com/metro/15/000000/hearts.png"></a>
						(Nro me gusta <?php echo $documentComments->likes ?>)
						<?php echo $documentComments->dscomentario ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<br>
	<div>
		<div class="panel panel-default">
			<form method="POST">
				<span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-envelope"></i></span>
				<textarea type="text" class="form-control" name="mensaje" placeholder="Mensaje" id="Mensaje" aria-describedby="sizing-addon1"></textarea>
				<br>
				<button class="btn btn-lg btn-primary btn-block btn-signin" id="IngresoLog" type="submit" onclick="">Entrar</button>
			</form>
		</div>
	</div>

	<div id="openModal" class="modalDialog">
		<div>
			<a href="#close" title="Close" class="close">X</a>
			<Table>
				<tr>
					<td>Evento</td>
					<td>
						<h6> - </h6>
					</td>
					<td>Fecha</td>
				</tr>
				<?php
				$filterUserEvents = ['$and' => [['usuarios_idusuario' => $usuario->idusuario]]];
				$queryUserEvents  = new MongoDB\Driver\Query($filterUserEvents, $options);
				$resultUserEvents = $manager->executeQuery('redes_sociales2.usuarios_has_eventos', $queryUserEvents);
				foreach ($resultUserEvents as $docUserEvents) {
					?>
					<?php
					$filter2 = ['$and' => [['idevento' => $docUserEvents->eventos_idevento]]];
					$query2 = new MongoDB\Driver\Query($filter2, $options);
					$result2 = $manager->executeQuery('redes_sociales2.eventos', $query2);
					foreach ($result2 as $doc2) {
						?>
						<div>
							<?php echo $doc2->dsevento ?> <?php echo $doc2->fechaEvento ?>
						</div>
					<?php } ?>
				<?php } ?>
			</Table>
		</div>
	</div>
	</div>

</body>
<footer>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body" id="Layer1" align="left">
				<div>
					<h6>Usuario: <?php echo $usuario->dsusuario ?> - Grupo Principal: <?php
																						echo $varMain
																						?> - Otros Grupos: <?php
																											$filterMain2 = ['$and' => [['usuarios_idusuarios' => $usuario->idusuario]]];
																											$queryMain2 = new MongoDB\Driver\Query($filterMain2, $options);
																											$resultMain2 = $manager->executeQuery('redes_sociales2.grupos_has_usuarios', $queryMain2);
																											foreach ($resultMain2 as $doc3) {
																												if ($doc3->principal == 'N') {
																													echo $doc3->grupos_idgrupo;
																												}
																											}
																											?>
					</h6>
				</div>
			</div>
		</div>
	</div>
</footer>

</html>