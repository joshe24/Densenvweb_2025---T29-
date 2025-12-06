<?php

$pessoas = [];

function adicionarPessoa($nome, $idade, $email) {
    if (trim($nome) === '') {
        throw new Exception("Nome inválido.");
    }
    if (!is_numeric($idade) || $idade <= 0) {
        throw new Exception("Idade inválida.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido.");
    }

    return [
        "nome" => $nome,
        "idade" => $idade,
        "email" => $email
    ];
}

try {
    $pessoas[] = adicionarPessoa("Lucas", 22, "lucas@gmail.com");
    $pessoas[] = adicionarPessoa("Ana", 19, "ana@gmail.com");
    $pessoas[] = adicionarPessoa("Carlos", 30, "carlos@hotmail.com");
    $pessoas[] = adicionarPessoa("Beatriz", 25, "bia@gmail.com");
    $pessoas[] = adicionarPessoa("João", 28, "joao@gmail.com");

    if (count($pessoas) < 5) {
        throw new Exception("É necessário cadastrar ao menos 5 pessoas.");
    }

    echo "Lista de Pessoas:\n\n";

    foreach ($pessoas as $i => $p) {
        echo ($i+1) . " - Nome: " . $p["nome"] . 
             ", Idade: " . $p["idade"] . 
             ", Email: " . $p["email"] . "\n";
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

?>
