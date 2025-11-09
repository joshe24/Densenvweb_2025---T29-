<?php
session_start();
$ADMIN_USER = 'admin';
$ADMIN_PASS = 'senha123'; 

$db_host = 'localhost';
$db_port = '5432';
$db_name = 'avaliacoes_db';
$db_user = 'postgres';
$db_pass = '1234';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    if ($u === $ADMIN_USER && $p === $ADMIN_PASS) {
        $_SESSION['admin_logged'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $login_error = 'Usuário ou senha inválidos.';
    }
}

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head><meta charset="utf-8"><title>Admin - Login</title>
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <link rel="stylesheet" href="styless.css">
    </head>
    <body>
      <main class="container">
        <h1>Painel Administrativo</h1>
        <p class="lead">Faça login para ver as avaliações.</p>
        <?php if (!empty($login_error)) echo '<p class="error">'.htmlspecialchars($login_error).'</p>'; ?>
        <form method="POST" action="admin.php">
          <label>Usuário<br><input type="text" name="username" required></label><br><br>
          <label>Senha<br><input type="password" name="password" required></label><br><br>
          <button class="btn" type="submit">Entrar</button>
        </form>
        <p style="margin-top:18px"><a href="index.php">Voltar ao formulário público</a></p>
      </main>
    </body>
    </html>
    <?php
    exit;
}

$conn_str = "host={$db_host} port={$db_port} dbname={$db_name} user={$db_user} password={$db_pass}";
$conn = pg_connect($conn_str);
if (!$conn) {
    die('Erro ao conectar ao banco de dados.');
}

pg_query($conn, "CREATE TABLE IF NOT EXISTS avaliacoes (
    id SERIAL PRIMARY KEY,
    atendimento INT NOT NULL,
    limpeza INT NOT NULL,
    infraestrutura INT NOT NULL,
    comentario TEXT,
    data_registro TIMESTAMP WITH TIME ZONE DEFAULT now()
)");

$stats_res = pg_query($conn, "SELECT 
    COUNT(*) as total, 
    ROUND(AVG(atendimento)::numeric,2) as avg_atendimento,
    ROUND(AVG(limpeza)::numeric,2) as avg_limpeza,
    ROUND(AVG(infraestrutura)::numeric,2) as avg_infra
FROM avaliacoes");
$stats = pg_fetch_assoc($stats_res);

$list_res = pg_query($conn, "SELECT id, atendimento, limpeza, infraestrutura, comentario, data_registro FROM avaliacoes ORDER BY data_registro DESC LIMIT 200");

?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin - Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="styless.css">
  <style>
    .grid { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:16px; }
    .card { background:#fff; padding:12px; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.04); flex:1 1 200px; }
    table { width:100%; border-collapse:collapse; }
    th,td { padding:8px; border-bottom:1px solid #eee; text-align:left; font-size:14px; }
    .small { font-size:13px; color:#666; }
  </style>
</head>
<body>
  <main class="container">
    <h1>Painel Administrativo</h1>
    <p class="lead">Médias e lista de avaliações</p>
    <p style="text-align:right"><a href="admin.php?logout=1" class="btn" styless="display:inline-block;background:#d33;">Sair</a></p>

    <div class="grid">
      <div class="card">
        <strong>Total de respostas</strong>
        <div style="font-size:22px; margin-top:6px;"><?= htmlspecialchars($stats['total'] ?? '0') ?></div>
      </div>
      <div class="card">
        <strong>Média - Atendimento</strong>
        <div style="font-size:22px; margin-top:6px;"><?= htmlspecialchars($stats['avg_atendimento'] ?? '0.00') ?></div>
      </div>
      <div class="card">
        <strong>Média - Limpeza</strong>
        <div style="font-size:22px; margin-top:6px;"><?= htmlspecialchars($stats['avg_limpeza'] ?? '0.00') ?></div>
      </div>
      <div class="card">
        <strong>Média - Infraestrutura</strong>
        <div style="font-size:22px; margin-top:6px;"><?= htmlspecialchars($stats['avg_infra'] ?? '0.00') ?></div>
      </div>
    </div>

    <section>
      <h2>Respostas recentes</h2>
      <table>
        <thead>
          <tr><th>ID</th><th>At</th><th>Lim</th><th>Inf</th><th>Comentário</th><th>Data</th></tr>
        </thead>
        <tbody>
        <?php while ($row = pg_fetch_assoc($list_res)): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['atendimento']) ?></td>
            <td><?= htmlspecialchars($row['limpeza']) ?></td>
            <td><?= htmlspecialchars($row['infraestrutura']) ?></td>
            <td class="small"><?= htmlspecialchars(mb_strimwidth($row['comentario'], 0, 80, '...')) ?></td>
            <td class="small"><?= htmlspecialchars($row['data_registro']) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
<?php
pg_close($conn);
?>
