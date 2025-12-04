<?php
require_once "../src/auth.php";
require_login();
require_once "../src/perguntas.php";

$perguntas = listarPerguntas();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Painel Administrativo</h2>

<h3>Perguntas Cadastradas</h3>
<table>
<tr>
    <th>ID</th>
    <th>Pergunta</th>
    <th>Status</th>
</tr>

<?php foreach ($perguntas as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['texto'] ?></td>
    <td><?= $p['status'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
