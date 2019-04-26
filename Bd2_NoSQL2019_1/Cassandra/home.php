<?php
include_once 'conexion.php';

date_default_timezone_set('America/Bogota');
$fecha = strval(date("Y/m/d H:i:s"));
$date = date_create();

$usuario	= htmlspecialchars($_GET["login"]);

$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios WHERE loguinUsuario = '$usuario';");
$resultado    = $session->execute($statement);

foreach($resultado as $datos)
{
  $idusuario = $datos['idusuario'];
   $dsusuario = $datos['dsusuario'];
    $fechaIngreso = $datos['fechaingreso'];
}


$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios_has_grupos WHERE usuarios_idusuario = $idusuario");
$resultado    = $session->execute($statement);
foreach($resultado as $datos)
{
  $gruposUsuarios = $datos['principal'];
 if($gruposUsuarios == 'Y')
 {
   $grupoPrincipal = $datos['grupos_idgrupo'];
 }
}
$statement = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios_has_grupos WHERE usuarios_idusuario = $idusuario");
$resultado    = $session->execute($statement);

if($_POST)
{
 $mensaje = $_POST['mensaje'];
 header("location:comentario.php?idgrupo=$grupoPrincipal&mensaje=$mensaje&idusuario=$idusuario&fecha=$fecha");
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello <?php echo $dsusuario?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="javascript/javaScript.js">    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  </head>
  <body>

  <div class="container">
  <h6>Ultima conexion: <?php echo $fechaIngreso?></h6>
  <div><a href="http://localhost/Bd2_NoSQL2019_1/Cassandra/registroFecha.php?login=<?php echo $usuario?>&codigo=2">Cerrar Sesion</a></div>
  <div class="panel panel-default">  
  <div class="panel-heading">Eventos Sociales <a href = "#openModal"><img src="https://img.icons8.com/ios/30/000000/calendar.png"></a></div>  
    <div class="panel-body" id="Layer1" align="center" style = "overflow: scroll">
    <?php $sqlite = new Cassandra\SimpleStatement("SELECT * FROM chatU.grupos_has_eventos WHERE grupos_idgrupo = $grupoPrincipal");
          $resultados = $session->execute($sqlite);
           ?>
    <?php foreach($resultados as $dato):?>
    <?php 
    $idevento = $dato['eventos_idevento'];
    $sqlite = new Cassandra\SimpleStatement("SELECT * FROM chatU.eventos WHERE idevento = $idevento");
    $resul = $session->execute($sqlite);
    foreach($resul as $dataStudio):      
    ?>
    <div align = "left"><a href="http://localhost/Bd2_NoSQL2019_1/Cassandra/asistencias.php?evento=<?php echo $dataStudio['idevento']?>&usuario=<?php echo $usuario?>"><img src="https://img.icons8.com/metro/15/000000/calendar.png"></a> (Asistencia: <?php echo $dataStudio['asistencias'];?>) <?php echo $dataStudio['dsevento'];?> </div> 
    <?php endforeach ?>
    <?php endforeach ?>
    
    
     
</div>
  </div> 
</div>



<div class="container">
  <div class="panel panel-default">  
  <div class="panel-heading">Comentarios <a><img src="https://img.icons8.com/wired/30/000000/multi-edit.png"></a></div>
    <div class="panel-body" id="Layer1" align="center" style = "overflow: auto">   
    <?php foreach ($resultado as $datos):?>  
 <?php 
 $idgrupos = $datos['grupos_idgrupo'];
 $sq = new Cassandra\SimpleStatement("SELECT * FROM chatU.comentarios");
$result    = $session->execute($sq);
 foreach ($result as $data):?>
  <?php if($idgrupos == $data['grupos_idgrupo']):?>
    <div align = "left"><a href="http://localhost/Bd2_NoSQL2019_1/Cassandra/likes.php?commentary=<?php echo $data['idcomentario']; ?>&usuario=<?php echo $usuario?>"><img src="https://img.icons8.com/metro/15/000000/hearts.png"></a>(Nro me gusta <?php echo $data['likes']; ?>) <?php  echo $data['dscomentario']; ?></div> 
    <?php endif?>
 <?php endforeach?>
  <?php endforeach?>
</div>
  </div>
</div>

<div class="container" >
<div class="panel panel-default" >
<form method="POST">
	<a title="Close" class="close">X</a>
		<span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-envelope"></i></span>
				  <textarea type="text" class="form-control" name="mensaje" placeholder="Mensaje" id="Mensaje" aria-describedby="sizing-addon1"></textarea>
          <br>
				<button class="btn btn-lg btn-primary btn-block btn-signin" id="IngresoLog" type="submit" onclick="">Entrar</button>
        </form>
  </div>
</div>

<div class = "container">
<div id="openModal" class="modalDialog">
	<div>
		<a href="#close" title="Close" class="close">X</a>
    <Table>
    <tr>
    <td>Evento</td>
    <td><h6>    -    </h6></td>
    <td>Fecha</td>
    </tr>
    <?php
     $sql = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios_has_eventos WHERE usuarios_idusuario = $idusuario");
     $resultaEventos    = $session->execute($sql);
     foreach($resultaEventos as $datosEventos):
    ?>
      <?php 
      $ideventos = $datosEventos['eventos_idevento'];
      $sql = new Cassandra\SimpleStatement("SELECT * FROM chatU.eventos WHERE idevento = $ideventos");
     $resultaEvento    = $session->execute($sql);
      
     foreach($resultaEvento as $datosEvento):
     ?>
     <tr>
     <td><?php echo $datosEvento['dsevento'];?></td>
     <td><h6>    -    </h6></td>
     <td><?php echo $datosEvento['fechaevento'];?></td>
     </tr>
    <?php endforeach?>
    <?php endforeach?>
    
    </Table>
		</div>
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
    <div><h6>Usuario: <?php echo $dsusuario?> -  Grupo Principal: <?php
$sql = new Cassandra\SimpleStatement("SELECT * FROM chatU.grupos WHERE idgrupo = $grupoPrincipal");
$resulta    = $session->execute($sql);

foreach($resulta as $datos)
{
  echo $datos['dsgrupo'];
}
?> - Otros Grupos: 
    <?php 
$sql = new Cassandra\SimpleStatement("SELECT * FROM chatU.usuarios_has_grupos WHERE usuarios_idusuario = $idusuario");
$resulta    = $session->execute($sql);

foreach($resulta as $datos)
{
  if($datos['principal'] == 'N')
  {
  $noPrincipal = $datos['grupos_idgrupo'];
  $sql = new Cassandra\SimpleStatement("SELECT * FROM chatU.grupos WHERE idgrupo = $noPrincipal");
  $result    = $session->execute($sql);

  foreach($result as $datos)
{
  echo $datos['dsgrupo'];
  echo " - ";
}
  }
} ?>    
    </h6></div>
</div>
  </div>
</div>
  </footer>
</html>
