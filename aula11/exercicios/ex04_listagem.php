<?php
try {
    $con = pg_connect("host=localhost dbname=teste user=postgres password=123");

    if (!$con) {
        throw new Exception("Erro ao conectar no banco.");
    }

    $busca = "";
    $sql = "SELECT * FROM TBPESSOA";

    // Se veio busca na querystring
    if (isset($_GET['nome'])) {
        $busca = filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_STRING);

        if ($busca !== "") {
            $sql .= " WHERE PESNOME ILIKE $1";
            $param = array("%$busca%");
            $query = pg_query_params($con, $sql, $param);
        } else {
            $query = pg_query($con, $sql);
        }
    } else {
        $query = pg_query($con, $sql);
    }

    if (!$query) {
        throw new Exception("Erro ao consultar dados.");
    }

    while ($row = pg_fetch_assoc($query)) {
        echo "Código: {$row['pescodigo']} - ";
        echo "Nome: {$row['pesnome']} {$row['pessobrenome']} - ";
        echo "Email: {$row['pesemail']} - ";
        echo "Cidade: {$row['pescidade']} - Estado: {$row['pesestado']}<br>";
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
