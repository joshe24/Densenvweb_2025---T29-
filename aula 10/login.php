<?php

session_start();

if(!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = ['campo_login'];
    $_SESSION['senha'] = ['campo_senha'];

    echo "Sessão iniciada e usuário registrado.";
}
else {
    echo "Usuário:" . $_SESSION['usuario'] . " já está na sessão";
    echo "Senha:" . $_SESSION['senha'] . " <br>";
}
?>
