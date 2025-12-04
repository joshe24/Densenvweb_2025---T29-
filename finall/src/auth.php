<?php
require_once "db.php";
require_once "funcoes.php";

session_start();

function login($login, $senha) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function logout() {
    session_start();
    session_destroy();
    header("Location: ../public/login.php");
    exit;
}
