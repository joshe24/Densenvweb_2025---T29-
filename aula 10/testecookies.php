<?php
session_start();

if(!isset($_SESSION['usuario'])) {
    setcookie("user", time() + (8600 * 30), "/" );
    echo "Sessão iniciada e usuário registrado.";
}
else {
    echo "Usuário:" . $_SESSION['usuario'] . " dados da sessão perdidos";
    echo "Senha:" . $_SESSION['senha'] . " <br>";
}
?>
