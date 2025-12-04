<?php
require_once "db.php";

function listarPerguntas() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM perguntas ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function adicionarPergunta($texto) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO perguntas (texto, status) VALUES (:texto, 'ativa')");
    $stmt->execute(['texto' => $texto]);
}

function atualizarPergunta($id, $texto, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE perguntas SET texto = :texto, status = :status WHERE id = :id");
    $stmt->execute(['id'=>$id, 'texto'=>$texto, 'status'=>$status]);
}

function removerPergunta($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM perguntas WHERE id = :id");
    $stmt->execute(['id'=>$id]);
}
