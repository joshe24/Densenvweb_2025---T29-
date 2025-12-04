<?php
require_once "db.php";
require_once "funcoes.php";

$feedback = !empty($_POST['feedback']) ? sanitize($_POST['feedback']) : null;

foreach ($_POST as $key => $value) {
    if (strpos($key, 'resposta_') === 0) {

        $id_pergunta = str_replace("resposta_", "", $key);
        $resposta = (int)$value;

        $stmt = $pdo->prepare("
            INSERT INTO avaliacoes (id_setor, id_pergunta, id_dispositivo, resposta, feedback)
            VALUES (1, :id_pergunta, 1, :resposta, :feedback)
        ");

        $stmt->execute([
            'id_pergunta' => $id_pergunta,
            'resposta' => $resposta,
            'feedback' => $feedback
        ]);
    }
}

header("Location: ../public/obrigado.php");
exit;
