<?php

$arquivo = "pessoas.json";

if (!isset($_POST['nome']) || !isset($_POST['idade']) || !isset($_POST['email'])) {
    die("Dados incompletos recebidos.");
}

$nome = trim($_POST['nome']);
$idade = intval($_POST['idade']);
$email = trim($_POST['email']);

if ($nome === "" || $idade <= 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Dados inválidos.");
}

if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([]));
}

$conteudo = file_get_contents($arquivo);
$pessoas = json_decode($conteudo, true);

$pessoas[] = [
    "nome" => $nome,
    "idade" => $idade,
    "email" => $email
];

if (count($pessoas) > 10) {
    die("Já existem 10 pessoas gravadas no arquivo.");
}

file_put_contents($arquivo, json_encode($pessoas, JSON_PRETTY_PRINT));

echo "Pessoa salva com sucesso. Total: " . count($pessoas);

?>
