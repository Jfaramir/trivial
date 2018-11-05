
<?php

session_start();  //inicia la sesión del navegador en el servidor PHP
                  //o la continúa si ya estuviera iniciada

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




 $resultadoQuery = $mysqli -> query("SELECT * FROM usuarios WHERE nombreUsuario='$cajaNombre' ");
 $numUsuarios = $resultadoQuery -> num_rows;
 if ($numUsuarios > 0){
     $r = $resultadoQuery -> fetch_array();
     if (password_verify($cajaPassword, $r['userPassword'])){
        //en la variable de sesión "nombreUsuario" guardo el nombre de usuario
        $_SESSION['nombreUsuario'] = $cajaNombre;
        //en la variable de sesión idUsuario guardo el id de usuario leido de la BBDD
        $_SESSION['idUsuario'] = $r['idUsuario'];
        //muestro la pantalla de la aplicación
        require 'app.php';
    }
    else {
        //muestro una pantalla de error porque la contraseña está mal
        require 'error.php';
    }
 }
    else {
        //muestro una pantalla de error porque el nombre de usuario está mal
        require 'error.php';
    }