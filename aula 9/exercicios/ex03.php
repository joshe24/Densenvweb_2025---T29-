<?php

function calcularValorFinal($valor, $desconto) {
    if (!is_numeric($valor) || !is_numeric($desconto)) {
        throw new Exception("Os parâmetros devem ser numéricos.");
    }

    if ($valor < 0 || $desconto < 0) {
        throw new Exception("Valor e desconto não podem ser negativos.");
    }

    return $valor - $desconto;
}

try {
    if (!isset($_REQUEST['valor']) || !isset($_REQUEST['desconto'])) {
        throw new Exception("Parâmetros 'valor' e 'desconto' são obrigatórios.");
    }

    $valor = $_REQUEST['valor'];
    $desconto = $_REQUEST['desconto'];

    $valorFinal = calcularValorFinal($valor, $desconto);

    echo "Valor final: " . number_format($valorFinal, 2, ',', '.');

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}

?>
