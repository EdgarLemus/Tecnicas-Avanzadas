<?php
date_default_timezone_set('America/Bogota');
$fecha = strval(date("Y/m/d H:i:s"));

include_once 'conexion.php';

$usuario	=  (integer)htmlspecialchars($_GET["usuario"]);




$time_start = microtime(true);
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.users_by_enter where ingreso_idusuario = $usuario order by ingreso_id desc limit 1;");
$resultado    = $session->execute($statement);
$time_end = microtime(true); // Tiempo Final
$time = $time_end - $time_start;

$time_start = microtime(true);
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.users where usuarios_id = $usuario;");
$resultadoUser    = $session->execute($statement);
$time_end = microtime(true); // Tiempo Final
$time = $time_end - $time_start;

$time_start = microtime(true);
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.groups_by_users where grupos_idusuario = $usuario;");
$resultadoUserGroups    = $session->execute($statement);
$time_end = microtime(true); // Tiempo Final
$time = $time_end - $time_start;

foreach ($resultadoUserGroups as $key) {
    
    $principal = $key['principal'];

    if($principal == 'Y')
    {
        $idGroup = $key['grupos_id'];
        $time_start = microtime(true);
        $statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.groups where grupos_id = $idGroup;");
        $resultadoGroups    = $session->execute($statement);
        $time_end = microtime(true); // Tiempo Final
        $time = $time_end - $time_start;

        foreach ($resultadoGroups as $key) {
    
            $nombreGrupo = $key['dsgrupo'];
         }
    }
    
 }

foreach ($resultadoUser as $key) {
    
    $nombreUsuario = $key['dsusuario'];
 }

foreach ($resultado as $key) {
    
    $ultimaConexion = $key['ingreso_fecha'];
 }


$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.commentary;");
 $resultadoCommentarys    = $session->execute($statement);



?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello <?php echo $nombreUsuario?></title>
    <link rel="stylesheet" type="text/css" href="css/modalWindow.css">
    <script type="text/javascript" src="javascript/javaScript.js">    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>

  <div class="container">
  <h6>Ultima conexion: <?php echo $ultimaConexion ?></h6>
  <div><a href="index.php">Cerrar Sesion</a></div>
  <div class="panel panel-default">  
  <div class="panel-heading">Eventos Sociales <a href = ""><img src="https://img.icons8.com/ios/30/000000/calendar.png"></a></div>  
    <div class="panel-body" id="Layer1" align="center" style = "overflow: scroll">
    <div align = "left"><img src="https://img.icons8.com/metro/26/000000/calendar.png"></div>  
</div>
  </div> 
</div>

<div class="container">
  <div class="panel panel-default">  
  <div class="panel-heading">Comentarios <a href="#openModal"><img src="https://img.icons8.com/wired/30/000000/multi-edit.png"></a></div>
    <div class="panel-body" id="Layer1" align="center" style = "overflow: scroll">   
    <?php foreach ($resultadoCommentarys as $key):?> 
 
 <?php if ($key['comentarios_idusuario'] == $usuario):?>
 <?php $idcomentario = $key['comentarios_id'];
  $statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.likes_by_idcomentario WHERE likes_idcomentario = $idcomentario;");
  $resultadoComentario    = $session->execute($statement);?>
  <?php foreach ($resultadoComentario as $keyComent):?>
 <div align = "left"><a href="http://localhost/tecnicas%20avanzadas/querys/likes.php?commentary=<?php echo $key['comentarios_id'] ?>&usuario=<?php echo $usuario?>"><img src="https://img.icons8.com/metro/15/000000/hearts.png"></a>(Nro me gusta <?php echo $keyComent['like'] ?>) <?php echo $key['dscomentario']?></div> 
 <?php endforeach?> 
 <?php endif?>
     
 <?php endforeach?>  
</div>
  </div>
</div>

<div id="openModal" class="modalDialog">
	<div>
		<a href="#close" title="Close" class="close">X</a>
		<span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-envelope"></i></span>
				  <textarea type="text" class="form-control" name="mensaje" placeholder="Mensaje" id="Mensaje" aria-describedby="sizing-addon1"></textarea>
          <br>
				<button class="btn btn-lg btn-primary btn-block btn-signin" id="IngresoLog" type="submit" onclick="sendMsm(<?php echo $usuario?>);">Entrar</button>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
  <footer>
  <div class="container">
  <div class="panel panel-default">  
    <div class="panel-body" id="Layer1" align="left">
    <div><h6>Usuario: <?php echo $nombreUsuario?> -  Grupo Principal: <?php echo $nombreGrupo?> - Otros Grupos: 
    <?php foreach ($resultadoUserGroups as $key ):?>
    <?php $principal = $key['principal']; ?>
    <?php if($principal == 'N'): ?>
    <?php $idGroup = $key['grupos_id'];
        $time_start = microtime(true);
        $statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.groups where grupos_id = $idGroup;");
        $resultadoGroups    = $session->execute($statement);
        $time_end = microtime(true); // Tiempo Final
        $time = $time_end - $time_start; ?>
    <?php  foreach ($resultadoGroups as $key): ?>
    <?php echo $key['dsgrupo']?>
    <?php if($key != null):?>
    <?php echo ","?>      
    <?php endif ?>
    <?php endforeach?>
    <?php endif ?>
    <?php endforeach ?>
    </h6></div>
</div>
  </div>
</div>
  </footer>
</html>

