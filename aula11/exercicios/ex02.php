<?php
$conn = pg_connect("host=localhost dbname=seubanco user=seuuser password=suasenha");

$busca = $_GET['busca'] ?? '';

$sql = "SELECT * FROM tbpessoa";

if ($busca !== '') {
    $sql .= " WHERE pesnome ILIKE '%$busca%'";
}

$res = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Pessoas</title>
</head>
<body>

<h2>Buscar Pessoa</h2>

<form method="GET" action="">
    <input type="text" name="busca" placeholder="Digite um nome..." value="<?= htmlspecialchars($busca) ?>">
    <button type="submit">Buscar</button>
</form>

<h2>Lista de Pessoas</h2>

<?php
if (pg_num_rows($res) > 0) {
    while ($p = pg_fetch_assoc($res)) {
        echo "ID: {$p['pesid']} - Nome: {$p['pesnome']} - Email: {$p['pesemail']}<br>";
    }
} else {
    echo "Nenhuma pessoa encontrada.";
}
?>

</body>
</html>
