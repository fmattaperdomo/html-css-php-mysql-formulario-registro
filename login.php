<?php
session_start();
require_once 'funciones.php';
$errores = '';

verificaUsuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
    $password =  $_POST['password'];
    $password = hash('sha512',$password);

    /*conexionBD();*/
    try {
        $conexion = new PDO('mysql:host=localhost;dbname=fmattaperdomo','root','');

    }catch(PDOException $e){
        echo "ERROR : " . $e->getMessage();
    }


    $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password LIMIT 1');
    $statement->execute(array(':usuario' => $usuario, ':password' => $password));
    $resultado = $statement->fetch();
    if ($resultado != false){
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
    }else {
        $errores .= '<li> Datos incorrectos </li>';
    }

}

require 'views/login.view.php';



?>