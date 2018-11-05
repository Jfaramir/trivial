<?php

include ('misFunciones.php');

function limpiaPalabra($palabra){
    //filtro muy básico para evitar la inyeccion SQL
    $palabra = trim($palabra, "'");
    $palabra = trim($palabra, " ");
    $palabra = trim($palabra, "-");
    $palabra = trim($palabra, "`");
    $palabra = trim($palabra, '"');
    return $palabra;
}

$mysqli = conectaBBDD();

 $cajaNombre = limpiaPalabra($_POST['cajaNombre']);
 
 $cajaPassword = limpiaPalabra($_POST['cajaPassword']);

$passwordEncriptada =  password_hash($cajaPassword, PASSWORD_BCRYPT);



 $resultadoQuery = $mysqli -> query("INSERT INTO usuarios (`idUsuario`, `nombreUsuario`, `userPassword`)  VALUES (NULL, '$cajaNombre', '$passwordEncriptada') ");
 

 
 $numUsuarios = $mysqli -> affected_rows;

if ($numUsuarios > 0){
    echo ('<div class="alert alert-success" role="alert"> SE HA AÑADIDO CORRECTAMENTE AL USUARIO '.$cajaNombre.' </div>');
}
else{
     echo ('<div class="alert alert-danger" role="alert"> NO SE HA PODIDO AÑADIR AL USUARIO '.$cajaNombre.' </div>');
}

 
