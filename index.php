<?php
require_once './bin/conexion/Conexion.php';
require_once './bin/persistencia/Crud.php';
require_once './bin/persistencia/modelos/ModeloGenerico.php';
require_once './bin/persistencia/modelos/Usuarios.php';
require_once './bin/http/ControladorUsuarios.php';


$controladorUsuarios = new ControladorUsuarios();

// $usuario = [
//         "idUsuario" => 6,
//         "fecha_registro" =>"2020-07-08"
// ];

// $respuesta = $controladorUsuarios->actualizarUsuario($usuario);
// echo "<br>";
// echo "<pre>";
// var_dump($respuesta);
// echo "</pre>";


// $respuesta= $controladorUsuarios->eliminarUsuario(6);
// $respuesta= $controladorUsuarios->buscarUserPorId(5);
// echo "<br>";
// echo "<pre>";
// var_dump($respuesta);
// echo "</pre>";

// $respuesta = $controladorUsuarios->listarUsuarios();
// echo "<br>";
// echo "<pre>";
// var_dump($respuesta);
// echo "</pre>";


?>


