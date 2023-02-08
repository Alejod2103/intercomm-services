<?php

$destino = "contact@multiservicecall.com";
//Esto es al correo que se enviara el mail

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];  
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

$header = "Enviado desde formulario en INTERCOMM-SERVICES";
$mensajeCompleto = "\n Nombre: " . $nombre . "\n Apellido: ". $apellido . "\n" .  "Email: " . $email . "\n" . "Télefono :" . $telefono . "\n". "Mensaje :" . $mensaje;
mail($destino, $asunto, $mensajeCompleto, $header);
header('Location: index.html');

?>