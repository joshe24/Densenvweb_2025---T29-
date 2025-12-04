<?php
$config = require __DIR__ . '/../config.php';

try {
    $pdo = new PDO(
        "pgsql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco: " . $e->getMessage());
}
