<?php
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método inválido.");
    }

    $con = pg_connect("host=localhost dbname=teste user=postgres password=123");

    if (!$con) {
        throw new Exception("Erro ao conectar no banco.");
    }

    // Sanitização
    $nome       = filter_input(INPUT_POST, 'campo_primeiro_nome', FILTER_SANITIZE_STRING);
    $sobrenome  = filter_input(INPUT_POST, 'campo_sobrenome', FILTER_SANITIZE_STRING);
    $email      = filter_input(INPUT_POST, 'campo_email', FILTER_SANITIZE_EMAIL);
    $senha      = filter_input(INPUT_POST, 'campo_password', FILTER_SANITIZE_STRING);
    $cidade     = filter_input(INPUT_POST, 'campo_cidade', FILTER_SANITIZE_STRING);
    $estado     = filter_input(INPUT_POST, 'campo_estado', FILTER_SANITIZE_STRING);

    // Validação
    if (empty($nome)) {
        throw new Exception("Nome é obrigatório.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido.");
    }

    if (strlen($estado) !== 2) {
        throw new Exception("Estado deve ter 2 caracteres.");
    }

    $sql = "
        INSERT INTO TBPESSOA
        (PESNOME, PESSOBRENOME, PESEMAIL, PESPASSWORD, PESCIDADE, PESESTADO)
        VALUES ($1, $2, $3, $4, $5, $6)
    ";

    $dados = array($nome, $sobrenome, $email, $senha, $cidade, $estado);

    $result = pg_query_params($con, $sql, $dados);

    if (!$result) {
        throw new Exception("Erro ao inserir dados.");
    }

    echo "Cadastro realizado com sucesso!";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
