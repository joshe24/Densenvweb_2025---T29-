<?php
sessiion_start();

if(!isset($_COOKIE["usuario"])) || (!isset($_COOKIE["inicio_sessao"]));
echo 'alert("Cookies de sessão expirados. Favor logar novamente.")';

if(!isset($_COOKIE["usuario"]))
$_SESSION['usuario'] = $_POST
$_SESSION['senha'] = $_POST
$_SESSION['inicio_sessao'] = $_POST

setcookie("usuario", "nome_user" , time() + (86400 * 30), "/");
echo "<html>";
echo "<body>";

if(!isset($_COOKIE["usuario"])) {
echo "O Cookie 'usuario' não foi definido!";
} else {
echo "Cookie 'usuario' definido!<br>";
echo "O valor é: " . $_COOKIE["usuario"];
}
echo "</body>";
echo "</html>";
?>