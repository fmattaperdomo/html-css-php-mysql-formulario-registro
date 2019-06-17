<?php
session_start();
require_once 'funciones.php';

verificaUsuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];   

    $errores = '';

    if(empty($usuario) or empty($password) or empty($password2)){
        $errores .= '<li>Por favor diligenciar todos los campos correctamente</li>';
    }else {
        /*conexionBD();*/
        try {
            $conexion = new PDO('mysql:host=localhost;dbname=fmattaperdomo','root','');
        }catch(PDOException $e){
            echo "ERROR : " . $e->getMessage();
        }


        $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        $statement->execute(array(':usuario' => $usuario));
        $resultado  = $statement->fetch();
        
        
        if ($resultado != false){
            $errores .= '<li>El nombre de usuario ya existe </li>';
        } 
        
        $password = hash('sha512',$password);
        $password2 = hash('sha512',$password2);
        
        if  ($password != $password2){
            $errores .= '<li>Las contraseñas no son iguales</li>';
        }

        if ($errores == ''){
            $statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, password) VALUES (null,:usuario,:password)');
            $statement->execute(array(':usuario' => $usuario, ':password' => $password));
            header('Location: login.php');
        }


    }
}

require 'views/registrate.view.php';


?>