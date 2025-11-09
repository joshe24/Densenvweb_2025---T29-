<?php
header('Content-Type: text/html; charset=utf-8');

$db_host = 'localhost';
$db_port = '5432';
$db_name = 'avaliacoes_db';
$db_user = 'postgres';
$db_pass = '1234';

$expected = ['atendimento', 'limpeza', 'infraestrutura'];

$valid = true;
$values = [];
foreach ($expected as $k) {
    if (!isset($_POST[$k])) {
        $valid = false;
        break;
    }
    $v = intval($_POST[$k]);
    if ($v < 0 || $v > 10) { $valid = false; break; }
    $values[$k] = $v;
}
$comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : null;

if (!$valid) {
    http_response_code(400);
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Erro</title>';
    echo '<link rel="stylesheet" href="css/style.css"></head><body><main class="container">';
    echo '<h1>Erro ao enviar avaliação</h1>';
    echo '<p>Por favor, preencha todas as perguntas antes de enviar.</p>';
    echo '<p><a href="index.php" class="btn">Voltar</a></p>';
    echo '</main></body></html>';
    exit;
}

$conn_string = "host={$db_host} port={$db_port} dbname={$db_name} user={$db_user} password={$db_pass}";
$conn = pg_connect($conn_string);
if (!$conn) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Erro</title>';
    echo '<link rel="stylesheet" href="css/style.css"></head><body><main class="container">';
    echo '<h1>Erro de servidor</h1>';
    echo '<p>Não foi possível conectar ao banco de dados.</p>';
    echo '<p><a href="index.php" class="btn">Voltar</a></p>';
    echo '</main></body></html>';
    exit;
}

$create_sql = <<<SQL
CREATE TABLE IF NOT EXISTS avaliacoes (
    id SERIAL PRIMARY KEY,
    atendimento INT NOT NULL,
    limpeza INT NOT NULL,
    infraestrutura INT NOT NULL,
    comentario TEXT,
    data_registro TIMESTAMP WITH TIME ZONE DEFAULT now()
);
SQL;
pg_query($conn, $create_sql);

$insert_sql = "INSERT INTO avaliacoes (atendimento, limpeza, infraestrutura, comentario) VALUES ($1, $2, $3, $4)";
$params = [
    $values['atendimento'],
    $values['limpeza'],
    $values['infraestrutura'],
    $comentario
];
$res = pg_query_params($conn, $insert_sql, $params);

pg_close($conn);

if (!$res) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><title>Erro</title>';
    echo '<link rel="stylesheet" href="css/style.css"></head><body><main class="container">';
    echo '<h1>Erro ao salvar avaliação</h1>';
    echo '<p>Por favor, tente novamente mais tarde.</p>';
    echo '<p><a href="index.php" class="btn">Voltar</a></p>';
    echo '</main></body></html>';
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Obrigado</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="styless.css">
</head>
<body>
  <main class="container thankyou">
    <h1>Obrigado!</h1>
    <p>O Estabelecimento agradece sua resposta e ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços.</p>
    <p><a href="index.php" class="btn">Enviar outra avaliação</a></p>
  </main>
</body>
</html>
