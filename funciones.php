<?php

$conexion='';

require_once 'funciones.php';

function verificaUsuario() {
    if (isset($_SESSION['usuario'])){
        header('Location: index.php');
    }
}

?>